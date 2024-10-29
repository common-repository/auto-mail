(function($){

    "use strict";

    var AMCampaignList = {

        init: function()
        {
            this._bind();
            // AMCampaignList._autoRefresh();
        },

        /**
         * Binds events for the Auto Mail List.
         *
         * @since 1.0.0
         * @access private
         * @method _bind
         */
        _bind: function()
        {

            $( document ).on('click', '.auto-mail-delete-action', AMCampaignList._deleteAction );
            $( document ).on('click', '#auto-mail-check-all-campaigns', AMCampaignList._checkAll );
            $( document ).on('click', '.auto-mail-bulk-action-button', AMCampaignList._preparePost );

        },

        /**
         * Auto Refresh
         *
         */
        _autoRefresh: function( ) {

            setInterval(function(){
                window.location.reload(1);
             }, 30000);


        },

        /**
         * Delete Action
         *
         */
        _deleteAction: function( ) {

            var data = $(this).data('campaign-id');

            $('.auto-mail-delete-id').val(data);


        },

        /**
         * Check All
         *
         */
        _checkAll: function( ) {

            if($(this).prop('checked')){
                $('.auto-mail-check-single-campaign').prop('checked', true);
            }else{
                $('.auto-mail-check-single-campaign').prop('checked', false);

            }

        },

        /**
         * Prepare data before post action
         *
         */
        _preparePost: function( ) {

            var ids = [];
            $('.auto-mail-check-single-campaign').each(function( index ) {
                if($(this).prop('checked')){
                    var value = $(this).val();
                    ids.push(value);
                }
            });

            $('#auto-mail-select-campaigns-ids').val(ids);

        },

    };

    /**
     * Initialize AMCampaignList
     */
    $(function(){
        AMCampaignList.init();
    });

})(jQuery);
