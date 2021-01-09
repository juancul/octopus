jQuery( document ).ready( function($) {
    $(document).on( 'click', '.mstore-delete-json-file', function() {
        var id = $(this).data('id');
        $.ajax({
            type: 'post',
            url: MyAjax.ajaxurl,
            data: {
                action: 'mstore_delete_json_file',
                id: id
            },
            success: function( result ) {
                if( result == 'success' ) {
                    location.reload();
                }
            }
        })
        return false;
    })

    $(document).on( 'blur', '.mstore-update-limit-product', function() {
        var limit = $(this).val();
        $.ajax({
            type: 'post',
            url: MyAjax.ajaxurl,
            data: {
                action: 'mstore_update_limit_product',
                limit: limit
            },
            success: function( result ) {
                if( result == 'success' ) {
                }
            }
        })
        return false;
    })
})