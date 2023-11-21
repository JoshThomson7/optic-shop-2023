<?php 

/* Enqueue Scripts
*/
function atm_enqueue() {

    if(is_page('our-team')){
      
        // style
        // wp_enqueue_style('atm-styles', atm_path(true).'assets/css/at-archive.min.css' );

        // Ajax
        wp_enqueue_script('atm-scripts', atm_path(true).'assets/js/atm-scripts.min.js', array('jquery'), '', false);
        wp_localize_script('atm-scripts', 'atm_ajax_object', array(
            'ajax_url' => admin_url( 'admin-ajax.php' ),
            'ajax_nonce' => wp_create_nonce('$C.cGLu/1zxq%.KH}PjIKK|2_7WDN`x[vdhtF5GS4|+6%$wvG)2xZgJcWv3H2K_M'),
        ));
    }

}
add_action('wp_enqueue_scripts', 'atm_enqueue', 20);
