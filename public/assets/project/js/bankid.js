(function( $ ) {
    var interval_handle = null,
        order_id        = null,
        in_progress     = false,
        project_hash    = $( '#livetime-suite-project-hash' ).val(),
        $bankid_tooltip = $( '#bankid-info-tooltip' );

    function bankid_collect()
    {
        if ( in_progress ) return;

        in_progress = true;

        $.get( REST.url + 'bankid/collect', { 'order_ref' : order_id, 'project_hash' : project_hash }, function( data ) {
            if ( data ) {
                data = JSON.parse( data );

                $bankid_tooltip.html( data.message );

                if ( data.complete )
                    clearInterval( interval_handle );
                if ( data.error )
                    clearInterval( interval_handle );

                in_progress = false;
            }
        });
    }

    function bankid_sign( personal_number, data )
    {
        if ( in_progress ) return;
        in_progress = true;

        $bankid_tooltip.html( 'Vänta...' );

        $.post( REST.url + 'bankid/sign', { 'personal_number' : personal_number, 'data' : data }, function( data ) {
            data = JSON.parse( data );
            order_id = data.order_ref;
            in_progress = false;

            bankid_collect();
            interval_handle = setInterval( bankid_collect, 2000 );
        });
    }

    $( '.web-email-bankid-btn' ).click( function( e ) {
        e.preventDefault();
        e.stopImmediatePropagation();
        clearInterval( interval_handle );

        var pn_regex = /\d{8}-?\d{4}/;
        var personal_number = $( '#livetime-suite-personal-number' ).val();

        if ( personal_number === null || !personal_number.match(pn_regex) ) {
            $bankid_tooltip.html( 'Du måste skriva in ett personnummer i form av YYYYMMDD-XXXX.' );
            return false;
        }

        bankid_sign( personal_number, 'test data' );
    });
})( jQuery );