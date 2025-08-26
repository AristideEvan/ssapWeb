<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Faq;
use App\Models\Page;
use App\Mail\Message;
use App\Models\Outil;
use App\Models\Theme;
use App\Models\Pilier;
use App\Models\Domaine;
use App\Models\Localite;
use App\Models\Pratique;
use App\Models\TypeChoc;
use App\Models\Actualite;
use App\Models\Typeoutil;
use App\Models\Communaute;
use App\Models\Partenaire;
use App\Models\TypeReponse;
use App\Models\Beneficiaire;
use App\Models\TypeLocalite;
use Illuminate\Http\Request;
use App\Models\SecteurActivite;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class WelcomeController extends Controller
{

    public function welcome()
    {
        $rub = 2;
        $srub = 3;
        $pratiquesList = Pratique::where("publique", true)->get();
        $pratiques = $this->getVedettePratiques();
        $countPratiquePays = $this->countPaysAvecPratiques();
        $faqs = Faq::all();
        $page = Page::first();
        // dd($page->images[0]->path);
        $partenaires = Partenaire::all();
        $statistiques = StatistiqueController::getStatisquesByPays();
        return view('welcome')->with([
            "rub" => $rub,
            "srub" => $srub,
            "pratiques" => $pratiques,
            "statistiques" => $statistiques,
            "pratiquesList" => $pratiquesList,
            "faqs" => $faqs,
            "page" => $page,
            "partenaires" => $partenaires,
            'countPratiquePays' => $countPratiquePays,
            'countRessources' => Outil::where('publique', true)->count()
        ]);
    }

    public function getVedettePratiques()
    {
        $pratiques = Pratique::where('publique', true)->latest()->take(VEDETTE_LIMIT)->get();
        return $pratiques;
    }

    public function listePratiques()
    {
        $rub = 2;
        $srub = 3;
        $pratiquesListe = Pratique::where("publique", true)->get();
        return view('pratique.list')->with(["rub" => $rub, "srub" => $srub, 'pratiquesListe' => $pratiquesListe]);
    }

    public function detailsPratique(Pratique $pratique)
    {
        if (!$pratique->publique) {
            abort(404);
        }
        $pratique->load([
            'zonesActuelles',
            'zonesPotentielles',
            'domaines',
            'reponses',
            'piliers',
            'typesChocs',
            'secteurs',
            'beneficiaires',
            'partenaires',
            'images',
            'documents',
            'sols',
            'climats',
            'themes'
        ]);
        $pays_id = TypeLocalite::where('typeLocaliteLibelle', LEVEL0_LABEL)->firstOrFail()->typeLocalite_id;
        $pays = Localite::where('typeLocalite_id', $pays_id)->get();
        $data = $this->getFormData();
        $pratique->setImagesUrls();
        $pratique->setDocumentsUrls();
        $data['pratique'] = $pratique;
        $data['pays'] = $pays;
        $localites = $pratique->zonesActuelles;
        $data  = array_merge($data, ['zones' => $localites]);
        return view('pratique.details', $data);
    }

    protected function getFormData()
    {

        $localites = Localite::all();
        $localites->each(
            function ($localite) {
                $localite->parents = $localite->parents;
            }
        );
        return [
            'pratique' => null,
            'domaines' => Domaine::all(),
            'piliers' => Pilier::all(),
            'secteurs' => SecteurActivite::all(),
            'partenaires' => Partenaire::all(),
            'typeChocs' => TypeChoc::all(),
            'typeReponses' => TypeReponse::all(),
            'localites' => $localites,
            'typeLocalites' => TypeLocalite::all(),
            'beneficiaires' => Beneficiaire::all(),
        ];
    }
    public function afficherDomaine($id)
    {
        $rub = 2;
        $srub = 3;

        // Récupérer le domaine avec l'ID spécifié
        $domaine = Theme::findOrFail($id);

        // Récupérer les pratiques associées à ce domaine en utilisant la vue avec pagination
        $pratiques = DB::table('viewPratiqueThemeLocalite')
            ->where('theme_id', $id)
            ->paginate(5); // Paginer par 5 éléments par page

        // Ajouter les URLs pour vedette_path et premier_document_path
        $pratiques->each(function ($pratique) {
            $pratique->vedette_url = !empty($pratique->vedette_path) ? asset('storage/' . $pratique->vedette_path) : '';
            $pratique->premier_document_url = !empty($pratique->premier_document_path) ? asset('storage/' . $pratique->premier_document_path ?? '') : '';
        });

        // Compter le nombre de pratiques
        $nombrePratiques = $pratiques->total();

        return view('biblioteque')->with([
            'rub' => $rub,
            'srub' => $srub,
            'domaine' => $domaine,
            'pratiques' => $pratiques,
            'nombrePratiques' => $nombrePratiques
        ]);
    }

    public function listeActualites()
    {
        $actualites = Actualite::where('publique', true)->latest()->get();
        return view('actualite.list')->with(['actualites' => $actualites]);
    }

    public function detailsActualite($id)
    {
        $actualite = Actualite::findOrFail($id);
        return view('actualite.show')->with(['actualite' => $actualite]);
    }

    public function communautes()
    {
        $communautes = Communaute::latest()->get();
        $page = Page::select('communautes_img_path')->first();
        return view('communaute.show')->with(['communautes' => $communautes, 'communautes_img_path' => $page->communautes_img_path ?? '']);
    }

    public function outils()
    {
        $outils = Outil::where('publique', true)->latest()->get();
        $typeOutils = Typeoutil::all();
        return view('outil.list')->with(['outils' => $outils, 'typeOutils' => $typeOutils]);
    }

    public function detailsOutils($id)
    {
        $outil = Outil::with(['documents'])->findOrFail($id);
        $outil->setDocumentsUrls();
        return view('outil.show')->with(['outil' => $outil]);
    }

    public function contactPage()
    {
        return view('contact.index');
    }
    public function sendMessage(Request $request)
    {
        // Validation des champs
        $validator = Validator::make($request->all(), [
            'name'    => 'required|string|max:100',
            'subject' => 'required|string|max:200',
            'message' => 'required|string',
            'email'   => 'required|email',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            Mail::to(env('MAIL_ADDRESS_TO'))->send(
                new Message(
                    $request->input('name'),
                    $request->input('subject'),
                    $request->input('message'),
                    $request->input('email')
                )
            );
            return back()->with('success', 'Email envoyé avec succès !');
        } catch (Exception $e) {
            return back()->with('error', 'Erreur lors de l\'envoi de l\'email. Veuillez ressayer plus tard.')->withInput();
        }
    }

    public function readMore(Request $request)
    {
        $page = Page::findOrFail(1);
        $section = $request->section;
        $id = $request->section_id;
        $titre = $section;

        $img_path = match ($section) {
            'apropos' => asset('storage/' . $page->apropos_img_path),
            default => asset('img/mais1600x1200.png')
        };

        $titre = match ($section) {
            'apropos' => 'A propos',
            default => $section
        };

        $content = $page->$section;
        return view('page.plus', compact('content', 'titre', 'img_path'));
    }

    public function countPaysAvecPratiques()
    {
        $sql = '
        SELECT COUNT(DISTINCT l."p0") AS total_pays
        FROM "pratiques" p
        JOIN "pratiquezoneapplis" z ON p."pratique_id" = z."pratique_id"
        JOIN "listeLocalite" l ON l."localite_id" = z."localite_id"
        WHERE p."deleted_at" IS NULL
    ';

        $result = DB::selectOne($sql);
        return $result->total_pays;
    }
}
