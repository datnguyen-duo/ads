<?php 
defined( 'ABSPATH' ) || exit; 
$layout = $args['layout'];
$variation = get_sub_field('variation');
$badges = get_sub_field('badges');
?>
<div class="<?php echo $layout . '__badges'; ?>">
    <?php foreach ($badges as $badge): 
        $title = $badge['title'];
        $source = $badge['source'];
        if ($variation == 'cards') {
            $image = $badge['image'];
            $description = $badge['description'];
        }
    ?>
        <?php if ($variation == 'cards'): ?>
        <div class="<?php echo $layout . '__card'; ?>">
        <?php endif; ?>
            <div class="<?php echo $layout . '__badge'; ?>">
                <div class="<?php echo $layout . '__badge-graphic'; ?>">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/trust-badges__graphic--left.png" alt="Trust Badge Graphic" loading="lazy">
                </div>
                <div class="<?php echo $layout . '__badge-content'; ?>">
                    <div class="<?php echo $layout . '__badge-title text__size-4'; ?>"><?php echo $title; ?></div>
                    <div class="<?php echo $layout . '__badge-source text__size-body--sm'; ?>"><?php echo $source; ?></div>
                </div>
                <div class="<?php echo $layout . '__badge-graphic'; ?>">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/trust-badges__graphic--right.png" alt="Trust Badge Graphic" loading="lazy">
                </div>
            </div>
        <?php if ($variation == 'cards'): ?>
            <div class="<?php echo $layout . '__card-content'; ?>">
                <?php if ($image): ?>
                    <?php image($image['ID'], 'full', $layout . '__card-image'); ?>
                <?php endif; ?>
                <?php if ($description): ?>
                    <p class="<?php echo $layout . '__card-description'; ?>"><?php echo $description; ?></p>
                <?php endif; ?>
            </div>
        </div>
        <?php endif; ?>
    <?php endforeach; ?>
</div>