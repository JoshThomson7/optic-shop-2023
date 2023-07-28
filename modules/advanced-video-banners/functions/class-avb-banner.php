<?php
/**
 * AVB Banner
 * Class in charge of the banner(s) of a page
 * 
 * @package AVB
 */

 // Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

class AVB_Banner {

    public $data;
    public $post;

    /**
     * Instantiate class and set its properties
     * 
     * @param integer $post_id
     * @param string $type
     */
    public function __construct($data) {

        $this->data = $data;

        global $post;
        $this->post = $post;

    }

    public function get_prop($prop = '') {

        return $this->data[$prop];

    }

    /**
     * Returns the main banner index
     */
    public function index() {

        return $this->get_prop('index') ?? null;

    }

    /**
     * Returns the main banner acf_fc_layout
     */
    public function layout() {

        return $this->get_prop('acf_fc_layout') ?? null;

    }

    /**
     * Returns logo image
     */
    public function logo() {

        $image_id = $this->get_prop('logo');

        if($image_id) { 
            $image = vt_resize($image_id, '', 570, 200, false);
            return is_array($image) && isset($image['url']) ? '<img src="'.$image['url'].'" alt="" />' : null;
        }

        return null;

    }

    /**
     * Returns the main banner heading
     */
    public function heading($html = true) {

        $heading = '';
        $h = $this->index() === 1 ? '1' : '2';

        if(is_front_page()) {
            $heading = $this->get_prop('heading') ?? null;
        } else {
            $heading = $this->get_prop('heading') ? $this->get_prop('heading') : get_the_title($this->post->ID);
        }

        if(!$html) return $heading;

        if($this->get_prop('heading_hide')) {
            $h .= ' class="hidden"';
        }

        return '<h'.$h.'>'.$heading.'</h'.$h.'>';

    }

    /**
     * Returns the small top header
     */
    public function headingTop() {

        $heading_top = $this->get_prop('heading_top') ?? null;
        return $heading_top ? '<h3>'.$this->get_prop('heading_top').'</h3>' : '';

    }
    
    /**
     * Returns the banner caption
     */
    public function caption() {
		
		return $this->get_prop('caption') ?? null;

    }
    
    /**
     * Returns the banner button_label
     */
    public function button_label() {

        return $this->get_prop('button_label') ?? null;

    }

    /**
     * Returns the banner button_type
     */
    public function button_type() {

        return $this->get_prop('button_type') ?? null;

    }
    
    /**
     * Returns the banner button_url
     */
    public function button_url() {

        return $this->get_prop('button_url') ?? null;

    }
    
    /**
     * Returns the banner button_url_target
     */
    public function button_url_target() {

        $url = $this->get_prop('button_url') ?? null;

		if(strpos($url, $_SERVER['HTTP_HOST']) === false) {
			return ' target="_blank"';
		}

		return '';

    }

    /**
     * Returns the banner overlay_opacity
     */
    public function overlay_opacity() {

        return 'opacity-'.$this->get_prop('overlay_opacity');

    }

    /**
     * Return alternative mobile image
     */
    public function image_mobile($return = 'url', $width = 1600, $height = 900, $crop = true) {

        $image_id = $this->get_prop('image_mobile');
        $image_url = '';
        if($image_id) { 
            $image_url = vt_resize($image_id, '', $width, $height, $crop);
			if(is_array($image_url)) {
            	return isset($image_url[$return]) ? $image_url[$return] : null;
			}
			return null;
        }

        return null;

    }


    /**
     * Returns the banner slide_duration
     */
    public function duration() {

        $duration = $this->get_prop('slide_duration');
		return $duration ? $duration * 1000 : 5000;

    }

    /**
     * Returns the banner avb_dots_position
     */
    public function dots_position() {

        return 'opacity-'.$this->get_prop('avb_dots_position');

    }

}
