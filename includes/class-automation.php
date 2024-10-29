<?php
/**
 * AM_Automation Class
 *
 * @since  1.0.0
 * @package Auto Mail
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
} // Exit if accessed directly

if ( ! class_exists( 'AM_Automation' ) ) :

   class AM_Automation {

       /**
        * Plugin instance
        *
        * @var null
        */
       private static $instance = null;


       /**
        * @var         array $triggers Registered triggers
        * @since       1.0.0
        */
       public $triggers = array();

       /**
        * @var         array $actions Registered actions
        * @since       1.0.0
        */
       public $actions = array();

       /**
        * Return the plugin instance
        *
        * @since 1.0.0
        * @return AM_Automation
        */
       public static function get_instance() {
           if ( is_null( self::$instance ) ) {
               self::$instance = new self();
           }

           return self::$instance;
       }

       /**
       * AM_Automation constructor.
       *
       * @since 1.0.0
       */
       public function __construct() {

       }

   }

endif;
