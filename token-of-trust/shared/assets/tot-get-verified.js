(function($){

    $(document).ready(function () {
        $(document.body)
            .on( 'checkout_error', check_errors_for_tot)
            .on( 'click', 'a[href="#tot_get_verified"]', openModal);

        if($('[data-tot-verify-age]').length > 0) {
            // Is this used?
            openModal();
        }
        if($('[data-tot-auto-open-modal="true"]').length > 0) {
            openModal();
        }
    });

    //////////

    function check_errors_for_tot() {
        var errorText = $('.woocommerce-error').find('li').first().text().trim();
        if ( errorText ==='Verification with Token of Trust is required to complete your order.' ) {
            openModal();
        }
    }

    function openModal(event) {
        console.debug('Call to modal open with window of type %s.', window.totModalType);
        if(!window.totModalType || !window.totModalParams || !window.tot) {
            return;
        }

        if(event && event.preventDefault) {
            event.preventDefault();
        }

        window.tot("modalOpen", window.totModalType, window.totModalParams);
    }

})(jQuery);