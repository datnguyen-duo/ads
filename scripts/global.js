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

let lenis;

/*	-----------------------------------------------------------------------------
	GSAP INITIALIZATION
--------------------------------------------------------------------------------- */
gsap.registerPlugin(ScrollTrigger, SplitText);

/*	-----------------------------------------------------------------------------
	SPLITTEXT MANAGER
--------------------------------------------------------------------------------- */
window.SplitTextManager = {
  instances: new Map(),
  register: function (element, splitTextInstance, config) {
    this.instances.set(element, {
      splitText: splitTextInstance,
      config: config,
      element: element,
    });
  },
  refreshLineBreaks: function () {
    this.instances.forEach((instance, element) => {
      const exists = document.contains(element);
      const isAnimated = element.classList.contains("animate-in");
      if (exists) {
        const { splitText, config } = instance;
        splitText.revert();
        const newSplitText = new SplitText(element, config);
        instance.splitText = newSplitText;
        if (isAnimated) {
          if (newSplitText.lines) {
            gsap.set(newSplitText.lines, {
              opacity: 1,
              y: 0,
            });
          }
          if (newSplitText.words) {
            gsap.set(newSplitText.words, {
              opacity: 1,
              filter: "blur(0px)",
            });
          }
        }
      }
    });
  },
  cleanup: function () {
    this.instances.forEach((instance, element) => {
      if (!document.contains(element)) {
        this.instances.delete(element);
      }
    });
  },
};

/*	-----------------------------------------------------------------------------
	SCROLLTRIGGER COMPONENTS MANAGER
--------------------------------------------------------------------------------- */
window.ScrollTriggerComponents = {
  customResizeHandlers: new Set(),
  registerCustomHandler: function (name) {
    this.customResizeHandlers.add(name);
  },
  hasCustomHandler: function (name) {
    return this.customResizeHandlers.has(name);
  },
};
/*	-----------------------------------------------------------------------------
	RESIZE HANDLERS
--------------------------------------------------------------------------------- */
(function () {
  let resizeTimeout;
  function debounce(func, delay) {
    return function (...args) {
      clearTimeout(resizeTimeout);
      resizeTimeout = setTimeout(() => func.apply(this, args), delay);
    };
  }
  function handleGlobalResize() {
    requestAnimationFrame(() => {
      window.SplitTextManager.cleanup();
      window.SplitTextManager.refreshLineBreaks();
      ScrollTrigger.refresh();
      window.dispatchEvent(new CustomEvent("scrolltrigger:resize"));
    });
  }
  const debouncedResize = debounce(handleGlobalResize, 250);
  window.addEventListener("resize", debouncedResize);
  window.addEventListener("orientationchange", () => {
    setTimeout(() => {
      debouncedResize();
    }, 100);
  });
})();

/*	-----------------------------------------------------------------------------
	MENU HEIGHT CALCULATION
--------------------------------------------------------------------------------- */
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
	SWIPER INITIALIZATION
--------------------------------------------------------------------------------- */
(function () {
  const swipers = document.querySelectorAll(".swiper");
  if (!swipers) return;
  swipers.forEach((slider) => {
    const nextButton = slider.querySelector(".swiper-button-next");
    const prevButton = slider.querySelector(".swiper-button-prev");
    const paginationEl = slider.querySelector(".swiper-pagination");
    const centeredSlides = slider.dataset.centeredSlides === "true";
    const useFade = slider.dataset.fade === "true";
    const variation = slider.dataset.variation;
    const slides = slider.querySelectorAll(".swiper-slide");
    const slideCount = slides.length;

    // Hide navigation if only one slide
    if (slideCount <= 1) {
      if (nextButton) nextButton.style.display = "none";
      if (prevButton) prevButton.style.display = "none";
      if (paginationEl) paginationEl.style.display = "none";
    }

    const swiperConfig = {
      slidesPerView: useFade ? 1 : "auto", // Fade requires slidesPerView: 1
      loop: slideCount > 1, // Only enable loop if more than 1 slide
      centeredSlides: centeredSlides || false,
      speed: 600,
      watchOverflow: true, // Disable swiper when slides <= slidesPerView
      on: {
        init: function () {
          // Check if swiper is actually needed after initialization
          if (this.isBeginning && this.isEnd && slideCount > 1) {
            // All slides are visible, hide navigation
            if (nextButton) nextButton.style.display = "none";
            if (prevButton) prevButton.style.display = "none";
            if (paginationEl) paginationEl.style.display = "none";
          }
        },
        resize: function () {
          // Re-check on resize in case viewport changes
          if (this.isBeginning && this.isEnd && slideCount > 1) {
            if (nextButton) nextButton.style.display = "none";
            if (prevButton) prevButton.style.display = "none";
            if (paginationEl) paginationEl.style.display = "none";
          } else if (slideCount > 1) {
            if (nextButton) nextButton.style.display = "";
            if (prevButton) prevButton.style.display = "";
            if (paginationEl) paginationEl.style.display = "";
          }
        },
      },
    };

    // Add navigation (autoplay uses marquee instead of swiper)
    swiperConfig.navigation = {
      nextEl: nextButton,
      prevEl: prevButton,
    };

    // Add pagination if pagination element exists
    if (paginationEl) {
      swiperConfig.pagination = {
        el: paginationEl,
        clickable: true,
      };
    }

    // Add fade effect if enabled
    if (useFade) {
      swiperConfig.effect = "fade";
      swiperConfig.fadeEffect = {
        crossFade: true,
      };
    }

    const swiper = new Swiper(slider, swiperConfig);
  });
})();

/*	-----------------------------------------------------------------------------
	LENIS SMOOTH SCROLLING
--------------------------------------------------------------------------------- */
(function () {
  if ("scrollRestoration" in history) {
    history.scrollRestoration = "manual";
  }
  lenis = new Lenis();
  lenis.on("scroll", ScrollTrigger.update);
  gsap.ticker.add((time) => {
    lenis.raf(time * 1000);
  });
  gsap.ticker.lagSmoothing(0);
})();

