//Code erst ausführen wenn Seite vollständig geladen
jQuery(document).ready(function($) {
     // Für testzwecke aktivieren:
    // alert('Hello');

	// Uploading files
var file_frame;


  //Hier wird die id wp_smart_rate_uploadButton des in der meta box vorhandenen 
  //Upload-Buttons angegeben. Muss dort gleichlautend vorhanden sein.
  $('#wp_smart_rate_uploadButton').on('click', function( event ){
    // Für testzwecke aktivieren:
    // alert('Hello');


    event.preventDefault();

    // If the media frame already exists, reopen it.
    if ( file_frame ) {
      file_frame.open();
      return;
    }

    // Create the media frame.
    file_frame = wp.media.frames.file_frame = wp.media({
      title: jQuery( this ).data( 'uploader_title' ),
      button: {
        text: jQuery( this ).data( 'uploader_button_text' ),
      },
      multiple: false  // Set to true to allow multiple files to be selected
    });

    // When an image is selected, run a callback.
    file_frame.on( 'select', function() {
      // We set multiple to false so only get one image from the uploader
      attachment = file_frame.state().get('selection').first().toJSON();

    //Hier wird die id wp_smart_rate_image des in der meta box vorhandenen 
    //Text-Feldes der Image-URL angegeben. Muss dort gleichlautend vorhanden sein.
	$('#wp_smart_rate_image').val( attachment.url );
      // Do something with attachment.id and/or attachment.url here
    });

    // Finally, open the modal
    file_frame.open(); 
  }); 

});