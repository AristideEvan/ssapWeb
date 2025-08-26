<?php

namespace App\Http\Controllers;

use App\Models\Candidat;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Codedge\Fpdf\Fpdf\Fpdf;
use GrofGraf\LaravelPDFMerger\PDFMerger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PDF extends FPDF {
    function Header()
	{
        
        //$this->Cell(70);
        //$this->Cell(140,8,utf8_decode('Fiche synthèse de distribution des produits aux élèves : Niveau notional'),0,1,'C',1);
    }

    function entete(){
        $this->SetFont('Helvetica','',10);
        //$this->Ln(2);
        $this->Cell(100,4,'MINISTERE DE L\'ENSEIGNEMENT SECONDAIRE, DE',0,0,'C');
        $this->Cell(65);
        $this->Cell(20,4,'BURKINA FASO',0,1,'C');
        $this->Cell(100,4,'LA FORMATION PROFESSIONNELLE ET TECHNIQUE',0,0,'C');
        $this->Cell(65);
        //$this->Cell(20,4,'----------',0,1,'C');
        //$this->Cell(100,4,'DES LANGUES NATIONALES',0,0,'C');
        //$this->Cell(165);
        $this->SetFont('Helvetica','I',10);
        $this->Cell(20,4,utf8_decode('Unité - Progrès - Justice'),0,1,'C');
        $this->SetFont('Helvetica','',10);
        $this->Cell(100,4,'-------------',0,1,'C');
        $this->Cell(100,4,utf8_decode('SECRETARIAT GENERAL'),0,0,'C');
        $this->Image("images/logo.png",110,20,25);
        
        $this->Ln(5);
        $this->Cell(100,4,'-------------',0,1,'C');
        $this->Cell(100,4,utf8_decode("DIRECTION GENERALE DE L'ACCES A"),0,0,'C');
        $this->Ln(5);
        $this->Cell(100,4,utf8_decode("L'EDUCATION FORMELLE"),0,0,'C');
        $this->Ln(8);
        $this->Cell(5);
        $this->Cell(120,4,'Tel: 25 65 22 69',0,1,'L');
        $this->Ln(2);
        $this->Cell(5);
        $this->Cell(120,4,'E-mail:diospb.mena@gmail.com',0,1,'L');
        $this->Ln(2);
        $this->Cell(5);
        $this->Cell(120,4,'Site: www.diospb.education.gov.bf',0,1,'L');
        $this->Ln();
    }

    function Footer() {
		// Positionnement à 1,5 cm du bas
		
		// Numéro de page, centré (C)
		//$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
	}

    function pied(){
        $this->SetY(-25);
        $this->SetFont('Helvetica','BUI',9);
        $this->Cell(50,4,'Signature du boursier',0,0,'C');
		// Police Arial italique 8
        $this->Cell(90);
        $this->Cell(50,4,'Signature du directeur',0,0,'C');
    }
}

