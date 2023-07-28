<?php

/**
 * FC Helpers
 *
 * Helper static methods for the FC module.
 */

// Exit if accessed directly
if (!defined('ABSPATH')) exit;

class FC_Helpers
{

    public static function flexible_content($fc_id = null)
    {

        $current_user_id = get_current_user_id();

        do_action('fc_before');

        if (have_rows('fc_content_types', $fc_id)) {

            $row_count = 1;
            $overlap = get_field('fc_overlap') ? ' fc-overlap' : '';

            if (!$fc_id) {
                echo '<div id="flexible_content" class="flexible__content' . $overlap . '">';
            }

            do_action('fc_before_loop');

            while (have_rows('fc_content_types', $fc_id)) {
                the_row();

                // open section - see fc-functions.php
                $open = FC_Helpers::fc_field_section(get_row_layout(), 'open', $row_count, $fc_id);

                if (!$open['skip_open']) {
                    echo get_row_layout() === 'fc_global' ? '' : $open['html'];
                }

                if (file_exists(FC_PATH . 'layouts/' . get_row_layout() . '.php')) {
                    require FC_PATH . 'layouts/' . get_row_layout() . '.php';
                } else {
                    echo 'Layout <strong>' . get_row_layout() . '.php</strong> not found.';
                }

                // close section - see fc-functions.php
                $close = FC_Helpers::fc_field_section(get_row_layout(), 'close', $row_count, $fc_id);

                if (!$close['skip_close']) {
                    echo get_row_layout() === 'fc_global' ? '' : $close['html'];
                }

                $row_count++;
            }

            do_action('fc_after_loop');

            if (!$fc_id) {
                echo '</div><!-- flexible__content -->';
            }
        }

        do_action('fc_after');
    }

