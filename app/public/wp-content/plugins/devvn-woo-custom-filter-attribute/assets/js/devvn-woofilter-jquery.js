(function($){
    //image upload
    $('body').on('click','.wcfa-upload',function(e){
        // Prevents the default action from occuring.
        e.preventDefault();
        var thisUpload = $(this).parents('.wcfa-upload-image');
        // Sets up the media library frame
        meta_image_frame = wp.media.frames.meta_image_frame = wp.media({
            title: 'Upload Image',
            button: { text:  'Upload Image' },
            library: { type: 'image' },
            multiple: false
        });
        // Runs when an image is selected.
        meta_image_frame.on('select', function(){
            // Grabs the attachment selection and creates a JSON representation of the model.
            var media_attachment = meta_image_frame.state().get('selection').first().toJSON();
            // Sends the attachment URL to our custom image input field.

            if ( media_attachment.id ) {
                var attachment_image = media_attachment.sizes && media_attachment.sizes.thumbnail ? media_attachment.sizes.thumbnail.url : media_attachment.url;

                thisUpload.addClass('wcfa-has-image');
                thisUpload.find('input[type="hidden"]').val(media_attachment.id);
                thisUpload.find('img.wcfa-image_view').attr('src',media_attachment.url);
                thisUpload.closest('tr').find('input[type="text"]').trigger('change');
            }
        });
        // Opens the media library frame.
        meta_image_frame.open();
    });


    $('body').on('click','.wcfa-delete-image',function(){
        var parentDiv = $(this).parents('.wcfa-upload-image');
        parentDiv.removeClass('wcfa-has-image');
        parentDiv.find('input[type="hidden"]').val('');
        parentDiv.closest('tr').find('input[type="text"]').trigger('change');
        return false;
    });

    function initColorPicker( widget ) {
        widget.find( '.wcfa-color' ).wpColorPicker( {
            change: _.throttle( function() { // For Customizer
                $(this).trigger( 'change' );
            }, 3000 ),
            clear: _.throttle( function() { // For Customizer
                $(this).trigger( 'change' );
            }, 4000 )
        });
    }

    function onFormUpdate( event, widget ) {
        initColorPicker( widget );
    }

    $( document ).on( 'widget-added widget-updated', onFormUpdate );

    $( 'div[id*="_devvn_wcfa_layered_nav-"]' ).not('[id*="__i__"]').each( function () {
        initColorPicker( $( this ) );
    } );

    $('body').on('change', '.change_to_ajax_attr', function(){
        var thisWrap = $(this).closest('form');
        var thisWCFA = thisWrap.find('.devvn_woo_filter');
        thisWCFA.addClass('wcfa_loading');
        var tax_slug = $(this).val();
        var value_default = thisWrap.find('.value_default').val();
        var key_default = thisWrap.find('.key_default').val();
        $.ajax({
            type : "post",
            dataType : "json",
            url : devvn_wcfa_array.ajaxurl,
            data : {
                action: "wcfa_get_terms_attr",
                tax_slug : tax_slug,
                value_default: value_default,
                key_default: key_default
            },
            context: this,
            beforeSend: function(){

            },
            success: function(response) {
                var data = response.data;
                if(response.success){
                    if(data) {
                        $.each(data.fragments, function (key, value) {
                            $(key, thisWrap).html(value);
                            initColorPicker(thisWrap);
                        });
                    }else{
                        thisWCFA.html(data.mess);
                    }
                }else{
                    thisWCFA.html(data.mess);
                }
                thisWCFA.removeClass('wcfa_loading');
            },
            error: function( jqXHR, textStatus, errorThrown ){
                thisWCFA.removeClass('wcfa_loading');
                thisWCFA.html('');
            }
        })
    });

})(jQuery);