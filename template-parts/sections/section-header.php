<?php
defined( 'ABSPATH' ) || exit;
$layout = $args['layout'];
$pre_heading = $args['pre_heading'];
$heading = $args['heading'];
$description = $args['description'];
$cta = $args['cta'];
$variation = $args['variation'] ?? 'default';
?>
<div class="<?php echo $layout . '__header section-header'; ?>">
    <?php if ($pre_heading): ?>
        <p class="<?php echo $layout . '__pre-heading text__size-body--lg section-header__pre-heading'; ?>" <?php if ($layout !== 'hero') { echo 'data-animate-block'; } ?>><?php echo $pre_heading; ?></p>
    <?php endif; ?>
    <?php if ($heading): ?>
        <?php if ($layout == 'hero'): ?>
            <h1 class="<?php echo $layout . '__heading section-header__heading'; ?>" <?php if ($layout !== 'hero') { echo 'data-animate-words'; } ?>><?php echo $heading; ?></h1>
        <?php else: ?>
            <h2 class="<?php echo $layout . '__heading text__size-1 section-header__heading'; ?>" <?php if ($layout !== 'hero') { echo 'data-animate-words'; } ?>><?php echo $heading; ?></h2>
        <?php endif; ?>
    <?php endif; ?>
    <?php if ($description): ?>
        <p class="<?php echo $layout . '__description section-header__description text__size-body--lg'; ?>" <?php if ($layout !== 'hero') { echo 'data-animate-block'; } ?>><?php echo $description; ?></p>
    <?php endif; ?>
    <?php if (!empty($cta)): ?>
        <div class="<?php echo $layout . '__cta section-header__cta'; ?>" <?php if ($layout !== 'hero') { echo 'data-animate-block'; } ?>>
            <?php 
            foreach($cta as $key => $link) { 
                if (!empty($link['link']['url']) && !empty($link['link']['title'])) {
                    $url = $link['link']['url'];
                    $target = $link['link']['target'];
                    $title = $link['link']['title'];
                    $button_class = $key === 0 ? 'button--primary' : 'button--secondary';
                    echo "<div class='" . $layout . "__cta-link section-header__cta-link'>";
                        button($title, $url, $target, $button_class);
                    echo "</div>";
                } 
            }
            ?>
        </div>
    <?php endif; ?>
</div>