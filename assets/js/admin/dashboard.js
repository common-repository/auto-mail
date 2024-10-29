(function($){

    "use strict";

    var AMDashboard = {

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
            $( document ).on('click', '.nav-tab', AMDashboard._switchWelcomeTabs );

        },

        /**
         * Switch Welcome Tabs
         *
         */
         _switchWelcomeTabs: function( event ) {

            event.preventDefault();
            var tab = '#' + $(this).data('nav');

            $('.nav-tab').removeClass('nav-tab-active');
            $(this).addClass('nav-tab-active');

            $('.nav-container').removeClass('active');
            $('.auto-mail-welcome-tabs').find(tab).addClass('active');

        },

    };

    /**
     * InitializeAMDashboard
     */
    $(function(){
        AMDashboard.init();
    });

})(jQuery);
