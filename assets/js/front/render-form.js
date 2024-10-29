(function($){

    "use strict";

    var AMFormRender = {

        init: function()
        {
            // Document ready.
            $( document ).ready( AMFormRender._loadForm() );
            // Popup modal
            $( document ).ready( AMFormRender._toggleModal() );
            this._bind();

        },

        /**
         * Binds events for the Form Render.
         *
         * @since 1.0.0
         * @access private
         * @method _bind
         */
        _bind: function()
        {
            $( document ).on('click', AMFormRender._hideModal);
            $( document ).on('click', '.am-submit-form-button', AMFormRender._submitForm );
        },

        /**
         * submit form
         *
         */
        _submitForm: function( event ) {

            event.preventDefault();

            $(this).html('<div class="text-center"><div class="loader1"><span></span><span></span><span></span><span></span><span></span></div></div>');

            var formdata = $('.am-subscribe-form-data').serializeArray();
            var fields = {};
            $(formdata ).each(function(index, obj){
                fields[obj.name] = obj.value;
            });

            var validate_email = AMFormRender._validateEmail(fields['email']);

            if(validate_email){
                $.ajax({
                    url  : Auto_Mail_Ajax_Front_Data.ajaxurl,
                    type : 'POST',
                    dataType: 'json',
                    data : {
                        action       : 'am_form_submit',
                        fields_data  : fields,
                        _ajax_nonce  : Auto_Mail_Ajax_Front_Data._ajax_nonce,
                    },
                    beforeSend: function() {
                    },
                })
                .fail(function( jqXHR ){
                    console.log( jqXHR.status + ' ' + jqXHR.responseText);
                })
                .done(function ( result ) {
                    if( false === result.success ) {
                        console.log(result);
                    } else {
                        if(fields['on_submit'] == 'go_page'){
                            window.location.replace(fields['go_page']);
                        }else{
                            var message = '<div class="am-form-success-message"><div class="am-form-success-content"><p>'+fields['show_message']+'</p></div></div>';
                            $('.am-form-container').html(message);
                            console.log(result);
                        }

                    }
                });
            }else{
                AMFormRender._displayNoticeMessage('Please entered an incorrect email address.');
            }

        },

        /**
         * trigger Unlock
         *
         */
        _validateEmail(email) {
            var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
            return regex.test(email);
        },

        /**
         * Display Notice Message
         *
         */
        _displayNoticeMessage: function(message) {

            var html = '<div class="am-form-notice-message">' + message + '</div>';
            $(html).appendTo(".am-form-content").fadeIn('slow').animate({opacity: 1.0}, 2500).fadeOut('slow');

        },

        /**
         * Toggle Modal
         *
         */
         _toggleModal: function( event ) {
             // Switch to design tab
            setTimeout(
                function(){
                    var modal = $('.modal');
                    modal.toggleClass("show-modal");
                }
                , 5000
            );

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
         * Load Form
         *
         */
        _loadForm: function( ) {

            console.log('load form');

            $.ajax({
                    url  : Auto_Mail_Ajax_Front_Data.ajaxurl,
                    type : 'POST',
                    dataType: 'html',
                    data : {
                        action       : 'auto_mail_load_form',
                        _ajax_nonce  : Auto_Mail_Ajax_Front_Data._ajax_nonce,
                    },
                    beforeSend: function() {
                    },
                })
                .fail(function( jqXHR ){
                    console.log( jqXHR.status + ' ' + jqXHR.responseText);
                })
                .done(function ( option ) {
                    $('.auto-mail-form-container').html(option);
                });


        },



    };

    /**
     * Initialize AMFormRender
     */
    $(function(){
        AMFormRender.init();
    });

})(jQuery);
