<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Sol;
use App\Models\Image;
use App\Models\Climat;
use App\Models\Pilier;
use App\Models\Profil;
use App\Models\Domaine;
use App\Models\Localite;
use App\Models\Pratique;
use App\Models\TypeChoc;
use App\Models\Partenaire;
use App\Models\TypeReponse;
use App\Models\Beneficiaire;
use App\Models\TypeLocalite;
use Illuminate\Http\Request;
use App\Models\SecteurActivite;
use App\Models\Theme;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PratiqueController extends Controller
{
    protected $rules = [];
    protected $infoRules = [];
    protected $zoneRules = [];
    protected $fileRules = [];
    protected $acteurRules = [];
    private $msgerror = 'Impossible de supprimer cet élément car il est utilisé!';
    private $operation = 'Opération effectuée avec succès';
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->rules = [
            'pratiqueLibelle' => ['required', 'string', 'max:255'],
            'description_env_humain' => ['required', 'string'],
            'objectif' => ['required', 'string'],
            'description' => ['required', 'string'],
            'periode' => ['required', 'string'],
            'conseil' => ['nullable', 'string'], // removed
            'avantage' => ['required', 'string'], // resultats
            'contrainte' => ['required', 'string'],
            'mesure' => ['required', 'string'],
            'cout' => ['required', 'numeric', 'min:100000'],
            'recommandation' => ['required', 'string'],
            'defis' => ['nullable', 'string'], // removed
            'theme' => ['required', 'array', 'min:1'],
            'theme.*' => ['required', 'integer', 'exists:themes,theme_id', 'distinct'],

        ];
        $this->infoRules = [
            'domaine' => ['nullable', 'array', 'min:1'],
            'domaine.*' => ['integer', 'exists:domaines,domaine_id'],
            'pilier' => ['nullable', 'array', 'min:1'],
            'pilier.*' => ['integer', 'exists:piliers,pilier_id', 'distinct'],
            'secteurActivite' => ['nullable', 'array', 'min:1'],
            'secteurActivite.*' => ['integer', 'exists:secteur_activites,secteurActivite_id', 'distinct'],
            'typeChoc' => ['nullable', 'array', 'min:1'],
            'typeChoc.*' => ['integer', 'exists:type_chocs,typeChoc_id', 'distinct'],
            'typeReponse' => ['nullable', 'array', 'min:1'],
            'typeReponse.*' => ['required', 'exists:type_reponses,typeReponse_id', 'distinct'],
            'climat' => ['required', 'array', 'min:1'],
            'climat.*' => ['integer', 'exists:climats,climat_id', 'distinct'],
            'sol' => ['required', 'array', 'min:1'],
            'sol.*' => ['integer', 'exists:sols,sol_id', 'distinct'],
        ];
        $this->zoneRules = [
            'zones' => ['required', 'array'],
            'zones.*.localite' => ['required', 'integer', 'exists:localites,localite_id'],
            'zones.*.latitude' => ['nullable', 'numeric', 'required_with:zones.*.longitude'],
            'zones.*.longitude' => ['nullable', 'numeric', 'required_with:zones.*.latitude'],
            'zonesp' => ['array', 'nullable'],
            'zonesp.*.localite' => ['integer', 'exists:localites,localite_id'],
        ];
        $this->fileRules = [
            'vedette_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'images' => ['nullable', 'array'],
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'documents' => ['required', 'array'],
            'documents.*' => 'file|mimes:pdf,xls,xlsx,doc,docx,ppt,pptx,odt,xml,gpx,odp,ods,jpeg,png,jpg,gif,svg,txt|max:2048',
        ];
        $this->acteurRules = [
            'beneficiaire' => ['nullable', 'array'],
            'beneficiaire.*' => ['integer', 'exists:beneficiaires,beneficiaire_id', 'distinct'],
            'partenaire' => ['nullable', 'array'],
            'partenaire.*' => ['integer', 'exists:partenaires,partenaire_id', 'distinct'],
        ] ;
    }
    /**
     * Display a listing of the resource.
     */
    public function index($rub, $srub)
    {
        $user = auth()->user();
        $pays = getPays();
        $pratiques = [];
        if (!isAdmin($user)) {
            $pratiques = Pratique::where('user_id', $user->id)->orderby('created_at', 'desc')->get();
        } else {
            $pratiques = Pratique::orderby('created_at', 'desc')->get();
        }
        return view('pratique.index')->with(['pratiques' => $pratiques, 'pays' => $pays, 'controler' => $this, "rub" => $rub, "srub" => $srub]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($rub, $srub)
    {
        $pays = getPays();
        if (empty($pays)) {
            return back()->with('error', 'Veuillez configurer les localités');
        }
        $data = $this->getFormData();
        return view('pratique.create', $data)->with(
            [
                'pays' => $pays,
                'controler' => $this,
                "rub" => $rub,
                "srub" => $srub,
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = array_merge($this->rules, $this->infoRules, $this->zoneRules, $this->fileRules);
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $zoneActuellesForm = $this->getOnValidationFailsZonesForm($request);
            $zonePotentiellesForm = $this->getOnValidationFailsZonesForm($request, 'potentielles');
            return redirect()->back()->withErrors($validator)->withInput()->with(['error' =>  __('Données incorrectes.'), 'zoneActuellesForm' => $zoneActuellesForm, 'zonePotentiellesForm' => $zonePotentiellesForm]);
        }

        try {
            DB::transaction(
                function () use ($request) {
                    $pratique = Pratique::create($this->setPratiqueData($request));
                    $pratique->themes()->attach($request->input('theme'));
                    $pratique->domaines()->attach($request->input('domaine'));
                    $pratique->reponses()->attach($request->input('typeReponse'));
                    $pratique->piliers()->attach($request->input('pilier'));
                    $pratique->secteurs()->attach($request->input('secteurActivite'));
                    $pratique->typesChocs()->attach($request->input('typeChoc'));
                    $zonesp = $request->input('zonesp');
                    if (!empty($zonesp)) {
                        $zones = array_column($zonesp, 'localite');
                        $pratique->zonesPotentielles()->attach($zones);
                    }
                    $pratique->partenaires()->attach($request->input('partenaire'));
                    $pratique->beneficiaires()->attach($request->input('beneficiaire'));
                    $pratique->climats()->attach($request->input('climat'));
                    $pratique->sols()->attach($request->input('sol'));

                    foreach ($request->input('zones') as $zone) {
                        $zone_id = $zone['localite'];
                        $geom = null;
                        if (!empty($zone['latitude']) && !empty($zone['longitude'])) {
                            $geom = $this->geomConvert($zone['longitude'], $zone['latitude']);
                        } else {
                            $geom = Localite::find($zone_id)->centroid;
                        }
                        $pratique->zonesActuelles()->attach(
                            $zone_id,
                            [
                                'longitude' => $zone['longitude'] ?? null,
                                'latitude' => $zone['latitude'] ?? null,
                                'geom' => $geom
                            ]
                        );
                    }

                    // Appeler saveFiles à l'intérieur de la transaction
                    $this->saveFiles($request, $pratique);
                }
            );
            refreshStatisques();
            return redirect('pratique/' . $request->input('rub') . '/' . $request->input('srub'))
                ->with(['success' => $this->operation]);
        } catch (Exception $e) {
            if ($e->getCode() === '23000') {
                return back()->withErrors(['error' => 'Une pratique avec cet ID et cette localité existe déjà.']);
            }
            Log::error('Erreur lors de l\'enregistrement : ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Echec de l\'enregistrement veuillez réessayer.');
        }
    }


    /**
     * Display the specified resource.
     */
    public function show($id, $rub, $srub)
    {
        $pratique = Pratique::findOrFail($id);
        $data = $this->getEditData($pratique);
        return view('pratique.show', $data)->with(['controler' => $this, "rub" => $rub, "srub" => $srub]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id, $rub, $srub)
    {
        $pays = getPays();
        $pratique = Pratique::findOrFail($id);
        $data = $this->getEditData($pratique);
        return view('pratique.edit', $data)->with(['controler' => $this, "rub" => $rub, "srub" => $srub, 'pays' => $pays]);
    }

    public function editSection($id, $section, $rub, $srub)
    {
        $pratique = Pratique::findOrFail($id);
        $data = $this->getEditData($pratique);
        return view('pratique.section-edit', $data)->with(['controler' => $this, "rub" => $rub, "srub" => $srub, 'section' => $section]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $user = auth()->user();
        $pratique = Pratique::findOrFail($id);
        if (!$this->isOwner($user, $pratique)) {
            return back();
        }
        $request = $this->valideRemovedFiles($request);
        $this->rules = array_merge($this->rules, $this->infoRules, $this->zoneRules);
        $validator = Validator::make($request->all(), $this->rules);
        if ($validator->fails()) {
            $zoneActuellesForm = $this->getOnValidationFailsZonesForm($request);
            $zonePotentiellesForm = $this->getOnValidationFailsZonesForm($request, 'potentielles');
            return back()->withErrors($validator)->withInput()->with(['error', __('Données incorrectes.'), 'zoneActuellesForm' => $zoneActuellesForm, 'zonePotentiellesForm' => $zonePotentiellesForm]);
        }
        try {
            DB::transaction(
                function () use ($request, $pratique) {
                    $this->updateGeneral($request, $pratique);
                    $this->updateInfo($request, $pratique);
                    $this->updateZones($request, $pratique);
                    $this->updateActeurs($request, $pratique);
                    $this->updateFiles($request, $pratique);
                }
            );
            return redirect('pratique/' . $request->input('rub') . '/' . $request->input('srub'))->with('success', __('Pratique modifiée avec succès'));
        } catch (Exception $e) {
            return back()->withInput()->with('error', __('La mise à jour a échoué, veuillez réessayer.'));
        }
    }

    public function updateSection(Request $request, $id, $section, $rub, $srub)
    {
        $user = auth()->user();
        $pratique = Pratique::findOrFail($id);
        if (!$this->isOwner($user, $pratique)) {
            return back();
        }
        try {
            DB::transaction(
                function () use ($request, $pratique, $section) {
                    switch ($section) {
                        case 1:
                            $request->validate($this->rules);
                            $this->updateGeneral($request, $pratique);
                            break;
                        case 2:
                            $request->validate($this->infoRules);
                            $this->updateInfo($request, $pratique);
                            break;
                        case 3:
                            $request->validate($this->zoneRules);
                            $this->updateZones($request, $pratique);
                            break;
                        case 4:
                            $request->validate($this->fileRules);
                            $request = $this->valideRemovedFiles($request);
                            $request->validate($this->fileRules);
                            $this->updateFiles($request, $pratique);
                            break;
                        case 5:
                            $request->validate($this->acteurRules);
                            $this->updateActeurs($request, $pratique);
                            break;
                        default:
                            return back();
                    }
                }
            );
            $data = $this->getEditData($pratique);
            $data['section_id'] = 'section-' . $section;
            return redirect('pratique/' . $id . '/show/' . $rub . '/' . $srub)
                ->with([
                    'success' => __('Pratique modifiée avec succès'),
                    'data' => $data,
                    'controler' => $this,
                    'rub' => $rub,
                    'srub' => $srub
                ]);
        } catch (Exception $e) {
            return back()->withInput()->with('error', __('La mise à jour a échoué, veuillez réessayer.'));
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $pratique = Pratique::with(['images', 'documents'])->findOrFail($id);

            // Delete images if any
            if ($pratique->images->isNotEmpty()) {
                Storage::delete($pratique->images->pluck('path')->toArray());
                $pratique->images()->delete();
            }

            // Delete vedette image if path exists
            if (!empty($pratique->vedette_path)) {
                Storage::delete($pratique->vedette_path);
            }

            // Delete documents if any
            if ($pratique->documents->isNotEmpty()) {
                Storage::delete($pratique->documents->pluck('path')->toArray());
                $pratique->documents()->delete();
            }

            // Delete the practice record
            $pratique->delete();

            refreshStatisques();
            return back()->with('success', 'Pratique supprimée avec succès.');
        } catch (\Exception $e) {
            Log::error('Erreur lors de la suppression de la pratique : ' . $e->getMessage());
            return back()->with('error', 'Une erreur est survenue : ' . $e->getMessage());
        }
    }



    protected function updateGeneral(Request $request, $pratique)
    {
        try {
            $pratique->update($this->setPratiqueData($request));
            $pratique->themes()->sync($request->input('theme'));
            return true;
        } catch (Exception $e) {
            Log::error('Erreur lors de la mise à jour des infos générales : ' . $e->getMessage());
            throw $e;
        }
    }

    protected function updateInfo(Request $request, $pratique)
    {
        try {
            $pratique->domaines()->sync($request->input('domaine'));
            $pratique->reponses()->sync($request->input('typeReponse'));
            $pratique->piliers()->sync($request->input('pilier'));
            $pratique->secteurs()->sync($request->input('secteurActivite'));
            $pratique->typesChocs()->sync($request->input('typeChoc'));
            $pratique->climats()->sync($request->input('climat'));
            $pratique->themes()->sync($request->input('theme'));
            $pratique->sols()->sync($request->input('sol'));
            return true;
        } catch (Exception $e) {
            Log::error('Erreur lors de la mise à jour des infos supplémentaires : ' . $e->getMessage());
            throw $e;
        }
    }

    protected function updateZones(Request $request, $pratique)
    {
        try {
            $zonesp = $request->input('zonesp');
            if (!empty($zonesp)) {
                $zones = array_column($zonesp, 'localite');
                $pratique->zonesPotentielles()->sync($zones);
            }
            $pivotData = [];
            foreach ($request->input('zones') as $zone) {
                $zone_id = $zone['localite'];
                $geom = null;
                if (!empty($zone['latitude']) && !empty($zone['longitude'])) {
                    $geom = $this->geomConvert($zone['longitude'], $zone['latitude']);
                } else {
                    $geom = Localite::find($zone_id)->centroid;
                }

                // Collecter les données dans un tableau
                $pivotData[$zone_id] = [
                    'longitude' => $zone['longitude'] ?? null,
                    'latitude' => $zone['latitude'] ?? null,
                    'geom' => $geom
                ];
            }

            // Une fois que toutes les données sont collectées, appeler sync
            $pratique->zonesActuelles()->sync($pivotData);
            return true;
        } catch (Exception $e) {
            Log::error('Erreur lors de la mise à jour des zones : ' . $e->getMessage());
            throw $e;
        }
    }

    protected function updateActeurs(Request $request, $pratique)
    {
        $pratique->partenaires()->sync($request->input('partenaire'));
        $pratique->beneficiaires()->sync($request->input('beneficiaire'));
    }

    protected function updateFiles($request, $pratique)
    {
        try {
            foreach ($request->removed_images ?? [] as $imagePath) {
                if (Storage::disk('public')->exists($imagePath)) {
                    $pratique->images()->where('path', $imagePath)->first()->delete();
                    Storage::delete($imagePath);
                }
            }
            // Delete removed files
            foreach ($request->removed_documents ?? [] as $filePath) {
                if (Storage::disk('public')->exists($filePath)) {
                    $pratique->documents()->where('path', $filePath)->first()->delete();
                    Storage::delete($filePath);
                }
            }
            $this->saveFiles($request, $pratique);
            return true;
        } catch (Exception $e) {
            Log::error('Erreur lors de la mise à jour des fichiers : ' . $e->getMessage());
            throw $e;
        }
    }

    protected function getFormData()
    {

        $localites = Localite::all();
        return [
            'pratique' => null,
            'piliers' => Pilier::all(),
            'secteurs' => SecteurActivite::all(),
            'partenaires' => Partenaire::all(),
            'typeChocs' => TypeChoc::all(),
            'typeReponses' => TypeReponse::all(),
            'localites' => $localites,
            'typeLocalites' => TypeLocalite::all(),
            'beneficiaires' => Beneficiaire::all(),
            'climats' => Climat::all() ?? [],
            'sols' => Sol::all() ?? [],
            'themes' => Theme::all(),
        ];
    }

    public function getEditData($pratique)
    {
        $domaines = $pratique->themes->pluck('domaines')->flatten();
        $pays = getPays();
        $pratique->setFilesUrls(true, true);
        // $pratique->setDocumentsUrls();
        $data = $this->getFormData();
        $data['pratique'] = $pratique;
        $data['pays'] = $pays;
        $data['domaines'] = $domaines;
        $localites = $pratique->zonesActuelles;
        return array_merge($data, ['zones' => $localites]);
    }

    protected function getFilePath($fileUrl)
    {
        $path = parse_url($fileUrl)['path'];
        $path = str_replace('/storage/', 'public/', $path);
        return $path;
    }

    protected function saveFiles($request, $pratique)
    {

        $this->saveImages($request, $pratique);
        if ($request->hasFile('documents')) {
            foreach ($request->file('documents') as $fichier) {
                $path = $fichier->store('documents', 'public');
                $filename = $this->sanitizeFilename($fichier->getClientOriginalName());
                $pratique->documents()->create(
                    [
                        'path' => $path,
                        'nom' => $filename
                    ]
                );
            }
        }
        $this->replaceFile($request, $pratique, 'vedette_path', 'image_vedette');
    }
    protected function setPratiqueData(Request $request)
    {
        return [
            'pratiqueLibelle' => $request->input('pratiqueLibelle'),
            'description' => $request->input('description'),
            'objectif' => $request->input('objectif'),
            'avantage' => $request->input('avantage'),
            'contrainte' => $request->input('contrainte'),
            'cout' => $request->input('cout'),
            'conseil' => $request->input('conseil'),
            'mesure' => $request->input('mesure'),
            'description_env_humain' => $request->input('description_env_humain'),
            'recommandation' => $request->input('recommandation'),
            'defis' => $request->input('defis'),
            'user_id' => Auth()->user()->id,
            'theme_id' => $request->input('theme_id'),
        ];
    }

    protected function isOwner($user, $pratique)
    {
        if (empty($user) || empty($pratique)) {
            return false;
        }
        $profile = Profil::find($user->profil_id);
        if (in_array($profile->nomProfil, ADMIN_PROFILES)) {
            return true;
        }
        return $pratique->user_id === $user->id;
    }

    protected function getOnValidationFailsZonesForm($request, $zonesType = 'actuelles')
    {
        $pays = getPays();

        $blade = $zonesType === 'actuelles' ? 'pratique.partials.fails' : 'pratique.partials.failsp';
        $zones = $zonesType === 'actuelles' ? $request->input('zones') : $request->input('zonesp');

        $zones = $zones ?: [];

        $vue = view(
            $blade,
            [
                'pays' => $pays,
                'zones' => $zones,
            ]
        )->render();

        return $vue;
    }

    protected function valideRemovedFiles($request)
    {
        $validator = Validator::make(
            $request->only('removed_images', 'removed_documents'),
            [
                'removed_images' => ['nullable', 'array'],
                'removed_images.*' => ['string'],
                'removed_documents' => ['nullable', 'array'],
                'removed_documents.*' => ['string'],

            ]
        );
        if ($validator->fails()) {
            $request->merge(
                [
                    'removed_images' => $validatedData['removed_images'] ?? null,
                    'removed_documents' => $validatedData['removed_documents'] ?? null,
                ]
            );
        }
        return $request;
    }
}
