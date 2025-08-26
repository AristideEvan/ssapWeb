/*!
* script js mise en place par SOMDA
*/

jQuery('select').select2({
    language: "fr",
    width: '100%'
});

$(".js-select2").select2({
    closeOnSelect : false,
    placeholder : "",
    allowHtml: true,
    allowClear: true,
    tags: true
});

/**
 * function pour le message de confirmation de la suppression
 * @param {*} href
 * @param {*} text
 */
function Supprimer(href,text){
    jQuery('#pourSupp').prop('action', href);
    jQuery('#nb').text(text);
    jQuery("#suppModal").modal();
    //console.log("yes");
}

/** fonction pour afficher des fenetres de type popup */
function popUp(chemin,id){
    console.log(chemin);
    jQuery('#envoi').load(chemin, function(){
      jQuery("#"+id).modal();
  });
}

/*  pour faire afficher le mot de passe */
jQuery(".toggle-password").click(function() {
    jQuery(this).toggleClass("fa-eye fa-eye-slash");
    var input = jQuery(jQuery(this).attr("toggle"));
    if (input.attr("type") == "password") {
    input.attr("type", "text");
    } else {
    input.attr("type", "password");
    }
});

//input mask pour créer un masque de saisie a revoir

$(document).ready(function() {
    jQuery('[data-mask]').inputmask();
  });

jQuery(".phone").inputmask({"mask": "(+226) 99-99-99-99"});
jQuery(".year").inputmask({"mask": "9999"});
jQuery(".anneeScol").inputmask({"mask": "9999-9999"});
jQuery(".moyenne").inputmask({"mask": "99.99"});
jQuery(".coefficient").inputmask({"mask": "99.9"});
//jQuery(".point").inputmask({"mask": "99999"});

$(function(){
	$('.sm,.ssm').prop("disabled",true);
	function count_checkbox_checked(){
		nchecked = 0;
		$('.parent,.sm').each(function(index){
			if($(this).prop('checked')){
				nchecked = nchecked + 1;
			}
		});
		$('input[name="nbmenu"]').val(nchecked);
	}
	$('#toutMenu').click(function(){
		if($(this).prop('checked')){
			$('.parent,.sm,.ssm').prop("checked",true);
			$('.sm,.ssm').prop("disabled",false);
		}else{
			$('.parent,.sm, .ssm').prop("checked",false);
			$('.sm,.ssm').prop("disabled",true);
		}
		count_checkbox_checked();
	});
	$('.parent,.sm').click(function(){
		if($(this).prop('checked')){
			$('.fils'+$(this).attr("value")).prop("disabled",false);
		}else{
			$('.fils'+$(this).attr("value")).prop("disabled",true);
			$('.fils'+$(this).attr("value")).prop("checked",false);
            $('.pfils'+$(this).attr("value")).prop("disabled",true);
			$('.pfils'+$(this).attr("value")).prop("checked",false);
		}
		count_checkbox_checked();
	});
    $('.sm').css('margin-left','20px');
    $('.ssm').css('margin-left','40px');
});


/**
 * function pour le message de confirmation de la suppression
 * @param {*} href
 * @param {*} text
 */
 function Supprimer(href,text){
    jQuery('#pourSupp').prop('action', href);
    jQuery('#nb').text(text);
    jQuery("#suppModal").modal();
    //console.log("yes");
}

/** fonction pour afficher des fenetres de type popup */
function popUp(chemin,id){
    //console.log(chemin);
    jQuery('#envoi').load(chemin, function(){
      jQuery("#"+id).modal();
  });
}

/* Fonction pour activer un element du ménu */
jQuery(document).ready(function() {
	var chemin=jQuery(location).attr("pathname");
	var indice=chemin.split('/');
	var tailleTab = indice.length;
	var elem=indice[1];
	//console.log();

	jQuery('#colapse-'+indice[tailleTab-2]).addClass('menu-is-opening menu-open');
	jQuery('#sousMenu'+indice[tailleTab-1]).addClass('lienActiver');
	//jQuery('#heading'+indice[tailleTab-2]).addClass('menuChoisi');
	//jQuery('#sousMenu'+indice[tailleTab-1]).parents('li').css('background-color', '#a1d69f');
  });

  function Collapser(id){
    var chaine=id.split('-');/* Pour recuperer le num du collapse */
    var ordre=chaine[1];/* Num du collapse */
    var classe=jQuery("#colapse-"+ordre).prop('class');
	jQuery('[id^="colapse-"]').each(function(){
		if($(this).prop('id')!='colapse-'+ordre){
			$(this).first().children('ul').css('display','none');
			$(this).removeClass('menu-is-opening menu-open');
		}
    });
}


