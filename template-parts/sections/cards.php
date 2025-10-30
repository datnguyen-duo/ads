<?php 
defined( 'ABSPATH' ) || exit; 
$layout = $args['layout'];
$heading = get_sub_field('heading');
$cards = get_sub_field('cards');
?>
<div class="<?php echo $layout . '__container'; ?>">
    <?php if ($heading): ?>
        <h3 class="<?php echo $layout . '__heading text__size-body--lg'; ?>"><?php echo $heading; ?></h3>
    <?php endif; ?>
    <div class="<?php echo $layout . '__cards'; ?>">
        <?php foreach ($cards as $card): 
            $icon = $card['icon'];
            $title = $card['title'];
            $description = $card['description'];
            ?>
            <div class="<?php echo $layout . '__card'; ?>">
                <?php if ($icon): ?>
                    <?php image($icon['ID'], 'full', $layout . '__card-icon'); ?>
                <?php endif; ?>
                <?php if ($title): ?>
                    <h3 class="<?php echo $layout . '__card-title text__size-body--md text__body--bold'; ?>"><?php echo $title; ?></h3>
                <?php endif; ?>
                <?php if ($description): ?>
                    <p class="<?php echo $layout . '__card-description'; ?>"><?php echo $description; ?></p>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
</div>