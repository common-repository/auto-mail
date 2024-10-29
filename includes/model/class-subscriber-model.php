<?php
/**
 * Auto_Mail_Subscriber_Model Class
 *
 * @since  1.0.0
 * @package Auto Mail
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'Auto_Mail_Subscriber_Model' ) ) :

    class Auto_Mail_Subscriber_Model extends Auto_Mail_Form_Base_Model {

        protected $post_type = 'am_subscribers';

        /**
         * @param int|string $class_name
         *
         * @since 1.0
         * @return Auto_Mail_Subscriber_Model
         */
        public static function model( $class_name = __CLASS__ ) { // phpcs:ignore
            return parent::model( $class_name );
        }

        /**
         *
         * Search subscribers with args
         * @param array $args
         * @since 1.0.0
         */
        public function search( $args ) {
            $selected = array();
            $models = array();
            $all = $this->get_all_models();

            // Set result array header
            $selected[0] = array_keys($all['models'][0]->settings);

            // Prepare selected array
            foreach($all['models'] as $key => $value){
                $models[$key] = $value->settings;
            }

            // Search array by lists
            foreach($models as $key => $value){
                foreach($args['lists'] as $list){
                    if(in_array($list, $value['lists'])){
                        $selected[] = $value;
                    }
                }
            }

            $result = array();
            // Remove lists column
            foreach ($selected as $element) {
                $result[] = array_slice($element, 0, 4);
            }

            return $result;
        }

        public function delete_col(&$array, $offset) {
            return array_walk($array, function (&$v) use ($offset) {
                array_splice($v, $offset, 1);
            });
        }


    }

endif;
