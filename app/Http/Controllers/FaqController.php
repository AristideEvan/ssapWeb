<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    private $operation = 'Opération effectuée avec succès';

    protected $rules = [
        'question' => 'required|string|max:255',
        'reponse' => 'required|string',
    ];


    public function index($rub, $srub)
    {
        $faqs = Faq::orderBy('created_at', 'desc')->get();
        return view('faq.index')->with(['faqs' => $faqs, 'controler' => $this, "rub" => $rub, "srub" => $srub]);
    }


    public function create($rub, $srub)
    {
        return view('faq.create')->with(["rub" => $rub, "srub" => $srub]);
    }

    public function store(Request $request)
    {

        $request->validate($this->rules);

        Faq::create($request->all());
        return redirect('faq/' . $request->input('rub') . '/' . $request->input('srub'))->with(['success' => $this->operation]);
    }

    public function edit($id, $rub, $srub)
    {
        $faq = Faq::findOrFail($id);
        return view('faq.edit')->with(['faq' => $faq, "rub" => $rub, "srub" => $srub]);

        return view('faq.edit', compact('faq', 'rub', 'srub'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate($this->rules);

        $faq = Faq::findOrFail($id);
        $faq->update($validated);
        return redirect('faq/' . $request->input('rub') . '/' . $request->input('srub'))->with(['success' => $this->operation]);
    }

    public function destroy($id)
    {
        // Suppression de la FAQ
        $faq = Faq::findOrFail($id);
        $faq->delete();

        return back()->with('success', $this->operation);
    }
}
