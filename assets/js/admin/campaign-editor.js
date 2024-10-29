(function($){

    "use strict";

    var AMCampaignEditor = {

        init: function()
        {
            // Document ready.
            this._bind();
            console.log('campaign editor');
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
            $( document ).on('click', '#auto-mail-save-design', AMCampaignEditor._saveDesign);
            $( document ).on('click', '.auto-mail-switch-sections', AMCampaignEditor._switchDesignSend);
            $( document ).on('click', '.auto-mail-process-campaign', AMCampaignEditor._processCampaign);
            $( document ).on('click', '.auto-mail-step', AMCampaignEditor._switchTabs );
            $( document ).on('click', '.auto-mail-template-button', AMCampaignEditor._selectTemplate );
            $( document ).on('click', '.auto-mail-pro-template-button', AMCampaignEditor._goProVersion );
            $( document ).on('click', '.hui-template-preview', AMCampaignEditor._goProVersion );
            $( document ).on('click', '.auto-mail-newsletter-setup', AMCampaignEditor._startSetup );
            // Popup modal
            $( document ).on('click', '.auto-mail-popup-preview', AMCampaignEditor._toggleModal );
            $( document ).on('click', AMCampaignEditor._hideModal);

        },

        /**
         * Go Pro Version
         *
         */
        _goProVersion: function( ) {
            var target_url = 'https://wpautomail.com/pricing/';
            window.open(target_url, '_blank');
        },

        /**
         * Toggle Modal
         *
         */
         _toggleModal: function( event ) {
            event.preventDefault();
            var modal = '.' + $(this).data('template');
            console.log(modal);
            $(modal).toggleClass("show-modal");
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
         * Start setup
         *
         */
        _startSetup: function( event ) {
            event.preventDefault();

            if ( $( "input[name='auto_mail_campaign_name']" ).val().length == 0 ){
                $('.auto-mail-error-message-name').css("display", "block");
                return;
            }

            $(this).html('<div class="text-center"><div class="loader1"><span></span><span></span><span></span><span></span><span></span></div></div>');
            $('.auto-mail-newsletter-button').attr('disabled', true);

            // Switch to template tab
            setTimeout(
                function(){
                    var tab = '.template';
                    $('.auto-mail-setps-tab a').removeClass('current');
                    $('.auto-mail-setps-tab').find(tab).addClass('current');

                    $('.auto-mail-box-tab').removeClass('active');
                    $('.auto-mail-box-tabs').find(tab).addClass('active');

                    $('.auto-mail-newsletter-setup').html('<span class="auto-mail-loading-text">Save Campaign</span>');
                    $('.auto-mail-newsletter-setup').attr('disabled', false);

                }
                , 5000
            );

        },

        /**
         * Select Template
         *
         */
        _selectTemplate: function( event ) {
            event.preventDefault();

            $(this).html('<div class="text-center"><div class="loader1"><span></span><span></span><span></span><span></span><span></span></div></div>');
            $('.auto-mail-template-button').attr('disabled', true);

            // Set template data
            localStorage.setItem('template', $(this).data('template'));
            $('#auto-mail-change-template').trigger('click');


            // Switch to design tab
            setTimeout(
                function(){
                    var tab = '.design';
                    $('.auto-mail-setps-tab a').removeClass('current');
                    $('.auto-mail-setps-tab').find(tab).addClass('current');

                    $('.auto-mail-box-tab').removeClass('active');
                    $('.auto-mail-box-tabs').find(tab).addClass('active');

                    $('.auto-mail-template-button').html('<span>Select</span>');
                    $('.auto-mail-template-button').attr('disabled', false);

                }
                , 5000
            );


        },

        /**
         * Switch Tabs
         *
         */
         _switchTabs: function( event ) {

            event.preventDefault();

            var tab = '.' + $(this).data('nav');

            $('.auto-mail-setps-tab a').removeClass('current');
            $(this).addClass('current');

            $('.auto-mail-box-tab').removeClass('active');
            $('.auto-mail-box-tabs').find(tab).addClass('active');

        },

        /**
         * Process Campaign
         *
         */
        _processCampaign: function( ) {
            console.log('Process email campaign');

            var fields = {};
            fields['settings'] = {};
            var formdata = $('.auto-mail-campaign-form').serializeArray();
            $(formdata).each(function(index, obj){
                fields['settings'][obj.name] = obj.value;
            });
            fields['action'] = $(this).data('action');

            var lists = [];
            $("input:checkbox[name=lists]:checked").each(function(){
                lists.push($(this).val());
            });
            fields['lists'] = lists;
            fields['template'] = localStorage.getItem("design");
            fields['html'] = localStorage.getItem("html");
            fields['id'] = $( "input[name='id']" ).val();
            fields['name'] = $( "input[name='auto_mail_campaign_name']" ).val();

            console.log(fields);

            $.ajax({
                    url  : Auto_Mail_Data.ajaxurl,
                    type : 'POST',
                    dataType: 'json',
                    data : {
                        action       : 'auto_mail_process_campaign',
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
                        var message = "Your newsletter has been save successfully!"
                        AMCampaignEditor._displayNoticeMessage(message);
                        window.location.replace(Auto_Mail_Data.campaigns_url);
                    }
                });
        },

        /**
         * Display Notice Message
         *
         */
         _displayNoticeMessage: function(message) {

            var html = '<div class="notice updated auto-mail-notice-message">' + message + '</div>';
            $(html).prependTo("#auto-mail-prepare-send").slideDown('slow').animate({opacity: 1.0}, 2500).slideUp('slow');;

        },

        /**
         * Switch design and send
         *
         */
        _switchDesignSend: function( ) {
            console.log('Switch design and send');
            $('#hi-react').toggleClass('active');
            $('#auto-mail-prepare-send').toggleClass('active');
        },

        /**
         * Save Design
         *
         */
        _saveDesign: function( ) {

            $(this).html('<div class="text-center"><div class="loader1"><span></span><span></span><span></span><span></span><span></span></div></div>');

            setTimeout(
                function(){
                    var fields = {};
                    const params = new URLSearchParams(window.location.href);
                    if(params.get('id')){
                        fields['id'] = params.get('id');
                    }
                    fields['template'] = localStorage.getItem("design");

                    $.ajax({
                            url  : Auto_Mail_Data.ajaxurl,
                            type : 'POST',
                            dataType: 'json',
                            data : {
                                action       : 'auto_mail_save_design',
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
                                $( "input[name='id']" ).val(options.data);
                                $('#auto-mail-save-design').html('Save Design');
                                var message = 'Newsletter design has been saved successfully!';
                                AMCampaignEditor._displayDesignSavedMessage(message);
                            }
                        });
                 }
                , 5000
            );
        },

        /**
         * Display Design Saved Message
         *
         */
         _displayDesignSavedMessage: function(message) {
            var html = '<div class="message-box auto-mail-message-box success">' + message + '</div>';
            $(html).appendTo(".auto-mail-wrap").slideDown('slow').animate({opacity: 1.0}, 2000).slideUp('slow');
        },
    };

    /**
     * Initialize AMCampaignEditor
     */
    $(function(){
        AMCampaignEditor.init();
    });

})(jQuery);
