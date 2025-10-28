<?php
defined( 'ABSPATH' ) || exit;
$secondary_logo = get_field('secondary_logo', 'option');
$tagline = get_bloginfo('description');
$email = get_field('us_office', 'option')['email'];
$phone = get_field('us_office', 'option')['phone'];
$address = get_field('us_office', 'option')['address'];
?>
<div class="site-footer__content">
    <?php if ($secondary_logo): ?>
        <div class="site-footer__content-logo">
            <?php image($secondary_logo['id'], 'full', 'site-footer__content-logo-image'); ?>
        </div>
    <?php endif; ?>
    <?php if ($address): ?>
        <p class="site-footer__content-address text__size-5"><?php echo $address; ?></p>
    <?php endif; ?>

    <?php
        wp_nav_menu(
            array(
                'theme_location' => 'footer-buttons',
                'menu_id'        => 'footer-buttons-menu',
                'container'      => false,
            )
        );
    ?>
</div>