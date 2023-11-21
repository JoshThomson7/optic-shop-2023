<?php

/**
 * Ins Rate
 *
 * Class in charge of single rate
 */

// Exit if accessed directly
if (!defined('ABSPATH')) exit;

class Ins_Rate
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
    public function date($format = 'j M Y')
    {

        return get_the_time($format, $this->id);
    }

    /**
     * Returns date
     * 
     * @param string $format
     */
    public function last_modified($format = 'Ymd')
    {

        return get_the_modified_time($format, $this->id);
    }

    /**
     * Returns rate
     * 
     * @param string $format
     */
    public function rate($rate)
    {
        return get_field($rate, $this->id) ?? null;
    }

    /**
     * Returns rate
     * 
     * @param string $format
     */
    public function get_rates()
    {

        $rates = array();
        $fields = acf_get_fields('group_6480856236c48') ?? array();

        foreach ($fields as $field) {
            $rate = array();
            $value = $this->rate($field['name']);
            if (!$value) continue;

            $rate['label'] = $field['label'];
            $rate['value'] = $value;
            $rate['symbol'] = '%';

            $rates[] = $rate;
        }

        return $rates;
    }
}
