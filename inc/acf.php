<?php 
function acf_generate_options_css($post_id) {
    if ($post_id !== 'options') {
        return;
    }
    $ss_dir = get_stylesheet_directory();
    ob_start(); 
    require($ss_dir . '/inc/theme-styles.php');
    $css = ob_get_clean(); 
    file_put_contents($ss_dir . '/theme-variables.css', $css, LOCK_EX);
}
add_action( 'acf/save_post', 'acf_generate_options_css', 20 );

function acf_input_admin_footer() {
	$primary_colors = get_field('primary_colors', 'option');
	$secondary_colors = get_field('secondary_colors', 'option');
    $neutral_colors = get_field('neutral_colors', 'option');
    $colors = array_merge($primary_colors, $secondary_colors, $neutral_colors);
    $palette = [];
    foreach ($colors as $color) {
        if (is_array($color)) {
            $palette[] = $color['color'];
        } else {
            $palette[] = $color;
        }
    }
	?>
	<script type="text/javascript">
		(function($) {
			acf.add_filter('color_picker_args', function( args, $field ){
                args.palettes = ['<?php echo implode("', '", $palette); ?>'];
				return args;
			});
		})(jQuery);
	</script>
	<?php
}
add_action('acf/input/admin_footer', 'acf_input_admin_footer');
?>