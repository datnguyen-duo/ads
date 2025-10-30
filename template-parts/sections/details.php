<?php 
defined( 'ABSPATH' ) || exit; 
$layout = $args['layout'];
$tabs = get_sub_field('tabs');
?>

<h2 class="<?php echo $layout . '__heading text__size-3'; ?>">Details</h2>

<?php if ($tabs):
    $single_tab = count($tabs) === 1;
    ?>
    <div class="<?php echo $layout . '__tabs'; ?>">
        <div class="<?php echo $layout . '__tabs-navigation'; ?><?php echo $single_tab ? ' --single-tab' : ''; ?>">
            <?php foreach ($tabs as $index => $tab):
                ?>
                <button 
                    class="<?php echo $layout . '__tab'; ?><?php echo $index === 0 ? ' active' : ''; ?>" 
                    data-tab="<?php echo $index; ?>"
                >
                    <?php echo esc_html($tab['title']); ?>
                </button>
            <?php endforeach; ?>
            <span class="<?php echo $layout . '__tab-indicator'; ?>"></span>
        </div>
        <div class="<?php echo $layout . '__tabs-content'; ?>">
            <?php foreach ($tabs as $index => $tab): ?>
                <div 
                    class="<?php echo $layout . '__tab-content show-more-container'; ?><?php echo $index === 0 ? ' active' : ''; ?>" 
                    data-tab-content="<?php echo $index; ?>"
                    data-content-height="400"
                >
                    <div class="<?php echo $layout . '__tab-text text__size-body--sm'; ?>">
                        <?php echo $tab['text']; ?>
                    </div>
                    <button class="show-more-button text__size-body--sm">
                        <span class="show-more-button-text">Show more</span> 
                        <span class="show-more-button-icon">
                            <?php icon_arrow('var(--color-light)'); ?>
                        </span>
                    </button>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
<?php endif; ?>
