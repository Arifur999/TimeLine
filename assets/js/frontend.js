/**
 * Static Timeline Widget – Frontend JavaScript
 * Features:
 *  1. Scroll-triggered card reveal (IntersectionObserver)
 *  2. Progressive vertical line draw as user scrolls
 */
(function () {
    'use strict';

    document.addEventListener('DOMContentLoaded', function () {

        // ── Find all timeline wrappers on page ──
        var wrappers = document.querySelectorAll('.stw-animate');

        wrappers.forEach(function (wrapper) {

            var items   = wrapper.querySelectorAll('.stw-hidden');
            var line    = wrapper.querySelector('.stw-line');
            var track   = wrapper.querySelector('.stw-line-track');

            // ── 1. Card reveal via IntersectionObserver ──
            if ('IntersectionObserver' in window && items.length) {
                var cardObserver = new IntersectionObserver(function (entries) {
                    entries.forEach(function (entry) {
                        if (entry.isIntersecting) {
                            entry.target.classList.add('stw-visible');
                            cardObserver.unobserve(entry.target);
                        }
                    });
                }, {
                    threshold: 0.15,
                    rootMargin: '0px 0px -60px 0px'
                });

                items.forEach(function (item) {
                    cardObserver.observe(item);
                });
            } else {
                // Fallback: show all if no IntersectionObserver
                items.forEach(function (item) {
                    item.classList.add('stw-visible');
                });
            }

            // ── 2. Scroll-driven line growth ──
            if (line && track) {
                function updateLine() {
                    var trackRect  = track.getBoundingClientRect();
                    var trackTop   = trackRect.top + window.pageYOffset;
                    var trackH     = track.offsetHeight;
                    var scrollPos  = window.pageYOffset + window.innerHeight * 0.75;
                    var progress   = (scrollPos - trackTop) / trackH;

                    progress = Math.min(Math.max(progress, 0), 1);
                    line.style.height = (progress * 100) + '%';
                }

                // Initial call
                updateLine();

                // On scroll – throttled with requestAnimationFrame
                var ticking = false;
                window.addEventListener('scroll', function () {
                    if (!ticking) {
                        window.requestAnimationFrame(function () {
                            updateLine();
                            ticking = false;
                        });
                        ticking = true;
                    }
                });

                // Also update on resize
                window.addEventListener('resize', updateLine);
            }
        });
    });

})();
