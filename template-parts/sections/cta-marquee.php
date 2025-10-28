<?php 
defined( 'ABSPATH' ) || exit; 
$layout = $args['layout'];

// Check if cta is passed via $args (for global/reusable sections)
// Otherwise fall back to get_sub_field (for flexible content)
if (isset($args['cta'])) {
    $cta = $args['cta'];
} else {
    $cta = get_sub_field('cta');
}
?>
<?php if ($cta): ?>
    <div class="<?php echo $layout . '__container'; ?>" data-marquee-container>
        <div class="<?php echo $layout . '__track'; ?>" data-marquee>
            <a class="<?php echo $layout . '__item marquee__item text__size-1'; ?>" href="<?php echo $cta['url']; ?>" target="<?php echo $cta['target']; ?>">
                <?php echo wp_kses_post(html_entity_decode($cta['title'])); ?>
            </a>
        </div>
    </div>
<?php endif; ?>