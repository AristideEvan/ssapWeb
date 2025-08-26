<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use App\Models\Localite;
use App\Models\TypeLocalite;
use Illuminate\Http\Request;

class LocaliteController extends Controller
{
    // Méthode pour afficher la liste des localités
    public function index($rub, $srub)
    {
        // Récupère les localités
        $localites = Localite::with('typeLocalite', 'parent')->get();  // Assuming 'parent' is a relation
        return view('localite.index')->with(['localites'=>$localites,'controler'=>$this,"rub"=>$rub,"srub"=>$srub]);
    }

    // Méthode pour afficher le formulaire de création d'une nouvelle localité
    public function create($rub, $srub)
    {
        // Récupère les types de localités et les localités existantes pour le champ parent
        $types = TypeLocalite::all();
        $localites = Localite::with('typeLocalite', 'parent')->get(); 
        return view('localite.create', compact('rub', 'srub', 'types', 'localites'));
    }

    // Méthode pour enregistrer une nouvelle localité
    public function store(Request $request)
    {
        // Validation des données
        $request->validate([
            'localiteNom' => 'required|string|max:255',
            'typeLocalite' => 'nullable|exists:type_localites,typeLocalite_id',
            'parent' => 'nullable|exists:localites,localite_id', // Parent localite is optional
            'codeAlpha2' => 'nullable|string|max:2',
            'codeAlpha3' => 'nullable|string|max:3',
            'codeNumerique' => 'nullable|numeric',
        ]);

        // Création de la localité
        Localite::create([
            'nomLocalite' =>strtoupper( $request->localiteNom),
            'typeLocalite_id' => $request->typeLocalite,
            'parent_id' => $request->parent ?? null,
            'codeAlpha2' =>strtoupper( $request->codeAlpha2),
            'codeAlpha3' => strtoupper($request->codeAlpha3),
            'codeNum' => $request->codeNumerique,
        ]);

        return redirect('localite/'.$request->input('rub').'/'.$request->input('srub'));     }

    // Méthode pour afficher le formulaire d'édition d'une localité
    public function edit($id, $rub, $srub)
    {
        // Récupère la localité et les données nécessaires pour l'édition
        $localite = Localite::findOrFail($id);
        $types = TypeLocalite::all();
        $localites = Localite::all(); // Liste des localités pour le champ parent
        return view('localite.edit')->with(['localites'=>$localites,'localite'=>$localite,'types'=>$types,"rub"=>$rub,"srub"=>$srub]);    }

    // Méthode pour mettre à jour une localité
    public function update(Request $request, $id)
    {
        // Validation des données
        $request->validate([
            'localiteNom' => 'required|string|max:255',
            'typeLocalite' => 'required|exists:type_localites,typeLocalite_id',
            'parent' => 'nullable|exists:localites,localite_id', // Parent localite is optional
            'codeAlpha2' => 'nullable|string|max:2',
            'codeAlpha3' => 'nullable|string|max:3',
            'codeNumerique' => 'nullable|numeric',
        ]);

        // Récupère la localité existante
        $localite = Localite::findOrFail($id);

        // Mise à jour des données
        $localite->update([
            'nomLocalite' =>strtoupper( $request->localiteNom),
            'typeLocalite_id' => $request->typeLocalite,
            'parent_id' => $request->parent ?? null,
            'codeAlpha2' =>strtoupper( $request->codeAlpha2),
            'codeAlpha3' =>strtoupper( $request->codeAlpha3),
            'codeNum' => $request->codeNumerique,
        ]);

        return redirect('localite/'.$request->input('rub').'/'.$request->input('srub'));    
    }

    // Méthode pour supprimer une localité
    public function destroy($id)
    {
        DB::table('pratiquezoneapplis')->where('localite_id', $id)->delete();
        DB::table('pratiquezonepotents')->where('localite_id', $id)->delete();
        // Récupère et supprime la localité
        $localite = Localite::findOrFail($id);
        $localite->delete();
        return back();
        //return redirect()->route('localite.index');
    }
}
