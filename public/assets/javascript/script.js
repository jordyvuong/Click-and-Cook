gsap.registerPlugin(ScrollTrigger);

gsap.fromTo(
  ".leftCol",
  {
    x: -50,

    opacity: 0, // Valeur initiale
  },
  {
    x: 0,
    duration: 1,
    opacity: 1, // Valeur finale
    scrollTrigger: {
      trigger: ".leftCol",
      start: "top 90%",
      toggleActions: "play pause play pause", // Modifie les actions selon les événements
    },
  }
);

gsap.fromTo(
  ".rightCol",
  {
    x: 50,

    opacity: 0, // Valeur initiale
  },
  {
    x: 0,
    duration: 1,
    opacity: 1, // Valeur finale
    scrollTrigger: {
      trigger: ".rightCol",
      start: "top 44%",
      toggleActions: "play pause play pause", // Modifie les actions selon les événements
    },
  }
);

gsap.fromTo(
  ".makeRecipe",
  {
    y: 50,

    opacity: 0, // Valeur initiale
  },
  {
    y: 0,

    opacity: 1, // Valeur finale
    scrollTrigger: {
      trigger: ".makeRecipe",
      start: "top 110%",
      end: "top 25%",
      scrub: true,

      toggleActions: "restart pause restart pause", // Modifie les actions selon les événements
    },
  }
);

gsap.fromTo(
  ".leftAnim",
  {
    x: -50,

    opacity: 0, // Valeur initiale
  },
  {
    x: 0,

    opacity: 1, // Valeur finale
    scrollTrigger: {
      trigger: ".leftAnim",
      start: "top 70%",
      end: "top 25%",
      scrub: true,
      toggleActions: "restart pause reverse pause", // Modifie les actions selon les événements
    },
  }
);

gsap.fromTo(
  ".rightAnim",
  {
    x: 50,

    opacity: 0, // Valeur initiale
  },
  {
    x: 0,

    opacity: 1, // Valeur finale
    scrollTrigger: {
      trigger: ".rightAnim",
      start: "top 70%",
      end: "top 25%",
      scrub: true,
      toggleActions: "restart pause reverse pause", // Modifie les actions selon les événements
    },
  }
);

gsap.fromTo(
  ".travelAnim.One",
  {
    y: 50,

    opacity: 0, // Valeur initiale
  },
  {
    y: 0,

    opacity: 1, // Valeur finale
    scrollTrigger: {
      trigger: ".travelAnim.One",
      start: "top 120%",
      end: "top 25%",
      scrub: true,
      toggleActions: "restart pause reverse pause", // Modifie les actions selon les événements
    },
  }
);

gsap.fromTo(
  ".travelAnim.Two",
  {
    y: 50,

    opacity: 0, // Valeur initiale
  },
  {
    y: 0,

    opacity: 1, // Valeur finale
    scrollTrigger: {
      trigger: ".travelAnim.Two",
      start: "top 70%",
      end: "top 25%",
      scrub: true,

      toggleActions: "restart pause reverse pause", // Modifie les actions selon les événements
    },
  }
);

gsap.fromTo(
  ".faqLeft",
  {
    x: -50,

    opacity: 0, // Valeur initiale
  },
  {
    x: 0,

    opacity: 1, // Valeur finale
    scrollTrigger: {
      trigger: ".faqLeft",
      start: "top 120%",
      end: "top 60%",
      scrub: true,
      toggleActions: "restart pause reverse pause", // Modifie les actions selon les événements
    },
  }
);

gsap.fromTo(
  ".faqRight",
  {
    x: 50,

    opacity: 0, // Valeur initiale
  },
  {
    x: 0,

    opacity: 1, // Valeur finale
    scrollTrigger: {
      trigger: ".faqRight",
      start: "top 120%",
      end: "top 70%",
      scrub: true,
      toggleActions: "restart pause reverse pause", // Modifie les actions selon les événements
    },
  }
);
