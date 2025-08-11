<?php
defined( 'ABSPATH' ) || exit;
$themeurl = get_template_directory_uri();
$scripts = get_field('scripts', 'option');
?>
	</main>
	<footer id="colophon" class="site-footer">
		<div class="site-footer__container page-container">
			<?php 
				get_template_part('template-parts/footer/site-info'); 
				get_template_part('template-parts/footer/navigation');
				get_template_part('template-parts/footer/bottom');
			?>
		</div>
	</footer>
</div>
<div id="video-modal" class="video-modal" role="dialog" aria-labelledby="video-modal-title" aria-hidden="true">
    <div class="video-modal__overlay"></div>
	<div class="video-modal__container">
		<div class="video-modal__header">
			<h2 id="video-modal-title" class="video-modal__title text__size-3"></h2>
		</div>
		<div class="video-modal__content">
			<div class="video-modal__iframe-container">
			</div>
		</div>
	</div>
	<button class="video-modal__close" aria-label="Close video modal">
		<svg width="24" height="24" viewBox="0 0 24 24" fill="none">
			<path d="M18 6L6 18M6 6L18 18" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
		</svg>
	</button>
</div>
<div class="noise"></div>
<?php wp_footer(); ?>
<?php if ($scripts) {
	foreach ($scripts as $script) {
		if ($script['insert'] == 'footer') {
			echo $script['script'];
		}
	}
} ?>
</body>
</html>