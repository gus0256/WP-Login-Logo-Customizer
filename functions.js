jQuery(document).ready(function($) 
{   
   // Uploading files
    var file_frame;
     
    jQuery('#image_button').live('click', function( event )
    {
    event.preventDefault();
     
    // If the media frame already exists, reopen it.
    if ( file_frame )
     {
        file_frame.open();
        return;
    }
     
    // Create the media frame.
    file_frame = wp.media.frames.file_frame = wp.media(
    {
    title: jQuery( this ).data( 'uploader_title' ),
    button: {
    text: jQuery( this ).data( 'uploader_button_text' ),
    },
    multiple: false // Set to true to allow multiple files to be selected
    });
    // When an image is selected, run a callback.
    file_frame.on('select',function()
        {
            attachment = file_frame.state().get('selection').first().toJSON();
            $("#image_url_field").val(attachment.url);
        }
    );
    file_frame.open();
    });
    
    jQuery('#reset_button').live('click',function(event)
    {
        event.preventDefault();
        defaultImage = $('#defaultLogoAddress').val();
        $('#image_url_field').val(defaultImage);
    });
});