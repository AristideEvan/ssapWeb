<?php

namespace App\Http\Controllers;

use App\Models\Action;
use App\Models\Actionmenu;
use App\Models\Menu;
use App\Models\Profilmenu;
use App\Models\Profilmenuaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class InitController extends Controller
{
    public function initUser($identifiant)
    {
        $user =  new User();

        $user->profil_id=1;
        $user->nom=$identifiant;
        $user->prenom=$identifiant;
        $user->telephone='00000000';
        $user->identifiant = $identifiant;
        $user->email =$identifiant.'@'.$identifiant.'.com';
        $user->actif= true;
        $user->password = Hash::make($identifiant);
        $user->save();

        $tableau=Menu::all();
        if(!empty($tableau)){
            foreach($tableau as $tab){
                $userMenu=new Profilmenu();
                $userMenu->menu_id=$tab->id;
                $userMenu->profil_id=1;
                $userMenu->save();
                $actions=Action::all();
                $actionmenus = Actionmenu::where('menu_id',$tab->id)->get();
                if(count($actionmenus)==0){
                    foreach($actions as $actionid){
                        $actionMenu = new Actionmenu();
                        $actionMenu->action_id= $actionid->id;
                        $actionMenu->menu_id= $tab->id;
                        $actionMenu->save();
                    }
                }
                if(!empty($actions)){
                    foreach($actions as $actionid){
                        $actionUserMenu = new Profilmenuaction();
                        $actionUserMenu->profil_id= 1;
                        $actionUserMenu->action_id= $actionid->id;
                        $actionUserMenu->menu_id= $tab->id;
                        $actionUserMenu->save();
                    }
                }
            
            }
        }
        return back()->with('success', 'Opération effectuée avec succès.');
    }
}
