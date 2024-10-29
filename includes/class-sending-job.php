<?php
/**
 * Auto Mail Sending Job Class
 *
 * @since  1.0.0
 * @package Auto Mail
 */

defined( 'ABSPATH' ) or exit;

if ( ! class_exists( 'Auto_Mail_Sending_Job' ) ) :

	/**
	 * Auto Mail Queue
	 */
	class Auto_Mail_Sending_Job {

        /**
		 * Constructor.
		 *
		 * @since 1.1.0
		 */
		public function __construct() {
        }

        /**
         * Do sending job.
         *
         * @since 1.1.0
         */
        public function do_sending() {
            // Global settings
            $settings = get_option('auto_mail_global_settings');

            // Run campaigns queue job here
            $scheduledCampaigns = array();
            $campaigns = Auto_Mail_Campaign_Model::model()->get_all_models();
            foreach($campaigns['models'] as $key => $item){
                if($item->status == 'scheduled'){
                    $scheduledCampaigns[] = $item;
                }
            }

            foreach($scheduledCampaigns as $key => $campaign){
                // Prepare limit subscribers from sending queue
                $limit = isset($settings['sending_limit']) ? $settings['sending_limit']  : "2";
                $sendingSubscribers = Auto_Mail_Queue::prepare_subscribers($campaign->id, $limit);
                // Update campaign status to sent if all emails have been sent
                if(empty($sendingSubscribers)){
                    Auto_Mail_Campaign_Model::model()->update($campaign->id, 'sent');
                }

                if(!empty($scheduledCampaigns)){
                    foreach($sendingSubscribers as $key => $item){
                        $options = array(
                            'to_address' => $item->subscriber,
                            'to_name' => $item->name,
                            'subject' => $campaign->settings['subject'],
                            'html' => $campaign->html
                        );
                        $sender = new Auto_Mail_Sender($settings['delivery_method'], $options);
                        $result = $sender->do_send(false);
                        //update subscriber status on sending queue
                        if($result){
                            Auto_Mail_Queue::mark_email_send($item->id);
                        }
                    }
                }

            }
        }





    }

endif;
