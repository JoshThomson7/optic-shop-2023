<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <title><?php wp_title(' - ', true, 'right'); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="format-detection" content="telephone=no">
    <?php wp_head(); ?>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.3.0/dist/chart.umd.min.js"></script>
</head>

<body <?php body_class(); ?>>

    <?php
    global $post;
    include get_stylesheet_directory() . '/modules/mega-menu-mobile.php';
    ?>

    <div id="page">
        <header class="header">

            <?php if (get_field('sitewide_notice_enable', 'option')) : ?>
                <div class="header--site__wide__notice">
                    <div class="max__width">
                        <?php the_field('sitewide_notice', 'option'); ?>
                    </div>
                </div>
            <?php endif; ?>

            <div class="header__main">

                <div class="max__width">

                    <div class="header__main--left">
                        <a href="mailto:info@opticshop-aber.co.uk" class="social-nav">
                            <i class="fal fa-envelope"></i>
                            <span>Email</span>
                        </a>
                    </div><!-- left -->

                    <div class="header__main--centre">
                        <div class="logo">
                            <a href="<?php echo esc_url(home_url()); ?>" title="<?php bloginfo('name'); ?>">
                                <img src="<?php echo esc_url(get_stylesheet_directory_uri().'/img/optic-shop-logo.png'); ?>" alt="<?php bloginfo('name'); ?>"/>
                            </a>
                        </div><!-- logo -->

                        <?php include FL1_PATH . '/modules/mega-menu.php'; ?>

                        <a href="#nav_mobile" class="burger__menu">
                            <i class="fal fa-bars"></i>
                        </a>
                    </div>

                    <div class="header__main--right">
                        <a href="tel:01873855664" class="social-nav">
                            <i class="fal fa-phone"></i>
                            <span>Phone</span>
                        </a>
                    </div><!-- right -->

                </div><!-- max__width -->
            </div><!-- header__main -->

            <?php do_action('fc_tab_scroller', $post->ID); ?>
        </header><!-- header -->