/*	-----------------------------------------------------------------------------
	SCROLLTRIGGER-BASED SCROLL DETECTION
--------------------------------------------------------------------------------- */
(function () {
  let lastScrollY = 0;
  let isScrollingUp = false;

  function initScrollDetection() {
    ScrollTrigger.create({
      trigger: "body",
      start: "top top",
      end: "bottom bottom",
      onUpdate: (self) => {
        const currentScrollY = self.scroll();
        const scrollThreshold = 10;
        const topThreshold = 5;
        const directionThreshold = 3;

        const scrollDiff = currentScrollY - lastScrollY;
        if (Math.abs(scrollDiff) > directionThreshold) {
          isScrollingUp = scrollDiff < 0;
        }

        const isAtTop = currentScrollY <= topThreshold;
        const isScrolled = currentScrollY > scrollThreshold;

        document.body.classList.toggle("scrolled", isScrolled);
        document.body.classList.toggle(
          "scrolling-up",
          isScrollingUp && !isAtTop
        );
        document.body.classList.toggle("at-top", isAtTop);

        lastScrollY = currentScrollY;
      },
    });
  }

  window.addEventListener("load", () => {
    initScrollDetection();
    const currentScrollY = window.scrollY;
    document.body.classList.toggle("scrolled", currentScrollY > 10);
    document.body.classList.toggle("at-top", currentScrollY <= 5);
    document.body.classList.toggle("scrolling-up", false);
  });
})();
/*	-----------------------------------------------------------------------------
	ANIMATION INITIALIZATION
--------------------------------------------------------------------------------- */
(function () {
  function initWordAnimations() {
    const textElements = document.querySelectorAll("[data-animate-words]");
    textElements.forEach((element) => {
      const playImmediately = element.hasAttribute("data-play-immediately");
      const config = {
        type: "words",
        wordsClass: "split-word",
        tag: "span",
      };
      const splitText = new SplitText(element, config);
      window.SplitTextManager.register(element, splitText, config);
      gsap.set(splitText.words, {
        opacity: 0,
        filter: "blur(8px)",
        willChange: "transform, opacity, filter",
      });
      if (playImmediately) {
        gsap.to(splitText.words, {
          opacity: 1,
          filter: "blur(0px)",
          duration: 0.6,
          ease: easeOut,
          stagger: 0.05,
          force3D: true,
        });
      } else {
        ScrollTrigger.create({
          trigger: element,
          start: start,
          onEnter: () => {
            gsap.to(splitText.words, {
              opacity: 1,
              filter: "blur(0px)",
              duration: 0.6,
              ease: easeOut,
              stagger: 0.05,
              force3D: true,
              onComplete: () => {
                element.classList.add("animate-in");
              },
            });
          },
        });
      }
    });
  }
  function initBlockAnimations() {
    const textElements = document.querySelectorAll("[data-animate-block]");
    textElements.forEach((element) => {
      gsap.set(element, {
        opacity: 0,
        filter: "blur(8px)",
        willChange: "transform, opacity, filter",
      });
      ScrollTrigger.create({
        trigger: element,
        start: start,
        onEnter: () => {
          gsap.to(element, {
            opacity: 1,
            filter: "blur(0px)",
            duration: 0.8,
            ease: easeOut,
            force3D: true,
            onComplete: () => {
              element.classList.add("animate-in");
            },
          });
        },
      });
    });
  }
  function initLineAnimations() {
    const textElements = document.querySelectorAll("[data-animate-lines]");
    textElements.forEach((element) => {
      const paragraphs = element.querySelectorAll("p");
      const allLines = [];
      const splitInstances = [];
      const lineConfig = {
        type: "lines",
        linesClass: "split-line",
        tag: "div",
      };
      paragraphs.forEach((paragraph) => {
        const splitText = new SplitText(paragraph, lineConfig);
        splitInstances.push(splitText);
        allLines.push(...splitText.lines);
        window.SplitTextManager.register(paragraph, splitText, lineConfig);
      });
      if (paragraphs.length === 0) {
        const splitText = new SplitText(element, lineConfig);
        splitInstances.push(splitText);
        allLines.push(...splitText.lines);
        window.SplitTextManager.register(element, splitText, lineConfig);
      }
      gsap.set(allLines, {
        opacity: 0,
        y: 24,
        willChange: "transform, opacity",
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
            force3D: true,
            onComplete: () => {
              element.classList.add("animate-in");
            },
          });
        },
      });
    });
  }
  function initImageAnimations() {
    const imageElements = document.querySelectorAll("[data-animate-image]");
    imageElements.forEach((element) => {
      gsap.set(element, {
        clipPath: "inset(0% 0% 100% 0%)",
        scale: 1.05,
        willChange: "transform, clip-path",
      });
      ScrollTrigger.create({
        trigger: element,
        start: start,
        onEnter: () => {
          gsap.to(element, {
            clipPath: "inset(0% 0% 0% 0%)",
            scale: 1,
            duration: 1,
            ease: easeInOut,
            force3D: true,
            onComplete: () => {
              element.classList.add("animate-in");
            },
          });
        },
      });
    });
  }
  window.addEventListener("load", () => {
    setTimeout(() => {
      initWordAnimations();
      initBlockAnimations();
      initLineAnimations();
      initImageAnimations();
    }, 100);
  });
})();
/*	-----------------------------------------------------------------------------
	SECTION ANIMATIONS - HERO
--------------------------------------------------------------------------------- */
(function () {
  window.addEventListener("load", () => {
    const section = document.querySelector(".hero");
    if (!section) return;
    const preHeading = section.querySelector(".hero__pre-heading");
    const heading = section.querySelector(".hero__heading");
    const description = section.querySelector(".hero__description");
    const cta = section.querySelector(".hero__cta");
    const heroConfig = {
      type: "words",
      wordsClass: "split-word",
      tag: "span",
    };
    const splitWords = new SplitText(heading, heroConfig);
    if (heading) {
      window.SplitTextManager.register(heading, splitWords, heroConfig);
    }
    gsap.set(preHeading, {
      opacity: 0,
      filter: "blur(8px)",
      willChange: "transform, opacity, filter",
    });
    gsap.set(splitWords.words, {
      opacity: 0,
      filter: "blur(8px)",
      willChange: "transform, opacity, filter",
    });
    gsap.set(description, {
      opacity: 0,
      filter: "blur(8px)",
      willChange: "transform, opacity, filter",
    });
    gsap.set(cta, {
      opacity: 0,
      filter: "blur(8px)",
      willChange: "transform, opacity, filter",
    });
    let heroScrollTrigger;
    function createHeroScrollTrigger() {
      if (heroScrollTrigger) {
        heroScrollTrigger.kill();
      }
      const scrollTimeline = gsap.timeline();
      scrollTimeline.to(section, {
        filter: "blur(10px)",
        yPercent: 25,
      });
      heroScrollTrigger = ScrollTrigger.create({
        trigger: section,
        scrub: true,
        start: "top top",
        animation: scrollTimeline,
      });
    }
    const tl = gsap.timeline({
      onStart: () => {
        if (section.classList.contains(".--high-impact")) {
          createHeroScrollTrigger();
        }
      },
    });
    tl.to(splitWords.words, {
      opacity: 1,
      filter: "blur(0px)",
      duration: 0.6,
      ease: easeOut,
      stagger: 0.05,
      force3D: true,
    });
    tl.to(
      preHeading,
      {
        opacity: 1,
        filter: "blur(0px)",
        duration: 0.8,
        ease: easeOut,
        force3D: true,
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
        force3D: true,
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
        force3D: true,
      },
      "<"
    );
    window.addEventListener("scrolltrigger:resize", () => {
      if (heroScrollTrigger) {
        createHeroScrollTrigger();
      }
    });
  });
})();

