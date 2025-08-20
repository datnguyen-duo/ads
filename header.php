<?php
defined( 'ABSPATH' ) || exit;
$themeurl = get_template_directory_uri();

$logo = get_field('primary_logo', 'option');
$logo_secondary = get_field('secondary_logo', 'option');
$scripts = get_field('scripts', 'option');
$body_classes = "loading";
if (is_404()) {
	$body_classes .= " site-header-open";
}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<?php if ($scripts) {
		foreach ($scripts as $script) {
			if ($script['insert'] == 'head') {
				echo $script['script'];
			}
		}
	} ?>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>
<body <?php body_class($body_classes); ?>>
<?php wp_body_open(); ?>
<?php if ($scripts) {
	foreach ($scripts as $script) {
		if ($script['insert'] == 'body') {
			echo esc_html($script['script']);
		}
	}
} ?>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#main"><?php esc_html_e( 'Skip to content', 'theme' ); ?></a>
	<header id="masthead" class="site-header">

		<div class="site-header__navigation">
			<?php get_template_part( 'template-parts/header/navigation' ); ?>
			<div class="site-header__toggle">
				<div class="site-header__toggle-line"></div>
				<div class="site-header__toggle-line"></div>
			</div>
		</div>

	</header>
	<main id="main" class="site-main">