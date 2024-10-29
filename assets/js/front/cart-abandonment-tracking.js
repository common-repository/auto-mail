(function($){

    "use strict";

    var AMCartTracking = {

        init: function()
        {

            this._bind();

        },

        /**
         * Binds events for the Cart Tracking.
         *
         * @since 1.0.0
         * @access private
         * @method _bind
         */
        _bind: function()
        {
            $( document ).on(
				'keyup keypress change',
				'#billing_email, #billing_phone, input.input-text, textarea.input-text, select',
                AMCartTracking._getCheckoutData
			);

        },

        /**
         * Get checkout data
         *
         */
        _getCheckoutData: function( ) {

            const wcf_email = jQuery( '#billing_email' ).val();

            // console.log(wcf_email);

			if ( typeof wcf_email === 'undefined' ) {
				return;
			}

			let wcf_phone = jQuery( '#billing_phone' ).val();
			const atposition = wcf_email.indexOf( '@' );
			const dotposition = wcf_email.lastIndexOf( '.' );

			if ( typeof wcf_phone === 'undefined' || wcf_phone === null ) {
				//If phone number field does not exist on the Checkout form
				wcf_phone = '';
			}

            if (
				! (
					atposition < 1 ||
					dotposition < atposition + 2 ||
					dotposition + 2 >= wcf_email.length
				) ||
				wcf_phone.length >= 1
			) {
				//Checking if the email field is valid or phone number is longer than 1 digit
				//If Email or Phone valid
				const wcf_name = jQuery( '#billing_first_name' ).val();
				const wcf_surname = jQuery( '#billing_last_name' ).val();
				wcf_phone = jQuery( '#billing_phone' ).val();
				const wcf_country = jQuery( '#billing_country' ).val();
				const wcf_city = jQuery( '#billing_city' ).val();

				//Other fields used for "Remember user input" function
				const wcf_billing_company = jQuery( '#billing_company' ).val();
				const wcf_billing_address_1 = jQuery(
					'#billing_address_1'
				).val();
				const wcf_billing_address_2 = jQuery(
					'#billing_address_2'
				).val();
				const wcf_billing_state = jQuery( '#billing_state' ).val();
				const wcf_billing_postcode = jQuery(
					'#billing_postcode'
				).val();
				const wcf_shipping_first_name = jQuery(
					'#shipping_first_name'
				).val();
				const wcf_shipping_last_name = jQuery(
					'#shipping_last_name'
				).val();
				const wcf_shipping_company = jQuery(
					'#shipping_company'
				).val();
				const wcf_shipping_country = jQuery(
					'#shipping_country'
				).val();
				const wcf_shipping_address_1 = jQuery(
					'#shipping_address_1'
				).val();
				const wcf_shipping_address_2 = jQuery(
					'#shipping_address_2'
				).val();
				const wcf_shipping_city = jQuery( '#shipping_city' ).val();
				const wcf_shipping_state = jQuery( '#shipping_state' ).val();
				const wcf_shipping_postcode = jQuery(
					'#shipping_postcode'
				).val();
				const wcf_order_comments = jQuery( '#order_comments' ).val();

                let timer;

                clearTimeout( timer );


                timer = setTimeout( function () {
				    if (
                     AMCartTracking._validate_email( wcf_email )
				    ) {
                        $.ajax({
                            url  : AM_Cart_Tracking_Data.ajaxurl,
                            type : 'POST',
                            dataType: 'json',
                            data : {
                                action       : 'am_save_cart_abandonment_data',
                                _ajax_nonce  : AM_Cart_Tracking_Data._ajax_nonce,
                                wcf_email,
					            wcf_name,
					            wcf_surname,
					            wcf_phone,
					            wcf_country,
					            wcf_city,
					            wcf_billing_company,
					            wcf_billing_address_1,
					            wcf_billing_address_2,
					            wcf_billing_state,
					            wcf_billing_postcode,
					            wcf_shipping_first_name,
					            wcf_shipping_last_name,
					            wcf_shipping_company,
					            wcf_shipping_country,
					            wcf_shipping_address_1,
					            wcf_shipping_address_2,
					            wcf_shipping_city,
					            wcf_shipping_state,
					            wcf_shipping_postcode,
					            wcf_order_comments,
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
                                console.log(result);
                            }
                        });
				    }
                }, 500 );


			} else {
				//console.log("Not a valid e-mail or phone address");
			}

        },


        _validate_email( value ) {
			let valid = true;
			if ( value.indexOf( '@' ) === -1 ) {
				valid = false;
			} else {
				const parts = value.split( '@' );
				const domain = parts[ 1 ];
				if ( domain.indexOf( '.' ) === -1 ) {
					valid = false;
				} else {
					const domainParts = domain.split( '.' );
					const ext = domainParts[ 1 ];
					if ( ext.length > 14 || ext.length < 2 ) {
						valid = false;
					}
				}
			}
			return valid;
		},


    };

    /**
     * Initialize AMCartTracking
     */
    $(function(){
        AMCartTracking.init();
    });

})(jQuery);
