<?php
/**
 * AEF Event
 *
 * Class in charge of single event
 */

 // Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

class AEF_Event {

    /**
	 * The post ID.
	 *
	 * @since 1.0
	 * @access   private
	 * @var      string
	 */
    protected $id;
    
    /**
	 * Initialize the class and set its properties.
	 *
	 * @since 1.0
	 * @access public
	 * @param int $id
	 */
    public function __construct($id = null) {

        $this->id = $id;

    }

    /**
     * Gets post ID.
     * If not set, use global $post
     */
    public function id() {

        if($this->id) {

            return $this->id;

        } else {

            global $post;
            
            if(isset($post->ID)) {
                return $post->ID;
            }

        }

        return null;

    }

    /**
     * Returns post title
     */
    public function title() {

        return get_the_title($this->id);

    }

    /**
     * Returns permalink
     */
    public function url() {

        return get_permalink($this->id);

    }

    /**
     * Returns the exceprt
     * 
     * @param int trunc
     */
    public function excerpt() {

        return get_the_excerpt($this->id);

    }

    /**
     * Returns date
     * 
     * @param string $format
     */
    public function published($format = 'M jS Y') {

        return get_the_time($format, $this->id);

    }

    /**
     * Returns featured image.
     * 
     * @param int $width
     * @param int $height
     * @param bool $crop
     * @see vt_resize() in modules/wp-image-resize.php
     */
    public function image($width = 900, $height = 500, $crop = true) {

        $attachment_id = get_post_thumbnail_id($this->id);

        if($attachment_id) {
            return vt_resize($attachment_id, '', $width, $height, $crop);
        }

        return false;

    }

    /**
     * Returns the main category (first in array, index [0] via reset()).
     * 
     * @see https://www.php.net/manual/en/function.reset.php
     * @param string $return | See $this->categories() above
     */
    public function main_category($return = null) {

        $post_cats = $this->get_terms('category', $return);
        
        if(!empty($post_cats) && !is_wp_error($post_cats)) {
            return reset($post_cats);
        }

        return null;
        
    }

    /**
     * Returns the service categories.
     * 
     * @param string $taxonomy
     * @param string $return | Accepts: all | all_with_object_id | ids | tt_ids | slugs | count | id=>parent | id=>name | id=>slug
     * @see https://developer.wordpress.org/reference/classes/wp_term_query/__construct/
     */
    public function get_terms($taxonomy = '', $return = null) {

        $args = $return ? array('fields' => $return) : array();        
        $post_terms = wp_get_object_terms($this->id, $taxonomy, $args);

        if(!empty($post_terms) && !is_wp_error($post_terms)) {
            return $post_terms;
        }

        return null;

    }

    /**
     * Returns the custom meta start date.
     */
    public function start_date() {

        return get_field('event_start_date', $this->id);

    }

    /**
     * Returns the custom meta end date.
     */
    public function end_date() {

        return get_field('event_end_date', $this->id);

    }

    /**
     * Returns the custom meta event_display_location.
     */
    public function display_location() {

        return get_field('event_display_location', $this->id);

    }

    /**
     * Gets event date
     * 
     * Returns the event date bearing in mind start and end date fields
     *
     * @param string $format
     * @param string $start_end
     * @param bool $echo
     *
     * Usage: $event->date('m Y, H:i', 'start', false);
     */
    public function date($format = null, $start_end = 'start_end', $echo = false) {

        // Date & time
        $event_start = $this->start_date();
        $event_end = $this->end_date();

        if (empty($event_start) && $echo) {
            echo __('--');
            return;
        }

        $event_start_date = new DateTime($event_start, wp_timezone());
        $event_end_date = new DateTime($event_end, wp_timezone());

        // Start date
        $get_event_start_day = $event_start_date->format("j");
        $get_event_start_month = $event_start_date->format("M");
        $get_event_start_year = $event_start_date->format("Y");

        // End date
        $get_event_end_day = $event_end_date->format("j");
        $get_event_end_month = $event_end_date->format("M");
        $get_event_end_year = $event_end_date->format("Y");

        // Checks
        if ($format == null) {

            if ($event_end) { // If end date

                if ($get_event_start_year == $get_event_end_year) { // Same year

                    if ($get_event_start_month == $get_event_end_month) { // Same month

                        $event_end = '';
                        if ($get_event_start_day != $get_event_end_day) { // Same day
                            $event_end = ' &ndash; ' . $get_event_end_day;
                        }

                        $the_date = $get_event_start_day . $event_end . ' ' . $get_event_end_month . ' ' . $get_event_end_year; // Format: 23 - 25 Nov 2015

                    } else {

                        $the_date = $get_event_start_day . ' ' . $get_event_start_month . ' &ndash; ' . $get_event_end_day . ' ' . $get_event_end_month . ' ' . $get_event_end_year; // Format: 23 Nov - 3 Dec 2015

                    }
                } else { // Different year

                    $the_date = $event_start_date->format("j M Y") . ' &ndash; ' . $event_end_date->format("j M Y");
                }
            } else { // If NOT end date

                $the_date = $event_start_date->format("j M Y");
            }
        } else {

            if ($start_end == 'start_end') {

                $start = $event_start_date->format($format);
                $end = '';
                if ($event_end) {
                    $end = ' &ndash; ' . $event_end_date->format($format);
                }

                $the_date = $start . $end;
            } else {

                if ($start_end == 'start') {
                    $the_date = $event_start_date->format($format);
                } elseif ($start_end == 'end') {
                    $the_date = $event_end_date->format($format);
                }
            }
        }

        if ($echo)
            echo $the_date;
        else
            return $the_date;
    }

    /**
     * Returns the address.
     * 
     * @param array $exclude
     * @param string $separator
     * @return string|array
     */
    public function address($exclude = array(), $separator = '') {

        $address = get_field('event_address', $this->id) ?? array();

		// Remove empty items from the array
		$array = array_filter($address);
    
		// Combine number and street in a new field called address_1
		$address_1 = '';
		if (!empty($array['number'])) {
			$address_1 .= $array['number'];
		}
		if (!empty($array['street'])) {
			$address_1 .= ' ' . $array['street'];
		}
		
		// Remove 'number' and 'street' fields
		unset($array['number'], $array['street']);
		
		// Remove any items that match keys in the $exclude array
		if (!empty($exclude)) {
			foreach ($exclude as $key) {
				unset($array[$key]);
			}
		}

		if (!empty($address_1)) {
			$position = 'name';
			$inserted = array('address_1' => $address_1);
			$array = array_slice($array, 0, array_search($position, array_keys($array)) + 1, true)
			+ $inserted
			+ array_slice($array, array_search($position, array_keys($array)) + 1, null, true);

		}
		
		// Join the final array with $separator as the separator between array items
		$result = implode($separator, $array);
		
		return $result;

    }

    /**
     * Expire event
     * @return int
     */
    public function expire() {
        return wp_update_post(array(
            'ID'            =>  $this->id,
            'post_status'   =>  'expired_event'
        ));
    }

}

/**
 * Expire event function used by the cron job
 * @param array $args
 * @return int
 */
function expire_event($args) {

    $post_id = isset($args['post_id']) && !empty($args['post_id']) ? $args['post_id'] : null;

    if($post_id) {
        $event = new AEF_Event($post_id);
        $event->expire();
    }

}