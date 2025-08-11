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
    const swiper = new Swiper(slider, {
      slidesPerView: "auto",
      loop: true,
      centeredSlides: true,
      speed: 600,
      navigation: {
        nextEl: nextButton,
        prevEl: prevButton,
      },
    });
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
    // Create a ScrollTrigger specifically for scroll detection
    ScrollTrigger.create({
      trigger: "body",
      start: "top top",
      end: "bottom bottom",
      onUpdate: (self) => {
        const currentScrollY = self.scroll();
        const scrollThreshold = 10;
        const topThreshold = 5;
        const directionThreshold = 3; // Minimum movement to change direction

        // Only update direction if scroll difference is significant
        const scrollDiff = currentScrollY - lastScrollY;
        if (Math.abs(scrollDiff) > directionThreshold) {
          isScrollingUp = scrollDiff < 0;
        }

        const isAtTop = currentScrollY <= topThreshold;
        const isScrolled = currentScrollY > scrollThreshold;

        // Update body classes with smoother logic
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

  // Initialize when animations are ready
  window.addEventListener("load", () => {
    setTimeout(() => {
      initScrollDetection();
      // Set initial state
      const currentScrollY = window.scrollY;
      document.body.classList.toggle("scrolled", currentScrollY > 10);
      document.body.classList.toggle("at-top", currentScrollY <= 5);
      document.body.classList.toggle("scrolling-up", false);
    }, 600); // Wait for other animations to initialize
  });
})();
/*	-----------------------------------------------------------------------------
	ANIMATION INITIALIZATION
--------------------------------------------------------------------------------- */
(function () {
  function initWordAnimations() {
    const textElements = document.querySelectorAll("[data-animate-words]");
    textElements.forEach((element) => {
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
    }, 500);
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
        createHeroScrollTrigger();
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
	MARQUEE ANIMATION
--------------------------------------------------------------------------------- */
(function () {
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
        const speed = deviceInfo.isMobile ? 100 : 200;
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
	PAGE LOADING STATE
--------------------------------------------------------------------------------- */
(function () {
  window.addEventListener("load", () => {
    document.body.classList.remove("loading");
  });
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
  function optimizeResponsiveVideos() {
    const responsiveVideos = document.querySelectorAll(
      'video[data-responsive="true"]'
    );
    responsiveVideos.forEach((video) => {
      if (deviceInfo.prefersReducedData) {
        video.setAttribute("preload", "none");
        return;
      }
      if (deviceInfo.isSlowConnection) {
        video.setAttribute("preload", "metadata");
      } else {
        video.setAttribute("preload", "auto");
      }
      if (deviceInfo.isMobile) {
        let orientationTimeout;
        window.addEventListener("orientationchange", () => {
          clearTimeout(orientationTimeout);
          orientationTimeout = setTimeout(() => {
            video.load();
          }, 300);
        });
      }
    });
  }
  window.addEventListener("load", optimizeResponsiveVideos);
})();
