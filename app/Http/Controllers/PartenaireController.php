<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\Controller;
use App\Models\Partenaire;
use App\Models\TypePartenaire;
use Illuminate\Http\Request;

class PartenaireController extends Controller
{

    private $msgerror = 'Impossible de supprimer cet élément car il est utilisé!';
    private $operation = 'Opération effectuée avec succès';
    
    public function __construct()
    {
       $this->middleware('auth');
        
    }
    // Affiche la liste des partenaires avec rub et srub
    public function index($rub, $srub)
    {
        // Récupérer la liste des partenaires depuis la base de données
        $listePartenaires = Partenaire::all(); // Vous pouvez filtrer ou utiliser rub et srub selon les besoins

        // Retourner la vue avec les données des partenaires et rub/srub
        return view('partenaire.index')->with(['listePartenaires'=>$listePartenaires,'controler'=>$this,"rub"=>$rub,"srub"=>$srub]);
    }

    // Affiche le formulaire pour créer un nouveau partenaire avec rub et srub
    public function create($rub, $srub)
    {
        // Récupérer les types de partenaires pour le formulaire
        $typesPartenaire = TypePartenaire::all(); // Exemple, adapter selon vos besoins

        // Retourner la vue pour créer un nouveau partenaire avec rub et srub
        return view('partenaire.create', compact('typesPartenaire', 'rub', 'srub'));
    }

    // Enregistrer un nouveau partenaire dans la base de données
    public function store(Request $request)
    {
        // Validation des données envoyées
        $request->validate([
            'nom_partenaire' => 'required|string|max:255',
            'sigle' => 'nullable|string|max:255',
            'type_partenaire' => 'required|exists:type_partenaires,typePartenaire_id',
            'nom_repondant' => 'nullable|string|max:255',
            'prenom_repondant' => 'nullable|string|max:255',
            'telephone_repondant' => 'nullable|string|max:255',
            'email_repondant' => 'nullable|email|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Ajout de la validation du logo
        ]);

        $logoName = null;

    // Vérifier si un fichier logo est téléchargé
        if ($request->hasFile('logo')) {
        // Récupérer le fichier
            $logo = $request->file('logo');

            // Générer un nom unique pour le fichier
            $logoName = time() . '_' . uniqid() . '.' . $logo->getClientOriginalExtension();

            // Déplacer le fichier vers le dossier public/logos/
            $logo->move(public_path('logos'), $logoName);
        }
        // Créer un nouveau partenaire dans la base de données
        Partenaire::create([
            'nomPartenaire' => strtoupper($request->nom_partenaire),
            'sigle' => strtoupper($request->sigle),
            'typePartenaire_id' => $request->type_partenaire,
            'nomRepondant' => strtoupper($request->nom_repondant),
            'prenomRepondant' => strtoupper($request->prenom_repondant),
            'telephoneRepondant' => $request->telephone_repondant,
            'emailRepondant' => $request->email_repondant,
            'logo' => $logoName, // Stocke le nom du fichier dans la base de données
        ]);

        // Rediriger vers la liste des partenaires avec un message de succès
        return redirect('partenaire/'.$request->input('rub').'/'.$request->input('srub'))->with(['success'=>$this->operation]);    }

    // Affiche le formulaire pour éditer un partenaire avec rub et srub
    public function edit($id, $rub, $srub)
    {
        // Récupérer le partenaire à éditer
        $partenaire = Partenaire::findOrFail($id);

        // Récupérer les types de partenaires pour le formulaire
        $typesPartenaire = TypePartenaire::all();

        // Retourner la vue pour modifier le partenaire avec rub et srub
        return view('partenaire.edit')->with(['partenaire'=>$partenaire,'typesPartenaire'=>$typesPartenaire,"rub"=>$rub,"srub"=>$srub]);
    }

    // Met à jour un partenaire existant dans la base de données
    public function update(Request $request, $id)
    {
        // Validation des données envoyées
        $request->validate([
            'nom_partenaire' => 'required|string|max:255',
            'sigle' => 'nullable|string|max:255',
            'type_partenaire' => 'nullable|exists:type_partenaires,typePartenaire_id',
            'nom_repondant' => 'nullable|string|max:255',
            'prenom_repondant' => 'nullable|string|max:255',
            'telephone_repondant' => 'nullable|string|max:255',
            'email_repondant' => 'nullable|email|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validation du logo
        ]);

        // Trouver le partenaire à mettre à jour
        $partenaire = Partenaire::findOrFail($id);

        // Mettre à jour les données du partenaire
        $partenaire->update([
            'nomPartenaire' => strtoupper($request->nom_partenaire),
            'sigle' => strtoupper($request->sigle),
            'typePartenaire_id' => $request->type_partenaire,
            'nomRepondant' => strtoupper($request->nom_repondant),
            'prenomRepondant' => strtoupper($request->prenom_repondant),
            'telephoneRepondant' => $request->telephone_repondant,
            'emailRepondant' => $request->email_repondant,
        ]);
        if ($request->hasFile('logo')) {
            // Supprimer l'ancien logo si nécessaire
            if ($partenaire->logo && file_exists(public_path('logos/'.$partenaire->logo))) {
                unlink(public_path('logos/'.$partenaire->logo));
            }
    
            // Télécharger le nouveau logo
            $logo = $request->file('logo');
            $logoName = time() . '.' . $logo->getClientOriginalExtension();
            
            // Déplacer le logo vers le dossier public/logos
            $logo->move(public_path('logos'), $logoName);
    
            // Mettre à jour le nom du logo dans la base de données
            $partenaire->logo = $logoName;
            $partenaire->save();
        }
        // Rediriger vers la liste des partenaires avec un message de succès
        return redirect('partenaire/'.$request->input('rub').'/'.$request->input('srub'));    }

    // Supprimer un partenaire de la base de données
    public function destroy($id)
    {
        DB::table('pratiqueparts')->where('partenaire_id', $id)->delete();
        // Trouver le partenaire à supprimer
        $partenaire = Partenaire::findOrFail($id);

        // Supprimer le partenaire
        $partenaire->delete();
        return back();
        // Rediriger vers la liste des partenaires avec un message de succès
        //return redirect()->route('partenaire.index')->with('success', 'Partenaire supprimé avec succès.');
    }
}
