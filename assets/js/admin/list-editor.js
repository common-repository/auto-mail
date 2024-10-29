(function($){

    "use strict";

    var AMListEditor = {

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
            $( document ).on('click', '.auto-mail-list-save', AMListEditor._saveList);
        },

        /**
         * Save List
         *
         */
        _saveList: function( event ) {
            event.preventDefault();
            $(this).html('<div class="text-center"><div class="loader1"><span></span><span></span><span></span><span></span><span></span></div></div>');

            var formdata = $('.auto-mail-list-form').serializeArray();
            var fields = {};
            $(formdata ).each(function(index, obj){
                fields[obj.name] = obj.value;
            });
            fields['list_status'] = 'publish';

            $.ajax({
                    url  : Auto_Mail_Data.ajaxurl,
                    type : 'POST',
                    dataType: 'json',
                    data : {
                        action       : 'auto_mail_save_list',
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
                        $('.auto-mail-list-save').html('<span class="auto-mail-loading-text">Save</span>');
                        AMListEditor._displayErrorMessage(options.data);
                    } else {
                        console.log(options);
                        $('.auto-mail-list-save').html('<span class="auto-mail-loading-text">Save</span>');
                        AMListEditor._displayNoticeMessage(options.data);
                        window.location.replace(Auto_Mail_Data.lists_url);
                    }
                });
        },

        /**
         * Display Notice Message
         *
         */
         _displayNoticeMessage: function(message) {

            var html = '<div class="notice updated auto-mail-notice-message">' + message + '</div>';
            $(html).prependTo(".auto-mail-row-with-sidenav").slideDown('slow').animate({opacity: 1.0}, 2500).slideUp('slow');;

        },

        /**
         * Display Error Message
         *
         */
         _displayErrorMessage: function(message) {

            var html = '<div class="notice error auto-mail-notice-message">' + message + '</div>';
            $(html).prependTo(".auto-mail-row-with-sidenav").slideDown('slow').animate({opacity: 1.0}, 2500).slideUp('slow');;

        },
    };

    /**
     * Initialize AMListEditor
     */
    $(function(){
        AMListEditor.init();
    });

})(jQuery);
