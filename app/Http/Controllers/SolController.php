<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\Controller;
use App\Models\Sol;
use Illuminate\Http\Request;

class SolController extends Controller
{
    private $msgerror = 'Impossible de supprimer cet élément car il est utilisé!';
    private $operation = 'Opération effectuée avec succès';

    public function __construct()
    {
        $this->middleware('auth');
    }

    // Affiche la liste des sols avec rub et srub
    public function index($rub, $srub)
    {
        // Récupérer la liste des sols depuis la base de données
        $listeSols = Sol::all(); // Vous pouvez filtrer ou utiliser rub et srub selon les besoins

        // Retourner la vue avec les données des sols et rub/srub
        return view('sol.index')->with(['listeSols' => $listeSols, 'controler' => $this, "rub" => $rub, "srub" => $srub]);
    }

    // Affiche le formulaire pour créer un nouveau sol avec rub et srub
    public function create($rub, $srub)
    {
        // Retourner la vue pour créer un nouveau sol avec rub et srub
        return view('sol.create', compact('rub', 'srub'));
    }

    // Enregistrer un nouveau sol dans la base de données
    public function store(Request $request)
    {
        // Validation des données envoyées
        $request->validate([
            'solLibelle' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
        ]);

        // Créer un nouveau sol dans la base de données
        Sol::create([
            'solLibelle' => strtoupper($request->solLibelle),
            'description' => strtoupper($request->description),
        ]);

        // Rediriger vers la liste des sols avec un message de succès
        return redirect('sol/' . $request->input('rub') . '/' . $request->input('srub'))->with(['success' => $this->operation]);
    }

    // Affiche le formulaire pour éditer un sol avec rub et srub
    public function edit($id, $rub, $srub)
    {
        // Récupérer le sol à éditer
        $sol = Sol::findOrFail($id);

        // Retourner la vue pour modifier le sol avec rub et srub
        return view('sol.edit')->with(['sol' => $sol, "rub" => $rub, "srub" => $srub]);
    }

    // Met à jour un sol existant dans la base de données
    public function update(Request $request, $id)
    {
        // Validation des données envoyées
        $request->validate([
            'solLibelle' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
        ]);

        // Trouver le sol à mettre à jour
        $sol = Sol::findOrFail($id);

        // Mettre à jour les données du sol
        $sol->update([
            'solLibelle' => strtoupper($request->solLibelle),
            'description' => strtoupper($request->description),
        ]);

        // Rediriger vers la liste des sols avec un message de succès
        return redirect('sol/' . $request->input('rub') . '/' . $request->input('srub'))->with(['success' => $this->operation]);
    }

    // Supprimer un sol de la base de données
    public function destroy($id)
    {
        DB::table('pratiquesols')->where('sol_id', $id)->delete();
        $sol = Sol::findOrFail($id);

        // Supprimer le sol
        $sol->delete();
        return back();
        // Rediriger vers la liste des sols avec un message de succès
        //return redirect()->route('sol.index')->with('success', 'Sol supprimé avec succès.');
    }
}