/*	-----------------------------------------------------------------------------
	UNIVERSAL VIDEO PLAY BUTTON
--------------------------------------------------------------------------------- */
(function () {
  window.addEventListener("load", () => {
    // Look for video play buttons anywhere on the page
    const playButtons = document.querySelectorAll(".js-video-play");

    if (playButtons.length === 0) return;

    playButtons.forEach((playButton) => {
      const videoContainer = playButton.closest(".video-play-container");
      if (!videoContainer) return;

      const video = videoContainer.querySelector("video");
      if (!video) return;

      // Play button click handler
      playButton.addEventListener("click", () => {
        video.muted = false; // Unmute the video
        video.play();
        playButton.style.display = "none"; // Hide play button
      });

      // Click video to pause/play
      video.addEventListener("click", () => {
        if (video.paused) {
          video.play();
        } else {
          video.pause();
        }
      });

      // Show play button again when video ends
      video.addEventListener("ended", () => {
        playButton.style.display = "flex"; // Show play button
      });

      // Also hide play button if video starts playing (e.g., via native controls)
      video.addEventListener("play", () => {
        playButton.style.display = "none";
      });

      // Show play button if video is paused
      video.addEventListener("pause", () => {
        if (video.currentTime < video.duration) {
          playButton.style.display = "flex";
        }
      });
    });
  });
})();

/*	-----------------------------------------------------------------------------
	SHOW MORE FUNCTIONALITY - GLOBAL
--------------------------------------------------------------------------------- */

(function () {
  function initShowMore() {
    const containers = document.querySelectorAll(".show-more-container");
    if (!containers.length) return;

    containers.forEach((container) => {
      const button = container.querySelector(".show-more-button");
      if (!button) return;

      // Get height threshold from data attribute, default to 700
      const heightThreshold = parseInt(
        container.getAttribute("data-content-height") || "700"
      );

      // For hidden elements (like inactive tabs), temporarily show to measure
      const wasHidden = container.offsetParent === null;
      let actualHeight = container.scrollHeight;

      if (wasHidden) {
        // Temporarily make visible to measure
        const originalDisplay = container.style.display;
        const originalVisibility = container.style.visibility;
        const originalPosition = container.style.position;

        container.style.display = "block";
        container.style.visibility = "hidden";
        container.style.position = "absolute";

        actualHeight = container.scrollHeight;

        // Restore original state
        container.style.display = originalDisplay;
        container.style.visibility = originalVisibility;
        container.style.position = originalPosition;
      }

      // Check if content height exceeds threshold
      if (actualHeight > heightThreshold) {
        container.classList.add("has-more");

        // Set max-height when has-more
        if (!container.classList.contains("expanded")) {
          container.style.maxHeight = `${heightThreshold}px`;
        }

        // Remove existing listener to avoid duplicates
        button.removeEventListener("click", button._showMoreHandler);

        // Store handler for removal later
        button._showMoreHandler = () => {
          container.classList.toggle("expanded");

          // Toggle max-height
          if (container.classList.contains("expanded")) {
            container.style.maxHeight = "none";
          } else {
            container.style.maxHeight = `${heightThreshold}px`;
          }

          const buttonText = button.querySelector(".show-more-button-text");
          if (buttonText) {
            buttonText.textContent = container.classList.contains("expanded")
              ? "Show less"
              : "Show more";
          }
        };

        button.addEventListener("click", button._showMoreHandler);
      } else {
        // Remove has-more if content is shorter than threshold
        container.classList.remove("has-more");
        container.style.maxHeight = "none";
      }
    });
  }

  window.addEventListener("load", initShowMore);

  // Re-initialize when tabs are switched (for details section)
  document.addEventListener("click", (e) => {
    if (e.target.matches(".details__tab")) {
      // Small delay to allow tab content to be visible
      setTimeout(initShowMore, 50);
    }
  });
})();

