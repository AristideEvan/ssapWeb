<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use App\Models\Domaine;
use App\Models\Theme;
use Illuminate\Http\Request;

class DomaineController extends Controller
{
    private $msgerror='Impossible de supprimer cet élément car il est utilisé!';
    private $operation='Opération effectuée avec succès';
     /**
     * Create a new controller instance.
     *  
     * @return void
     */
    public function __construct()
    {
       $this->middleware('auth');
        
    }
    /**
     * Display a listing of the resource.
     */
    public function index($rub , $srub)
    {
        //dd(session('menus'));
        $domaines=Domaine::orderby('created_at','desc')->get();
        $themes = Theme::all();
        return view('domaine.index')->with(['themes'=>$themes,'domaines'=>$domaines,'controler'=>$this,"rub"=>$rub,"srub"=>$srub]);
    }

     /**
     * Show the form for creating a new resource.
     */
    public function create($rub, $srub)
    {
        $themes = Theme::all();
        return view('domaine.create')->with(['themes'=>$themes,"rub"=>$rub,"srub"=>$srub]);
    }

   /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validation des données du formulaire
        $this->validate($request, [
            'domaine' => ['required', 'string'],
            'theme' => ['required', 'array'], // Vérifie que c'est un tableau (sélection multiple)
            'theme.*' => ['exists:themes,theme_id'], // Vérifie que chaque élément existe bien dans la table themes
        ]);

        // Création et enregistrement du domaine
        $domaine = new Domaine();
        $domaine->domaineLibelle = $request->input('domaine');
        $domaine->save();

        // Enregistrement des thèmes sélectionnés dans la table d'association theme_domaine
        $themes = $request->input('theme'); // Récupération des IDs des thèmes sélectionnés
        $domaine->themes()->attach($themes); // Utilisation de la relation Eloquent

        // Redirection avec un message de succès
        return redirect('domaine/' . $request->input('rub') . '/' . $request->input('srub'))
            ->with(['success' => $this->operation]);
    }



     /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id,$rub, $srub)
    {
        $domaine=Domaine::find($id); 
        $themes = Theme::all();
        return view('domaine.edit')->with(['domaine'=>$domaine,'themes'=>$themes, "rub"=>$rub,"srub"=>$srub]);
        
    }

   /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Domaine $domaine)
    {
        // Validation des données
        $this->validate($request, [
            'domaine' => ['required', 'string'],
            'theme' => ['required', 'array'],
            'theme.*' => ['exists:themes,theme_id'],
        ]);

        // Mise à jour du domaine
        $domaine->domaineLibelle = $request->input('domaine');
        $domaine->save();

        // Mise à jour des thèmes associés
        $domaine->themes()->sync($request->input('theme'));

        return redirect('domaine/' . $request->input('rub') . '/' . $request->input('srub'))
            ->with(['success' => $this->operation]);
    }



   /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        DB::table('pratiquedomaines')->where('domaine_id', $id)->delete();
        $domaine=Domaine::find($id);
        $domaine->delete();
        return back();
        //return redirect('domaine/'.$request['rub'].'/'.$request['srub']);
    }
}
