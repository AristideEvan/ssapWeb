<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\Controller;
use App\Models\Pilier;
use Illuminate\Http\Request;

class PilierController extends Controller
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
        $piliers=Pilier::orderby('created_at','desc')->get();
        return view('pilier.index')->with(['piliers'=>$piliers,'controler'=>$this,"rub"=>$rub,"srub"=>$srub]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($rub, $srub)
    {
        return view('pilier.create')->with(["rub"=>$rub,"srub"=>$srub]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'pilier' => ['required', 'string'],
        ]);

        $pilier = new Pilier();
        $pilier->pilierLibelle=$request->input('pilier');
        $pilier->save();

        return redirect('pilier/'.$request->input('rub').'/'.$request->input('srub'))->with(['success'=>$this->operation]);
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
        $pilier=Pilier::find($id);
        return view('pilier.edit')->with(['pilier'=>$pilier,"rub"=>$rub,"srub"=>$srub]);
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'pilier' => ['required', 'string'],
        ]);

        $pilier = Pilier::find($id);
        $pilier->pilierLibelle=$request->input('pilier');
        $pilier->save();

        return redirect('pilier/'.$request->input('rub').'/'.$request->input('srub'))->with(['success'=>$this->operation]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        DB::table('pratiquepiliers')->where('pilier_id', $id)->delete();
        $pilier=Pilier::find($id);
        $pilier->delete();
        return back();
        //return redirect('pilier/'.$request['rub'].'/'.$request['srub']);
    }
}
