<?php
defined( 'ABSPATH' ) || exit; 
?>
<nav id="footer-navigation" class="footer-navigation">
<?php
    wp_nav_menu(
        array(
            'theme_location' => 'footer',
            'menu_id'        => 'footer-menu',
            'container'      => false,
        )
    );
    ?>
</nav>