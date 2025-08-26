<?php
// utilisateur 

use App\Models\Profil;
use App\Models\Localite;
use App\Models\TypeLocalite;
use App\Models\Domaine;
use App\Models\Pratiquedomaine;
use App\Models\Pratiqueclimat;
use App\Models\Pratiquesol;
use App\Models\Theme;
use App\Models\Pratiquetheme;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

define('ADMIN_PROFILES', ['Root', 'Admin']);
define('CAN_PUBLIC_PROFILES', ['Root', 'PUBLICATION']);
define('VEDETTE_LIMIT', 5);
define('LEVEL0_LABEL', 'PAYS');

function username()
{
    return auth()->user()->prenom . " " . auth()->user()->nom;
}
function useremail()
{
    return auth()->user()->email;
}
function userlogin()
{
    return auth()->user()->identifiant;
}
function usertelephone()
{
    return auth()->user()->telephone;
}
function userpassword()
{
    return auth()->user()->password;
}

function profil_id()
{
    return auth()->user()->profil_id;
}

// Menu 

function setMenuOpen($route)
{
    if (request()->route()->getName() === $route) {
        return "menu-open";
    }
    return "";
}

function root()
{
    $root = explode('/', request()->server('REQUEST_URI'))[1];
    return $root;
}

function root1($route = null)
{
    //$root = explode('/',request()->server('REQUEST_URI'))[1];
    return $route;
}

function getTemplate($rb, $srb)
{
    //dd(session('menus')[$rb][1][$srb][0]->template);
    $rub = explode('-', $rb);
    $srub = explode('-', $srb);
    //dd($srub);
    return (array_key_exists(1, $srub) && $srub[1] == 1) ? 'front' : 'template';
    //return session('menus')[$rub][1][$srub][0]->template;
}

function integerToDate($integer)
{
    $date = new DateTime();
    return $date->setTimestamp($integer)->format('d-m-Y');
}

function canMakePublic($user = null)
{
    if (empty($user)) {
        return false;
    }
    $profile = Profil::find($user->profil_id);
    if (in_array($profile->nomProfil, CAN_PUBLIC_PROFILES)) {
        return true;
    }
    return false;
}

function getLocalites($localite_ids)
{
    $single = !is_array($localite_ids);
    if ($single) {
        $localite_ids = [$localite_ids];
    }
    $placeholders = implode(',', array_fill(0, count($localite_ids), '?'));
    $localites = DB::select(
        'SELECT "nomLocalite" FROM "listeLocalite" WHERE "localite_id" IN (' . $placeholders . ')',
        $localite_ids
    );
    $names = array_map(function ($localite) {
        return $localite->nomLocalite;
    }, $localites);
    return $single ? (count($names) > 0 ? $names[0] : null) : $names;
}



function formatCurrency($amount, $currency = 'XOF')
{
    $locale = app()->getLocale();
    $formatter = new NumberFormatter($locale, NumberFormatter::CURRENCY);
    return $formatter->formatCurrency($amount, $currency);
}

function getPays()
{
    $pays_id = TypeLocalite::where('typeLocaliteLibelle', LEVEL0_LABEL)->firstOrFail()->typeLocalite_id;
    $pays = Localite::where('typeLocalite_id', $pays_id)->get();
    return $pays;
}

function isAdmin($user = null)
{
    if (empty($user)) {
        return false;
    }
    $profile = Profil::find($user->profil_id);
    if (in_array($profile->nomProfil, ADMIN_PROFILES)) {
        return true;
    }
    return false;
}


function getFileIcon($fileExtension)
{
    $iconMap = [
        'pdf' => 'pdf-icon.png',
        'docx' => 'word-icon.png',
        'doc' => 'word-icon.png',
        'txt' => 'text-icon.png',
        'xlsx' => 'excel-icon.png',
        'xls' => 'excel-icon.png',
        'zip' => 'zip-icon.png',
        'default' => 'file-icon.png',
    ];
    return asset('img/icons/' . ($iconMap[$fileExtension] ?? $iconMap['default']));
}

