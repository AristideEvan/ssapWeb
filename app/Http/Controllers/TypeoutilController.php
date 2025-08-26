<?php

namespace App\Http\Controllers;

use App\Models\Typeoutil;
use Illuminate\Http\Request;

class TypeoutilController extends Controller
{
    private $msgerror = 'Impossible de supprimer cet élément car il est utilisé!';
    private $operation = 'Opération effectuée avec succès';

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
    public function index($rub, $srub)
    {
        $typeoutils = Typeoutil::orderBy('created_at', 'desc')->get();
        return view('typeoutil.index')->with(['typeoutils' => $typeoutils, 'controler' => $this, 'rub' => $rub, 'srub' => $srub]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($rub, $srub)
    {
        return view('typeoutil.create')->with(['rub' => $rub, 'srub' => $srub]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'typeoutilLibelle' => ['required', 'string'],
        ]);

        $typeoutil = new Typeoutil();
        $typeoutil->typeoutilLibelle = $request->input('typeoutilLibelle');
        $typeoutil->save();

        return redirect('typeoutil/' . $request->input('rub') . '/' . $request->input('srub'))->with(['success' => $this->operation]);
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
    public function edit($id, $rub, $srub)
    {
        $typeoutil = Typeoutil::find($id);
        return view('typeoutil.edit')->with(['typeoutil' => $typeoutil, 'rub' => $rub, 'srub' => $srub]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'typeoutilLibelle' => ['required', 'string'],
        ]);

        $typeoutil = Typeoutil::find($id);
        $typeoutil->typeoutilLibelle = $request->input('typeoutilLibelle');
        $typeoutil->save();

        return redirect('typeoutil/' . $request->input('rub') . '/' . $request->input('srub'))->with(['success' => $this->operation]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $typeoutil = Typeoutil::find($id);
        $typeoutil->delete();
        return back();
    }
}
