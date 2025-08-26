<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class UpdateViewPratiqueLocalite extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('
            CREATE OR REPLACE VIEW "viewPratiqueLocalite" AS
            SELECT 
                "pz"."pratique_id",
                "pz"."localite_id",
                "l"."typeLocalite_id",
                "l"."typeLocaliteLibelle",
                "l"."p0",
                "l"."pays",
                "ll"."nomLocalite",
                "l"."p1",
                "l"."libelle1",
                "l"."p2",
                "l"."libelle2",
                "l"."p3",
                "l"."libelle3",
                "l"."p4",
                "l"."libelle4",
                "l"."codeAlpha3",
                "l"."centroid",
                "pz"."longitude",
                "pz"."latitude",
                "pz"."geom",
                "p"."pratiqueLibelle",
                "p"."description",
                "p"."objectif",
                "p"."periodeDebut",
                "p"."periodeFin",
                "p"."avantage",
                "p"."contrainte",
                "p"."cout",
                "p"."conseil",
                "p"."mesure",
                "p"."description_env_humain",
                "p"."recommandation",
                "p"."defis",
                "p"."publique",
                "p"."user_id",
                "p"."vedette_path",
                "p"."created_at",
                "p"."updated_at",
                "pc"."climat_id",
                "c"."libelleClimat",
                "ps"."sol_id",
                "s"."solLibelle",
                "pt"."theme_id",
                "t"."themeLibelle",
                "pd"."domaine_id",
                "d"."domaineLibelle"
            FROM "pratiquezoneapplis" "pz"
            LEFT JOIN "pratiques" "p" ON "pz"."pratique_id" = "p"."pratique_id" AND "p"."deleted_at" IS NULL AND "p"."publique" = true
            LEFT JOIN "viewLocalite" "l" ON "pz"."localite_id" = "l"."localite_id"
            LEFT JOIN "listeLocalite" "ll" ON "l"."localite_id" = "ll"."localite_id"
            LEFT JOIN "pratiqueclimats" "pc" ON "p"."pratique_id" = "pc"."pratique_id"
            LEFT JOIN "climats" "c" ON "pc"."climat_id" = "c"."climat_id"
            LEFT JOIN "pratiquesols" "ps" ON "p"."pratique_id" = "ps"."pratique_id"
            LEFT JOIN "sols" "s" ON "ps"."sol_id" = "s"."sol_id"
            LEFT JOIN "pratiquethemes" "pt" ON "p"."pratique_id" = "pt"."pratique_id"
            LEFT JOIN "themes" "t" ON "pt"."theme_id" = "t"."theme_id"
            LEFT JOIN "pratiquedomaines" "pd" ON "p"."pratique_id" = "pd"."pratique_id"
            LEFT JOIN "domaines" "d" ON "pd"."domaine_id" = "d"."domaine_id"
            WHERE p.deleted_at IS NULL AND p.publique = true;
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('DROP VIEW IF EXISTS "viewPratiqueLocalite"');
    }
}
