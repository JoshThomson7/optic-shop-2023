<div class="book-apt-footer">
    <div class="max__width">
        <a href="mailto:info@opticshop-aber.co.uk" target="_blank">Book an Appointment</a>
    </div>
</div>

<footer class="footer" role="contentinfo">

    <div class="max__width">

        <div class="footer-cols">

            <?php
            while (have_rows('footer_menus', 'options')) : the_row();

                $footer_menu = get_sub_field('footer_menu');
                $footer_menu_2 = get_sub_field('footer_menu_2');
            ?>
                <div class="footer-col">

                    <?php if ($footer_menu) : ?>
                        <div class="footer-menu">
                            <div class="footer-menu__heading">
                                <h5><?php echo $footer_menu->name; ?></h5>
                                <span class="menu-dropdown"><i class="fas fa-chevron-down"></i></span>
                            </div>
                            <div class="footer-menu__items">
                                <?php wp_nav_menu(array('menu' => $footer_menu->name, 'container' => false)); ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if ($footer_menu_2) : ?>
                        <div class="footer-menu footer-menu--2">
                            <div class="footer-menu__heading">
                                <h5><?php echo $footer_menu_2->name; ?></h5>
                                <span class="menu-dropdown"><i class="fas fa-chevron-down"></i></span>
                            </div>
                            <div class="footer-menu__items">
                                <?php wp_nav_menu(array('menu' => $footer_menu_2->name, 'container' => false)); ?>
                            </div>
                        </div>
                    <?php endif; ?>

                </div>

            <?php endwhile; ?>

            <div class="footer-col footer-col--main">
                <div class="footer-menu footer-menu--company">

                    <div class="footer-menu__heading">
                        <h5>Connect</h5>
                    </div>

                    <ul>
                        <li class="social">
                            <a href="https://www.facebook.com/opticshopabergavenny" target="_blank"><i class="fa-brands fa-facebook-f"></i></a>
                            <a href="https://www.instagram.com/opticshopabergavenny/" target="_blank"><i class="fa-brands fa-instagram"></i></a>
                            <a href="https://twitter.com/theopticshopa" target="_blank"><i class="fa-brands fa-twitter"></i></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="footer-legal">
            <?php wp_nav_menu(array('menu' => 'Legal', 'container' => false)); ?>
        </div>

        <div class="subfooter">
            <div class="subfooter--left">
                <small>&copy;<?php date('Y'); ?> <?php bloginfo('name') ?>. All Rights Reserved.<br></small>
            </div><!-- subfooter--left -->

            <div class="subfooter--right">
                <small><a href="https://thomson-website-solutions.com/" target="_blank">Website by Thomson Website Solutions</a></small>
            </div><!-- subfooter--left -->
        </div><!-- subfooter -->
</footer>

</div><!-- #page -->

<?php wp_footer(); ?>
<script async type="text/javascript" src="https://static.klaviyo.com/onsite/js/klaviyo.js?company_id=RcRgdD"></script>
</body>

</html>