function enleverBloc(id){
	$('#'+id).remove();
}

function calculNbPlat() {
	var nbrPartAttrib = 0;
    $('.calNbTotal').each(function(index){
        nbrPartAttrib =Number(nbrPartAttrib)+Number($(this).val());
    });

	$("#nombreT").val(nbrPartAttrib);
}

function enleverBlocMet(id){
	$('#'+id).remove();
	calculNbPlat();
}

function changerEtatCompte(href,text){
	jQuery('#changeEtat').prop('action', href);
	jQuery('#zoneMessage').text(text);
	jQuery("#changeEtatModal").modal();
}

function checkPrescription(id){
    if($('#'+id).prop('checked')){
        $('.checkPrescription').prop("checked",true);
    }else{
        $('.checkPrescription').prop("checked",false);
    }
}


function validerDate(debut,limit,niveau){
	var dateDebut=$('#'+debut);
	var dateLimit=$('#'+limit);
	if(dateDebut.val()!="" && dateLimit.val()!=""){
	  var partsDeb=dateDebut.val().split("-");
	  var date_debut=new Date(partsDeb[2],partsDeb[1]-1,partsDeb[0]);
	  var partsLimit=dateLimit.val().split("-");
	  var dateLimite=new Date(partsLimit[2],partsLimit[1]-1,partsLimit[0]);
	  //console.log(aujourd);
	  if(dateLimite<date_debut){
		if(Number(niveau)==1){
		  dateDebut.val("");
		}else{
		  dateLimit.val("");
		}
		  //popupAlert("La date de début ne peut être antérieure &agrave; date limite!");
		  $.rtnotify({
			  title: "",
			  message: "La date de début ne peut être antérieure &agrave; date limite!",
			  type: "error",
			  permanent: false,
			  timeout: 5,
			  fade: true,
			  width: 300
		  });
	  }
	}

}

function calculNombreBourse(){
	var nbrTotalBourse=jQuery('#nbrTotalBourse').val();
	var cotaFille=jQuery('#quotaFille').val();
	var cotaMerite=jQuery('#quotaMerite').val();
	var checkMerite=jQuery('#cotaMerite').val();
	var checkFille=jQuery('#cotaFille').val();

	if(Number(nbrTotalBourse)!=0 && Number(cotaFille!=0)){
		var nbrFille=(nbrTotalBourse*cotaFille)/100;
		var nbrGarcon=nbrTotalBourse-Math.round(nbrFille);
  
		var nbrMeriteFille=(Math.round(nbrFille)*cotaMerite)/100;
		//console.log(nbrMeriteFille);
		var nbrSocialFille=(Math.round(nbrFille))-(Math.round(nbrMeriteFille));
		var nbrMeriteGar=(Math.round(nbrGarcon)*cotaMerite)/100;
		var nbrSocialGar=(Math.round(nbrGarcon))-(Math.round(nbrMeriteGar));
		
		if(checkFille!=-1){
			jQuery('#nbreFille').val(Math.round(nbrFille));
			jQuery('#nbreGarcon').val(Math.round(nbrGarcon));
		}else{
			jQuery('#quotaFille').val("");
		}
		if(checkMerite!=-1){
			jQuery('#nbrGarconMerite').val(Math.round(nbrMeriteGar));
			jQuery('#nbrGarconSocial').val(Math.round(nbrSocialGar));
			jQuery('#nbrFilleMerite').val(Math.round(nbrMeriteFille));
			jQuery('#nbrFilleSocial').val(Math.round(nbrSocialFille));
		}else{
			jQuery('#quotaMerite').val("");
		}
	}


   // console.log('fille '+nbrFille+' et garcon '+nbrGarcon);
  }

