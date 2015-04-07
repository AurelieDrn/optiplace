$(document).on('change', '.btn-file :file', function() {
  var input = $(this),
      numFiles = input.get(0).files ? input.get(0).files.length : 1,
      label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
  input.trigger('fileselect', [numFiles, label]);
});

$(document).ready( function() {
    $('.btn-file :file').on('fileselect', function(event, numFiles, label) {
        
        var input = $(this).parents('.input-group').find(':text'),
            log = numFiles > 1 ? numFiles + ' files selected' : label;
        
        if( input.length ) {
            input.val(log);
        } else {
            if( log ) alert(log);
        }
        
    });
	
    // Show or hide modals
    $('.bouton-creer').on('click', function() {
        $('.modal-creer').show();
        $('.modal-afficher').hide();
        $('.modal-importer').hide();
        $('.modal-exporter').hide();
    });    
	
    $('.bouton-afficher').on('click', function() {
        $('.modal-afficher').show();
        $('.modal-creer').hide();
        $('.modal-importer').hide();
        $('.modal-exporter').hide();
    }); 

    $('.bouton-importer').on('click', function() {
        $('.modal-importer').show();
        $('.modal-creer').hide();
        $('.modal-afficher').hide();
        $('.modal-exporter').hide();
    }); 

    $('.bouton-exporter').on('click', function() {
        $('.modal-exporter').show();
        $('.modal-creer').hide();
        $('.modal-afficher').hide();
        $('.modal-importer').hide();
    }); 
	
	// Alert messages
	if (getUrlParameter('sallesPage') == "true" && getUrlParameter('msg') == "true") {
		importSuccess();
	}
	if (getUrlParameter('sallesPage') == "true" && getUrlParameter('msg') == "false") {
		importError();
	}
});

function importSuccess() {
	swal("Bravo !", "Votre fichier a été téléchargé avec succès.", "success");
}

function importError() {
	swal("Nous sommes désolés !", "Votre fichier n'a pas pu être téléchargé. Veuillez vérifier que votre fichier soit d'extension .xlsx de version 2003 à 2010 et que vous possédez les droits pour importer des fichiers sur cet espace.", "error");
}

// Check if the input file is an xlsx file 
function testTypeFichier() {
	var nomFich = document.getElementById("userfile").value;
	if (nomFich.slice(-4) == "xlsx") { // Extension is correct
		return true;
	}
    else if(nomFich.slice(-4) == "") { // No file
        swal("Aucun fichier détecté !", "Veuillez sélectionner un fichier Excel.", "info");
		return false;
    }
	else {
		swal("Attention !", "Le fichier doit être issu d'une version Excel 2003 à 2010.", "warning");
		return false;
	}
}

// Get url parameter sParam
function getUrlParameter(sParam) {
    var sPageURL = window.location.search.substring(1);
    var sURLVariables = sPageURL.split('&');
    for (var i = 0; i < sURLVariables.length; i++) {
        var sParameterName = sURLVariables[i].split('=');
        if (sParameterName[0] == sParam) {
            return sParameterName[1];
        }
    }
}    

