<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use App\Models\Beneficiaire;
use App\Models\TypeBeneficiaire;
use Illuminate\Http\Request;

class BeneficiaireController extends Controller
{
   /**
     * Afficher la liste des bénéficiaires.
     */
    public function index($rub, $srub)
    {
        $beneficiaires = Beneficiaire::with('typeBeneficiaire')->get(); // Charge la relation typeBeneficiaire
        return view('beneficiaire.index')->with(['beneficiaires'=>$beneficiaires,'controler'=>$this,"rub"=>$rub,"srub"=>$srub]);
    }

    /**
     * Afficher le formulaire pour créer un nouveau bénéficiaire.
     */
    public function create($rub, $srub)
    {
        $types = TypeBeneficiaire::all(); // Charge tous les types de bénéficiaires pour le combobox
        return view('beneficiaire.create', compact('types', 'rub', 'srub'));
    }

    /**
     * Enregistrer un nouveau bénéficiaire.
     */
    public function store(Request $request)
    {
        $request->validate([
            'typeBeneficiaire' => 'nullable|exists:type_beneficiaires,typeBeneficiaire_id',
            'beneficiaireLibelle' => 'required|string|max:255',
        ]);

        Beneficiaire::create([
            'typeBeneficiaire_id' => $request->typeBeneficiaire,
            'beneficiaireLibelle' =>strtoupper($request->beneficiaireLibelle),
        ]);

        return redirect('beneficiaire/'.$request->input('rub').'/'.$request->input('srub'));
    }

    /**
     * Afficher le formulaire pour modifier un bénéficiaire existant.
     */
    public function edit($id, $rub, $srub)
    {
        $beneficiaire = Beneficiaire::findOrFail($id);
        $types = TypeBeneficiaire::all(); // Charge tous les types de bénéficiaires pour le combobox
        return view('beneficiaire.edit')->with(['beneficiaire'=>$beneficiaire,'types'=>$types,"rub"=>$rub,"srub"=>$srub]);
    }

    /**
     * Mettre à jour un bénéficiaire existant.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'typeBeneficiaire' => 'nullable|exists:type_beneficiaires,typeBeneficiaire_id',
            'beneficiaireLibelle' => 'required|string|max:255',
        ]);

        $beneficiaire = Beneficiaire::findOrFail($id);
        $beneficiaire->update([
            'typeBeneficiaire' => $request->typeBeneficiaire,
            'beneficiaireLibelle' => strtoupper($request->beneficiaireLibelle),
        ]);

        return redirect('beneficiaire/'.$request->input('rub').'/'.$request->input('srub')); 
    }

    /**
     * Supprimer un bénéficiaire.
     */
    public function destroy($id)
    {
        DB::table('pratiquebenefs')->where('beneficiaire_id', $id)->delete();
        $beneficiaire = Beneficiaire::findOrFail($id);
        $beneficiaire->delete();

        return back()->with('success', 'Bénéficiaire supprimé avec succès.');
    }
}