<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\SolController;
use App\Http\Controllers\InitController;
use App\Http\Controllers\CarteController;
use App\Http\Controllers\GuideController;
use App\Http\Controllers\OutilController;
use App\Http\Controllers\ThemeController;
use App\Http\Controllers\ClimatController;
use App\Http\Controllers\PilierController;
use App\Http\Controllers\VisionController;
use App\Http\Controllers\AproposController;
use App\Http\Controllers\ContenuController;
use App\Http\Controllers\DomaineController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\LocaliteController;
use App\Http\Controllers\PratiqueController;
use App\Http\Controllers\TypeChocController;
use App\Http\Controllers\ActualiteController;
use App\Http\Controllers\Ajax\AjaxController;
use App\Http\Controllers\TypeoutilController;
use App\Http\Controllers\CommunauteController;
use App\Http\Controllers\PartenaireController;
use App\Http\Controllers\Params\MenuController;
use App\Http\Controllers\Params\UserController;
use App\Http\Controllers\StatistiqueController;
use App\Http\Controllers\TypeReponseController;
use App\Http\Controllers\BeneficiaireController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\TypeLocaliteController;
use App\Http\Controllers\Params\ActionController;
use App\Http\Controllers\Params\ProfilController;
use App\Http\Controllers\TypePartenaireController;
use App\Http\Controllers\SecteurActiviteController;
use App\Http\Controllers\TypeBeneficiaireController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/elearning', function () {
    //dd('ok');
    //ini_set('max_execution_time', 120);
    return redirect("http://vps-5d87716e.vps.ovh.net:9091/");
    //return redirect("10.4.21.239:9091");
});

Route::get('/info', function () {
    //ini_set('max_execution_time', 120);
    return phpinfo();
});

Route::get('/inituser/{identifiant}', [InitController::class, 'initUser'])->name('init.user');
Route::get('/', [WelcomeController::class, 'welcome']);

Route::get('nous.contacter/{rub}', function () {
    return view('dashboard');
});

Route::get('list-pratiques', [WelcomeController::class, 'listePratiques'])->name('pratique.list');
Route::get('list-pratiques/{rub}/{srub}', [WelcomeController::class, 'listePratiques']);
Route::get('details-pratiques/{pratique}', [WelcomeController::class, 'detailsPratique'])->name('pratique.details');

Route::get('nous.contacter', function () {
    return view('dashboard');
})->name('nous.contacter');

