<?php
defined( 'ABSPATH' ) || exit;
$themeurl = get_template_directory_uri();
$show_announcement_bar = get_field('show_announcement_bar', 'option');
$announcement_bar_background_color = get_field('announcement_bar_background_color', 'option');
$announcement_bar_text_color = get_field('announcement_bar_text_color', 'option');
$logo = get_field('primary_logo', 'option');
$logo_secondary = get_field('secondary_logo', 'option');
$scripts = get_field('scripts', 'option');
$body_classes = "loading";
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
	<link rel="profile" href="https:
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
<div id="page" class=" site">
	<a class="skip-link screen-reader-text" href="#main"><?php esc_html_e( 'Skip to content', 'theme' ); ?></a>
    <header>
      <div class="container">
        <div class="navbar">
          <a name="main"></a>
          <div class="navbar-header">
            <button
              type="button"
              class="navbar-toggle"
              data-toggle="collapse"
              data-target=".navbar-collapse"
            >
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/#main"
              ><img src="<?php echo $logo['url']; ?>" alt="<?php echo $logo['alt']; ?>"
            /></a>
            <a href="/" style="display: none"
              ><img
                src="<?php echo $logo_secondary['url']; ?>"
                width="155"
                alt="Africa Dream Safaris"
            /></a>
          </div>
          <ul class="nav navbar-nav navbar-right navbar-buttons">
            <li>
              <a class="btn-contact-us" href="/contact"
                ><span>Contact Us</span><i class="fa fa-caret-right"></i
              ></a>
            </li>
            <li>
              <a
                class="btn-create-your-own"
                href="/create-your-own-itinerary"
                ><span>Choose Your<br />Safari</span
                ><i class="fa fa-caret-right"></i
              ></a>
            </li>
          </ul>
          <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav" id="navbar-tablet">
              <li>
                <a
                  class="nav-has-submenu"
                  data-submenu-name="about"
                  href="/company-overview/letter-from-the-founder"
                  >About</a
                >
              </li>
              <li><a href="/guest-reviews">Guest Reviews</a></li>
              <li>
                <a
                  class="nav-has-submenu"
                  data-submenu-name="regions"
                  href="/maps/tanzania"
                  >Regions</a
                >
              </li>
              <li>
                <a
                  class="nav-has-submenu"
                  data-submenu-name="lodging"
                  href="/lodging"
                  >Lodging</a
                >
              </li>
              <li><a href="/media/videos">Galleries</a></li>
              <li>
                <a
                  class=""
                  href="http:
                  target="_blank"
                  >Blog</a
                >
              </li>
              <li class="navbar-link-secondary">
                <a class="" href="/awards-and-press">Awards</a>
              </li>
              <li class="navbar-link-secondary">
                <a
                  data-submenu-name="local-partnerships"
                  class="nav-has-submenu"
                  href="/community"
                  >Local Partnerships</a
                >
              </li>
              <li class="navbar-link-secondary">
                <a class="" href="/faq">FAQ</a>
              </li>
              <li class="navbar-link-secondary">
                <a class="" href="/maps/tanzania">Maps</a>
              </li>
              <li class="navbar-link-secondary">
                <a href="/safari-details/photographic-ambassador"
                  >Expert Photo Tips</a
                >
              </li>
              <li class="navbar-link-secondary" id="navbar-link-search-form">
                <form
                  action="/search"
                  method="get"
                >
                  <div class="search-input-container">
                    <input type="text" name="q" placeholder="Search" />
                  </div>
                  <button type="submit" class="search-input-icon">
                    <svg viewBox="0 0 15.8 15.8">
                      <use
                        xmlns:xlink="http:
                        xlink:href="#icon-search"
                      ></use>
                    </svg>
                  </button>
                </form>
              </li>
            </ul>
            <ul class="nav navbar-nav" id="navbar-primary">
              <li class="dropdown dropdown-about">
                <a href="/company-overview/letter-from-the-founder"
                  ><span class="valign-wrap">About</span></a
                >
                <div class="dropdown-menu">
                  <ul class="list-unstyled">
                    <li class="menu-section first">
                      <ul class="list-unstyled">
                        <li class="first"><a>Company Overview</a></li>
                        <li>
                          <a
                            href="/company-overview/letter-from-the-founder"
                            >Letter from the Founder</a
                          >
                        </li>
                        <li>
                          <a href="/company-overview/why-were-different"
                            >Why We're Different</a
                          >
                        </li>
                        <li>
                          <a href="/company-overview/tanzania-specialists"
                            >We Specialize in Tanzania</a
                          >
                        </li>
                        <li>
                          <a
                            href="/company-overview/meet-our-safari-experts"
                            >Meet Our Safari Experts</a
                          >
                        </li>
                        <li>
                          <a
                            href="/company-overview/private-safari-advantage"
                            >Private Safari Advantage</a
                          >
                        </li>
                        <li>
                          <a
                            href="/company-overview/personalized-itineraries"
                            >Personalized Itineraries</a
                          >
                        </li>
                        <li>
                          <a
                            href="/company-overview/wildlife-viewing-maximized"
                            >Wildlife Viewing Maximized</a
                          >
                        </li>
                      </ul>
                    </li>
                    <li class="menu-section">
                      <ul class="list-unstyled">
                        <li class="first"><a>Safari Details</a></li>
                        <li>
                          <a href="/safari-details/driver-guides"
                            >Driver Guides</a
                          >
                        </li>
                        <li>
                          <a href="/safari-details/vehicle-specifications"
                            >Vehicle Specifications</a
                          >
                        </li>
                        <li>
                          <a href="/safari-details/seasonal-highlights"
                            >Seasonal Highlights</a
                          >
                        </li>
                        <li>
                          <a
                            href="/safari-details/inclusions-and-exclusions"
                            >Inclusions & Exclusions</a
                          >
                        </li>
                        <li>
                          <a
                            href="/safari-details/itinerary-design-and-recommendations"
                            >Itinerary Design & Recommendations
                          </a>
                        </li>
                        <li>
                          <a href="/safari-details/safety">Safari Safety</a>
                        </li>
                        <li>
                          <a href="/safari-details/photographic-ambassador"
                            >Our Photographic Ambassador</a
                          >
                        </li>
                      </ul>
                    </li>
                    <li class="menu-section">
                      <ul class="list-unstyled">
                        <li class="first"><a>Trip Enhancements</a></li>
                        <li>
                          <a href="/trip-enhancements/cultural-tour"
                            >Cultural Tour</a
                          >
                        </li>
                        <li>
                          <a href="/trip-enhancements/balloon-safari"
                            >Balloon Safari</a
                          >
                        </li>
                        <li>
                          <a href="/trip-enhancements/arusha-layover"
                            >Arusha Layover</a
                          >
                        </li>
                        <li>
                          <a href="/trip-enhancements/walking-safari"
                            >Walking Safari</a
                          >
                        </li>
                        <li>
                          <a href="/trip-enhancements/night-game-drive"
                            >Night Game Drive</a
                          >
                        </li>
                        <li>
                          <a
                            href="/trip-enhancements/junior-game-ranger-challenge"
                            >Junior Game Ranger</a
                          >
                        </li>
                        <li>
                          <a href="/trip-enhancements/charitable-visits"
                            >Charitable Visits</a
                          >
                        </li>
                        <li>
                          <a
                            href="/trip-enhancements/serengeti-lion-project"
                            >Serengeti Lion Project</a
                          >
                        </li>
                      </ul>
                    </li>
                    <li class="menu-section">
                      <ul class="list-unstyled">
                        <li class="first"><a>Booking And Flights</a></li>
                        <li>
                          <a href="/booking-and-flights/booking-security"
                            >Booking Security</a
                          >
                        </li>
                        <li>
                          <a
                            href="/booking-and-flights/flexible-travel-and-payment"
                            >Flexible Travel & Payment</a
                          >
                        </li>
                        <li>
                          <a
                            href="/booking-and-flights/booking-terms-and-conditions"
                            >Booking Terms & Conditions</a
                          >
                        </li>
                        <li>
                          <a
                            href="/booking-and-flights/international-flight-routing"
                            >International Flight Routing</a
                          >
                        </li>
                      </ul>
                    </li>
                  </ul>
                </div>
              </li>
              <li class="dropdown dropdown-image-blocks">
                <a href="/guest-reviews"
                  ><span class="valign-wrap">Guest<br />Reviews</span></a
                >
                <div class="dropdown-menu">
                  <ul class="list-unstyled">
                    <li class="menu-section first">
                      <a href="/guest-reviews#family-vacations">
                        <span class="menu-img"
                          ><img
                            src="<?php echo $themeurl; ?>/assets/archive/guestreviews-familyvacations-thumb.jpg"
                        /></span>
                        <span class="menu-text">Family Vacations</span>
                      </a>
                    </li>
                    <li class="menu-section">
                      <a href="/guest-reviews#romantic-getaways">
                        <span class="menu-img"
                          ><img
                            src="<?php echo $themeurl; ?>/assets/archive/guestreviews-romanticgetaways-thumb.jpg"
                        /></span>
                        <span class="menu-text">Romantic Getaways</span>
                      </a>
                    </li>
                    <li class="menu-section">
                      <a href="/guest-reviews#photo-safaris">
                        <span class="menu-img"
                          ><img
                            src="<?php echo $themeurl; ?>/assets/archive/guestreviews-photosafaris-thumb.jpg"
                        /></span>
                        <span class="menu-text">Photo Safaris</span>
                      </a>
                    </li>
                    <li class="menu-section">
                      <a href="/guest-reviews#bucket-list">
                        <span class="menu-img"
                          ><img
                            src="<?php echo $themeurl; ?>/assets/archive/guestreviews-bucketlist-thumb.jpg"
                        /></span>
                        <span class="menu-text">Bucket List</span>
                      </a>
                    </li>
                  </ul>
                </div>
              </li>
              <li class="dropdown" id="menu-dropdown-regions">
                <a href="/maps/tanzania"
                  ><span class="valign-wrap">Regions</span></a
                >
                <div class="dropdown-menu">
                  <div class="dropdown-menu-callout">
                    <h1>Select a region or sub-region to learn more.</h1>
                    <h2>- OR -</h2>
                    <a class="dropdown-callout-map" href="/maps/tanzania"
                      ><img
                        src="<?php echo $themeurl; ?>/assets/archive/scale-map-tanzania.gif"
                    /></a>
                    <a class="btn btn-primary" href="/maps/tanzania"
                      >Search by Map <i class="fa fa-chevron-right"></i
                    ></a>
                  </div>
                  <div class="dropdown-list-container">
                    <div class="dropdown-list-group">
                      <ul>
                        <li class="dropdown-region-header">
                          <a href="/serengeti-national-park"
                            >Serengeti
                            <span class="extended-region-name"
                              >National Park</span
                            ></a
                          >
                        </li>
                        <li class="dropdown-region-subheader">
                          <a href="/north-serengeti">North Serengeti</a>
                        </li>
                        <li class="dropdown-link-group">
                          <ul>
                            <li><a href="/lobo-valley">Lobo Valley</a></li>
                            <li>
                              <a href="/upper-grumeti-woodlands"
                                >Upper Grumeti Woodlands</a
                              >
                            </li>
                            <li><a href="/mara-river">Mara River</a></li>
                            <li>
                              <a href="/lamai-triangle">Lamai Triangle</a>
                            </li>
                            <li><a href="/wogakuria">Wogakuria</a></li>
                            <li>
                              <a href="/bologonja-springs"
                                >Bologonja Springs</a
                              >
                            </li>
                          </ul>
                        </li>
                        <li class="dropdown-region-subheader">
                          <a href="/west-serengeti">West Serengeti</a>
                        </li>
                        <li class="dropdown-link-group">
                          <ul>
                            <li>
                              <a href="/ruwana-plains">Ruwana Plains</a>
                            </li>
                            <li>
                              <a href="/lower-grumeti-woodlands"
                                >Lower Grumeti Woodlands</a
                              >
                            </li>
                            <li>
                              <a href="/mbalageti-river-valley"
                                >Mbalageti River Valley</a
                              >
                            </li>
                            <li>
                              <a href="/musabi-plains">Musabi Plains</a>
                            </li>
                          </ul>
                        </li>
                        <li class="dropdown-region-subheader">
                          <a href="/east-serengeti">East Serengeti</a>
                        </li>
                        <li class="dropdown-link-group">
                          <ul>
                            <li>
                              <a href="/sametu-marsh-and-kopjes"
                                >Sametu Marsh and Kopjes</a
                              >
                            </li>
                            <li><a href="/naabi-hill">Naabi Hill</a></li>
                            <li><a href="/gol-kopjes">Gol Kopjes</a></li>
                            <li>
                              <a href="/barfafu-gorge-and-kopjes"
                                >Barfafu Gorge and Kopjes</a
                              >
                            </li>
                            <li>
                              <a href="/lemuta-hill-and-waterhole"
                                >Lemuta Hill and Waterhole</a
                              >
                            </li>
                            <li><a href="/lake-natron">Lake Natron</a></li>
                          </ul>
                        </li>
                      </ul>
                    </div>
                    <div class="dropdown-list-group">
                      <ul>
                        <li class="dropdown-region-subheader">
                          <a href="/south-serengeti">South Serengeti</a>
                        </li>
                        <li class="dropdown-link-group">
                          <ul>
                            <li>
                              <a href="/the-triangle">The Triangle</a>
                            </li>
                            <li>
                              <a href="/hidden-valley">Hidden Valley</a>
                            </li>
                            <li><a href="/lake-ndutu">Lake Ndutu</a></li>
                            <li>
                              <a href="/kusini-plains">Kusini Plains</a>
                            </li>
                            <li>
                              <a href="/olduvai-gorge">Olduvai Gorge</a>
                            </li>
                            <li>
                              <a href="/matiti-plains">Matiti Plains</a>
                            </li>
                          </ul>
                        </li>
                        <li class="dropdown-region-subheader">
                          <a href="/central-serengeti">Central Serengeti</a>
                        </li>
                        <li class="dropdown-link-group">
                          <ul>
                            <li>
                              <a href="/seronera-valley">Seronera Valley</a>
                            </li>
                            <li>
                              <a href="/seronera-river">Seronera River</a>
                            </li>
                            <li><a href="/retina-pool">Retina Pool</a></li>
                            <li><a href="/moru-kopjes">Moru Kopjes</a></li>
                            <li>
                              <a href="/maasai-kopjes">Maasai Kopjes</a>
                            </li>
                            <li><a href="/makoma-hill">Makoma Hill</a></li>
                            <li>
                              <a href="/turners-spring">Turners Spring</a>
                            </li>
                            <li>
                              <a href="/simba-kopjes">Simba Kopjes</a>
                            </li>
                            <li>
                              <a href="/long-grass-plains"
                                >Long Grass Plains</a
                              >
                            </li>
                          </ul>
                        </li>
                      </ul>
                    </div>
                    <div class="dropdown-list-group">
                      <ul>
                        <li class="dropdown-region-header">
                          <a href="/lake-manyara"
                            >Lake Manyara
                            <span class="extended-region-name"
                              >National Park</span
                            ></a
                          >
                        </li>
                        <li class="dropdown-link-group">
                          <ul>
                            <li>
                              <a href="/ground-water-forest"
                                >Ground Water Forest</a
                              >
                            </li>
                            <li>
                              <a href="/acacia-woodlands"
                                >Acacia Woodlands</a
                              >
                            </li>
                            <li><a href="/floodplains">Floodplains</a></li>
                            <li>
                              <a href="/lake-manyara">Lake Manyara</a>
                            </li>
                          </ul>
                        </li>
                        <li
                          class="dropdown-region-header dropdown-region-header-lined"
                        >
                          <a href="/ngorongoro-conservation-area"
                            >Ngorongoro
                            <span class="extended-region-name"
                              >Conservation Area</span
                            ></a
                          >
                        </li>
                        <li class="dropdown-link-group">
                          <ul>
                            <li><a href="/lake-magadi">Lake Magadi</a></li>
                            <li>
                              <a href="/central-plains">Central Plains</a>
                            </li>
                            <li>
                              <a href="/lerai-forest">Lerai Forest</a>
                            </li>
                            <li><a href="/rumbe-hills">Rumbe Hills</a></li>
                            <li>
                              <a href="/munge-stream">Munge Stream</a>
                            </li>
                            <li>
                              <a href="/mandusi-swamp">Mandusi Swamp</a>
                            </li>
                            <li>
                              <a href="/gorigor-swamp">Gorigor Swamp</a>
                            </li>
                            <li>
                              <a href="/ngoitokitok-springs"
                                >Ngoitokitok Springs</a
                              >
                            </li>
                          </ul>
                        </li>
                      </ul>
                    </div>
                    <div class="dropdown-list-group">
                      <ul>
                        <li class="dropdown-region-header">
                          <a href="/tarangire-national-park"
                            >Tarangire
                            <span class="extended-region-name"
                              >National Park</span
                            ></a
                          >
                        </li>
                        <li class="dropdown-link-group">
                          <ul>
                            <li>
                              <a href="/tarangire-river">Tarangire River</a>
                            </li>
                            <li>
                              <a href="/lemiyon-triangle"
                                >Lemiyon Triangle</a
                              >
                            </li>
                            <li>
                              <a href="/matete-woodlands"
                                >Matete Woodlands</a
                              >
                            </li>
                            <li>
                              <a href="/silale-swamp">Silale Swamp</a>
                            </li>
                            <li>
                              <a href="/burungi-circuit">Burungi Circuit</a>
                            </li>
                            <li>
                              <a href="/kitibong-hill">Kitibong Hill</a>
                            </li>
                          </ul>
                        </li>
                        <li
                          class="dropdown-region-header dropdown-region-header-lined"
                        >
                          <a href="/arusha">Arusha</a>
                        </li>
                        <li class="dropdown-link-group">
                          <ul>
                            <li><a href="/arusha">Arusha</a></li>
                          </ul>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
              </li>
              <li class="dropdown dropdown-lodging">
                <a href="/lodging"
                  ><span class="valign-wrap">Lodging</span></a
                >
                <div class="dropdown-menu">
                  <div class="dropdown-menu-callout">
                    <h1>What style of lodging are you looking for?</h1>
                    <a class="btn btn-primary" href="/lodging"
                      >Search by Style <i class="fa fa-chevron-right"></i
                    ></a>
                    <a class="dropdown-callout-map" href="/maps/tanzania"
                      ><img
                        src="<?php echo $themeurl; ?>/assets/archive/scale-map-tanzania.gif"
                    /></a>
                    <a class="btn btn-primary" href="/maps/tanzania"
                      >Search by Map <i class="fa fa-chevron-right"></i
                    ></a>
                  </div>
                  <div class="dropdown-list-container">
                    <div class="dropdown-list-group">
                      <ul>
                        <li class="dropdown-region-header">
                          <span class="dropdown-list-anchor-wrap"
                            >Serengeti
                            <span class="extended-region-name"
                              >National Park</span
                            ></span
                          >
                        </li>
                        <li class="dropdown-region-subheader">
                          <span class="dropdown-list-anchor-wrap">North</span>
                        </li>
                        <li class="dropdown-link-group">
                          <ul>
                            <li>
                              <a href="/migration-tented-lodge"
                                >Migration Tented Lodge</a
                              >
                            </li>
                            <li>
                              <a href="/lemala-mara-river-camp"
                                >Lemala Mara River Camp</a
                              >
                            </li>
                            <li>
                              <a href="/kuria-hills-lodge"
                                >Kuria Hills Lodge</a
                              >
                            </li>
                            <li><a href="/river-camp">River Camp</a></li>
                            <li><a href="/taasa-lodge">Taasa Lodge</a></li>
                            <li>
                              <a href="/serengeti-under-canvas-north"
                                >N. Serengeti Under Canvas</a
                              >
                            </li>
                            <li>
                              <a href="/nimali-mara-lodge"
                                >Nimali Mara Lodge</a
                              >
                            </li>
                          </ul>
                        </li>
                        <li class="dropdown-region-subheader">
                          <span class="dropdown-list-anchor-wrap">West</span>
                        </li>
                        <li class="dropdown-link-group">
                          <ul>
                            <li>
                              <a href="/mbalageti-tented-lodge"
                                >Mbalageti Tented Lodge</a
                              >
                            </li>
                            <li>
                              <a href="/kirawira-tented-lodge"
                                >Kirawira Tented Lodge</a
                              >
                            </li>
                            <li>
                              <a href="/grumeti-river-lodge"
                                >Grumeti River Lodge</a
                              >
                            </li>
                            <li>
                              <a href="/lahia-tented-lodge"
                                >Lahia Tented Lodge</a
                              >
                            </li>
                          </ul>
                        </li>
                        <li class="dropdown-region-subheader">
                          <span class="dropdown-list-anchor-wrap">East</span>
                        </li>
                        <li class="dropdown-link-group">
                          <ul>
                            <li><a href="/sametu-camp">Sametu Camp</a></li>
                            <li>
                              <a href="/nanyukie-tented-lodge"
                                >Nanyukie Tented Lodge</a
                              >
                            </li>
                          </ul>
                        </li>
                      </ul>
                    </div>
                    <div class="dropdown-list-group">
                      <ul>
                        <li class="dropdown-region-subheader">
                          <span class="dropdown-list-anchor-wrap">South</span>
                        </li>
                        <li class="dropdown-link-group">
                          <ul>
                            <li><a href="/ndutu-lodge">Ndutu Lodge</a></li>
                            <li>
                              <a href="/lake-masek-tented-lodge"
                                >Lake Masek Tented Lodge</a
                              >
                            </li>
                            <li>
                              <a href="/woodlands-camp">Woodlands Camp</a>
                            </li>
                            <li>
                              <a href="/serengeti-under-canvas-south"
                                >S. Serengeti Under Canvas</a
                              >
                            </li>
                          </ul>
                        </li>
                        <li class="dropdown-region-subheader">
                          <span class="dropdown-list-anchor-wrap">Central</span>
                        </li>
                        <li class="dropdown-link-group">
                          <ul>
                            <li>
                              <a href="/mbuzi-mawe-tented-lodge"
                                >Mbuzi Mawe Tented Lodge</a
                              >
                            </li>
                            <li>
                              <a href="/serengeti-serena-lodge"
                                >Serengeti Serena Lodge</a
                              >
                            </li>
                            <li>
                              <a href="/four-seasons-lodge"
                                >Four Seasons Lodge</a
                              >
                            </li>
                            <li>
                              <a href="/private-mobile-camp"
                                >Private Mobile Camp</a
                              >
                            </li>
                            <li>
                              <a href="/kubu-kubu-tented-lodge"
                                >Kubu Kubu Tented Lodge</a
                              >
                            </li>
                            <li>
                              <a href="/serengeti-pioneer-camp"
                                >Serengeti Pioneer Camp</a
                              >
                            </li>
                            <li>
                              <a href="/nimali-serengeti-lodge"
                                >Nimali Serengeti Lodge</a
                              >
                            </li>
                          </ul>
                        </li>
                      </ul>
                    </div>
                    <div class="dropdown-list-group">
                      <ul>
                        <li class="dropdown-region-header">
                          <span class="dropdown-list-anchor-wrap"
                            >Lake Manyara
                            <span class="extended-region-name"
                              >National Park</span
                            ></span
                          >
                        </li>
                        <li class="dropdown-link-group">
                          <ul>
                            <li>
                              <a href="/plantation-lodge"
                                >Plantation Lodge</a
                              >
                            </li>
                            <li><a href="/gibbs-farm">Gibbs Farm</a></li>
                            <li>
                              <a href="/the-manor-at-ngorongoro"
                                >The Manor at Ngorongoro</a
                              >
                            </li>
                            <li>
                              <a href="/neptune-lodge">Neptune Lodge</a>
                            </li>
                          </ul>
                        </li>
                        <li
                          class="dropdown-region-header dropdown-region-header-lined"
                        >
                          <span class="dropdown-list-anchor-wrap"
                            >Ngorongoro
                            <span class="extended-region-name"
                              >Conservation Area</span
                            ></span
                          >
                        </li>
                        <li class="dropdown-link-group">
                          <ul>
                            <li>
                              <a href="/ngorongoro-crater-lodge"
                                >Ngorongoro Crater Lodge</a
                              >
                            </li>
                            <li>
                              <a href="/ngorongoro-serena-lodge"
                                >Ngorongoro Serena Lodge</a
                              >
                            </li>
                            <li>
                              <a href="/lions-paw-camp"
                                >Lion&#039;s Paw Camp</a
                              >
                            </li>
                            <li>
                              <a href="/craters-edge-lodge"
                                >Crater&#039;s Edge Lodge</a
                              >
                            </li>
                            <li>
                              <a href="/ngorongoro-melia-lodge"
                                >Ngorongoro Melia Lodge</a
                              >
                            </li>
                          </ul>
                        </li>
                      </ul>
                    </div>
                    <div class="dropdown-list-group">
                      <ul>
                        <li class="dropdown-region-header">
                          <span class="dropdown-list-anchor-wrap"
                            >Tarangire
                            <span class="extended-region-name"
                              >National Park</span
                            ></span
                          >
                        </li>
                        <li class="dropdown-link-group">
                          <ul>
                            <li>
                              <a href="/swala-tented-lodge"
                                >Swala Tented Lodge</a
                              >
                            </li>
                            <li>
                              <a href="/tarangire-treetops-lodge"
                                >Tarangire Treetops Lodge</a
                              >
                            </li>
                            <li>
                              <a href="/kikoti-tented-lodge"
                                >Kikoti Tented Lodge</a
                              >
                            </li>
                            <li>
                              <a href="/mpingo-ridge-lodge"
                                >Mpingo Ridge Lodge
                              </a>
                            </li>
                            <li>
                              <a href="/maramboi-tented-lodge"
                                >Maramboi Tented Lodge</a
                              >
                            </li>
                            <li>
                              <a href="/elephant-springs"
                                >Elephant Springs</a
                              >
                            </li>
                            <li>
                              <a href="/kuro-treetops-lodge"
                                >Kuro Treetops Lodge</a
                              >
                            </li>
                          </ul>
                        </li>
                        <li
                          class="dropdown-region-header dropdown-region-header-lined"
                        >
                          <span class="dropdown-list-anchor-wrap">Arusha</span>
                        </li>
                        <li class="dropdown-link-group">
                          <ul>
                            <li>
                              <a href="/mount-meru-resort"
                                >Mount Meru Resort</a
                              >
                            </li>
                            <li>
                              <a href="/arusha-coffee-lodge"
                                >Arusha Coffee Lodge</a
                              >
                            </li>
                            <li>
                              <a href="/lake-duluti-lodge"
                                >Lake Duluti Lodge</a
                              >
                            </li>
                            <li>
                              <a href="/kili-seasons-hotel"
                                >Kili Seasons Hotel</a
                              >
                            </li>
                            <li>
                              <a href="/kili-private-villas"
                                >Kili Private Villas</a
                              >
                            </li>
                            <li>
                              <a href="/gran-melia-arusha"
                                >Gran Melia Arusha</a
                              >
                            </li>
                          </ul>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
              </li>
              <li
                class="dropdown dropdown-image-blocks dropdown-image-blocks-2"
              >
                <a class="" href="/media/videos">Galleries</a>
                <div class="dropdown-menu">
                  <ul class="list-unstyled">
                    <li class="menu-section first">
                      <a href="/media/videos">
                        <span class="menu-img">
                          <img
                            src="<?php echo $themeurl; ?>/assets/archive/media-videos-img-thumb.jpg"
                          />
                          <span class="menu-img-overlay"></span>
                          <i class="fa fa-play-circle"></i>
                        </span>
                        <span class="menu-text">Video Archives</span>
                      </a>
                    </li>
                    <li class="menu-section">
                      <a href="/media/photos">
                        <span class="menu-img">
                          <img
                            src="<?php echo $themeurl; ?>/assets/archive/media-photos-img-thumb.jpg"
                          />
                          <span class="menu-img-overlay"></span>
                          <i class="fa fa-arrow-circle-right"></i>
                        </span>
                        <span class="menu-text">Photo Gallery</span>
                      </a>
                    </li>
                  </ul>
                </div>
              </li>
            </ul>
            <ul class="nav navbar-nav" id="navbar-secondary">
              <li><a class="" href="/awards-and-press">Awards</a></li>
              <li><a class="" href="/maps/tanzania">Map</a></li>
              <li><a class="" href="/community">Local Partnerships</a></li>
              <li>
                <a
                  class=""
                  href="http:
                  target="_blank"
                  >Blog</a
                >
              </li>
              <li><a class="" href="/faq">FAQ</a></li>
              <li>
                <a href="/safari-details/photographic-ambassador"
                  >Expert Photo Tips</a
                >
              </li>
              <li id="header-search-form">
                <form
                  action="/search"
                  method="get"
                >
                  <div class="search-input-icon">
                    <svg viewBox="0 0 15.8 15.8">
                      <use
                        xmlns:xlink="http:
                        xlink:href="#icon-search"
                      ></use>
                    </svg>
                  </div>
                  <div class="search-input-container">
                    <input
                      type="text"
                      name="q"
                      value=""
                      placeholder="What are you looking for?"
                    />
                  </div>
                </form>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </header>
    <!-- Mobile submenu -->
    <div id="nav-submenu" style="display: none">
      <div id="nav-submenu-content">
        <div class="container">
          <div id="nav-submenu-close"><i class="fa fa-times"></i></div>
          <ul class="list-unstyled" id="nav-submenu-about">
            <li class="nav-submenu-name">
              <a href="/company-overview/letter-from-the-founder">About</a>
            </li>
            <li class="nav-submenu-header"><a>Company Overview</a></li>
            <li class="nav-submenu-link">
              <a href="/company-overview/letter-from-the-founder"
                >Letter from the Founder</a
              >
            </li>
            <li class="nav-submenu-link">
              <a href="/company-overview/why-were-different"
                >Why We're Different</a
              >
            </li>
            <li class="nav-submenu-link">
              <a href="/company-overview/tanzania-specialists"
                >We Specialize in Tanzania</a
              >
            </li>
            <li class="nav-submenu-link">
              <a href="/company-overview/meet-our-safari-experts"
                >Meet Our Safari Experts</a
              >
            </li>
            <li class="nav-submenu-link">
              <a href="/company-overview/private-safari-advantage"
                >Private Safari Advantage</a
              >
            </li>
            <li class="nav-submenu-link">
              <a href="/company-overview/personalized-itineraries"
                >Personalized Itineraries</a
              >
            </li>
            <li class="nav-submenu-link">
              <a href="/company-overview/wildlife-viewing-maximized"
                >Wildlife Viewing Maximized</a
              >
            </li>
            <li class="nav-submenu-header"><a>Safari Details</a></li>
            <li class="nav-submenu-link">
              <a href="/safari-details/driver-guides">Driver Guides</a>
            </li>
            <li class="nav-submenu-link">
              <a href="/safari-details/vehicle-specifications"
                >Vehicle Specifications</a
              >
            </li>
            <li class="nav-submenu-link">
              <a href="/safari-details/seasonal-highlights"
                >Seasonal Highlights</a
              >
            </li>
            <li class="nav-submenu-link">
              <a href="/safari-details/inclusions-and-exclusions"
                >Inclusions & Exclusions</a
              >
            </li>
            <li class="nav-submenu-link">
              <a href="/safari-details/itinerary-design-and-recommendations"
                >Itinerary Design & Recommendations
              </a>
            </li>
            <li class="nav-submenu-link">
              <a href="/safari-details/safety">Safari Safety</a>
            </li>
            <li class="nav-submenu-link">
              <a href="/safari-details/photographic-ambassador"
                >Our Photographic Ambassador</a
              >
            </li>
            <li class="nav-submenu-header"><a>Trip Enhancements</a></li>
            <li class="nav-submenu-link">
              <a href="/trip-enhancements/cultural-tour">Cultural Tour</a>
            </li>
            <li class="nav-submenu-link">
              <a href="/trip-enhancements/balloon-safari">Balloon Safari</a>
            </li>
            <li class="nav-submenu-link">
              <a href="/trip-enhancements/arusha-layover">Arusha Layover</a>
            </li>
            <li class="nav-submenu-link">
              <a href="/trip-enhancements/walking-safari">Walking Safari</a>
            </li>
            <li class="nav-submenu-link">
              <a href="/trip-enhancements/night-game-drive"
                >Night Game Drive</a
              >
            </li>
            <li class="nav-submenu-link">
              <a href="/trip-enhancements/junior-game-ranger-challenge"
                >Junior Game Ranger</a
              >
            </li>
            <li class="nav-submenu-link">
              <a href="/trip-enhancements/charitable-visits"
                >Charitable Visits</a
              >
            </li>
            <li class="nav-submenu-link">
              <a href="/trip-enhancements/serengeti-lion-project"
                >Serengeti Lion Project</a
              >
            </li>
            <li class="nav-submenu-header"><a>Booking And Flights</a></li>
            <li class="nav-submenu-link">
              <a href="/booking-and-flights/booking-security"
                >Booking Security</a
              >
            </li>
            <li class="nav-submenu-link">
              <a href="/booking-and-flights/flexible-travel-and-payment"
                >Flexible Travel & Payment</a
              >
            </li>
            <li class="nav-submenu-link">
              <a href="/booking-and-flights/booking-terms-and-conditions"
                >Booking Terms & Conditions</a
              >
            </li>
            <li class="nav-submenu-link">
              <a href="/booking-and-flights/international-flight-routing"
                >International Flight Routing</a
              >
            </li>
          </ul>
          <ul class="list-unstyled" id="nav-submenu-regions">
            <li class="nav-submenu-name">
              <a href="/maps/tanzania">Regions</a>
            </li>
            <li class="nav-submenu-buttons">
              <a class="btn btn-primary" href="/maps/tanzania"
                >Search by Map <i class="fa fa-chevron-right"></i
              ></a>
            </li>
            <li class="nav-submenu-header">
              <a href="/serengeti-national-park">Serengeti National Park</a>
            </li>
            <li class="nav-submenu-link">
              <a href="/north-serengeti">North Serengeti</a>
            </li>
            <li class="nav-submenu-link">
              <a href="/west-serengeti">West Serengeti</a>
            </li>
            <li class="nav-submenu-link">
              <a href="/central-serengeti">Central Serengeti</a>
            </li>
            <li class="nav-submenu-link">
              <a href="/east-serengeti">East Serengeti</a>
            </li>
            <li class="nav-submenu-link">
              <a href="/south-serengeti">South Serengeti</a>
            </li>
            <li class="nav-submenu-header">
              <a href="/ngorongoro-conservation-area"
                >Ngorongoro Conservation Area</a
              >
            </li>
            <li class="nav-submenu-link">
              <a href="/lake-magadi">Lake Magadi</a>
            </li>
            <li class="nav-submenu-link">
              <a href="/central-plains">Central Plains</a>
            </li>
            <li class="nav-submenu-link">
              <a href="/lerai-forest">Lerai Forest</a>
            </li>
            <li class="nav-submenu-link">
              <a href="/rumbe-hills">Rumbe Hills</a>
            </li>
            <li class="nav-submenu-link">
              <a href="/munge-stream">Munge Stream</a>
            </li>
            <li class="nav-submenu-link">
              <a href="/mandusi-swamp">Mandusi Swamp</a>
            </li>
            <li class="nav-submenu-link">
              <a href="/gorigor-swamp">Gorigor Swamp</a>
            </li>
            <li class="nav-submenu-link">
              <a href="/ngoitokitok-springs">Ngoitokitok Springs</a>
            </li>
            <li class="nav-submenu-header">
              <a href="/lake-manyara-national-park"
                >Lake Manyara National Park</a
              >
            </li>
            <li class="nav-submenu-link">
              <a href="/ground-water-forest">Ground Water Forest</a>
            </li>
            <li class="nav-submenu-link">
              <a href="/acacia-woodlands">Acacia Woodlands</a>
            </li>
            <li class="nav-submenu-link">
              <a href="/floodplains">Floodplains</a>
            </li>
            <li class="nav-submenu-link">
              <a href="/lake-manyara">Lake Manyara</a>
            </li>
            <li class="nav-submenu-header">
              <a href="/tarangire-national-park">Tarangire National Park</a>
            </li>
            <li class="nav-submenu-link">
              <a href="/tarangire-river">Tarangire River</a>
            </li>
            <li class="nav-submenu-link">
              <a href="/lemiyon-triangle">Lemiyon Triangle</a>
            </li>
            <li class="nav-submenu-link">
              <a href="/matete-woodlands">Matete Woodlands</a>
            </li>
            <li class="nav-submenu-link">
              <a href="/silale-swamp">Silale Swamp</a>
            </li>
            <li class="nav-submenu-link">
              <a href="/burungi-circuit">Burungi Circuit</a>
            </li>
            <li class="nav-submenu-link">
              <a href="/kitibong-hill">Kitibong Hill</a>
            </li>
            <li class="nav-submenu-header"><a href="/arusha">Arusha</a></li>
          </ul>
          <ul class="list-unstyled" id="nav-submenu-lodging">
            <li class="nav-submenu-name"><a href="/lodging">Lodging</a></li>
            <li class="nav-submenu-buttons">
              <a class="btn btn-primary" href="/lodging"
                >Search by Style <i class="fa fa-chevron-right"></i
              ></a>
              <a class="btn btn-primary" href="/maps/tanzania"
                >Search by Map <i class="fa fa-chevron-right"></i
              ></a>
            </li>
            <li class="nav-submenu-header"><a>North Serengeti</a></li>
            <li class="nav-submenu-link">
              <a href="/migration-tented-lodge">Migration Tented Lodge</a>
            </li>
            <li class="nav-submenu-link">
              <a href="/lemala-mara-river-camp">Lemala Mara River Camp</a>
            </li>
            <li class="nav-submenu-link">
              <a href="/kuria-hills-lodge">Kuria Hills Lodge</a>
            </li>
            <li class="nav-submenu-link">
              <a href="/river-camp">River Camp</a>
            </li>
            <li class="nav-submenu-link">
              <a href="/taasa-lodge">Taasa Lodge</a>
            </li>
            <li class="nav-submenu-link">
              <a href="/serengeti-under-canvas-north"
                >N. Serengeti Under Canvas</a
              >
            </li>
            <li class="nav-submenu-link">
              <a href="/nimali-mara-lodge">Nimali Mara Lodge</a>
            </li>
            <li class="nav-submenu-header"><a>West Serengeti</a></li>
            <li class="nav-submenu-link">
              <a href="/mbalageti-tented-lodge">Mbalageti Tented Lodge</a>
            </li>
            <li class="nav-submenu-link">
              <a href="/kirawira-tented-lodge">Kirawira Tented Lodge</a>
            </li>
            <li class="nav-submenu-link">
              <a href="/grumeti-river-lodge">Grumeti River Lodge</a>
            </li>
            <li class="nav-submenu-link">
              <a href="/lahia-tented-lodge">Lahia Tented Lodge</a>
            </li>
            <li class="nav-submenu-header"><a>South Serengeti</a></li>
            <li class="nav-submenu-link">
              <a href="/ndutu-lodge">Ndutu Lodge</a>
            </li>
            <li class="nav-submenu-link">
              <a href="/lake-masek-tented-lodge">Lake Masek Tented Lodge</a>
            </li>
            <li class="nav-submenu-link">
              <a href="/woodlands-camp">Woodlands Camp</a>
            </li>
            <li class="nav-submenu-link">
              <a href="/serengeti-under-canvas-south"
                >S. Serengeti Under Canvas</a
              >
            </li>
            <li class="nav-submenu-header"><a>Central Serengeti</a></li>
            <li class="nav-submenu-link">
              <a href="/mbuzi-mawe-tented-lodge">Mbuzi Mawe Tented Lodge</a>
            </li>
            <li class="nav-submenu-link">
              <a href="/serengeti-serena-lodge">Serengeti Serena Lodge</a>
            </li>
            <li class="nav-submenu-link">
              <a href="/four-seasons-lodge">Four Seasons Lodge</a>
            </li>
            <li class="nav-submenu-link">
              <a href="/private-mobile-camp">Private Mobile Camp</a>
            </li>
            <li class="nav-submenu-link">
              <a href="/kubu-kubu-tented-lodge">Kubu Kubu Tented Lodge</a>
            </li>
            <li class="nav-submenu-link">
              <a href="/serengeti-pioneer-camp">Serengeti Pioneer Camp</a>
            </li>
            <li class="nav-submenu-link">
              <a href="/nimali-serengeti-lodge">Nimali Serengeti Lodge</a>
            </li>
            <li class="nav-submenu-header"><a>East Serengeti</a></li>
            <li class="nav-submenu-link">
              <a href="/sametu-camp">Sametu Camp</a>
            </li>
            <li class="nav-submenu-link">
              <a href="/nanyukie-tented-lodge">Nanyukie Tented Lodge</a>
            </li>
            <li class="nav-submenu-header">
              <a>Lake Manyara National Park</a>
            </li>
            <li class="nav-submenu-link">
              <a href="/plantation-lodge">Plantation Lodge</a>
            </li>
            <li class="nav-submenu-link">
              <a href="/gibbs-farm">Gibbs Farm</a>
            </li>
            <li class="nav-submenu-link">
              <a href="/the-manor-at-ngorongoro">The Manor at Ngorongoro</a>
            </li>
            <li class="nav-submenu-link">
              <a href="/neptune-lodge">Neptune Lodge</a>
            </li>
            <li class="nav-submenu-header">
              <a>Ngorongoro Conservation Area</a>
            </li>
            <li class="nav-submenu-link">
              <a href="/ngorongoro-crater-lodge">Ngorongoro Crater Lodge</a>
            </li>
            <li class="nav-submenu-link">
              <a href="/ngorongoro-serena-lodge">Ngorongoro Serena Lodge</a>
            </li>
            <li class="nav-submenu-link">
              <a href="/lions-paw-camp">Lion's Paw Camp</a>
            </li>
            <li class="nav-submenu-link">
              <a href="/craters-edge-lodge">Crater's Edge Lodge</a>
            </li>
            <li class="nav-submenu-link">
              <a href="/ngorongoro-melia-lodge">Ngorongoro Melia Lodge</a>
            </li>
            <li class="nav-submenu-header"><a>Tarangire National Park</a></li>
            <li class="nav-submenu-link">
              <a href="/swala-tented-lodge">Swala Tented Lodge</a>
            </li>
            <li class="nav-submenu-link">
              <a href="/tarangire-treetops-lodge"
                >Tarangire Treetops Lodge</a
              >
            </li>
            <li class="nav-submenu-link">
              <a href="/kikoti-tented-lodge">Kikoti Tented Lodge</a>
            </li>
            <li class="nav-submenu-link">
              <a href="/mpingo-ridge-lodge">Mpingo Ridge Lodge </a>
            </li>
            <li class="nav-submenu-link">
              <a href="/maramboi-tented-lodge">Maramboi Tented Lodge</a>
            </li>
            <li class="nav-submenu-link">
              <a href="/elephant-springs">Elephant Springs</a>
            </li>
            <li class="nav-submenu-link">
              <a href="/kuro-treetops-lodge">Kuro Treetops Lodge</a>
            </li>
            <li class="nav-submenu-header"><a>Arusha</a></li>
            <li class="nav-submenu-link">
              <a href="/mount-meru-resort">Mount Meru Resort</a>
            </li>
            <li class="nav-submenu-link">
              <a href="/arusha-coffee-lodge">Arusha Coffee Lodge</a>
            </li>
            <li class="nav-submenu-link">
              <a href="/lake-duluti-lodge">Lake Duluti Lodge</a>
            </li>
            <li class="nav-submenu-link">
              <a href="/kili-seasons-hotel">Kili Seasons Hotel</a>
            </li>
            <li class="nav-submenu-link">
              <a href="/kili-private-villas">Kili Private Villas</a>
            </li>
            <li class="nav-submenu-link">
              <a href="/gran-melia-arusha">Gran Melia Arusha</a>
            </li>
          </ul>
          <ul class="list-unstyled" id="nav-submenu-local-partnerships">
            <li class="nav-submenu-name">
              <a href="/lodging">Local Partnerships</a>
            </li>
            <li class="nav-submenu-header"><a>Overview</a></li>
            <li class="nav-submenu-link">
              <a
                href="community/overview/together-we-can-make-a-difference"
                >Together We Can Make a Difference</a
              >
            </li>
            <li class="nav-submenu-header"><a>Conservation</a></li>
            <li class="nav-submenu-link">
              <a href="community/conservation/serengeti-lion-project"
                >Serengeti Lion Project</a
              >
            </li>
            <li class="nav-submenu-link">
              <a href="community/conservation/serengeti-cheetah-project"
                >Serengeti Cheetah Project</a
              >
            </li>
            <li class="nav-submenu-header"><a>Humanitarian</a></li>
            <li class="nav-submenu-link">
              <a href="community/humanitarian/school-of-st-jude"
                >School of St. Jude</a
              >
            </li>
            <li class="nav-submenu-link">
              <a
                href="community/humanitarian/foundation-for-african-medicine-education"
                >Foundation for African Medicine & Education</a
              >
            </li>
            <li class="nav-submenu-link">
              <a href="community/humanitarian/peace-house-orphanage"
                >Peace House Orphanage</a
              >
            </li>
            <li class="nav-submenu-link">
              <a href="community/humanitarian/poli-village-school"
                >POLI Village School</a
              >
            </li>
          </ul>
        </div>
      </div>
    </div>
    <!-- SVG Icons -->
    <svg style="display: none">
      <symbol id="icon-search" viewBox="0 0 15.8 15.8">
        <path
          d="M15.45 13.37l-3.78-3.78a6.15 6.15 0 0 0 .9-3.21A6.52 6.52 0 0 0 6.19 0 6.18 6.18 0 0 0 0 6.19a6.52 6.52 0 0 0 6.38 6.38 6.15 6.15 0 0 0 3.11-.84l3.8 3.8a1 1 0 0 0 1.35 0l.94-.94c.42-.38.24-.85-.13-1.22zM1.9 6.19A4.28 4.28 0 0 1 6.19 1.9a4.61 4.61 0 0 1 4.47 4.47 4.28 4.28 0 0 1-4.28 4.28A4.62 4.62 0 0 1 1.9 6.19z"
        ></path>
      </symbol>
    </svg>
	<main id="main" class="site-main">