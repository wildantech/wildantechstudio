const revealTargets = document.querySelectorAll('[data-reveal]');
const midnightMoonTheme = document.querySelector('.theme-midnight-moon');

if (midnightMoonTheme) {
    document.addEventListener('visibilitychange', () => {
        midnightMoonTheme.classList.toggle('animations-paused', document.hidden);
    });
}

if ('IntersectionObserver' in window) {
    const revealObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                entry.target.classList.add('is-visible');
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.12 });

    revealTargets.forEach((target) => {
        target.classList.add('reveal-on-scroll');
        revealObserver.observe(target);
    });
} else {
    revealTargets.forEach((target) => target.classList.add('is-visible'));
}