Route::get('/dashboard', function () {
    return view('dashboard', ['statistiques' => StatistiqueController::index()]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

Route::resource('action', ActionController::class);
Route::get('action/{rub}/{srub}', [ActionController::class, 'index']);
Route::get('action/create/{rub}/{srub}', [ActionController::class, 'create']);
Route::get('action/{id}/edit/{rub}/{srub}', [ActionController::class, 'edit']);


Route::resource('menu', MenuController::class);
Route::post('menu', [MenuController::class, 'store'])->name('menu.store');
Route::get('menu/{rub}/{srub}', [MenuController::class, 'index']);
Route::get('menu/create/{rub}/{srub}', [MenuController::class, 'create']);
Route::get('menu/{id}/edit/{rub}/{srub}', [MenuController::class, 'edit']);

Route::resource('profil', ProfilController::class);
Route::get('profil/{rub}/{srub}', [ProfilController::class, 'index']);
Route::get('profil/create/{rub}/{srub}', [ProfilController::class, 'create']);
Route::get('profil/{id}/edit/{rub}/{srub}', [ProfilController::class, 'edit']);

Route::resource('user', UserController::class);
Route::get('user/{rub}/{srub}', [UserController::class, 'index']);
Route::get('user/create/{rub}/{srub}', [UserController::class, 'create']);
Route::get('user/{id}/edit/{rub}/{srub}', [UserController::class, 'edit']);
Route::get('comptenonactif/{rub}/{srub}', [UserController::class, 'compteNonValide']);
Route::get('comptenonactif', [UserController::class, 'comptenonactif'])->name('comptenonactif');
Route::post('changerEtatCompte/{id}', [UserController::class, 'changerEtatCompte']);
Route::get('changerEtatCompte', [UserController::class, 'changerEtatCompte'])->name('changerEtatCompte');
Route::get('/editPass/{iduser}/{rub}/{srub}', [UserController::class, 'editPass']);
Route::post('saveEditPass/{id}', [UserController::class, 'saveEditPass']);

Route::get('/setVisibleMenu/{idmenu}', [AjaxController::class, 'setVisibleMenu']);

Route::resource('pilier', PilierController::class);
Route::get('pilier/{rub}/{srub}', [PilierController::class, 'index']);
Route::get('pilier/create/{rub}/{srub}', [PilierController::class, 'create']);
Route::get('pilier/{id}/edit/{rub}/{srub}', [PilierController::class, 'edit']);

Route::resource('secteurActivite', SecteurActiviteController::class);
Route::get('secteurActivite/{rub}/{srub}', [SecteurActiviteController::class, 'index']);
Route::get('secteurActivite/create/{rub}/{srub}', [SecteurActiviteController::class, 'create']);
Route::get('secteurActivite/{id}/edit/{rub}/{srub}', [SecteurActiviteController::class, 'edit']);

Route::resource('typeChoc', TypeChocController::class);
Route::get('typeChoc/{rub}/{srub}', [TypeChocController::class, 'index']);
Route::get('typeChoc/create/{rub}/{srub}', [TypeChocController::class, 'create']);
Route::get('typeChoc/{id}/edit/{rub}/{srub}', [TypeChocController::class, 'edit']);

Route::resource('typeReponse', TypeReponseController::class);
Route::get('typeReponse/{rub}/{srub}', [TypeReponseController::class, 'index']);
Route::get('typeReponse/create/{rub}/{srub}', [TypeReponseController::class, 'create']);
Route::get('typeReponse/{id}/edit/{rub}/{srub}', [TypeReponseController::class, 'edit']);

Route::resource('domaine', DomaineController::class);
Route::get('domaine/{rub}/{srub}', [DomaineController::class, 'index']);
Route::get('domaine/create/{rub}/{srub}', [DomaineController::class, 'create']);
Route::get('domaine/{id}/edit/{rub}/{srub}', [DomaineController::class, 'edit']);


Route::resource('typePartenaire', TypePartenaireController::class);
Route::get('typePartenaire/{rub}/{srub}', [TypePartenaireController::class, 'index']);
Route::get('typePartenaire/create/{rub}/{srub}', [TypePartenaireController::class, 'create']);
Route::get('typePartenaire/{id}/edit/{rub}/{srub}', [TypePartenaireController::class, 'edit']);


Route::resource('typeLocalite', TypeLocaliteController::class);
Route::get('typeLocalite/{rub}/{srub}', [TypeLocaliteController::class, 'index']);
Route::get('typeLocalite/create/{rub}/{srub}', [TypeLocaliteController::class, 'create']);
Route::get('typeLocalite/{id}/edit/{rub}/{srub}', [TypeLocaliteController::class, 'edit']);

Route::resource('typeBeneficiaire', TypeBeneficiaireController::class);
Route::get('typeBeneficiaire/{rub}/{srub}', [TypeBeneficiaireController::class, 'index']);
Route::get('typeBeneficiaire/create/{rub}/{srub}', [TypeBeneficiaireController::class, 'create']);
Route::get('typeBeneficiaire/{id}/edit/{rub}/{srub}', [TypeBeneficiaireController::class, 'edit']);


Route::resource('partenaire', PartenaireController::class);
Route::get('partenaire/{rub}/{srub}', [PartenaireController::class, 'index']);
Route::get('partenaire/create/{rub}/{srub}', [PartenaireController::class, 'create']);
Route::get('partenaire/{id}/edit/{rub}/{srub}', [PartenaireController::class, 'edit']);


Route::resource('beneficiaire', BeneficiaireController::class);
Route::get('beneficiaire/{rub}/{srub}', [BeneficiaireController::class, 'index']);
Route::get('beneficiaire/create/{rub}/{srub}', [BeneficiaireController::class, 'create']);
Route::get('beneficiaire/{id}/edit/{rub}/{srub}', [BeneficiaireController::class, 'edit']);


Route::resource('localite', LocaliteController::class);
Route::get('localite/{rub}/{srub}', [LocaliteController::class, 'index']);
Route::get('localite/create/{rub}/{srub}', [LocaliteController::class, 'create']);
Route::get('localite/{id}/edit/{rub}/{srub}', [LocaliteController::class, 'edit']);

Route::resource('pratique', PratiqueController::class);
Route::get('pratique/{rub}/{srub}', [PratiqueController::class, 'index']);
Route::get('pratique/create/{rub}/{srub}', [PratiqueController::class, 'create']);
Route::get('pratique/{id}/edit/{rub}/{srub}', [PratiqueController::class, 'edit']);
Route::get('pratique/{id}/section/{section}/edit/{rub}/{srub}', [PratiqueController::class, 'editSection'])->name('pratique.section.edit');
Route::patch('pratique/{id}/section/{section}/edit/{rub}/{srub}', [PratiqueController::class, 'updateSection'])->name('pratique.section.update');
Route::get('pratique/{id}/show/{rub}/{srub}', [PratiqueController::class, 'show']);

Route::resource('sol', SolController::class);
Route::get('sol/{rub}/{srub}', [SolController::class, 'index']);
Route::get('sol/create/{rub}/{srub}', [SolController::class, 'create']);
Route::get('sol/{id}/edit/{rub}/{srub}', [SolController::class, 'edit']);

Route::resource('climat', ClimatController::class);
Route::get('climat/{rub}/{srub}', [ClimatController::class, 'index']);
Route::get('climat/create/{rub}/{srub}', [ClimatController::class, 'create']);
Route::get('climat/{id}/edit/{rub}/{srub}', [ClimatController::class, 'edit']);

Route::resource('theme', ThemeController::class);
Route::get('theme/{rub}/{srub}', [ThemeController::class, 'index']);
Route::get('theme/create/{rub}/{srub}', [ThemeController::class, 'create']);
Route::get('theme/{id}/edit/{rub}/{srub}', [ThemeController::class, 'edit']);

Route::resource('typeoutil', TypeoutilController::class);
Route::get('typeoutil/{rub}/{srub}', [TypeoutilController::class, 'index']);
Route::get('typeoutil/create/{rub}/{srub}', [TypeoutilController::class, 'create']);
Route::get('typeoutil/{id}/edit/{rub}/{srub}', [TypeoutilController::class, 'edit']);

Route::resource('carte', CarteController::class);
Route::get('carte/{rub}/{srub}', [CarteController::class, 'index'])->middleware('auth');
Route::get('showMap', [CarteController::class, 'showMap'])->name('carte.showMap');


Route::get('localites/children/{rub}/{srub}', [CarteController::class, 'getLocalitesByParent']);

Route::get('formulaire/{zone_type}/{localite_id?}', [AjaxController::class, 'getZoneForm'])->whereNumber('localite_id')->whereIn('type_zone', [1, 2]);
Route::post('update-pratiques/{rub}/{srub}', [AjaxController::class, 'updatePratiques']);
Route::get('localite-with-pratiques/{localite_id}', [AjaxController::class, 'getLocaliteWithPratiques'])->whereNumber('localite_id')->name('pratiques.localites');
Route::get('pratique-with-zones/{pratique_id}', [AjaxController::class, 'getPratiqueWithZones'])->whereNumber('pratique_id')->name('pratiques.zones');
Route::get('pratique-all', [AjaxController::class, 'getAllPratiques'])->name('pratiques.all');


Route::get('lesparents', [CarteController::class, 'lesparents']);
Route::get('localites/pratiques/{rub}/{srub}', [CarteController::class, 'getPratiqueParLocalite']);
Route::post('/meslocalite', [CarteController::class, 'processLocalite']);

Route::get('pratiques/{rub}/{srub}/filter', [AjaxController::class, 'getFilteredPratiques'])->name('pratiques.filter');
Route::get('/biblioteque/{id}', [WelcomeController::class, 'afficherDomaine'])->name('biblioteque');



Route::get('init', [CarteController::class, 'initialisemap']);
Route::get('pays/{rub}/{srub}', [CarteController::class, 'paysetfils']);
Route::get('preatiqueselected/{rub}/{srub}', [CarteController::class, 'pratiques']);
Route::get('localit/{rub}/{srub}', [CarteController::class, 'localite']);
Route::get('clima/{rub}/{srub}', [CarteController::class, 'climat']);
Route::get('sols/{rub}/{srub}', [CarteController::class, 'sol']);
Route::get('ptheme/{rub}/{srub}', [CarteController::class, 'theme']);
Route::get('pdomaine/{rub}/{srub}', [CarteController::class, 'domaine']);



Route::resource('faq', FaqController::class);
Route::get('faq/{rub}/{srub}', [FaqController::class, 'index']);
Route::get('faq/create/{rub}/{srub}', [FaqController::class, 'create']);
Route::get('faq/{id}/edit/{rub}/{srub}', [FaqController::class, 'edit']);

Route::resource('page', PageController::class);
Route::get('page/{rub}/{srub}', [PageController::class, 'index']);
Route::get('page/create/{rub}/{srub}', [PageController::class, 'create']);
Route::get('page/{id}/edit/{rub}/{srub}', [PageController::class, 'edit']);


Route::resource('actualite', ActualiteController::class);
Route::get('actualite/{rub}/{srub}', [ActualiteController::class, 'index']);
Route::get('actualite/create/{rub}/{srub}', [ActualiteController::class, 'create']);
Route::get('actualite/{id}/edit/{rub}/{srub}', [ActualiteController::class, 'edit']);
Route::get('liste-actualites', [WelcomeController::class, 'listeActualites'])->name('actualites.liste');
Route::get('details-actualite/{id}', [WelcomeController::class, 'DetailsActualite'])->name('actualites.details');

Route::resource('communaute', CommunauteController::class);
Route::get('communaute/{rub}/{srub}', [CommunauteController::class, 'index']);
Route::get('communaute/create/{rub}/{srub}', [CommunauteController::class, 'create']);
Route::get('communaute/{id}/edit/{rub}/{srub}', [CommunauteController::class, 'edit']);
Route::get('communautes', [WelcomeController::class, 'communautes'])->name('communautes');

Route::resource('outil', OutilController::class);
Route::get('outil/{rub}/{srub}', [OutilController::class, 'index']);
Route::get('outil/create/{rub}/{srub}', [OutilController::class, 'create']);
Route::get('outil/{id}/edit/{rub}/{srub}', [OutilController::class, 'edit']);
Route::get('outils', [WelcomeController::class, 'outils'])->name('outils');
Route::get('details-outils/{id}', [WelcomeController::class, 'DetailsOutils'])->name('outils.details');
Route::post('outils/filter', [AjaxController::class, 'getFilteredOutils'])->name('outils.filter');

Route::get('contact', [WelcomeController::class, 'contactPage'])->name('contact');
Route::post('contact', [WelcomeController::class, 'sendMessage']);
Route::post('get-theme-domains', [AjaxController::class, 'getThemeDomains'])->name('themes.domains');
Route::get('/showtheme', [CarteController::class, 'showTheme']);
Route::get('plus/section/{?id}', [WelcomeController::class, 'readMore'])->name('readmore');
Route::get('plus/section/{section?}/{id?}', [WelcomeController::class, 'readMore'])->name('readmore');

