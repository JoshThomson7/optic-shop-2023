<?php
/**
 * AEF Init
 *
 * Class in charge of initialising everything AEF
 */

 // Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

class AEF {

    public function __construct() {

        $this->define_constants();

        add_filter(FL1_SLUG.'_load_dependencies', array($this, 'load_dependencies'));
        add_action(FL1_SLUG.'_setup_theme',	array($this, 'setup_theme'));
        add_action(FL1_SLUG.'_acf_init', array($this, 'acf_init'));

    }

    /**
     * Setup constants.
     *
     * @access private
     * @since 1.0
     * @return void
     */
    private function define_constants() {
        
        define('AEF_VERSION', '2.0');
        define('AEF_SLUG', 'aef');
        define('AEF_PLUGIN_FOLDER', 'advanced-events-framework');
        define('AEF_PATH', FL1_PATH.'/modules/'.AEF_PLUGIN_FOLDER.'/');
        define('AEF_URL', FL1_URL.'/modules/'.AEF_PLUGIN_FOLDER.'/');

    }

    public function load_dependencies($deps) {

        $deps[] = AEF_PATH. 'class-aef-cpt.php';
        $deps[] = AEF_PATH. 'class-aef-acf.php';
        $deps[] = AEF_PATH. 'class-aef-event.php';

        return $deps;

    }

    public function setup_theme() {

        new AEF_CPT();
        new AEF_ACF();

        add_filter('fl1_acf_json_save_groups', array($this, 'save_field_groups'), 10, 2);
        add_filter('fl1_acf_json_load_location', array($this, 'load_field_groups'));

    }

    public function acf_init() {

        if(function_exists('acf_add_options_sub_page')) {
        
            acf_add_options_sub_page(array(
                'page_title'  => 'Event Settings',
                'menu_title'  => 'Event Settings',
                'menu_slug' => AEF_SLUG.'-settings',
                'parent_slug' => 'edit.php',
            ));

        }

    }

    public function save_field_groups($field_groups, $group) {

        if (strpos($group['title'], 'Event') !== false) {
            $field_groups[$group["key"]] = AEF_PATH .'acf-json';
        }

        return $field_groups;

    }

    public function load_field_groups($paths) {

        $paths[] = AEF_PATH .'acf-json';

        return $paths;

    }
    

}

// Release the Kraken!
new AEF();