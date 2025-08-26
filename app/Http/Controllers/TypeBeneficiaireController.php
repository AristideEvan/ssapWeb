<?php

namespace App\Http\Controllers;

use App\Models\TypeBeneficiaire;
use Illuminate\Http\Request;

class TypeBeneficiaireController extends Controller
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
        $typeBeneficiaires=TypeBeneficiaire::orderby('created_at','desc')->get();
        return view('typeBeneficiaire.index')->with(['typeBeneficiaires'=>$typeBeneficiaires,'controler'=>$this,"rub"=>$rub,"srub"=>$srub]);
    }

     /**
     * Show the form for creating a new resource.
     */
    public function create($rub, $srub)
    {
        return view('typeBeneficiaire.create')->with(["rub"=>$rub,"srub"=>$srub]);
    }

   /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'typeBeneficiaire' => ['required', 'string'],
        ]);

        $typeBeneficiaire = new TypeBeneficiaire();
        $typeBeneficiaire->typeBeneficiaireLibelle=$request->input('typeBeneficiaire');
        $typeBeneficiaire->save();

        return redirect('typeBeneficiaire/'.$request->input('rub').'/'.$request->input('srub'))->with(['success'=>$this->operation]);
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
        $typeBeneficiaire=TypeBeneficiaire::find($id);
        return view('typeBeneficiaire.edit')->with(['typeBeneficiaire'=>$typeBeneficiaire,"rub"=>$rub,"srub"=>$srub]);
        
    }

   /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'typeBeneficiaire' => ['required', 'string'],
        ]);

        $typeBeneficiaire = TypeBeneficiaire::find($id);
        $typeBeneficiaire->typeBeneficiaireLibelle=$request->input('typeBeneficiaire');
        $typeBeneficiaire->save();

        return redirect('typeBeneficiaire/'.$request->input('rub').'/'.$request->input('srub'))->with(['success'=>$this->operation]);
    }


   /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $typeBeneficiaire=TypeBeneficiaire::find($id);
        $typeBeneficiaire->delete();
        return back();
        //return redirect('typeBeneficiaire/'.$request['rub'].'/'.$request['srub']);
    }
}
