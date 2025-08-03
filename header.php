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
            <a class="navbar-brand" href="index.html#main"
              ><img src="<?php echo $logo['url']; ?>" alt="<?php echo $logo['alt']; ?>"
            /></a>

            <a href="index.html" style="display: none"
              ><img
                src="<?php echo $logo_secondary['url']; ?>"
                width="155"
                alt="Africa Dream Safaris"
            /></a>
          </div>

          <ul class="nav navbar-nav navbar-right navbar-buttons">
            <li>
              <a class="btn-contact-us" href="contact.html"
                ><span>Contact Us</span><i class="fa fa-caret-right"></i
              ></a>
            </li>
            <li>
              <a
                class="btn-create-your-own"
                href="create-your-own-itinerary.html"
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
                  href="company-overview/letter-from-the-founder.html"
                  >About</a
                >
              </li>
              <li><a href="guest-reviews.html">Guest Reviews</a></li>
              <li>
                <a
                  class="nav-has-submenu"
                  data-submenu-name="regions"
                  href="maps/tanzania.html"
                  >Regions</a
                >
              </li>
              <li>
                <a
                  class="nav-has-submenu"
                  data-submenu-name="lodging"
                  href="lodging.html"
                  >Lodging</a
                >
              </li>
              <li><a href="media/videos.html">Galleries</a></li>
              <li>
                <a
                  class=""
                  href="http://blog.africadreamsafaris.com/"
                  target="_blank"
                  >Blog</a
                >
              </li>
              <li class="navbar-link-secondary">
                <a class="" href="awards-and-press.html">Awards</a>
              </li>
              <li class="navbar-link-secondary">
                <a
                  data-submenu-name="local-partnerships"
                  class="nav-has-submenu"
                  href="community.html"
                  >Local Partnerships</a
                >
              </li>
              <li class="navbar-link-secondary">
                <a class="" href="faq.html">FAQ</a>
              </li>
              <li class="navbar-link-secondary">
                <a class="" href="maps/tanzania.html">Maps</a>
              </li>
              <li class="navbar-link-secondary">
                <a href="safari-details/photographic-ambassador.html"
                  >Expert Photo Tips</a
                >
              </li>

              <li class="navbar-link-secondary" id="navbar-link-search-form">
                <form
                  action="https://www.africadreamsafaris.com/search"
                  method="get"
                >
                  <div class="search-input-container">
                    <input type="text" name="q" placeholder="Search" />
                  </div>
                  <button type="submit" class="search-input-icon">
                    <svg viewBox="0 0 15.8 15.8">
                      <use
                        xmlns:xlink="http://www.w3.org/1999/xlink"
                        xlink:href="#icon-search"
                      ></use>
                    </svg>
                  </button>
                </form>
              </li>
            </ul>

            <ul class="nav navbar-nav" id="navbar-primary">
              <li class="dropdown dropdown-about">
                <a href="company-overview/letter-from-the-founder.html"
                  ><span class="valign-wrap">About</span></a
                >

                <div class="dropdown-menu">
                  <ul class="list-unstyled">
                    <li class="menu-section first">
                      <ul class="list-unstyled">
                        <li class="first"><a>Company Overview</a></li>
                        <li>
                          <a
                            href="company-overview/letter-from-the-founder.html"
                            >Letter from the Founder</a
                          >
                        </li>
                        <li>
                          <a href="company-overview/why-were-different.html"
                            >Why We're Different</a
                          >
                        </li>
                        <li>
                          <a href="company-overview/tanzania-specialists.html"
                            >We Specialize in Tanzania</a
                          >
                        </li>
                        <li>
                          <a
                            href="company-overview/meet-our-safari-experts.html"
                            >Meet Our Safari Experts</a
                          >
                        </li>
                        <li>
                          <a
                            href="company-overview/private-safari-advantage.html"
                            >Private Safari Advantage</a
                          >
                        </li>
                        <li>
                          <a
                            href="company-overview/personalized-itineraries.html"
                            >Personalized Itineraries</a
                          >
                        </li>
                        <li>
                          <a
                            href="company-overview/wildlife-viewing-maximized.html"
                            >Wildlife Viewing Maximized</a
                          >
                        </li>
                      </ul>
                    </li>
                    <li class="menu-section">
                      <ul class="list-unstyled">
                        <li class="first"><a>Safari Details</a></li>
                        <li>
                          <a href="safari-details/driver-guides.html"
                            >Driver Guides</a
                          >
                        </li>
                        <li>
                          <a href="safari-details/vehicle-specifications.html"
                            >Vehicle Specifications</a
                          >
                        </li>
                        <li>
                          <a href="safari-details/seasonal-highlights.html"
                            >Seasonal Highlights</a
                          >
                        </li>
                        <li>
                          <a
                            href="safari-details/inclusions-and-exclusions.html"
                            >Inclusions & Exclusions</a
                          >
                        </li>
                        <li>
                          <a
                            href="safari-details/itinerary-design-and-recommendations.html"
                            >Itinerary Design & Recommendations
                          </a>
                        </li>
                        <li>
                          <a href="safari-details/safety.html">Safari Safety</a>
                        </li>
                        <li>
                          <a href="safari-details/photographic-ambassador.html"
                            >Our Photographic Ambassador</a
                          >
                        </li>
                      </ul>
                    </li>
                    <li class="menu-section">
                      <ul class="list-unstyled">
                        <li class="first"><a>Trip Enhancements</a></li>
                        <li>
                          <a href="trip-enhancements/cultural-tour.html"
                            >Cultural Tour</a
                          >
                        </li>
                        <li>
                          <a href="trip-enhancements/balloon-safari.html"
                            >Balloon Safari</a
                          >
                        </li>
                        <li>
                          <a href="trip-enhancements/arusha-layover.html"
                            >Arusha Layover</a
                          >
                        </li>
                        <li>
                          <a href="trip-enhancements/walking-safari.html"
                            >Walking Safari</a
                          >
                        </li>
                        <li>
                          <a href="trip-enhancements/night-game-drive.html"
                            >Night Game Drive</a
                          >
                        </li>
                        <li>
                          <a
                            href="trip-enhancements/junior-game-ranger-challenge.html"
                            >Junior Game Ranger</a
                          >
                        </li>
                        <li>
                          <a href="trip-enhancements/charitable-visits.html"
                            >Charitable Visits</a
                          >
                        </li>
                        <li>
                          <a
                            href="trip-enhancements/serengeti-lion-project.html"
                            >Serengeti Lion Project</a
                          >
                        </li>
                      </ul>
                    </li>
                    <li class="menu-section">
                      <ul class="list-unstyled">
                        <li class="first"><a>Booking And Flights</a></li>
                        <li>
                          <a href="booking-and-flights/booking-security.html"
                            >Booking Security</a
                          >
                        </li>
                        <li>
                          <a
                            href="booking-and-flights/flexible-travel-and-payment.html"
                            >Flexible Travel & Payment</a
                          >
                        </li>
                        <li>
                          <a
                            href="booking-and-flights/booking-terms-and-conditions.html"
                            >Booking Terms & Conditions</a
                          >
                        </li>
                        <li>
                          <a
                            href="booking-and-flights/international-flight-routing.html"
                            >International Flight Routing</a
                          >
                        </li>
                      </ul>
                    </li>
                  </ul>
                </div>
              </li>

              <li class="dropdown dropdown-image-blocks">
                <a href="guest-reviews.html"
                  ><span class="valign-wrap">Guest<br />Reviews</span></a
                >

                <div class="dropdown-menu">
                  <ul class="list-unstyled">
                    <li class="menu-section first">
                      <a href="guest-reviews.html#family-vacations">
                        <span class="menu-img"
                          ><img
                            src="<?php echo $themeurl; ?>/assets/archive/guestreviews-familyvacations-thumb.jpg"
                        /></span>
                        <span class="menu-text">Family Vacations</span>
                      </a>
                    </li>

                    <li class="menu-section">
                      <a href="guest-reviews.html#romantic-getaways">
                        <span class="menu-img"
                          ><img
                            src="<?php echo $themeurl; ?>/assets/archive/guestreviews-romanticgetaways-thumb.jpg"
                        /></span>
                        <span class="menu-text">Romantic Getaways</span>
                      </a>
                    </li>

                    <li class="menu-section">
                      <a href="guest-reviews.html#photo-safaris">
                        <span class="menu-img"
                          ><img
                            src="<?php echo $themeurl; ?>/assets/archive/guestreviews-photosafaris-thumb.jpg"
                        /></span>
                        <span class="menu-text">Photo Safaris</span>
                      </a>
                    </li>

                    <li class="menu-section">
                      <a href="guest-reviews.html#bucket-list">
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
                <a href="maps/tanzania.html"
                  ><span class="valign-wrap">Regions</span></a
                >

                <div class="dropdown-menu">
                  <div class="dropdown-menu-callout">
                    <h1>Select a region or sub-region to learn more.</h1>
                    <h2>- OR -</h2>

                    <a class="dropdown-callout-map" href="maps/tanzania.html"
                      ><img
                        src="<?php echo $themeurl; ?>/assets/archive/scale-map-tanzania.gif"
                    /></a>
                    <a class="btn btn-primary" href="maps/tanzania.html"
                      >Search by Map <i class="fa fa-chevron-right"></i
                    ></a>
                  </div>

                  <div class="dropdown-list-container">
                    <div class="dropdown-list-group">
                      <ul>
                        <li class="dropdown-region-header">
                          <a href="serengeti-national-park.html"
                            >Serengeti
                            <span class="extended-region-name"
                              >National Park</span
                            ></a
                          >
                        </li>
                        <li class="dropdown-region-subheader">
                          <a href="north-serengeti.html">North Serengeti</a>
                        </li>

                        <li class="dropdown-link-group">
                          <ul>
                            <li><a href="lobo-valley.html">Lobo Valley</a></li>
                            <li>
                              <a href="upper-grumeti-woodlands.html"
                                >Upper Grumeti Woodlands</a
                              >
                            </li>
                            <li><a href="mara-river.html">Mara River</a></li>
                            <li>
                              <a href="lamai-triangle.html">Lamai Triangle</a>
                            </li>
                            <li><a href="wogakuria.html">Wogakuria</a></li>
                            <li>
                              <a href="bologonja-springs.html"
                                >Bologonja Springs</a
                              >
                            </li>
                          </ul>
                        </li>

                        <li class="dropdown-region-subheader">
                          <a href="west-serengeti.html">West Serengeti</a>
                        </li>

                        <li class="dropdown-link-group">
                          <ul>
                            <li>
                              <a href="ruwana-plains.html">Ruwana Plains</a>
                            </li>
                            <li>
                              <a href="lower-grumeti-woodlands.html"
                                >Lower Grumeti Woodlands</a
                              >
                            </li>
                            <li>
                              <a href="mbalageti-river-valley.html"
                                >Mbalageti River Valley</a
                              >
                            </li>
                            <li>
                              <a href="musabi-plains.html">Musabi Plains</a>
                            </li>
                          </ul>
                        </li>

                        <li class="dropdown-region-subheader">
                          <a href="east-serengeti.html">East Serengeti</a>
                        </li>

                        <li class="dropdown-link-group">
                          <ul>
                            <li>
                              <a href="sametu-marsh-and-kopjes.html"
                                >Sametu Marsh and Kopjes</a
                              >
                            </li>
                            <li><a href="naabi-hill.html">Naabi Hill</a></li>
                            <li><a href="gol-kopjes.html">Gol Kopjes</a></li>
                            <li>
                              <a href="barfafu-gorge-and-kopjes.html"
                                >Barfafu Gorge and Kopjes</a
                              >
                            </li>
                            <li>
                              <a href="lemuta-hill-and-waterhole.html"
                                >Lemuta Hill and Waterhole</a
                              >
                            </li>
                            <li><a href="lake-natron.html">Lake Natron</a></li>
                          </ul>
                        </li>
                      </ul>
                    </div>

                    <div class="dropdown-list-group">
                      <ul>
                        <li class="dropdown-region-subheader">
                          <a href="south-serengeti.html">South Serengeti</a>
                        </li>

                        <li class="dropdown-link-group">
                          <ul>
                            <li>
                              <a href="the-triangle.html">The Triangle</a>
                            </li>
                            <li>
                              <a href="hidden-valley.html">Hidden Valley</a>
                            </li>
                            <li><a href="lake-ndutu.html">Lake Ndutu</a></li>
                            <li>
                              <a href="kusini-plains.html">Kusini Plains</a>
                            </li>
                            <li>
                              <a href="olduvai-gorge.html">Olduvai Gorge</a>
                            </li>
                            <li>
                              <a href="matiti-plains.html">Matiti Plains</a>
                            </li>
                          </ul>
                        </li>

                        <li class="dropdown-region-subheader">
                          <a href="central-serengeti.html">Central Serengeti</a>
                        </li>

                        <li class="dropdown-link-group">
                          <ul>
                            <li>
                              <a href="seronera-valley.html">Seronera Valley</a>
                            </li>
                            <li>
                              <a href="seronera-river.html">Seronera River</a>
                            </li>
                            <li><a href="retina-pool.html">Retina Pool</a></li>
                            <li><a href="moru-kopjes.html">Moru Kopjes</a></li>
                            <li>
                              <a href="maasai-kopjes.html">Maasai Kopjes</a>
                            </li>
                            <li><a href="makoma-hill.html">Makoma Hill</a></li>
                            <li>
                              <a href="turners-spring.html">Turners Spring</a>
                            </li>
                            <li>
                              <a href="simba-kopjes.html">Simba Kopjes</a>
                            </li>
                            <li>
                              <a href="long-grass-plains.html"
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
                          <a href="lake-manyara.html"
                            >Lake Manyara
                            <span class="extended-region-name"
                              >National Park</span
                            ></a
                          >
                        </li>

                        <li class="dropdown-link-group">
                          <ul>
                            <li>
                              <a href="ground-water-forest.html"
                                >Ground Water Forest</a
                              >
                            </li>
                            <li>
                              <a href="acacia-woodlands.html"
                                >Acacia Woodlands</a
                              >
                            </li>
                            <li><a href="floodplains.html">Floodplains</a></li>
                            <li>
                              <a href="lake-manyara.html">Lake Manyara</a>
                            </li>
                          </ul>
                        </li>

                        <li
                          class="dropdown-region-header dropdown-region-header-lined"
                        >
                          <a href="ngorongoro-conservation-area.html"
                            >Ngorongoro
                            <span class="extended-region-name"
                              >Conservation Area</span
                            ></a
                          >
                        </li>

                        <li class="dropdown-link-group">
                          <ul>
                            <li><a href="lake-magadi.html">Lake Magadi</a></li>
                            <li>
                              <a href="central-plains.html">Central Plains</a>
                            </li>
                            <li>
                              <a href="lerai-forest.html">Lerai Forest</a>
                            </li>
                            <li><a href="rumbe-hills.html">Rumbe Hills</a></li>
                            <li>
                              <a href="munge-stream.html">Munge Stream</a>
                            </li>
                            <li>
                              <a href="mandusi-swamp.html">Mandusi Swamp</a>
                            </li>
                            <li>
                              <a href="gorigor-swamp.html">Gorigor Swamp</a>
                            </li>
                            <li>
                              <a href="ngoitokitok-springs.html"
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
                          <a href="tarangire-national-park.html"
                            >Tarangire
                            <span class="extended-region-name"
                              >National Park</span
                            ></a
                          >
                        </li>

                        <li class="dropdown-link-group">
                          <ul>
                            <li>
                              <a href="tarangire-river.html">Tarangire River</a>
                            </li>
                            <li>
                              <a href="lemiyon-triangle.html"
                                >Lemiyon Triangle</a
                              >
                            </li>
                            <li>
                              <a href="matete-woodlands.html"
                                >Matete Woodlands</a
                              >
                            </li>
                            <li>
                              <a href="silale-swamp.html">Silale Swamp</a>
                            </li>
                            <li>
                              <a href="burungi-circuit.html">Burungi Circuit</a>
                            </li>
                            <li>
                              <a href="kitibong-hill.html">Kitibong Hill</a>
                            </li>
                          </ul>
                        </li>

                        <li
                          class="dropdown-region-header dropdown-region-header-lined"
                        >
                          <a href="arusha.html">Arusha</a>
                        </li>

                        <li class="dropdown-link-group">
                          <ul>
                            <li><a href="arusha.html">Arusha</a></li>
                          </ul>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
              </li>

              <li class="dropdown dropdown-lodging">
                <a href="lodging.html"
                  ><span class="valign-wrap">Lodging</span></a
                >

                <div class="dropdown-menu">
                  <div class="dropdown-menu-callout">
                    <h1>What style of lodging are you looking for?</h1>

                    <a class="btn btn-primary" href="lodging.html"
                      >Search by Style <i class="fa fa-chevron-right"></i
                    ></a>

                    <a class="dropdown-callout-map" href="maps/tanzania.html"
                      ><img
                        src="<?php echo $themeurl; ?>/assets/archive/scale-map-tanzania.gif"
                    /></a>
                    <a class="btn btn-primary" href="maps/tanzania.html"
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
                              <a href="migration-tented-lodge.html"
                                >Migration Tented Lodge</a
                              >
                            </li>
                            <li>
                              <a href="lemala-mara-river-camp.html"
                                >Lemala Mara River Camp</a
                              >
                            </li>
                            <li>
                              <a href="kuria-hills-lodge.html"
                                >Kuria Hills Lodge</a
                              >
                            </li>
                            <li><a href="river-camp.html">River Camp</a></li>
                            <li><a href="taasa-lodge.html">Taasa Lodge</a></li>
                            <li>
                              <a href="serengeti-under-canvas-north.html"
                                >N. Serengeti Under Canvas</a
                              >
                            </li>
                            <li>
                              <a href="nimali-mara-lodge.html"
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
                              <a href="mbalageti-tented-lodge.html"
                                >Mbalageti Tented Lodge</a
                              >
                            </li>
                            <li>
                              <a href="kirawira-tented-lodge.html"
                                >Kirawira Tented Lodge</a
                              >
                            </li>
                            <li>
                              <a href="grumeti-river-lodge.html"
                                >Grumeti River Lodge</a
                              >
                            </li>
                            <li>
                              <a href="lahia-tented-lodge.html"
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
                            <li><a href="sametu-camp.html">Sametu Camp</a></li>
                            <li>
                              <a href="nanyukie-tented-lodge.html"
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
                            <li><a href="ndutu-lodge.html">Ndutu Lodge</a></li>
                            <li>
                              <a href="lake-masek-tented-lodge.html"
                                >Lake Masek Tented Lodge</a
                              >
                            </li>
                            <li>
                              <a href="woodlands-camp.html">Woodlands Camp</a>
                            </li>
                            <li>
                              <a href="serengeti-under-canvas-south.html"
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
                              <a href="mbuzi-mawe-tented-lodge.html"
                                >Mbuzi Mawe Tented Lodge</a
                              >
                            </li>
                            <li>
                              <a href="serengeti-serena-lodge.html"
                                >Serengeti Serena Lodge</a
                              >
                            </li>
                            <li>
                              <a href="four-seasons-lodge.html"
                                >Four Seasons Lodge</a
                              >
                            </li>
                            <li>
                              <a href="private-mobile-camp.html"
                                >Private Mobile Camp</a
                              >
                            </li>
                            <li>
                              <a href="kubu-kubu-tented-lodge.html"
                                >Kubu Kubu Tented Lodge</a
                              >
                            </li>
                            <li>
                              <a href="serengeti-pioneer-camp.html"
                                >Serengeti Pioneer Camp</a
                              >
                            </li>
                            <li>
                              <a href="nimali-serengeti-lodge.html"
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
                              <a href="plantation-lodge.html"
                                >Plantation Lodge</a
                              >
                            </li>
                            <li><a href="gibbs-farm.html">Gibbs Farm</a></li>
                            <li>
                              <a href="the-manor-at-ngorongoro.html"
                                >The Manor at Ngorongoro</a
                              >
                            </li>
                            <li>
                              <a href="neptune-lodge.html">Neptune Lodge</a>
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
                              <a href="ngorongoro-crater-lodge.html"
                                >Ngorongoro Crater Lodge</a
                              >
                            </li>
                            <li>
                              <a href="ngorongoro-serena-lodge.html"
                                >Ngorongoro Serena Lodge</a
                              >
                            </li>
                            <li>
                              <a href="lions-paw-camp.html"
                                >Lion&#039;s Paw Camp</a
                              >
                            </li>
                            <li>
                              <a href="craters-edge-lodge.html"
                                >Crater&#039;s Edge Lodge</a
                              >
                            </li>
                            <li>
                              <a href="ngorongoro-melia-lodge.html"
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
                              <a href="swala-tented-lodge.html"
                                >Swala Tented Lodge</a
                              >
                            </li>
                            <li>
                              <a href="tarangire-treetops-lodge.html"
                                >Tarangire Treetops Lodge</a
                              >
                            </li>
                            <li>
                              <a href="kikoti-tented-lodge.html"
                                >Kikoti Tented Lodge</a
                              >
                            </li>
                            <li>
                              <a href="mpingo-ridge-lodge.html"
                                >Mpingo Ridge Lodge
                              </a>
                            </li>
                            <li>
                              <a href="maramboi-tented-lodge.html"
                                >Maramboi Tented Lodge</a
                              >
                            </li>
                            <li>
                              <a href="elephant-springs.html"
                                >Elephant Springs</a
                              >
                            </li>
                            <li>
                              <a href="kuro-treetops-lodge.html"
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
                              <a href="mount-meru-resort.html"
                                >Mount Meru Resort</a
                              >
                            </li>
                            <li>
                              <a href="arusha-coffee-lodge.html"
                                >Arusha Coffee Lodge</a
                              >
                            </li>
                            <li>
                              <a href="lake-duluti-lodge.html"
                                >Lake Duluti Lodge</a
                              >
                            </li>
                            <li>
                              <a href="kili-seasons-hotel.html"
                                >Kili Seasons Hotel</a
                              >
                            </li>
                            <li>
                              <a href="kili-private-villas.html"
                                >Kili Private Villas</a
                              >
                            </li>
                            <li>
                              <a href="gran-melia-arusha.html"
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
                <a class="" href="media/videos.html">Galleries</a>

                <div class="dropdown-menu">
                  <ul class="list-unstyled">
                    <li class="menu-section first">
                      <a href="media/videos.html">
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
                      <a href="media/photos.html">
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
              <li><a class="" href="awards-and-press.html">Awards</a></li>
              <li><a class="" href="maps/tanzania.html">Map</a></li>
              <li><a class="" href="community.html">Local Partnerships</a></li>
              <li>
                <a
                  class=""
                  href="http://blog.africadreamsafaris.com/"
                  target="_blank"
                  >Blog</a
                >
              </li>
              <li><a class="" href="faq.html">FAQ</a></li>
              <li>
                <a href="safari-details/photographic-ambassador.html"
                  >Expert Photo Tips</a
                >
              </li>
              <li id="header-search-form">
                <form
                  action="https://www.africadreamsafaris.com/search"
                  method="get"
                >
                  <div class="search-input-icon">
                    <svg viewBox="0 0 15.8 15.8">
                      <use
                        xmlns:xlink="http://www.w3.org/1999/xlink"
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
              <a href="company-overview/letter-from-the-founder.html">About</a>
            </li>
            <li class="nav-submenu-header"><a>Company Overview</a></li>
            <li class="nav-submenu-link">
              <a href="company-overview/letter-from-the-founder.html"
                >Letter from the Founder</a
              >
            </li>
            <li class="nav-submenu-link">
              <a href="company-overview/why-were-different.html"
                >Why We're Different</a
              >
            </li>
            <li class="nav-submenu-link">
              <a href="company-overview/tanzania-specialists.html"
                >We Specialize in Tanzania</a
              >
            </li>
            <li class="nav-submenu-link">
              <a href="company-overview/meet-our-safari-experts.html"
                >Meet Our Safari Experts</a
              >
            </li>
            <li class="nav-submenu-link">
              <a href="company-overview/private-safari-advantage.html"
                >Private Safari Advantage</a
              >
            </li>
            <li class="nav-submenu-link">
              <a href="company-overview/personalized-itineraries.html"
                >Personalized Itineraries</a
              >
            </li>
            <li class="nav-submenu-link">
              <a href="company-overview/wildlife-viewing-maximized.html"
                >Wildlife Viewing Maximized</a
              >
            </li>
            <li class="nav-submenu-header"><a>Safari Details</a></li>
            <li class="nav-submenu-link">
              <a href="safari-details/driver-guides.html">Driver Guides</a>
            </li>
            <li class="nav-submenu-link">
              <a href="safari-details/vehicle-specifications.html"
                >Vehicle Specifications</a
              >
            </li>
            <li class="nav-submenu-link">
              <a href="safari-details/seasonal-highlights.html"
                >Seasonal Highlights</a
              >
            </li>
            <li class="nav-submenu-link">
              <a href="safari-details/inclusions-and-exclusions.html"
                >Inclusions & Exclusions</a
              >
            </li>
            <li class="nav-submenu-link">
              <a href="safari-details/itinerary-design-and-recommendations.html"
                >Itinerary Design & Recommendations
              </a>
            </li>
            <li class="nav-submenu-link">
              <a href="safari-details/safety.html">Safari Safety</a>
            </li>
            <li class="nav-submenu-link">
              <a href="safari-details/photographic-ambassador.html"
                >Our Photographic Ambassador</a
              >
            </li>
            <li class="nav-submenu-header"><a>Trip Enhancements</a></li>
            <li class="nav-submenu-link">
              <a href="trip-enhancements/cultural-tour.html">Cultural Tour</a>
            </li>
            <li class="nav-submenu-link">
              <a href="trip-enhancements/balloon-safari.html">Balloon Safari</a>
            </li>
            <li class="nav-submenu-link">
              <a href="trip-enhancements/arusha-layover.html">Arusha Layover</a>
            </li>
            <li class="nav-submenu-link">
              <a href="trip-enhancements/walking-safari.html">Walking Safari</a>
            </li>
            <li class="nav-submenu-link">
              <a href="trip-enhancements/night-game-drive.html"
                >Night Game Drive</a
              >
            </li>
            <li class="nav-submenu-link">
              <a href="trip-enhancements/junior-game-ranger-challenge.html"
                >Junior Game Ranger</a
              >
            </li>
            <li class="nav-submenu-link">
              <a href="trip-enhancements/charitable-visits.html"
                >Charitable Visits</a
              >
            </li>
            <li class="nav-submenu-link">
              <a href="trip-enhancements/serengeti-lion-project.html"
                >Serengeti Lion Project</a
              >
            </li>
            <li class="nav-submenu-header"><a>Booking And Flights</a></li>
            <li class="nav-submenu-link">
              <a href="booking-and-flights/booking-security.html"
                >Booking Security</a
              >
            </li>
            <li class="nav-submenu-link">
              <a href="booking-and-flights/flexible-travel-and-payment.html"
                >Flexible Travel & Payment</a
              >
            </li>
            <li class="nav-submenu-link">
              <a href="booking-and-flights/booking-terms-and-conditions.html"
                >Booking Terms & Conditions</a
              >
            </li>
            <li class="nav-submenu-link">
              <a href="booking-and-flights/international-flight-routing.html"
                >International Flight Routing</a
              >
            </li>
          </ul>

          <ul class="list-unstyled" id="nav-submenu-regions">
            <li class="nav-submenu-name">
              <a href="maps/tanzania.html">Regions</a>
            </li>

            <li class="nav-submenu-buttons">
              <a class="btn btn-primary" href="maps/tanzania.html"
                >Search by Map <i class="fa fa-chevron-right"></i
              ></a>
            </li>

            <li class="nav-submenu-header">
              <a href="serengeti-national-park.html">Serengeti National Park</a>
            </li>
            <li class="nav-submenu-link">
              <a href="north-serengeti.html">North Serengeti</a>
            </li>
            <li class="nav-submenu-link">
              <a href="west-serengeti.html">West Serengeti</a>
            </li>
            <li class="nav-submenu-link">
              <a href="central-serengeti.html">Central Serengeti</a>
            </li>
            <li class="nav-submenu-link">
              <a href="east-serengeti.html">East Serengeti</a>
            </li>
            <li class="nav-submenu-link">
              <a href="south-serengeti.html">South Serengeti</a>
            </li>
            <li class="nav-submenu-header">
              <a href="ngorongoro-conservation-area.html"
                >Ngorongoro Conservation Area</a
              >
            </li>
            <li class="nav-submenu-link">
              <a href="lake-magadi.html">Lake Magadi</a>
            </li>
            <li class="nav-submenu-link">
              <a href="central-plains.html">Central Plains</a>
            </li>
            <li class="nav-submenu-link">
              <a href="lerai-forest.html">Lerai Forest</a>
            </li>
            <li class="nav-submenu-link">
              <a href="rumbe-hills.html">Rumbe Hills</a>
            </li>
            <li class="nav-submenu-link">
              <a href="munge-stream.html">Munge Stream</a>
            </li>
            <li class="nav-submenu-link">
              <a href="mandusi-swamp.html">Mandusi Swamp</a>
            </li>
            <li class="nav-submenu-link">
              <a href="gorigor-swamp.html">Gorigor Swamp</a>
            </li>
            <li class="nav-submenu-link">
              <a href="ngoitokitok-springs.html">Ngoitokitok Springs</a>
            </li>
            <li class="nav-submenu-header">
              <a href="lake-manyara-national-park.html"
                >Lake Manyara National Park</a
              >
            </li>
            <li class="nav-submenu-link">
              <a href="ground-water-forest.html">Ground Water Forest</a>
            </li>
            <li class="nav-submenu-link">
              <a href="acacia-woodlands.html">Acacia Woodlands</a>
            </li>
            <li class="nav-submenu-link">
              <a href="floodplains.html">Floodplains</a>
            </li>
            <li class="nav-submenu-link">
              <a href="lake-manyara.html">Lake Manyara</a>
            </li>
            <li class="nav-submenu-header">
              <a href="tarangire-national-park.html">Tarangire National Park</a>
            </li>
            <li class="nav-submenu-link">
              <a href="tarangire-river.html">Tarangire River</a>
            </li>
            <li class="nav-submenu-link">
              <a href="lemiyon-triangle.html">Lemiyon Triangle</a>
            </li>
            <li class="nav-submenu-link">
              <a href="matete-woodlands.html">Matete Woodlands</a>
            </li>
            <li class="nav-submenu-link">
              <a href="silale-swamp.html">Silale Swamp</a>
            </li>
            <li class="nav-submenu-link">
              <a href="burungi-circuit.html">Burungi Circuit</a>
            </li>
            <li class="nav-submenu-link">
              <a href="kitibong-hill.html">Kitibong Hill</a>
            </li>
            <li class="nav-submenu-header"><a href="arusha.html">Arusha</a></li>
          </ul>

          <ul class="list-unstyled" id="nav-submenu-lodging">
            <li class="nav-submenu-name"><a href="lodging.html">Lodging</a></li>

            <li class="nav-submenu-buttons">
              <a class="btn btn-primary" href="lodging.html"
                >Search by Style <i class="fa fa-chevron-right"></i
              ></a>
              <a class="btn btn-primary" href="maps/tanzania.html"
                >Search by Map <i class="fa fa-chevron-right"></i
              ></a>
            </li>

            <li class="nav-submenu-header"><a>North Serengeti</a></li>
            <li class="nav-submenu-link">
              <a href="migration-tented-lodge.html">Migration Tented Lodge</a>
            </li>
            <li class="nav-submenu-link">
              <a href="lemala-mara-river-camp.html">Lemala Mara River Camp</a>
            </li>
            <li class="nav-submenu-link">
              <a href="kuria-hills-lodge.html">Kuria Hills Lodge</a>
            </li>
            <li class="nav-submenu-link">
              <a href="river-camp.html">River Camp</a>
            </li>
            <li class="nav-submenu-link">
              <a href="taasa-lodge.html">Taasa Lodge</a>
            </li>
            <li class="nav-submenu-link">
              <a href="serengeti-under-canvas-north.html"
                >N. Serengeti Under Canvas</a
              >
            </li>
            <li class="nav-submenu-link">
              <a href="nimali-mara-lodge.html">Nimali Mara Lodge</a>
            </li>
            <li class="nav-submenu-header"><a>West Serengeti</a></li>
            <li class="nav-submenu-link">
              <a href="mbalageti-tented-lodge.html">Mbalageti Tented Lodge</a>
            </li>
            <li class="nav-submenu-link">
              <a href="kirawira-tented-lodge.html">Kirawira Tented Lodge</a>
            </li>
            <li class="nav-submenu-link">
              <a href="grumeti-river-lodge.html">Grumeti River Lodge</a>
            </li>
            <li class="nav-submenu-link">
              <a href="lahia-tented-lodge.html">Lahia Tented Lodge</a>
            </li>
            <li class="nav-submenu-header"><a>South Serengeti</a></li>
            <li class="nav-submenu-link">
              <a href="ndutu-lodge.html">Ndutu Lodge</a>
            </li>
            <li class="nav-submenu-link">
              <a href="lake-masek-tented-lodge.html">Lake Masek Tented Lodge</a>
            </li>
            <li class="nav-submenu-link">
              <a href="woodlands-camp.html">Woodlands Camp</a>
            </li>
            <li class="nav-submenu-link">
              <a href="serengeti-under-canvas-south.html"
                >S. Serengeti Under Canvas</a
              >
            </li>
            <li class="nav-submenu-header"><a>Central Serengeti</a></li>
            <li class="nav-submenu-link">
              <a href="mbuzi-mawe-tented-lodge.html">Mbuzi Mawe Tented Lodge</a>
            </li>
            <li class="nav-submenu-link">
              <a href="serengeti-serena-lodge.html">Serengeti Serena Lodge</a>
            </li>
            <li class="nav-submenu-link">
              <a href="four-seasons-lodge.html">Four Seasons Lodge</a>
            </li>
            <li class="nav-submenu-link">
              <a href="private-mobile-camp.html">Private Mobile Camp</a>
            </li>
            <li class="nav-submenu-link">
              <a href="kubu-kubu-tented-lodge.html">Kubu Kubu Tented Lodge</a>
            </li>
            <li class="nav-submenu-link">
              <a href="serengeti-pioneer-camp.html">Serengeti Pioneer Camp</a>
            </li>
            <li class="nav-submenu-link">
              <a href="nimali-serengeti-lodge.html">Nimali Serengeti Lodge</a>
            </li>
            <li class="nav-submenu-header"><a>East Serengeti</a></li>
            <li class="nav-submenu-link">
              <a href="sametu-camp.html">Sametu Camp</a>
            </li>
            <li class="nav-submenu-link">
              <a href="nanyukie-tented-lodge.html">Nanyukie Tented Lodge</a>
            </li>
            <li class="nav-submenu-header">
              <a>Lake Manyara National Park</a>
            </li>
            <li class="nav-submenu-link">
              <a href="plantation-lodge.html">Plantation Lodge</a>
            </li>
            <li class="nav-submenu-link">
              <a href="gibbs-farm.html">Gibbs Farm</a>
            </li>
            <li class="nav-submenu-link">
              <a href="the-manor-at-ngorongoro.html">The Manor at Ngorongoro</a>
            </li>
            <li class="nav-submenu-link">
              <a href="neptune-lodge.html">Neptune Lodge</a>
            </li>
            <li class="nav-submenu-header">
              <a>Ngorongoro Conservation Area</a>
            </li>
            <li class="nav-submenu-link">
              <a href="ngorongoro-crater-lodge.html">Ngorongoro Crater Lodge</a>
            </li>
            <li class="nav-submenu-link">
              <a href="ngorongoro-serena-lodge.html">Ngorongoro Serena Lodge</a>
            </li>
            <li class="nav-submenu-link">
              <a href="lions-paw-camp.html">Lion's Paw Camp</a>
            </li>
            <li class="nav-submenu-link">
              <a href="craters-edge-lodge.html">Crater's Edge Lodge</a>
            </li>
            <li class="nav-submenu-link">
              <a href="ngorongoro-melia-lodge.html">Ngorongoro Melia Lodge</a>
            </li>
            <li class="nav-submenu-header"><a>Tarangire National Park</a></li>
            <li class="nav-submenu-link">
              <a href="swala-tented-lodge.html">Swala Tented Lodge</a>
            </li>
            <li class="nav-submenu-link">
              <a href="tarangire-treetops-lodge.html"
                >Tarangire Treetops Lodge</a
              >
            </li>
            <li class="nav-submenu-link">
              <a href="kikoti-tented-lodge.html">Kikoti Tented Lodge</a>
            </li>
            <li class="nav-submenu-link">
              <a href="mpingo-ridge-lodge.html">Mpingo Ridge Lodge </a>
            </li>
            <li class="nav-submenu-link">
              <a href="maramboi-tented-lodge.html">Maramboi Tented Lodge</a>
            </li>
            <li class="nav-submenu-link">
              <a href="elephant-springs.html">Elephant Springs</a>
            </li>
            <li class="nav-submenu-link">
              <a href="kuro-treetops-lodge.html">Kuro Treetops Lodge</a>
            </li>
            <li class="nav-submenu-header"><a>Arusha</a></li>
            <li class="nav-submenu-link">
              <a href="mount-meru-resort.html">Mount Meru Resort</a>
            </li>
            <li class="nav-submenu-link">
              <a href="arusha-coffee-lodge.html">Arusha Coffee Lodge</a>
            </li>
            <li class="nav-submenu-link">
              <a href="lake-duluti-lodge.html">Lake Duluti Lodge</a>
            </li>
            <li class="nav-submenu-link">
              <a href="kili-seasons-hotel.html">Kili Seasons Hotel</a>
            </li>
            <li class="nav-submenu-link">
              <a href="kili-private-villas.html">Kili Private Villas</a>
            </li>
            <li class="nav-submenu-link">
              <a href="gran-melia-arusha.html">Gran Melia Arusha</a>
            </li>
          </ul>

          <ul class="list-unstyled" id="nav-submenu-local-partnerships">
            <li class="nav-submenu-name">
              <a href="lodging.html">Local Partnerships</a>
            </li>

            <li class="nav-submenu-header"><a>Overview</a></li>
            <li class="nav-submenu-link">
              <a
                href="community/overview/together-we-can-make-a-difference.html"
                >Together We Can Make a Difference</a
              >
            </li>
            <li class="nav-submenu-header"><a>Conservation</a></li>
            <li class="nav-submenu-link">
              <a href="community/conservation/serengeti-lion-project.html"
                >Serengeti Lion Project</a
              >
            </li>
            <li class="nav-submenu-link">
              <a href="community/conservation/serengeti-cheetah-project.html"
                >Serengeti Cheetah Project</a
              >
            </li>
            <li class="nav-submenu-header"><a>Humanitarian</a></li>
            <li class="nav-submenu-link">
              <a href="community/humanitarian/school-of-st-jude.html"
                >School of St. Jude</a
              >
            </li>
            <li class="nav-submenu-link">
              <a
                href="community/humanitarian/foundation-for-african-medicine-education.html"
                >Foundation for African Medicine & Education</a
              >
            </li>
            <li class="nav-submenu-link">
              <a href="community/humanitarian/peace-house-orphanage.html"
                >Peace House Orphanage</a
              >
            </li>
            <li class="nav-submenu-link">
              <a href="community/humanitarian/poli-village-school.html"
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