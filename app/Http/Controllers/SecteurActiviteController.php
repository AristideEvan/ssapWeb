<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use App\Models\SecteurActivite;
use Illuminate\Http\Request;

class SecteurActiviteController extends Controller
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
        $secteurActivites=SecteurActivite::orderby('created_at','desc')->get();
        return view('secteurActivite.index')->with(['secteurActivites'=>$secteurActivites,'controler'=>$this,"rub"=>$rub,"srub"=>$srub]);
    }

     /**
     * Show the form for creating a new resource.
     */
    public function create($rub, $srub)
    {
        return view('secteurActivite.create')->with(["rub"=>$rub,"srub"=>$srub]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'secteurActivite' => ['required', 'string'],
        ]);

        $secteurActivite = new SecteurActivite();
        $secteurActivite->secteurActiviteLibelle=$request->input('secteurActivite');
        $secteurActivite->save();

        return redirect('secteurActivite/'.$request->input('rub').'/'.$request->input('srub'))->with(['success'=>$this->operation]);
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
        $secteurActivite=SecteurActivite::find($id);
        return view('secteurActivite.edit')->with(['secteurActivite'=>$secteurActivite,"rub"=>$rub,"srub"=>$srub]);
        
    }

   /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'secteurActivite' => ['required', 'string'],
        ]);

        $secteurActivite = SecteurActivite::find($id);
        $secteurActivite->secteurActiviteLibelle=$request->input('secteurActivite');
        $secteurActivite->save();

        return redirect('secteurActivite/'.$request->input('rub').'/'.$request->input('srub'))->with(['success'=>$this->operation]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        DB::table('pratiquesectacts')->where('secteurActivite_id', $id)->delete();
        $secteurActivite=SecteurActivite::find($id);
        $secteurActivite->delete();
        return back();
        //return redirect('secteurActivite/'.$request['rub'].'/'.$request['srub']);
    }
}
