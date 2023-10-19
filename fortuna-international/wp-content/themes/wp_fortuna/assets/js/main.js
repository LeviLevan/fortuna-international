;var wp_fortuna;

(function($) {
	'use strict';

	wp_fortuna = {

	init: function() {
		this.pageLoading();
		this.firstWord();
		//this.counterSlider();
	},
	counterSlider:function(){
		$('#counter-slider').slick({
		  responsive: [
		    {
		      breakpoint: 1200,
		      settings: {
		        slidesToShow: 3,
		      },
		    },
		    {
		      breakpoint: 1024,
		      settings: {
		        slidesToShow: 3,
		      },
		    },
		    {
		      breakpoint: 800,
		      settings: 'unslick',
		    },
		  ],
		})
	},
	// initAnimateButton:function(){
	// 	var fadeBottomUpLineItems = document.querySelectorAll('.elementor-widget-button .elementor-widget-container .elementor-button-wrapper a.elementor-button-link');
 //        [].forEach.call(fadeBottomUpLineItems, function(item) {
 //            var splitText = new SplitText(item,{
 //                type: "lines"
 //            });
 //            gsap.fromTo(splitText.lines, item.dataset.animationSpeed ? item.dataset.animationSpeed : 0.8, {
 //                yPercent: 80,
 //                opacity: 0
 //            }, {
 //                visibility: 'visible',
 //                yPercent: 0,
 //                opacity: 1,
 //                delay: item.dataset.animationDelay ? item.dataset.animationDelay : 0.5,
 //                stagger: 0.12,
 //                scrollTrigger: item,
 //                ease: item.dataset.animationType ? item.dataset.animationType : 'pixit-out',
 //                onComplete: function() {
 //                    splitText.revert();
 //                    item.style.visibility = "visible"
 //                }
 //            })
 //        });
	// },
	initAnimateImage:function() {
		var fadeBottomUpImages = document.querySelectorAll('.elementor-widget-image img');
        [].forEach.call(fadeBottomUpImages, function(item) {
            gsap.fromTo(item, item.dataset.animationSpeed ? item.dataset.animationSpeed : 0.8, {
                yPercent: 20,
                opacity: 0
            }, {
                visibility: 'visible',
                yPercent: 0,
                opacity: 1,
                delay: item.dataset.animationDelay ? item.dataset.animationDelay : 0.5,
                scrollTrigger: item,
                ease: item.dataset.animationType ? item.dataset.animationType : 'pixit-out'
            })
        });
	},
	initAnimateText:function(){
		var fadeBottomUpLineItems = document.querySelectorAll('.elementor-widget-text-editor p');
        [].forEach.call(fadeBottomUpLineItems, function(item) {
            var splitText = new SplitText(item,{
                type: "lines"
            });
            gsap.fromTo(splitText.lines, item.dataset.animationSpeed ? item.dataset.animationSpeed : 0.8, {
                yPercent: 80,
                opacity: 0
            }, {
                visibility: 'visible',
                yPercent: 0,
                opacity: 1,
                delay: item.dataset.animationDelay ? item.dataset.animationDelay : 0.5,
                stagger: 0.12,
                scrollTrigger: item,
                ease: item.dataset.animationType ? item.dataset.animationType : 'pixit-out',
                onComplete: function() {
                    splitText.revert();
                    item.style.visibility = "visible"
                }
            })
        });
	},
	initAnimateTextMob:function(){
		var fadeBottomUpLineItems = document.querySelectorAll('.elementor-widget-text-editor p');
        [].forEach.call(fadeBottomUpLineItems, function(item) {
            var splitText = new SplitText(item,{
                type: "lines"
            });
            gsap.fromTo(splitText.lines, item.dataset.animationSpeed ? item.dataset.animationSpeed : 0.6, {
                yPercent: 80,
                opacity: 0
            }, {
                visibility: 'visible',
                yPercent: 0,
                opacity: 1,
                delay: item.dataset.animationDelay ? item.dataset.animationDelay : 0.3,
                stagger: 0.12,
                scrollTrigger: item,
                ease: item.dataset.animationType ? item.dataset.animationType : 'pixit-out',
                onComplete: function() {
                    splitText.revert();
                    item.style.visibility = "visible"
                }
            })
        });
	},
	initAnimateButton:function() {
		var fadeBottomUpImages = document.querySelectorAll('.elementor-widget-button .elementor-widget-container .elementor-button-wrapper a.elementor-button-link');
        [].forEach.call(fadeBottomUpImages, function(item) {
            gsap.fromTo(item, item.dataset.animationSpeed ? item.dataset.animationSpeed : 0.8, {
                yPercent: 20,
                opacity: 0
            }, {
                visibility: 'visible',
                yPercent: 0,
                opacity: 1,
                delay: item.dataset.animationDelay ? item.dataset.animationDelay : 0.9,
                scrollTrigger: item,
                ease: item.dataset.animationType ? item.dataset.animationType : 'pixit-out'
            })
        });
    },
    initAnimateBlock:function() {
		var fadeBottomUpImages = document.querySelectorAll('.elementor-widget-icon-list');
        [].forEach.call(fadeBottomUpImages, function(item) {
            gsap.fromTo(item, item.dataset.animationSpeed ? item.dataset.animationSpeed : 0.8, {
                yPercent: 20,
                opacity: 0
            }, {
                visibility: 'visible',
                yPercent: 0,
                opacity: 1,
                delay: item.dataset.animationDelay ? item.dataset.animationDelay : 0.8,
                scrollTrigger: item,
                ease: item.dataset.animationType ? item.dataset.animationType : 'pixit-out'
            })
        });
    },
	firstWord:function(){
		var element = document.getElementsByClassName('.jet-listing-dynamic-field__content')
		$('.jet-listing-dynamic-field__content').each(function(){
		  var title = $(this);
		  title.html( title.text().replace(/(^\w+)/,'<span class="big-font">$1</span>') );
		});
	},
	initAnimateTitle:function() {
		gsap.registerPlugin(SplitText);
        var fadeBottomUpLineRevealItems = document.querySelectorAll('.elementor-widget-heading');
        [].forEach.call(fadeBottomUpLineRevealItems, function(item) {
            var splitText = new SplitText(item.querySelector('.elementor-heading-title'),{
                type: "lines"
            });
            gsap.set(splitText.lines, {
                y: splitText.lines.length * 100 + '%',
                onComplete: function() {
                    gsap.set(item.querySelector('.elementor-heading-title'), {
                        visibility: 'visible'
                    });
                    gsap.to(splitText.lines, item.dataset.animationSpeed ? item.dataset.animationSpeed : 0.8, {
                        y: 0,
                        delay: item.dataset.animationDelay ? item.dataset.animationDelay : 0.5,
                        stagger: 0.1,
                        scrollTrigger: item,
                        ease: item.dataset.animationType ? item.dataset.animationType : 'pixit-out',
                        onComplete: function() {
                            splitText.revert();
                            item.style.visibility = "visible"
                        }
                    })
                }
            })
        });
    },
    initAnimateTitleMob:function() {
		gsap.registerPlugin(SplitText);
        var fadeBottomUpLineRevealItems = document.querySelectorAll('.elementor-widget-heading');
        [].forEach.call(fadeBottomUpLineRevealItems, function(item) {
            var splitText = new SplitText(item.querySelector('.elementor-heading-title'),{
                type: "lines"
            });
            gsap.set(splitText.lines, {
                y: splitText.lines.length * 100 + '%',
                onComplete: function() {
                    gsap.set(item.querySelector('.elementor-heading-title'), {
                        visibility: 'visible'
                    });
                    gsap.to(splitText.lines, item.dataset.animationSpeed ? item.dataset.animationSpeed : 0.6, {
                        y: 0,
                        delay: item.dataset.animationDelay ? item.dataset.animationDelay : 0.3,
                        stagger: 0.1,
                        scrollTrigger: item,
                        ease: item.dataset.animationType ? item.dataset.animationType : 'pixit-out',
                        onComplete: function() {
                            splitText.revert();
                            item.style.visibility = "visible"
                        }
                    })
                }
            })
        });
    },
	pageLoading:function(){
		if( window.innerWidth >= 768 ){
		    var _this = this;
		    var loading = document.querySelectorAll('.loading');
		    document.body.classList.add('overflow-hidden');
		    var interval = setInterval(function() {
	        if (document.readyState === 'complete') {
	            clearInterval(interval);
	            gsap.timeline({
	              	onComplete: ()=>{
	                    [].forEach.call(loading, function(element) {
		                    gsap.set(element, {
		                        display: 'none'
		                    })
	                 	});
	                    _this.initAnimateTitle();
	                    _this.initAnimateText();
	                    _this.initAnimateButton();
	                    _this.initAnimateBlock();
	                    _this.initAnimateImage();
	                }
	                }).add([
	                	gsap.to(['.loading.loading-1.slide .reveal-item'], 1, {
	                    xPercent: 0,
	                    yPercent: -101,
	                    delay: 0,
	                    force3D: !0,
	                    ease: "pixit-in-out"
	                }), gsap.to(['.loading.loading-1.slide .reveal-item .reveal-item-inner'], 1, {
	                    xPercent: 0,
	                    yPercent: 101,
	                    delay: 0,
	                    force3D: !0,
	                    ease: "pixit-in-out"
	                }), gsap.to(['.loading.loading-2.slide .reveal-item'], 1, {
	                    xPercent: 0,
	                    yPercent: -101,
	                    delay: 0.2,
	                    force3D: !0,
	                    ease: "pixit-in-out"
	                }), gsap.to(['.loading.loading-2.slide .reveal-item .reveal-item-inner'], 1, {
	                    xPercent: 0,
	                    yPercent: 101,
	                    delay: 0.2,
	                    force3D: !0,
	                    ease: "pixit-in-out"
	                })
	                ]);
	                document.body.classList.remove('overflow-hidden')
	            }
	        }, 10)
		} else {
		var _this = this;
	    var loading = document.querySelectorAll('.loading');
	    document.body.classList.add('overflow-hidden');
	    var interval = setInterval(function() {
	        if (document.readyState === 'complete') {
	            clearInterval(interval);
	            gsap.timeline({
	              	onComplete: ()=>{
	                    [].forEach.call(loading, function(element) {
		                    gsap.set(element, {
		                        display: 'none'
		                    })
	                 	});
	                    _this.initAnimateTitleMob();
	                    _this.initAnimateTextMob();
	                    _this.initAnimateButton();
	                    _this.initAnimateBlock();
	                    _this.initAnimateImage();
	                }
	                })
	                document.body.classList.remove('overflow-hidden')
	            }
	        }, 10)
		}
	},


	};

	$(document).ready(function(){
		wp_fortuna.init();
	})

}(jQuery));