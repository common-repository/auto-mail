(function($){

    "use strict";

    var AMSubscriberEditor = {

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
            $( document ).on('click', '.auto-mail-vertical-tab a', AMSubscriberEditor._switchTabs );
            $( document ).on('click', '.auto-mail-subscriber-save', AMSubscriberEditor._publishSubscriber );
        },

        /**
         * Publish Subscriber
         *
         */
         _publishSubscriber: function( event ) {
            event.preventDefault();

            var formdata = $('.auto-mail-subscriber-form').serializeArray();
            var fields = {};
            $(formdata ).each(function(index, obj){
                fields[obj.name] = obj.value;
            });
            fields['subscriber_status'] = 'publish';

            var lists = [];
            $("input:checkbox[name=lists]:checked").each(function(){
                lists.push($(this).val());
            });
            fields['lists'] = lists;

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
                        AMSubscriberEditor._displayNoticeMessage(options.data);
                        window.location.replace(Auto_Mail_Data.subscribers_url);
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

    };

    /**
     * Initialize AMSubscriberEditor
     */
    $(function(){
        AMSubscriberEditor.init();
    });

})(jQuery);
