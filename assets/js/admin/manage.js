(function($){

    "use strict";

    var AMManage = {

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
            $( document ).on('click', '.auto-mail-vertical-tab a', AMManage._switchTabs );
            $( document ).on('click', '.auto-mail-vertical-tab a', AMManage._switchTabs );

            $( document ).on( 'click', '.auto-mail-init-status-selector', AMManage._statusSelector );
            // Import actions
            $( document ).on('click', '#auto-mail-prepare-import', AMManage._prepareImportData );
            $( document ).on('click', '.auto-mail-do-import', AMManage._doImport );
            $( document ).on('click', '#auto-mail-mailchimp-verify', AMManage._mailchimpVerify );
            $( document ).on('change', '.auto-mail-list-toggle', AMManage._rolesToggle );
            // Export actions
            $( document ).on('click', '.auto-mail-do-export', AMManage._doExport );
        },

        /**
         * Do export
         *
         */
        _doExport: function(event) {
            event.preventDefault();
            $(this).html('<div class="text-center"><div class="loader1"><span></span><span></span><span></span><span></span><span></span></div></div>');

            var formdata = $('.auto-mail-export-form').serializeArray();
            var fields = {};
            $(formdata ).each(function(index, obj){
                fields[obj.name] = obj.value;
            });

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
                        action       : 'auto_mail_do_export',
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
                        $('.auto-mail-do-export').html('<span class="auto-mail-loading-text">Export</span>');
                    } else {
                        console.log(options);
                        AMManage._downloadFile(options.data.url);
                        $('.auto-mail-do-export').html('<span class="auto-mail-loading-text">Export</span>');
                    }
                });
        },

        /**
         * Download file
         *
         */
        _downloadFile: function(dataurl)  {
            const link = document.createElement("a");
            link.href = dataurl;
            link.click();
        },

        /**
         * Roles Toggle
         *
         */
        _rolesToggle: function( ) {
            $('.auto-mail-selected-roles').each(function( ) {
                if($(this).prop('checked')){
                    $(this).prop('checked', false);
                }else{
                    $(this).prop('checked', true);
                }
            });
        },

        /**
         * MailChimp Verify
         *
         */
        _mailchimpVerify: function( ) {

            var formdata = $('.auto-mail-mailchimp-form').serializeArray();
            var fd = new FormData();
            $(formdata ).each(function(index, obj){
                fd.append(obj.name, obj.value);
            });

            fd.append("_ajax_nonce", Auto_Mail_Data._ajax_nonce);
            fd.append('action', "auto_mail_mailchimp_verify");

            $.ajax({
                    url  : Auto_Mail_Data.ajaxurl,
                    type : 'POST',
                    dataType: 'json',
                    contentType: false,
                    processData: false,
                    data : fd,
                    beforeSend: function() {
                        $('.auto-mail-import-running').toggleClass('active');
                    },
                })
                .fail(function( jqXHR ){
                    console.log( jqXHR.status + ' ' + jqXHR.responseText);
                })
                .done(function ( options ) {
                    if( false === options.success ) {
                        console.log(options);
                        //AMManage._displayNoticeMessage(options.data.msg);
                        $('.auto-mail-import-running').toggleClass('active');
                    } else {
                        $('.auto-mail-import-running').toggleClass('active');
                        // Show mailchimp lists
                        $('.auto-mail-import-steps').html(options.data.html);
                    }
                });

        },

        /**
         * Do Import
         *
         */
        _doImport: function(event) {
            event.preventDefault();
            var formdata = $('#subscriber-import-table').serializeArray();
            var fields = {};
            $(formdata).each(function(index, obj){
                if(obj.name == 'import_lists'){
                    return;
                }
                fields[obj.name] = obj.value;
            });

            var lists = [];
            $("input:checkbox[name=import_lists]:checked").each(function(){
                lists.push($(this).val());
            });
            fields['lists'] = lists;
            fields['identifier'] = $('#import-identifier').val();

            $.ajax({
                url  : Auto_Mail_Data.ajaxurl,
                type : 'POST',
                dataType: 'json',
                data : {
                    action       : 'auto_mail_do_import',
                    fields_data  : fields,
                    _ajax_nonce  : Auto_Mail_Data._ajax_nonce,
                },
                beforeSend: function() {
                    $('.auto-mail-import-running').toggleClass('active');
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
                    $('.auto-mail-import-running').toggleClass('active');
                    $('.auto-mail-import-steps').html(options.data.html);
                    $('.auto-mail-import-steps').addClass('auto-mail-import-results');
                }
            });
        },

        /**
         * Prepare Import Data
         *
         */
        _prepareImportData: function( ) {

            var formdata = $('.auto-mail-prepare-form').serializeArray();
            var fd = new FormData();
            $(formdata ).each(function(index, obj){
                fd.append(obj.name, obj.value);
            });

            if($(this).hasClass('auto-mail-paste-method')){
                fd.append("type", "paste");
            }else if($(this).hasClass('auto-mail-upload-method')){
                fd.append("type", "upload");
                var file = $('input[type="file"]');
                var individual_file = file[0].files[0];
                fd.append("file", individual_file);
            }else if($(this).hasClass('auto-mail-mailchimp-method')){
                fd.append("type", "mailchimp");
            }else if($(this).hasClass('auto-mail-wordpress-method')){
                fd.append("type", "wordpress");
            }

            fd.append("_ajax_nonce", Auto_Mail_Data._ajax_nonce);
            fd.append('action', "auto_mail_import_handler");

            $.ajax({
                    url  : Auto_Mail_Data.ajaxurl,
                    type : 'POST',
                    dataType: 'json',
                    contentType: false,
                    processData: false,
                    data : fd,
                    beforeSend: function() {
                        $('.auto-mail-import-running').toggleClass('active');
                    },
                })
                .fail(function( jqXHR ){
                    console.log( jqXHR.status + ' ' + jqXHR.responseText);
                })
                .done(function ( options ) {
                    if( false === options.success ) {
                        console.log(options);
                        //AMManage._displayNoticeMessage(options.data.msg);
                        $('.auto-mail-import-running').toggleClass('active');
                    } else {
                        console.log(options.data.identifier);
                        $('.auto-mail-import-running').toggleClass('active');
                        // Show import data
                        AMManage._showImportData(options.data.identifier);
                    }
                });

        },

        /**
         * Show Import Data
         *
         */
        _showImportData: function(identifier) {
            $.ajax({
                url  : Auto_Mail_Data.ajaxurl,
                type : 'POST',
                dataType: 'json',
                data : {
                    action       : 'auto_mail_show_import_data',
                    identifier   : identifier
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
                    $('.auto-mail-import-steps').html(options.data.html);
                }
            });
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
         * Status Selector
         *
         */
        _statusSelector: function(e) {
                e.preventDefault();
                e.stopPropagation();
                /* api type expanded */
                $(this).toggleClass('expanded');

                /* set from status value */
                var status = $(this).find('#'+$(e.target).attr('for'));
                console.log(status);
                status.prop('checked',true);

                $('.shortcode-select').hide();
                $('.'+$(e.target).attr('for')).show();
                $('.'+$(e.target).attr('for')).addClass('current');
        },

        /**
         * Display Notice Message
         *
         */
         _displayNoticeMessage: function(message) {
            var html = '<div class="message-box auto-mail-message-box success">' + message + '</div>';
            $(html).prependTo(".auto-mail-import-actions").slideDown('slow');
        },

    };

    /**
     * Initialize AMManage
     */
    $(function(){
        AMManage.init();
    });

})(jQuery);
