(function($){

    "use strict";

    var AutoMailForm = {

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
            $( document ).on('click', AutoMailForm._hideModal );
            $( document ).on('click', '.am-form-popup-template', AutoMailForm._popupTemplate );
            $( document ).on('click', '.auto-mail-form-editor-trigger-button', AutoMailForm._triggerFormEditor );
            $( document ).on('mouseover', '.hui-template-card', AutoMailForm._hoverTemplate );
            $( document ).on('mouseout', '.hui-template-card', AutoMailForm._outTemplate );
            $( document ).on('click', '.am-template-select-button', AutoMailForm._selectTemplate );

            $( document ).on('click', '#auto-mail-check-all-forms', AutoMailForm._checkAll );
            $( document ).on('click', '.auto-mail-bulk-action-button', AutoMailForm._preparePost );

        },

        /**
         * Prepare data before post action
         *
         */
         _preparePost: function( ) {

            var ids = [];
            $('.auto-mail-check-single-form').each(function( index ) {
                if($(this).prop('checked')){
                    var value = $(this).val();
                    ids.push(value);
                }
            });

            $('#auto-mail-select-forms-ids').val(ids);

        },

        /**
         * Check All
         *
         */
         _checkAll: function( ) {
            if($(this).prop('checked')){
                $('.auto-mail-check-single-form').prop('checked', true);
            }else{
                $('.auto-mail-check-single-form').prop('checked', false);
            }
        },

        /**
         * Select template
         *
         */
         _selectTemplate: function( event ) {
            event.preventDefault();
            var target_url = Auto_Mail_Data.wizard_url + '&template='+ $(this).data('template');

            window.location.replace(target_url);
        },

        /**
         * Hover template
         *
         */
         _hoverTemplate: function( event ) {
            event.preventDefault();
            $(this).addClass('active');
            $(this).find('.auto-mail-button').addClass('active');
            $(this).find('.hui-template-card--image').addClass('active');
        },

        /**
         * Out template
         *
         */
        _outTemplate: function( event ) {
            event.preventDefault();
            $(this).removeClass('active');
            $(this).find('.auto-mail-button').removeClass('active');
            $(this).find('.hui-template-card--image').removeClass('active');

        },

        /**
         * Trigger form editor
         *
         */
        _triggerFormEditor: function( event ) {
            event.preventDefault();
            var target_url = Auto_Mail_Data.wizard_url;
            window.location.replace(target_url);
        },

        /**
         * Popup template
         *
         */
        _popupTemplate: function( event ) {
            event.preventDefault();
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





    };

    /**
     * Initialize AutoMailForm
     */
    $(function(){
        AutoMailForm.init();
    });

})(jQuery);
