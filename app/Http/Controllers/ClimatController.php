<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;


use App\Http\Controllers\Controller;
use App\Models\Climat;
use Illuminate\Http\Request;

class ClimatController extends Controller
{
    private $msgerror = 'Impossible de supprimer cet élément car il est utilisé!';
    private $operation = 'Opération effectuée avec succès';

    public function __construct()
    {
        $this->middleware('auth');
    }

    // Affiche la liste des climats avec rub et srub
    public function index($rub, $srub)
    {
        // Récupérer la liste des climats depuis la base de données
        $listeClimats = Climat::all(); // Vous pouvez filtrer ou utiliser rub et srub selon les besoins

        // Retourner la vue avec les données des climats et rub/srub
        return view('climat.index')->with(['listeClimats' => $listeClimats, 'controler' => $this, "rub" => $rub, "srub" => $srub]);
    }

    // Affiche le formulaire pour créer un nouveau climat avec rub et srub
    public function create($rub, $srub)
    {
        // Retourner la vue pour créer un nouveau climat avec rub et srub
        return view('climat.create', compact('rub', 'srub'));
    }

    // Enregistrer un nouveau climat dans la base de données
    public function store(Request $request)
    {
        // Validation des données envoyées
        $request->validate([
            'libelleClimat' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
        ]);

        // Créer un nouveau climat dans la base de données
        Climat::create([
            'libelleClimat' => strtoupper($request->libelleClimat),
            'description' => strtoupper($request->description),
        ]);

        // Rediriger vers la liste des climats avec un message de succès
        return redirect('climat/' . $request->input('rub') . '/' . $request->input('srub'))->with(['success' => $this->operation]);
    }

    // Affiche le formulaire pour éditer un climat avec rub et srub
    public function edit($id, $rub, $srub)
    {
        // Récupérer le climat à éditer
        $climat = Climat::findOrFail($id);

        // Retourner la vue pour modifier le climat avec rub et srub
        return view('climat.edit')->with(['climat' => $climat, "rub" => $rub, "srub" => $srub]);
    }

    // Met à jour un climat existant dans la base de données
    public function update(Request $request, $id)
    {
        // Validation des données envoyées
        $request->validate([
            'libelleClimat' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
        ]);

        // Trouver le climat à mettre à jour
        $climat = Climat::findOrFail($id);

        // Mettre à jour les données du climat
        $climat->update([
            'libelleClimat' => strtoupper($request->libelleClimat),
            'description' => strtoupper($request->description),
        ]);

        // Rediriger vers la liste des climats avec un message de succès
        return redirect('climat/' . $request->input('rub') . '/' . $request->input('srub'))->with(['success' => $this->operation]);
    }

    // Supprimer un climat de la base de données
    public function destroy($id)
    {
        DB::table('pratiqueclimats')->where('climat_id', $id)->delete();

        // Trouver le climat à supprimer
        $climat = Climat::findOrFail($id);

        // Supprimer le climat
        $climat->delete();
        return back();
        // Rediriger vers la liste des climats avec un message de succès
        // return redirect()->route('climat.index')->with('success', 'Climat supprimé avec succès.');
    }
}
