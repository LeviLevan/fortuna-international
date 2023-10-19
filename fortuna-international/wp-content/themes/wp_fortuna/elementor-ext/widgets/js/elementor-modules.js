(function($, elementor) {

    "use strict";

    var wp_fortuna = {

        init: function() {
            var widgets = {
               
                'custom-testimonial-carousel.default': wp_fortuna.carouselInit,
            };

            $.each(widgets, function(widget, callback) {
                window.elementorFrontend.hooks.addAction('frontend/element_ready/' + widget, callback);
            });
        },
        carouselInit: function($scope) {
            var owl = $(".owl-carousel", $scope),
                slick = $('.slick-slider', $scope),
                isNoviBuilder = false;

            function initOwlCarousel(c) {
                var aliaces = ["-", "-sm-", "-md-", "-lg-", "-xl-", "-xxl-"],
                    values = [0, 576, 768, 992, 1200, 1600],
                    responsive = {};

                for (var j = 0; j < values.length; j++) {
                    responsive[values[j]] = {};
                    for (var k = j; k >= -1; k--) {
                        if (!responsive[values[j]]["items"] && c.attr("data" + aliaces[k] + "items")) {
                            responsive[values[j]]["items"] = k < 0 ? 1 : parseInt(c.attr("data" + aliaces[k] + "items"), 10);
                        }
                        if (!responsive[values[j]]["stagePadding"] && responsive[values[j]]["stagePadding"] !== 0 && c.attr("data" + aliaces[k] + "stage-padding")) {
                            responsive[values[j]]["stagePadding"] = k < 0 ? 0 : parseInt(c.attr("data" + aliaces[k] + "stage-padding"), 10);
                        }
                        if (!responsive[values[j]]["margin"] && responsive[values[j]]["margin"] !== 0 && c.attr("data" + aliaces[k] + "margin")) {
                            responsive[values[j]]["margin"] = k < 0 ? 30 : parseInt(c.attr("data" + aliaces[k] + "margin"), 10);
                        }
                    }
                }

                // Enable custom pagination
                if (c.attr('data-dots-custom')) {
                    c.on("initialized.owl.carousel", function(event) {
                        var carousel = $(event.currentTarget),
                            customPag = $(carousel.attr("data-dots-custom")),
                            active = 0;

                        if (carousel.attr('data-active')) {
                            active = parseInt(carousel.attr('data-active'), 10);
                        }

                        carousel.trigger('to.owl.carousel', [active, 300, true]);
                        customPag.find("[data-owl-item='" + active + "']").addClass("active");

                        customPag.find("[data-owl-item]").on('click', function(e) {
                            e.preventDefault();
                            carousel.trigger('to.owl.carousel', [parseInt(this.getAttribute("data-owl-item"), 10), 300, true]);
                        });

                        carousel.on("translate.owl.carousel", function(event) {
                            customPag.find(".active").removeClass("active");
                            customPag.find("[data-owl-item='" + event.item.index + "']").addClass("active")
                        });
                    });
                }

                // Create custom Numbering
                if (typeof(c.attr("data-numbering")) !== 'undefined') {
                    var numberingObject = $(c.attr("data-numbering"));

                    c.on('initialized.owl.carousel changed.owl.carousel', function(numberingObject) {
                        return function(e) {
                            if (!e.namespace) return;
                            if (isNoviBuilder ? false : c.attr("data-loop") !== "false") {
                                var tempFix = (e.item.index + 1) - (e.relatedTarget.clones().length / 2);
                                if (tempFix > 0) {
                                    numberingObject.find('.numbering-current').text(tempFix > e.item.count ? tempFix % e.item.count : tempFix);
                                } else {
                                    numberingObject.find('.numbering-current').text(e.item.index + 1);
                                }
                            } else {
                                numberingObject.find('.numbering-current').text(e.item.index + 1);
                            }

                            numberingObject.find('.numbering-count').text(e.item.count);
                        };
                    }(numberingObject));
                }

                c.owlCarousel({
                    autoplay: isNoviBuilder ? false : c.attr("data-autoplay") === "true",
                    loop: isNoviBuilder ? false : c.attr("data-loop") !== "false",
                    items: 1,
                    merge: true,
                    center: c.attr("data-center") === "true",
                    dotsContainer: c.attr("data-pagination-class") || false,
                    navContainer: c.attr("data-navigation-class") || false,
                    mouseDrag: isNoviBuilder ? false : c.attr("data-mouse-drag") !== "false",
                    nav: c.attr("data-nav") === "true",
                    dots: c.attr("data-dots") === "true",
                    dotsEach: c.attr("data-dots-each") ? parseInt(c.attr("data-dots-each"), 10) : false,
                    animateIn: c.attr('data-animation-in') ? c.attr('data-animation-in') : false,
                    animateOut: c.attr('data-animation-out') ? c.attr('data-animation-out') : false,
                    responsive: responsive,
                    smartSpeed: c.attr('data-smart-speed') ? c.attr('data-smart-speed') : 250,
                    navText: function() {
                        try {
                            return JSON.parse(c.attr("data-nav-text"));
                        } catch (e) {
                            return [];
                        }
                    }(),
                    navClass: function() {
                        try {
                            return JSON.parse(c.attr("data-nav-class"));
                        } catch (e) {
                            return ['owl-prev', 'owl-next'];
                        }
                    }()
                });
            }

            if (owl.length) {
                for (var i = 0; i < owl.length; i++) {
                    var c = $(owl[i]);
                    owl[i].owl = c;

                    initOwlCarousel(c);
                }
            }

            if (slick.length) {
                for (var i = 0; i < slick.length; i++) {
                    var $slickItem = $(slick[i]);

                    $slickItem.slick({
                            slidesToScroll: parseInt($slickItem.attr('data-slide-to-scroll'), 10) || 1,
                            asNavFor: $slickItem.attr('data-for') || false,
                            dots: $slickItem.attr("data-dots") === "true",
                            infinite: isNoviBuilder ? false : $slickItem.attr("data-loop") === "true",
                            focusOnSelect: true,
                            arrows: $slickItem.attr("data-arrows") === "true",
                            swipe: $slickItem.attr("data-swipe") === "true",
                            autoplay: $slickItem.attr("data-autoplay") === "true",
                            centerMode: $slickItem.attr("data-center-mode") === "true",
                            fade: $slickItem.attr("data-slide-effect") === "true",
                            centerPadding: $slickItem.attr("data-center-padding") ? $slickItem.attr("data-center-padding") : '0.50',
                            mobileFirst: true,
                            appendArrows: $slickItem.attr("data-arrows-class") || $slickItem,
                            nextArrow: $slickItem.attr('data-custom-arrows') === "true" ? '<button type="button" class="slick-next">' +
                                '  <svg width="100%" height="100%" viewbox="0 0 78 78">' +
                                '    <circle class="slick-button-line" cx="39" cy="39" r="36"></circle>' +
                                '    <circle class="slick-button-line-2" cx="39" cy="39" r="36"></circle>' +
                                '  </svg>' +
                                '</button>' : '<button type="button" class="slick-next"></button>',
                            prevArrow: $slickItem.attr('data-custom-arrows') === "true" ? '<button type="button" class="slick-prev">' +
                                '  <svg width="100%" height="100%" viewbox="0 0 78 78">' +
                                '    <circle class="slick-button-line" cx="39" cy="39" r="36"></circle>' +
                                '    <circle class="slick-button-line-2" cx="39" cy="39" r="36"></circle>' +
                                '  </svg>' +
                                '</button>' : '<button type="button" class="slick-prev"></button>',
                            responsive: [{
                                    breakpoint: 0,
                                    settings: {
                                        slidesToShow: parseInt($slickItem.attr('data-items'), 10) || 1,
                                        vertical: $slickItem.attr('data-vertical') === 'true' || false
                                    }
                                },
                                {
                                    breakpoint: 575,
                                    settings: {
                                        slidesToShow: parseInt($slickItem.attr('data-sm-items'), 10) || 1,
                                        vertical: $slickItem.attr('data-sm-vertical') === 'true' || false
                                    }
                                },
                                {
                                    breakpoint: 767,
                                    settings: {
                                        slidesToShow: parseInt($slickItem.attr('data-md-items'), 10) || 1,
                                        vertical: $slickItem.attr('data-md-vertical') === 'true' || false
                                    }
                                },
                                {
                                    breakpoint: 991,
                                    settings: {
                                        slidesToShow: parseInt($slickItem.attr('data-lg-items'), 10) || 1,
                                        vertical: $slickItem.attr('data-lg-vertical') === 'true' || false
                                    }
                                },
                                {
                                    breakpoint: 1199,
                                    settings: {
                                        slidesToShow: parseInt($slickItem.attr('data-xl-items'), 10) || 1,
                                        vertical: $slickItem.attr('data-xl-vertical') === 'true' || false
                                    }
                                }
                            ]
                        })

                        .on('afterChange', function(event, slick, currentSlide, nextSlide) {
                            var $this = $(this),
                                childCarousel = $this.attr('data-child');

                            if (childCarousel) {
                                $(childCarousel + ' .slick-slide').removeClass('slick-current');
                                $(childCarousel + ' .slick-slide').eq(currentSlide).addClass('slick-current');
                            }
                        });

                    if ($slickItem.attr('data-fraction')) {
                        (function() {
                            var fractionElement = document.querySelectorAll($slickItem.attr('data-fraction'))[0],
                                fractionCurrent = fractionElement.querySelectorAll('.slick-fraction-current')[0],
                                fractionAll = fractionElement.querySelectorAll('.slick-fraction-all')[0];

                            $slickItem.on('afterChange', function(slick) {
                                fractionCurrent.innerText = leadingZero(this.slick.currentSlide + 1);
                                fractionAll.innerText = leadingZero(this.slick.slideCount);
                            });

                            $slickItem.trigger('afterChange');
                        })();
                    }
                }
            }
        },

    };

    $(window).on('elementor/frontend/init', wp_fortuna.init);

}(jQuery, window.elementorFrontend));