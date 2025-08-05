/*	-----------------------------------------------------------------------------
  GLOBAL VARIABLES
--------------------------------------------------------------------------------- */

const easeInOut = "power3.inOut",
  easeOut = "power1.out",
  easeIn = "power1.in",
  easeNone = "none",
  duration = 0.7,
  durationSlow = 1.3,
  durationFast = 0.3,
  start = "top 75%",
  startScrub = "top bottom",
  startPin = "top top",
  scale = 1.5;

// Device and connection detection for optimal video loading
const deviceInfo = {
  isMobile:
    window.innerWidth <= 768 ||
    /Android|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(
      navigator.userAgent
    ),
  isLowEnd: navigator.hardwareConcurrency <= 2 || navigator.deviceMemory <= 2,
  isSlowConnection:
    navigator.connection &&
    (navigator.connection.effectiveType === "2g" ||
      navigator.connection.effectiveType === "slow-2g"),
  prefersReducedData: navigator.connection && navigator.connection.saveData,
};

gsap.registerPlugin(ScrollTrigger, SplitText);

/*	-----------------------------------------------------------------------------
  GLOBAL SCROLLTRIGGER RESIZE HANDLER
--------------------------------------------------------------------------------- */

// Global registry for components with custom resize handlers
window.ScrollTriggerComponents = {
  customResizeHandlers: new Set(),

  // Register a component that handles its own resize
  registerCustomHandler: function (name) {
    this.customResizeHandlers.add(name);
  },

  // Check if a component has custom resize handling
  hasCustomHandler: function (name) {
    return this.customResizeHandlers.has(name);
  },
};

// Global debounced resize handler for ScrollTrigger refresh
(function () {
  let resizeTimeout;

  // Debounce function for resize events
  function debounce(func, delay) {
    return function (...args) {
      clearTimeout(resizeTimeout);
      resizeTimeout = setTimeout(() => func.apply(this, args), delay);
    };
  }

  // Handle window resize with ScrollTrigger refresh
  function handleGlobalResize() {
    // Use requestAnimationFrame for optimal performance
    requestAnimationFrame(() => {
      // Only refresh ScrollTriggers that don't have custom handlers
      // Custom handlers will manage their own ScrollTriggers
      ScrollTrigger.refresh();

      // Dispatch custom event for components that need special resize handling
      window.dispatchEvent(new CustomEvent("scrolltrigger:resize"));
    });
  }

  // Create debounced resize handler with 250ms delay (industry standard)
  const debouncedResize = debounce(handleGlobalResize, 250);

  // Add resize listener
  window.addEventListener("resize", debouncedResize);

  // Optional: Handle orientation change for mobile devices
  window.addEventListener("orientationchange", () => {
    // Slight delay for orientation change to complete
    setTimeout(() => {
      debouncedResize();
    }, 100);
  });
})();

/*	-----------------------------------------------------------------------------
  GLOBAL FUNCTIONS
--------------------------------------------------------------------------------- */

// Menu Height Setup
(function () {
  document.addEventListener("DOMContentLoaded", () => {
    const menu = document.querySelector("header");
    if (menu) {
      const menuHeight = menu.offsetHeight;
      document.documentElement.style.setProperty(
        "--menu-height",
        `${menuHeight}px`
      );
    }
  });
})();

/*	-----------------------------------------------------------------------------
  SWIPER
--------------------------------------------------------------------------------- */

(function () {
  const swiper = new Swiper(".swiper", {
    slidesPerView: "auto",
    loop: true,
    centeredSlides: true,
    speed: 600,
    navigation: {
      nextEl: ".swiper-button-next",
      prevEl: ".swiper-button-prev",
    },
  });
})();

/*	-----------------------------------------------------------------------------
  LENIS
--------------------------------------------------------------------------------- */

// Make lenis globally accessible
let lenis;

(function () {
  lenis = new Lenis();

  lenis.on("scroll", ScrollTrigger.update);

  gsap.ticker.add((time) => {
    lenis.raf(time * 1000);
  });

  gsap.ticker.lagSmoothing(0);
})();

/*	-----------------------------------------------------------------------------
  SCROLL TRIGGERS
--------------------------------------------------------------------------------- */

