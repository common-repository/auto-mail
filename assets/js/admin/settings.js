(function($){

    "use strict";

    var AutoMailSettings = {

        init: function()
        {
            // Document ready.
            this._bind();
        },

        /**
         * Binds events for setting.
         *
         * @since 1.0.0
         * @access private
         * @method _bind
         */
        _bind: function()
        {
            $( document ).on('click', '.auto-mail-vertical-tab a', AutoMailSettings._switchTabs );
            $( document ).on('click', '.auto-mail-save-settings', AutoMailSettings._saveSettings);
            $( document ).on('click', '.sui-tab-item', AutoMailSettings._switchSuiTabs );
            $( document ).on('click', '.auto-mail-region-selector', AutoMailSettings._frequencySelector );

        },

        /**
         * Frequency Selector
         *
         */
        _frequencySelector: function( ) {
                e.preventDefault();
                e.stopPropagation();
                /* api type expanded */
                $(this).toggleClass('expanded');

                /* set from region value */
                var region = $(this).find('#'+$(e.target).attr('for'));
                console.log(region);
                region.prop('checked',true);
        },

        /**
         * Switch Sui Tabs
         *
         */
         _switchSuiTabs: function( event ) {

            event.preventDefault();

            var tab = '#' + $(this).data('nav');

            $('.sui-tab-item').removeClass('active');
            $(this).addClass('active');

            $('.sui-tab-content').removeClass('active');
            $('.sui-tabs-content').find(tab).addClass('active');

            console.log($(this).data('nav'));

            $( "input[name='delivery_method']" ).val($(this).data('nav'));


        },

        /**
         * Switch Tabs
         *
         */
        _switchTabs: function( event ) {

            event.preventDefault();

            var tab = '#' + $(this).data('nav');

            $('.auto-mail-vertical-tab').removeClass('current');
            $(this).parent().addClass('current');

            $('.auto-mail-box-tab').removeClass('active');
            $('.auto-mail-box-tabs').find(tab).addClass('active');

        },

        /**
         * Save Settings
         *
         */
         _saveSettings: function( event ) {
            event.preventDefault();
            $(this).html('<div class="text-center"><div class="loader1"><span></span><span></span><span></span><span></span><span></span></div></div>');

            var formdata = $('.auto-mail-settings-form').serializeArray();
            var fields = {};
            $(formdata ).each(function(index, obj){
                fields[obj.name] = obj.value;
            });

            $.ajax({
                    url  : Auto_Mail_Data.ajaxurl,
                    type : 'POST',
                    dataType: 'json',
                    data : {
                        action       : 'auto_mail_save_settings',
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
                        $('.auto-mail-save-settings').html('<span class="auto-mail-loading-text">Save</span>');
                        AutoMailSettings._displayErrorMessage(options.data);
                    } else {
                        console.log(options);
                        $('.auto-mail-save-settings').html('<span class="auto-mail-loading-text">Save</span>');
                        AutoMailSettings._displayNoticeMessage(options.data);
                    }
                });
        },

        /**
         * Display Error Message
         *
         */
         _displayErrorMessage: function(message) {

            var html = '<div class="notice error auto-mail-notice-message">' + message + '</div>';
            $(html).prependTo(".auto-mail-content-wrap").slideDown('slow').animate({opacity: 1.0}, 2500).slideUp('slow');;

        },

        /**
         * Display Notice Message
         *
         */
         _displayNoticeMessage: function(message) {
            var html = '<div class="notice updated auto-mail-notice-message">' + message + '</div>';
            $(html).prependTo(".auto-mail-content-wrap").slideDown('slow').animate({opacity: 1.0}, 2500).slideUp('slow');;
        },

    };

    /**
     * Initialize AutoMailSettings
     */
    $(function(){
        AutoMailSettings.init();
    });

})(jQuery);
