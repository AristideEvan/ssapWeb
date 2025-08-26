<?php

namespace App\Http\Controllers;
use App\Models\Localite;
use App\Models\Pratiquezoneappli;
use Illuminate\Support\Facades\DB;
use App\Models\Pratique;
use App\Models\Theme;
use App\Models\Domaine;
use Illuminate\Http\Request;
use App\Http\Controllers\Ajax\AjaxController;

require_once app_path('Helpers/Helpers.php');

class CarteController extends Controller
{
    /**
     * Afficher la carte avec les points de données.
     *
     * @return \Illuminate\View\View
     */
    public function index($rub, $srub)
    {
        //dd(session('menusFront'));
        // Exemple de données dynamiques avec des coordonnées de test
        $localites=Localite::where('parent_id',null)->get();
        //dd($localites);
        // Optionnel : récupérer les bénéficiaires si nécessaire
        // Retourner la vue avec les données
        return view('carte.index')->with(['localites' => $localites, 'rub' => $rub, 'srub' => $srub, 'controller' => $this ]);

        
    }




    public function initialisemap()
    {
        try {
            // Récupération de tous les éléments de la vue viewPratiqueLocalite
            $pratiques = DB::select('
                SELECT *, ST_X(geom::geometry) AS longitude, ST_Y(geom::geometry) AS latitude
                FROM "viewPratiqueLocalite"
            ');
    
            // Traitement des chemins d'image pour éviter les valeurs nulles
            foreach ($pratiques as &$pratique) {
                $pratique->vedette_path = !empty($pratique->vedette_path) ? asset('storage/' . $pratique->vedette_path) : '';
            }
    
            return response()->json(["status" => "success", "data" => $pratiques]);
    
        } catch (\Exception $e) {
            return response()->json(["status" => "error", "message" => $e->getMessage()], 500);
        }
    } 
    

public function paysetfils(Request $request, $rub, $srub){
    $parentId = $request->get('parent_id');
    if ($parentId) {
        // Récupérer la localité parent
        $parent = DB::select('                                                                                                                                                                                                                                                                                                                                                                                                        
        SELECT 
            "localite_id",                                                                                         
            "typeLocalite_id",
            "parent_id",
            "nomLocalite",
            "codeAlpha2",
            "codeAlpha3",
            "codeNum",
            "centroid",
            ST_X(centroid::geometry) AS longitude,
            ST_Y(centroid::geometry) AS latitude,
            "created_at",
            "updated_at"
        FROM "localites"
        WHERE "localite_id" = ?
    ', [$parentId]);

    $pratiques = DB::select('
                SELECT *, ST_X(geom::geometry) AS longitude, ST_Y(geom::geometry) AS latitude
                FROM "viewPratiqueLocalite"
            ');
    foreach ($pratiques as &$pratique) {
        $pratique->vedette_path = !empty($pratique->vedette_path) ? asset('storage/' . $pratique->vedette_path) : '';
    }

    return response()->json(["success" => "true", "data" => $pratiques,"parent" =>$parent[0]]);
    }
}



public function showMap()
    {
        $localites=Localite::where('parent_id',null)->get();
        return view('carte.showMap')->with(['localites' => $localites, 'rub' => 1, 'srub' => 2, 'controller' => $this ]);
    }

public function showTheme(Request $request)
    {
        // Récupérer l'ID du thème depuis la requête GET
        $themeId = $request->query('theme_id');

        if (!$themeId) {
            return response()->json([
                'status' => 'error',
                'message' => 'Paramètre theme_id manquant.'
            ], 400);
        }

        // Vérifier si le thème existe
        $theme = Theme::find($themeId);

        if (!$theme) {
            return response()->json([
                'status' => 'error',
                'message' => 'Thème non trouvé.'
            ], 404);
        }

        // Récupérer les domaines associés au thème depuis la table d'association theme_domaine
        $domaines = Domaine::join('theme_domaine', 'domaines.domaine_id', '=', 'theme_domaine.domaine_id')
            ->where('theme_domaine.theme_id', $themeId)
            ->select('domaines.domaine_id', 'domaines.domaineLibelle')
            ->get();

        return response()->json([
            'status' => 'success',
            'theme' => $theme,
            'domaines' => $domaines
        ]);
    }

}
