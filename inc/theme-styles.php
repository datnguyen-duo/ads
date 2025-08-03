<?php 
$primary_colors = get_field('primary_colors', 'option');
$secondary_colors = get_field('secondary_colors', 'option');
$neutral_colors = get_field('neutral_colors', 'option');
$announcement_bar_background_color = get_field('announcement_bar_background_color', 'option');
$announcement_bar_text_color = get_field('announcement_bar_text_color', 'option');
function generate_css($colors, $color_type, $css) {
  foreach ($colors as $key => $color) {
      $css .= '--color-' . $color_type . '-' . ($key + 1) . ': ' . $color['color'] . ';';
  }
  return $css;
}

function generate_font_face($font_field_name) {
  $font = get_field($font_field_name, 'option');
  if ($font['upload_type'] == 'local-file' && ($font['files'] || $font['url'])) {
      $font_face_src = array_map(function($file) {
          $url = $file['file']['url'];
          $file_subtype = $file['file']['subtype']; 
          
          $file_subtype = str_replace('font-', '', $file_subtype);
          
          $format = ($file_subtype == 'ttf') ? 'truetype' : $file_subtype;
          
          if (substr($url, 0, 5) === 'http:') {
              $url = 'https:' . substr($url, 5);
          }
          return 'url("' . $url . '") format("' . $format . '")';
      }, $font['files']);

      $font_face_src = implode(', ', $font_face_src);
      $font_family_name = $font['files'][0]['file']['title'];
?>
@font-face {
  font-family: "<?php echo $font_family_name; ?>";
  src: <?php echo $font_face_src; ?>;
  font-weight: <?php echo $font['font_weight']; ?>;
  font-style: <?php echo $font['font_style']; ?>;
  font-display: swap;
}
<?php 
  }
}

function process_font_and_append_css($css, $font_field_name, $css_var_name) {
  $font = get_field($font_field_name, 'option');
  if ($font['files'] || $font['url']) {
      if ($font['upload_type'] == 'local-file') {
          $font_family_name = $font['files'][0]['file']['title'];
          $font_family = '"' . $font_family_name . '", ' . $font['category'];
      } else { 
          $font_family = '"' . $font['font_family'] . '", ' . $font['category'];
      }
      $css .= "$css_var_name: $font_family;";
  }
  return $css;
}

generate_font_face('primary_font');
generate_font_face('secondary_font');

?>
:root {<?php 
    $css = '';
    $css = process_font_and_append_css($css, 'primary_font', '--font-primary');
    $css = process_font_and_append_css($css, 'secondary_font', '--font-secondary');
    $css = generate_css($primary_colors, 'primary', $css);
    $css = generate_css($secondary_colors, 'secondary', $css);
    $css = generate_css($neutral_colors, 'neutral', $css);
    $css .= '--color-light: var(--color-secondary-2);';
    $css .= '--color-dark: var(--color-secondary-1);';
    $css .= '--color-background: var(--color-light);';
    $css .= '--color-text: var(--color-dark);';
    $css .= '--color-overlay: rgba(255, 255, 255, 0.1);';
    $css .= '--color-overlay-dark: rgba(0, 0, 0, 0.5);';
    $css .= $announcement_bar_background_color ? '--color-announcement-bar-background: ' . $announcement_bar_background_color . ';' : '';
    $css .= $announcement_bar_text_color ? '--color-announcement-bar-text: ' . $announcement_bar_text_color . ';' : '';
    $css .= '--font-size-1: clamp(2.5rem, 5.4vw, 104px);';
    $css .= '--font-size-2: clamp(2.25rem, 5vw, 96px);';
    $css .= '--font-size-3: clamp(1.75rem, 1.875vw, 36px);';
    $css .= '--font-size-3--alt: clamp(1.75rem, 2.5vw, 48px);';
    $css .= '--font-size-4: clamp(1.125rem, 1.25vw, 24px);';
    $css .= '--font-size-5: 18px;';
    $css .= '--font-size-6: 1rem;';
    $css .= '--font-size-body-lg: clamp(1.4rem, 1.45vw, 28px);';
    $css .= '--font-size-body-md: clamp(1.2rem, 1.05vw, 20px);';
    $css .= '--font-size-body-sm: var(--font-size-6);';
    $css .= '--font-size-sm: 12px;';
    $css .= '--page-width: 1920px;';
    $css .= '--container-width: 1440px;';
    $css .= '--container-width-sm: 1000px;';
    $css .= '--content-width: 900px;';
    $css .= '--spacer: clamp(3rem, 6.667vw, 8rem);';
    $css .= '--spacer-sm: calc(var(--spacer) / 2);';
    $css .= '--spacer-lg: calc(var(--spacer) * 2);';
    $css .= '--spacer-xl: calc(var(--spacer) * 3);';
    $css .= '--gutter: clamp(1rem, 3vw, 52px);';
    $css .= '--gutter-sm: calc(var(--gutter) / 2);';
    $css .= '--gutter-lg: calc(var(--gutter) * 2);';
    $css .= '--gutter-xl: calc(var(--gutter) * 3);';
    $css .= '--gap: 2rem;';
    $css .= '--gap-xxs: calc(var(--gap) / 8);';
    $css .= '--gap-xs: calc(var(--gap) / 4);';
    $css .= '--gap-sm: calc(var(--gap) / 2);';
    $css .= '--gap-lg: calc(var(--gap) * 2);';
    $css .= '--border-radius: 9999em;';
    $css .= '--border-radius-sm: 10px;';
    $css .= '--box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25);';
    $css .= '--transition-ease-in-out: cubic-bezier(0.7, 0, 0.3, 1);';
    $css .= '--transition-duration: 0.2s;';
    $css .= '--transition-duration-long: .4s;';
    $css .= '--transition-duration-ease-in-out: var(--transition-duration) cubic-bezier(0.7, 0, 0.3, 1);';
    $css .= '--aspect-square: 1;';
    $css .= '--aspect-portrait: 4/5;';
    $css .= '--aspect-photo: 5/4;';
    $css .= '--aspect-fullscreen: 4/3;';
    $css .= '--aspect-film: 3/2;';
    $css .= '--aspect-video: 16/9;';
    $css .= '--aspect-ultrawide: 21/9;';
    echo trim($css);
    ?>}

// File generated by /inc/theme-styles.php
