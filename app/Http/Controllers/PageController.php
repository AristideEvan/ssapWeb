<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PageController extends Controller
{
    private $operation = 'Opération effectuée avec succès';

    protected $rules = [
        'apropos' => 'required|string',
        'objectif' => 'required|string',
        'but' => 'required|string',
        'contenu' => 'required|string',
        'guide' => 'required|string',
        'communautes_img' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'apropos_img' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'carousel_img' => 'required|array',
        'carousel_img.*' => 'image|mimes:jpeg,png,jpg|max:2048',
    ];


    public function index($rub, $srub)
    {
        $page = Page::first();
        return view('page.index')->with(['page' => $page, 'controler' => $this, "rub" => $rub, "srub" => $srub]);
    }


    public function create($rub, $srub)
    {
        return view('page.create')->with(["rub" => $rub, "srub" => $srub]);
    }

    public function store(Request $request)
    {

        $request->validate($this->rules);
        $communautes_img_path = $request->hasFile('communautes_img') ? $request->file('communautes_img')->store('images', 'public') : null;
        $apropos_img_path = $request->hasFile('apropos_img') ? $request->file('apropos_img')->store('images', 'public') : null;
        $page = Page::create([
            'apropos' => $request->input('apropos'),
            'but' => $request->input('but'),
            'objectif' => $request->input('objectif'),
            'contenu' => $request->input('contenu'),
            'guide' => $request->input('guide'),
            'apropos_img_path' => $apropos_img_path,
            'communautes_img_path' => $communautes_img_path,
        ]);
        $this->saveFiles($request, $page);
        return redirect('page/' . $request->input('rub') . '/' . $request->input('srub'))->with(['success' => $this->operation]);
    }

    public function edit($id, $rub, $srub)
    {
        $page = Page::with('images')->firstOrFail();
        $page->setImagesUrls([
            'communautes_image' => $page->communautes_img_path,
            'apropos_image' => $page->apropos_img_path,
        ], true);
        return view('page.edit')->with(['page' => $page, "rub" => $rub, "srub" => $srub]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'apropos' => 'required|string',
            'objectif' => 'required|string',
            'but' => 'required|string',
            'contenu' => 'required|string',
            'guide' => 'required|string',
            'communautes_img' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'apropos_img' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'removed_apropos_img' => 'nullable|string',
            'carousel_img' => 'nullable|array',
            'carousel_img.*' => 'image|mimes:jpeg,png,jpg|max:2048',
            'removed_carousel_img' => 'nullable|array',
            'removed_carousel_img.*' => 'string',
        ]);
        $page = Page::findOrFail($id);
        if ($request->hasFile('communautes_img')) {
            $communautes_img_path = $request->file('communautes_img')->store('images', 'public');
            if (!empty($page->communautes_img)) {
                Storage::delete($page->communautes_img);
            }
        }
        if ($request->hasFile('apropos_img')) {
            $apropos_img_path = $request->file('apropos_img')->store('images', 'public');
            if (!empty($page->apropos_img)) {
                Storage::delete($page->apropos_img);
            }
        }
        $page->update([
            'apropos' => $request->input('apropos'),
            'but' => $request->input('but'),
            'objectif' => $request->input('objectif'),
            'contenu' => $request->input('contenu'),
            'guide' => $request->input('guide'),
            'apropos_img_path' => $apropos_img_path ?? $page->apropos_img_path,
            'communautes_img_path' => $communautes_img_path ?? $page->communautes_img_path,
        ]);
        // save carousel images
        $this->saveFiles($request, $page);
        if ($request->removed_apropos_img) {
            $path = $this->getPathFromStr($request->removed_apropos_img);
            Storage::disk('public')->delete($path);
            $page->apropos_img_path = null;
            $page->save();
        }
        foreach ($request->removed_carousel_img ?? [] as $imagePath) {
            if (Storage::disk('public')->exists($imagePath)) {
                $page->images()->where('path', $imagePath)->first()->delete();
                Storage::delete($imagePath);
            }
        }
        return redirect('page/' . $request->input('rub') . '/' . $request->input('srub'))->with(['success' => $this->operation]);
    }

    protected function saveFiles($request, $page)
    {
        if ($request->hasFile('carousel_img')) {
            foreach ($request->file('carousel_img') as $fichier) {
                try {
                    $path = $fichier->store('images', 'public');
                    $filename = $this->sanitizeFilename($fichier->getClientOriginalName()); // Assurez-vous que cette fonction est correctement implémentée
                    $page->images()->create([
                        'path' => $path,
                        'nom' => $filename,
                    ]);
                } catch (\Exception $e) {
                    Log::error('Erreur lors du stockage de l\'image carousel : ' . $e->getMessage());
                    // Gérer l'erreur, par exemple, en renvoyant un message à l'utilisateur
                }
            }
        }
    }

    public function getPathFromStr(string $str)
    {
        if (filter_var($str, FILTER_VALIDATE_URL) === false) {
            return $str;
        } else {
            $pathParts = parse_url($str);
            if (isset($pathParts['path'])) {
                $path = ltrim($pathParts['path'], '/');
                if (strpos($path, 'storage/') === 0) {
                    $path = substr($path, strlen('storage/'));
                }
                return $path;
            } else {
                return null;
            }
        }
    }
}
