<?php
defined( 'ABSPATH' ) || exit;
$logo = get_field('primary_logo', 'option') ? get_field('primary_logo', 'option')['ID'] : get_option('site_icon');
$logoSecondary = get_field('secondary_logo', 'option') ? get_field('secondary_logo', 'option')['ID'] : get_option('site_icon');
?>
<nav id="site-navigation" class="main-navigation container">
    <a href="<?php echo esc_url(home_url('/')); ?>" class="main-navigation__logo">
        <?php image($logo, 'full', $class = 'main-navigation__logo--primary', $alt = 'Logo', $loading = 'eager'); ?>
    </a>
    <?php
    wp_nav_menu(
        array(
            'theme_location' => 'primary',
            'menu_id'        => 'primary-menu',
            'container'      => false,
        )
    );
    ?>
</nav>