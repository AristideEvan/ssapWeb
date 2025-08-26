<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use App\Models\Theme;
use Illuminate\Http\Request;

class ThemeController extends Controller
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
        $themes = Theme::orderBy('created_at', 'desc')->get();
        return view('theme.index')->with(['themes' => $themes, 'controler' => $this, 'rub' => $rub, 'srub' => $srub]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($rub, $srub)
    {
        return view('theme.create')->with(['rub' => $rub, 'srub' => $srub]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'themeLibelle' => ['required', 'string'],
        ]);

        $theme = new Theme();
        $theme->themeLibelle = $request->input('themeLibelle');
        $theme->save();

        return redirect('theme/' . $request->input('rub') . '/' . $request->input('srub'))->with(['success' => $this->operation]);
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
        $theme = Theme::find($id);
        return view('theme.edit')->with(['theme' => $theme, 'rub' => $rub, 'srub' => $srub]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'themeLibelle' => ['required', 'string'],
        ]);

        $theme = Theme::find($id);
        $theme->themeLibelle = $request->input('themeLibelle');
        $theme->save();

        return redirect('theme/' . $request->input('rub') . '/' . $request->input('srub'))->with(['success' => $this->operation]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        DB::table('pratiquethemes')->where('theme_id', $id)->delete();
        $theme = Theme::find($id);
        $theme->delete();
        return back();
    }
}
