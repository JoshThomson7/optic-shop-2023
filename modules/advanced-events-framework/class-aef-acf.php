<?php
/**
 * AEF ACF
 *
 * Class in charge of registering AEF custom post types
 */

 // Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

class AEF_ACF {

    public function __construct() {

        add_filter('acf/validate_value/name=event_end_date', array($this, 'validate_date'), 10, 4);
        add_action('acf/save_post', array($this, 'save_event'), 10);

    }

    /**
     * Validate end date
     * @param  boolean $valid  Whether the value is valid or not
     * @param  mixed   $value  The value which was loaded from the database
     * @param  array   $field  The field array holding all the field options
     * @param  string  $input  The corresponding input name for $_POST value
     * @return boolean
     */
    public function validate_date( $valid, $value, $field, $input ){

        // bail early if value is already invalid
        if( !$valid ) {
            return $valid;
        }
    
        $startdate = $_POST['acf']['field_5824547123e9b'];
    
        if($value):
            if($startdate > $value):
                $valid = 'The end date must be after the start date';
            endif;
        endif;
    
        return $valid;
    
    }

    /**
     * Save event
     * @param  int $post_id
     * @return void
     */
    public function save_event($post_id) {

        $post_type = get_post_type($post_id);
        $post_status = get_post_status($post_id);
    
        if($post_type === 'event') {

            $cron_args = array(
                'callback' => 'expire_event',
                'args' => array(
                    'post_id' => $post_id
                )
            );

            if($post_status === 'expired_event') {

                new FL1_Cron('clear', $cron_args);
            
            } else {

                $get_expiry_date = get_field('event_expiry_date', $post_id);

                if($get_expiry_date) {
                    $expiry_date = new DateTime($get_expiry_date, wp_timezone());
                    new FL1_Cron('clear', $cron_args);
                    new FL1_Cron($expiry_date->getTimestamp(), $cron_args);
                }

            }

        }

    }

}