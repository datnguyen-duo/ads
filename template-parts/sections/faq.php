<?php 
defined( 'ABSPATH' ) || exit;
$layout = $args['layout'];
$groups = get_sub_field('groups');
?>
<div class="<?php echo $layout . '__container'; ?>">
    <div class="<?php echo $layout . '__tabs'; ?>">
        <?php foreach ($groups as $group): ?>
            <a href="#<?php echo sanitize_title($group['label']); ?>" class="<?php echo $layout . '__tab'; ?>">
                <div class="<?php echo $layout . '__tab-content'; ?>">
                    <span class="<?php echo $layout . '__tab-label text__size-body--md'; ?>"><?php echo $group['label']; ?></span>
                </div>
            </a>
        <?php endforeach; ?>
    </div>

    <div class="<?php echo $layout . '__groups'; ?>">
        <?php foreach ($groups as $group):
            $label = $group['label'];
            $items = $group['items']; ?>
            <div id="<?php echo sanitize_title($label); ?>" class="<?php echo $layout . '__group accordions__accordions'; ?>">
                <h3 class="<?php echo $layout . '__group-label text__size-3'; ?>"><?php echo $label; ?></h3>

                <?php foreach ($items as $item):
                    $title = $item['title'];
                    $text = $item['text'];
                    ?>
                    <div class="<?php echo $layout . '__group-item accordions__accordion'; ?>">
                        <div class="<?php echo $layout . '__group-item-header accordions__accordion-header'; ?>">
                            <h3 class="<?php echo $layout . '__group-item-title text__size-body--lg'; ?>"><?php echo $title; ?></h3>
                            <div class="<?php echo $layout . '__group-item-icon accordions__accordion-icon'; ?>">
                                <div class="<?php echo $layout . '__group-item-icon-line accordions__accordion-icon-line'; ?>"></div>
                                <div class="<?php echo $layout . '__group-item-icon-line accordions__accordion-icon-line'; ?>"></div>
                            </div>
                        </div>
                        <div class="<?php echo $layout . '__group-item-text accordions__accordion-text'; ?>">
                            <div class="<?php echo $layout . '__group-item-text-inner accordions__accordion-text-inner rte'; ?>">
                                <?php echo $text; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>
    </div>
</div>