//   Ajouter une matière à un niveau
function addMatiere(){
    var matiere_id= jQuery('#matiere').val();
    var matiereLibelle = jQuery('#matiere option:selected').text();
    var coef = jQuery('#coefficient').val();
    var deBase = jQuery('#base').prop('checked');
    var cocher = deBase?"Oui":"Non";
    var regex = /^\d{1,2}\.(0|5)$/; // 1 ou deux chiffres avant la virgule et le chiffre 0 ou 5 après
    if (regex.test(coef)) {
        enleverBloc(matiere_id);// Supp l'ancienne ligne si elle existe
        jQuery('#niveauMatieres').append(
            '<tr id="'+matiere_id+'">'+
            '<td><input hidden readonly style="border: none;" type="text" value="'+matiere_id+'" name="matieres[]"><span>'+matiereLibelle+'</span></td>'+
            '<td><input readonly style="border: none;width:30px" type="text" value="'+coef+'" name="coefficients[]"></td>'+
            '<td><input readonly style="border: none;width:40px" type="text" value="'+cocher+'" name="isBases[]"></td>'+
            '<td style="color:red"><i onclick="enleverBloc('+matiere_id+')" class="fa-solid fa-xmark"></i></td>'+
            '</tr>'
        );
    }else{
        Notification("Coefficient erroné! Assurez vous d'avoir 0 ou 5 après la virgule ex:(05.0 ou 05.5)");
    }
}

function apercuDocument(chemin){
    PDFObject.embed(chemin, "#docZone");
    jQuery("#apercuDoc").modal("show");
}

function popUpFront(chemin,id){
    jQuery('#envoi').load(chemin, function(){
      jQuery("#"+id).modal("show");
  });
}

function toutCocher(id,classe){
    if($('#'+id).prop('checked')){
        $('.'+classe).prop("checked",true);
    }else{
        $('.'+classe).prop("checked",false);
    }
}

function popupAlert($message){
	console.log($message)
    jQuery('#zoneMessage').html($message);
    jQuery("#popupAlert").modal();
}

// Calculer la moyenne d'une matière
function calculMoyMatiere(idMatiere){
    var note4 = Number(jQuery('#4eme-mat-'+idMatiere).val());
    var note3 = Number(jQuery('#3eme-mat-'+idMatiere).val());
    var noteExam = Number(jQuery('#exam-mat-'+idMatiere).val());
    if (note4 <0 || note4 > 20) {
        jQuery('#4eme-mat-'+idMatiere).val("")
        Notification("Mauvaise note");
        return;
    }
    if (note3 <0 || note3 > 20) {
        jQuery('#3eme-mat-'+idMatiere).val("")
        Notification("Mauvaise note");
        return;
    }
    var moyMatiere = (note4 + note3 + noteExam)/3;
    jQuery('#moy-mat-'+idMatiere).val(Math.round(moyMatiere * 100) / 100);
    determineProfil();
}

// Calcul la moyenne pour une série
function calculMoySerie(serie){
    var totalCoef = 0;
    var totalPondere = 0;
    $('.serie-'+serie).each(function(index){//Pour toutes les matières de base de la serie
        var coef = Number($(this).val());
        var note = Number($('#'+$(this).prop('name')).val());
        var pondere = coef * note;
        totalCoef+= coef;
        totalPondere+= pondere;
    });
    var moy = Number(totalPondere/totalCoef);
    $('#moy-serie-'+serie).val(Math.round(moy * 100) / 100);
    // Couleurs
    couleur(moy, serie);
}

// definir la couleur de recommandation d'une serie en fonction de la moyenne
function couleur(moy, serie){
    if (moy <= 8.0) {
        $('#moy-serie-'+serie).css('background-color','red');
    }else{
        if (moy <= 10.0) {
            $('#moy-serie-'+serie).css('background-color','orange');
        } else {
            if (isNaN(moy)) {
                $('#moy-serie-'+serie).css('background-color','white');
            }else{
                $('#moy-serie-'+serie).css('background-color','#1d8348');
            }
        }
    }
}

// Détermine les profils pour chaque serie
function determineProfil(){
    $('.serie').each(function(index){//Pour toutes les series
        var id = $(this).prop('id').split('-')[1];//id de la serie (niveau)
        calculMoySerie(id);
    });
}
