<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Examen;
use App\Models\User;
use App\Models\UserEleve;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register')->with(['controler'=>$this]);
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nom' => ['required', 'string'],
            'prenom' => ['required', 'string'],
            'identifiant' => ['required', 'string'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

       /*  $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user); */

        $user=new User();
        $user->nom=$request->input('nom');
        $user->prenom=$request->input('prenom');
        $user->telephone=$request->input('telephone');
        $user->email=$request->input('email');
        $user->identifiant=$request->input('identifiant');
        $user->actif=(request('actif')=='on')? true : false;
        $user->password=Hash::make($request->input('password'));
        $user->profil_id=2;
        try {
            $user->save();
        } catch (\Throwable $th) {
            return redirect()->back()->with(['error'=>$th->getMessage()]);
        }
        
        //event(new Registered($user));
        //Auth::login($user);
        
        //return redirect(RouteServiceProvider::HOME);
        return redirect("/");
    }
}
