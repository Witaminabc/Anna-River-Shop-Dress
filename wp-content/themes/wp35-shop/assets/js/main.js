/*!
 [be]Lazy.js - v1.8.2 - 2016.10.25
*/
(function(q,m){"function"===typeof define&&define.amd?define(m):"object"===typeof exports?module.exports=m():q.Blazy=m()})(this,function(){function q(b){var c=b._util;c.elements=E(b.options);c.count=c.elements.length;c.destroyed&&(c.destroyed=!1,b.options.container&&l(b.options.container,function(a){n(a,"scroll",c.validateT)}),n(window,"resize",c.saveViewportOffsetT),n(window,"resize",c.validateT),n(window,"scroll",c.validateT));m(b)}function m(b){for(var c=b._util,a=0;a<c.count;a++){var d=c.elements[a],e;a:{var g=d;e=b.options;var p=g.getBoundingClientRect();if(e.container&&y&&(g=g.closest(e.containerClass))){g=g.getBoundingClientRect();e=r(g,f)?r(p,{top:g.top-e.offset,right:g.right+e.offset,bottom:g.bottom+e.offset,left:g.left-e.offset}):!1;break a}e=r(p,f)}if(e||t(d,b.options.successClass))b.load(d),c.elements.splice(a,1),c.count--,a--}0===c.count&&b.destroy()}function r(b,c){return b.right>=c.left&&b.bottom>=c.top&&b.left<=c.right&&b.top<=c.bottom}function z(b,c,a){if(!t(b,a.successClass)&&(c||a.loadInvisible||0<b.offsetWidth&&0<b.offsetHeight))if(c=b.getAttribute(u)||b.getAttribute(a.src)){c=c.split(a.separator);var d=c[A&&1<c.length?1:0],e=b.getAttribute(a.srcset),g="img"===b.nodeName.toLowerCase(),p=(c=b.parentNode)&&"picture"===c.nodeName.toLowerCase();if(g||void 0===b.src){var h=new Image,w=function(){a.error&&a.error(b,"invalid");v(b,a.errorClass);k(h,"error",w);k(h,"load",f)},f=function(){g?p||B(b,d,e):b.style.backgroundImage='url("'+d+'")';x(b,a);k(h,"load",f);k(h,"error",w)};p&&(h=b,l(c.getElementsByTagName("source"),function(b){var c=a.srcset,e=b.getAttribute(c);e&&(b.setAttribute("srcset",e),b.removeAttribute(c))}));n(h,"error",w);n(h,"load",f);B(h,d,e)}else b.src=d,x(b,a)}else"video"===b.nodeName.toLowerCase()?(l(b.getElementsByTagName("source"),function(b){var c=a.src,e=b.getAttribute(c);e&&(b.setAttribute("src",e),b.removeAttribute(c))}),b.load(),x(b,a)):(a.error&&a.error(b,"missing"),v(b,a.errorClass))}function x(b,c){v(b,c.successClass);c.success&&c.success(b);b.removeAttribute(c.src);b.removeAttribute(c.srcset);l(c.breakpoints,function(a){b.removeAttribute(a.src)})}function B(b,c,a){a&&b.setAttribute("srcset",a);b.src=c}function t(b,c){return-1!==(" "+b.className+" ").indexOf(" "+c+" ")}function v(b,c){t(b,c)||(b.className+=" "+c)}function E(b){var c=[];b=b.root.querySelectorAll(b.selector);for(var a=b.length;a--;c.unshift(b[a]));return c}function C(b){f.bottom=(window.innerHeight||document.documentElement.clientHeight)+b;f.right=(window.innerWidth||document.documentElement.clientWidth)+b}function n(b,c,a){b.attachEvent?b.attachEvent&&b.attachEvent("on"+c,a):b.addEventListener(c,a,{capture:!1,passive:!0})}function k(b,c,a){b.detachEvent?b.detachEvent&&b.detachEvent("on"+c,a):b.removeEventListener(c,a,{capture:!1,passive:!0})}function l(b,c){if(b&&c)for(var a=b.length,d=0;d<a&&!1!==c(b[d],d);d++);}function D(b,c,a){var d=0;return function(){var e=+new Date;e-d<c||(d=e,b.apply(a,arguments))}}var u,f,A,y;return function(b){if(!document.querySelectorAll){var c=document.createStyleSheet();document.querySelectorAll=function(a,b,d,h,f){f=document.all;b=[];a=a.replace(/\[for\b/gi,"[htmlFor").split(",");for(d=a.length;d--;){c.addRule(a[d],"k:v");for(h=f.length;h--;)f[h].currentStyle.k&&b.push(f[h]);c.removeRule(0)}return b}}var a=this,d=a._util={};d.elements=[];d.destroyed=!0;a.options=b||{};a.options.error=a.options.error||!1;a.options.offset=a.options.offset||100;a.options.root=a.options.root||document;a.options.success=a.options.success||!1;a.options.selector=a.options.selector||".b-lazy";a.options.separator=a.options.separator||"|";a.options.containerClass=a.options.container;a.options.container=a.options.containerClass?document.querySelectorAll(a.options.containerClass):!1;a.options.errorClass=a.options.errorClass||"b-error";a.options.breakpoints=a.options.breakpoints||!1;a.options.loadInvisible=a.options.loadInvisible||!1;a.options.successClass=a.options.successClass||"b-loaded";a.options.validateDelay=a.options.validateDelay||25;a.options.saveViewportOffsetDelay=a.options.saveViewportOffsetDelay||50;a.options.srcset=a.options.srcset||"data-srcset";a.options.src=u=a.options.src||"data-src";y=Element.prototype.closest;A=1<window.devicePixelRatio;f={};f.top=0-a.options.offset;f.left=0-a.options.offset;a.revalidate=function(){q(a)};a.load=function(a,b){var c=this.options;void 0===a.length?z(a,b,c):l(a,function(a){z(a,b,c)})};a.destroy=function(){var a=this._util;this.options.container&&l(this.options.container,function(b){k(b,"scroll",a.validateT)});k(window,"scroll",a.validateT);k(window,"resize",a.validateT);k(window,"resize",a.saveViewportOffsetT);a.count=0;a.elements.length=0;a.destroyed=!0};d.validateT=D(function(){m(a)},a.options.validateDelay,a);d.saveViewportOffsetT=D(function(){C(a.options.offset)},a.options.saveViewportOffsetDelay,a);C(a.options.offset);l(a.options.breakpoints,function(a){if(a.width>=window.screen.width)return u=a.src,!1});setTimeout(function(){q(a)})}});
$(document).ready(function() {
	// Форматирование видео на странице
	if ($('#video_background').length > 0) {
		function setHeight() {
	    	videoHeight = $('#video_background').height();
	    	$('#video_background').parent().height(videoHeight);
		}
		if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
			setHeight();
		}
	    $(window).resize(setHeight);
	}

	// Проверка номера телефона по маске
	jQuery(function($){
        if($(".tel").length) { $(".tel").mask("+9 (999) 999-9999");}
    });

	$('body #pa_count').on('change', function(){
		$('body .quantity .qty').attr('value',$(this).val());
	});


    var countParamsSearch =0;
    if ($('body').is('.post-type-archive-product') || $('body').is('.tax-product_cat')) {
        countParamsSearch = $('body #accordionNo .widget_layered_nav .current-cat').length;
        var paramsPrice = parseFloat($('body .price_slider .ui-slider-range.ui-widget-header').css('width'));
        if (paramsPrice != 100) countParamsSearch += 1;
    }
	//Изменения в мобильном меню каталога
 	if ((/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) && $(window).width()<992) {
 		if ($('body').is('.post-type-archive-product') || $('body').is('.tax-product_cat')) {
	 		categoryWidget = $('#collapseCategory');
	 		$("body [id*='rs_woocommerce_product_categories']").remove();
            let sidebarPanel = $('body .sidebar-panel').detach();
            $('.breadcrumbs').append('<div class="category-switch"><i class="fa fa-lg fa-angle-right"></i></div>');
	 		$('.category-switch').attr('data-toggle', 'collapse');
	 		$('.category-switch').attr('href', '#collapseCategory');
	 		$('.category-switch').attr('aria-expanded', 'false');
	 		$('.breadcrumbs').after(categoryWidget);
	 		categoryWidget.attr('aria-expanded', 'false');
	 		categoryWidget.removeClass('in');
	 		//$('.woocommerce-products-header').hide();
            $('nav.change-view.pull-right').remove();
	 		$('body .product-filter').append('<div class="filter-show">Фильтры <span class="count">'+countParamsSearch+'</span><i class="fas fa-caret-down"></i></div>');
            $('body .product-filter').append(sidebarPanel);
	 		$('#accordionNo').hide();
	 		$('body .product-filter').on('click', function() {
				if ($('#accordionNo').css('display') === 'none') {
					$('#accordionNo').slideDown(500);
				} else {
					$('#accordionNo').slideUp(500);
				}
	 		});


            if(countParamsSearch>0){
            	$('body .filter-show').addClass('active');
			}

 		}

 	}

 	/*
 	if($('.background-responsive').length){
 		setBg();
        $(window).resize(function() {
            setBg();
        });
    }
    function setBg(){
        $('.background-responsive' ).each(function(){
            let imageUrl;
            if(screen.width<768){
                imageUrl=$(this).data('small');
            } else if(screen.width<1024){
                imageUrl=$(this).data('medium');
            } else {
                imageUrl=$(this).data('full');
            }
            $(this).css('backgroundImage', 'url(' + imageUrl + ')');
            console.log($(this),imageUrl);
        })
    }*/

    var bLazy = new Blazy({
        selector: '.b-lazy',
        breakpoints: [{
            width: 768 // max-width
            , src: 'data-small'
        }
            , {
                width: 1024 // max-width
                , src: 'data-medium'
            }]
    });

   /*==================================
     Parallax
     ====================================*/
    if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
        // Detect Mobile User // No parallax
        $('.parallaximg').addClass('ismobile');
    } else {
        // All Desktop
        $(window).bind('scroll', function (e) {
            parallaxScroll();
        });
        function parallaxScroll() {
            var scrolledY = $(window).scrollTop();
            var sc = ((scrolledY * 0.3)) + 'px';
             if ($('div').is('.rs-one-menu')) {
 				$('.parallaximg').css('marginTop', '' + ((scrolledY * 0.3)) + 'px');
 			} else {
           		$('.parallaximg').css('marginTop', '' + ((scrolledY * 0.3) - 30) + 'px');
 			}
        }
    }

	/*==================================
     Slick
     ====================================*/
if ($('.rs-slider-container').length > 0) {
	$('.rs-slider-container').slick({
		infinite: true,
		slidesToShow: 1,
		speed: 300,
		dots: true,
		autoplay: false,
		//lazyLoad: 'ondemand',
		//cssEase: 'cubic-bezier(0.845, 0.045, 0.355, 1)'
	});
}
	// Остановка видео
	$("#video-block-full .close").on("click", function() {
		$("#yt-player iframe").attr("src", $("#yt-player iframe").attr("src"));
	});

/*==================================
     OwlCarousel
     ====================================*/
if ($('.reviews-slider').length > 0) {
        $(".reviews-slider").owlCarousel({
            items: 1,
			margin: 10,
            lazyLoad: true,
            autoplay: false,
            loop: true,
            dots: false,
            nav: false,
            responsiveClass: true,
			autoHeight:true,
            responsive: {
                0: {
                    items: 1,
					lazyLoad: true,
					autoplay: true,
					loop: true,
					dots: false,
					nav: false,
					responsiveClass: true,
					autoHeight:true
                }
            }
        });
		 $("a.reviews-next").click(function () {
            $(".reviews-slider").trigger('next.owl.carousel');
        });
        $("a.reviews-prev").click(function () {
            $(".reviews-slider").trigger('prev.owl.carousel');
        });
}

	var logosSlider = $("#logos-slider");
	if(logosSlider.length > 0){
		logosSlider.owlCarousel({
			items: 6,
			nav:false,
			dots: true,
			autoplay: true,
			margin: 30,
			responsive: {
					0: {
						items: 1
					},
					480: {
						items: 2
					},
					544: {
						items: 3
					},
					768: {
						items: 4
					},
					992: {
						items: 5
					},
					1200: {
						items: 6
					}
			},
			onInitialized: function(){customPager(logosSlider)},
			onResized: function(){customPager(logosSlider)}
		});

		$("#logos-slider .owl-next").click(function () {
        logosSlider.trigger('next.owl.carousel');
		});
		$("#logos-slider .owl-prev").click(function () {
			logosSlider.trigger('prev.owl.carousel');
		});
	}

	if ($("#examples-slider").length > 0) {
		$("#examples-slider").owlCarousel({
			items: 2,
			pagination: true,
			dots: true,
			nav: true,
			margin: 30,
			navText: [
			  "<span class='example-slider-left'><i class=' fa fa-angle-left '></i></span>",
			  "<span class='example-slider-right'><i class=' fa fa-angle-right'></i></span>"
			],
			responsive: {
					0: {
						items: 1
					},
					544: {
						items: 1
					},
					768: {
						items: 1
					},
					992: {
						items: 2
					},
					1200: {
						items: 2
					}
			}
		});
	}

	var recommendSlider = $("#recommendations-slider");
	if(recommendSlider.length > 0){
		recommendSlider.owlCarousel({
			items: 5,
			nav: false,
			dots: true,
			autoplay: false,
			margin: 30,
			responsive: {
					0: {
						items: 1
					},
					480: {
						items: 1
					},
					544: {
						items: 2
					},
					768: {
						items: 3
					},
					992: {
						items: 4
					},
					1200: {
						items: 5
					}
			},
			onInitialized: function(){customPager(recommendSlider)},
			onResized: function(){customPager(recommendSlider)}
		});

		$("#recommendations-slider .owl-next").click(function () {
            recommendSlider.trigger('next.owl.carousel');
		});
		$("#recommendations-slider .owl-prev").click(function () {
			recommendSlider.trigger('prev.owl.carousel');
		});
	}

	var fotoCarouselSlider = $("#foto-carousel-slider");
	if(fotoCarouselSlider.length > 0){
		fotoCarouselSlider.owlCarousel({
			loop: true,
			mouseDrag: true,
			touchDrag: true,
			//items: 3,
			nav: false,
			dots: false,
			autoplay: false,
			margin: 0,
			center: false,
			navContainer: '#foto-carousel-nav',
			navText: [
			  '<i class="fa fa-angle-left"></i>',
			  '<i class="fa fa-angle-right"></i>'
			],
			responsive: {
					0: {
						items: 1
					},
					480: {
						items: 1
					},
					544: {
						items: 1
					},
					768: {
						items: 2
					},
					992: {
						items: 2
					},
					1200: {
						items: 3
					}
			},
			onInitialized: function(){customPager(fotoCarouselSlider)},
			onResized: function(){customPager(fotoCarouselSlider)}
		});

		$("#foto-carousel-slider .owl-next").click(function () {
            fotoCarouselSlider.trigger('next.owl.carousel');
		});
		$("#foto-carousel-slider .owl-prev").click(function () {
			fotoCarouselSlider.trigger('prev.owl.carousel');
		});
	}

function customPager(obj) {
	var pagination = obj.find('.owl-dots');
	obj.find('.owl-next').remove();
	obj.find('.owl-prev').remove();
	if(pagination.hasClass('disabled')){
		return;
	}
	pagination.after("<div class='owl-next'><i class='fa fa-angle-right'></i>  </div>");
    pagination.before("<div class='owl-prev'><i class='fa fa-angle-left'></i> </div>");
}

// Сообщение о добавлении товара через ajax
	$('body ').on('click','.btn.addBascetAjax a', function() {
		addBtnCaption = $(this).text();
		if (addBtnCaption === 'В корзину') {
			successMsgEl = $(this).parents('.action-control').siblings('.success.text-center');
			successMsgEl.text('Товар успешно добавлен в корзину');
			successMsgEl.addClass('bg-success');
		}
	});

 	//count
	if($('.rs-count').length){
		$('.rs-count').counterUp({
	                delay: 10,
	                time: 1000
	    });
	}
	var latestProductSlider = $("#product-slider");
	if(latestProductSlider.length > 0) {
		latestProductSlider.owlCarousel({
			items: 4,
			dots: true,
			nav: false,
			lazyLoad: true,
			responsiveClass:true,
			responsive: {
					0: {
						items: 1
					},
					544: {
						items: 2
					},
					992: {
						items: 3
					},
					1200: {
						items: 4
					}
			},
			onInitialized: function(){customPager(latestProductSlider)},
			onResized: function(){customPager(latestProductSlider)}
		});
		$("#product-slider .owl-next").click(function () {
        latestProductSlider.trigger('next.owl.carousel');
		});
		$("#product-slider .owl-prev").click(function () {
			latestProductSlider.trigger('prev.owl.carousel');
		});
	}

	// модальное окно быстрый просмотр товара
    $('body').on('click', '.btn-quickview', function () {
    	var themPath = $(this).attr('data-path');
        var id = $(this).attr('data-id');
        var target = $(this).attr('data-target');
        $(target+" .modal-content").empty().load(themPath +"/woocommerce/ajax_archives.php?id=" + id);

    });

	// модальное окно галерея
	$(".modal-product-thumb a").click(function () {
		var largeImage = $(this).find("img").attr('data-large');
		$(".product-largeimg").attr('src', largeImage);
		$(".zoomImg").attr('src', largeImage);
	});

	// слайдер для блока Самые продаваемые
	var productSliderBs = $("#product-slider-bs");
	if(productSliderBs.length > 0) {
		productSliderBs.owlCarousel({
			items: 4,
			dots: true,
			nav: false,
			lazyLoad: true,
			responsiveClass:true,
			responsive: {
					0: {
						items: 1
					},
					544: {
						items: 2
					},
					992: {
						items: 3
					},
					1200: {
						items: 4
					}
			},
			onInitialized: function(){customPager(productSliderBs)},
			onResized: function(){customPager(productSliderBs)}
		});
		$("#product-slider-bs .owl-next").click(function () {
        	productSliderBs.trigger('next.owl.carousel');
		});
		$("#product-slider-bs .owl-prev").click(function () {
			productSliderBs.trigger('prev.owl.carousel');
		});
	}

	// слайдер для блока Популярные
	var productSliderPopular = $("#product-slider-popular");
	if(productSliderPopular.length > 0) {
		productSliderPopular.owlCarousel({
			items: 4,
			dots: true,
			nav: false,
			lazyLoad: true,
			responsiveClass:true,
			responsive: {
					0: {
						items: 1
					},
					544: {
						items: 2
					},
					992: {
						items: 3
					},
					1200: {
						items: 4
					}
			},
			onInitialized: function(){customPager(productSliderPopular)},
			onResized: function(){customPager(productSliderPopular)}
		});
		$("#product-slider-popular .owl-next").click(function () {
        	productSliderPopular.trigger('next.owl.carousel');
		});
		$("#product-slider-popular .owl-prev").click(function () {
			productSliderPopular.trigger('prev.owl.carousel');
		});
	}

	// слайдер для блока Распродажа
	var productSliderOnsale = $("#product-slider-onsale");
	if(productSliderOnsale.length > 0) {
		productSliderOnsale.owlCarousel({
			items: 4,
			dots: true,
			nav: false,
			lazyLoad: true,
			responsiveClass:true,
			responsive: {
					0: {
						items: 1
					},
					544: {
						items: 2
					},
					992: {
						items: 3
					},
					1200: {
						items: 4
					}
			},
			onInitialized: function(){customPager(productSliderOnsale)},
			onResized: function(){customPager(productSliderOnsale)}
		});
		$("#product-slider-onsale .owl-next").click(function () {
        	productSliderOnsale.trigger('next.owl.carousel');
		});
		$("#product-slider-onsale .owl-prev").click(function () {
			productSliderOnsale.trigger('prev.owl.carousel');
		});
	}

	var similarProductSlider = $("#similar-product-slider");
	if(similarProductSlider.length > 0){
		similarProductSlider.owlCarousel({
			items: 5,
			dots: true,
			nav: false,
			lazyLoad: true,
			responsiveClass:true,
			responsive: {
					0: {
						items: 1
					},
					480: {
						items: 2
					},
					768: {
						items: 3
					},
					992: {
						items: 4
					},
					1200: {
						items: 5
					}
			},
			onInitialized: function(){customPager(similarProductSlider)},
			onResized: function(){customPager(similarProductSlider)}
		});
		$("#similar-product-slider .owl-next").click(function () {
        similarProductSlider.trigger('next.owl.carousel');
		});
		$("#similar-product-slider .owl-prev").click(function () {
			similarProductSlider.trigger('prev.owl.carousel');
		});
	}

    // слайдер для блока Похожие
    var productSliderRelated = $("#product-related");
    if(productSliderRelated.length > 0) {
        productSliderRelated.owlCarousel({
            items: 4,
            dots: true,
            nav: false,
            lazyLoad: true,
            responsiveClass:true,
            responsive: {
                0: {
                    items: 1
                },
                992: {
                    items: 2
                },
                1024: {
                    items: 3
                },
                1200: {
                    items: 4
                }
            },
            onInitialized: function(){customPager(productSliderRelated)},
            onResized: function(){customPager(productSliderRelated)}
        });
        $("#product-related .owl-next").click(function () {
            productSliderBs.trigger('next.owl.carousel');
        });
        $("#product-related .owl-prev").click(function () {
            productSliderBs.trigger('prev.owl.carousel');
        });
    }

	// слайдер для блока Наша команда
	if($("#team-slider").length > 0){
		console.log('1');
			$("#team-slider").owlCarousel({
				items: 5,
				pagination	: false,
				nav:true,
				margin: 30,
				navText: [
				  "<span class='team-slider-left'><i class=' fas fa-angle-left '></i></span>",
				  "<span class='team-slider-right'><i class=' fas fa-angle-right'></i></span>"
				],
				responsive: {
						0: {
							items: 1
						},
						544: {
							items: 2
						},
						768: {
							items: 3
						},
						992: {
							items: 4
						},
						1200: {
							items: 5
						}
				}
			});
		}

    // search-btn, search-close
    $(".search-btn").on('click', function (e) {
        console.log('search-btn');
        $('.search-full').toggleClass("active"); //you can list several class names
        e.preventDefault();
    });
    $('.search-btn-inner').on('click', function (e) {
        console.log(1,$(this).parents('.search-form').find('.search-input-box input').val());
        if($(this).parents('.search-form').find('.search-input-box input').val()==''){
            $('.search-full').removeClass("active"); //you can list several class names
            e.preventDefault();
        }

    });

	// Product Details Modal Change large image when click thumb image
    $(".modal-product-thumb a").click(function () {
        var largeImage = $(this).find("img").attr('data-large');
        $(".product-largeimg").attr('src', largeImage);
        $(".zoomImg").attr('src', largeImage);
    });

	// product details color switch
    $(".swatches li").click(function () {
        $(".swatches li.selected").removeClass("selected");
        $(this).addClass('selected');
    });

    $(".product-color a").click(function () {
        $(".product-color a").removeClass("active");
        $(this).addClass('active');
    });

    // Modal thumb link selected
    $(".modal-product-thumb a").click(function () {
        $(".modal-product-thumb a.selected").removeClass("selected");
        $(this).addClass('selected');
    });

	// customs select by select2
    // $("select").minimalect(); // REMOVED with  selct2.min.js
	/*$(function(){
		if($('select.form-control').length > 0){
			$('select.form-control').select2();
		}
	});*/

	//NekoAnim
	$(function(){
		if($('.activateAppearAnimation').length > 0){
			nekoAnimAppear();
			$('.reloadAnim').click(function (e) {
				$(this).parent().parent().find('img[data-nekoanim]').attr('class', '').addClass('img-responsive');
				nekoAnimAppear();
				e.preventDefault();
			});
		}
	});

	//checkbox modal
	/*$(function(){
		$('input[type="checkbox"].agreement-check').prop('checked',false);
		$('button.modal-btn').prop('disabled',true);
		$('input[type="checkbox"].agreement-check').on('change',function(){
			if(this.checked){
				$('button.modal-btn').attr('disabled',false);
			}else{
				$('button.modal-btn').prop('disabled',true);
			}
		});
	});*/

	//scroll up
	$(function(){
		$(window).scroll(function(){
			if($(this).scrollTop()>200){
				$("#button-up").fadeIn();
			}else{
				$("#button-up").fadeOut();
			}
		});
		$("#button-up").click(function() {
		$("body,html").animate({scrollTop:0},800);
		});
	});


var subscribeForm = $('#subscribeForm');
	if(subscribeForm.length > 0){
		subscribeForm.validate({
			rules: {
				email_subscribe_author: {
						required: true,
						email: true
					   }
				},
				messages: {
						email_subscribe_author: {
							required: "Введите свой email",
							email: "Введите корректный email"
						}

				}

		});
	}

	$('#subscribeFormBtn').on('gvalidate', function (event) {
		if(subscribeForm.valid() == true){
			event.preventDefault();

			$('#loader_img').show();
			var phone = $('#subscribeForm input[name=phone]').val();
			var email_subscribe_author = $('#subscribeForm input[name=email_subscribe_author]').val();
			var token = $('#subscribeForm').find(".g-recaptcha-response").val();

			$.ajax({
				type: 'POST',
				data: {
					phone: phone,
					email_subscribe_author: email_subscribe_author,
					token: token,
					modeJs: 'subscribeForm'
				},
				dataType: 'json',
				success: function (result) {
					$('#subscribeForm').empty();
					$('#block-subscribe .success').addClass('bg-success').append(result.message);
					$('#loader_img').hide();
				}
			});
			return false;
		} else return false;
    });

	var FormMainBanner3 = $('#FormMainBanner3');
	if(FormMainBanner3.length > 0){
		FormMainBanner3.validate({
			rules: {
				name_author3: {
						required: true,
						minlength: {
							depends: function(element) {
							return $('#FormMainBanner3 .input_spec input[name=valueJs]').val('dfsd3f');
						}
						},

					   },

				phone_author3: {
						required: true,
						minlength: 6,
						digits: true
					   }
				},
				messages: {
						name_author3: {
							required: "Введите свое имя",
							minlength: "Длина должна быть больше 2-х символов"
						},
						phone_author3: {
							required: "Введите свой телефон",
							minlength: "Введите корректный телефон",
							digits: "Вводите только цифры"
						},

				}
		});
	}

	$('#contactFormMainBanner3').on('gvalidate', function (e) {
		if(FormMainBanner3.valid() == true){
			e.preventDefault();

			$('#loader_img').show();

			var phone = $('#FormMainBanner3 input[name=phone]').val();

			var name_author3 = $('#FormMainBanner3 input[name=name_author3]').val();

			var phone_author3 = $('#FormMainBanner3 input[name=phone_author3]').val();

			var message_author3 = $('#FormMainBanner3 textarea[name=message_author3]').val();

			var valueF = $('#FormMainBanner3 .input_spec input[name=valueJs]').val();

			var token = $('#FormMainBanner3').find(".g-recaptcha-response").val();

			$.ajax({
				type: 'POST',
				data: {
					phone : phone,
					phone_author3: phone_author3,
					name_author3: name_author3,
					message_author3: message_author3,
					valueF: valueF,
					token: token,
					modeJs: 'contactFormMainBanner3'
				},
				dataType: 'json',
				success: function (result) {
					$('#FormMainBanner3').empty().append('<p class="success bg-success text-center">');
					$('#FormMainBanner3 .success').empty().append(result.message);
					$('#loader_img').hide();
				}
			});
			return false;
		}else return false;
    });


	//Validate
	var contactForm = $('#contact-form');
	if($('#contact-form').length > 0) {
		$('#contact-form').validate({
			submitHandler: function (form){
				form.submit();
			},
			rules: {
				contact_name_author: {
						required: true,
						minlength: 2
					   },

				contact_email_author: {
						required: true,
						email: true
					   },

				contact_phone_author: {
						required: true,
						minlength: 10
					   }
				},
				messages: {
						contact_name_author: {
							required: "Введите свое имя",
							minlength: "Длина должна быть больше 2-х символов"
						},
						 contact_email_author: {
							required: "Введите email",
							email: "Введите корректный email"
						},
						 contact_phone_author: {
							required: "Введите телефон",
							minlength: "Введите корректный телефон"
						}
				}
		});
	}

	var reCaptchaCounter = 1;
	$(function(){
		$(
			'#contactsFormBtn,'+
			'#footerContactsBtn,'+
			'#formMainBtn,'+
			'#subscribeFormBtn,'+
			'#contactFormMainBanner,'+
			'#contactFormMainBanner2,'+
			'#contactFormMainBanner3,'+
			'#contactFormMainBanner4,'+
			'#contactFormBtn,'+
			'#formTopBlockBtn,'+
			'#fastOrdeer button[type="submit"],'+
			'#orderFormBtn'+
			''
			).each(function(){
			//$(this).addClass('g-recaptcha')
			//if(!$(this).attr('id')) $(this).attr('id','captcha'+reCaptchaCounter)
			//reCaptchaCounter++
			$(this).on('click', function(){$(this).trigger('gvalidate'); return false;})
		})
	})

	function onloadCallback(){
		console.log('onloadCallback')
		$(".g-recaptcha").each(function() {
			var object = $(this);
			grecaptcha.render(object.attr("id"), {
				"sitekey" : "6LdZP1oUAAAAAFLC-DJ75oaHVKnMNPeKFYrFjWZt",
				"callback" : function(token) {
					console.log('callback')
					object.parents('form').find(".g-recaptcha-response").val(token);
					object.trigger('gvalidate')
					object.on('click', function(){$(this).trigger('gvalidate')})
				}
			});
		});

		$('.search-form .g-recaptcha').each(function(){
		var e = $(this)
		e.prev().insertAfter(e)
		})
		$('.agreement-check').change()
	}

	$('#contactFormBtn').on('gvalidate', function (e) {
		if(contactForm.valid() == true){
			e.preventDefault();
			$('#loader_img').show();
			var phone = $('#contact-form input[name=phone]').val();
			var contact_phone_author = $('#contact-form input[name=contact_phone_author]').val();
			var contact_name_author = $('#contact-form input[name=contact_name_author]').val();
			var contact_email_author = $('#contact-form input[name=contact_email_author]').val();
			var token = $('#contact-form').find(".g-recaptcha-response").val();
			$.ajax({
				type: 'POST',
				data: {
					phone: phone,
					contact_phone_author: contact_phone_author,
					contact_name_author: contact_name_author,
					contact_email_author: contact_email_author,
					token: token,
					modeJs: 'contactForm'
				},
				dataType: 'json',
				success: function (result) {
					$('#contact-form .success').empty().addClass('bg-success').append(result.message);
					$('#loader_img').hide();
					contactForm.trigger('reset');
				}
			});
			return false;
		}
    });

	var contactsForm = $('#contactsForm');
	if(contactsForm.length > 0){
		contactsForm.validate({
			rules: {
                contacts_name: {
						required: true,
						minlength: 2
					   },

                contacts_email: {
						required: true,
						email: true
					   },

                contacts_phone: {
						required: true,
						minlength: 6,
						digits: true
					   }
				},
				messages: {
                    contacts_name: {
							required: "Введите свое имя",
							minlength: "Длина должна быть больше 2-х символов"
						},
                    contacts_email: {
							required: "Введите email",
							email: "Введите корректный email"
						},
                    contacts_phone: {
							required: "Введите телефон",
							minlength: "Введите корректный телефон",
							digits: "Вводите только цифры"
						}
				}
		});
	}

   $('#contactsFormBtn').on('gvalidate', function (event) {
		if(contactsForm.valid() == true){
        event.preventDefault();

			$('#loader_img').show();
			var phone = $('#contactsForm input[name=phone]').val();
			var contacts_name = $('#contactsForm input[name=contacts_name]').val();
			var contacts_email = $('#contactsForm input[name=contacts_email]').val();
			var contacts_phone = $('#contactsForm input[name=contacts_phone]').val();
			var contacts_message = $('#contactsForm textarea[name=contacts_message]').val();
			var token = $('#contactsForm').find(".g-recaptcha-response").val();
			$.ajax({
				type: 'POST',
				data: {
					phone: phone,
					contacts_email: contacts_email,
					contacts_name: contacts_name,
					contacts_phone: contacts_phone,
					contacts_message : contacts_message,
					token : token,
					modeJs: 'contactFormMain'
				},
				dataType: 'json',
				success: function (result) {
					$('#contactsForm .success').addClass('bg-success').append(result.message);
					$('#loader_img').hide();
					contactsForm.trigger('reset');
				}
			});
			return false;
		} else return false;
    });

	var formMain = $('#formMain');
	if(formMain.length > 0){
		formMain.validate({
			rules: {
				form_name: {
						required: true,
						minlength: 2
					   },

				form_email: {
						required: true,
						email: true
					   },

				form_phone: {
						required: true,
						minlength: 6,
						digits: true
					   }
				},
				messages: {
						form_name: {
							required: "Введите свое имя",
							minlength: "Длина должна быть больше 2-х символов"
						},
						 form_email: {
							required: "Введите email",
							email: "Введите корректный email"
						},
						form_phone: {
							required: "Введите телефон",
							minlength: "Введите корректный телефон",
							digits: "Вводите только цифры"
						}
				}
		});
	}

	$('#formMainBtn').on('gvalidate', function (event) {
		console.log('click', this)
		if(formMain.valid() == true){
        event.preventDefault();

			$('#loader_img').show();
			var phone = $('#formMainBtn input[name=phone]').val();
			var form_name = $('#formMain input[name=form_name]').val();
			var form_email = $('#formMain input[name=form_email]').val();
			var form_phone = $('#formMain input[name=form_phone]').val();
			var form_message = $('#formMain textarea[name=form_message]').val();
			var token = $('#formMain').find(".g-recaptcha-response").val();
			$.ajax({
				type: 'POST',
				data: {
					phone: phone,
					form_email: form_email,
					form_name: form_name,
					form_phone: form_phone,
					form_message : form_message,
					token : token,
					modeJs: 'formMain'
				},
				dataType: 'json',
				success: function (result) {
					$('#formMain .success').addClass('bg-success').append(result.message);
					$('#loader_img').hide();
					formMain.trigger('reset');
				}
			});
			return false;
		} else return false;
    });

	if($('#order-call .form-order').length > 0){
		$('#order-call .form-order').validate({
			submitHandler: function (form){
				form.submit();
			},
			rules: {
				name: {
						required: true,
						minlength: 2
					   },

				email: {
						required: true,
						email: true
					   },

				phone: {
						required: true,
						minlength: 10
					   }
				},
				messages: {
						name: {
							required: "Введите свое имя",
							minlength: "Длина должна быть больше 2-х символов"
						},
						 email: {
							required: "Введите свой email",
							email: "Введите корректный email"
						},
						 phone: {
							required: "Введите свой телефон",
							minlength: "Введите корректный телефон"

						}
				}
		});
	}

	if($('#order-call2 .form-order').length > 0){
		$('#order-call2 .form-order').validate({
			submitHandler: function (form){
				form.submit();
			},
			rules: {
				name: {
						required: true,
						minlength: 2
					   },

				email: {
						required: true,
						email: true
					   }
				},
				messages: {
						name: {
							required: "Введите свое имя",
							minlength: "Длина должна быть больше 2-х символов"
						},
						email: {
							required: "Введите свой email",
							email: "Введите корректный email"
						}

				}
		});
	}

	if($('#order-call3 .form-order').length > 0){
		$('#order-call3 .form-order').validate({
			submitHandler: function (form){
				form.submit();
			},
			rules: {
				name: {
						required: true,
						minlength: 2
					   },


				phone: {
						required: true,
						minlength: 10
					   }
				},
				messages: {
						name: {
							required: "Введите свое имя",
							minlength: "Длина должна быть больше 2-х символов"
						},
						phone: {
							required: "Введите свой телефон",
							minlength: "Введите корректный телефон"
						},

				}
		});
	}

	if($('.contacts-form').length > 0 && !$('.contacts-form').parent('.wpcf7-form')){
		$('.contacts-form').validate({
			submitHandler: function (form){
				form.submit();
			},
			rules: {
				contacts_name: {
						required: true,
						minlength: 2
					   },

				contacts_email: {
						required: true,
						email: true
					   },

				contacts_phone: {
						required: true,
						minlength: 10
					   }
				},
				messages: {
						contacts_name: {
							required: "Введите свое имя",
							minlength: "Длина должна быть больше 2-х символов"
						},
						contacts_email: {
							required: "Введите свой email",
							email: "Введите корректный email"
						},
						contacts_phone: {
							required: "Введите свой телефон",
							minlength: "Введите корректный телефон"

						}
				}
		});
	}

    $('.has-spinner').click(function () {
        var btn = $(this);
        $(btn).buttonLoader('start');
        var wpcf7Id=$(this).parents('.wpcf7').attr('id');
        var wpcf7Elm = document.querySelector( '#'+wpcf7Id )
        wpcf7Elm.addEventListener( 'wpcf7submit', function( event ) {
            $(btn).buttonLoader('stop');
        }, false );
         wpcf7Elm.addEventListener( 'wpcf7invalid', function( event ) {
             $(btn).buttonLoader('stop');
            $('#'+wpcf7Id).find('.wpcf7-validation-errors').remove();
        }, false );

    });

	$(function(){
		if($('body .smoothscroll').length){
			$("body .smoothscroll").mCustomScrollbar({
				advanced: {
					updateOnContentResize: true,
					updateOnBrowserResize: true
				},
				scrollButtons: {
					enable: false
				},
				mouseWheelPixels: "100",
				theme: "dark-2",
				//autoDraggerLength: true
			});
		}
    });
	$(function(){
			$(".navbar-collapse .link-btn").click(function () { //use a class, since your ID gets mangled
				$(this).children('.fa').toggleClass('fa-rotate-180 fa-rotate-0');
				$(this).parent('.dropdown').toggleClass("open");
			});
		});

	/*$(function(){
			$(".navbar-collapse .dropdown a").click(function (event) { //use a class, since your ID gets mangled
				//$(this).children('.fa').toggleClass('fa-rotate-180 fa-rotate-0');
				event.preventDefault();
				$(this).parent('.dropdown').toggleClass("open");
			});
		});	*/

	//fancybox
	$(function(){
		if($('[data-fancybox]').length > 0){
		$('[data-fancybox]').fancybox({
					loop : true,
					infobar : false,
					toolbar  : true,

					buttons : [
					    'zoom',
					    'slideShow',
					    'thumbs',
					    'close'
					],
					thumbs : {
						autoStart : true
					}
					});
		}
	});

	// cart quantity changer sniper
	$(function(){
		if($("input[name='quanitySniper']").length > 0){
			$("input[name='quanitySniper']").TouchSpin({
				buttondown_class: "btn btn-link",
				buttonup_class: "btn btn-link"
			});
		}
	});

	if($('.rs-product-view')){
		$('body').on('click','.thumbLink',function(){
            $('body .thumbLink').removeClass('selected');
            $(this).addClass('selected');
            console.log($(this).find('img').data('large'));
            $('body .product-largeimg-link').find('img').attr('src',$(this).find('img').data('large'));
		})
	}
	// product-carousel
	$(function(){
		if($('#product-carousel').length > 0){
			$('#product-carousel').carousel({
				interval: false,
				wrap: false,
				keyboard: false,
				pause: 'null'
			});
			$('#product-carousel').carousel('pause');

			// zoom product
			var productHeight = $('#product-carousel .product-carousel-item').height();
			var productWidth = $('#product-carousel .product-carousel-item').width();

			$('#product-carousel .product-carousel-item a').each(function(){
				var productWidthImg = $(this).find('img').naturalWidth();
				var productHeightImg = $(this).find('img').naturalHeight();
				if((productWidthImg > productWidth)&&(productHeightImg > productHeight)){
					$(this).zoom();
				}
			})
		}
	});

	//change-view
	$(function(){
		$('.change-view .grid-view').click(function(){
			if($(this).hasClass('active')) {
				$(this).siblings().removeClass('active');
				$('.categoryProduct').addClass('grid-view');
			}
			else {
				$(this).addClass('active');
				$(this).siblings().removeClass('active');
				$('.categoryProduct').addClass('grid-view');
				}
			$('.categoryProduct').removeClass('list-view');

			return false;
			});


		$('.change-view .list-view').click(function(){
			if($(this).hasClass('active')) {
				$(this).siblings().removeClass('active');
				$('.categoryProduct').addClass('list-view');
			}
			else {
				$(this).siblings().removeClass('active');
				$(this).addClass('active');
				$('.categoryProduct').addClass('list-view');
			}
			$('.category').removeClass('grid-view');

			return false;
			});
	});

	// Customs tree menu script
	$(function(){
		$(".dropdown-tree-a").click(function () { //use a class, since your ID gets mangled
			$(this).parent('.dropdown').toggleClass("open"); //add the class to the clicked element
		});
	});

    var showAccordion=false;
    if($(window).width() > 991 ) showAccordion=true;

	panelClose();
	$(window).resize(function(){
		panelClose();
	});
    function panelClose(){
        if($(window).width() <= 991) {
            if(showAccordion){
                $('#accordionNo .panel-collapse').collapse('hide');
                showAccordion=false;
            }
            $('#accordionNo .panel-collapse').each(function(){
                if($(this).hasClass('in') && !showAccordion) {
                    $(this).collapse('show');
                } else {
                    $(this).collapse('hide');
                }
            });
        } else{
            $('#accordionNo .panel-collapse').collapse('show');
            showAccordion=true;
        }
    }

});

