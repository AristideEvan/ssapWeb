<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement('
        CREATE MATERIALIZED VIEW statistiques_pratiques_par_pays AS
        SELECT 
            COALESCE("pays"."nomLocalite", \'Inconnu\') AS pays,
            COUNT(DISTINCT "pratiquezoneapplis"."pratique_id") AS nb_pratiques_publiques
        FROM 
            "pratiquezoneapplis"
        JOIN 
            "listeLocalite" ON "pratiquezoneapplis"."localite_id" = "listeLocalite"."localite_id"
        JOIN 
            "localites" ON "listeLocalite"."p0" = "localites"."localite_id"
        JOIN 
            "localites" AS "pays" ON "pays"."parent_id" IS NULL AND "pays"."localite_id" = "listeLocalite"."p0"
        JOIN 
            "pratiques" ON "pratiquezoneapplis"."pratique_id" = "pratiques"."pratique_id"
        WHERE 
            "localites"."parent_id" IS NULL
            AND "pratiques"."deleted_at" IS NULL -- Exclure les pratiques supprimées
            AND "pratiques"."publique" = true -- Ajouter la condition publique
        GROUP BY 
            "pays"."nomLocalite"
        ORDER BY 
            nb_pratiques_publiques DESC;
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('DROP MATERIALIZED VIEW IF EXISTS statistiques_pratiques_par_pays;');
    }
};
