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
	
	 //when a group is shown, save it as the active accordion group
        $("#accordion").on('shown.bs.collapse', function () {
            var active = $("#accordion .in").attr('id');
            $.cookie('activeAccordionGroup', active);
          //  alert(active);
        });
        $("#accordion").on('hidden.bs.collapse', function () {
            $.removeCookie('activeAccordionGroup');
        });
        var last = $.cookie('activeAccordionGroup');
        if (last != null) {
            //remove default collapse settings
            $("#accordion .panel-collapse").removeClass('in');
            //show the account_last visible group
            $("#" + last).addClass("in");
        }

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

});

// Check if the input file is an xlsx file 
function testTypeFichier() {
	var nomFich = document.getElementById("userfile").value;
	if (nomFich.slice(-4) == "xlsx") { // Extension is correct
		return true;
	}
    else if(nomFich.slice(-4) == "") { // No file
        return false;
    }
	else {
		window.location.replace("index.php?sallesPage=true&erreurType=true");
		return false;
	}
}