(function () {
  // Word-by-Word Text Animations (Headlines, Titles)
  function initWordAnimations() {
    const textElements = document.querySelectorAll("[data-animate-words]");

    textElements.forEach((element) => {
      // Split into words only to preserve inline elements like <em>
      const splitText = new SplitText(element, {
        type: "words",
        wordsClass: "split-word",
        tag: "span",
      });

      // Set initial state - opacity 0 and blur
      gsap.set(splitText.words, {
        opacity: 0,
        filter: "blur(8px)",
      });

      ScrollTrigger.create({
        trigger: element,
        start: start,
        onEnter: () => {
          gsap.to(splitText.words, {
            opacity: 1,
            filter: "blur(0px)",
            duration: 0.6,
            ease: easeOut,
            stagger: 0.05, // Faster stagger - was 0.08
            onComplete: () => {
              element.classList.add("animate-in");
            },
          });
        },
      });
    });
  }

  // Block Text Animations (Descriptions, Paragraphs - no splitting)
  function initBlockAnimations() {
    const textElements = document.querySelectorAll("[data-animate-block]");

    textElements.forEach((element) => {
      // Set initial state - opacity 0 and blur for entire element
      gsap.set(element, {
        opacity: 0,
        filter: "blur(8px)",
      });

      ScrollTrigger.create({
        trigger: element,
        start: start,
        onEnter: () => {
          gsap.to(element, {
            opacity: 1,
            filter: "blur(0px)",
            duration: 0.8, // Slightly longer for unified animation
            ease: easeOut,
            onComplete: () => {
              element.classList.add("animate-in");
            },
          });
        },
      });
    });
  }

  // Line-by-Line Text Animations (Body Text, Articles)
  function initLineAnimations() {
    const textElements = document.querySelectorAll("[data-animate-lines]");

    textElements.forEach((element) => {
      // Find all paragraph elements inside the container
      const paragraphs = element.querySelectorAll("p");
      const allLines = [];

      // Split each paragraph into lines
      paragraphs.forEach((paragraph) => {
        const splitText = new SplitText(paragraph, {
          type: "lines",
          linesClass: "split-line",
          tag: "div",
        });
        allLines.push(...splitText.lines);
      });

      // If no paragraphs found, split the container directly
      if (paragraphs.length === 0) {
        const splitText = new SplitText(element, {
          type: "lines",
          linesClass: "split-line",
          tag: "div",
        });
        allLines.push(...splitText.lines);
      }

      // Set initial state - opacity 0 and slide up
      gsap.set(allLines, {
        opacity: 0,
        y: 24, // Subtle slide up effect
      });

      ScrollTrigger.create({
        trigger: element,
        start: start,
        onEnter: () => {
          gsap.to(allLines, {
            opacity: 1,
            y: 0,
            duration: 1,
            ease: easeOut,
            stagger: 0.08,
            onComplete: () => {
              element.classList.add("animate-in");
            },
          });
        },
      });
    });
  }

  // Image Load-In Animations (with clip-path reveal and scale)
  function initImageAnimations() {
    const imageElements = document.querySelectorAll("[data-animate-image]");

    imageElements.forEach((element) => {
      // Set initial state - clipped from bottom and slightly scaled up
      gsap.set(element, {
        clipPath: "inset(0% 0% 100% 0%)", // Fully clipped from bottom
        scale: 1.05, // Slightly zoomed in
      });

      ScrollTrigger.create({
        trigger: element,
        start: start,
        onEnter: () => {
          gsap.to(element, {
            clipPath: "inset(0% 0% 0% 0%)", // Reveal fully
            scale: 1, // Normal scale
            duration: 1, // Slightly longer for dramatic effect
            ease: easeInOut,
            onComplete: () => {
              element.classList.add("animate-in");
            },
          });
        },
      });
    });
  }

  window.addEventListener("load", () => {
    initWordAnimations();
    initBlockAnimations();
    initLineAnimations();
    initImageAnimations();
  });
})();

/*	-----------------------------------------------------------------------------
  HERO
--------------------------------------------------------------------------------- */

