(function($){

    "use strict";

    var AMSubscriberList = {

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
            // Popup modal
            $( document ).on('click', '.popup-trigger', AMSubscriberList._toggleModal );
            $( document ).on('click', '.auto-mail-close-button', AMSubscriberList._toggleModal );
            $( document ).on('click', '#auto-mail-quick-add-subscriber', AMSubscriberList._addSubscriber );
            $( document ).on('click', AMSubscriberList._hideModal);

            // Delete actions
            $( document ).on('click', '#auto-mail-check-all-subscribers', AMSubscriberList._checkAll );
            $( document ).on('click', '.auto-mail-bulk-action-button', AMSubscriberList._preparePost );

            // Toggle Actions
            $( document ).on('mouseover', '.auto-mail-subscriber-item', AMSubscriberList._toggleActions );
            $( document ).on('mouseout', '.auto-mail-subscriber-item', AMSubscriberList._toggleActions );

            // Single Delete Popup modal
            $( document ).on('click', '.auto-mail-single-delete-popup', AMSubscriberList._toggleDeleteModal );
            $( document ).on('click', '.auto-mail-delete-close-button', AMSubscriberList._toggleDeleteModal );
            $( document ).on('click', AMSubscriberList._hideDeleteModal);

            // Single Delete Action
            $( document ).on('click', '.auto-mail-single-delete-action', AMSubscriberList._deleteSingleAction );

        },

        /**
         * Delete Single Action
         *
         */
         _deleteSingleAction: function( ) {

            var data = $(this).data('subscriber-id');

            $('.auto-mail-delete-id').val(data);


        },

        /**
         * Toggle Actions
         *
         */
        _toggleActions: function( ) {
            console.log('hover subscriber item');
            console.log($(this).find('td .auto-mail-row-actions'));
            $(this).find('td .auto-mail-row-actions').toggleClass('active');
        },

        /**
         * Check All
         *
         */
        _checkAll: function( ) {

            if($(this).prop('checked')){
                $('.auto-mail-check-single-subscriber').prop('checked', true);
            }else{
                $('.auto-mail-check-single-subscriber').prop('checked', false);

            }

        },

        /**
         * Prepare data before post action
         *
         */
        _preparePost: function( ) {

            var ids = [];
            $('.auto-mail-check-single-subscriber').each(function( index ) {
                if($(this).prop('checked')){
                    var value = $(this).val();
                    ids.push(value);
                }
            });

            $('#auto-mail-select-subscribers-ids').val(ids);

            console.log(ids);

        },

        /**
         * Add subscriber
         *
         */
        _addSubscriber: function( ) {
            var formdata = $('.auto-mail-quick-subscriber-form').serializeArray();
            var fields = {};
            $(formdata ).each(function(index, obj){
                fields[obj.name] = obj.value;
            });
            fields['subscriber_status'] = 'publish';

            console.log(fields);

            $.ajax({
                    url  : Auto_Mail_Data.ajaxurl,
                    type : 'POST',
                    dataType: 'json',
                    data : {
                        action       : 'auto_mail_save_subscriber',
                        fields_data  : fields,
                        _ajax_nonce  : Auto_Mail_Data._ajax_nonce,

                    },
                    beforeSend: function() {

                    },
                })
                .fail(function( jqXHR ){
                    console.log( jqXHR.status + ' ' + jqXHR.responseText);
                })
                .done(function ( options ) {
                    if( false === options.success ) {
                        console.log(options);
                    } else {
                        console.log(options);
                        AMSubscriberList._displayNoticeMessage(options.data);
                        window.location.replace(Auto_Mail_Data.subscribers_url);
                    }
                });

        },

        /**
         * Toggle Modal
         *
         */
         _toggleModal: function( event ) {
            console.log('click toggle modal');
            var modal = $('.modal');
            modal.toggleClass("show-modal");
        },

        /**
         * Hide Modal
         *
         */
        _hideModal: function( event ) {
            var modal = $('.modal');
            var closeButton = $('.auto-mail-close-button');
            if ($(event.target).hasClass('modal') || $(event.target).hasClass('auto-mail-close-button')) {
                if(modal.hasClass('show-modal')){
                    console.log('the hide modal');
                    modal.removeClass("show-modal");
                }

            }
        },

        /**
         * Display Notice Message
         *
         */
        _displayNoticeMessage: function(message) {
            var html = '<div class="message-box auto-mail-message-box success">' + message + '</div>';
            $(html).prependTo(".auto-mail-block-content-center").slideDown('slow').animate({opacity: 1.0}, 2500).slideUp('slow');
        },

        /**
         * Toggle Modal
         *
         */
         _toggleDeleteModal: function( event ) {
            console.log('click toggle modal');
            var modal = $('.delete-modal');
            modal.toggleClass("show-modal");
        },

        /**
         * Hide Delete Modal
         *
         */
         _hideDeleteModal: function( event ) {
            var modal = $('.delete-modal');
            var closeButton = $('.auto-mail-delete-close-button');
            if ($(event.target).hasClass('delete-modal') || $(event.target).hasClass('auto-mail-delete-close-button')) {
                if(modal.hasClass('show-modal')){
                    console.log('the hide modal');
                    modal.removeClass("show-modal");
                }

            }
        },
    };

    /**
     * Initialize AMSubscriberList
     */
    $(function(){
        AMSubscriberList.init();
    });

})(jQuery);
