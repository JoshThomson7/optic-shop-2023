<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
/**
 * ATeam Functions
 *
 * @package modules/woocommerce
 * @version 1.0
*/


/*--------------------------------------------------------------------------*/
/*    function atm_path()
/*    returns the full ATM path
/*--------------------------------------------------------------------------*/
function atm_path($atm_url = false) {

    if($atm_url) {
        $atm_path = get_stylesheet_directory_uri()  . '/modules/advanced-team-members/';
    } else {
        $atm_path = get_stylesheet_directory()  . '/modules/advanced-team-members/';
    }

    return $atm_path;
}

require_once('inc/ateam-post-type.php');
require_once('inc/ateam-enqueue.php');
require_once('inc/ateam-templates.php');
require_once('inc/ateam-ajax.php');


/**
 * wp_dropdown_cats filter to allow multiple 
 * 
 * @source https://gist.github.com/willybahuaud/1af140d0b4132c2e6c49205746332b20
 */

// This filter allow a wp_dropdown_categories select to return multiple items
add_filter( 'wp_dropdown_cats', 'willy_wp_dropdown_cats_multiple', 10, 2 );
function willy_wp_dropdown_cats_multiple( $output, $r ) {
    
    if ( ! empty( $r['data-placeholder'] )  ) {
        $multiple_html = (! empty( $r['multiple'] )) ? ' multiple="multiple"' : ''; 
        $placeholder_html = (! empty( $r['data-placeholder'] )) ? ' data-placeholder="'.$r['data-placeholder'].'"' : ''; 

		$output = preg_replace( '/<select(.*?)>/i', '<select$1 '.$multiple_html.$placeholder_html.'>', $output );
		// $output = preg_replace( '/name=([\'"]{1})(.*?)\1/i', 'name=$2[]', $output );
    }

	return $output;
}

// // This Walker is needed to match more than one selected value
// class Willy_Walker_CategoryDropdown extends Walker_CategoryDropdown {
    
//     public function start_el( &$output, $category, $depth = 0, $args = array(), $id = 0 ) {
// 		$pad = str_repeat('&nbsp;', $depth * 3);

// 		/** This filter is documented in wp-includes/category-template.php */
// 		$cat_name = apply_filters( 'list_cats', $category->name, $category );

// 		if ( isset( $args['value_field'] ) && isset( $category->{$args['value_field']} ) ) {
// 			$value_field = $args['value_field'];
// 		} else {
// 			$value_field = 'term_id';
// 		}

// 		$output .= "\t<option class=\"level-$depth\" value=\"" . esc_attr( $category->{$value_field} ) . "\"";

// 		// Type-juggling causes false matches, so we force everything to a string.
// 		if ( in_array( $category->{$value_field}, (array)$args['selected'], true ) )
// 			$output .= ' selected="selected"';
// 		$output .= '>';
// 		$output .= $pad.$cat_name;
// 		if ( $args['show_count'] )
// 			$output .= '&nbsp;&nbsp;('. number_format_i18n( $category->count ) .')';
// 		$output .= "</option>\n";
// 	}
// }