    public static function fc_field_section($row_layout, $open_close, $row_count, $fc_id = null)
    {

        $fc_classes = array('fc-layout', $row_layout);
        $max_width_classes = array('max__width');
        $layout_container_classes = array('fc-layout-container');

        // section heading
        $options = get_sub_field('fc_options');
        $option_squares = $options['squares'];
        $option_top_heading = $options['top_heading'];
        $option_heading = $options['heading'];
        $option_heading_center = $options['heading_center'];
        $option_caption = $options['caption'];
        $section_link = $options['section_link'];
        $option_tab = $options['tab_name'];

        // generate section ID
        $tab_id = '';
        if ($option_tab) {
            $tab_id = ' id="' . strtolower(preg_replace("#[^A-Za-z0-9]#", "", $option_tab)) . '_section"';
        }

        // Styles
        $style = array();
        $fc_styles = get_sub_field('fc_styles');

        // Padding
        $padding = $fc_styles['fc_padding'];
        $background = $fc_styles['fc_background'];
        $background_constrain = $fc_styles['fc_background_constrain'];

        $padding_style = 'padding:';
        $padding_top = $padding['fc_padding_top'] ?? 0;

        $wave = get_field('fc_wave_separator');
        $theme = get_field('theme_colour');
        if ($wave && $row_count == 1 && !$fc_id) {
            $padding_top = $padding_top + ($theme === 'default' ? 120 : 140);
        }

        $padding_style .= !empty($padding_top) ? ' ' . $padding_top . 'px' : ' 0';
        $padding_style .= !empty($padding['fc_padding_right']) ? ' ' . (($padding['fc_padding_right'] * 100) / 1200) . '%' : ' 0';
        $padding_style .= !empty($padding['fc_padding_bottom']) ? ' ' . $padding['fc_padding_bottom'] . 'px' : ' 0';
        $padding_style .= !empty($padding['fc_padding_left']) ? ' ' . (($padding['fc_padding_left'] * 100) / 1200) . '%' : ' 0';

        $style[] = $padding_style;


        if ($background) {
            if ($background_constrain) {
                $max_width_classes[] = 'fc-bg-theme--' . $background . ' fc-bg-constrain';
            } else {
                $layout_container_classes[] = 'fc-bg-theme--' . $background;
            }
        }

        // Classes
        $fc_classes = join(' ', $fc_classes);
        $max_width_classes = join(' ', $max_width_classes);
        $layout_container_classes = join(' ', $layout_container_classes);

        // full width
        $full_width = $fc_styles['fc_full_width'] == true ? true : false;

        // open/close
        $html = '';
        if ($open_close === 'open') {

            if ($row_layout === 'fc_carousel_open') {

                $html .= '<div class="fc-layout-carousel ' . $fc_classes . '">';
            } else {

                $html .= '<section' . $tab_id . ' class="' . $fc_classes . '">';

                $html .= '<div class="' . $layout_container_classes . '" style="' . $padding_style . '">';

                // check if full with
                if (!$full_width) {
                    $html .= '<div class="' . $max_width_classes . '">';
                }

                if ($option_top_heading || $option_heading || $option_caption || (isset($section_link['url']) && $section_link['url'])) {
                    $centre_heading = '';
                    if ($option_heading_center) {
                        $centre_heading = ' centred';
                    }

                    $squares = '';
                    if ($option_squares) {
                        $squares = '<figure class="fc-squares">' . file_get_contents(FL1_PATH . '/img/squares.svg') . '</figure>';
                    }

                    $section_top_heading = '';
                    if ($option_top_heading) {
                        $section_top_heading = '<h5>' . $option_top_heading . '</h5>';
                    }

                    $section_heading = '';
                    if ($option_heading) {
                        $section_heading = '<h2>' . $option_heading . '</h2>';
                    }

                    $section_caption = '';
                    if ($option_caption) {
                        $section_caption = $option_caption;
                    }

                    $html .= '<div class="fc-layout-heading' . $centre_heading . '">';
                    $html .= '<div class="fc-layout-heading-left">' . $squares . $section_top_heading . $section_heading . $section_caption . '</div>';
                    $html_heading_right = '';
                    if ($section_link['label'] && $section_link['url']) {
                        $html_heading_right = '<a href="' . $section_link['url'] . '" class="link animate-icon icon-right">' . $section_link['label'] . '<i class="fa fa-arrow-right"></i></a>';
                    }
                    $html .= '<div class="fc-layout-heading-right">' . $html_heading_right . '</div>';
                    $html .= '</div>';
                }
            }
        } elseif ($open_close === 'close') {

            if ($row_layout === 'fc_carousel_close') {

                $html .= '</div>';
            } else {

                // check if full with
                if (!$full_width) {
                    $html .= '</div><!-- max__width -->';
                    $html .= '</div><!-- fc-layout-container -->';
                    $html .= '</section><!-- ' . $row_layout . ' -->';
                } else {
                    $html .= '</div><!-- fc-layout-container -->';
                    $html .= '</section><!-- ' . $row_layout . ' -->';
                }
            }
        }

        switch ($row_layout) {
            case 'fc_carousel_open':
            case 'fc_wrapper_open':
                $skip_close = true;
                $skip_open = false;
                break;

            case 'fc_carousel_close':
            case 'fc_wrapper_close':
                $skip_close = false;
                $skip_open = true;
                break;

            default:
                $skip_close = false;
                $skip_open = false;
                break;
        }

        return array(
            'html' => $html,
            'is_full_width' => $full_width,
            'skip_open' => $skip_open,
            'skip_close' => $skip_close,
        );
    }

    public static function video_popup($string)
    {

        $pattern = '/(https?:\/\/)?(www\.)?(youtube\.com|youtu\.?be)\/.+$/';
        $pattern2 = '/(https?:\/\/)?(www\.)?(vimeo\.com)\/.+$/';

        if (preg_match($pattern, $string) || preg_match($pattern2, $string)) {
            return true;
        }

        return false;
    }
}
