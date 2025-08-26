<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use App\Models\TypeReponse;
use Illuminate\Http\Request;

class TypeReponseController extends Controller
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
        $typeReponses=TypeReponse::orderby('created_at','desc')->get();
        return view('typeReponse.index')->with(['typeReponses'=>$typeReponses,'controler'=>$this,"rub"=>$rub,"srub"=>$srub]);
    }

     /**
     * Show the form for creating a new resource.
     */
    public function create($rub, $srub)
    {
        return view('typeReponse.create')->with(["rub"=>$rub,"srub"=>$srub]);
    }

   /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'typeReponse' => ['required', 'string'],
        ]);

        $typeReponse = new TypeReponse();
        $typeReponse->typeReponseLibelle=$request->input('typeReponse');
        $typeReponse->save();

        return redirect('typeReponse/'.$request->input('rub').'/'.$request->input('srub'))->with(['success'=>$this->operation]);
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
        $typeReponse=TypeReponse::find($id);
        return view('typeReponse.edit')->with(['typeReponse'=>$typeReponse,"rub"=>$rub,"srub"=>$srub]);
        
    }

   /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'typeReponse' => ['required', 'string'],
        ]);

        $typeReponse = TypeReponse::find($id);
        $typeReponse->typeReponseLibelle=$request->input('typeReponse');
        $typeReponse->save();

        return redirect('typeReponse/'.$request->input('rub').'/'.$request->input('srub'))->with(['success'=>$this->operation]);
    }


   /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        DB::table('pratiquereponses')->where('typeReponse_id', $id)->delete();
        $typeReponse=TypeReponse::find($id);
        $typeReponse->delete();
        return back();
        //return redirect('typeReponse/'.$request['rub'].'/'.$request['srub']);
    }
}
