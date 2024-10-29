(function($){

    "use strict";

    var AMGenerator = {

        init: function()
        {
            // Document ready.
            this._bind();
            $( document ).ready( AMGenerator._changeBgColor() );
        },

        /**
         * Binds events for the Auto Mail Setup.
         *
         * @since 1.0.0
         * @access private
         * @method _bind
         */
        _bind: function()
        {
            $( document ).on('click', '.auto-mail-welcome-next', AMGenerator._nextSlider );
            $( document ).on('click', '.auto-mail-welcome-prev', AMGenerator._prevSlider );
            $( document ).on('click', '.sui-tab-item', AMGenerator._switchSuiTabs );
            $( document ).on('click', '.auto-mail-save-delivery-button', AMGenerator._saveSettings);
            $( document ).on('click', '.auto-mail-test-button', AMGenerator._sendTestEmail);
            $( document ).on('click', '.am-triggers-pro-button', AMGenerator._goProVersion );

            // Action events
            $( document ).on('click', '.hub-type-trigger-integration', AMGenerator._switchTriggerBuilder );
            $( document ).on('click', '.am-single-trigger-cancel', AMGenerator._switchTriggerBuilder );
            $( document ).on('click', '.auto-mail-trigger-event', AMGenerator._selectTrigger );

            // Delay Selector
            $( document ).ready( AMGenerator._rangeSlider() );
            $( document ).ready( AMGenerator._delayUnitSelector() );

            // Generate Automation
            $( document ).on('click', '.auto-mail-generate-automation', AMGenerator._generateCampaign );
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
         * Generate new automation
         *
         */
        _generateCampaign: function( event ) {
            event.preventDefault();
            console.log('generate automation');

            // set post form data
            var formdata = $('#am-generate-automation-form').serializeArray();
            var fields = {};
            $(formdata ).each(function(index, obj){
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

            $.ajax({
                    url  : Auto_Mail_Data.ajaxurl,
                    type : 'POST',
                    dataType: 'json',
                    data : {
                        action       : 'auto_mail_generate_automation',
                        fields_data  : fields,
                        _ajax_nonce  : Auto_Mail_Data._ajax_nonce

                    },
                    beforeSend: function() {

                    },
                })
                .fail(function( jqXHR ){
                    console.log( jqXHR.status + ' ' + jqXHR.responseText);
                })
                .done(function ( options ) {
                    console.log(options);
                    if( false === options.success ) {
                        console.log(options);
                    } else {
                        //redirect to automations
                        var automations_url = Auto_Mail_Data.automations_url;
                        //window.location.replace(automations_url);
                    }
                });
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
         * Switch Trigger Builder
         *
         */
        _switchTriggerBuilder: function( event ) {
            event.preventDefault();
            console.log(typeof $(this).data('trigger'));
            var trigger = '.am-single-trigger-' + $(this).data('trigger');
            console.log(trigger);
            $(trigger).toggleClass('wp-osprey-hide-form-builder');
            $('.auto-mail-triggers-list').toggleClass('wp-osprey-hide-form-builder');
        },

        /**
         * Send test email
         *
         */
         _sendTestEmail: function( event ) {
            event.preventDefault();

            var reveiver = $( "input[name='test_email_receiver']" ).val();

            console.log('Trigger send test email');
            $(this).html('<div class="text-center"><div class="loader1"><span></span><span></span><span></span><span></span><span></span></div></div>');

            $.ajax({
                    url  : Auto_Mail_Data.ajaxurl,
                    type : 'POST',
                    dataType: 'json',
                    data : {
                        action    : 'am_send_test_email',
                        reveiver  : reveiver,
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
                        $('.auto-mail-test-button').html('Send test email');
                        AMGenerator._displayErrorMessage(options.data);
                    } else {
                        console.log(options);
                        $('.auto-mail-test-button').html('Send test email');
                        AMGenerator._displayNoticeMessage(options.data);
                    }
                });


        },

        /**
         * Display Error Message
         *
         */
         _displayErrorMessage: function(message) {

            var html = '<div class="notice error auto-mail-notice-message">' + message + '</div>';
            $(html).prependTo(".delivery-test-email").slideDown('slow').animate({opacity: 1.0}, 5000).slideUp('slow');;

        },

        /**
         * Display Notice Message
         *
         */
         _displayNoticeMessage: function(message) {

            var html = '<div class="notice updated auto-mail-notice-message">' + message + '</div>';
            $(html).prependTo(".delivery-test-email").slideDown('slow').animate({opacity: 1.0}, 5000).slideUp('slow');;

        },

        /**
         * Save Settings
         *
         */
         _saveSettings: function( event ) {
            event.preventDefault();

            var formdata = $('#auto-mail-setup-form').serializeArray();
            var fields = {};
            $(formdata ).each(function(index, obj){
                fields[obj.name] = obj.value;
            });
            fields['delivery_method'] = $('.delivery-method.active').data('nav');

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
                    } else {
                        console.log(options);
                    }
                });
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
         * Change background color
         *
         */
         _changeBgColor: function( ) {
            $('#wpwrap').css("background-color", "#9bd8ef");
        },

        /**
         * Show next slider
         *
         */
         _nextSlider: function( event ) {
            event.preventDefault();
            var currentSlider = $('.cd-slider li.visible');
            //cache jQuery objects
           var direction = 'next';
           var svgCoverLayer = $('div.cd-svg-cover');
           var pathId = svgCoverLayer.find('path').attr('id');
           var svgPath = Snap('#' + pathId);
           var mode = $('input[name="auto-mail-mode-switch"]:checked').val();

           //store path 'd' attribute values
           var pathArray = [];
           pathArray[0] = svgCoverLayer.data('step1');
           pathArray[1] = svgCoverLayer.data('step6');
           pathArray[2] = svgCoverLayer.data('step2');
           pathArray[3] = svgCoverLayer.data('step7');
           pathArray[4] = svgCoverLayer.data('step3');
           pathArray[5] = svgCoverLayer.data('step8');
           pathArray[6] = svgCoverLayer.data('step4');
           pathArray[7] = svgCoverLayer.data('step9');
           pathArray[8] = svgCoverLayer.data('step5');
           pathArray[9] = svgCoverLayer.data('step10');

           var triggerEvent = $('.am-trigger-event-checked').data('event');

            $('.auto-mail-welcome-next').removeClass("auto-mail-save-delivery-button");

            if ( currentSlider.hasClass('am-slide-automation-name') && $( "input[name='am_automation_name']" ).val().length == 0 ){
                $('.auto-mail-error-message-name').css("display", "block");
                return;
            }else if(
                currentSlider.hasClass('am-slide-trigger-name') && typeof triggerEvent === "undefined"){
                $('.auto-mail-error-message-trigger').css("display", "block");
                return;
            }else{
                AMGenerator._sliderLayerAnimate(direction, svgCoverLayer, pathArray, svgPath);
            }

            // Display prev button
            if($('.auto-mail-welcome-prev').css('display') == 'none'){
                setTimeout(function(){
                    $('.auto-mail-welcome-prev').css("display", "block");
                }, 400);
            }

            if ( currentSlider.next('.auto-mail-slide').length ){
                setTimeout(function(){
                    currentSlider.removeClass('visible')
                    .next('.auto-mail-slide')
                    .addClass('visible');
                }, 400);
            }

            if ( currentSlider.next('.auto-mail-slide').hasClass('auto-mail-last-slide') ){
                setTimeout(function(){
                    $('.auto-mail-welcome-prev').css("display", "none");
                    $('.auto-mail-welcome-next').css("display", "none");
                }, 400);
            }

            if ( currentSlider.next('.auto-mail-slide').hasClass('am-slider-delay') ){
                $('.auto-mail-welcome-next').addClass('auto-mail-generate-automation');
            }
        },

        /**
         * Show prev slider
         *
         */
         _prevSlider: function( event ) {
            event.preventDefault();

             //cache jQuery objects
           var direction = 'prev';
           var svgCoverLayer = $('div.cd-svg-cover');
           var pathId = svgCoverLayer.find('path').attr('id');
           var svgPath = Snap('#' + pathId);

           //store path 'd' attribute values
           var pathArray = [];
           pathArray[0] = svgCoverLayer.data('step1');
           pathArray[1] = svgCoverLayer.data('step6');
           pathArray[2] = svgCoverLayer.data('step2');
           pathArray[3] = svgCoverLayer.data('step7');
           pathArray[4] = svgCoverLayer.data('step3');
           pathArray[5] = svgCoverLayer.data('step8');
           pathArray[6] = svgCoverLayer.data('step4');
           pathArray[7] = svgCoverLayer.data('step9');
           pathArray[8] = svgCoverLayer.data('step5');
           pathArray[9] = svgCoverLayer.data('step10');

           AMGenerator._sliderLayerAnimate(direction, svgCoverLayer, pathArray, svgPath);

           $('.auto-mail-welcome-next').removeClass("auto-mail-save-delivery-button");

            var currentSlider = $('.cd-slider li.visible');
            if ( currentSlider.prev('.auto-mail-slide').length ){
                setTimeout(function(){
                        currentSlider.removeClass('visible')
                        .prev('.auto-mail-slide')
                        .addClass('visible');
                }, 400);
            }

            if ( currentSlider.prev('.auto-mail-slide').hasClass('auto-mail-first-slide') ){
                setTimeout(function(){
                    $('.auto-mail-welcome-prev').css("display", "none");
                }, 400);
            }

        },

        _sliderLayerAnimate: function(direction, svgCoverLayer, paths, svgPath) {
            var duration = 300;
            var delay = 300;
            var epsilon = (1000 / 60 / duration) / 4;
            var firstCustomMinaAnimation = AMGenerator._bezier(.42, .03, .77, .63, epsilon);
            var secondCustomMinaAnimation = AMGenerator._bezier(.27, .5, .6, .99, epsilon);

            if (direction == 'next') {
                var path1 = paths[0];
                var path2 = paths[2];
                var path3 = paths[4];
                var path4 = paths[6];
                var path5 = paths[8];
            } else {
                var path1 = paths[1];
                var path2 = paths[3];
                var path3 = paths[5];
                var path4 = paths[7];
                var path5 = paths[9];
            }

            svgCoverLayer.addClass('is-animating');
            svgPath.attr('d', path1);
            svgPath.animate({'d': path2}, duration, firstCustomMinaAnimation, function () {
                svgPath.animate({'d': path3}, duration, secondCustomMinaAnimation, function () {
                    setTimeout(function () {
                        svgPath.animate({'d': path4}, duration, firstCustomMinaAnimation, function () {
                            svgPath.animate({'d': path5}, duration, secondCustomMinaAnimation, function () {
                                svgCoverLayer.removeClass('is-animating');
                            });
                        });
                    }, delay);
                });
            });
        },

        _bezier: function(x1, y1, x2, y2, epsilon) {
            //https://github.com/arian/cubic-bezier
            var curveX = function (t) {
                var v = 1 - t;
                return 3 * v * v * t * x1 + 3 * v * t * t * x2 + t * t * t;
            };

            var curveY = function (t) {
                var v = 1 - t;
                return 3 * v * v * t * y1 + 3 * v * t * t * y2 + t * t * t;
            };

            var derivativeCurveX = function (t) {
                var v = 1 - t;
                return 3 * (2 * (t - 1) * t + v * v) * x1 + 3 * (-t * t * t + 2 * v * t) * x2;
            };

            return function (t) {

                var x = t, t0, t1, t2, x2, d2, i;

                // First try a few iterations of Newton's method -- normally very fast.
                for (t2 = x, i = 0; i < 8; i++) {
                    x2 = curveX(t2) - x;
                    if (Math.abs(x2) < epsilon)
                        return curveY(t2);
                    d2 = derivativeCurveX(t2);
                    if (Math.abs(d2) < 1e-6)
                        break;
                    t2 = t2 - x2 / d2;
                }

                t0 = 0, t1 = 1, t2 = x;

                if (t2 < t0)
                    return curveY(t0);
                if (t2 > t1)
                    return curveY(t1);

                // Fallback to the bisection method for reliability.
                while (t0 < t1) {
                    x2 = curveX(t2);
                    if (Math.abs(x2 - x) < epsilon)
                        return curveY(t2);
                    if (x > x2)
                        t0 = t2;
                    else
                        t1 = t2;
                    t2 = (t1 - t0) * .5 + t0;
                }

                // Failure
                return curveY(t2);

            };
        },
    };

    /**
     * Initialize AMGenerator
     */
    $(function(){
        AMGenerator.init();
    });

})(jQuery);
