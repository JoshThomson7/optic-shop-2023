<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
/**
*  APF ACF JSON
*
*  @package APF
*  @see https://support.advancedcustomfields.com/forums/topic/multiple-save-locations-for-json/
*  @docs Hook into filter fl1_acf_json_save_groups to add your save locations
*  @docs Hook into filter fl1_acf_json_load_location to add your load locations
*/

class FL1_ACF_JSON {

    private $groups = array();
    private $current_group_being_saved;

    public function __construct() {

        // This init action will set up the save paths
        // /add_action('admin_init', array($this, 'admin_init'));
        //add_action('admin_notices', array($this, 'acf_admin_notice'));

        // Called by ACF before saving a field group.
        // Priority is set to 1 so that it runs before the internal ACF action
        add_action('acf/update_field_group', array($this, 'update_field_group'), 1, 1);

        add_filter('acf/settings/load_json', array($this, 'json_load_location'));

    }

    /**
     * Set up the paths where we
     * want to store JSON files.
     */
    public function admin_init() {

        $this->groups = acf_get_field_groups();

    }

    /**
     * Set save location.
     */
    public function update_field_group($group) {

        // Renew groups so it includes new ones 
        $this->groups = apply_filters('fl1_acf_json_save_groups', $this->groups, $group);

        // first check to see if this is one of our groups
        if (!isset($this->groups[$group['key']])) {
            // not one or our groups
            return $group;
        }
        
        // store the group key and add action
        $this->current_group_being_saved = $group['key'];
        add_action('acf/settings/save_json',  array($this, 'json_save_location'));

        // don't forget to return the groups
        return $group;

    }

    public function json_save_location($path) {

        $path = $this->groups[$this->current_group_being_saved];
        return $path;

    }

    public function json_load_location( $paths ) {

        $paths = apply_filters('fl1_acf_json_load_location', $paths);

        return $paths;
    
    }

}