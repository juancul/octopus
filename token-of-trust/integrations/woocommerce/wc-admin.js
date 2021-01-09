(function($){

    var quarantineButtonSelector = 'a[href="#tot_remove_quarantine"]';
    var emailReminderSelector = 'a[href="#tot_order_detail_verification_reminder"]';

    $(document).ready(function(){
        $('body')
            .on('click', quarantineButtonSelector, removeQuarantine)
            .on('click', emailReminderSelector, emailReminder);
    });

    //////////

    function removeQuarantine( event ) {
        event.preventDefault();
        var $el = $(event.currentTarget);
        var order = $el.data('order');
        var $spinner = $('<span class="spinner is-active"></span>');
        var $buttons = $(quarantineButtonSelector);

        var confirmation = confirm('Are you sure you want to remove the Token of Trust Verification Hold?');

        if(!confirmation) {
            return;
        }

        $buttons.addClass('tot-button-loading').append($spinner);

        if(!window.ajaxurl) {
            removeQuarantineFailed();
            return;
        }

        $.ajax({
            type: "POST",
            url: window.ajaxurl,
            data: {
                'action': 'tot_wc_order_unquarantine',
                'order_id': order
            },
            success: removeQuarantineSuccess,
            error: removeQuarantineFailed
        });
    }

    function removeQuarantineFailed() {
        removeQuarantLoading();
    }

    function removeQuarantineSuccess(data) {

        if(!data || (data.success === false)) {
            removeQuarantineFailed();
            return;
        }
        document.location.reload();
    }

    function removeQuarantLoading() {
        var $buttons = $(quarantineButtonSelector);
        $buttons.removeClass('tot-button-loading').find('.spinner').remove();
    }

    function emailReminder( event ) {
        event.preventDefault();
        var $el = $(event.currentTarget);
        var order = $el.data('order');
        var $spinner = $('<span class="spinner is-active"></span>');
        var $buttons = $(emailReminderSelector);

        var confirmation = confirm('Are you sure you want to email the user?');

        if(!confirmation) {
            return;
        }

        $buttons.addClass('tot-button-loading').append($spinner);

        if(!window.ajaxurl) {
            removeQuarantineFailed();
            return;
        }

        console.info('order', order, $el);

        $.ajax({
            type: "POST",
            url: window.ajaxurl,
            data: {
                'action': 'tot_wc_email_reminder',
                'order_id': order
            },
            success: emailSuccess,
            error: emailError
        });
    }

    function emailSuccess( data ) {
        if(!data || (data.success === false)) {
            emailError();
            return;
        }
        var $buttons = $(emailReminderSelector);
        $buttons.removeClass('tot-button-loading').find('.spinner').remove();
    }

    function emailError() {
        var $buttons = $(emailReminderSelector);
        $buttons.removeClass('tot-button-loading').find('.spinner').remove();
    }

})(jQuery);