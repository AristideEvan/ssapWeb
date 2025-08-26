<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class StatistiqueController extends Controller
{
    public static function index()
    {
        return [
            'nb_pratiques' => self::getNombrePratiques(),
            'nb_pratiques_publiques' => self::getNombrePratiquesVisibles(),
            'nb_pratiques_pays' => self::getStatisquesByPays(),
            'nb_utilisateurs_actifs' => self::getNombreUtilisateursActifs(),
        ];
    }

    public static function getNombrePratiques()
    {
        return DB::table('pratiques')
            ->whereNull('deleted_at')
            ->count();
    }

    public static function getNombrePratiquesVisibles()
    {
        return DB::table('pratiques')
            ->whereNull('deleted_at')
            ->where('publique', true)
            ->count();
    }

    public static function getStatisquesByPays()
    {
        DB::statement('REFRESH MATERIALIZED VIEW "statistiques_pratiques_par_pays"');
        $statistiques = DB::select('SELECT * FROM "statistiques_pratiques_par_pays"');
        return $statistiques;
    }

    public static function getNombreUtilisateursActifs()
    {
        return DB::table('users')
            ->whereNull('deleted_at')
            ->where('actif', true)
            ->count();
    }
}