/*	-----------------------------------------------------------------------------
	SECTION ANIMATIONS - HORIZONTAL GALLERY
--------------------------------------------------------------------------------- */
(function () {
  window.ScrollTriggerComponents.registerCustomHandler("horizontal-gallery");
  window.addEventListener("load", () => {
    const section = document.querySelector(".horizontal-gallery");
    if (!section) return;
    const container = section.querySelector(".horizontal-gallery__container");
    const images = section.querySelectorAll(".horizontal-gallery__media");
    const background = section.querySelector(
      ".horizontal-gallery__background-image"
    );
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
    gsap.set(images, {
      y: "40%",
      scale: 1.1,
      opacity: 0,
      willChange: "transform, opacity",
    });
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
          force3D: true,
        }).to(
          images,
          {
            scale: 1,
            duration: 0.6,
            ease: easeInOut,
            stagger: 0.1,
            force3D: true,
          },
          "-=0.6"
        );
      },
    });
  });
})();
/*	-----------------------------------------------------------------------------
	SECTION ANIMATIONS - EXPERIENCE PATHS
--------------------------------------------------------------------------------- */
(function () {
  window.addEventListener("load", () => {
    const section = document.querySelector(".experience-paths");
    if (!section) return;
    const paths = section.querySelectorAll(".experience-paths__path");
    const line = section.querySelector(".experience-paths__line.--active");
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
          scrub: 2,
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
	SECTION ANIMATIONS - PROCESS
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
	SECTION ANIMATIONS - PREVIEWS & VIDEO MODAL
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
    let mouseX = 0;
    let mouseY = 0;
    let isMouseInside = false;
    let mouseMoveTimer = null;
    section.addEventListener("mouseenter", () => {
      isMouseInside = true;
    });
    section.addEventListener("mouseleave", () => {
      isMouseInside = false;
      if (mouseMoveTimer) {
        cancelAnimationFrame(mouseMoveTimer);
        mouseMoveTimer = null;
      }
      gsap.to(mediaInner, {
        x: 0,
        y: 0,
        duration: 0.8,
        ease: easeOut,
      });
    });
    function handleMouseMove(e) {
      if (!isMouseInside) return;
      const rect = section.getBoundingClientRect();
      const centerX = rect.width / 2;
      const centerY = rect.height / 2;
      mouseX = (e.clientX - rect.left - centerX) / centerX;
      mouseY = (e.clientY - rect.top - centerY) / centerY;
      if (mouseMoveTimer) {
        cancelAnimationFrame(mouseMoveTimer);
      }
      mouseMoveTimer = requestAnimationFrame(() => {
        mediaInner.forEach((item, index) => {
          const intensity = 15;
          const multiplier = index % 2 === 0 ? 1 : -0.8;
          gsap.to(item, {
            x: mouseX * intensity * multiplier,
            y: mouseY * intensity * multiplier * 0.6,
            duration: 0.6,
            ease: easeOut,
            overwrite: "auto",
            willChange: "transform",
            force3D: true,
          });
        });
        mouseMoveTimer = null;
      });
    }
    section.addEventListener("mousemove", handleMouseMove);
    const videoModal = document.getElementById("video-modal");
    const modalTitle = document.getElementById("video-modal-title");
    const modalClose = document.querySelector(".video-modal__close");
    const modalOverlay = document.querySelector(".video-modal__overlay");
    const iframeContainer = document.querySelector(
      ".video-modal__iframe-container"
    );
    if (videoModal && media.length > 0) {
      media.forEach((item) => {
        item.addEventListener("click", (e) => {
          e.preventDefault();
          const embedSrc = item.dataset.embedSrc;
          const caption = item.dataset.caption;
          if (embedSrc) {
            openVideoModal(embedSrc, caption);
          }
        });
      });
      function openVideoModal(embedSrc, caption) {
        modalTitle.textContent = caption || "Video";
        const iframe = document.createElement("iframe");
        iframe.src = embedSrc;
        iframe.width = "100%";
        iframe.height = "100%";
        iframe.frameBorder = "0";
        iframe.allow =
          "autoplay; fullscreen; picture-in-picture; clipboard-write; encrypted-media; web-share";
        iframe.referrerPolicy = "strict-origin-when-cross-origin";
        iframe.title = caption || "Video";
        iframeContainer.innerHTML = "";
        iframeContainer.appendChild(iframe);
        videoModal.setAttribute("aria-hidden", "false");
        document.body.style.overflow = "hidden";
        gsap.set(videoModal, { display: "flex", opacity: 0 });
        gsap
          .timeline()
          .to(videoModal, {
            opacity: 1,
            duration: 0.3,
            ease: easeOut,
          })
          .to(
            modalOverlay,
            {
              duration: 0.4,
              ease: easeInOut,
            },
            "<0.1"
          );
        modalClose.focus();
      }
      function closeVideoModal() {
        gsap
          .timeline()
          .to(modalOverlay, {
            duration: 0.3,
            ease: easeInOut,
          })
          .to(
            videoModal,
            {
              opacity: 0,
              duration: 0.2,
              ease: easeOut,
              onComplete: () => {
                videoModal.style.display = "none";
                videoModal.setAttribute("aria-hidden", "true");
                document.body.style.overflow = "";
                iframeContainer.innerHTML = "";
              },
            },
            "<0.1"
          );
      }
      modalClose.addEventListener("click", closeVideoModal);
      modalOverlay.addEventListener("click", (e) => {
        if (e.target === modalOverlay) {
          closeVideoModal();
        }
      });
      document.addEventListener("keydown", (e) => {
        if (
          videoModal.getAttribute("aria-hidden") === "false" &&
          e.key === "Escape"
        ) {
          closeVideoModal();
        }
      });
    }
  });
})();

/*	-----------------------------------------------------------------------------
	SECTION ANIMATIONS - FLIP SLIDER
--------------------------------------------------------------------------------- */
(function () {
  class FlipSlider {
    constructor(element) {
      this.container = element;
      this.slides = [];
      this.slideContents = [];
      this.prevBtn = null;
      this.nextBtn = null;
      this.timeline = null;
      this.deltaObject = { delta: 0 };
      this.incr = 0;

      this.init();
    }

    init() {
      // Get all elements
      this.slides = gsap.utils.toArray(".js-flip-item");
      this.slideContents = gsap.utils.toArray(".js-flip-content");
      this.prevBtn = this.container.querySelector("[data-flip-prev]");
      this.nextBtn = this.container.querySelector("[data-flip-next]");

      if (this.slides.length === 0) {
        console.warn("No flip slider items found");
        return;
      }

      this.setupAnimation();
      this.bindEvents();
    }

    setupAnimation() {
      // Animation timing configuration
      const baseDuration = this.slides.length / 2; // e.g., 4 slides = 2 seconds
      const staggerEach = 0.5; // 0.5 seconds between each slide animation
      const repeatDelay = baseDuration - staggerEach;

      // Quick-to function for smooth scrubbing
      this.deltaTo = gsap.quickTo(this.deltaObject, "delta", {
        duration: 0.8,
        ease: "power1",
        onUpdate: () => {
          this.timeline.time(this.deltaObject.delta);
        },
      });

      // Create main timeline (paused, we'll control it manually)
      this.timeline = gsap.timeline({ paused: true });

      // ANIMATION 1: Slide Items - Move from back to front in 3D space
      // Starting position: far away (negative z) and lower (positive y)
      // Ending position: at origin (center, front)
      this.timeline.from(this.slides, {
        y: "15vw", // Start 15vw below
        z: "-90vw", // Start 90vw back in z-space
        ease: "none",
        duration: baseDuration,
        stagger: {
          each: staggerEach,
          repeat: -1, // Infinite loop
        },
      });

      // ANIMATION 2: Content - Entry animation (slides in from top)
      // Each slide's content animates in with a bounce effect
      this.timeline.fromTo(
        this.slideContents,
        {
          y: "-20vh", // Start above viewport
        },
        {
          y: 0, // End at natural position
          ease: "back.out(1.05)", // Slight overshoot for dynamic feel
          duration: staggerEach,
          stagger: {
            each: staggerEach,
            repeat: -1,
            repeatDelay: repeatDelay,
            onRepeat() {
              // Reset position on loop for seamless infinite animation
              this.targets()[0].style.transform = "translateY(100vh)";
            },
          },
        },
        "<" // Start at same time as previous animation
      );

      // ANIMATION 3: Content - Exit animation (slides out to top)
      // After being visible, content exits upward
      this.timeline.fromTo(
        this.slideContents,
        {
          y: 0, // Start at natural position
        },
        {
          y: "-200vh", // Exit way above viewport
          ease: "power3.in",
          duration: staggerEach,
          delay: repeatDelay,
          stagger: {
            each: staggerEach,
            repeat: -1,
            repeatDelay: repeatDelay,
            onRepeat() {
              // Reset position on loop
              this.targets()[0].style.transform = "translateY(0vh)";
            },
          },
        },
        "<" // Start at same time as previous animation
      );

      // Calculate starting point (show slides from middle of timeline)
      const beginDistance = this.slides.length * 100;
      this.timeline.time(beginDistance);
      this.deltaTo(beginDistance + 0.01, beginDistance);

      // Snap helper for clean slide transitions
      this.snap = gsap.utils.snap(baseDuration / this.slides.length);
    }

    bindEvents() {
      if (this.prevBtn) {
        this.prevBtn.addEventListener("click", () => this.prev());
      }

      if (this.nextBtn) {
        this.nextBtn.addEventListener("click", () => this.next());
      }
    }

    prev() {
      this.incr -= 0.5;
      const beginDistance = this.slides.length * 100;
      this.deltaTo(this.snap(beginDistance + this.incr));
    }

    next() {
      this.incr += 0.5;
      const beginDistance = this.slides.length * 100;
      this.deltaTo(this.snap(beginDistance + this.incr));
    }

    destroy() {
      if (this.timeline) {
        this.timeline.kill();
      }
      if (this.prevBtn) {
        this.prevBtn.removeEventListener("click", this.prev);
      }
      if (this.nextBtn) {
        this.nextBtn.removeEventListener("click", this.next);
      }
    }
  }

  window.addEventListener("load", () => {
    const section = document.querySelector(".flip-slider");
    if (!section) return;

    const sliderElement = section.querySelector("[data-flip-slider]");
    if (sliderElement) {
      new FlipSlider(sliderElement);
    }
  });
})();