(function () {
  window.addEventListener("load", () => {
    const section = document.querySelector(".hero");

    if (!section) return;

    const header = document.querySelector("header");
    const preload = section.querySelector(".hero__preload");
    const preloadImages = section.querySelectorAll(".hero__preload-image");
    const background = section.querySelector(".hero__background");
    const backgroundOverlay = section.querySelector(
      ".hero__background-overlay"
    );
    const backgroundMedia = background.querySelector("img, video");
    const preHeading = section.querySelector(".hero__pre-heading");
    const heading = section.querySelector(".hero__heading");
    const description = section.querySelector(".hero__description");
    const cta = section.querySelector(".hero__cta");
    const playButton = section.querySelector(".hero__play-button");

    // Store reference to hero scroll trigger for resize handling
    let heroScrollTrigger;

    // Function to create hero scroll trigger
    function createHeroScrollTrigger() {
      // Kill existing trigger if it exists
      if (heroScrollTrigger) {
        heroScrollTrigger.kill();
      }

      // Create timeline for scroll animations
      const scrollTimeline = gsap.timeline();
      scrollTimeline
        .to(background, {
          scale: 1.5,
        })
        .to(
          section,
          {
            filter: "blur(10px)",
            yPercent: 25,
          },
          0
        ); // Start at the same time (0 position)

      heroScrollTrigger = ScrollTrigger.create({
        trigger: section,
        scrub: true,
        start: () => {
          const navbar = document.querySelector(".navbar");
          return `top ${navbar.offsetHeight}px`;
        },
        animation: scrollTimeline,
      });
    }

    const splitWords = new SplitText(heading, {
      type: "words",
      wordsClass: "split-word",
      tag: "span",
    });

    if (preloadImages) {
      lenis.scrollTo(0, { immediate: true });
      lenis.stop();
      gsap.set(header, {
        yPercent: -100,
      });
      gsap.set(preload, {
        scale: 0.5,
      });
      gsap.set(preloadImages, {
        scale: 1.2,
        clipPath: "inset(0% 0% 100% 0%)",
      });
      gsap.set(backgroundOverlay, {
        opacity: 0,
      });
      gsap.set(background, {
        scale: 0.5,
      });
      gsap.set(backgroundMedia, {
        scale: 1.2,
        clipPath: "inset(0% 0% 100% 0%)",
      });
      gsap.set(preHeading, {
        opacity: 0,
        filter: "blur(8px)",
      });
      gsap.set(splitWords.words, {
        opacity: 0,
        filter: "blur(8px)",
      });
      gsap.set(description, {
        opacity: 0,
        filter: "blur(8px)",
      });
      gsap.set(cta, {
        opacity: 0,
        filter: "blur(8px)",
      });
      gsap.set(playButton, {
        opacity: 0,
        filter: "blur(8px)",
      });

      var tl = gsap.timeline({
        onComplete: () => {
          // Start lenis and create hero scroll trigger
          lenis.start();
          createHeroScrollTrigger();
        },
      });
      preloadImages.forEach((image, index) => {
        tl.to(image, {
          clipPath: "inset(0% 0% 0% 0%)",
          scale: 1,
          duration: 0.5,
          ease: easeOut,
          delay: index !== 0 ? 0.3 : 0,
        });
      });
      tl.to(backgroundMedia, {
        clipPath: "inset(0% 0% 0% 0%)",
        scale: 1,
        duration: 0.5,
        ease: easeOut,
        delay: 0.3,
      });
      tl.add(() => {
        backgroundMedia.play();
      }, "<50%");
      tl.to(background, {
        scale: 1,
        duration: 0.8,
        ease: easeInOut,
        delay: 0.3,
      });
      tl.to(
        header,
        {
          yPercent: 0,
          duration: 0.8,
          ease: easeInOut,
        },
        "<"
      );
      tl.to(
        backgroundOverlay,
        {
          opacity: 0.6,
          duration: 0.8,
          ease: easeInOut,
        },
        "<"
      );
      tl.to(splitWords.words, {
        opacity: 1,
        filter: "blur(0px)",
        duration: 0.6,
        ease: easeOut,
        stagger: 0.05,
      });
      tl.to(
        preHeading,
        {
          opacity: 1,
          filter: "blur(0px)",
          duration: 0.8,
          ease: easeOut,
        },
        "<50%"
      );
      tl.to(
        description,
        {
          opacity: 1,
          filter: "blur(0px)",
          duration: 0.8,
          ease: easeOut,
        },
        "<"
      );
      tl.to(
        cta,
        {
          opacity: 1,
          filter: "blur(0px)",
          duration: 0.8,
          ease: easeOut,
        },
        "<"
      );
      tl.to(
        playButton,
        {
          opacity: 1,
          filter: "blur(0px)",
          duration: 0.8,
          ease: easeOut,
        },
        "<"
      );
      tl.add(() => {
        preload.remove();
      });
    }

    if (playButton) {
      playButton.addEventListener("click", () => {
        section.classList.add("hero--playing");
        gsap.to(backgroundOverlay, {
          opacity: 0,
          duration: 0.4,
          ease: easeOut,
        });
      });
      background.addEventListener("click", () => {
        section.classList.remove("hero--playing");
        gsap.to(backgroundOverlay, {
          opacity: 0.6,
          duration: 0.4,
          ease: easeOut,
        });
      });
    }

    // Add resize handler for hero scroll trigger
    window.addEventListener("scrolltrigger:resize", () => {
      if (heroScrollTrigger) {
        createHeroScrollTrigger();
      }
    });
  });
})();

/*	-----------------------------------------------------------------------------
  HORIZONTAL GALLERY
--------------------------------------------------------------------------------- */

