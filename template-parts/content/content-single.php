<?php
defined( 'ABSPATH' ) || exit; 
$post_type = get_post_type();
$background_color = "var(--color-secondary-2);";
?>
<section class="entry">
	<div class="entry__container container">
		<?php 
			get_template_part( 'template-parts/content/entry', 'header' );
			get_template_part( 'template-parts/content/entry', 'content' );
		?>
		<div class="entry__footer">
			<?php 
				get_template_part( 'template-parts/content/entry', 'related' ); 
			?>
		</div>
	</div>
</section>