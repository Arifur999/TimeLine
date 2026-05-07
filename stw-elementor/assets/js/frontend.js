/* Static Timeline for Elementor – Frontend JS */
(function(){
'use strict';

function initTimeline(wrap){
    var items = wrap.querySelectorAll('.stwel-hide');
    var line  = wrap.querySelector('.stwel-line');
    var track = wrap.querySelector('.stwel-track');

    /* Card reveal */
    if('IntersectionObserver' in window && items.length){
        var io = new IntersectionObserver(function(entries){
            entries.forEach(function(e){
                if(e.isIntersecting){
                    e.target.classList.add('stwel-show');
                    io.unobserve(e.target);
                }
            });
        },{threshold:0.15, rootMargin:'0px 0px -60px 0px'});
        items.forEach(function(el){ io.observe(el); });
    } else {
        items.forEach(function(el){ el.classList.add('stwel-show'); });
    }

    /* Progressive line draw */
    if(!line || !track) return;
    var ticking = false;
    function drawLine(){
        var r   = track.getBoundingClientRect();
        var top = r.top + window.pageYOffset;
        var h   = track.offsetHeight;
        var p   = (window.pageYOffset + window.innerHeight * 0.75 - top) / h;
        p = Math.min(Math.max(p,0),1);
        line.style.height = (p*100)+'%';
    }
    drawLine();
    window.addEventListener('scroll', function(){
        if(!ticking){
            requestAnimationFrame(function(){ drawLine(); ticking=false; });
            ticking=true;
        }
    });
    window.addEventListener('resize', drawLine);
}

function init(){
    document.querySelectorAll('.stwel-anim').forEach(initTimeline);
}

/* Works with Elementor frontend */
if(typeof elementorFrontend !== 'undefined'){
    elementorFrontend.hooks.addAction('frontend/element_ready/static_timeline.default', function($scope){
        var w = $scope[0] ? $scope[0].querySelector('.stwel-anim') : null;
        if(w) initTimeline(w);
    });
}

document.addEventListener('DOMContentLoaded', init);

})();
