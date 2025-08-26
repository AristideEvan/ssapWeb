<?php

namespace App\Http\Controllers;

use App\Models\TypeLocalite;
use Illuminate\Http\Request;

class TypeLocaliteController extends Controller
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
        $typeLocalites=TypeLocalite::orderby('created_at','desc')->get();
        return view('typeLocalite.index')->with(['typeLocalites'=>$typeLocalites,'controler'=>$this,"rub"=>$rub,"srub"=>$srub]);
    }

     /**
     * Show the form for creating a new resource.
     */
    public function create($rub, $srub)
    {
        return view('typeLocalite.create')->with(["rub"=>$rub,"srub"=>$srub]);
    }

   /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'typeLocalite' => ['required', 'string'],
        ]);

        $typeLocalite = new TypeLocalite();
        $typeLocalite->typeLocaliteLibelle=$request->input('typeLocalite');
        $typeLocalite->save();

        return redirect('typeLocalite/'.$request->input('rub').'/'.$request->input('srub'))->with(['success'=>$this->operation]);
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
        $typeLocalite=TypeLocalite::find($id);
        return view('typeLocalite.edit')->with(['typeLocalite'=>$typeLocalite,"rub"=>$rub,"srub"=>$srub]);
        
    }

   /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'typeLocalite' => ['required', 'string'],
        ]);

        $typeLocalite = TypeLocalite::find($id);
        $typeLocalite->typeLocaliteLibelle=$request->input('typeLocalite');
        $typeLocalite->save();

        return redirect('typeLocalite/'.$request->input('rub').'/'.$request->input('srub'))->with(['success'=>$this->operation]);
    }


   /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $typeLocalite=TypeLocalite::find($id);
        $typeLocalite->delete();
        return back();
        //return redirect('typeLocalite/'.$request['rub'].'/'.$request['srub']);
    }
}