(function () {
  // Register horizontal gallery as having custom resize handling
  window.ScrollTriggerComponents.registerCustomHandler("horizontal-gallery");

  window.addEventListener("load", () => {
    const section = document.querySelector(".horizontal-gallery");

    if (!section) return;

    const container = section.querySelector(".horizontal-gallery__container");
    const images = section.querySelectorAll(".horizontal-gallery__media");
    const background = section.querySelector(
      ".horizontal-gallery__background-image"
    );

    let horizontalScrollTrigger;
    let resizeTimeout;

    if (background) {
      gsap.set(background, {
        opacity: 0,
        xPercent: 100,
      });

      ScrollTrigger.create({
        trigger: background,
        start: "top 60%",
        onEnter: () => {
          gsap.to(background, {
            opacity: 1,
            xPercent: 0,
            duration: 0.6,
            ease: easeOut,
          });
        },
      });
    }

    // Calculate dimensions
    function calculateDimensions() {
      return {
        containerWidth: container.scrollWidth,
        windowWidth: window.innerWidth,
      };
    }

    // Initialize horizontal scroll
    function initHorizontalScroll() {
      // Kill existing trigger if it exists
      if (horizontalScrollTrigger) {
        horizontalScrollTrigger.kill();
      }

      // Reset container position and force layout recalculation
      gsap.set(container, { x: 0 });
      container.offsetWidth;

      const { containerWidth, windowWidth } = calculateDimensions();

      // Create new horizontal scroll trigger
      horizontalScrollTrigger = ScrollTrigger.create({
        trigger: section,
        start: "50% bottom",
        end: "top top",
        scrub: 1.2,
        animation: gsap.to(container, {
          x: window.innerWidth > 768 ? windowWidth - containerWidth : -500,
          ease: "none",
        }),
      });
    }
    // Debounced resize handler
    function handleResize() {
      clearTimeout(resizeTimeout);
      resizeTimeout = setTimeout(() => {
        requestAnimationFrame(() => {
          initHorizontalScroll();
          if (horizontalScrollTrigger) {
            horizontalScrollTrigger.refresh();
          }
        });
      }, 250);
    }

    // Set initial state for all images
    gsap.set(images, {
      y: "40%",
      scale: 1.1,
      opacity: 0,
    });

    // Image animation (runs once)
    ScrollTrigger.create({
      trigger: container,
      start: start,
      onEnter: () => {
        const tl = gsap.timeline();

        tl.to(images, {
          y: (index) => (index % 2 === 0 ? "0%" : "-5%"),
          opacity: 1,
          duration: 0.3,
          ease: easeOut,
          stagger: 0.05,
        }).to(
          images,
          {
            scale: 1,
            duration: 0.6,
            ease: easeInOut,
            stagger: 0.1,
          },
          "-=0.2"
        );
      },
    });

    // Initialize horizontal scroll
    initHorizontalScroll();

    // Add resize listener
    window.addEventListener("resize", handleResize);
  });
})();

/*	-----------------------------------------------------------------------------
  EXPERIENCE PATHS
--------------------------------------------------------------------------------- */

(function () {
  window.addEventListener("load", () => {
    const section = document.querySelector(".experience-paths");

    if (!section) return;

    const paths = section.querySelectorAll(".experience-paths__path");
    const line = section.querySelector(".experience-paths__line");
    const backgrounds = section.querySelectorAll(
      ".experience-paths__background-image"
    );

    paths.forEach((path) => {
      gsap.set(path, {
        opacity: 0,
      });

      ScrollTrigger.create({
        trigger: path,
        start: "top 60%",
        once: true,
        onEnter: () => {
          const tl = gsap.timeline();
          tl.to(path, {
            opacity: 1,
            scale: 1.1,
            duration: 0.4,
            ease: easeOut,
          }).to(path, {
            scale: 1,
            duration: 0.4,
            ease: easeInOut,
            onComplete: () => {
              path.classList.add("animate-in");
            },
          });
        },
      });
    });

    if (backgrounds) {
      backgrounds.forEach((background, index) => {
        gsap.set(background, {
          opacity: 0,
          xPercent: index % 2 === 0 ? -100 : 100,
        });

        ScrollTrigger.create({
          trigger: background,
          start: "top 60%",
          onEnter: () => {
            gsap.to(background, {
              opacity: 1,
              xPercent: 0,
              duration: 0.6,
              ease: easeOut,
            });
          },
        });
      });
    }

    if (line) {
      const path = line.querySelector("path");
      if (path) {
        gsap.set(path, {
          clipPath: "inset(0% 0% 100% 0%)",
        });

        ScrollTrigger.create({
          trigger: path,
          start: "top 80%",
          end: "bottom center",
          scrub: 1,
          animation: gsap.to(path, {
            clipPath: "inset(0% 0% 0% 0%)",
            ease: "none",
          }),
        });
      }
    }
  });
})();

