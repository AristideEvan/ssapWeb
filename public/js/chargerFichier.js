var nbrFichiers = 0;
//Fonction renvoyant le nom d'un fichier à partir de son chemin complet
function getFileName(fileName)
{
  if (fileName != "") {
    if (fileName.match(/^(\\\\|.:)/)) {
      var temp = new Array();
      temp = fileName.split("\\");
      var len = temp.length;
      fileName = temp[len-1];
    } else {
      temp = fileName.split("/");
      var len = temp.length;
      if(len>0)
        fileName = temp[len-1];
    }
  }
  return fileName;
}


//recuperer l'extension du fichier
function get_extension(nomfichier) {
    return nomfichier.slice((nomfichier.lastIndexOf('.') - 1 >>> 0) + 2);
}

function verifierExtensionShp(nomFichier){
  var flag=false;
  var TabExtension=['cpg','dbf','prj','shp','shx'];

  var fichierExten=get_extension(nomFichier);

  var extenMin=fichierExten.toLowerCase();
  console.log(extenMin);
  for(var i=0; i<TabExtension.length; i++){
      if(TabExtension[i]==extenMin){
          flag=true;
      }
  }

  return flag;
}

function verifierGpx(gpx){
    var flag=false;
    var gpxExtension=get_extension(gpx);
    //console.log(gpxExtension);
    if(gpxExtension=='xml' || gpxExtension=='gpx'){
        return flag=true
    }
    return flag;
}

function verifierExcel(fichier){
  var flag=false;
  var getExtension=get_extension(fichier);
  if(getExtension=='xls' || getExtension=='xlsx'){
      return flag=true
  }
  return flag;
}

function verifierPdf(fichier){
    var flag=false;
    var getExtension=get_extension(fichier);
    if(getExtension=='pdf' || getExtension=='PDF'){
        return flag=true
    }
    return flag;
  }

  function pdfValidator(input){
    var flag=verifierPdf(getFileName(input.value));
    if(!flag){
        NotificationMauvaisFichier("Veuillez choisir un fichier PDF",4);
        input.type = ''
        input.type = 'file'
    }
}

function gpxValidator(input){
    var flag=verifierGpx(getFileName(input.value));
    if(!flag){
        NotificationMauvaisFichier("Veuillez choisir un fichier GPX valide",4);
        input.type = ''
        input.type = 'file'
    }
}

function excelValidator(input){
  var flag=verifierExcel(getFileName(input.value));
  if(!flag){
    NotificationMauvaisFichier("Veuillez choisir un fichier excel valide",4);
      input.type = ''
      input.type = 'file'
  }
}

//création d'un input
var nbrFichiers = 0;

function creerInput(){
  jQuery("#input").append(
      "<input type='file' style='height: 40px;' onchange='ajouterFichier(this)' class='form-control formulaire'>"
  )
}

/**
 * 
 * @param {*input} input de type file pour le chargement des fichiers shape
 */
function ajouterFichier(input){
  var flag=verifierExtensionShp(getFileName(input.value));
  var fanion= VerifierTaille(input);
   if(flag){
      if(fanion){
      if(nbrFichiers==0){
          $("#p1").remove();
          //console.log($("fichiers").text());
      }
      nbrFichiers++;

      jQuery("#fichiers").append(
          "<p style='margin: 0; padding: 0'>"+
              "<a id='"+nbrFichiers+"' class='FileListe' onclick='supprimerFichier(this.id)'>"+
                  "<i class='fa fa-trash' style='color:#F00; cursor:pointer'></i>"+
              "</a>"+" " + getFileName(input.value)+
               "<input class='Extension' type='hidden' id='extension"+nbrFichiers+"' name='extension"+nbrFichiers+"' value='"+get_extension(getFileName(input.value))+"'>"+ 
          "</p>"
      );

      //Affectation de l'attribut name de l'input
      input.name = "selectFichier"+nbrFichiers;
      input.className='InputList';
      input.style='display:none';

      creerInput();
      }else{
        NotificationMauvaisFichier("Fichier trop volumineux! Max 3Mo",2);
      }
  }else{
    NotificationMauvaisFichier("Fichier non valide",2);
  }
}

function supprimerFichier(id){
  jQuery('#'+id).parent().remove();
  jQuery("input[name=selectFichier"+id+"]").remove();
  numeroter();
  numeroterA();
  numeroterExt();
  nbrFichiers--;
  /* if(nbrFichiers==0){
      jQuery("#fichiers").append(
          "<p id='p1'>Aucun fichier à uploader</p>"
      )
  } */

}

/**
* fonction pour renumeroter la liste des fichiers
*/
function numeroter(){
var t=1;
  jQuery(".InputList").each(function()
  {
      jQuery(this).attr('name','selectFichier'+t)
     //console.log(jQuery(this).attr('name','fichier'+j));
      t++;
   });
}

function numeroterA(){
  var j=1;
      jQuery(".FileListe").each(function()
      {
          jQuery(this).attr('id',j)
          j++;
       });
  }

  function numeroterExt(){
    var j=1;
        jQuery(".Extension").each(function()
        {
            jQuery(this).attr('name','extension'+j)
            jQuery(this).attr('id','extension'+j)
            j++;
         });
    }


  /**
 * fonction des verification de la taille des fichiers
 */

 function VerifierTaille(input){
  var files=input.files;
  var tailleMax=3145728;
  var tailleFile=files[0].size;
  if(tailleFile>tailleMax){
      return false;
  }else{
      return true;
  }
}
/* vérifier les extensions des fichiers chargés  */
function verifierExtensionFichiersBib(nomFichier){
    var flag=false;
    var TabExtension=['pdf','doc','docx','xls','xlsx','ppt','pptx','odt','xml','gpx','odp','ods','jpeg','png','jpg','gif','txt',];
    var fichierExten=get_extension(nomFichier);
    var extenMin=fichierExten.toLowerCase();
    console.log(extenMin);
    for(var i=0; i<TabExtension.length; i++){
        if(TabExtension[i]==extenMin){
            flag=true;
        }
    }
    return flag;
}
/* Valider un fichier choisi */
function fichierValidator(input){
    var flag=verifierExtensionFichiersBib(getFileName(input.value));
    if(!flag){
        NotificationMauvaisFichier("Le type de fichier choisit n'est pas autorisé",4);
        input.type = ''
        input.type = 'file'
    }

    var taille = VerifierTaille(input);
    if(!taille){
      NotificationMauvaisFichier("Le fichier est trop volumineux (taille max 3Mo)",4);
        input.type = ''
        input.type = 'file'
    }
}
/* Affiche une notification */
function NotificationMauvaisFichier(message,duree){
    jQuery.rtnotify({
        title: "",
        message: message,
        type: "error",
        permanent: false,
        timeout: duree,
        fade: true,
        width: 300
    });
}