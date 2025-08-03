<?php
defined( 'ABSPATH' ) || exit;
get_header();
?>

<section class="error-404 not-found">
	<header class="not-found__header">
		<h1 class="not-found__heading"><?php esc_html_e( 'Page not found.', 'anthonygustin' ); ?></h1>
		<p class="not-found__description text__size-3">Sorry, but the page you were looking for could not be found.</p>
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="not-found__cta button">Return to the homepage</a>
	</header>
</section>

<?php
get_footer();
