<?php

namespace App\Http\Controllers;

use App\Models\TypePartenaire;
use Illuminate\Http\Request;

class TypePartenaireController extends Controller
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
        $typePartenaires=TypePartenaire::orderby('created_at','desc')->get();
        return view('typePartenaire.index')->with(['typePartenaires'=>$typePartenaires,'controler'=>$this,"rub"=>$rub,"srub"=>$srub]);
    }

     /**
     * Show the form for creating a new resource.
     */
    public function create($rub, $srub)
    {
        return view('typePartenaire.create')->with(["rub"=>$rub,"srub"=>$srub]);
    }

   /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'typePartenaire' => ['required', 'string'],
        ]);

        $typePartenaire = new TypePartenaire();
        $typePartenaire->typePartenaireLibelle=$request->input('typePartenaire');
        $typePartenaire->save();

        return redirect('typePartenaire/'.$request->input('rub').'/'.$request->input('srub'))->with(['success'=>$this->operation]);
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
        $typePartenaire=TypePartenaire::find($id);
        return view('typePartenaire.edit')->with(['typePartenaire'=>$typePartenaire,"rub"=>$rub,"srub"=>$srub]);
        
    }

   /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'typePartenaire' => ['required', 'string'],
        ]);

        $typePartenaire = TypePartenaire::find($id);
        $typePartenaire->typePartenaireLibelle=$request->input('typePartenaire');
        $typePartenaire->save();

        return redirect('typePartenaire/'.$request->input('rub').'/'.$request->input('srub'))->with(['success'=>$this->operation]);
    }


   /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $typePartenaire=TypePartenaire::find($id);
        $typePartenaire->delete();
        return back();
        //return redirect('typePartenaire/'.$request['rub'].'/'.$request['srub']);
    }
}
