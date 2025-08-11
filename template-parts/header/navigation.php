<?php
defined( 'ABSPATH' ) || exit;
$logo = get_field('primary_logo', 'option') ? get_field('primary_logo', 'option')['ID'] : get_option('site_icon');
$logoSecondary = get_field('secondary_logo', 'option') ? get_field('secondary_logo', 'option')['ID'] : get_option('site_icon');
?>
<nav id="site-navigation" class="main-navigation">
    <div class="main-navigation__top">
        <div class="main-navigation__top-container page-container">
            <div class="main-navigation__secondary-menu">
                <?php
                    wp_nav_menu(
                        array(
                            'theme_location' => 'secondary',
                            'menu_id'        => 'secondary-menu',
                            'container'      => false,
                        )
                    );
                ?>
            </div>

            <div class="main-navigation__search">
                <div class="main-navigation__search-toggle">
                    <p class="text__size-body--sm main-navigation__search-toggle-text">Search</p>
                    <?php icon_search('currentColor', '1.5'); ?>
                </div>
                <form action="<?php echo esc_url(home_url('/search')); ?>" method="get">
                    <input class="main-navigation__search-input" type="text" name="q" placeholder="What are you looking for?">
                    <button class="main-navigation__search-button" type="submit">
                        <?php icon_search('currentColor', '1.5'); ?>
                    </button>
                    <button class="main-navigation__search-close" type="button">
                        <?php icon_close('currentColor', '1.5'); ?>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="main-navigation__bottom">
        <div class="main-navigation__bottom-container page-container">
            <a href="<?php echo esc_url(home_url('/')); ?>" class="main-navigation__logo">
                <?php image($logo, 'full', $class = 'main-navigation__logo-image --primary', $alt = 'Logo', $loading = 'eager'); ?>
                <?php image($logoSecondary, 'full', $class = 'main-navigation__logo-image --secondary', $alt = 'Logo', $loading = 'eager'); ?>
            </a>

            <div class="main-navigation__primary-menu">
                <?php
                wp_nav_menu(
                    array(
                        'theme_location' => 'primary',
                        'menu_id'        => 'primary-menu',
                        'container'      => false,
                    )
                );
                ?>
            </div>

            <div class="main-navigation__header-buttons">
                <?php
                wp_nav_menu(
                array(
                    'theme_location' => 'header-buttons',
                    'menu_id'        => 'header-buttons',
                    'container'      => false,
                    )
                );
                ?>
            </div>
        </div>
    </div>
</nav>