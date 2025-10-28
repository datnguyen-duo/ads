<?php 
defined( 'ABSPATH' ) || exit; 
$layout = $args['layout'];
$items = get_sub_field('items');
?>
<div class="<?php echo $layout . '__container'; ?>">
    <div class="<?php echo $layout . '__tabs'; ?>" data-lenis-prevent>
        <?php foreach ($items as $key => $item): ?>
            <a href="#content" class="<?php echo $layout . '__tab'; ?><?php echo $key === 0 ? ' active' : ''; ?>">
                <div class="<?php echo $layout . '__tab-content'; ?>">
                    <span class="<?php echo $layout . '__tab-title text__size-3'; ?>"><?php echo $item['tab']['title']; ?></span>
                    <span class="<?php echo $layout . '__tab-label text__size-body--md'; ?>"><?php echo $item['tab']['label']; ?></span>
                </div>
            </a>
        <?php endforeach; ?>
    </div>
    <div class="<?php echo $layout . '__content'; ?>" id="content">
        <?php foreach ($items as $key => $item): ?>
            <div class="<?php echo $layout . '__content-item rte'; ?> <?php echo $key === 0 ? 'active' : ''; ?>"><?php echo $item['content']; ?></div>
        <?php endforeach; ?>
        <div class="<?php echo $layout . '__navigation'; ?>">
            <a href="#content" class="<?php echo $layout . '__navigation-button button__icon --prev'; ?>">
                <?php icon_arrow(); ?>
            </a>
            <a href="#content" class="<?php echo $layout . '__navigation-button button__icon --next'; ?>">
                <?php icon_arrow(); ?>
            </a>
        </div>
    </div>
</div>