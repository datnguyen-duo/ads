<?php
defined('ABSPATH') || exit; ?>

<div class="posts__load-more post-list__pagination">
    <button class="button --ghost load-more-button" data-page="<?php echo $current_page + 1; ?>"><?php _e('Load More', 'text-domain'); ?></button>
</div>