(function($){

    "use strict";

    var AMListItems = {

        init: function()
        {
            // Document ready.
            this._bind();
        },

        /**
         * Binds events for the Form Builder.
         *
         * @since 1.0.0
         * @access private
         * @method _bind
         */
        _bind: function()
        {
            $( document ).on('click', '#auto-mail-check-all-lists', AMListItems._checkAll );
            $( document ).on('click', '.auto-mail-delete-action', AMListItems._deleteAction );
            $( document ).on('click', '.auto-mail-bulk-action-button', AMListItems._preparePost );
        },

        /**
         * Check All
         *
         */
         _checkAll: function( ) {

            if($(this).prop('checked')){
                $('.auto-mail-check-single-list').prop('checked', true);
            }else{
                $('.auto-mail-check-single-list').prop('checked', false);

            }

        },

        /**
         * Delete Action
         *
         */
         _deleteAction: function( ) {

            var data = $(this).data('list-id');

            $('.auto-mail-delete-id').val(data);


        },

        /**
         * Prepare data before post action
         *
         */
         _preparePost: function( ) {

            var ids = [];
            $('.auto-mail-check-single-list').each(function( index ) {
                if($(this).prop('checked')){
                    var value = $(this).val();
                    ids.push(value);
                }
            });

            $('#auto-mail-select-lists-ids').val(ids);

        },

    };

    /**
     * Initialize AMListItems
     */
    $(function(){
        AMListItems.init();
    });

})(jQuery);
