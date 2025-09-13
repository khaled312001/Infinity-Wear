// Scroll reveal for `.reveal` and `.reveal-stagger`
(function () {
  if (typeof window === 'undefined') return;

  const revealEls = Array.from(document.querySelectorAll('.reveal'));
  const revealStaggerEls = Array.from(document.querySelectorAll('.reveal-stagger'));

  if (!('IntersectionObserver' in window)) {
    revealEls.forEach(el => el.classList.add('is-visible'));
    revealStaggerEls.forEach(el => el.classList.add('is-visible'));
    return;
  }

  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('is-visible');
        observer.unobserve(entry.target);
      }
    });
  }, { threshold: 0.15 });

  revealEls.forEach(el => observer.observe(el));
  revealStaggerEls.forEach(el => observer.observe(el));

  // Enhance buttons/cards with hover lift if they opt-in
  document.querySelectorAll('[data-hover-lift]')
    .forEach(el => el.classList.add('hover-lift'));

  // Progressive enhancement for anchor underline animation
  document.querySelectorAll('a[data-underline]')
    .forEach(a => a.classList.add('underline-animate'));

  // Optional: float effect for featured visual elements
  document.querySelectorAll('[data-float-soft]')
    .forEach(el => el.classList.add('float-soft'));
})();
