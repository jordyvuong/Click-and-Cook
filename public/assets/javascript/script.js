gsap.registerPlugin(ScrollTrigger);

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
      start: "top 70%",
      end: "top 25%",
      markers: true,
      scrub: true,
      toggleActions: "restart pause reverse pause", // Modifie les actions selon les événements
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
      markers: true,
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
      markers: true,
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
      markers: true,
      scrub: true,
      toggleActions: "restart pause reverse pause", // Modifie les actions selon les événements
    },
  }
);
