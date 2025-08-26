<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        
        $request->authenticate();
       
        $request->session()->regenerate();
        $user=User::find(Auth()->user()->id);
        $this->userMenus($request);
        return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function userMenus(Request $request){
        if ($request->hasSession()) {
            $request->session()->put('auth.password_confirmed_at', time());
            $tableau=[];
            $tableauFront=[];
            $idBon='';
            $localisation = [];
            $menus=DB::table('menus')
                ->select('menus.*')
                ->selectRaw('\'template\' AS template')
                ->join('profilmenus','profilmenus.menu_id','=','menus.id')
                ->where(['profilmenus.profil_id'=>Auth()->user()->profil_id,'visible'=>true])
                ->whereIn('interface',[1,3])
                ->orderBy('ordre','ASC')
                ->get();
                foreach($menus as $parent){
                    if($parent->parent_id==NULL){
                        $tableau[$parent->id][0]=$parent;
                    }else{
                        $tableau[$parent->parent_id][1][$parent->id][0]=$parent;
                        $actionMenu=DB::table('actions')
                            ->select('actions.*')
                            ->join('profilmenuactions','profilmenuactions.action_id','=','actions.id')
                            ->where(['profilmenuactions.menu_id'=>$parent->id,
                            'profilmenuactions.profil_id'=>Auth()->user()->profil_id])
                            ->get();
                        $actions=[];
                        foreach($actionMenu as $action){
                            $actions[] = $action->nomAction;
                        }
                        $tableau[$parent->parent_id][1][$parent->id][1]=$actions;
                    }
                }

            $menusFront=DB::table('menus')
                ->select('menus.*')
                ->selectRaw('\'front\' AS template')
                ->join('profilmenus','profilmenus.menu_id','=','menus.id')
                ->where(['profilmenus.profil_id'=>Auth()->user()->profil_id,'visible'=>true])
                ->whereIn('interface',[2,3])
                ->orderBy('ordre','ASC')
                ->get();
                foreach($menusFront as $parent){
                    if($parent->parent_id==NULL){
                        $tableauFront[$parent->id][0]=$parent;
                    }else{
                        $tableauFront[$parent->parent_id][1][$parent->id][0]=$parent;
                        $actionMenu=DB::table('actions')
                            ->select('actions.*')
                            ->join('profilmenuactions','profilmenuactions.action_id','=','actions.id')
                            ->where(['profilmenuactions.menu_id'=>$parent->id,
                            'profilmenuactions.profil_id'=>Auth()->user()->profil_id])
                            ->get();
                        $actions=[];
                        foreach($actionMenu as $action){
                            $actions[] = $action->nomAction;
                        }
                        $tableauFront[$parent->parent_id][1][$parent->id][1]=$actions;
                    }
                }
            $user=User::find(Auth()->user()->id);
            Session::put('menus', $tableau);
            Session::put('menusFront', $tableauFront);
            Session::put('user', $user);
            //Session::put('localisation',$localisation);
        }
    }
}