function refreshStatisques()
{
    try {
        DB::statement('REFRESH MATERIALIZED VIEW "statistiques_pratiques_par_pays"');
    } catch (Exception $e) {
        Log::error('Erreur lors du rafraischissement des statistiques : ' . $e->getMessage());
    }
}

function getDomaines()
{
    return Theme::all();
}
function getClimats()
{
    return Pratiqueclimat::with('climat')->get()->pluck('climat')->unique();
}

function getSols()
{
    return Pratiquesol::with('sol')->get()->pluck('sol')->unique();
}
function getThemes()
{
    return Pratiquetheme::with('theme')->get()->pluck('theme')->unique();
}
function getdomaine()
{
    return Pratiquedomaine::with('domaine')->get()->pluck('domaine')->unique();
}

if (!function_exists('formatTexte')) {
    function formatTexte($texte)
    {
        return mb_convert_case($texte, MB_CASE_TITLE, "UTF-8");
    }
}

if (!function_exists('truncateHtml')) {
    function truncateHtml($html, $maxLength = 800, $end = '...')
    {
        $dom = new DOMDocument();
        libxml_use_internal_errors(true);

        // Assurer une bonne gestion des entités HTML et éviter les erreurs de parsing
        $html = '<div>' . htmlspecialchars_decode($html, ENT_QUOTES) . '</div>';
        $dom->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'), LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        
        libxml_clear_errors();

        $charCount = 0;
        $truncated = '';

        foreach ($dom->documentElement->childNodes as $node) {
            if ($charCount >= $maxLength) break;
            $truncated .= truncateNode($node, $charCount, $maxLength, $end);
        }

        return closeUnclosedTags(trimTextAtSentenceEnd($truncated, $end));
    }

    function truncateNode($node, &$charCount, $maxLength, $end)
    {
        if ($charCount >= $maxLength) return '';

        if ($node->nodeType == XML_TEXT_NODE) {
            $text = $node->nodeValue;
            $remaining = $maxLength - $charCount;

            if (mb_strlen($text, 'UTF-8') > $remaining) {
                $truncatedText = mb_substr($text, 0, $remaining, 'UTF-8');
                $charCount = $maxLength;
                return $truncatedText;
            }

            $charCount += mb_strlen($text, 'UTF-8');
            return $text;
        }

        if ($node->nodeType == XML_ELEMENT_NODE) {
            $html = "<{$node->nodeName}";

            foreach ($node->attributes as $attr) {
                $html .= " {$attr->nodeName}=\"{$attr->nodeValue}\"";
            }

            $html .= '>';

            foreach ($node->childNodes as $child) {
                if ($charCount >= $maxLength) break;
                $html .= truncateNode($child, $charCount, $maxLength, $end);
            }

            $html .= "</{$node->nodeName}>";
            return $html;
        }

        return '';
    }

    function trimTextAtSentenceEnd($text, $end)
    {
        // Trouver la dernière occurrence de '.', '!' ou '?' avant la coupure
        $lastSentenceEnd = max(mb_strrpos($text, '.'), mb_strrpos($text, '!'), mb_strrpos($text, '?'));

        if ($lastSentenceEnd !== false && $lastSentenceEnd > (mb_strlen($text) * 0.7)) {
            return mb_substr($text, 0, $lastSentenceEnd + 1, 'UTF-8');
        }

        return rtrim($text, " \t\n\r\0\x0B") . $end;
    }

    function closeUnclosedTags($html)
    {
        $dom = new DOMDocument();
        libxml_use_internal_errors(true);
        
        $dom->loadHTML('<div>' . mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8') . '</div>', LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        libxml_clear_errors();

        $fixedHtml = '';
        foreach ($dom->documentElement->childNodes as $node) {
            $fixedHtml .= $dom->saveHTML($node);
        }

        return $fixedHtml;
    }
}



