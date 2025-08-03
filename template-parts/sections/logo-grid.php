<?php 
defined( 'ABSPATH' ) || exit; 
$layout = $args['layout'];
$logos = get_sub_field('logos'); ?>

<?php if ($logos): ?>
    <div class="<?php echo $layout . '__grid'; ?>">
        <?php foreach ($logos as $logo): ?>
            <div class="<?php echo $layout . '__grid-item'; ?>">
                <?php image($logo['id'], 'full', 'logo-grid__grid-item-image'); ?>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>