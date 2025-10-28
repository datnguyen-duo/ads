<?php
defined( 'ABSPATH' ) || exit; 
$us_office = get_field('us_office', 'option');
if ($us_office):
	$us_office_address = $us_office['address'] ? $us_office['address'] : '';
	$us_office_phone = $us_office['phone'] ? $us_office['phone'] : '';
	$us_office_email = $us_office['email'] ? $us_office['email'] : '';
	$us_office_hours = $us_office['hours'] ? $us_office['hours'] : '';
endif;
$tanzania_office = get_field('tanzania_office', 'option');
if ($tanzania_office):
	$tanzania_office_address = $tanzania_office['address'] ? $tanzania_office['address'] : '';
	$tanzania_office_phone = $tanzania_office['phone'] ? $tanzania_office['phone'] : '';
	$tanzania_office_email = $tanzania_office['email'] ? $tanzania_office['email'] : '';
	$tanzania_office_hours = $tanzania_office['hours'] ? $tanzania_office['hours'] : '';
endif;
$lodging_cta = get_field('lodging_cta', 'option');
$lodging_form = get_field('lodging_form', 'option');
?>
<article class="entry">
	<?php 
		get_template_part( 'template-parts/content/entry', 'header' ); 
		get_template_part( 'template-parts/content/entry', 'content' );
		
		// Display global lodging CTA if it exists
		if ($lodging_cta): 
			$background_color = $lodging_cta['background_color'] ?? 'var(--color-primary-1)';
			$text_color = $lodging_cta['text_color'] ?? 'var(--color-light)';
			$combined_style = '--color-section-background: ' . $background_color . '; --color-section-text: ' . $text_color . ';';
			?>
			<div class="entry__cta cta" style="<?php echo $combined_style; ?>" data-has-background-color>
				<div class="page-container">
					<?php 
					get_template_part('template-parts/sections/cta', null, array(
						'layout' => 'cta',
						'data' => $lodging_cta
					)); 
					?>
				</div>
			</div>
		<?php endif; 
		
		// Display global lodging form if it exists
		if ($lodging_form):
			$background_color = $lodging_form['background_color'] ? $lodging_form['background_color'] : 'var(--color-light)';
			$text_color = $lodging_form['text_color'] ? $lodging_form['text_color'] : 'var(--color-dark)';
			$combined_style = '--color-section-background: ' . $background_color . '; --color-section-text: ' . $text_color . ';';
			$heading = $lodging_form['heading'] ? $lodging_form['heading'] : 'More Questions?';
			$description = $lodging_form['description'] ? $lodging_form['description'] : 'Reach out to one of our safari specialists who are ready and eager to help answer any inquiries.';
			$form = $lodging_form['form'];
			$form_title = $form['title'] ? $form['title'] : 'Drop Us A Line';
			$form_text = $form['text'] ? $form['text'] : 'Leave your contact info below';
			?>
			<div class="entry__inquiry" style="<?php echo $combined_style; ?>" data-has-background-color>
				<div class="entry__inquiry-container page-container">
					<div class="entry__inquiry-content">
						<h2 class="entry__inquiry-heading text__size-1" data-animate-words><?php echo $heading; ?></h2>
						<p class="entry__inquiry-description text__size-body--lg" data-animate-block><?php echo $description; ?></p>
						<?php if ($us_office_phone): ?>
							<div class="entry__inquiry-content-item">
								<p class="entry__inquiry-content-item-label text__body--bold">Toll-Free</p>
								<p class="entry__inquiry-content-item-text text__size-body--lg"><a href="tel:<?php echo $us_office_phone; ?>"><?php echo $us_office_phone; ?></a></p>
							</div>
						<?php endif; ?>
						<?php if ($us_office || $tanzania_office): ?>
							<div class="entry__inquiry-content-grid">
								<?php if ($us_office_address): ?>
									<div class="entry__inquiry-content-grid-item">
										<p class="entry__inquiry-content-grid-label text__body--bold">US Office</p>
										<p class="entry__inquiry-content-grid-item-text"><?php echo $us_office_address; ?></p>
										<?php if ($us_office_hours): ?>
											<p class="entry__inquiry-content-grid-item-text">Hours: <?php echo $us_office_hours; ?></p>
										<?php endif; ?>
									</div>
								<?php endif; ?>
								<?php if ($tanzania_office_address): ?>
									<div class="entry__inquiry-content-grid-item">
										<p class="entry__inquiry-content-grid-label text__body--bold">Tanzania Office</p>
										<p class="entry__inquiry-content-grid-item-text"><?php echo $tanzania_office_address; ?></p>
										<?php if ($tanzania_office_phone): ?>
											<p class="entry__inquiry-content-grid-item-text"><a href="tel:<?php echo $tanzania_office_phone; ?>"><?php echo $tanzania_office_phone; ?></a></p>
										<?php endif; ?>
										<?php if ($tanzania_office_hours): ?>
											<p class="entry__inquiry-content-grid-item-text">Hours: <?php echo $tanzania_office_hours; ?></p>
										<?php endif; ?>
									</div>
								<?php endif; ?>
							</div>
						<?php endif; ?>

					</div>
					<div class="entry__inquiry-wrapper">
						<h3 class="entry__inquiry-wrapper-title text__size-3" data-animate-words><?php echo $form_title; ?></h3>
						<p class="entry__inquiry-wrapper-text" data-animate-block><?php echo $form_text; ?></p>
						<form action="#" method="post" class="entry__inquiry-form form" data-animate-block>
							<div class="entry__inquiry-form-fields">
								<div class="entry__inquiry-form-field">
									<label for="name">Name</label>
									<input type="text" id="name" name="name" required placeholder="Your Name">
								</div>
								<div class="entry__inquiry-form-field">
									<label for="email">Email</label>
									<input type="email" id="email" name="email" required placeholder="Your Email">
								</div>
								<div class="entry__inquiry-form-field">
									<label for="message">Message</label>
									<textarea id="message" name="message" required placeholder="Your Message" rows="4"></textarea>
								</div>
								<button type="submit" class="entry__inquiry-form-button button button--primary">Submit</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		<?php endif; ?>
</article>