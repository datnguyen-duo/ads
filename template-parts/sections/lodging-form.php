<?php
/**
 * Lodging Form - Reusable Component
 * 
 * Can be used in single.php or via global-section-reference
 */
defined('ABSPATH') || exit;

$layout = $args['layout'];
$data = $args['data'] ?? null;
$us_office = $args['us_office'] ?? get_field('us_office', 'option');
$tanzania_office = $args['tanzania_office'] ?? get_field('tanzania_office', 'option');

if (!$data) return;

// Extract office data
$us_office_address = $us_office['address'] ?? '';
$us_office_phone = $us_office['phone'] ?? '';
$us_office_hours = $us_office['hours'] ?? '';
$tanzania_office_address = $tanzania_office['address'] ?? '';
$tanzania_office_phone = $tanzania_office['phone'] ?? '';
$tanzania_office_hours = $tanzania_office['hours'] ?? '';

// Extract form data with defaults
$background_color = $data['background_color'] ?? 'var(--color-light)';
$text_color = $data['text_color'] ?? 'var(--color-dark)';
$combined_style = '--color-section-background: ' . $background_color . '; --color-section-text: ' . $text_color . ';';
$heading = $data['heading'] ?? 'More Questions?';
$description = $data['description'] ?? 'Reach out to one of our safari specialists who are ready and eager to help answer any inquiries.';
$form = $data['form'] ?? array();
$form_title = $form['title'] ?? 'Drop Us A Line';
$form_text = $form['text'] ?? 'Leave your contact info below';
?>

<div class="<?php echo $layout; ?>" style="<?php echo $combined_style; ?>" data-has-background-color>
    <div class="<?php echo $layout; ?>__container page-container">
        <div class="<?php echo $layout; ?>__content">
            <h2 class="<?php echo $layout; ?>__heading text__size-1" data-animate-words><?php echo $heading; ?></h2>
            <p class="<?php echo $layout; ?>__description text__size-body--lg" data-animate-block><?php echo $description; ?></p>
            <?php if ($us_office_phone): ?>
                <div class="<?php echo $layout; ?>__content-item">
                    <p class="<?php echo $layout; ?>__content-item-label text__body--bold">Toll-Free</p>
                    <p class="<?php echo $layout; ?>__content-item-text text__size-body--lg"><a href="tel:<?php echo $us_office_phone; ?>"><?php echo $us_office_phone; ?></a></p>
                </div>
            <?php endif; ?>
            <?php if ($us_office || $tanzania_office): ?>
                <div class="<?php echo $layout; ?>__content-grid">
                    <?php if ($us_office_address): ?>
                        <div class="<?php echo $layout; ?>__content-grid-item">
                            <p class="<?php echo $layout; ?>__content-grid-label text__body--bold">US Office</p>
                            <p class="<?php echo $layout; ?>__content-grid-item-text"><?php echo $us_office_address; ?></p>
                            <?php if ($us_office_hours): ?>
                                <p class="<?php echo $layout; ?>__content-grid-item-text">Hours: <?php echo $us_office_hours; ?></p>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                    <?php if ($tanzania_office_address): ?>
                        <div class="<?php echo $layout; ?>__content-grid-item">
                            <p class="<?php echo $layout; ?>__content-grid-label text__body--bold">Tanzania Office</p>
                            <p class="<?php echo $layout; ?>__content-grid-item-text"><?php echo $tanzania_office_address; ?></p>
                            <?php if ($tanzania_office_phone): ?>
                                <p class="<?php echo $layout; ?>__content-grid-item-text"><a href="tel:<?php echo $tanzania_office_phone; ?>"><?php echo $tanzania_office_phone; ?></a></p>
                            <?php endif; ?>
                            <?php if ($tanzania_office_hours): ?>
                                <p class="<?php echo $layout; ?>__content-grid-item-text">Hours: <?php echo $tanzania_office_hours; ?></p>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
        <div class="<?php echo $layout; ?>__form-wrapper">
            <h3 class="<?php echo $layout; ?>__form-wrapper-title text__size-3" data-animate-words><?php echo $form_title; ?></h3>
            <p class="<?php echo $layout; ?>__form-wrapper-text" data-animate-block><?php echo $form_text; ?></p>
            <form action="#" method="post" class="<?php echo $layout; ?>__form form" data-animate-block>
                <div class="<?php echo $layout; ?>__form-fields">
                    <div class="<?php echo $layout; ?>__form-field">
                        <label for="name">Name</label>
                        <input type="text" id="name" name="name" required placeholder="Your Name">
                    </div>
                    <div class="<?php echo $layout; ?>__form-field">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" required placeholder="Your Email">
                    </div>
                    <div class="<?php echo $layout; ?>__form-field">
                        <label for="message">Message</label>
                        <textarea id="message" name="message" required placeholder="Your Message" rows="4"></textarea>
                    </div>
                    <button type="submit" class="<?php echo $layout; ?>__form-button button button--primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