/*	-----------------------------------------------------------------------------
  PROCESS
--------------------------------------------------------------------------------- */

(function () {
  window.addEventListener("load", () => {
    const section = document.querySelector(".process");

    if (!section) return;

    const container = section.querySelector(".process__steps");
    const steps = section.querySelectorAll(".process__step");

    gsap.set(steps, {
      opacity: 0,
      xPercent: 20,
    });

    ScrollTrigger.create({
      trigger: container,
      start: start,
      onEnter: () => {
        gsap.to(steps, {
          xPercent: 0,
          duration: 0.6,
          ease: easeOut,
          stagger: 0.1,
        });

        gsap.to(steps, {
          opacity: 1,
          duration: 2,
          ease: easeOut,
          stagger: 0.1,
        });
      },
    });
  });
})();

/*	-----------------------------------------------------------------------------
  PREVIEWS
--------------------------------------------------------------------------------- */

(function () {
  window.addEventListener("load", () => {
    const section = document.querySelector(".previews");

    if (!section) return;

    const line = section.querySelector(".previews__line");
    const backgrounds = section.querySelectorAll(".previews__background-image");
    const media = section.querySelectorAll(".previews__media-item");
    const mediaInner = section.querySelectorAll(".previews__media-item-inner");

    gsap.set(line, {
      clipPath: "inset(0% 0% 100% 0%)",
    });

    gsap.set(backgrounds, {
      opacity: 0,
      rotate: -45,
      scale: 0.5,
    });

    media.forEach((item, index) => {
      let clipPath;
      switch (index) {
        case 0:
          clipPath = "polygon(100% 100%, 100% 100%, 100% 100%, 100% 100%)";
          margin = "4rem 0 0 4rem";
          break;
        case 1:
          clipPath = "polygon(0% 100%, 0% 100%, 0% 100%, 0% 100%)";
          margin = "4rem 4rem 0";
          break;
        case 2:
          clipPath = "polygon(100% 0, 100% 0, 100% 0, 100% 0)";
          margin = "0 0 4rem 4rem";
          break;
        case 3:
          clipPath = "polygon(0% 0%, 0% 0%, 0% 0%, 0% 0%)";
          margin = "0 4rem 4rem 0";
          break;
        default:
          clipPath = "polygon(0% 100%, 0% 100%, 0% 100%, 0% 100%)";
      }
      gsap.set(item, {
        clipPath:
          window.innerWidth > 768
            ? clipPath
            : "polygon(0% 0%, 100% 0%, 100% 0%, 0% 0%)",
        margin: window.innerWidth > 768 ? margin : "0",
      });
    });

    ScrollTrigger.create({
      trigger: section,
      start: "top 40%",
      onEnter: () => {
        const tl = gsap.timeline();
        tl.to(line, {
          clipPath: "inset(0% 0% 0% 0%)",
          duration: 0.6,
          ease: easeOut,
        })
          .to(
            backgrounds,
            {
              opacity: 1,
              rotate: 0,
              scale: 1,
              duration: 0.6,
              ease: easeOut,
              stagger: 0.2,
            },
            "-=0.5"
          )
          .to(media, {
            clipPath: "polygon(0% 0%, 100% 0%, 100% 100%, 0% 100%)",
            margin: "0",
            duration: 0.6,
            ease: easeOut,
          });
      },
    });

    // Mouse parallax effect for media items
    let mouseX = 0;
    let mouseY = 0;
    let isMouseInside = false;

    section.addEventListener("mouseenter", () => {
      isMouseInside = true;
    });

    section.addEventListener("mouseleave", () => {
      isMouseInside = false;
      // Reset all media items to center position
      gsap.to(mediaInner, {
        x: 0,
        y: 0,
        duration: 0.8,
        ease: easeOut,
      });
    });

    section.addEventListener("mousemove", (e) => {
      if (!isMouseInside) return;

      const rect = section.getBoundingClientRect();
      const centerX = rect.width / 2;
      const centerY = rect.height / 2;

      // Calculate mouse position relative to section center (-1 to 1)
      mouseX = (e.clientX - rect.left - centerX) / centerX;
      mouseY = (e.clientY - rect.top - centerY) / centerY;

      // Apply subtle movement to each media item with varying intensity
      mediaInner.forEach((item, index) => {
        const intensity = 15; // Maximum movement in pixels
        const multiplier = index % 2 === 0 ? 1 : -0.8; // Alternate direction for variety

        gsap.to(item, {
          x: mouseX * intensity * multiplier,
          y: mouseY * intensity * multiplier * 0.6, // Less vertical movement
          duration: 0.6,
          ease: easeOut,
        });
      });
    });
  });
})();

