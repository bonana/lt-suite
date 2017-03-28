( function( $ ) {
    var suggest_lock = false;
    var select_lock = false;

    $( '.suggested-product .row-thumbnail' ).on( 'load', function( e ) {
        $( '.suggested-product .loading-overlay' ).removeClass( 'loading' );
    } );

    $( '.theme-select' ).click( function( e ) {
        if ( select_lock ) return false;
        select_lock = true;

        e.preventDefault();
        e.stopImmediatePropagation();

        $( '#global-loading-overlay' ).addClass( 'loading' );

        $.post( REST.url + 'envato/change', { 'theme-url' : $(this).attr( 'data-site-url' ), 'envato-url' : $(this).attr( 'data-theme-url' ) }, function( data ) {
            if ( data ) {
                data = JSON.parse( data );

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
                $chosen_theme.find( '.demo-link' ).attr( 'href', '//' + data.site + data.url );
                $chosen_theme.find( '.row-thumbnail' )[0].src = data.image;
            }

            $( '#envato-suggest-btn' ).trigger( 'click' );
            $( '#global-loading-overlay' ).removeClass( 'loading' );

            select_lock = false;
        } );

        $( '#envato-suggest-btn' ).click( function( e ) {
            if ( suggest_lock ) return false;
            suggest_lock = true;

            e.preventDefault();
            e.stopImmediatePropagation();

            var self = $(this);
            var $products = $( '.suggested-product' );

            $products.find( '.loading-overlay' ).addClass( 'loading' );

            $.get( REST.url + self.attr( 'data-next-page' ), function( data ) {
                if ( data ) {
                    data = JSON.parse( data );

                    self.attr( 'data-next-page', data.next_page );

                    $products.each( function( i, obj ) {
                        $(obj).find( '.row-thumbnail' )[0].src data.pictures[i];
                        $(obj).find( '.theme-select' ).attr( 'data-theme-url', data.urls[i] );
                    } );
                }
            } );
        } );
    } );
} )( jQuery );