/*	-----------------------------------------------------------------------------
	SECTION ANIMATIONS - CTA
--------------------------------------------------------------------------------- */
(function () {
  window.addEventListener("load", () => {
    const section = document.querySelector(".cta");
    if (!section) return;
    const lineActive = section.querySelectorAll(".cta__line.--active");

    gsap.set(lineActive, { clipPath: "inset(0% 100% 0% 0%)" });
    gsap.to(lineActive, {
      clipPath: "inset(0% 0% 0% 0%)",
      duration: 2,
      scrollTrigger: {
        trigger: section,
        start: "top 70%",
      },
    });
  });
})();

/*	-----------------------------------------------------------------------------
	SECTION ANIMATIONS - MEDIA
--------------------------------------------------------------------------------- */
(function () {
  window.addEventListener("load", () => {
    const section = document.querySelector(".media");
    if (!section) return;
    const backgrounds = section.querySelectorAll(".media__background-image");
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
  });
})();

/*	-----------------------------------------------------------------------------
	SECTION ANIMATIONS - DETAILS
--------------------------------------------------------------------------------- */
(function () {
  window.addEventListener("load", () => {
    const section = document.querySelector(".details");
    if (!section) return;

    const tabs = section.querySelectorAll(".details__tab");
    const tabContents = section.querySelectorAll(".details__tab-content");
    const indicator = section.querySelector(".details__tab-indicator");

    if (!tabs.length || !tabContents.length || !indicator) return;

    // Function to update indicator position
    function updateIndicator(activeTab) {
      const tabRect = activeTab.getBoundingClientRect();
      const navRect = activeTab.parentElement.getBoundingClientRect();
      const scrollLeft = activeTab.parentElement.scrollLeft;

      const left = tabRect.left - navRect.left + scrollLeft;
      const width = tabRect.width;

      indicator.style.transform = `translateX(${left}px)`;
      indicator.style.width = `${width}px`;
    }

    // Initialize indicator position on first tab
    const activeTab = section.querySelector(".details__tab.active");
    if (activeTab) {
      updateIndicator(activeTab);
    }

    // Tab click handlers
    tabs.forEach((tab) => {
      tab.addEventListener("click", () => {
        const tabIndex = tab.getAttribute("data-tab");

        // Remove active class from all tabs and contents
        tabs.forEach((t) => t.classList.remove("active"));
        tabContents.forEach((content) => content.classList.remove("active"));

        // Add active class to clicked tab and corresponding content
        tab.classList.add("active");
        const activeContent = section.querySelector(
          `.details__tab-content[data-tab-content="${tabIndex}"]`
        );
        if (activeContent) {
          activeContent.classList.add("active");
        }

        // Update indicator position
        updateIndicator(tab);
      });
    });

    // Update indicator on window resize
    let resizeTimeout;
    window.addEventListener("resize", () => {
      clearTimeout(resizeTimeout);
      resizeTimeout = setTimeout(() => {
        const currentActive = section.querySelector(".details__tab.active");
        if (currentActive) {
          updateIndicator(currentActive);
        }
      }, 100);
    });
  });
})();

/*	-----------------------------------------------------------------------------
	SECTION ANIMATIONS - TOGGLE SLIDER
--------------------------------------------------------------------------------- */
(function () {
  window.addEventListener("load", () => {
    const section = document.querySelector(".toggle-slider");
    if (!section) return;

    const tabs = section.querySelectorAll(".toggle-slider__tab");
    const tabContents = section.querySelectorAll(
      ".toggle-slider__slider-wrapper"
    );
    const indicator = section.querySelector(".toggle-slider__tab-indicator");
    const heading = section.querySelector("[data-active-tab-name]");
    const globalNextButton = section.querySelector(
      ".toggle-slider__header .swiper-button-next"
    );
    const globalPrevButton = section.querySelector(
      ".toggle-slider__header .swiper-button-prev"
    );

    if (!tabs.length || !tabContents.length || !indicator) return;

    // Store swiper instances
    const swiperInstances = new Map();

    // Initialize swipers for each slider
    tabContents.forEach((wrapper) => {
      const slider = wrapper.querySelector(".toggle-slider__slider");
      if (!slider) return;

      const slides = slider.querySelectorAll(".swiper-slide");
      const slideCount = slides.length;

      const swiper = new Swiper(slider, {
        slidesPerView: "auto",
        spaceBetween: 0,
        loop: slideCount > 3,
        speed: 600,
        navigation: {
          nextEl: globalNextButton,
          prevEl: globalPrevButton,
        },
      });

      swiperInstances.set(wrapper, { swiper, slideCount });
    });

    // Function to update navigation visibility based on slide count
    function updateNavigationVisibility(slideCount) {
      if (globalNextButton && globalPrevButton) {
        if (slideCount <= 3) {
          globalNextButton.style.display = "none";
          globalPrevButton.style.display = "none";
        } else {
          globalNextButton.style.display = "";
          globalPrevButton.style.display = "";
        }
      }
    }

    // Function to update indicator position
    function updateIndicator(activeTab) {
      const tabRect = activeTab.getBoundingClientRect();
      const navRect = activeTab.parentElement.getBoundingClientRect();
      const scrollLeft = activeTab.parentElement.scrollLeft;

      const left = tabRect.left - navRect.left + scrollLeft;
      const width = tabRect.width;

      indicator.style.transform = `translateX(${left}px)`;
      indicator.style.width = `${width}px`;
    }

    // Initialize indicator position and navigation visibility
    const activeTab = section.querySelector(".toggle-slider__tab.active");
    if (activeTab) {
      updateIndicator(activeTab);
      const activeWrapper = section.querySelector(
        `.toggle-slider__slider-wrapper[data-tab-content="${activeTab.getAttribute(
          "data-tab"
        )}"]`
      );
      if (activeWrapper && swiperInstances.has(activeWrapper)) {
        const { slideCount } = swiperInstances.get(activeWrapper);
        updateNavigationVisibility(slideCount);
      }
    }

    // Tab click handlers
    tabs.forEach((tab) => {
      tab.addEventListener("click", () => {
        const tabId = tab.getAttribute("data-tab");
        const tabName = tab.getAttribute("data-tab-name");

        // Update heading text
        if (heading && tabName) {
          heading.textContent = tabName;
        }

        // Remove active class from all tabs and contents
        tabs.forEach((t) => t.classList.remove("active"));
        tabContents.forEach((content) => content.classList.remove("active"));

        // Add active class to clicked tab and corresponding content
        tab.classList.add("active");
        const activeContent = section.querySelector(
          `.toggle-slider__slider-wrapper[data-tab-content="${tabId}"]`
        );
        if (activeContent) {
          activeContent.classList.add("active");

          // Update swiper for active content and navigation visibility
          if (swiperInstances.has(activeContent)) {
            const { swiper, slideCount } = swiperInstances.get(activeContent);
            swiper.update();
            updateNavigationVisibility(slideCount);
          }
        }

        // Update indicator position
        updateIndicator(tab);
      });
    });

    // Update indicator on window resize
    let resizeTimeout;
    window.addEventListener("resize", () => {
      clearTimeout(resizeTimeout);
      resizeTimeout = setTimeout(() => {
        const currentActive = section.querySelector(
          ".toggle-slider__tab.active"
        );
        if (currentActive) {
          updateIndicator(currentActive);
        }
      }, 100);
    });
  });
})();

