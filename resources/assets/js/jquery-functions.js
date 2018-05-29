

jQuery(function () {
    jQuery('[data-toggle="tooltip"]').tooltip();
})

jQuery('#close-menu').click(function() {
    jQuery('#wrapper').toggleClass('toggled');
});

jQuery(document).ready(function() {
    jQuery("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });

    jQuery.each( jQuery('.nav-item.dropdown a.nav-link.dropdown-parent'), function( key, value ) {
        if (jQuery(this).parent().find('.show').length > 0)
            jQuery(this).attr('aria-expanded', 'true');
    });

    jQuery('li a[role=button]').click(function() {
        if (jQuery(this).attr('aria-expanded') == 'false') {
            jQuery(this).attr('aria-expanded', 'true');
            jQuery(this).parent().find('div[aria-labelledby=navbarDropdown]').toggleClass('show');
        } else {
            jQuery(this).attr('aria-expanded', 'false');
            jQuery(this).parent().find('div[aria-labelledby=navbarDropdown]').toggleClass('show');
        }
    });

    jQuery('select#banks').on('change', function(e) {
        var bank_id = e.target.value;
        var selector = jQuery(this).parent();
        selector.find('small').remove();
        jQuery.get('/api/banks/' + bank_id, function(data) {
            if (data)
                selector.append('<small><strong>Balance: ' + data.balance + '</strong></small>');
        }); 
    }).trigger('change');
    jQuery('button.close').click(function() {
        jQuery(this).parent().fadeOut();
    });


    // Handles Print
    printModule();

});


 // Handles Print
function printModule() {
    jQuery('.btn-print-modal').click(function() {
        var type = jQuery(this).attr('expense-type');
        var id = jQuery(this).attr('expense-id');

        jQuery.get('/' + type + '/print/' + id, function(data) {
            if (data) {
                jQuery('#printer .modal-body').html(data);
                jQuery('#printer').modal('toggle');

                jQuery('#printer .btn-print-cancel').click(function() {
                    jQuery('#printer .btn-print').unbind();
                    jQuery('#printer').modal('toggle');
                });

                jQuery('#printer .btn-print').click(function() {
                    jQuery('#print-element').printThis({
                        importStyle: true,
                    });
                    // window.JWSI.printDiv('print-element');
                });
            }
        });

    });

}
