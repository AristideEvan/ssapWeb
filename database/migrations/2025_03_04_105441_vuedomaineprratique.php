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
            CREATE VIEW vue_domaines_pratiques AS
            SELECT
                d."domaine_id",
                d."domaineLibelle",
                p."pratique_id",
                p."pratiqueLibelle",
                p."objectif",
                p."periodeDebut",
                p."periodeFin",
                p."description",
                p."conseil",
                p."avantage",
                p."contrainte",
                p."defis",
                p."vedette",
                p."publique",
                p."mesure",
                p."cout",
                p."description_env_humain",
                p."recommandation",
                p."vedette_path",
                p."created_at",
                p."updated_at",
                (SELECT doc."path"
                 FROM "documents" doc
                 WHERE doc."documentable_id" = p."pratique_id" 
                 ORDER BY doc."created_at" ASC
                 LIMIT 1) AS premier_document_path
            FROM
                "domaines" d
            JOIN
                "pratiquedomaines" pd ON d."domaine_id" = pd."domaine_id"
            JOIN
                "pratiques" p ON pd."pratique_id" = p."pratique_id"
            WHERE
                p."deleted_at" IS NULL
                AND p."publique" = true
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('DROP VIEW IF EXISTS vue_domaines_pratiques');
    }
};