/*	-----------------------------------------------------------------------------
  CTA MARQUEE
--------------------------------------------------------------------------------- */

(function () {
  // Register CTA marquee as having custom resize handling
  window.ScrollTriggerComponents.registerCustomHandler("cta-marquee");

  let marqueeAnimation;
  let resizeTimeout;

  function initMarquee() {
    const marqueeElements = document.querySelectorAll("[data-marquee]");

    marqueeElements.forEach((track) => {
      if (marqueeAnimation) {
        marqueeAnimation.kill();
      }

      const item = track.querySelector(".cta-marquee__item");
      if (!item) return;

      setTimeout(() => {
        const existingClones = track.querySelectorAll(
          ".cta-marquee__item:not(:first-child)"
        );
        existingClones.forEach((clone) => clone.remove());

        const containerWidth = track.parentElement.offsetWidth;
        const itemWidth = item.offsetWidth;
        const clonesNeeded = Math.ceil(containerWidth / itemWidth) + 3;

        for (let i = 0; i < clonesNeeded; i++) {
          const clone = item.cloneNode(true);
          track.appendChild(clone);
        }

        gsap.set(track, { x: 0 });

        const animationDistance = itemWidth;

        // Slower speed for mobile devices
        const speed = deviceInfo.isMobile ? 100 : 200; // Mobile is half the speed

        const tl = gsap.timeline({ repeat: -1 });

        tl.to(track, {
          x: -animationDistance,
          duration: animationDistance / speed,
          ease: "none",
        }).set(track, { x: 0 });

        marqueeAnimation = tl;

        gsap.set(track, {
          force3D: true,
          willChange: "transform",
        });
      }, 50);
    });
  }

  function handleResize() {
    clearTimeout(resizeTimeout);
    resizeTimeout = setTimeout(() => {
      initMarquee();
    }, 250);
  }

  document.addEventListener("DOMContentLoaded", () => {
    setTimeout(initMarquee, 100);
  });

  window.addEventListener("resize", handleResize);

  document.addEventListener("DOMContentLoaded", () => {
    const marqueeContainers = document.querySelectorAll(".cta-marquee");

    marqueeContainers.forEach((container) => {
      container.addEventListener("mouseenter", () => {
        if (marqueeAnimation) {
          gsap.to(marqueeAnimation, { timeScale: 0.3, duration: 0.3 });
        }
      });

      container.addEventListener("mouseleave", () => {
        if (marqueeAnimation) {
          gsap.to(marqueeAnimation, { timeScale: 1, duration: 0.3 });
        }
      });
    });
  });
})();

/*	-----------------------------------------------------------------------------
  HEADER
--------------------------------------------------------------------------------- */

