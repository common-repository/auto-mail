(function($){

    "use strict";

    var AMFormEditor = {

        init: function()
        {
            // Document ready.
            this._bind();
            $( document ).ready( AMFormEditor._preventFormSubmit() );

            console.log('form editor');
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
            // Switch tabs
            $( document ).on('click', '.auto-mail-vertical-tab a', AMFormEditor._switchTabs );
            $( document ).on('click', '.sui-tab-item', AMFormEditor._switchSuiTabs );

            // Popup modal
            $( document ).on('click', '.popup-trigger', AMFormEditor._toggleModal );
            $( document ).on('click', '.auto-mail-close-button', AMFormEditor._toggleModal );
            $( document ).on('click', AMFormEditor._hideModal);

            // Select insert fields
            $( document ).on('click', '.hub-plantform', AMFormEditor._checkedField );

            // Display dropdown
            $( document ).on('click', '.auto-mail-dropdown-anchor', AMFormEditor._displayDropdownActions );

            // Publish form
            $( document ).on('click', '#auto-mail-form-publish', AMFormEditor._publishForm );
            $( document ).on('click', '#auto-mail-form-preview', AMFormEditor._showFormPreview );
            $( document ).on('click', '.auto-mail-close-preview', AMFormEditor._closeFormPreview );
            $( document ).on('click', '#auto-mail-reload-preview', AMFormEditor._reloadFormPreview );
            $( document ).on('click', '.auto-mail-mobile-preview', AMFormEditor._mobileFormPreview );
            $( document ).on('click', '.auto-mail-desktop-preview', AMFormEditor._desktopFormPreview );

            // Upload media image
            $( document ).on('click', '.am-upload-image-button', AMFormEditor._uploadMediaImage );
            $( document ).on('click', '.am-remove-image-button', AMFormEditor._removeFeatureImage );
        },

        /**
         * Upload media image
         *
         */
        _uploadMediaImage: function( event ) {

            event.preventDefault();

            var send_attachment_bkp = wp.media.editor.send.attachment;
            var button = $(this);
            wp.media.editor.send.attachment = function(props, attachment) {
                $(button).parent().prev().attr('src', attachment.url);
                $(button).prev().val(attachment.id);
                wp.media.editor.send.attachment = send_attachment_bkp;
            }
            wp.media.editor.open(button);
            return false;
        },

        /**
         * Remove feature image
         *
         */
        _removeFeatureImage: function( event ) {
            event.preventDefault();
            var answer = confirm('Are you sure?');
            if (answer == true) {
                var src = $(this).parent().prev().attr('data-src');
                $(this).parent().prev().attr('src', src);
                $(this).prev().prev().val('');
            }
            return false;
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

            $( "input[name='on_submit']" ).val($(this).data('nav'));


        },

        /**
         * Desktop Form Preview
         *
         */
         _desktopFormPreview : function( ) {
            console.log('desktop preview form');
            $(".am-preview-device-button").removeClass("sui-active");
            $(this).addClass("sui-active");
            $(".hui-preview-body").css("max-width", "1315px");
            $(".hui-preview-body").css("margin", "0 auto");
            $(".hui-preview-body").find("iframe").css("width", "1315px");
            $(".hui-preview-body").find("iframe").css("height", "1000px");
        },

        /**
         * Mobile Form Preview
         *
         */
         _mobileFormPreview : function( ) {
            console.log('mobile preview form');
            $(".am-preview-device-button").removeClass("sui-active");
            $(this).addClass("sui-active");
            $(".hui-preview-body").css("max-width", "415px");
            $(".hui-preview-body").css("margin", "0 auto");
            $(".hui-preview-body").find("iframe").css("width", "415px");
            $(".hui-preview-body").find("iframe").css("height", "630px");
        },

        /**
         * Reload Form Preview
         *
         */
         _reloadFormPreview : function( ) {
            console.log('reload preview form');
            document.getElementById('am-preview-iframe').contentDocument.location.reload(true);
        },

        /**
         * Show Form Preview
         *
         */
        _showFormPreview : function( ) {
            console.log('show preview form');
            $('#auto-mail-reload-preview').trigger('click');
            $('.am-form-preview').addClass('active');
            $('.am-form-editor').addClass('hide');
        },

         /**
         * Close Form Preview
         *
         */
        _closeFormPreview : function( ) {
            console.log('hide form preview');
            $('.am-form-preview').removeClass('active');
            $('.am-form-editor').removeClass('hide');
        },

        /**
         * Prevent Form Submit
         *
         */
        _preventFormSubmit: function( ) {
            $('.auto-mail-form-data').submit(function (evt) {
                evt.preventDefault();
            });
        },

        /**
         * Publish Form
         *
         */
         _publishForm: function( ) {

            var formdata = $('.auto-mail-form-data').serializeArray();
            var fields = {};
            $(formdata ).each(function(index, obj){
                fields[obj.name] = obj.value;
            });
            fields['form_status'] = 'publish';

            var lists = [];
            $("input:checkbox[name=lists]:checked").each(function(){
                lists.push($(this).val());
            });
            fields['lists'] = lists;

            console.log(fields);

            $.ajax({
                    url  : Auto_Mail_Data.ajaxurl,
                    type : 'POST',
                    dataType: 'json',
                    data : {
                        action       : 'auto_mail_save_form',
                        fields_data  : fields,
                        _ajax_nonce  : Auto_Mail_Data._ajax_nonce,

                    },
                    beforeSend: function() {
                        $('.auto-mail-status-changes').html('<ion-icon name="reload-circle"></ion-icon></ion-icon>Saving');
                    },
                })
                .fail(function( jqXHR ){
                    console.log( jqXHR.status + ' ' + jqXHR.responseText);
                })
                .done(function ( options ) {
                    if( false === options.success ) {
                        console.log(options);
                    } else {
                        // update form save icon status
                        $('.auto-mail-status-changes').html('<ion-icon class="auto-mail-icon-saved" name="checkmark-circle"></ion-icon>Saved');
                        // window.location.replace(Auto_Mail_Data.forms_url);
                    }
                });

        },

        /**
         * Check field
         *
         */
        _checkedField: function( event ) {

            event.preventDefault();

            console.log('check field');

            //PosterHubAccountsList.plantform = $(this).data('plantform');

            $(this).css({"background-color": "#e1f6ff", "color": "#17a8e3"});

            $(".hub-plantform").not($(this)).css({"background-color": "#ffffff", "color": "#888"});

            $(this).parent().find('.hub-type').prop('checked', true);

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
         * Toggle Modal
         *
         */
        _toggleModal: function( event ) {
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
         * Display Actions
         *
         */
         _displayDropdownActions: function( event ) {
            event.preventDefault();
            if($(this).closest('.auto-mail-dropdown').find('.auto-mail-dropdown-list').hasClass('active')){
                $(this).closest('.auto-mail-dropdown').find('.auto-mail-dropdown-list').removeClass('active');
            }else{
                $(this).closest('.auto-mail-dropdown').find('.auto-mail-dropdown-list').addClass('active');
            }

        },
    };

    /**
     * Initialize AMFormEditor
     */
    $(function(){
        AMFormEditor.init();
    });

})(jQuery);
