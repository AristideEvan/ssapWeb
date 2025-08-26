<?php

namespace App\Http\Controllers\Ajax;

use Exception;
use App\Models\Menu;
use App\Models\Outil;
use App\Models\Theme;
use App\Models\Localite;
use App\Models\Pratique;
use App\Models\TypeLocalite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AjaxController extends Controller
{
    public function setVisibleMenu($idMenu)
    {
        $menu = Menu::find($idMenu);
        if ($menu->visible) {
            $menu->visible = false;
        } else {
            $menu->visible = true;
        }
        $menu->save();
    }

    public function getLocaliteData(Request $request)
    {
        // Récupérer l'ID passé par la requête AJAX
        $localiteId = $request->get('id');

        // Si l'ID est présent, récupérer les données des localités enfants
        if ($localiteId) {
            // Récupérer les localités dont le parent_id correspond à localiteId
            $localites = Localite::where('parent_id', $localiteId)->get(); // Assurez-vous que 'parent_id' est un champ valide dans la table Localite

            if ($localites->isEmpty()) {
                // Si aucune localité n'est trouvée
                return response()->json(
                    [
                        'success' => false,
                        'message' => 'Aucune localité trouvée pour ce parent.'
                    ]
                );
            } else {
                // Retourner les localités sous forme de tableau
                $localiteData = $localites->map(
                    function ($localite) {
                        return [
                            'id' => $localite->localite_id,
                            'nom' => $localite->nomLocalite
                        ];
                    }
                );

                return response()->json(
                    [
                        'success' => true,
                        'data' => $localiteData
                    ]
                );
            }
        } else {
            // Si l'ID n'est pas passé dans la requête
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Aucun ID fourni.'
                ]
            );
        }
    }

    public function getZoneForm($zone_type, $localite_id = null)
    {
        if (isset($localite_id)) {
            $localite_id = Localite::findOrFail($localite_id)->localite_id;
            $localites = DB::select('SELECT "localite_id", "nomLocalite" FROM "listeLocalite" WHERE "p0" = ?', [$localite_id]);
            $form = $this->generateLocalitesOptions($localites);
        } else {
            $form = $this->generateNewZoneForm($zone_type);
        }
        return response()->json(['success' => true, 'html' => $form]);
    }

    // Méthode pour générer les options de localités pour un formulaire
    public function generateLocalitesOptions($localites)
    {
        $html = '<option value="">' . __("Selectionner une localité") . '</option>';
        foreach ($localites as $localite) {
            $html .= '<option value="' . $localite->localite_id . '">' . $localite->nomLocalite . '</option>';
        }
        return $html;
    }

    public function generateNewZoneForm($zone_type = null)
    {
        $uniqueIndex = (string) now()->timestamp;
        $pays_id = TypeLocalite::where('typeLocaliteLibelle', 'PAYS')->first()->typeLocalite_id;
        $pays = Localite::where('typeLocalite_id', $pays_id)->get();
        $template = $zone_type == 1 ? 'pratique.partials.zone' : 'pratique.partials.zonep';
        $vue = view(
            $template,
            [
                'pays' => $pays,
                'uniqueIndex' => $uniqueIndex
            ]
        );
        return response()->json(['success' => true, 'html' => $vue->render()]);
        //return view($template)->with([ 'pays' => $pays, 'uniqueIndex' => $uniqueIndex,'controller' => $this ]);

    }
    public function updatePratiques(Request $request, $rub, $srub)
    {
        try {
            $request->validate([
                'action' => 'in:vedette,publique',
                'unselected_values' => 'array|max:5',
                'unselected_values.*' => 'integer|exists:pratiques,pratique_id',
                'new_values' => 'array|max:5',
                'returnHtml' => 'nullable|boolean',
                'new_values.*' => 'integer|exists:pratiques,pratique_id',
            ]);

            $actionColumn = $request->action === 'vedette' ? 'vedette' : 'publique';

            if ($request->filled('unselected_values')) {
                Pratique::whereIn('pratique_id', $request->input('unselected_values'))
                    ->update([$actionColumn => false]);
            }

            if ($request->filled('new_values')) {
                Pratique::whereIn('pratique_id', $request->input('new_values'))
                    ->update([$actionColumn => true]);
            }

            refreshStatisques();

            if ($request->filled('returnHtml') && $request->returnHtml === true) {
                $pratiques = $this->filterPratiques($request);
                $vue = view('pratique.partials.table', [
                    'pays' => getPays(),
                    'pratiques' => $pratiques,
                    'rub' => $rub,
                    'srub' => $srub,
                    'controler' => $this,
                ])->render();
                return response()->json([
                    'success' => true,
                    'html' => $vue,
                ]);
            }

            $updated = array_merge(
                $request->input('unselected_values', []),
                $request->input('new_values', [])
            );

            if (!empty($updated)) {
                $pratique = Pratique::find($updated[0]);
                return response()->json([
                    'success' => true,
                    'publique' => $pratique->publique,
                    'message' => "Les pratiques ont été mises à jour pour l'action '{$request->action}'",
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Aucune pratique mise à jour.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Une erreur est survenue.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    public function getAllPratiques()
    {
        try {
            $pratiques = Pratique::all();

            return response()->json([
                'success' => true,
                'pratiques' => $pratiques,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la récupération des pratiques.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // Méthode pour obtenir les localités avec les pratiques associées
    public static function getLocaliteWithPratiques($localite_id)
    {
        try {
            $localite = Localite::with('pratiques.zonesActuelles')->findOrFail($localite_id);
            return response()->json(
                [
                    'success' => true,
                    'localite' => $localite
                ]
            );
        } catch (\Exception $e) {
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Pratique introuvable ou erreur.',
                    'error' => $e->getMessage(),
                ],
                404
            );
        }
    }

    // Méthode pour obtenir une pratique avec les zones associées
    public static function getPratiqueWithZones($pratique_id)
    {
        try {
            $pratique = Pratique::with('zonesActuelles')->findOrFail($pratique_id);
            return response()->json(
                [
                    'success' => true,
                    'pratique' => $pratique
                ]
            );
        } catch (\Exception $e) {
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Pratique introuvable ou erreur.',
                    'error' => $e->getMessage(),
                ],
                404
            );
        }
    }


    public function getFilteredPratiques(Request $request, $rub, $srub)
    {
        $request->validate(
            [
                'pays' => 'nullable',
                'publique' => 'nullable|string|in:true,false,all',
            ]
        );

        $paysList = getPays();
        $pratiques = $this->filterPratiques($request);
        $vue = view(
            'pratique.partials.table',
            [
                'pays' => $paysList,
                'pratiques' => $pratiques,
                'rub' => $rub,
                'srub' => $srub,
                'controler' => $this,
            ]
        );

        return response()->json(
            [
                'success' => true,
                'html' => $vue->render()
            ]
        );
    }

    protected function filterPratiques($request)
    {
        try {
            $pays = $request->input('pays') ?? 'all';
            $publique = $request->input('publique') ?? 'all';

            $params = [];

            if ($pays !== 'all') {
                $sql = '
            SELECT DISTINCT p.*
            FROM pratiques p
            JOIN pratiquezoneapplis z ON p.pratique_id = z.pratique_id
            JOIN (
                SELECT localite_id, "nomLocalite"
                FROM "listeLocalite"
                WHERE "p0" = ?
            ) l ON l.localite_id = z.localite_id
            WHERE p.deleted_at IS NULL
            ';
                $params[] = $pays;
            } else {
                $sql = '
            SELECT *
            FROM pratiques p
            WHERE p.deleted_at IS NULL
            ';
            }

            if ($publique !== 'all') {
                $sql .= ' AND p.publique = ?';
                $params[] = $publique === 'true' ? true : false;
            }

            $user = Auth::user();
            if (!isAdmin($user)) {
                $sql .= ' AND p.user_id = ?';
                $params[] = $user->id;
            }

            $sql .= ' ORDER BY p.created_at DESC';

            $pratiques = DB::select($sql, $params);

            return $pratiques;
        } catch (Exception $e) {
            return $e;
            throw $e;
        }
    }




    public function getFilteredOutils(Request $request)
    {
        Validator::make($request->all(), [
            'typeoutil_id' => 'nullable|array',
            'typeoutil_id.*' => 'required|integer',
        ])->validate();


        $message = "";
        if (empty($request->typeoutil_id)) {
            $outils = Outil::where('publique', true)->get();
        } else {
            $outils = Outil::whereIn('typeoutil_id', $request->typeoutil_id)->where('publique', true)->get();
        }
        if (empty($outils)) {
            $message = "Aucun outil trouvé";
        }
        $vue = view('outil.partials.outil', ['outils' => $outils]);

        return response()->json(
            [
                'success' => true,
                'html' => $vue->render(),
                'message' => $message
            ]
        );
    }

    public function getThemeDomains(Request $request)
    {
        $request->validate([
            'theme_ids' => 'required|array',
            'theme_ids.*' => 'required|integer',
            'pratique_id' => 'nullable|integer'
        ]);

        $html = '';
        $domainIds = [];

        if ($request->pratique_id) {
            $pratique = Pratique::with('domaines')->find($request->pratique_id);
            if ($pratique) {
                $selectedDomaines = old('domaine', $pratique->domaines->pluck('domaine_id')->toArray() ?? []);

                foreach ($pratique->domaines as $domain) {
                    $selected = in_array($domain->domaine_id, $selectedDomaines) ? 'selected' : '';
                    $html .= '<option value="' . $domain->domaine_id . '" ' . $selected . '>' . $domain->domaineLibelle . '</option>';
                    $domainIds[] = $domain->domaine_id;
                }
            }
        }

        $themes = Theme::whereIn('theme_id', $request->theme_ids)->with('domaines')->get();
        $domains = $themes->pluck('domaines')->flatten();

        foreach ($domains as $domain) {
            if (!in_array($domain->domaine_id, $domainIds)) {
                $html .= '<option value="' . $domain->domaine_id . '">' . $domain->domaineLibelle . '</option>';
                $domainIds[] = $domain->domaine_id;
            }
        }

        // Retour de la réponse en JSON
        return response()->json([
            'success' => true,
            'html' => $html,
        ]);
    }
}
