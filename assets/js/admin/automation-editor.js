(function($){

    "use strict";

    var AMAutomationEditor = {

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
            $( document ).on('click', '.auto-mail-step', AMAutomationEditor._switchTabs );
            $( document ).on('click', '.hub-type-integration', AMAutomationEditor._switchFormBuilder );
            $( document ).on('click', '.am-single-trigger-cancel', AMAutomationEditor._switchFormBuilder );

            // Trigger events
            $( document ).on('click', '.popup-trigger', AMAutomationEditor._toggleModal );
            $( document ).on('click', '.auto-mail-trigger-event', AMAutomationEditor._selectTrigger );

            $( document ).on('click', '.am-triggers-pro-button', AMAutomationEditor._goProVersion );
            $( document ).on('click', '.am-add-trigger-button', AMAutomationEditor._addTrigger );
            $( document ).on('click', '.am-trigger-event-trash', AMAutomationEditor._removeTrigger );

            // Action events
            $( document ).on('click', '.hub-type-action-integration', AMAutomationEditor._switchActionBuilder );
            $( document ).on('click', '.am-single-action-cancel', AMAutomationEditor._switchActionBuilder );

            $( document ).on('click', '.popup-action', AMAutomationEditor._toggleModal );
            $( document ).on('click', '.auto-mail-close-button', AMAutomationEditor._toggleModal );
            $( document ).on('click', AMAutomationEditor._hideModal);

            $( document ).on('click', '.am-actions-pro-button', AMAutomationEditor._goProVersion );

            $( document ).on('click', '.am-automation-times-edit', AMAutomationEditor._editTotalTimes );
            $( document ).on('click', '.am-save-automation-button', AMAutomationEditor._saveAutomation );

            $( document ).on('submit', '.auto-mail-automation-form', AMAutomationEditor._disableSubmitForm );

            $( document ).on('click', '.auto-mail-automation-name', AMAutomationEditor._startSetup );

            // Delay Selector
            $( document ).ready( AMAutomationEditor._rangeSlider() );
            $( document ).ready( AMAutomationEditor._delayUnitSelector() );
        },

        /**
         * Range Slider
         *
         */
        _rangeSlider: function( ) {

            var slider = $('.range-slider'),
                range = $('.range-slider__range'),
                value = $('.range-slider__value');

            slider.each(function(){

                value.each(function(){
                    var value = $(this).prev().attr('value');
                    $(this).html(value);
                });

                range.on('input', function(){
                    $(this).next(value).html(this.value);
                });
            });

        },


        /**
         * Delay Unit Selector
         *
         */
        _delayUnitSelector: function( ) {

            // onClick new options list of new select
            var newOptions = $('.list-results > li');
            newOptions.on('click', function(){
                $(this).closest('.select-list-container').find('.list-value').text($(this).text());
                $(this).closest('.select-list-container').find('.list-value').val($(this).text());
                $(this).closest('.select-list-container').find('.list-results > li').removeClass('selected');
                $(this).addClass('selected');
            });

            var aeDropdown = $('.select-list-container');
            aeDropdown.on('click', function(){
                $(this).closest('.select-list-container').find('.list-results').toggleClass('robot-sidenav-hide-md');
            });

            var robotDropdown = $('.dropdown-handle');
            robotDropdown.on('click', function(){
                $(this).closest('.select-list-container').find('.list-results').toggleClass('robot-sidenav-hide-md');
            });

        },

        /**
         * Start setup
         *
         */
        _startSetup: function( event ) {
            event.preventDefault();
            if ( $( "input[name='am_automation_name']" ).val().length == 0 ){
                $('.auto-mail-error-message-name').css("display", "block");
                return;
            }

            $(this).html('<div class="text-center"><div class="loader1"><span></span><span></span><span></span><span></span><span></span></div></div>');
            $('.auto-mail-automation-name').attr('disabled', true);

            // Switch to template tab
            setTimeout(
                function(){
                    var tab = '.triggers';
                    $('.auto-mail-setps-tab a').removeClass('current');
                    $('.auto-mail-setps-tab').find(tab).addClass('current');

                    $('.auto-mail-box-tab').removeClass('active');
                    $('.auto-mail-box-tabs').find(tab).addClass('active');

                    $('.auto-mail-automation-name').html('<span class="auto-mail-loading-text">Next</span>');
                    $('.auto-mail-automation-name').attr('disabled', false);

                }
                , 5000
            );

        },

        /**
         * Disable Submit Form
         *
         */
        _disableSubmitForm: function( ) {
            return false;
        },

        /**
         * Save Automation
         *
         */
        _saveAutomation : function( event ) {
            event.preventDefault();

            console.log('Save Automation');

            var formdata = $('.auto-mail-automation-form').serializeArray();
            var fields = {};
            $(formdata).each(function(index, obj){
                fields[obj.name] = obj.value;
            });
            fields['status'] = 'publish';

            fields['trigger-type'] = 'woocommerce';
            fields['trigger-name'] = 'woocommerce_cart_abandonment';

            fields['pretty_message'] = tinyMCE.get('pretty_message').getContent();

            fields['update_frequency'] = $('.range-slider__value').text();
            fields['update_frequency_unit'] = $('#robot-field-unit-button').val();

            var type = 'woocommerce';
            var name = 'woo_schedule_email';
            var action = {
                'type' : type,
                'name' : name,
                'position' : 1
            };
            fields['actions'] = [];
            fields['actions'].push(action);

            var WooEmailMeta = {
                '1' : {
                    'id' : 1,
                    'subject' : fields['woo_automation_email_subject'],
                    'content' : tinyMCE.get('pretty_message').getContent(),
                    'delay' : $('.range-slider__value').text()
                },
            };

            fields['actions_meta'] = WooEmailMeta;

            console.log(fields);

            $.ajax({
                url  : Auto_Mail_Data.ajaxurl,
                type : 'POST',
                dataType: 'json',
                data : {
                    action       : 'auto_mail_save_automation',
                    fields_data  : fields,
                    _ajax_nonce  : Auto_Mail_Data._ajax_nonce,
                },
                beforeSend: function() {
                    $(this).html('<div class="text-center"><div class="loader1"><span></span><span></span><span></span><span></span><span></span></div></div>');
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
                    $(this).html('<button class="auto-mail-button auto-mail-button-blue">Save &amp; Active</button>');
                    var message = "Your automation has been save successfully!"
                    AMAutomationEditor._displayAutomationMessage(message);
                    window.location.replace(Auto_Mail_Data.automations_url);
                }
            });
        },

        /**
         * Edit Total Times
         *
         */
        _editTotalTimes: function( ) {
            console.log('Edit Total Times');
        },

         /**
         * Switch Action Builder
         *
         */
         _switchActionBuilder: function( event ) {
            event.preventDefault();

            console.log(typeof $(this).data('action'));


                var action = '.am-single-action-' + $(this).data('action');
                console.log(action);
                $(action).toggleClass('wp-osprey-hide-form-builder');

            $('.auto-mail-actions-list').toggleClass('wp-osprey-hide-form-builder');
        },

        /**
         * Add Action
         *
         */
        _removeAction: function( event ) {
            event.preventDefault();
            console.log('Remove action');
            //var html = '<div class="auto-mail-box auto-mail-message am-user-selected-action"><img src="https://wpautomail.com/wp-content/uploads/2022/12/action.png" class="auto-mail-image auto-mail-image-center" aria-hidden="true" alt="Auto Mail"><div class="auto-mail-message-content"><p>Select action event for your marketing automation.</p><p><a href="#" class="auto-mail-add-action"><button class="auto-mail-button auto-mail-button-blue popup-action">Add Action</button></a></p></div></div>';
            //$('.am-user-selected-action').html(html);
            $(this).closest('.auto-mail-accordion').remove();
        },

        /**
         * Add Trigger
         *
         */
        _removeTrigger: function( event ) {
            event.preventDefault();
            console.log('Remove trigger');
            var html = '<div class="auto-mail-box auto-mail-message am-user-selected-trigger"><img src="https://wpautomail.com/wp-content/uploads/2022/12/trigger.png" class="auto-mail-image auto-mail-image-center" aria-hidden="true" alt="Auto Mail"><div class="auto-mail-message-content"><p>Select trigger event for your marketing automation.</p><p><a href="#" class="auto-mail-add-trigger"><button class="auto-mail-button auto-mail-button-blue popup-trigger">Add Trigger</button></a></p></div></div>';
            $('.am-user-selected-trigger').html(html);
         },

        /**
         * Add Trigger
         *
         */
        _addTrigger: function( event ) {
           event.preventDefault();
           //console.log('Add trigger');
           var type = $('.am-trigger-event-checked').data('type');
           var event = $('.am-trigger-event-checked').data('event');
           if(typeof event === "undefined"){
                $('.auto-mail-box-triggers').css('margin-top', '50px');
                AMAutomationEditor._displayNoticeMessage('Please choose your trigger event');
                setTimeout(
                    function(){
                        $('.auto-mail-box-triggers').css('margin-top', '0px');
                    }
                    , 2500
                );

           }else{
                console.log(event);
                var modal = $('.modal');
                modal.toggleClass("show-modal");

                var html = '<div class="auto-mail-accordion auto-mail-accordion-block"><div class="auto-mail-accordion-item"><div class="auto-mail-accordion-item-header"><div class="auto-mail-accordion-item-title auto-mail-trim-title"><span class="auto-mail-trim-text am-trigger-type">' + type + '</span><span class="auto-mail-tag auto-mail-tag-green am-trigger-name">' + event + '</span></div><div class="auto-mail-accordion-item-date"><strong>Last Run</strong> Never</div><div class="auto-mail-accordion-col-auto"><a href="#" class="auto-mail-button am-trigger-event-trash auto-mail-button-ghost auto-mail-accordion-item-action auto-mail-desktop-visible"><ion-icon name="trash" class="auto-mail-icon-trash"/></ion-icon>Delete</a></div></div></div></div>';
                $('.am-user-selected-trigger').html(html);
           }
        },

        /**
         * Display Notice Message
         *
         */
        _displayNoticeMessage: function(message) {
            var html = '<div class="message-box auto-mail-message-box success">' + message + '</div>';
            $(html).prependTo(".am-trigger-message-box").slideDown('slow').animate({opacity: 1.0}, 2500).slideUp('slow');
        },

        /**
         * Display Action Message
         *
         */
        _displayActionMessage: function(message) {
            var html = '<div class="message-box auto-mail-message-box success">' + message + '</div>';
            $(html).prependTo(".am-action-message-box").slideDown('slow').animate({opacity: 1.0}, 2500).slideUp('slow');
        },

        /**
         * Display Automation Message
         *
         */
        _displayAutomationMessage: function(message) {
            var html = '<div class="message-box auto-mail-message-box success">' + message + '</div>';
            $(html).prependTo("#auto-mail-prepare-save").slideDown('slow').animate({opacity: 1.0}, 2500).slideUp('slow');
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
         * Select Trigger
         *
         */
        _selectTrigger: function( event ) {
            event.preventDefault();

            $('.auto-mail-trigger-event').removeClass('auto-mail-button-blue');
            $('.auto-mail-trigger-event').addClass('auto-mail-button-white');
            $('.auto-mail-trigger-event').removeClass('am-trigger-event-checked');

            $(this).removeClass('auto-mail-button-white');
            $(this).addClass('auto-mail-button-blue');
            $(this).addClass('am-trigger-event-checked');
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
            //event.preventDefault();
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
         * Switch Form Builder
         *
         */
        _switchFormBuilder: function( event ) {
            //event.preventDefault();

            console.log(typeof $(this).data('trigger'));


                var trigger = '.am-single-trigger-' + $(this).data('trigger');
                console.log(trigger);
                $(trigger).toggleClass('wp-osprey-hide-form-builder');

            $('.auto-mail-triggers-list').toggleClass('wp-osprey-hide-form-builder');
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





    };

    /**
     * Initialize AMAutomationEditor
     */
    $(function(){
        AMAutomationEditor.init();
    });

})(jQuery);
