<?php

namespace App\Http\Controllers;

use App\Models\Outil;
use App\Models\Actualite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ActualiteController extends Controller
{
    private $operation = 'Opération effectuée avec succès';

    protected $rules = [
        'titre' => 'required|string',
        'contenu' => 'required|string',
        'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'publique' => 'boolean',
    ];


    public function index($rub, $srub)
    {
        $actualites = Actualite::orderBy('created_at', 'desc')->get();
        return view('actualite.index')->with(['actualites' => $actualites, 'controler' => $this, "rub" => $rub, "srub" => $srub]);
    }


    public function create($rub, $srub)
    {
        return view('actualite.create')->with(["rub" => $rub, "srub" => $srub]);
    }

    public function store(Request $request)
    {
        $request->validate($this->rules);
        $path = $request->hasFile('image') ? $request->file('image')->store('images', 'public') : null;
        Actualite::create(array_merge($request->all(), ['image_path' => $path]));
        return redirect('actualite/' . $request->input('rub') . '/' . $request->input('srub'))->with(['success' => $this->operation]);
    }

    public function edit($id, $rub, $srub)
    {
        $actualite = Actualite::findOrFail($id);
        $actualite->setFilesUrls();
        return view('actualite.edit')->with(['actualite' => $actualite, "rub" => $rub, "srub" => $srub]);
    }

    public function update(Request $request, $id)
    {
        $request->validate($this->rules);
        $actualite = Actualite::findOrFail($id);
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('images', 'public');
            if (!empty($actualite->image_path)) {
                Storage::delete($actualite->image_path);
            }
        }
        $actualite->update(array_merge($request->all(), ['image_path' => $path ?? $actualite->image_path]));

        return redirect('actualite/' . $request->input('rub') . '/' . $request->input('srub'))->with(['success' => $this->operation]);
    }

    public function destroy($id)
    {
        // Suppression de la FAQ
        $actualite = Outil::findOrFail($id);
        try {
            if (!empty($actualite->image_path)) {
                Storage::delete($actualite->image_path);
            }
        } catch (\Exception $e) {
            Log::error('Erreur lors de la suppression de l\'acutalite : ' . $e->getMessage());
            return back()->with('error', 'Une erreur est survenue : ' . $e->getMessage());
        }
        $actualite->delete();

        return back()->with('success', $this->operation);
    }
}