/*	-----------------------------------------------------------------------------
	SECTION ANIMATIONS - SIDEBAR TABS
--------------------------------------------------------------------------------- */
(function () {
  window.addEventListener("load", () => {
    const section = document.querySelector(".sidebar-tabs");
    if (!section) return;
    const tabs = section.querySelectorAll(".sidebar-tabs__tab");
    const tabContents = section.querySelectorAll(".sidebar-tabs__content-item");

    if (!tabs.length || !tabContents.length) return;

    function resetTabs() {
      tabs.forEach((tab) => {
        tab.classList.remove("active");
      });
      tabContents.forEach((content) => {
        content.classList.remove("active");
      });
    }

    function activateTab(index) {
      resetTabs();
      tabs[index].classList.add("active");
      tabContents[index].classList.add("active");
    }

    function getCurrentActiveIndex() {
      return Array.from(tabs).findIndex((tab) =>
        tab.classList.contains("active")
      );
    }

    // Tab click handlers
    tabs.forEach((tab, index) => {
      tab.addEventListener("click", () => {
        activateTab(index);
      });
    });

    // Navigation button handlers
    const navigationButtons = section.querySelectorAll(
      ".sidebar-tabs__navigation-button"
    );
    navigationButtons.forEach((button) => {
      button.addEventListener("click", () => {
        const isPrev = button.classList.contains("--prev");
        const isNext = button.classList.contains("--next");
        const currentIndex = getCurrentActiveIndex();
        const totalTabs = tabs.length;

        let newIndex = currentIndex;

        if (isNext) {
          // Move to next tab, wrap to first if at end
          newIndex = (currentIndex + 1) % totalTabs;
        } else if (isPrev) {
          // Move to previous tab, wrap to last if at beginning
          newIndex = (currentIndex - 1 + totalTabs) % totalTabs;
        }

        activateTab(newIndex);
      });
    });
  });
})();

