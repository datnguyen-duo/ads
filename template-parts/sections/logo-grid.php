<?php 
defined( 'ABSPATH' ) || exit; 
$layout = $args['layout'];

// Check if logos are passed via $args (for global/reusable sections)
// Otherwise fall back to get_sub_field (for flexible content)
if (isset($args['logos'])) {
    $logos = $args['logos'];
} else {
    $logos = get_sub_field('logos');
}
?>
<?php if ($logos): ?>
    <div class="<?php echo $layout . '__grid'; ?>">
        <?php foreach ($logos as $logo): ?>
            <div class="<?php echo $layout . '__grid-item'; ?>">
                <?php image($logo['id'], 'full', 'logo-grid__grid-item-image'); ?>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>