(function () {
  "use strict";

  function smoothScrollTo(target, offset = 0, duration = 700) {
    const targetElement = document.querySelector(target);
    if (!targetElement) return;

    const targetPosition = targetElement.offsetTop - offset;
    const startPosition = window.pageYOffset;
    const distance = targetPosition - startPosition;
    let startTime = null;

    function animation(currentTime) {
      if (startTime === null) startTime = currentTime;
      const timeElapsed = currentTime - startTime;
      const run = ease(timeElapsed, startPosition, distance, duration);
      window.scrollTo(0, run);
      if (timeElapsed < duration) requestAnimationFrame(animation);
    }

    function ease(t, b, c, d) {
      t /= d / 2;
      if (t < 1) return (c / 2) * t * t + b;
      t--;
      return (-c / 2) * (t * (t - 2) - 1) + b;
    }

    requestAnimationFrame(animation);
  }

  function hideElement(element) {
    if (element) element.style.display = "none";
  }

  function showElement(element) {
    if (element) element.style.display = "";
  }

  document.addEventListener("DOMContentLoaded", function () {
    const navbarLinks = document.querySelectorAll(".navbar-nav li > a");
    navbarLinks.forEach(function (link) {
      link.addEventListener("click", function (e) {
        const parentLi = this.parentElement;

        if (parentLi.classList.contains("dropdown")) {
          parentLi.classList.toggle("open");
        } else {
          const navbarNav = document.querySelector(".navbar-nav");
          if (navbarNav) navbarNav.classList.remove("open");
        }

        const href = this.getAttribute("href");
        if (!href || href.indexOf("#") === -1) {
          return true;
        }
        e.preventDefault();

        const offset = 0;
        smoothScrollTo(href, offset, 700);

        return false;
      });
    });

    const navSubmenus = document.querySelectorAll(".nav-has-submenu");
    navSubmenus.forEach(function (submenu) {
      submenu.addEventListener("click", function (e) {
        e.preventDefault();
        const submenuName = this.getAttribute("data-submenu-name");
        document.body.classList.add("nav-submenu-open");

        const navSubmenuUls = document.querySelectorAll("#nav-submenu ul");
        navSubmenuUls.forEach(hideElement);

        const targetSubmenu = document.querySelector(
          "#nav-submenu-" + submenuName
        );
        showElement(targetSubmenu);

        const navSubmenu = document.querySelector("#nav-submenu");
        showElement(navSubmenu);

        return false;
      });
    });

    const navSubmenuClose = document.querySelector("#nav-submenu-close");
    if (navSubmenuClose) {
      navSubmenuClose.addEventListener("click", function (e) {
        document.body.classList.remove("nav-submenu-open");
        const navSubmenu = document.querySelector("#nav-submenu");
        hideElement(navSubmenu);
      });
    }

    const navbarButtons = document.querySelector(".navbar-buttons");
    if (navbarButtons) {
      navbarButtons.addEventListener("click", function (e) {
        if (e.target.classList.contains("btn-start-new-itinerary")) {
          const event = new CustomEvent(
            "button.click:header-start-a-new-itinerary"
          );
          document.dispatchEvent(event);
        } else if (e.target.classList.contains("btn-itinerary-get-quote")) {
          const event = new CustomEvent("button.click:header-get-a-quote");
          document.dispatchEvent(event);
        } else if (e.target.classList.contains("btn-itinerary-contact")) {
          const event = new CustomEvent("button.click:header-contact");
          document.dispatchEvent(event);
        }
      });
    }

    const navbarToggle = document.querySelector(".navbar-toggle");
    const navbarCollapse = document.querySelector(".navbar-collapse");

    if (navbarToggle && navbarCollapse) {
      navbarCollapse.classList.add("collapse");

      navbarToggle.addEventListener("click", function (e) {
        e.preventDefault();

        if (navbarCollapse.classList.contains("in")) {
          navbarCollapse.classList.remove("in");
        } else {
          navbarCollapse.classList.add("in");
        }

        const expanded = navbarToggle.getAttribute("aria-expanded") === "true";
        navbarToggle.setAttribute("aria-expanded", !expanded);

        const menuLinks = navbarCollapse.querySelectorAll("a");
        menuLinks.forEach(function (link) {
          link.addEventListener(
            "click",
            function () {
              navbarCollapse.classList.remove("in");
              navbarToggle.setAttribute("aria-expanded", "false");
            },
            { once: true }
          );
        });
      });
    }

    const searchIcon = document.querySelector(
      "#header-search-form .search-input-icon"
    );
    const searchForm = document.querySelector("#header-search-form");
    const searchInput = document.querySelector(
      "#header-search-form input[type=text]"
    );

    if (searchIcon && searchForm && searchInput) {
      searchIcon.addEventListener("click", function (e) {
        e.preventDefault();

        if (searchForm.classList.contains("header-search-form-open")) {
          searchForm.classList.remove("header-search-form-open");
          searchInput.blur();
        } else {
          searchForm.classList.add("header-search-form-open");
          searchInput.focus();
        }

        return false;
      });
    }
  });
})();

/*	-----------------------------------------------------------------------------
  FOOTER
--------------------------------------------------------------------------------- */

