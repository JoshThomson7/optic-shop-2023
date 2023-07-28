<?php

/**
 * Ins Bank
 *
 * Class in charge of single bank
 */

// Exit if accessed directly
if (!defined('ABSPATH')) exit;

class Ins_Bank
{

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
    public function __construct($id = null)
    {

        $this->id = $id;
    }

    /**
     * Gets post ID.
     * If not set, use global $post
     */
    public function id()
    {

        if ($this->id) {

            return $this->id;
        } else {

            global $post;

            if (isset($post->ID)) {
                return $post->ID;
            }
        }

        return null;
    }

    /**
     * Returns post title
     */
    public function name()
    {

        return get_the_title($this->id);
    }

    /**
     * Returns permalink
     */
    public function url()
    {

        return get_permalink($this->id);
    }

    /**
     * Returns the exceprt
     * 
     * @param int trunc
     */
    public function excerpt()
    {

        return get_the_excerpt($this->id);
    }

    /**
     * Returns date
     * 
     * @param string $format
     */
    public function date($format = 'M jS Y')
    {

        return get_the_time($format, $this->id);
    }

    /**
     * Returns bio/content.
     * 
     * @return string
     */
    public function bio($trunc = 0)
    {

        $content = apply_filters('the_content', get_the_content(null, false, $this->id));
        return $trunc ? FL1_Helpers::trunc($content, $trunc) : $content;
    }

    public function get_image_id()
    {
        return get_field('bank_logo', $this->id, false);
    }

    /**
     * Returns featured image.
     * 
     * @param int $width
     * @param int $height
     * @param bool $crop
     * @see vt_resize() in modules/wp-image-resize.php
     */
    public function image($width = 900, $height = 900, $crop = true)
    {

        $attachment_id = $this->get_image_id();

        if ($attachment_id) {
            return vt_resize($attachment_id, '', $width, $height, $crop);
        }

        return false;
    }
}
