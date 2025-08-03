<?php
defined( 'ABSPATH' ) || exit;
get_header();
$post_type = get_post_type();
get_template_part("template-parts/content/content", "single");
get_footer(); 
?>