(function () {
  "use strict";

  function ready(fn) {
    if (document.readyState != "loading") {
      fn();
    } else {
      document.addEventListener("DOMContentLoaded", fn);
    }
  }

  ready(function () {
    updateCopyrightYear();
    initSocialMediaTracking();
    initFooterLinkTracking();
  });

  function updateCopyrightYear() {
    var currentYear = new Date().getFullYear();

    var footerLegalElements = document.querySelectorAll(
      "#footer-legal .list-inline li"
    );

    if (footerLegalElements && footerLegalElements.length > 0) {
      var copyrightText = footerLegalElements[0].textContent;
      if (copyrightText && copyrightText.includes("©")) {
        var updatedText = copyrightText.replace(
          /©\s*\d{4}/,
          "© " + currentYear
        );
        footerLegalElements[0].textContent = updatedText;
      }
    }
  }

  function initSocialMediaTracking() {
    var socialLinks = document.querySelectorAll(".list-social a");

    socialLinks.forEach(function (link) {
      link.addEventListener("click", function (e) {
        var href = this.getAttribute("href");
        var platform = getSocialPlatform(href);

        if (platform) {
          trackEvent("social_click", {
            event_category: "social_media",
            event_label: platform + "_footer",
          });
        }
      });
    });
  }

  function getSocialPlatform(url) {
    if (url.includes("facebook")) return "facebook";
    if (url.includes("twitter")) return "twitter";
    if (url.includes("instagram")) return "instagram";
    if (url.includes("pinterest")) return "pinterest";
    if (url.includes("vimeo")) return "vimeo";
    if (url.includes("google")) return "google_plus";
    return null;
  }

  function initFooterLinkTracking() {
    var footerLinks = document.querySelectorAll("footer a");

    footerLinks.forEach(function (link) {
      link.addEventListener("click", function () {
        var href = this.getAttribute("href");
        var text = this.textContent.trim();

        trackEvent("footer_link_click", {
          event_category: "navigation",
          event_label: text || href,
        });
      });
    });
  }

  function trackEvent(eventName, parameters) {
    if (typeof gtag !== "undefined") {
      gtag("event", eventName, parameters);
    }

    if (typeof ga !== "undefined") {
      ga(
        "send",
        "event",
        parameters.event_category,
        eventName,
        parameters.event_label
      );
    }

    if (
      typeof analytics !== "undefined" &&
      typeof analytics.track === "function"
    ) {
      analytics.track(eventName, parameters);
    }
  }

  window.FooterComponent = {
    init: function () {
      updateCopyrightYear();
      initSocialMediaTracking();
      initFooterLinkTracking();
    },
    updateCopyrightYear: updateCopyrightYear,
    trackEvent: trackEvent,
  };
})();

/*	-----------------------------------------------------------------------------
  LOAD
--------------------------------------------------------------------------------- */

(function () {
  window.addEventListener("load", () => {
    document.body.classList.remove("loading");
  });
})();

/*	-----------------------------------------------------------------------------
  BUTTON RIPPLE EFFECT
--------------------------------------------------------------------------------- */
(function () {
  function initButtonRipple() {
    const buttons = document.querySelectorAll(".button");

    buttons.forEach((button) => {
      // Remove any existing ripple listeners to prevent duplicates
      button.removeEventListener("mouseenter", handleButtonEnter);
      button.removeEventListener("mouseleave", handleButtonLeave);

      // Add new listeners
      button.addEventListener("mouseenter", handleButtonEnter);
      button.addEventListener("mouseleave", handleButtonLeave);
    });
  }

  function handleButtonEnter(e) {
    const button = e.currentTarget;
    const rect = button.getBoundingClientRect();

    // Calculate mouse position relative to button
    const x = e.clientX - rect.left;
    const y = e.clientY - rect.top;

    // Calculate percentage position for transform-origin
    const xPercent = (x / rect.width) * 100;
    const yPercent = (y / rect.height) * 100;

    // Set transform origin to mouse position and trigger ripple
    gsap.set(button, {
      "--ripple-x": xPercent + "%",
      "--ripple-y": yPercent + "%",
    });

    gsap.to(button, {
      "--ripple-scale": 1,
      duration: 0.4,
      ease: "power2.out",
    });
  }

  function handleButtonLeave(e) {
    const button = e.currentTarget;

    // Animate ripple out
    gsap.to(button, {
      "--ripple-scale": 0,
      duration: 0.3,
      ease: "power2.inOut",
    });
  }

  // Initialize on DOM ready
  document.addEventListener("DOMContentLoaded", initButtonRipple);

  // Re-initialize after any dynamic content loads
  window.addEventListener("load", initButtonRipple);
})();

/*	-----------------------------------------------------------------------------
  VIDEO OPTIMIZATION (OPTIONAL ENHANCEMENT)
--------------------------------------------------------------------------------- */

(function () {
  "use strict";

  // Simple video optimization for responsive videos
  function optimizeResponsiveVideos() {
    const responsiveVideos = document.querySelectorAll(
      'video[data-responsive="true"]'
    );

    responsiveVideos.forEach((video) => {
      // Respect user's data preference
      if (deviceInfo.prefersReducedData) {
        video.setAttribute("preload", "none");
        return;
      }

      // Optimize preload based on connection
      if (deviceInfo.isSlowConnection) {
        video.setAttribute("preload", "metadata");
      } else {
        video.setAttribute("preload", "auto");
      }

      // Handle orientation changes for mobile devices
      if (deviceInfo.isMobile) {
        let orientationTimeout;
        window.addEventListener("orientationchange", () => {
          clearTimeout(orientationTimeout);
          orientationTimeout = setTimeout(() => {
            video.load(); // Reload video after orientation change
          }, 300);
        });
      }
    });
  }

  // Initialize video optimizations
  document.addEventListener("DOMContentLoaded", optimizeResponsiveVideos);
})();
