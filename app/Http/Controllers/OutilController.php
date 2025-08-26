<?php

namespace App\Http\Controllers;

use App\Models\Outil;
use App\Models\Typeoutil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class OutilController extends Controller
{
    private $operation = 'Opération effectuée avec succès';

    protected $rules = [
        'typeoutil_id' => 'required|integer|exists:typeoutils,typeoutil_id',
        'titre' => 'required|string',
        'contenu' => 'required|string',
        'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'documents' => ['nullable', 'array'],
        'documents.*' => 'file|mimes:pdf,xls,xlsx,doc,docx,ppt,pptx,odt,xml,gpx,odp,ods,jpeg,png,jpg,gif,svg,txt|max:2048',

    ];

    public function index($rub, $srub)
    {
        $outils = Outil::orderBy('created_at', 'desc')->get();
        return view('outil.index')->with(['outils' => $outils, 'controler' => $this, "rub" => $rub, "srub" => $srub]);
    }


    public function create($rub, $srub)
    {
        $typeOutils = Typeoutil::all();
        return view('outil.create')->with(["rub" => $rub, "srub" => $srub, 'typeOutils' => $typeOutils]);
    }

    public function store(Request $request)
    {
        Validator::make($request->all(), $this->rules)->validate();
        $path = $request->hasFile('image') ? $request->file('image')->store('images', 'public') : null;
        $outil = Outil::create(array_merge($request->all(), ['image_path' => $path]));
        $this->saveFiles($request, $outil);
        return redirect('outil/' . $request->input('rub') . '/' . $request->input('srub'))->with(['success' => $this->operation]);
    }

    public function edit($id, $rub, $srub)
    {
        $outil = Outil::findOrFail($id);
        $outil->setFilesUrls(true, true); // include images and documents
        $typeOutils = TypeOutil::all();
        return view('outil.edit')->with(['outil' => $outil, "rub" => $rub, "srub" => $srub, 'typeOutils' => $typeOutils]);
        return view('outil.edit', compact('outil', 'rub', 'srub'));
    }

    public function update(Request $request, $id)
    {
        $outil = Outil::findOrFail($id);
        Validator::make($request->all(), $this->rules)->validate();
        $validatedData = Validator::make(
            $request->only('removed_documents'),
            [
                'removed_documents' => ['nullable', 'array'],
                'removed_documents.*' => ['string'],
            ]
        )->validated();
        $request->merge(
            [
                'removed_documents' => $validatedData['removed_documents'] ?? null,
            ]
        );
        // Delete removed documents
        if ($request->filled('removed_documents')) {
            $to_delete_documents = $outil->documents()->whereIn('path', $request->removed_documents)->get();
            // Supprimer les entrées de la base de données
            foreach ($to_delete_documents as $doc) {
                $doc->delete(); // Suppression en base
            }

            foreach ($request->removed_documents as $filePath) {
                if (Storage::exists($filePath)) {
                    Storage::delete($filePath);
                }
            }
        }

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('images', 'public');
            if (!empty($outil->image_path)) {
                Storage::delete($outil->image_path);
            }
        }
        $outil->update(array_merge($request->all(), ['image_path' => $path ?? $outil->image_path]));
        $this->saveFiles($request, $outil);
        return redirect('outil/' . $request->input('rub') . '/' . $request->input('srub'))->with(['success' => $this->operation]);
    }

    public function destroy($id)
    {
        // Suppression de la FAQ
        $outil = Outil::findOrFail($id);
        try {
            $outil = Outil::with(['documents'])->findOrFail($id);
            if (!empty($outil->image_path)) {
                Storage::delete($outil->image_path);
            }
            // Delete images if any
            if ($outil->documents->isNotEmpty()) {
                Storage::delete($outil->images->pluck('path')->toArray());
                $outil->documents()->delete();
            }
        } catch (\Exception $e) {
            Log::error('Erreur lors de la suppression de l\'outil : ' . $e->getMessage());
            return back()->with('error', 'Une erreur est survenue : ' . $e->getMessage());
        }
        $outil->delete();

        return back()->with('success', $this->operation);
    }

    protected function saveFiles($request, $outil)
    {
        if ($request->hasFile('documents')) {
            foreach ($request->file('documents') as $fichier) {
                $path = $fichier->store('documents', 'public');
                $filename = $this->sanitizeFilename($fichier->getClientOriginalName());
                $outil->documents()->create(
                    [
                        'path' => $path,
                        'nom' => $filename
                    ]
                );
            }
        }
    }
}
