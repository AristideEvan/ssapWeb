<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Log;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        try {
            DB::unprepared('
                CREATE OR REPLACE VIEW "viewLocalite" AS
                -- Niveau 0
                SELECT 
                    l.localite_id,
                    l."typeLocalite_id",
                    "typeLocaliteLibelle",
                    parent_id AS p0,
                    "nomLocalite" AS pays,
                    0 AS p1, 
                    NULL AS libelle1, 
                    0 AS p2, 
                    NULL AS libelle2, 
                    0 AS p3,
                    NULL AS libelle3,
                    0 AS p4,
                    NULL AS libelle4,
                    "codeAlpha3",
                    centroid
                FROM localites l 
                INNER JOIN "type_localites" tl ON l."typeLocalite_id" = tl."typeLocalite_id"
                WHERE parent_id IS NULL

                UNION

                -- Niveau 1
                SELECT 
                    l.localite_id,
                    l."typeLocalite_id",
                    "typeLocaliteLibelle",
                    l.parent_id AS p0,
                    p0."nomLocalite" AS pays,
                    0 AS p1, 
                    l."nomLocalite" AS libelle1, 
                    0 AS p2, 
                    NULL AS libelle2, 
                    0 AS p3,
                    NULL AS libelle3,
                    0 AS p4,
                    NULL AS libelle4,
                    l."codeAlpha3",
                    l.centroid
                FROM localites l 
                INNER JOIN "type_localites" tl ON l."typeLocalite_id" = tl."typeLocalite_id"
                INNER JOIN localites p0 ON p0.localite_id = l.parent_id AND p0.parent_id IS NULL

                UNION

                -- Niveau 2
                SELECT 
                    l.localite_id,
                    l."typeLocalite_id",
                    "typeLocaliteLibelle",
                    p.parent_id AS p0,
                    p0."nomLocalite" AS pays,
                    p.localite_id AS p1, 
                    p."nomLocalite" AS libelle1, 
                    0 AS p2, 
                    l."nomLocalite" AS libelle2, 
                    0 AS p3,
                    NULL AS libelle3,
                    0 AS p4,
                    NULL AS libelle4,
                    l."codeAlpha3",
                    l.centroid
                FROM localites l 
                INNER JOIN "type_localites" tl ON l."typeLocalite_id" = tl."typeLocalite_id"
                INNER JOIN localites p ON p.localite_id = l.parent_id
                INNER JOIN localites p0 ON p0.localite_id = p.parent_id AND p0.parent_id IS NULL

                UNION

                -- Niveau 3
                SELECT 
                    l.localite_id,
                    l."typeLocalite_id",
                    "typeLocaliteLibelle",
                    p0.localite_id AS p0,
                    p0."nomLocalite" AS pays,
                    p1.localite_id AS p1, 
                    p1."nomLocalite" AS libelle1, 
                    p.localite_id AS p2, 
                    p."nomLocalite" AS libelle2, 
                    0 AS p3,
                    l."nomLocalite" AS libelle3,
                    0 AS p4,
                    NULL AS libelle4,
                    l."codeAlpha3",
                    l.centroid
                FROM localites l 
                INNER JOIN "type_localites" tl ON l."typeLocalite_id" = tl."typeLocalite_id"
                INNER JOIN localites p ON p.localite_id = l.parent_id
                INNER JOIN localites p1 ON p1.localite_id = p.parent_id
                INNER JOIN localites p0 ON p0.localite_id = p1.parent_id AND p0.parent_id IS NULL

                UNION

                -- Niveau 4
                SELECT 
                    l.localite_id,
                    l."typeLocalite_id",
                    "typeLocaliteLibelle",
                    p0.localite_id AS p0,
                    p0."nomLocalite" AS pays,
                    p1.localite_id AS p1, 
                    p1."nomLocalite" AS libelle1, 
                    p2.localite_id AS p2, 
                    p2."nomLocalite" AS libelle2, 
                    p.localite_id AS p3,
                    p."nomLocalite" AS libelle3,
                    0 AS p4,
                    l."nomLocalite" AS libelle4,
                    l."codeAlpha3",
                    l.centroid
                FROM localites l 
                INNER JOIN "type_localites" tl ON l."typeLocalite_id" = tl."typeLocalite_id"
                INNER JOIN localites p ON p.localite_id = l.parent_id
                INNER JOIN localites p2 ON p2.localite_id = p.parent_id
                INNER JOIN localites p1 ON p1.localite_id = p2.parent_id
                INNER JOIN localites p0 ON p0.localite_id = p1.parent_id AND p0.parent_id IS NULL;

                -- Vue de concaténation des libellés
                CREATE OR REPLACE VIEW "listeLocalite" AS
                SELECT 
                    localite_id,
                    "typeLocalite_id",
                    "typeLocaliteLibelle",
                    p0,
                    p1,
                    p2,
                    p3,
                    CONCAT_WS(\' - \', pays, libelle1, libelle2, libelle3, libelle4) AS "nomLocalite",
                    centroid
                FROM "viewLocalite";
            ');
        } catch (\Exception $e) {
            Log::error("Erreur lors de la création des vues: " . $e->getMessage());
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        try {
            DB::statement('DROP VIEW IF EXISTS "listeLocalite" CASCADE');
            DB::statement('DROP VIEW IF EXISTS "viewLocalite" CASCADE');
        } catch (\Exception $e) {
        }
    }
};
