(function($){

    "use strict";

    var AMAutomationList = {

        selected_template: '',

        init: function()
        {
            // Document ready.
            $( document ).ready( AMAutomationList._loadPopup() );

            this._bind();
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
            $( document ).on('click', '.auto-mail-delete-action', AMAutomationList._deleteAction );
            $( document ).on('click', '#auto-mail-check-all-automations', AMAutomationList._checkAll );
            $( document ).on('click', '.auto-mail-bulk-action-button', AMAutomationList._preparePost );
            $( document ).on('click', '.auto-mail-automation-builder', AMAutomationList._switchTemplate );
            $( document ).on('click', '.am-automation-template-close', AMAutomationList._closeTemplate );
            $( document ).on('click', '.am-template-filter', AMAutomationList._selectTemplate );
            $( document ).on('click', '.hui-template-card', AMAutomationList._switchFormType );
            $( document ).on('click', '.am-automation-template-next', AMAutomationList._triggerAMEditor );
        },

        /**
         * Load Popup
         *
         */
        _loadPopup: function( ) {
            $('.open-popup-pro').magnificPopup({
                type:'inline',
                midClick: true, // Allow opening popup on middle mouse click. Always set it to true if you don't provide alternative source in href.
                // Delay in milliseconds before popup is removed
                removalDelay: 300,
                closeOnBgClick: true,
                closeBtnInside: false,
                showCloseBtn: false,
                // Class that is added to popup wrapper and background
                // make it unique to apply your CSS animations just to this exact popup
                callbacks: {
                    beforeOpen: function() {
                        this.st.mainClass = this.st.el.attr('data-effect');
                    }
                },
            });

        },

        /**
         * Trigger am editor
         *
         */
        _triggerAMEditor: function( event ) {
            event.preventDefault();
            var target_url = Auto_Mail_Data.new_am_url + '&template=' + AMAutomationList.selected_template;
            window.location.replace(target_url);
        },

        /**
         * Switch Form Type
         *
         */
        _switchFormType: function( event ) {
            event.preventDefault();
            console.log('switch form type');
            $('.hui-template-card').removeClass('wp-osprey-form-type-switcher');
            $(this).toggleClass('wp-osprey-form-type-switcher');
            AMAutomationList.selected_template = $(this).data('template');
        },

        /**
         * Select Automation Template
         *
         */
        _selectTemplate: function( ) {
            console.log('Automation Template Filter');
            if($(this).hasClass('cat-all')){
                console.log('cat all');
                $('.filter-cat-results .f-cat:not(.active)')
                    .addClass('active');
            }else{
                console.log($(this).data('cat'));
                var cat = $(this).data('cat');
                // reset results list
                $('.filter-cat-results .f-cat').removeClass('active');

                // elements to be filtered
                $('.filter-cat-results .f-cat')
                    .filter('[data-cat="' + cat + '"]')
                    .addClass('active');
            }
        },

        /**
         * Close Automation Template
         *
         */
        _closeTemplate: function( ) {
            $('#wpwrap').css("background-color", "#ffffff");

            $('.auto-mail-wrap').toggleClass('wp-osprey-hide-form-builder');
            $('.am-automation-template-wrap').toggleClass('wp-osprey-hide-form-builder');
        },

        /**
         * Automation Template
         *
         */
        _switchTemplate: function( ) {
            console.log('Automation Template');
            $('#wpwrap').css("background-color", "#9bd8ef");

            $('.auto-mail-wrap').toggleClass('wp-osprey-hide-form-builder');
            $('.am-automation-template-wrap').toggleClass('wp-osprey-hide-form-builder');
        },

        /**
         * Delete Action
         *
         */
        _deleteAction: function( ) {
            var data = $(this).data('automation-id');
            $('.auto-mail-delete-id').val(data);
        },

        /**
         * Check All
         *
         */
        _checkAll: function( ) {

            if($(this).prop('checked')){
                $('.auto-mail-check-single-automation').prop('checked', true);
            }else{
                $('.auto-mail-check-single-automation').prop('checked', false);

            }

        },

        /**
         * Prepare data before post action
         *
         */
        _preparePost: function( ) {

            var ids = [];
            $('.auto-mail-check-single-automation').each(function( index ) {
                if($(this).prop('checked')){
                    var value = $(this).val();
                    ids.push(value);
                }
            });

            $('#auto-mail-select-automations-ids').val(ids);

        },

    };



    /**
     * Initialize AMAutomationList
     */
    $(function(){
        AMAutomationList.init();
    });

})(jQuery);
