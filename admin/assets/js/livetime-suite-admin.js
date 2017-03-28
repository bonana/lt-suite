(function($) {
    $('#email_product_add').click(function(e) {
        const $container = $('#email_product_container');
        const newIndex = $container.children().length + 1;

        var newElement = '<div style="margin-top:20px;">';
        newElement += '<h3>Produkt #' + newIndex + '</h3>';

        newElement += '<div class="form-set">';
        newElement += '<input type="text" name="email_product_name[]" id="email_product_name_' + newIndex + '" placeholder="Namn"><label for="email_product_name_' + newIndex + '">Namn</label>';
        newElement += '</div>';

        newElement += '<div class="form-set">';
        newElement += '<textarea name="email_product_description[]" id="email_product_description_' + newIndex + '" placeholder="Beskrivning"></textarea>';
        newElement += '<label for="email_product_description_' + newIndex + '">Beskrivning</label>';
        newElement += '</div>';

        newElement += '<div class="form-set">';
        newElement += '<input type="text" name="email_product_price[]" id="email_product_price_' + newIndex + '" placeholder="Pris">';
        newElement += '<label for="email_product_price_' + newIndex + '">Pris</label>';
        newElement += '</div>';

        newElement += '<div class="form-set">';
        newElement += '<input type="text" name="email_product_qty[]" id="email_product_qty_' + newIndex + '" placeholder="Antal">';
        newElement += '<label for="email_product_qty_' + newIndex + '">Antal</label>';
        newElement += '</div>';


        newElement += '</div>';

        $container.append(newElement);
    });

    $('form.ltwp-email-form').submit(function(e) {
        return window.confirm('Vill du verkligen skicka?');
    });

    $(document).on('click', '.send-invoice', function(e) {
        var project_id = $(this).attr('data-project-id');

        if ( ! project_id ) return false;

        $.post($(this).attr('href'), { 'action' : 'livetime_suite_send_invoice', 'project_id' : project_id }, function(data) {
            console.log(data);
            console.log('sent');
        });

        return false;
    });

    $(document).ready(function() {
        var options = {
            valueNames: [ 'name' ]
        };

        var projectList = new List('projects', options);
    });
})(jQuery);