function nekoAnimAppear(){
	$("[data-nekoanim]").each(function() {
		var $this = $(this);
        var offset = $this.offset();

		if($(window).width() > 767 && offset.top>100) {
            $this.addClass("nekoAnim-invisible");
			$this.appear(function() {

				var delay = ($this.data("nekodelay") ? $this.data("nekodelay") : 1);
				if(delay > 1) $this.css("animation-delay", delay + "ms");

				$this.addClass("nekoAnim-animated");
				$this.addClass('nekoAnim-'+$this.data("nekoanim"));

				setTimeout(function() {
					$this.addClass("nekoAnim-visible");
				}, delay);

			}, {accX: 0, accY: -150});

		} else {
			$this.animate({ opacity: 1 }, 300, 'easeInOutQuad',function() { });
		}
	});
}

(function($){
  var
  props = ['Width', 'Height'],
  prop;

  while (prop = props.pop()) {
  (function (natural, prop) {
	$.fn[natural] = (natural in new Image()) ? 
	function () {
	return this[0][natural];
	} : 
	function () {
	var 
	node = this[0],
	img,
	value;

	if (node.tagName.toLowerCase() === 'img') {
	  img = new Image();
	  img.src = node.src,
	  value = img[prop];
	}
	return value;
	};
  }('natural' + prop, prop.toLowerCase()));
  }
}(jQuery));