/*	-----------------------------------------------------------------------------
	SECTION ANIMATIONS - FAQ & ACCORDIONS
--------------------------------------------------------------------------------- */
(function () {
  let faqScrollTriggers = [];

  window.addEventListener("load", () => {
    // Initialize FAQ section if it exists
    const faqSection = document.querySelector(".faq");
    if (faqSection) {
      const groups = faqSection.querySelectorAll(".faq__group");
      const tabs = faqSection.querySelectorAll(".faq__tab");

      if (groups.length && tabs.length) {
        groups.forEach((group, index) => {
          const trigger = ScrollTrigger.create({
            trigger: group,
            start: "top 50%",
            end: "bottom 50%",
            onToggle: (self) => {
              if (self.isActive) {
                tabs[index].classList.add("active");
              } else {
                tabs[index].classList.remove("active");
              }
            },
          });
          faqScrollTriggers.push(trigger);
        });
      }
    }

    // Initialize ALL accordions (FAQ and standalone)
    const accordionSections = document.querySelectorAll(
      ".accordions__accordions"
    );
    if (accordionSections.length) {
      accordionSections.forEach((section) => {
        const accordions = section.querySelectorAll(".accordions__accordion");
        accordions.forEach((accordion) => {
          const header = accordion.querySelector(
            ".accordions__accordion-header"
          );
          if (header) {
            header.addEventListener("click", () => {
              accordion.classList.toggle("active");

              // Check if this accordion is inside a FAQ section
              const isInsideFAQ = accordion.closest(".faq");

              if (isInsideFAQ && faqScrollTriggers.length) {
                // For FAQ accordions: kill and recreate ScrollTriggers
                faqScrollTriggers.forEach((trigger) => trigger.kill());
                faqScrollTriggers = [];

                // Recreate ScrollTriggers after DOM settles
                setTimeout(() => {
                  const groups = faqSection.querySelectorAll(".faq__group");
                  const tabs = faqSection.querySelectorAll(".faq__tab");

                  groups.forEach((group, index) => {
                    const trigger = ScrollTrigger.create({
                      trigger: group,
                      start: "top 50%",
                      end: "bottom 50%",
                      onToggle: (self) => {
                        if (self.isActive) {
                          tabs[index].classList.add("active");
                        } else {
                          tabs[index].classList.remove("active");
                        }
                      },
                    });
                    faqScrollTriggers.push(trigger);
                  });
                }, 0);
              } else {
                // For standalone accordions: simple refresh
                ScrollTrigger.refresh();
              }
            });
          }
        });
      });
    }
  });
})();
/*	-----------------------------------------------------------------------------
	MARQUEE ANIMATION - REUSABLE
--------------------------------------------------------------------------------- */
(function () {
  window.ScrollTriggerComponents.registerCustomHandler("marquee");
  const marqueeInstances = new Map();
  let resizeTimeout;

  function initMarquee() {
    const marqueeElements = document.querySelectorAll("[data-marquee]");

    marqueeElements.forEach((track) => {
      // Kill existing animation for this track
      if (marqueeInstances.has(track)) {
        marqueeInstances.get(track).animation.kill();
      }

      const item = track.querySelector(".marquee__item");
      if (!item) return;

      // Get speed from data attribute or use default
      const speed =
        parseInt(track.dataset.marqueeSpeed) ||
        (deviceInfo.isMobile ? 100 : 200);
      const container = track.closest("[data-marquee-container]");

      setTimeout(() => {
        // Remove existing clones
        const existingClones = track.querySelectorAll(
          ".marquee__item:not(:first-child)"
        );
        existingClones.forEach((clone) => clone.remove());

        // Calculate how many clones we need
        const containerWidth = track.parentElement.offsetWidth;
        const itemWidth = item.offsetWidth;
        const clonesNeeded = Math.ceil(containerWidth / itemWidth) + 3;

        // Clone items
        for (let i = 0; i < clonesNeeded; i++) {
          const clone = item.cloneNode(true);
          track.appendChild(clone);
        }

        // Reset position
        gsap.set(track, { x: 0 });

        // Calculate animation
        const animationDistance = itemWidth;
        const tl = gsap.timeline({ repeat: -1 });
        tl.to(track, {
          x: -animationDistance,
          duration: animationDistance / speed,
          ease: "none",
        }).set(track, { x: 0 });

        // Store animation instance
        marqueeInstances.set(track, {
          animation: tl,
          speed: speed,
        });

        // Enable GPU acceleration
        gsap.set(track, {
          force3D: true,
          willChange: "transform",
        });

        // Add hover handlers if container exists
        if (container) {
          const pauseOnHover = container.dataset.marqueePause !== "false";

          if (pauseOnHover) {
            container.addEventListener("mouseenter", () => {
              gsap.to(tl, { timeScale: 0.3, duration: 0.3 });
            });

            container.addEventListener("mouseleave", () => {
              gsap.to(tl, { timeScale: 1, duration: 0.3 });
            });
          }
        }
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
})();
/*	-----------------------------------------------------------------------------
	HEADER
--------------------------------------------------------------------------------- */

(function () {
  const siteHeader = document.querySelector(".site-header");
  const searchToggle = document.querySelector(
    ".main-navigation__search-toggle"
  );
  const searchClose = document.querySelector(".main-navigation__search-close");
  const searchInput = document.querySelector(".main-navigation__search-input");
  const siteHeaderToggle = document.querySelector(".site-header__toggle");
  searchToggle.addEventListener("click", () => {
    document.body.classList.toggle("search-open");
    setTimeout(() => {
      searchInput.focus();
    }, 100);
  });
  searchClose.addEventListener("click", () => {
    document.body.classList.remove("search-open");
  });

  siteHeaderToggle.addEventListener("click", () => {
    document.body.classList.toggle("site-header-open");
  });
})();

/*	-----------------------------------------------------------------------------
	MEGA MENU - MOBILE
--------------------------------------------------------------------------------- */

(function () {
  if (deviceInfo.isMobile) {
    const menuItems = document.querySelectorAll(
      ".main-navigation .menu-item--level-0"
    );
    menuItems.forEach((item) => {
      const menuItemLink = item.querySelector(".menu-item__link");
      menuItemLink.addEventListener("click", (e) => {
        e.preventDefault();
        item.classList.toggle("is-open");
        menuItemLink.classList.toggle("is-open");
      });
    });
  }
})();

/*	-----------------------------------------------------------------------------
	BUTTON RIPPLE EFFECTS
--------------------------------------------------------------------------------- */
(function () {
  function initButtonRipple() {
    const buttons = document.querySelectorAll(".button");
    buttons.forEach((button) => {
      button.removeEventListener("mouseenter", handleButtonEnter);
      button.removeEventListener("mouseleave", handleButtonLeave);
      button.addEventListener("mouseenter", handleButtonEnter);
      button.addEventListener("mouseleave", handleButtonLeave);
    });
  }
  function handleButtonEnter(e) {
    const button = e.currentTarget;
    const rect = button.getBoundingClientRect();
    const x = e.clientX - rect.left;
    const y = e.clientY - rect.top;
    const corners = [
      { x: 0, y: 0 },
      { x: rect.width, y: 0 },
      { x: 0, y: rect.height },
      { x: rect.width, y: rect.height },
    ];
    const maxDistance = Math.max(
      ...corners.map((corner) =>
        Math.sqrt(Math.pow(corner.x - x, 2) + Math.pow(corner.y - y, 2))
      )
    );
    const diameter = maxDistance * 2;
    gsap.set(button, {
      "--ripple-x": x + "px",
      "--ripple-y": y + "px",
      "--ripple-size": diameter + "px",
    });
    gsap.to(button, {
      "--ripple-scale": 1,
      duration: 0.4,
      ease: "power2.out",
    });
  }
  function handleButtonLeave(e) {
    const button = e.currentTarget;
    gsap.to(button, {
      "--ripple-scale": 0,
      duration: 0.3,
      ease: "power2.inOut",
      onComplete: () => {
        gsap.set(button, {
          "--ripple-x": "50%",
          "--ripple-y": "50%",
          "--ripple-size": "0px",
        });
      },
    });
  }
  window.addEventListener("load", initButtonRipple);
})();

/*	-----------------------------------------------------------------------------
	RESPONSIVE VIDEO OPTIMIZATION
--------------------------------------------------------------------------------- */
(function () {
  "use strict";

  function isMobileViewport() {
    return window.innerWidth <= 768;
  }

  function switchVideoSource(video) {
    const desktopSrc = video.getAttribute("data-desktop-src");
    const desktopType = video.getAttribute("data-desktop-type");
    const mobileSrc = video.getAttribute("data-mobile-src");
    const mobileType = video.getAttribute("data-mobile-type");

    if (!desktopSrc || !mobileSrc) {
      console.warn(
        "⚠️ Missing video sources - desktop or mobile src not found"
      );
      return;
    }

    const source = video.querySelector("source");
    if (!source) {
      console.warn("⚠️ No source element found in video");
      return;
    }

    const currentTime = video.currentTime;
    const wasPlaying = !video.paused;
    const isMobile = isMobileViewport();
    const currentSrc = source.src;

    if (isMobile) {
      // Switch to mobile video
      if (source.src !== mobileSrc) {
        source.src = mobileSrc;
        source.type = mobileType;
        video.load();
        if (wasPlaying) {
          video.currentTime = currentTime;
          video.play().catch((error) => {});
        }
      }
    } else {
      // Switch to desktop video
      if (source.src !== desktopSrc) {
        source.src = desktopSrc;
        source.type = desktopType;
        video.load();
        if (wasPlaying) {
          video.currentTime = currentTime;
          video.play().catch((error) => {});
        }
      } else {
      }
    }
  }

  function optimizeResponsiveVideos() {
    const responsiveVideos = document.querySelectorAll(
      'video[data-responsive="true"]'
    );

    responsiveVideos.forEach((video, index) => {
      // Set initial video source based on viewport
      switchVideoSource(video);

      // Optimize preload settings
      if (deviceInfo.prefersReducedData) {
        video.setAttribute("preload", "none");
        return;
      }
      if (deviceInfo.isSlowConnection) {
        video.setAttribute("preload", "metadata");
      } else {
        video.setAttribute("preload", "auto");
      }
    });
  }

  function handleResponsiveVideoResize() {
    const responsiveVideos = document.querySelectorAll(
      'video[data-responsive="true"]'
    );

    responsiveVideos.forEach((video, index) => {
      switchVideoSource(video);
    });
  }

  // Initialize on load
  window.addEventListener("load", () => {
    optimizeResponsiveVideos();
  });

  // Handle viewport changes with debouncing
  let resizeTimeout;
  window.addEventListener("resize", () => {
    clearTimeout(resizeTimeout);
    resizeTimeout = setTimeout(() => {
      handleResponsiveVideoResize();
    }, 250);
  });

  // Handle orientation changes for mobile devices
  window.addEventListener("orientationchange", () => {
    setTimeout(() => {
      handleResponsiveVideoResize();
    }, 300);
  });
})();

/*	-----------------------------------------------------------------------------
	PAGE LOADING STATE
--------------------------------------------------------------------------------- */
(function () {
  window.addEventListener("load", () => {
    setTimeout(() => {
      document.body.classList.remove("loading");
    }, 100);
  });
})();

/*	-----------------------------------------------------------------------------
	SECTION ANIMATIONS - POSTS (Filter & Load More)
--------------------------------------------------------------------------------- */
(function () {
  const postsSection = document.querySelector(".posts");
  if (!postsSection) return;

  const postsContainer = postsSection.querySelector(".posts__posts");
  const filters = postsSection.querySelectorAll(".posts__filter");
  const resultsCount = postsSection.querySelector(".posts__results-count");
  const loadMoreButton = postsSection.querySelector(".posts__load-more-button");
  const loadMoreContainer = postsSection.querySelector(".posts__load-more");
  const loadingOverlay = postsSection.querySelector(".posts__loading-overlay");

  if (!postsContainer) return;

  const postType = postsContainer.dataset.postType;
  const taxonomy = postsContainer.dataset.taxonomy;
  const postsPerPage = parseInt(postsContainer.dataset.postsPerPage) || 8;
  let currentPage = 1;
  let currentTermId = "all";
  let isLoading = false;

  // Tooltip functionality for mobile
  const isTouchDevice =
    "ontouchstart" in window || navigator.maxTouchPoints > 0;

  if (isTouchDevice) {
    // Handle tooltip toggling on mobile
    filters.forEach((filter) => {
      const tooltip = filter.querySelector(".posts__tooltip");
      if (!tooltip) return;

      // Prevent default filter action when clicking tooltip icon
      const icon = filter.querySelector(".posts__filter-icon");
      if (icon) {
        icon.addEventListener("click", function (e) {
          e.stopPropagation(); // Prevent filter click

          // Close all other tooltips
          document.querySelectorAll(".posts__tooltip.active").forEach((t) => {
            if (t !== tooltip) t.classList.remove("active");
          });

          // Toggle this tooltip
          tooltip.classList.toggle("active");
        });
      }
    });

    // Close tooltips when clicking outside
    document.addEventListener("click", function (e) {
      if (!e.target.closest(".posts__filter")) {
        document.querySelectorAll(".posts__tooltip.active").forEach((t) => {
          t.classList.remove("active");
        });
      }
    });
  }

  // Filter click handler
  filters.forEach((filter) => {
    filter.addEventListener("click", function (e) {
      // Don't trigger filter if clicking tooltip icon on mobile
      if (isTouchDevice && e.target.closest(".posts__filter-icon")) {
        return;
      }

      if (isLoading) return;

      // Close any open tooltips
      if (isTouchDevice) {
        document.querySelectorAll(".posts__tooltip.active").forEach((t) => {
          t.classList.remove("active");
        });
      }

      // Update active state
      filters.forEach((f) => f.classList.remove("active"));
      this.classList.add("active");

      // Get filter data
      currentTermId = this.dataset.termId;
      currentPage = 1;

      // Load filtered posts
      loadPosts(true);
    });
  });

  // Load more click handler
  if (loadMoreButton) {
    loadMoreButton.addEventListener("click", function () {
      if (isLoading) return;
      currentPage++;
      loadPosts(false);
    });
  }

  // Load posts function
  function loadPosts(replaceContent = false) {
    if (isLoading) return;
    isLoading = true;

    // Show loading overlay for filter changes
    if (replaceContent && loadingOverlay) {
      loadingOverlay.classList.add("active");
    }

    // Show loading state for load more button
    if (!replaceContent && loadMoreButton) {
      loadMoreButton.textContent = "Loading...";
      loadMoreButton.disabled = true;
    }

    const formData = new FormData();
    formData.append("action", "load_more_posts");
    formData.append("post_type", postType);
    formData.append("posts_per_page", postsPerPage);
    formData.append("page", currentPage);

    if (currentTermId !== "all" && taxonomy) {
      formData.append("filter_term", taxonomy);
      formData.append("term_id", currentTermId);
    }

    fetch(ajax_object.ajax_url, {
      method: "POST",
      body: formData,
    })
      .then((response) => response.json())
      .then((data) => {
        if (data.posts_html) {
          if (replaceContent) {
            postsContainer.innerHTML = data.posts_html;
          } else {
            postsContainer.insertAdjacentHTML("beforeend", data.posts_html);
          }

          // Update results count
          if (resultsCount) {
            resultsCount.textContent = data.total_posts;
          }

          // Update load more button visibility
          if (loadMoreContainer) {
            if (data.has_more_posts) {
              loadMoreContainer.style.display = "";
            } else {
              loadMoreContainer.style.display = "none";
            }
          }

          // Update current page in dataset
          postsContainer.dataset.currentPage = data.current_page;
        }

        // Hide loading states
        isLoading = false;
        if (loadingOverlay) {
          loadingOverlay.classList.remove("active");
        }
        if (loadMoreButton) {
          loadMoreButton.textContent = "Load More";
          loadMoreButton.disabled = false;
        }
      })
      .catch((error) => {
        console.error("Error loading posts:", error);

        // Hide loading states on error
        isLoading = false;
        if (loadingOverlay) {
          loadingOverlay.classList.remove("active");
        }
        if (loadMoreButton) {
          loadMoreButton.textContent = "Load More";
          loadMoreButton.disabled = false;
        }
      });
  }
})();
