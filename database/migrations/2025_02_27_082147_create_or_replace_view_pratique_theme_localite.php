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
            CREATE OR REPLACE VIEW "viewPratiqueThemeLocalite" AS
            SELECT 
                pt."pratique_id",
                pt."theme_id",
                t."themeLibelle",
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
                "pratiquethemes" pt
            JOIN
                "pratiques" p ON pt."pratique_id" = p."pratique_id"
            JOIN
                "themes" t ON pt."theme_id" = t."theme_id"
            WHERE
                p."deleted_at" IS NULL
                AND p."publique" = true
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        DB::statement('DROP VIEW IF EXISTS "viewPratiqueThemeLocalite"');
    }
};
