<?php

namespace App\Http\Controllers;

use App\Models\Communaute;
use Illuminate\Http\Request;

class CommunauteController extends Controller
{
    private $operation = 'Opération effectuée avec succès';

    protected $rules = [
        'titre' => 'required|string',
        'contenu' => 'required|string',
    ];


    public function index($rub, $srub)
    {
        $communautes = Communaute::orderBy('created_at', 'desc')->get();
        return view('communaute.index')->with(['communautes' => $communautes, 'controler' => $this, "rub" => $rub, "srub" => $srub]);
    }


    public function create($rub, $srub)
    {
        return view('communaute.create')->with(["rub" => $rub, "srub" => $srub]);
    }

    public function store(Request $request)
    {

        // dd($request->all());
        $request->validate($this->rules);

        Communaute::create($request->all());
        return redirect('communaute/' . $request->input('rub') . '/' . $request->input('srub'))->with(['success' => $this->operation]);
    }

    public function edit($id, $rub, $srub)
    {
        $communaute = Communaute::findOrFail($id);
        return view('communaute.edit')->with(['communaute' => $communaute, "rub" => $rub, "srub" => $srub]);

        return view('communaute.edit', compact('communaute', 'rub', 'srub'));
    }

    public function update(Request $request, $id)
    {
        $request->validate($this->rules);

        $communaute = Communaute::findOrFail($id);
        $communaute->update($request->all());
        return redirect('communaute/' . $request->input('rub') . '/' . $request->input('srub'))->with(['success' => $this->operation]);
    }

    public function destroy($id)
    {
        // Suppression de la FAQ
        $communaute = Communaute::findOrFail($id);
        $communaute->delete();

        return back()->with('success', $this->operation);
    }
}
