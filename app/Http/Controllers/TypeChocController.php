<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use App\Models\TypeChoc;
use Illuminate\Http\Request;

class TypeChocController extends Controller
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
        $typeChocs=TypeChoc::orderby('created_at','desc')->get();
        return view('typeChoc.index')->with(['typeChocs'=>$typeChocs,'controler'=>$this,"rub"=>$rub,"srub"=>$srub]);
    }

     /**
     * Show the form for creating a new resource.
     */
    public function create($rub, $srub)
    {
        return view('typeChoc.create')->with(["rub"=>$rub,"srub"=>$srub]);
    }

   /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'typeChoc' => ['required', 'string'],
        ]);

        $typeChoc = new TypeChoc();
        $typeChoc->typeChocLibelle=$request->input('typeChoc');
        $typeChoc->save();

        return redirect('typeChoc/'.$request->input('rub').'/'.$request->input('srub'))->with(['success'=>$this->operation]);
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
        $typeChoc=TypeChoc::find($id);
        return view('typeChoc.edit')->with(['typeChoc'=>$typeChoc,"rub"=>$rub,"srub"=>$srub]);
        
    }

   /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'typeChoc' => ['required', 'string'],
        ]);

        $typeChoc = TypeChoc::find($id);
        $typeChoc->typeChocLibelle=$request->input('typeChoc');
        $typeChoc->save();

        return redirect('typeChoc/'.$request->input('rub').'/'.$request->input('srub'))->with(['success'=>$this->operation]);
    }


   /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        DB::table('pratiquetypechocs')->where('typeChoc_id', $id)->delete();
        $typeChoc=TypeChoc::find($id);
        $typeChoc->delete();
        return back();
        //return redirect('typeChoc/'.$request['rub'].'/'.$request['srub']);
    }
}
