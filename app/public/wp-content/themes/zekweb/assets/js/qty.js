/*Woo qty*/
jQuery( function( $ ) {
    // Check if we're on a cart page and if wc_cart_params exists
    var isCartPage = $('form.woocommerce-cart-form').length > 0;
    
    if ( ! String.prototype.getDecimals ) {
        String.prototype.getDecimals = function() {
            var num = this,
                match = ('' + num).match(/(?:\.(\d+))?(?:[eE]([+-]?\d+))?$/);
            if ( ! match ) {
                return 0;
            }
            return Math.max( 0, ( match[1] ? match[1].length : 0 ) - ( match[2] ? +match[2] : 0 ) );
        }
    }
 
    function wcqi_refresh_quantity_increments(){
        $( 'div.quantity:not(.buttons_added), td.quantity:not(.buttons_added)' ).addClass( 'buttons_added' ).append( '<input type="button" value="+" class="plus" />' ).prepend( '<input type="button" value="-" class="minus" />' );
    }
 
    $( document ).on( 'updated_wc_div', function() {
        wcqi_refresh_quantity_increments();
    } );
 
    $( document ).on( 'click', '.plus, .minus', function() {
        // Get values
        var $qty      = $( this ).closest( '.quantity' ).find( '.qty'),
            currentVal = parseFloat( $qty.val() ),
            max          = parseFloat( $qty.attr( 'max' ) ),
            min          = parseFloat( $qty.attr( 'min' ) ),
            step      = $qty.attr( 'step' );
 
        // Format values
        if ( ! currentVal || currentVal === '' || currentVal === 'NaN' ) currentVal = 0;
        if ( max === '' || max === 'NaN' ) max = '';
        if ( min === '' || min === 'NaN' ) min = 0;
        if ( step === 'any' || step === '' || step === undefined || parseFloat( step ) === 'NaN' ) step = 1;
 
        // Change the value
        if ( $( this ).is( '.plus' ) ) {
            if ( max && ( currentVal >= max ) ) {
                $qty.val( max );
            } else {
                $qty.val( ( currentVal + parseFloat( step )).toFixed( step.getDecimals() ) );
            }
        } else {
            if ( min && ( currentVal <= min ) ) {
                $qty.val( min );
            } else if ( currentVal > 0 ) {
                $qty.val( ( currentVal - parseFloat( step )).toFixed( step.getDecimals() ) );
            }
        }
 
        // Trigger change event
        $qty.trigger( 'change' );
        
        // Auto update cart when in cart page
        if ($('form.woocommerce-cart-form').length) {
            // Add loading state
            $('form.woocommerce-cart-form').addClass('processing').block({
                message: null,
                overlayCSS: {
                    background: '#fff',
                    opacity: 0.6
                }
            });
            
            // Get the form data
            var data = $('form.woocommerce-cart-form').serialize();
            
            // Add action to update cart
            data += '&action=woocommerce_update_cart&update_cart=Update+Cart';
            
            // AJAX request to update cart
            $.ajax({
                type: 'POST',
                url: wc_cart_params.ajax_url,
                data: data,
                dataType: 'html',
                success: function(response) {
                    // Update cart fragments
                    var $html = $.parseHTML(response);
                    var $form = $($html).find('.woocommerce-cart-form');
                    var $totals = $($html).find('.cart_totals');
                    
                    // Replace the cart form and totals
                    $('.woocommerce-cart-form').replaceWith($form);
                    $('.cart_totals').replaceWith($totals);
                    
                    // Trigger updated_cart_totals event
                    $(document.body).trigger('updated_cart_totals');
                    $(document.body).trigger('wc_fragment_refresh');
                },
                complete: function() {
                    // Remove loading state
                    $('form.woocommerce-cart-form').removeClass('processing').unblock();
                    wcqi_refresh_quantity_increments();
                }
            });
        }
    });
    wcqi_refresh_quantity_increments();
    
    // Handle direct input changes for quantity fields in cart
    if (isCartPage) {
        $(document).on('change', '.woocommerce-cart-form .qty', function() {
            // Delay to allow for typing
            clearTimeout(window.quantityUpdateTimer);
            window.quantityUpdateTimer = setTimeout(function() {
                $('[name="update_cart"]').trigger('click');
            }, 500);
        });
    }
});