class PdfController extends Controller
{
    public function getCarteBoursier($iue){
        //$eleve = Candidat::find($iue);
        $cheminQr='images/codeQR';

        
        
        $requete = 'SELECT c.*,i.*,r.*,so.*,vl.*,se.*,e.*,cr.*,p.*,s.*,b.*,ty."typeBourse",
            pb.libelle AS pb_libelle,t."typeBourse" AS pb_type_bourse,
            li.nomcommune AS "communeAct",li.nomprovince AS "provinceAct",
            li.nomregion AS "regionAct",li.idcom AS "idcomAct",li.idprov AS "idprovAct",
            li.idreg AS "idregAct"
            FROM candidats c
            INNER JOIN inscriptions i ON c.iue=i.iue
            INNER JOIN resultats r ON c.iue=r.iue
            INNER JOIN serie_options so ON so."serieOption_id"=i."serieOption_id"
            INNER JOIN listelocalite vl ON vl.idcom=i."centreExamen_id"
            INNER JOIN sessions se ON se.session_id=i.session_id
            INNER JOIN examens e ON e.examen_id=se.examen_id
            INNER join structures etab ON etab.structure_id=i.etablissement_id
            LEFT JOIN concours_rattaches cr ON cr."concoursRattache_id"=i."concoursRattache_id"
            INNER JOIN barems_concours bc ON bc."concoursRattache_id"=i."concoursRattache_id"
            INNER JOIN admis_concours ac ON ac.iue = c.iue
            INNER JOIN postulers p ON p.iue = c.iue
            INNER JOIN boursiers bo ON bo.iue = c.iue
            LEFT JOIN structures s ON p.etablissement_id=s.structure_id
            LEFT JOIN listelocalite li ON s.localite_id = li.idcom
            INNER JOIN bourses b ON b.bourse_id=p.bourse_id
            INNER JOIN type_bourses ty ON ty."typeBourse_id"=b."typeBourse_id"
            LEFT JOIN bourses pb ON b.parent_id=pb.bourse_id
            LEFT JOIN type_bourses t ON t."typeBourse_id"=pb."typeBourse_id"';

        $elev = DB::select($requete." WHERE c.iue='".$iue."'");
        $eleve = $elev[0];
        $systemeEns = "";
        if($eleve->examen_id==1 || $eleve->examen_id==2 ){
            $systemeEns = "POST-PRIMAIRE";
        }else{
            $systemeEns = "SECONDAIRE";
        }
        $imageQr = $cheminQr."/".$iue.".png";
        $ne=($eleve->sexe=='Masculin')? ' Né ':' Née ';
        $dateLieu = $this->showDateNaissence($eleve->dateNaissance,$eleve->typeDateNaissance);
        $codeQr = $iue.'-'.$eleve->annee.$eleve->examen.$eleve->typeBourse.'P-'.$eleve->nomPere.' '.$eleve->prenomPere.'BACCO-'.$eleve->meriteSocial;
        if(!file_exists($imageQr)){
            QrCode::size(500)->format('png')->generate(mb_convert_encoding($codeQr,"UTF-8"),public_path($cheminQr."/".$iue.'.png'));
        }
        $pdf = new PDF('L','mm','A5');
        // Nouvelle page A4 (incluant ici logo, titre et pied de page)
        $pdf->AddPage();
        $pdf->entete();
        if($eleve->lienPhoto!=''){
            $pdf->Image($eleve->lienPhoto,165,20,40,45);
        }else{
            $pdf->Image('images/no-image.png',150,20,50);
        }
        $pdf->Cell(50);
        $pdf->SetFont('Helvetica','B',10);
        
        // fond de couleur gris (valeurs en RGB)
        $pdf->setFillColor(230,230,230);
        $pdf->Cell(100,5,utf8_decode('ATTESTATION DE BOURSE SCOLAIRE'),0,1,'C',1);
        $pdf->Cell(50);
        $pdf->Cell(100,5,utf8_decode($systemeEns),0,1,'C',1);
        $pdf->Ln(3);
        $pdf->Cell(50);
        $pdf->SetFont('Helvetica','BI',10);
        $pdf->Cell(100,4,utf8_decode("1-Identification du boursier"),0,0,'C');
        $pdf->Ln(10);
        $pdf->SetFont('Helvetica','',10);
        $pdf->Cell(180,2,utf8_decode("Etablissement:".$eleve->nomStructure." - Province: ".$eleve->provinceAct." - Région: ".$eleve->regionAct),0,0,'L');
        $pdf->Ln(5);
        $pdf->Cell(180,2,utf8_decode("Nom et Prénom(s):".$eleve->nom." ".$eleve->prenom." ".$ne." ".$dateLieu." à ".$eleve->lieuNaissance),2,5,'L');
        $pdf->Ln(5);
        $pdf->Cell(180,2,utf8_decode($eleve->examen." Session ".$eleve->annee." N° PV: ".$eleve->numeroPV),2,5,'L');
        $pdf->Ln(5);
        $pdf->Cell(180,2,utf8_decode("Année d'obtention de la bourse:".$eleve->annee),2,5,'L');
        $pdf->Ln(5);
        $pdf->Cell(180,2,utf8_decode("N° téléphone du parent ou tuteur du boursier:".$eleve->tel_pere."/".$eleve->tel_mere),2,5,'L');
        $pdf->Image($imageQr,175,100,20);
        $pdf->pied();
        //$pdf->AliasNbPages();
        $pdf->AddPage();
        $pdf->Cell(50);
        $pdf->SetFont('Helvetica','BI',8);
        $pdf->Cell(100,4,utf8_decode("2-Paiement des bourses"),0,0,'C');
        $pdf->Ln(5);
        $pdf->Cell(4);
        $pdf->Cell(40,5,utf8_decode('Année Scolaire: '.$eleve->annee.'-'.$eleve->annee+1),0,0,'C');
        $pdf->Cell(8);
        $pdf->Cell(80,5,utf8_decode('Etablissement:......................................'),0,0,'C');
        $pdf->Cell(20);
        $pdf->Cell(40,5,utf8_decode('Classe:.................'),0,0,'C');
        $pdf->Ln(5);
        $pdf->Cell(45,4,utf8_decode("Tranche "),1,0,'L');
        $pdf->Cell(36,4,utf8_decode("Oct. Nov. Déc."),1,0,'L');
        $pdf->Cell(36,4,utf8_decode("Jan. Fév. Mar."),1,0,'L');
        $pdf->Cell(36,4,utf8_decode("Avril. Mai. Juin"),1,0,'L');
        $pdf->Cell(36,4,utf8_decode("Juil. Août. Sept"),1,0,'L');
        $pdf->Ln();
        $pdf->Cell(45,4,'Montant',1,0,'L');
        $pdf->Cell(36,4,'',1,0,'L');
        $pdf->Cell(36,4,'',1,0,'L');
        $pdf->Cell(36,4,'',1,0,'L');
        $pdf->Cell(36,4,'',1,0,'L');
        $pdf->Ln();
        $pdf->Cell(45,4,'Signature du boursier',1,0,'L');
        $pdf->Cell(36,4,'',1,0,'L');
        $pdf->Cell(36,4,'',1,0,'L');
        $pdf->Cell(36,4,'',1,0,'L');
        $pdf->Cell(36,4,'',1,0,'L');
        $pdf->Ln();
        $pdf->Cell(45,4,'Date et cachet du payeur',1,0,'L');
        $pdf->Cell(36,4,'',1,0,'L');
        $pdf->Cell(36,4,'',1,0,'L');
        $pdf->Cell(36,4,'',1,0,'L');
        $pdf->Cell(36,4,'',1,0,'L');
        //ligne deux
        $pdf->Ln(5);
        $pdf->Cell(4);
        $pdf->Cell(40,5,utf8_decode('Année Scolaire: '.($eleve->annee+1).'-'.$eleve->annee+2),0,0,'C');
        $pdf->Cell(8);
        $pdf->Cell(80,5,utf8_decode('Etablissement:......................................'),0,0,'C');
        $pdf->Cell(20);
        $pdf->Cell(40,5,utf8_decode('Classe:.................'),0,0,'C');
        $pdf->Ln(6);
        $pdf->Cell(45,4,utf8_decode("Tranche "),1,0,'L');
        $pdf->Cell(36,4,utf8_decode("Oct. Nov. Déc."),1,0,'L');
        $pdf->Cell(36,4,utf8_decode("Jan. Fév. Mar."),1,0,'L');
        $pdf->Cell(36,4,utf8_decode("Avril. Mai. Juin"),1,0,'L');
        $pdf->Cell(36,4,utf8_decode("Juil. Août. Sept"),1,0,'L');
        $pdf->Ln();
        $pdf->Cell(45,4,'Montant',1,0,'L');
        $pdf->Cell(36,4,'',1,0,'L');
        $pdf->Cell(36,4,'',1,0,'L');
        $pdf->Cell(36,4,'',1,0,'L');
        $pdf->Cell(36,4,'',1,0,'L');
        $pdf->Ln();
        $pdf->Cell(45,4,'Signature du boursier',1,0,'L');
        $pdf->Cell(36,4,'',1,0,'L');
        $pdf->Cell(36,4,'',1,0,'L');
        $pdf->Cell(36,4,'',1,0,'L');
        $pdf->Cell(36,4,'',1,0,'L');
        $pdf->Ln();
        $pdf->Cell(45,4,'Date et cachet du payeur',1,0,'L');
        $pdf->Cell(36,4,'',1,0,'L');
        $pdf->Cell(36,4,'',1,0,'L');
        $pdf->Cell(36,4,'',1,0,'L');
        $pdf->Cell(36,4,'',1,0,'L');
        $pdf->Ln(5);
        $pdf->Cell(4);
        $pdf->Cell(40,5,utf8_decode('Année Scolaire: '.($eleve->annee+2).'-'.$eleve->annee+3),0,0,'C');
        $pdf->Cell(8);
        $pdf->Cell(80,5,utf8_decode('Etablissement:......................................'),0,0,'C');
        $pdf->Cell(20);
        $pdf->Cell(40,5,utf8_decode('Classe:.................'),0,0,'C');
        $pdf->Ln(6);
        $pdf->Cell(45,4,utf8_decode("Tranche "),1,0,'L');
        $pdf->Cell(36,4,utf8_decode("Oct. Nov. Déc."),1,0,'L');
        $pdf->Cell(36,4,utf8_decode("Jan. Fév. Mar."),1,0,'L');
        $pdf->Cell(36,4,utf8_decode("Avril. Mai. Juin"),1,0,'L');
        $pdf->Cell(36,4,utf8_decode("Juil. Août. Sept"),1,0,'L');
        $pdf->Ln();
        $pdf->Cell(45,4,'Montant',1,0,'L');
        $pdf->Cell(36,4,'',1,0,'L');
        $pdf->Cell(36,4,'',1,0,'L');
        $pdf->Cell(36,4,'',1,0,'L');
        $pdf->Cell(36,4,'',1,0,'L');
        $pdf->Ln();
        $pdf->Cell(45,4,'Signature du boursier',1,0,'L');
        $pdf->Cell(36,4,'',1,0,'L');
        $pdf->Cell(36,4,'',1,0,'L');
        $pdf->Cell(36,4,'',1,0,'L');
        $pdf->Cell(36,4,'',1,0,'L');
        $pdf->Ln();
        $pdf->Cell(45,4,'Date et cachet du payeur',1,0,'L');
        $pdf->Cell(36,4,'',1,0,'L');
        $pdf->Cell(36,4,'',1,0,'L');
        $pdf->Cell(36,4,'',1,0,'L');
        $pdf->Cell(36,4,'',1,0,'L');
        //ligne deux
        $pdf->Ln(5);
        $pdf->Cell(4);
        $pdf->Cell(40,5,utf8_decode('Année Scolaire: '.($eleve->annee+3).'-'.$eleve->annee+4),0,0,'C');
        $pdf->Cell(8);
        $pdf->Cell(80,5,utf8_decode('Etablissement:......................................'),0,0,'C');
        $pdf->Cell(20);
        $pdf->Cell(40,5,utf8_decode('Classe:.................'),0,0,'C');
        $pdf->Ln(6);
        $pdf->Cell(45,4,utf8_decode("Tranche "),1,0,'L');
        $pdf->Cell(36,4,utf8_decode("Oct. Nov. Déc."),1,0,'L');
        $pdf->Cell(36,4,utf8_decode("Jan. Fév. Mar."),1,0,'L');
        $pdf->Cell(36,4,utf8_decode("Avril. Mai. Juin"),1,0,'L');
        $pdf->Cell(36,4,utf8_decode("Juil. Août. Sept"),1,0,'L');
        $pdf->Ln();
        $pdf->Cell(45,4,'Montant',1,0,'L');
        $pdf->Cell(36,4,'',1,0,'L');
        $pdf->Cell(36,4,'',1,0,'L');
        $pdf->Cell(36,4,'',1,0,'L');
        $pdf->Cell(36,4,'',1,0,'L');
        $pdf->Ln();
        $pdf->Cell(45,4,'Signature du boursier',1,0,'L');
        $pdf->Cell(36,4,'',1,0,'L');
        $pdf->Cell(36,4,'',1,0,'L');
        $pdf->Cell(36,4,'',1,0,'L');
        $pdf->Cell(36,4,'',1,0,'L');
        $pdf->Ln();
        $pdf->Cell(45,4,'Date et cachet du payeur',1,0,'L');
        $pdf->Cell(36,4,'',1,0,'L');
        $pdf->Cell(36,4,'',1,0,'L');
        $pdf->Cell(36,4,'',1,0,'L');
        $pdf->Cell(36,4,'',1,0,'L');
        $pdf->Ln(5);
        $pdf->Cell(4);
        $pdf->Cell(40,5,utf8_decode('Année Scolaire: '.($eleve->annee+4).'-'.$eleve->annee+5),0,0,'C');
        $pdf->Cell(8);
        $pdf->Cell(80,5,utf8_decode('Etablissement:......................................'),0,0,'C');
        $pdf->Cell(20);
        $pdf->Cell(40,5,utf8_decode('Classe:.................'),0,0,'C');
        $pdf->Ln(6);
        $pdf->Cell(45,4,utf8_decode("Tranche "),1,0,'L');
        $pdf->Cell(36,4,utf8_decode("Oct. Nov. Déc."),1,0,'L');
        $pdf->Cell(36,4,utf8_decode("Jan. Fév. Mar."),1,0,'L');
        $pdf->Cell(36,4,utf8_decode("Avril. Mai. Juin"),1,0,'L');
        $pdf->Cell(36,4,utf8_decode("Juil. Août. Sept"),1,0,'L');
        $pdf->Ln();
        $pdf->Cell(45,4,'Montant',1,0,'L');
        $pdf->Cell(36,4,'',1,0,'L');
        $pdf->Cell(36,4,'',1,0,'L');
        $pdf->Cell(36,4,'',1,0,'L');
        $pdf->Cell(36,4,'',1,0,'L');
        $pdf->Ln();
        $pdf->Cell(45,4,'Signature du boursier',1,0,'L');
        $pdf->Cell(36,4,'',1,0,'L');
        $pdf->Cell(36,4,'',1,0,'L');
        $pdf->Cell(36,4,'',1,0,'L');
        $pdf->Cell(36,4,'',1,0,'L');
        $pdf->Ln();
        $pdf->Cell(45,4,'Date et cachet du payeur',1,0,'L');
        $pdf->Cell(36,4,'',1,0,'L');
        $pdf->Cell(36,4,'',1,0,'L');
        $pdf->Cell(36,4,'',1,0,'L');
        $pdf->Cell(36,4,'',1,0,'L');
        $pdf->Image($imageQr,100,130,10);
        $pdf->output($iue.'.pdf','i');
        exit;
        //$pdf->Output('D','PERSNI_niveau_ecole.pdf');
    }
}
