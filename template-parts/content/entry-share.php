<?php
defined( 'ABSPATH' ) || exit; 
?>
<div class="entry__share">
    <div class="entry__share-icons">
        <?php
        $socials = [
            'facebook' => 'https://www.facebook.com/sharer/sharer.php?u=',
            'x' => 'https://twitter.com/intent/tweet?url=',
            'linkedin' => 'https://www.linkedin.com/shareArticle?mini=true&url=',
        ];
        foreach($socials as $key => $value) {
            $url = $value . get_the_permalink();
            $target = '_blank';
            $class = 'entry__share-icon';
            $title = ucfirst($key); 
            $icon_function = 'icon_' . $key; 
            echo "<a href='$url' target='$target' class='$class' title='$title' aria-label='$title'>";
                if (function_exists($icon_function)) {
                    $icon_function();
                }
            echo "</a>";
        }
        ?>
    </div>
</div>