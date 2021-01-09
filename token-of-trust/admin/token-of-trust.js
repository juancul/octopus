(function ($) {

	$(document).ready(function(){
        var $body = $( 'body' );
		$body.on( 'click', '.tot-dismiss-notice', dismissNotice);
        $body.on( 'change', 'select[data-tot-approval-status]', userApproval);
	});

    //////////

    function userApproval(evt) {
        var $select = $(evt.currentTarget);
        var newState = $select.val();
        var userId = $select.data('totApprovalStatus');
        var totUserId = $select.data('totUserId');
        var $wrapper = $select.parents('[data-tot-approval-status-wrap]');
        var $spinner = $wrapper.find('.spinner');

        $wrapper.addClass('tot-loading');
        $spinner.addClass('is-active');
        $select.prop('disabled', true);

        $.ajax( window.ajaxurl, {
            type: 'POST',
            data: {
                action: 'tot_set_user_approval',
                newState: newState,
                userId: userId
            }
        }).then(
            function(data) {
                $wrapper.removeClass('tot-loading');
                $spinner.removeClass('is-active');
                $select.prop('disabled', false);
                $row = $('#user-' + userId);
                var rolesString = '';
                for(var key in data.roles) {
                    if(!data.roles.hasOwnProperty(key)) {
                        continue;
                    }
                    if(rolesString !== '') {
                        rolesString += ', ';
                    }
                    rolesString += data.roles[key];
                }
                $row.find('td.column-role').html(rolesString);

                console.info(totUserId);
                $('[data-tot-widget][data-app-userid="' + totUserId + '"]').each(function(i, el) {
                    var $widget = $(el);
                    $widget.find('iframe').remove();
                    $widget
                        .removeAttr('data-tot-state')
                        .removeAttr('data-tot-index')
                        .attr('data-tot-override-status', newState);
                });

                window.tot('embedsInitialize');
            },
            function() {
                $wrapper.removeClass('tot-loading');
                $spinner.removeClass('is-active');
                $select.replaceWith('<p>Error</p>');
            }
        );
    }

    function dismissNotice(evt) {
        var type = $(evt.currentTarget).data( 'notice' );
        $.ajax( window.ajaxurl, {
            type: 'POST',
            data: {
                action: 'tot_dismissed_notice_handler',
                type: type
            }
        });
    }
})(jQuery);

(function ($) {
    $(document).ready(function() {
        if( typeof $().select2 !== 'function') {
            return;
        }
        $('select.tot_field_multiselect').select2();
    });
})(jQuery);