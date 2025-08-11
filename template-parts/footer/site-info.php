<?php
defined( 'ABSPATH' ) || exit;
$secondary_logo = get_field('secondary_logo', 'option');
$tagline = get_bloginfo('description');
$email = get_field('email', 'option');
$phone = get_field('phone', 'option');
$address = get_field('address', 'option');
?>
<div class="site-footer__content">
    <?php if ($secondary_logo): ?>
        <div class="site-footer__content-logo">
            <?php image($secondary_logo['id'], 'full', 'site-footer__content-logo-image'); ?>
        </div>
    <?php endif; ?>
    <?php if ($email): ?>
        <a href="mailto:<?php echo $email; ?>" class="site-footer__content-email text__size-5"><?php echo $email; ?></a>
    <?php endif; ?>
    <?php if ($phone): ?>
        <a href="tel:<?php echo $phone; ?>" class="site-footer__content-phone text__size-5"><?php echo $phone; ?></a>
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