(function($){

    "use strict";

    var AutoMailSetup = {

        init: function()
        {
            // Document ready.
            this._bind();
            $( document ).ready( AutoMailSetup._changeBgColor() );
            $( document ).ready( AutoMailSetup._regionSelector() );

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
            $( document ).on('click', '.auto-mail-welcome-next', AutoMailSetup._nextSlider );
            $( document ).on('click', '.auto-mail-welcome-prev', AutoMailSetup._prevSlider );
            $( document ).on('click', '.sui-tab-item', AutoMailSetup._switchSuiTabs );
            $( document ).on('click', '.auto-mail-save-delivery-button', AutoMailSetup._saveSettings);
            $( document ).on('click', '.auto-mail-test-button', AutoMailSetup._sendTestEmail);
            $( document ).on('click', '.auto-mail-region-selector', AutoMailSetup._regionSelector );
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
                        action    : 'auto_mail_test_email',
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
                        AutoMailSetup._displayErrorMessage(options.data);
                    } else {
                        console.log(options);
                        $('.auto-mail-test-button').html('Send test email');
                        AutoMailSetup._displayNoticeMessage(options.data);
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
         * Region Selector
         *
         */
        _regionSelector: function( e ) {
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


            AutoMailSetup._sliderLayerAnimate(direction, svgCoverLayer, pathArray, svgPath);

            $('.auto-mail-welcome-next').removeClass("auto-mail-save-delivery-button");


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

            if ( currentSlider.next('.auto-mail-slide').hasClass('auto-mail-slide-delivery-type') ){
                $('.auto-mail-welcome-next').addClass("auto-mail-save-delivery-button");
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

           AutoMailSetup._sliderLayerAnimate(direction, svgCoverLayer, pathArray, svgPath);

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

            if ( currentSlider.prev('.auto-mail-slide').hasClass('auto-mail-slide-delivery-type') ){
                $('.auto-mail-welcome-next').addClass("auto-mail-save-delivery-button");
            }

        },

        _sliderLayerAnimate: function(direction, svgCoverLayer, paths, svgPath) {
            var duration = 300;
            var delay = 300;
            var epsilon = (1000 / 60 / duration) / 4;
            var firstCustomMinaAnimation = AutoMailSetup._bezier(.42, .03, .77, .63, epsilon);
            var secondCustomMinaAnimation = AutoMailSetup._bezier(.27, .5, .6, .99, epsilon);

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
     * Initialize AutoMailSetup
     */
    $(function(){
        AutoMailSetup.init();
    });

})(jQuery);
