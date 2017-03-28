( function( $ ) {
    // INSERT MODAL.
    var contract_modal_div = document.createElement( 'div' );
    contract_modal_div.id = "contract-modal";

    var contract_html = "<div class='contract-modal-close-btn'><span>x</span></div>";
    //contract_html += "<div class='contract-modal-scroll'>v</div>";
    contract_html += "<div class='contract-modal-content'>";
    contract_html += "<h1>Test</h1>";
    contract_html += "<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus ullamcorper volutpat nulla ut tempus. Praesent rhoncus arcu sed nunc rutrum, a vulputate lacus dignissim. Proin purus arcu, blandit et condimentum quis, consectetur sit amet felis. Cras cursus felis vitae purus eleifend, quis egestas odio sollicitudin. Duis vestibulum, nulla eu venenatis fermentum, ipsum mauris hendrerit metus, eget ultricies lectus lectus nec orci. Etiam a leo facilisis, placerat lacus vel, porttitor quam. Nulla ipsum lorem, ultricies in ex sit amet, ornare lacinia felis. Integer sit amet mollis magna. Suspendisse aliquet consectetur leo id rhoncus.</p>";
    contract_html += "<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus ullamcorper volutpat nulla ut tempus. Praesent rhoncus arcu sed nunc rutrum, a vulputate lacus dignissim. Proin purus arcu, blandit et condimentum quis, consectetur sit amet felis. Cras cursus felis vitae purus eleifend, quis egestas odio sollicitudin. Duis vestibulum, nulla eu venenatis fermentum, ipsum mauris hendrerit metus, eget ultricies lectus lectus nec orci. Etiam a leo facilisis, placerat lacus vel, porttitor quam. Nulla ipsum lorem, ultricies in ex sit amet, ornare lacinia felis. Integer sit amet mollis magna. Suspendisse aliquet consectetur leo id rhoncus.</p>";
    contract_html += "<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus ullamcorper volutpat nulla ut tempus. Praesent rhoncus arcu sed nunc rutrum, a vulputate lacus dignissim. Proin purus arcu, blandit et condimentum quis, consectetur sit amet felis. Cras cursus felis vitae purus eleifend, quis egestas odio sollicitudin. Duis vestibulum, nulla eu venenatis fermentum, ipsum mauris hendrerit metus, eget ultricies lectus lectus nec orci. Etiam a leo facilisis, placerat lacus vel, porttitor quam. Nulla ipsum lorem, ultricies in ex sit amet, ornare lacinia felis. Integer sit amet mollis magna. Suspendisse aliquet consectetur leo id rhoncus.</p>";
    contract_html += "<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus ullamcorper volutpat nulla ut tempus. Praesent rhoncus arcu sed nunc rutrum, a vulputate lacus dignissim. Proin purus arcu, blandit et condimentum quis, consectetur sit amet felis. Cras cursus felis vitae purus eleifend, quis egestas odio sollicitudin. Duis vestibulum, nulla eu venenatis fermentum, ipsum mauris hendrerit metus, eget ultricies lectus lectus nec orci. Etiam a leo facilisis, placerat lacus vel, porttitor quam. Nulla ipsum lorem, ultricies in ex sit amet, ornare lacinia felis. Integer sit amet mollis magna. Suspendisse aliquet consectetur leo id rhoncus.</p>";
    contract_html += "<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus ullamcorper volutpat nulla ut tempus. Praesent rhoncus arcu sed nunc rutrum, a vulputate lacus dignissim. Proin purus arcu, blandit et condimentum quis, consectetur sit amet felis. Cras cursus felis vitae purus eleifend, quis egestas odio sollicitudin. Duis vestibulum, nulla eu venenatis fermentum, ipsum mauris hendrerit metus, eget ultricies lectus lectus nec orci. Etiam a leo facilisis, placerat lacus vel, porttitor quam. Nulla ipsum lorem, ultricies in ex sit amet, ornare lacinia felis. Integer sit amet mollis magna. Suspendisse aliquet consectetur leo id rhoncus.</p>";
    contract_html += "<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus ullamcorper volutpat nulla ut tempus. Praesent rhoncus arcu sed nunc rutrum, a vulputate lacus dignissim. Proin purus arcu, blandit et condimentum quis, consectetur sit amet felis. Cras cursus felis vitae purus eleifend, quis egestas odio sollicitudin. Duis vestibulum, nulla eu venenatis fermentum, ipsum mauris hendrerit metus, eget ultricies lectus lectus nec orci. Etiam a leo facilisis, placerat lacus vel, porttitor quam. Nulla ipsum lorem, ultricies in ex sit amet, ornare lacinia felis. Integer sit amet mollis magna. Suspendisse aliquet consectetur leo id rhoncus.</p>";
    contract_html += "<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus ullamcorper volutpat nulla ut tempus. Praesent rhoncus arcu sed nunc rutrum, a vulputate lacus dignissim. Proin purus arcu, blandit et condimentum quis, consectetur sit amet felis. Cras cursus felis vitae purus eleifend, quis egestas odio sollicitudin. Duis vestibulum, nulla eu venenatis fermentum, ipsum mauris hendrerit metus, eget ultricies lectus lectus nec orci. Etiam a leo facilisis, placerat lacus vel, porttitor quam. Nulla ipsum lorem, ultricies in ex sit amet, ornare lacinia felis. Integer sit amet mollis magna. Suspendisse aliquet consectetur leo id rhoncus.</p>";
    contract_html += "<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus ullamcorper volutpat nulla ut tempus. Praesent rhoncus arcu sed nunc rutrum, a vulputate lacus dignissim. Proin purus arcu, blandit et condimentum quis, consectetur sit amet felis. Cras cursus felis vitae purus eleifend, quis egestas odio sollicitudin. Duis vestibulum, nulla eu venenatis fermentum, ipsum mauris hendrerit metus, eget ultricies lectus lectus nec orci. Etiam a leo facilisis, placerat lacus vel, porttitor quam. Nulla ipsum lorem, ultricies in ex sit amet, ornare lacinia felis. Integer sit amet mollis magna. Suspendisse aliquet consectetur leo id rhoncus.</p>";
    contract_html += "<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus ullamcorper volutpat nulla ut tempus. Praesent rhoncus arcu sed nunc rutrum, a vulputate lacus dignissim. Proin purus arcu, blandit et condimentum quis, consectetur sit amet felis. Cras cursus felis vitae purus eleifend, quis egestas odio sollicitudin. Duis vestibulum, nulla eu venenatis fermentum, ipsum mauris hendrerit metus, eget ultricies lectus lectus nec orci. Etiam a leo facilisis, placerat lacus vel, porttitor quam. Nulla ipsum lorem, ultricies in ex sit amet, ornare lacinia felis. Integer sit amet mollis magna. Suspendisse aliquet consectetur leo id rhoncus.</p>";
    contract_html += "<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus ullamcorper volutpat nulla ut tempus. Praesent rhoncus arcu sed nunc rutrum, a vulputate lacus dignissim. Proin purus arcu, blandit et condimentum quis, consectetur sit amet felis. Cras cursus felis vitae purus eleifend, quis egestas odio sollicitudin. Duis vestibulum, nulla eu venenatis fermentum, ipsum mauris hendrerit metus, eget ultricies lectus lectus nec orci. Etiam a leo facilisis, placerat lacus vel, porttitor quam. Nulla ipsum lorem, ultricies in ex sit amet, ornare lacinia felis. Integer sit amet mollis magna. Suspendisse aliquet consectetur leo id rhoncus.</p>";
    contract_html += "<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus ullamcorper volutpat nulla ut tempus. Praesent rhoncus arcu sed nunc rutrum, a vulputate lacus dignissim. Proin purus arcu, blandit et condimentum quis, consectetur sit amet felis. Cras cursus felis vitae purus eleifend, quis egestas odio sollicitudin. Duis vestibulum, nulla eu venenatis fermentum, ipsum mauris hendrerit metus, eget ultricies lectus lectus nec orci. Etiam a leo facilisis, placerat lacus vel, porttitor quam. Nulla ipsum lorem, ultricies in ex sit amet, ornare lacinia felis. Integer sit amet mollis magna. Suspendisse aliquet consectetur leo id rhoncus.</p>";
    contract_html += "<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus ullamcorper volutpat nulla ut tempus. Praesent rhoncus arcu sed nunc rutrum, a vulputate lacus dignissim. Proin purus arcu, blandit et condimentum quis, consectetur sit amet felis. Cras cursus felis vitae purus eleifend, quis egestas odio sollicitudin. Duis vestibulum, nulla eu venenatis fermentum, ipsum mauris hendrerit metus, eget ultricies lectus lectus nec orci. Etiam a leo facilisis, placerat lacus vel, porttitor quam. Nulla ipsum lorem, ultricies in ex sit amet, ornare lacinia felis. Integer sit amet mollis magna. Suspendisse aliquet consectetur leo id rhoncus.</p>";
    contract_html += "<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus ullamcorper volutpat nulla ut tempus. Praesent rhoncus arcu sed nunc rutrum, a vulputate lacus dignissim. Proin purus arcu, blandit et condimentum quis, consectetur sit amet felis. Cras cursus felis vitae purus eleifend, quis egestas odio sollicitudin. Duis vestibulum, nulla eu venenatis fermentum, ipsum mauris hendrerit metus, eget ultricies lectus lectus nec orci. Etiam a leo facilisis, placerat lacus vel, porttitor quam. Nulla ipsum lorem, ultricies in ex sit amet, ornare lacinia felis. Integer sit amet mollis magna. Suspendisse aliquet consectetur leo id rhoncus.</p>";
    contract_html += "<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus ullamcorper volutpat nulla ut tempus. Praesent rhoncus arcu sed nunc rutrum, a vulputate lacus dignissim. Proin purus arcu, blandit et condimentum quis, consectetur sit amet felis. Cras cursus felis vitae purus eleifend, quis egestas odio sollicitudin. Duis vestibulum, nulla eu venenatis fermentum, ipsum mauris hendrerit metus, eget ultricies lectus lectus nec orci. Etiam a leo facilisis, placerat lacus vel, porttitor quam. Nulla ipsum lorem, ultricies in ex sit amet, ornare lacinia felis. Integer sit amet mollis magna. Suspendisse aliquet consectetur leo id rhoncus.</p>";
    contract_html += "</div>";

    contract_modal_div.innerHTML = contract_html;
    document.body.insertBefore( contract_modal_div, document.body.childNodes[0] );

    var suggest_lock = false;
    var select_lock = false;

    $( '#contract-btn' ).click( function( e ) {
        e.preventDefault();
        e.stopImmediatePropagation();

        $( '#contract-modal' ).fadeIn({
            duration: 225,
            easing: 'easeOutExpo'
        });
    } );

    $( '#contract-modal, .contract-modal-close-btn' ).click( function( e ) {
        e.preventDefault();

        $( '#contract-modal' ).fadeOut({
            duration: 195,
            easing: 'easeInExpo'
        });
    });

    $ ( '.contract-modal-content' ).click( function( e ) {
        e.preventDefault();
        e.stopImmediatePropagation();
    });

    $( '.suggested-product .row-thumbnail' ).on( 'load', function( e ) {
        $( '.suggested-product .loading-overlay' ).removeClass( 'loading' );
    } );

    // HANDLE CHANGING THEMES.
    $( '.theme-select' ).click( function( e ) {
        if ( select_lock ) return false;
        select_lock = true;

        e.preventDefault();
        e.stopImmediatePropagation();

        $( '#global-loading-overlay' ).addClass( 'loading' );

        $.post( REST.url + 'envato/change', { 'theme-url' : $(this).attr( 'data-site-url' ), 'envato-url' : $(this).attr( 'data-theme-url' ), 'project-hash' : $( '#project-hash' ).val() }, function( data ) {
            if ( data ) {
                var $chosen_theme = $( '.chosen-theme' );
                $chosen_theme.find( '.row-info-title' ).html( data.name );

                var new_info_list = '';

                data.attributes = data.attributes.filter( function( item ) {
                    return item.value !== null;
                } );

                data.attributes = data.attributes.map( function( item ) {
                    if ( item.constructor === Array )
                        return item.join( ', ' );

                    return item;
                } );

                var attribute_len = data.attributes.length;

                for ( i = 0; i < attribute_len; i++ ) {
                    new_info_list += '<li><strong>' + data.attributes[i].label + ':</strong> ' + data.attributes[i].value + '</li>';
                }

                $chosen_theme.find( '.row-info-list' ).html( new_info_list );
                $chosen_theme.find( '.demo-link' ).attr( 'href', data.preview );
                $chosen_theme.find( '.row-thumbnail' )[0].src = data.image;
            }

            $( '#envato-suggest-btn' ).trigger( 'click' );
            $( '#global-loading-overlay' ).removeClass( 'loading' );

            select_lock = false;
        } );
    } );

    $( '#envato-suggest-btn' ).click( function( e ) {
        if ( suggest_lock ) return false;
        suggest_lock = true;

        e.preventDefault();
        e.stopImmediatePropagation();

        var self = $(this);
        var $products = $( '.suggested-product' );

        $products.find( '.loading-overlay' ).addClass( 'loading' );

        $.get( REST.url + 'envato/suggest', { 'next-page' : self.attr( 'data-next-page' ) }, function( data ) {
            if ( data ) {
                self.attr( 'data-next-page', data.next_page );

                $products.each( function( i, obj ) {
                    $(obj).find( '.row-thumbnail' )[0].src = data.pictures[i];
                    $(obj).find( '.theme-select' ).attr( 'data-theme-url', data.urls[i] );
                    $(obj).find( '.theme-select' ).attr( 'data-site-url', data.site_urls[i] );
                } );
            }

            suggest_lock = false;
        } );
    } );

    $('#sign-btn').click(function(e) {
        var payment_option = $('#payment-option:checked').val();

        if ( !payment_option ) return false;

        $.post(REST.url + 'project/sign', { 'project_hash' : $('#project-hash').val(), 'payment_option' : $('#payment-option').val() }, function(data) {
            if ( data ) {
                data = JSON.parse( data );

                if ( data.success ) {
                    window.scrollTo(0, 0);
                    window.location.reload();
                }
            }
        });

        return false;
    });
} )( jQuery );