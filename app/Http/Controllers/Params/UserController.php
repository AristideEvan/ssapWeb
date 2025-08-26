<?php

namespace App\Http\Controllers\Params;

use App\Models\User;
use App\Models\Profil;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
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
     *
     * @return \Illuminate\Http\Response
     */
    public function index($rub, $srub)
    {
        $users = User::orderby('created_at', 'DESC')->get();
        $tabParam[0] = $this->parametre_exists($rub, $srub, "ATTRIBUER_ACTION");
        $tabParam[1] = $this->parametre_exists($rub, $srub, "MODIFIER_PASS_USER");
        //$tabParam[2]=$this->parametre_exists($rub,$srub,"MODIFIER_PASS_USER");
        //$tabParam[2]=$this->parametre_exists($rub,$srub,"MODIFIER_PASS_USER");
        return view('user.index')->with(['users' => $users, 'tabParam' => $tabParam, "controler" => $this, "rub" => $rub, "srub" => $srub]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request, $rub, $srub)
    {
        $profils = Profil::all();
        return view('user.create')->with(['controler' => $this, "profils" => $profils, "rub" => $rub, "srub" => $srub]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate(
            $request,
            [
                'password' => ['required', 'string', 'min:5', 'confirmed', Rules\Password::defaults()],
                'identifiant' => [
                    'required',
                    Rule::unique('users')->whereNull('deleted_at')
                ],
                // 'identifiant' => ['required', 'string','unique:users'],
            ],
            [
                'identifiant.unique' => 'Cet identifiant est déja utilisée !'
            ]
        );

        $user = new User();
        $user->nom = $request->input('nom');
        $user->prenom = $request->input('prenom');
        $user->telephone = $request->input('telephone');
        $user->email = $request->input('email');
        $user->identifiant = $request->input('identifiant');
        $user->actif = (request('actif') == 'on') ? true : false;
        $user->profil_id = $request->input('profil');
        $user->password = Hash::make($request->input('password'));
        //$user->user_id=Auth()->user()->id;
        $user->save();
        return redirect('user/' . $request->input('rub') . '/' . $request->input('srub'))->with(['success' => $this->operation]);
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
    public function edit($idUser, $rub, $srub)
    {
        $profils = Profil::all();
        $user = User::find($idUser);
        return view('user.edit')->with([
            'controler' => $this,
            'rub' => $rub,
            'srub' => $srub,
            'user' => $user,
            'profils' => $profils
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $userId)
    {
        $this->validate(
            $request,
            [
                //'password' => ['required','string','min:5'],
                // 'identifiant' => ['required', 'string', 'unique:users,identifiant,' . $userId],
                'identifiant' => [
                    'required',
                    Rule::unique('users')->ignore($userId)->whereNull('deleted_at')
                ],
            ],
            // [
            //     'identifiant.unique' => 'Cet identifiant est déja utilisée !'
            // ]
        );

        $user = User::find($userId);
        $user->nom = $request->input('nom');
        $user->prenom = $request->input('prenom');
        $user->telephone = $request->input('telephone');
        $user->email = $request->input('email');
        $user->identifiant = $request->input('identifiant');
        $user->profil_id = $request->input('profil');
        $user->actif = (request('actif') == 'on') ? true : false;
        //$user->password=Hash::make($request->input('password'));
        $user->user_id = Auth()->user()->id;
        $user->save();

        return redirect('user/' . $request->input('rub') . '/' . $request->input('srub'))->with(['success' => $this->operation]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);
        $user->delete();

        return back()->with(['success' => $this->operation]);
    }

    /* public function addRemoveRole($idUser,$rub = null, $srub=null){
        $user = User::find($idUser);

        $tableauMenuComp=[];
        $actions=Action::orderby('nomAction','asc')->get();
        $parentMenus=Menu::orderby('id','ASC')->get();

        foreach($parentMenus as $parent){
            if($parent->parentMenu_id==NULL){
                $tableauMenuComp[$parent->id][0]=$parent;
            }else{
                $tableauMenuComp[$parent->parentMenu_id][1][$parent->id][0]=$parent;
                $actionMenu=DB::table('actions')
                    ->select('actions.*')
                    ->join('actionmenus','actionmenus.action_id','=','actions.id')
                    ->where('actionmenus.menu_id',$parent->id)
                    ->get();
                $tableauMenuComp[$parent->parentMenu_id][1][$parent->id][1]=$actionMenu;
            }
        }
        

        $tableauMenusUser=[];
        $menusUsers=DB::table('menus')
        ->select('menus.*')
        ->join('usermenus','usermenus.menu_id','=','menus.id')
        ->where('usermenus.user_id',$idUser)
        ->get();

        foreach($menusUsers as $parent){
            if($parent->parentMenu_id==NULL){
                $tableauMenusUser[$parent->id][0]=$parent;
            }else{
                //$tableau[$parent->parentMenu_id][1][]=$parent;
                $tableauMenusUser[$parent->parentMenu_id][1][$parent->id][0]=$parent;
                $actionMenu=DB::table('actions')
                    ->select('actions.*')
                    ->join('usermenuactions','usermenuactions.action_id','=','actions.id')
                    ->where(['usermenuactions.menu_id'=>$parent->id,
                    'usermenuactions.user_id'=>$idUser])
                    ->get();
                $actions=[];
                foreach($actionMenu as $action){
                    $actions[] = $action->id;
                }
                $tableauMenusUser[$parent->parentMenu_id][1][$parent->id][1]=$actions;
            }
        }
        
        return view('user.addRemoveRole')->with(['menusComplet'=>$tableauMenuComp,'controler'=>$this,'rub'=>$rub,'srub'=>$srub,
            'menusUser'=>$tableauMenusUser,'user'=>$user]);
    } */

    /* public function saveAddRemoveRole($userId, Request $request){
        $user = User::find($userId);
        $user->actif = (request('actif')=='on')? true : false;
        $user->save();

        $tableau=$request->input('menu');
        $table=[];
        if(!empty($tableau)){
            DB::delete('delete from usermenus where user_id=?',[$userId]);
            DB::delete('delete from usermenuactions where user_id=?',[$userId]);
            foreach($tableau as $tab){
                $userMenu=new Usermenu();
                $userMenu->menu_id=$tab;
                $userMenu->user_id=$userId;
                $userMenu->save();
                $actions=$request->input($tab);
                if(!empty($actions)){
                    foreach($actions as $actionid){
                        $actionUserMenu = new Usermenuaction();
                        $actionUserMenu->user_id= $userId;
                        $actionUserMenu->action_id= $actionid;
                        $actionUserMenu->menu_id= $tab;
                        $actionUserMenu->save();
                    }
                }
            }
        }
        return redirect('user/'.$request->input('rub').'/'.$request->input('srub'))->with(['success'=>$this->operation]);
    } */


    public function editPass($idUser, $rub = null, $srub = null)
    {
        $user = User::find($idUser);
        return view('user.editPass')->with(['controler' => $this, 'rub' => $rub, 'srub' => $srub, 'user' => $user]);
    }

    public function saveEditPass($idUser, Request $request)
    {
        $this->validate(
            $request,
            [
                'password' => ['required', 'string', 'min:5', 'confirmed', Rules\Password::defaults()],
                //'identifiant' => ['required', 'string','unique:users,identifiant,'. $idUser],
            ],
            [
                'identifiant.unique' => 'Cet identifiant est déja utilisée !'
            ]
        );

        $user = User::find($idUser);
        /* $user->nom=$request->input('nom');
        $user->prenom=$request->input('prenom');
        $user->telephone=$request->input('telephone');
        $user->email=$request->input('email');
        $user->identifiant=$request->input('identifiant');
        $user->actif=(request('actif')=='on')? true : false; */
        $user->password = Hash::make($request->input('password'));
        //$user->user_id=Auth()->user()->id;
        $user->save();

        return redirect('user/' . $request->input('rub') . '/' . $request->input('srub'))->with(['success' => $this->operation]);
    }

    public function compteNonValide($rub = null, $srub = null)
    {

        $users = User::where('actif', false)->orderBy('created_at', 'DESC')->get();
        return view('user.nonvalider')->with(['users' => $users, 'controler' => $this, "rub" => $rub, "srub" => $srub]);
    }

    public function changerEtatCompte($id)
    {
        $user = User::find($id);
        if ($user->actif == true) {
            $user->actif = false;
        } else {
            $user->actif = true;
        }

        $user->save();

        return redirect()->back()->with(['success' => $this->operation]);
    }
}