(function ($) {
    $.fn.buttonLoader = function (action) {
        var self = $(this);
        if (action == 'start') {
            if ($(self).attr("disabled") == "disabled") {
                e.preventDefault();
            }
           // $('.has-spinner').attr("disabled", "disabled");
            $(self).attr('data-btn-text', $(self).text());
            $(self).html('<span class="spinner"><i class="fa fa-spinner fa-spin"></i></span>Отправляю…');
            $(self).addClass('active');
        }
        if (action == 'stop') {
            $(self).html($(self).attr('data-btn-text'));
            $(self).removeClass('active');
            $('.has-spinner').removeAttr("disabled");
        }
    }
})

// Параллакс в яболчных мобилках
var userAgent = window.navigator.userAgent;
const uA = navigator.userAgent;
const vendor = navigator.vendor;
if ((/Safari/i.test(uA) && /Apple Computer/.test(vendor) && !/Mobi|Android/i.test(uA)) || ((userAgent.match(/iPad/i) || userAgent.match(/iPhone/i)) && /Apple Computer/.test(vendor))) {
if(window.outerWidth < 768) {
jQuery(window).scroll(function(){
  var fromtop = jQuery(window).scrollTop();
  jQuery('.rs-features-photo').css({"background-position-y": fromtop+"px"});
  jQuery('.rs-features-photo').css({"background-size": "auto"});
  jQuery('.rs-parallax').css({"background-position-y": fromtop+"px"});
  jQuery('.rs-parallax').css({"background-size": "auto"});
 });
}
}

(jQuery);