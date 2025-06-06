(function() {
	jQuery(document).ready(function($) {
		// initial resize of [cusrev_reviews_grid] and Trust Badges
		crResizeAllGridItems();
		crResizeTrustBadges();
		//enable attachment of images to comments
		jQuery("form#commentform").attr( "enctype", "multipart/form-data" ).attr( "encoding", "multipart/form-data" );
		//prevent review submission if captcha is not solved
		jQuery("#commentform").on( "submit", function(event) {
			if( cr_ajax_object.ivole_recaptcha === '1' ) {
				var recaptcha = jQuery("#g-recaptcha-response").val();
				if (recaptcha === "") {
					event.preventDefault();
					alert("Please confirm that you are not a robot");
				}
			}
		} );
		//show lightbox when click on images attached to reviews
		jQuery("ol.commentlist").on("click", ".cr-comment-a", function(t) {
			if(cr_ajax_object.disable_lightbox === '0') {
				//only if lightbox is not disabled in settings of the plugin
				t.preventDefault();
				const oo = jQuery(".pswp");
				if ( 0 < oo.length ) {
					const o = oo[0];
					var pics = jQuery(this).parent().parent().find(".cr-comment-a img");
					var this_pic = jQuery(this).find("img");
					var inx = 0;
					if (pics.length > 0 && this_pic.length > 0) {
						var a = [];
						for (i = 0; i < pics.length; i++) {
							a.push({
								src: pics[i].src,
								w: pics[i].naturalWidth,
								h: pics[i].naturalHeight,
								title: pics[i].alt
							});
							if (this_pic[0].src == pics[i].src) {
								inx = i;
							}
						}
						var r = {
							index: inx
						};
						new PhotoSwipe(o, PhotoSwipeUI_Default, a, r).init();
					}
				}
			}
		});
		// play a video when a user clicks on it in the reviews grid
		jQuery(".cr-reviews-grid").on("click", ".image-row-vid, .cr-comment-videoicon", function(t) {
			if( ! jQuery(this).closest(".image-row").hasClass( "cr-vid-playing" ) ) {
				jQuery(this).closest(".image-row").addClass( "cr-vid-playing" );
				jQuery(this).closest(".image-row").find(".image-row-vid").prop( "controls", true );
				jQuery(this).closest(".image-row").find(".image-row-vid").get(0).play();
			} else {
				jQuery(this).closest(".image-row").find(".image-row-vid").get(0).pause();
				jQuery(this).closest(".image-row").find(".image-row-vid").prop( "controls", false );
				jQuery(this).closest(".image-row").removeClass( "cr-vid-playing" );
			}
			return false;
		} );
		// play a video when a user clicks on it in the media pop-up window
		jQuery(".cr-ajax-reviews-cus-images-modal").on("click", ".cr-ajax-reviews-video, .cr-ajax-reviews-video .cr-comment-videoicon", function(t) {
			if( ! jQuery(this).closest(".cr-ajax-reviews-video").hasClass( "cr-vid-playing" ) ) {
				jQuery(this).closest(".cr-ajax-reviews-video").addClass( "cr-vid-playing" );
				jQuery(this).closest(".cr-ajax-reviews-video").find("video").prop( "controls", true );
				jQuery(this).closest(".cr-ajax-reviews-video").find("video").get(0).play();
			} else {
				jQuery(this).closest(".cr-ajax-reviews-video").find("video").get(0).pause();
				jQuery(this).closest(".cr-ajax-reviews-video").find("video").prop( "controls", false );
				jQuery(this).closest(".cr-ajax-reviews-video").removeClass( "cr-vid-playing" );
			}
			return false;
		} );
		// open a gallery with media files in the reviews grid
		jQuery(".cr-reviews-grid").on("click", ".media-row-count", function(t) {
			if ( cr_ajax_object.disable_lightbox === '0' ) {
				// only if lightbox is not disabled in settings of the plugin
				t.preventDefault();
				const oo = jQuery(".pswp");
				let media = jQuery(this).parent().find(".image-row-vid,.image-row-img"),
					this_media = jQuery(this),
					inx = 0;
				if (media.length > 0 && this_media.length > 0) {
					const o = oo[0];
					var a = [];
					for (i = 0; i < media.length; i++) {
						if ( "vid" === media[i].dataset.crmedia ) {
							a.push({
								html: '<div class="cr-video-wrapper"><video class="cr-media-video" src="' + media[i].src + '" controls></video></div>',
								title: media[i].dataset.crtitle
							});
						} else {
							a.push({
								src: media[i].src,
								w: media[i].naturalWidth,
								h: media[i].naturalHeight,
								title: media[i].alt
							});
						}
						if (this_media[0].src == media[i].src) {
							inx = i;
						}
					}
					var r = {
						index: inx
					};
					new PhotoSwipe(o, PhotoSwipeUI_Default, a, r).init();
				}
			}
		} );
		// play or pause a video in the gallery
		jQuery(document).on("click", ".cr-video-wrapper .cr-media-video", function(t) {
			const vid = jQuery(this).get(0);
			if ( vid ) {
				const isVideoPlaying = !!( vid.currentTime > 0 && !vid.paused && !vid.ended && vid.readyState > 2 );
				if ( isVideoPlaying ) {
					vid.pause();
				} else {
					vid.play();
				}
			}
			return false;
		} );
		// show a lightbox when a user clicks on images in the reviews grid
		jQuery(".cr-reviews-grid").on("click", ".image-row-img, .image-row-count", function(t) {
			if(cr_ajax_object.disable_lightbox === '0') {
				// only if lightbox is not disabled in settings of the plugin
				t.preventDefault();
				const oo = jQuery(".pswp");
				if ( 0 < oo.length ) {
					const o = oo[0];
					var pics = jQuery(this).parent().find("img.image-row-img");
					var this_pic = jQuery(this);
					var inx = 0;
					if (pics.length > 0 && this_pic.length > 0) {
						var a = [];
						for (i = 0; i < pics.length; i++) {
							a.push({
								src: pics[i].src,
								w: pics[i].naturalWidth,
								h: pics[i].naturalHeight,
								title: pics[i].alt
							});
							if (this_pic[0].src == pics[i].src) {
								inx = i;
							}
						}
						var r = {
							index: inx
						};
						new PhotoSwipe(o, PhotoSwipeUI_Default, a, r).init();
					}
				}
			}
		});
		//register a listener for votes on for reviews
		initVoteClick("ol.commentlist", ".cr-voting-a", "cr_vote_review");
		//register a listener for the voting buttons on modal
		initVoteClick(".cr-ajax-reviews-cus-images-modal", ".cr-voting-a", "cr_vote_review");
		//register a listener for the voting buttons on Q & A
		initVoteClick(".cr-qna-block .cr-qna-list-block", ".cr-voting-a", "cr_vote_question");

		//show a lightbox when click on videos attached to reviews
		jQuery("ol.commentlist").on("click", ".cr-video-a, .cr-comment-videoicon", function(t) {
			if( ! jQuery(this).closest(".cr-comment-videos").hasClass( "cr-comment-videos-modal" ) ) {
				let tt = jQuery(this).closest("[class*='cr-comment-video-']");
				jQuery(this).closest(".cr-comment-videos").addClass( "cr-comment-videos-modal" );
				tt.addClass( "cr-comment-video-modal" );
				tt.find( "video" ).prop( "controls", true );
				tt.find( ".cr-comment-videoicon" ).hide();
				tt.find( "video" ).get(0).play();
				return false;
			}
			return false;
		} );
		//close a video lightbox
		jQuery("ol.commentlist").on( "click", ".cr-comment-videos", function(t) {
			if( jQuery(this).hasClass( "cr-comment-videos-modal" ) ) {
				jQuery(this).removeClass( "cr-comment-videos-modal" );
				jQuery(this).find("[class*='cr-comment-video-']").each(function(index, element){
					if( jQuery(element).hasClass( "cr-comment-video-modal" ) ) {
						jQuery(element).removeClass( "cr-comment-video-modal" );
						jQuery(element).find( "video").get(0).pause();
						jQuery(element).find( "video" ).prop( "controls", false );
						jQuery(element).find( ".cr-comment-videoicon" ).show();
						jQuery(element).removeAttr("style");
					}
				});
				return false;
			}
		} );
		//show more ajax reviews
		jQuery(".cr-show-more-reviews-prd").on( "click", function(t) {
			t.preventDefault();
			crShowMoreReviewsPrd( jQuery(this) );
		} );

		// ajax sorting of reviews
		jQuery(".cr-ajax-reviews-sort").on( "change", function(t) {
			t.preventDefault();

			if ( jQuery(this).parents(".cr-all-reviews-shortcode").length ) {
				// sorting in the all reviews block
				cr_filter_all_reviews( jQuery(this) );
			} else {
				// sorting on a product page
				var cr_product_id = jQuery(this).parents(".cr-reviews-ajax-comments").find(".commentlist.cr-ajax-reviews-list").attr("data-product");
				var cr_sort = jQuery(this).children("option:selected").val();
				var cr_rating = jQuery(this).parents(".cr-reviews-ajax-comments").find(".cr-summaryBox-ajax tr.ivole-histogramRow.ivole-histogramRow-s .ivole-histogram-a").attr("data-rating");
				if(!cr_rating){
					cr_rating = 0;
				}
				var cr_data = {
					"action": "cr_sort_reviews",
					"productID": cr_product_id,
					"sort": cr_sort,
					"rating": cr_rating
				};
				jQuery(this).parents(".cr-reviews-ajax-comments").find(".cr-search-no-reviews").hide();
				jQuery(this).parents(".cr-reviews-ajax-comments").find('.cr-ajax-search input').val("").trigger("change");
				jQuery(this).parents(".cr-reviews-ajax-comments").find(".cr-show-more-reviews-prd").hide();
				jQuery(this).parents(".cr-reviews-ajax-comments").find(".commentlist.cr-ajax-reviews-list").hide();
				jQuery(this).parents(".cr-reviews-ajax-comments").find(".cr-show-more-review-spinner").show();
				jQuery(this).parents(".cr-reviews-ajax-comments").find(".cr-summaryBox-ajax").addClass("cr-summaryBar-updating");
				jQuery(this).addClass("cr-sort-updating");
				jQuery.post( {
					url: cr_ajax_object.ajax_url,
					data: cr_data,
					context: this,
					success: function(response) {
						jQuery(this).parents(".cr-reviews-ajax-comments").find(".cr-show-more-review-spinner").hide();
						jQuery(this).parents(".cr-reviews-ajax-comments").find(".cr-summaryBox-ajax").removeClass("cr-summaryBar-updating");
						jQuery(this).removeClass("cr-sort-updating");
						if(response.page > 0){
							jQuery(this).parents(".cr-reviews-ajax-comments").find(".commentlist.cr-ajax-reviews-list").empty();
							jQuery(this).parents(".cr-reviews-ajax-comments").find(".commentlist.cr-ajax-reviews-list").append(response.html);
							jQuery(this).parents(".cr-reviews-ajax-comments").find(".commentlist.cr-ajax-reviews-list").show();
							jQuery(this).parents(".cr-reviews-ajax-comments").attr("data-page",response.page);
							if( response.show_more_label ) {
								jQuery(this).parents(".cr-reviews-ajax-comments").find(".cr-show-more-reviews-prd").text( response.show_more_label );
							}
							if ( response.count_row ) {
								jQuery(this).parents(".cr-reviews-ajax-comments").find(".cr-count-row .cr-count-row-count").html( response.count_row );
							}
							if(!response.last_page){
								jQuery(this).parents(".cr-reviews-ajax-comments").find(".cr-show-more-reviews-prd").show();
							}
						}
					},
					dataType: "json"
				} );
			}
		} );
		// non-ajax filtering of reviews
		jQuery(".cr-noAjax").on( "click", ".ivole-histogram-a", function (t) {
			t.preventDefault();
			const parser = new URL(window.location);
			parser.searchParams.set(cr_ajax_object.rating_filter, jQuery(this).data("rating"));
			parser.hash = cr_ajax_object.reviews_tab;
			window.location = parser.href;
		} );
		// ajax filtering of reviews
		jQuery(".cr-reviews-ajax-comments").on("click", ".ivole-histogram-a, .cr-seeAllReviews", function(t){
			t.preventDefault();
			let tmpParent = jQuery(this).parents(".cr-reviews-ajax-comments");
			let cr_product_id = tmpParent.find(".commentlist.cr-ajax-reviews-list").attr("data-product");
			let cr_nonce = tmpParent.find(".cr-summaryBox-ajax").attr("data-nonce");
			let cr_rating = jQuery(this).attr("data-rating");
			let cr_sort = tmpParent.find(".cr-ajax-reviews-sort").children("option:selected").val();
			let cr_data = {
				"action": "cr_filter_reviews",
				"productID": cr_product_id,
				"rating": cr_rating,
				"sort": cr_sort,
				"security": cr_nonce
			};
			tmpParent.find(".cr-summaryBox-ajax tr.ivole-histogramRow.ivole-histogramRow-s").removeClass("ivole-histogramRow-s");
			if( cr_rating > 0 ) {
				jQuery(this).closest("tr.ivole-histogramRow").addClass("ivole-histogramRow-s");
			}
			tmpParent.find(".cr-search-no-reviews").hide();
			tmpParent.find('.cr-ajax-search input').val("").trigger("change");
			tmpParent.find(".cr-show-more-reviews-prd").hide();
			tmpParent.find(".commentlist.cr-ajax-reviews-list").hide();
			tmpParent.find(".cr-show-more-review-spinner").show();
			tmpParent.find(".cr-summaryBox-ajax").addClass("cr-summaryBar-updating");
			tmpParent.find(".cr-ajax-reviews-sort").addClass("cr-sort-updating");
			jQuery.post( {
				url: cr_ajax_object.ajax_url,
				data: cr_data,
				context: tmpParent,
				success: function(response) {
					this.find(".cr-show-more-review-spinner").hide();
					this.find(".cr-summaryBox-ajax").removeClass("cr-summaryBar-updating");
					this.find(".cr-ajax-reviews-sort").removeClass("cr-sort-updating");
					if(response.page > 0) {
						this.find(".commentlist.cr-ajax-reviews-list").empty();
						this.find(".commentlist.cr-ajax-reviews-list").append(response.html);
						this.find(".commentlist.cr-ajax-reviews-list").show();
						this.attr("data-page",response.page);
						if( response.show_more_label ) {
							this.find( ".cr-show-more-reviews-prd" ).text( response.show_more_label );
						}
						if ( response.count_row ) {
							this.find(".cr-count-row .cr-count-row-count").html( response.count_row );
						}
						if(!response.last_page){
							this.find(".cr-show-more-reviews-prd").show();
						}
					}
				},
				dataType: "json"
			} );
		} );
		// ajax search typing
		jQuery('.cr-ajax-search input').on("keyup", function(e){
			if(e.keyCode == 13){
				jQuery(this).parents(".cr-ajax-search").find("button").trigger("click");
			}
			// show clear icon
			if(jQuery(this).val() !== "") {
				jQuery(this).parents(".cr-ajax-search").find(".cr-clear-input").css("display", "inline-block");
			} else {
				jQuery(this).parents(".cr-ajax-search").find(".cr-clear-input").css("display", "none");
			}
		}).on("change", function(){
			if(jQuery(this).val() === "") jQuery(this).parents(".cr-ajax-search").find(".cr-clear-input").hide();
		});
		//
		jQuery('.cr-reviews-ajax-reviews .cr-ajax-search input').on( 'keyup', crDebounce(
			( ref ) => {
				jQuery(ref.target).parents(".cr-reviews-ajax-comments").attr("data-page", 0);
				jQuery(ref.target).parents(".cr-reviews-ajax-reviews").find(".cr-ajax-reviews-list").empty();
				crShowMoreReviewsPrd( jQuery(ref.target) );
			},
			1000
		) );
		// clear search field
		jQuery(".cr-ajax-search .cr-clear-input").on("click", function () {
			jQuery(this).prev("input").val("");
			jQuery(this).parents(".cr-ajax-search").find(".cr-clear-input").hide();
			jQuery(this).parents(".cr-ajax-search").find("button").trigger("click");
			//
			if( jQuery(this).parents(".cr-reviews-ajax-reviews").length ) {
				// clear search in the case of product pages
				jQuery(this).parents(".cr-reviews-ajax-comments").attr("data-page", 0);
				jQuery(this).parents(".cr-reviews-ajax-reviews").find(".cr-ajax-reviews-list").empty();
				crShowMoreReviewsPrd( jQuery(this) );
			}
		});
		// ajax search of reviews
		jQuery(".cr-ajax-search button").on("click", function (e) {
			e.preventDefault();

			//search in the all reviews block
			if( jQuery(this).parents(".cr-all-reviews-shortcode").length ){
				// search in ajax version of the All Reviews block / shortcode
				cr_filter_all_reviews( jQuery(this) );
			} else {
				jQuery(this).parents(".cr-reviews-ajax-comments").attr("data-page", 0);
				jQuery(this).parents(".cr-reviews-ajax-comments").find(".cr-ajax-reviews-list").empty();
				crShowMoreReviewsPrd( jQuery(this) );
			}
		});
		jQuery(".cr-ajax-reviews-add-review, .cr-nosummary-add").on( "click", function(t) {
			t.preventDefault();
			jQuery(this).closest(".cr-reviews-ajax-reviews").find(".cr-reviews-ajax-comments").hide();
			jQuery(this).closest(".cr-reviews-ajax-reviews").find(".cr-ajax-reviews-review-form").show();
		} );
		// click to filter reviews by tags
		jQuery(".cr-review-tags-filter span.cr-tags-filter").on( "click", function (e) {
			e.preventDefault();
			if(jQuery(this).hasClass("cr-tag-selected")) {
				jQuery(this).removeClass("cr-tag-selected");
			} else {
				jQuery(this).addClass("cr-tag-selected");
			}
			if ( jQuery(this).parents(".cr-all-reviews-shortcode").length ) {
				// tags filtering in the all reviews shortcode
				cr_filter_all_reviews( jQuery(this) );
			} else {
				// tags filtering on a product page
				jQuery(this).parents(".cr-reviews-ajax-comments").attr("data-page", 0);
				jQuery(this).parents(".cr-reviews-ajax-comments").find(".cr-ajax-reviews-list").empty();
				crShowMoreReviewsPrd( jQuery(this) );
			}
		} );
		//open popup window with pictures
		jQuery(".cr-comment-image-top .cr-comment-image-top-item").on( "click", function(t) {
			t.preventDefault();
			jQuery("body").addClass("cr-noscroll");
			let slide_no = jQuery(this).data("slide");
			let imgParent = jQuery(this).closest(".cr-ajax-reviews-cus-images-div").parent();
			imgParent.find(".cr-ajax-reviews-cus-images-modal-cont").addClass("cr-mask-active");
			imgParent.find(".cr-ajax-reviews-cus-images-modal .cr-ajax-reviews-cus-images-slider-main").slickk('setPosition');
			imgParent.find(".cr-ajax-reviews-cus-images-modal .cr-ajax-reviews-cus-images-slider-nav").slickk('setPosition');
			if ( typeof slide_no !== 'undefined' ) {
				imgParent.find(".cr-ajax-reviews-cus-images-modal .cr-ajax-reviews-cus-images-slider-main").slickk('slickGoTo', slide_no, true);
				imgParent.find(".cr-ajax-reviews-cus-images-modal .cr-ajax-reviews-cus-images-slider-nav").slickk('slickGoTo', slide_no, true);
			}
		} );
		jQuery(".cr-comment-image-top .cr-comment-videoicon").on( "click", function(t) {
			jQuery(this).closest( ".cr-comment-image-top" ).find( ".cr-comment-image-top-item" ).trigger( "click" );
		} );
		//close popup window with pictures
		jQuery(".cr-ajax-reviews-cus-images-modal-cont, .cr-ajax-reviews-cus-images-modal .cr-ajax-reviews-cus-images-close").on( "click", function(t) {
			t.preventDefault();
			let closeParent = jQuery(this).closest(".cr-ajax-reviews-cus-images-modal-cont.cr-mask-active");
			closeParent.find(".cr-ajax-reviews-cus-images-modal .cr-ajax-reviews-cus-images-slider-main").slickk('slickGoTo',0,true);
			closeParent.find(".cr-ajax-reviews-cus-images-modal .cr-ajax-reviews-cus-images-slider-nav").slickk('slickGoTo',0,true);
			closeParent.removeClass("cr-mask-active");
			jQuery("body").removeClass("cr-noscroll");
		} );
		jQuery(".cr-ajax-reviews-cus-images-modal-cont .cr-ajax-reviews-cus-images-modal").on( "click", function(t) {
			t.stopPropagation();
		} );
		//Product variations
		jQuery(".single_variation_wrap").on( "show_variation", function ( event, variation ) {
			if(jQuery(".cr_gtin").length){
				jQuery(".cr_gtin_val").text(variation._cr_gtin);
			}
			if(jQuery(".cr_mpn").length){
				jQuery(".cr_mpn_val").text(variation._cr_mpn);
			}
			if(jQuery(".cr_brand").length){
				jQuery(".cr_brand_val").text(variation._cr_brand);
			}
		});
		//Reset Product variations
		jQuery(document).on('reset_data', function () {
			var cr_gtin = jQuery(".cr_gtin"),
			cr_mpn = jQuery(".cr_mpn"),
			cr_brand = jQuery(".cr_brand");

			if(cr_gtin.length){
				jQuery(".cr_gtin_val").text(cr_gtin.data("o_content"));
			}
			if(cr_mpn.length){
				jQuery(".cr_mpn_val").text(cr_mpn.data("o_content"));
			}
			if(cr_brand.length){
				jQuery(".cr_brand_val").text(cr_brand.data("o_content"));
			}
		});
		// show more ajax reviews in the all reviews block
		jQuery('.cr-all-reviews-shortcode .cr-show-more-button').on("click", function (e) {
			e.preventDefault();
			cr_filter_all_reviews( jQuery(this), true );
		});
		jQuery('.cr-all-reviews-shortcode').on("click", ".cr-page-numbers-a", function (e) {
			e.preventDefault();
			cr_filter_all_reviews( jQuery(this), true );
		});
		// filter ajax reviews in the all reviews block
		jQuery(".cr-all-reviews-shortcode").on("click", ".cr-histogram-a, .cr-seeAllReviews", function(t){
			t.preventDefault();
			let cr_rating = jQuery(this).data("rating");
			jQuery("div.ivole-summaryBox tr.ivole-histogramRow.ivole-histogramRow-s").removeClass("ivole-histogramRow-s");
			if ( cr_rating > 0 ) {
				jQuery(this).closest("tr.ivole-histogramRow").addClass("ivole-histogramRow-s");
			}
			jQuery(this).parents(".cr-all-reviews-shortcode").find(".cr-review-tags-filter .cr-tag-selected").removeClass("cr-tag-selected");
			cr_filter_all_reviews( jQuery(this) );
		});

		// show more ajax reviews in the grid
		jQuery( ".cr-reviews-grid .cr-show-more-button" ).on( "click", function (e) {
			e.preventDefault();

			let $this = jQuery(this),
			$spinner =  $this.next(".cr-show-more-spinner"),
			cr_rating = $this.parents(".cr-reviews-grid").find(".ivole-summaryBox.cr-grid-reviews-ajax tr.ivole-histogramRow.ivole-histogramRow-s .cr-histogram-a").attr("data-rating"),
			attributes = $this.parents(".cr-reviews-grid").data("attributes");

			attributes.comment__not_in = $this.parents(".cr-reviews-grid").find(".cr-review-card.cr-card-product").map( function() {
				return jQuery(this).data("reviewid");
			} ).get();
			attributes.comment__not_in = attributes.comment__not_in.concat(
				$this.parents(".cr-reviews-grid").find(".cr-review-card.cr-card-shop").map(function(){
					return jQuery(this).data("reviewid");
				}).get() );

			var grid_data = {
				'action': "ivole_show_more_grid_reviews",
				'rating': cr_rating,
				'attributes': attributes
			};

			$this.hide();
			$spinner.show();

			jQuery.post(cr_ajax_object.ajax_url, grid_data, function(response) {
				$spinner.hide();
				$reviews = jQuery(response.html).find(".cr-review-card");
				let showMoreBtn = jQuery(response.html).find(".cr-show-more-button");
				if ( $reviews.length ) {
					$this.parents(".cr-reviews-grid").find(".cr-reviews-grid-inner").colcade("append", $reviews);
					if ( showMoreBtn.length ) {
						$this.text( showMoreBtn.text() );
						$this.show();
					} else {
						$this.hide();
					}
				} else {
					$this.hide();
				}
			}).fail(function(response) {
				$spinner.hide();
				$this.show();
				$this.parent().append('<div style="color:#cd2653;text-align:center;display:block;">'+response.responseText+'</div>');
			});
		});

		jQuery(".cr-reviews-grid .cr-summaryBox-wrap").on("click", ".cr-histogram-a, .cr-seeAllReviews", function(e){
			e.preventDefault();

			let $this = jQuery(this),
			$grid =  $this.parents(".cr-reviews-grid"),
			$spinner =  $grid.find(".cr-show-more-spinner"),
			cr_rating = $this.attr("data-rating"),
			attributes = $grid.data("attributes");

			attributes.show_more = attributes.count + attributes.count_shop_reviews;
			attributes.comment__not_in = [];

			if(!cr_rating) cr_rating = 0;

			var grid_data = {
				'action': "ivole_show_more_grid_reviews",
				'rating': cr_rating,
				'attributes': attributes
			};

			$grid.find("div.ivole-summaryBox tr.ivole-histogramRow.ivole-histogramRow-s").removeClass("ivole-histogramRow-s");
			if( cr_rating > 0 ) {
				$this.closest("tr.ivole-histogramRow").addClass("ivole-histogramRow-s");
			}
			$grid.find(".cr-reviews-grid-inner").hide();
			$grid.find(".cr-show-more-button").hide();
			$spinner.show();
			$grid.find("div.ivole-summaryBox").addClass("cr-summaryBar-updating");

			jQuery.post(cr_ajax_object.ajax_url, grid_data, function(response) {
				$spinner.hide();
				$grid.find(".cr-show-more-button").show();
				$grid.find(".cr-summaryBox-wrap .cr-count-filtered-reviews").empty();
				$reviews = jQuery(response.html).find(".cr-review-card");
				if($reviews.length){
					$grid.find(".cr-reviews-grid-inner").colcade("empty");
					$grid.find(".cr-reviews-grid-inner").show();
					$grid.find(".cr-reviews-grid-inner").colcade("append", $reviews);
					$grid.find("div.ivole-summaryBox").removeClass("cr-summaryBar-updating");
					$grid.find(".cr-summaryBox-wrap .cr-count-filtered-reviews").append(jQuery(response.html).find(".cr-count-filtered-reviews").html());
				}
			}).fail(function(response) {
				$spinner.hide();
				$this.parent().append('<div style="color: #cd2653;text-align: center;display: block;">'+response.responseText+'</div>');
			});

		});
		jQuery('#cr_floatingtrustbadge').on( "click", function() {
			if( !jQuery(this).hasClass( 'cr-floatingbadge-big' ) ) {
				jQuery(this).find('div.cr-badge.badge_size_compact').hide();
				jQuery(this).find('div.cr-badge.badge--wide-mobile').css( 'display', 'block' );
				jQuery(this).find('div.cr-floatingbadge-close').css( 'display', 'block' );
				jQuery(this).addClass( 'cr-floatingbadge-big' );
				//update colors
				var crcolors = jQuery(this).data('crcolors');
				if (typeof crcolors !== 'undefined') {
					jQuery(this).css( 'border-color', crcolors['big']['border'] );
					jQuery(this).find('div.cr-floatingbadge-background-top').css( 'background-color', crcolors['big']['top'] );
					jQuery(this).find('div.cr-floatingbadge-background-middle').css( 'background-color', crcolors['big']['middle'] );
					jQuery(this).find('div.cr-floatingbadge-background-bottom').css( 'background-color', crcolors['big']['bottom'] );
					jQuery(this).find('div.cr-floatingbadge-background-bottom').css( 'border-color', crcolors['big']['border'] );
				}
			}
		} );
		jQuery('#cr_floatingtrustbadge .cr-floatingbadge-close').on( "click", function(event) {
			if( jQuery('#cr_floatingtrustbadge').hasClass( 'cr-floatingbadge-big' ) ) {
				jQuery(this).closest('#cr_floatingtrustbadge').find('div.cr-badge.badge--wide-mobile').hide();
				jQuery(this).closest('#cr_floatingtrustbadge').find('div.cr-badge.badge_size_compact').css( 'display', 'block' );
				jQuery(this).closest('#cr_floatingtrustbadge').removeClass( 'cr-floatingbadge-big' );
				//update colors
				var crcolors = jQuery(this).closest('#cr_floatingtrustbadge').data('crcolors');
				if (typeof crcolors !== 'undefined') {
					jQuery(this).closest('#cr_floatingtrustbadge').css( 'border-color', crcolors['small']['border'] );
					jQuery(this).closest('#cr_floatingtrustbadge').find('div.cr-floatingbadge-background-top').css( 'background-color', crcolors['small']['top'] );
					jQuery(this).closest('#cr_floatingtrustbadge').find('div.cr-floatingbadge-background-middle').css( 'background-color', crcolors['small']['middle'] );
					jQuery(this).closest('#cr_floatingtrustbadge').find('div.cr-floatingbadge-background-bottom').css( 'background-color', crcolors['small']['bottom'] );
					jQuery(this).closest('#cr_floatingtrustbadge').find('div.cr-floatingbadge-background-bottom').css( 'border-color', crcolors['small']['border'] );
				}
			} else {
				jQuery('#cr_floatingtrustbadge').hide();
				document.cookie = 'cr_hide_trustbadge=true; path=/; max-age='+60*60*24+';';
			}
			event.stopPropagation();
		} );
		jQuery( '.cr-reviews-slider' ).on( 'click', '.cr-slider-read-more a', function (e) {
			e.preventDefault();
			let parent = jQuery(this).parents(".review-text");
			parent.find(".cr-slider-read-more").hide();
			parent.find(".cr-slider-details").css("display", "inline");
			jQuery(this).parents(".cr-reviews-slider").slickk('setPosition');
		} );
		jQuery( '.cr-reviews-slider' ).on( 'click', '.cr-slider-read-less a', function (e) {
			e.preventDefault();
			let parent = jQuery(this).parents(".review-text");
			parent.find(".cr-slider-details").hide();
			parent.find(".cr-slider-read-more").css("display", "inline");
			jQuery(this).parents(".cr-reviews-slider").slickk('setPosition');
		} );
		jQuery('.cr-qna-block .cr-qna-search-block .cr-qna-ask-button').on( 'click', function (e) {
			e.preventDefault();
			jQuery( this ).closest( '.cr-qna-block' ).addClass( 'cr-qna-new-q-form-open' );
		} );
		jQuery(".cr-qna-block .cr-qna-list-block").on( "click", ".cr-qna-ans-button", function (e) {
			e.preventDefault();

			let nameField = jQuery( this ).closest( '.cr-qna-block' ).find( ".cr-qna-new-q-form .cr-review-form-name" );
			let nameValue = nameField.find( ".cr-review-form-txt" ).data("defval");
			jQuery( this ).closest( '.cr-qna-list-q-b' ).find( ".cr-qna-list-inl-answ .cr-review-form-name .cr-review-form-txt" ).val( nameValue );

			let emailField = jQuery( this ).closest( '.cr-qna-block' ).find( ".cr-qna-new-q-form .cr-review-form-email" );
			let emailValue = emailField.find( ".cr-review-form-txt" ).data("defval");
			jQuery( this ).closest( '.cr-qna-list-q-b' ).find( ".cr-qna-list-inl-answ .cr-review-form-email .cr-review-form-txt" ).val( emailValue );

			jQuery( this ).closest( '.cr-qna-list-q-b' ).addClass( 'cr-qna-ans-form-open' );
		} );
		//show more questions and answers
		jQuery(".cr-qna-block").on( "click", ".cr-show-more-que", function(t) {
			t.preventDefault();
			let qna_block = jQuery(this).parents(".cr-qna-block").eq(0);
			let cr_product_id = jQuery(this).attr("data-product");
			let cr_page = jQuery(this).attr("data-page");
			let cr_attributes = qna_block.data("attributes");
			let cr_search = qna_block.find(".cr-ajax-qna-search input").val();
			let cr_permalink = jQuery(this).attr("data-permalink");
			let cr_data = {
				"action": "cr_show_more_qna",
				"productID": cr_product_id,
				"page": cr_page,
				"permalink": cr_permalink,
				"search": cr_search,
				"cr_attributes": cr_attributes
			};
			qna_block.find(".cr-search-no-qna").hide();
			jQuery(this).hide();
			qna_block.find("#cr-show-more-q-spinner").show();
			jQuery.post(cr_ajax_object.ajax_url, cr_data, function(response) {
				jQuery(".cr-qna-block #cr-show-more-q-spinner").hide();
				if(response.page >= 0){
					jQuery(".cr-qna-block .cr-qna-list-block .cr-qna-list-block-inner").append(response.html);
					jQuery(".cr-qna-block #cr-show-more-q-id").attr("data-page",response.page);
					if(!response.last_page){
						jQuery(".cr-qna-block #cr-show-more-q-id").show();
					}
				}
				if(response.html === "" && response.page === 0){
					jQuery(".cr-qna-block .cr-search-no-qna").show();
				}
			}, "json");
		} );
		//search questions and answers
		jQuery(".cr-qna-block .cr-ajax-qna-search input").on("keyup", cr_keyup_delay(function(e) {
			// do nothing if it's an arrow key
			var code = (e.keyCode || e.which);
			if(code == 37 || code == 38 || code == 39 || code == 40) {
				return;
			}
			jQuery(".cr-qna-block #cr-show-more-q-id").attr("data-page", -1);
			jQuery(".cr-qna-block .cr-qna-list-block .cr-qna-list-block-inner").empty();
			jQuery(".cr-qna-block #cr-show-more-q-id").trigger("click");
		}, 500));
		jQuery(".cr-qna-block .cr-ajax-qna-search input").on("keyup", function(e){
			//show clear icon
			if(jQuery(this).val() !== "") {
				jQuery(".cr-qna-block .cr-ajax-qna-search .cr-clear-input").css("display", "inline-block");
			} else {
				if(jQuery(this).val() === "") jQuery(".cr-qna-block .cr-ajax-qna-search .cr-clear-input").hide();
			}
		}).on("change", function(){
			if(jQuery(this).val() === "") jQuery(".cr-qna-block .cr-ajax-qna-search .cr-clear-input").hide();
		});
		jQuery(".cr-qna-block .cr-ajax-qna-search .cr-clear-input").on("click", function () {
			jQuery(this).prev("input").val("");
			jQuery(".cr-qna-block .cr-ajax-qna-search .cr-clear-input").hide();
			jQuery(".cr-qna-block #cr-show-more-q-id").attr("data-page", -1);
			jQuery(".cr-qna-block .cr-qna-list-block .cr-qna-list-block-inner").empty();
			jQuery(".cr-qna-block #cr-show-more-q-id").trigger("click");
		});
		//show QnA tab
		jQuery("body").on("click", "a.cr-qna-link", function () {
			const cr_qna_tab = jQuery( '.cr_qna_tab a' );
			if( cr_qna_tab.length ) {
				cr_qna_tab.trigger( "click" );
			} else {
				jQuery( '.cr-qna-block' ).parents( ':hidden' ).show();
			}
			return true;
		});
		// show Reviews tab
		jQuery("body").on("click", ".cr-review-link", function () {
			const wc_reviews_tab = jQuery( '.reviews_tab a' );
			if( wc_reviews_tab.length ) {
				wc_reviews_tab.trigger( "click" );
				return true;
			}
		});

		// upload images with a review
		jQuery("#cr_review_image").on("change", function () {
			jQuery(".cr-upload-images-status").removeClass("cr-upload-images-status-error");
			jQuery(".cr-upload-images-status").text(cr_ajax_object.cr_upload_initial);
			let allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif', 'video/mp4', 'video/mpeg', 'video/ogg', 'video/webm', 'video/quicktime', 'video/x-msvideo'];
			let uploadFiles = jQuery("#cr_review_image");
			let countFiles = uploadFiles[0].files.length;
			let countUploaded = jQuery(".cr-upload-images-preview .cr-upload-images-containers").length;
			let lastIndex = 1;
			let cr_captcha = "";
			if(jQuery(this).attr("data-lastindex")) {
				lastIndex = parseInt(jQuery(this).attr("data-lastindex"));
			}
			if( countFiles + countUploaded > cr_ajax_object.cr_images_upload_limit ) {
				jQuery(".cr-upload-images-status").addClass("cr-upload-images-status-error");
				jQuery(".cr-upload-images-status").text(cr_ajax_object.cr_upload_error_too_many);
				jQuery(".cr-upload-images-preview .cr-upload-images-containers").not(".cr-upload-ok").remove();
				uploadFiles.val("");
				return;
			}
			for(let i = 0; i < countFiles; i++) {
				if(!allowedTypes.includes(uploadFiles[0].files[i].type) ) {
					jQuery(".cr-upload-images-status").addClass("cr-upload-images-status-error");
					jQuery(".cr-upload-images-status").text(cr_ajax_object.cr_upload_error_file_type);
					jQuery(".cr-upload-images-preview .cr-upload-images-containers").not(".cr-upload-ok").remove();
					uploadFiles.val("");
					return;
				} else if(uploadFiles[0].files[i].size && uploadFiles[0].files[i].size > cr_ajax_object.cr_images_upload_max_size) {
					jQuery(".cr-upload-images-status").addClass("cr-upload-images-status-error");
					jQuery(".cr-upload-images-status").text(cr_ajax_object.cr_upload_error_file_size);
					jQuery(".cr-upload-images-preview .cr-upload-images-containers").not(".cr-upload-ok").remove();
					uploadFiles.val("");
					return;
				} else {
					let container = jQuery("<div/>", {class:"cr-upload-images-containers cr-upload-images-container-" + (lastIndex + i)});
					let progressBar = jQuery("<div/>", {class:"cr-upload-images-pbar"});
					progressBar.append(
						jQuery("<div/>", {class:"cr-upload-images-pbarin"})
					);
					if( -1 === uploadFiles[0].files[i].type.indexOf( 'image' ) ) {
						container.append(
							jQuery( "<svg class='cr-upload-video-thumbnail' viewBox='0 0 576 512'><path d='M336.2 64H47.8C21.4 64 0 85.4 0 111.8v288.4C0 426.6 21.4 448 47.8 448h288.4c26.4 0 47.8-21.4 47.8-47.8V111.8c0-26.4-21.4-47.8-47.8-47.8zm189.4 37.7L416 177.3v157.4l109.6 75.5c21.2 14.6 50.4-.3 50.4-25.8V127.5c0-25.4-29.1-40.4-50.4-25.8z'></path></svg>" )
						);
					} else{
						container.append(
							jQuery("<img>", {class:"cr-upload-images-thumbnail",src:URL.createObjectURL(uploadFiles[0].files[i])})
						);
					}
					container.append(
						progressBar
					);
					let removeButton = jQuery("<button/>", {class:"cr-upload-images-delete"});
					removeButton.append(
						'<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><rect x="0" fill="none" width="20" height="20"/><g><path class="cr-no-icon" d="M12.12 10l3.53 3.53-2.12 2.12L10 12.12l-3.54 3.54-2.12-2.12L7.88 10 4.34 6.46l2.12-2.12L10 7.88l3.54-3.53 2.12 2.12z"/></g></svg>'
					);
					container.append(
						removeButton
					);
					container.append(
						jQuery("<input>", {name:"cr-upload-images-ids[]",type:"hidden",value:""})
					);
					container.append(
						jQuery("<span/>", {class:"cr-upload-images-delete-spinner"})
					);
					jQuery(".cr-upload-images-preview").append(container);
				}
			}
			for(let i = 0; i < countFiles; i++) {
				let formData = new FormData();
				formData.append("action", "cr_upload_local_images_frontend");
				formData.append("cr_nonce", jQuery(this).attr("data-nonce"));
				formData.append("cr_postid", jQuery(this).attr("data-postid"));
				formData.append("cr_file", uploadFiles[0].files[i]);
				if(typeof grecaptcha !== "undefined" && cr_ajax_object.ivole_recaptcha === '1') {
					cr_captcha = grecaptcha.getResponse();
					grecaptcha.reset();
				}
				formData.append("cr_captcha", cr_captcha);
				jQuery.ajax({
					url: cr_ajax_object.ajax_url,
					data: formData,
					processData: false,
					contentType: false,
					dataType: "json",
					type: "POST",
					beforeSend: function() {
					},
					xhr: function() {
						var myXhr = jQuery.ajaxSettings.xhr();
						if ( myXhr.upload ) {
							myXhr.upload.addEventListener( 'progress', function(e) {
								if ( e.lengthComputable ) {
									let perc = ( e.loaded / e.total ) * 100;
									perc = perc.toFixed(0);
									jQuery(".cr-upload-images-preview .cr-upload-images-containers.cr-upload-images-container-" + (lastIndex + i) + " .cr-upload-images-pbar .cr-upload-images-pbarin").width(perc + "%");
								}
							}, false );
						}
						return myXhr;
					},
					success: function(response) {
						if(200 === response["code"]) {
							let idkey = JSON.stringify({ id: response["attachment"]["id"], key: response["attachment"]["key"] });
							jQuery(".cr-upload-images-preview .cr-upload-images-containers.cr-upload-images-container-" + (lastIndex + i) + " input").val(idkey);
							jQuery(".cr-upload-images-preview .cr-upload-images-containers.cr-upload-images-container-" + (lastIndex + i)).addClass("cr-upload-ok");
							jQuery(".cr-upload-images-preview .cr-upload-images-containers.cr-upload-images-container-" + (lastIndex + i) + " button").attr("data-delnonce",response["attachment"]["nonce"]);
						} else if(500 <= response["code"]) {
							jQuery(".cr-upload-images-preview .cr-upload-images-containers.cr-upload-images-container-" + (lastIndex + i)).remove();
							jQuery(".cr-upload-images-status").addClass("cr-upload-images-status-error");
							jQuery(".cr-upload-images-status").text(response["message"]);
						}
					}
				});
			}
			jQuery(this).attr("data-lastindex", lastIndex + countFiles);
			uploadFiles.val("");
		});

		// delete uploaded image
		jQuery(".cr-upload-images-preview").on("click", ".cr-upload-images-delete", function (e) {
			e.preventDefault();
			jQuery(".cr-upload-images-status").removeClass("cr-upload-images-status-error");
			jQuery(".cr-upload-images-status").text(cr_ajax_object.cr_upload_initial);
			let classList = jQuery(this).parent().eq(0).attr("class").split(/\s+/);
			let classes = "";
			jQuery.each(classList, function(index, item) {
				classes += "." + item;
			});
			let ajaxData = {
				"action": "cr_delete_local_images_frontend",
				"cr_nonce": jQuery(this).attr("data-delnonce"),
				"image": jQuery(this).parent().children("input").eq(0).val(),
				"class": classes
			}
			jQuery(this).parent().addClass("cr-upload-delete-pending");
			jQuery.post(cr_ajax_object.ajax_url, ajaxData, function(response) {
				if(200 === response["code"] && response["class"]) {
					jQuery(".cr-upload-images-preview " + response["class"]).remove();
				}
				jQuery(".cr-upload-images-preview " + response["class"]).removeClass("cr-upload-delete-pending");
			}, "json");
		});

		// update star rating on an add-a-review form hover
		jQuery( ".cr-review-form-rating .cr-review-form-rating-inner" ).on(
			"mouseenter",
			function() {
				let rating = parseInt( jQuery( this ).data( "rating" ) );
				let ratingActv = parseInt( jQuery( this ).closest( ".cr-review-form-rating-cont" ).find( ".cr-review-form-rating-actv" ).data( "rating" ) );
				if( isNaN( ratingActv ) ) {
					ratingActv = 0;
				}
				for( r = 1; r < 6; r++ ) {
					if( r > rating && r > ratingActv ) {
						jQuery( this ).closest( ".cr-review-form-rating-cont" ).find( ".cr-review-form-rating-inner[data-rating=" + r + "] .cr-rating-act" ).hide();
						jQuery( this ).closest( ".cr-review-form-rating-cont" ).find( ".cr-review-form-rating-inner[data-rating=" + r + "] .cr-rating-deact" ).show();
					} else {
						jQuery( this ).closest( ".cr-review-form-rating-cont" ).find( ".cr-review-form-rating-inner[data-rating=" + r + "] .cr-rating-deact" ).hide();
						jQuery( this ).closest( ".cr-review-form-rating-cont" ).find( ".cr-review-form-rating-inner[data-rating=" + r + "] .cr-rating-act" ).show();
					}
				}
				jQuery( this ).closest( ".cr-review-form-rating-cont" ).find( ".cr-review-form-rating-nbr" ).text( rating + "/5" );
			}
		).on(
			"mouseleave",
			function() {
				let ratingActv = parseInt( jQuery( this ).closest( ".cr-review-form-rating-cont" ).find( ".cr-review-form-rating-actv" ).data( "rating" ) );
				if( isNaN( ratingActv ) ) {
					ratingActv = 0;
				}
				for( r = 1; r < 6; r++ ) {
					if( r > ratingActv ) {
						jQuery( this ).closest( ".cr-review-form-rating-cont" ).find( ".cr-review-form-rating-inner[data-rating=" + r + "] .cr-rating-act" ).hide();
						jQuery( this ).closest( ".cr-review-form-rating-cont" ).find( ".cr-review-form-rating-inner[data-rating=" + r + "] .cr-rating-deact" ).show();
					} else {
						jQuery( this ).closest( ".cr-review-form-rating-cont" ).find( ".cr-review-form-rating-inner[data-rating=" + r + "] .cr-rating-deact" ).hide();
						jQuery( this ).closest( ".cr-review-form-rating-cont" ).find( ".cr-review-form-rating-inner[data-rating=" + r + "] .cr-rating-act" ).show();
					}
				}
				jQuery( this ).closest( ".cr-review-form-rating-cont" ).find( ".cr-review-form-rating-nbr" ).text( ratingActv + "/5" );
			}
		);

		// update star rating on an add-a-review form click
		jQuery( ".cr-review-form-rating .cr-review-form-rating-inner" ).on( "click", function( e ) {
			e.preventDefault();
			let rating = parseInt( jQuery( this ).data( "rating" ) );
			jQuery( this ).closest( ".cr-review-form-rating-cont" ).find( ".cr-review-form-rating-inner" ).removeClass( "cr-review-form-rating-actv" );
			jQuery( this ).addClass( "cr-review-form-rating-actv" );
			for( r = 1; r < 6; r++ ) {
				if( r > rating ) {
					jQuery( this ).closest( ".cr-review-form-rating-cont" ).find( ".cr-review-form-rating-inner[data-rating=" + r + "] .cr-rating-act" ).hide();
					jQuery( this ).closest( ".cr-review-form-rating-cont" ).find( ".cr-review-form-rating-inner[data-rating=" + r + "] .cr-rating-deact" ).show();
				} else {
					jQuery( this ).closest( ".cr-review-form-rating-cont" ).find( ".cr-review-form-rating-inner[data-rating=" + r + "] .cr-rating-deact" ).hide();
					jQuery( this ).closest( ".cr-review-form-rating-cont" ).find( ".cr-review-form-rating-inner[data-rating=" + r + "] .cr-rating-act" ).show();
				}
			}
			jQuery( this ).closest( ".cr-review-form-rating-cont" ).find( ".cr-review-form-rating-nbr" ).text( rating + "/5" );
			jQuery( this ).closest( ".cr-review-form-rating" ).find( ".cr-review-form-rating-inp" ).val( rating );
			jQuery( this ).closest( ".cr-review-form-rating" ).removeClass( "cr-review-form-error" );
		} );

		// close the review form
		jQuery( ".cr-all-reviews-shortcode .cr-nav-left svg, .cr-all-reviews-shortcode .cr-nav-right svg, .cr-all-reviews-shortcode .cr-review-form-cancel" ).on( "click", function( e ) {
			jQuery( this ).closest( ".cr-all-reviews-shortcode" ).removeClass( "cr-all-reviews-new-review" );
			jQuery( this ).closest( ".cr-review-form-wrap" ).removeClass( "cr-review-form-res" );
			cr_reset_review_form( jQuery( this ) );
		} );
		jQuery( ".cr-all-reviews-shortcode .cr-review-form-wrap" ).on( "click", ".cr-review-form-success", function( e ) {
			jQuery( this ).closest( ".cr-all-reviews-shortcode" ).removeClass( "cr-all-reviews-new-review" );
			jQuery( this ).closest( ".cr-review-form-wrap" ).removeClass( "cr-review-form-res" );
			cr_reset_review_form( jQuery( this ) );
		} );
		jQuery( ".cr-review-form-wrap" ).on( "click", ".cr-review-form-error", function( e ) {
			jQuery( this ).closest( ".cr-review-form-wrap" ).removeClass( "cr-review-form-res" );
		} );
		jQuery( ".cr-ajax-reviews-review-form .cr-nav-left svg, .cr-ajax-reviews-review-form .cr-nav-right svg, .cr-ajax-reviews-review-form .cr-review-form-cancel" ).on( "click", function( e ) {
			jQuery(this).closest(".cr-reviews-ajax-reviews").find(".cr-reviews-ajax-comments").show();
			jQuery(this).closest(".cr-reviews-ajax-reviews").find(".cr-ajax-reviews-review-form").hide();
			jQuery( this ).closest( ".cr-review-form-wrap" ).removeClass( "cr-review-form-res" );
			cr_reset_review_form( jQuery( this ) );
		} );
		jQuery( ".cr-ajax-reviews-review-form .cr-review-form-wrap" ).on( "click", ".cr-review-form-success", function( e ) {
			jQuery(this).closest(".cr-reviews-ajax-reviews").find(".cr-reviews-ajax-comments").show();
			jQuery(this).closest(".cr-reviews-ajax-reviews").find(".cr-ajax-reviews-review-form").hide();
			jQuery( this ).closest( ".cr-review-form-wrap" ).removeClass( "cr-review-form-res" );
			cr_reset_review_form( jQuery( this ) );
		} );
		jQuery( ".cr-reviews-grid .cr-nav-left svg, .cr-reviews-grid .cr-nav-right svg, .cr-reviews-grid .cr-review-form-cancel" ).on( "click", function( e ) {
			jQuery( this ).closest( ".cr-reviews-grid" ).removeClass( "cr-reviews-grid-new-review" );
			jQuery( this ).closest( ".cr-review-form-wrap" ).removeClass( "cr-review-form-res" );
			cr_reset_review_form( jQuery( this ) );
		} );
		jQuery( ".cr-reviews-grid .cr-review-form-wrap" ).on( "click", ".cr-review-form-success", function( e ) {
			jQuery( this ).closest( ".cr-reviews-grid" ).removeClass( "cr-reviews-grid-new-review" );
			jQuery( this ).closest( ".cr-review-form-wrap" ).removeClass( "cr-review-form-res" );
			cr_reset_review_form( jQuery( this ) );
		} );
		// close the qna form
		jQuery( ".cr-qna-block" ).on( "click", ".cr-qna-new-q-form .cr-nav-left svg, .cr-qna-new-q-form .cr-nav-right svg, .cr-qna-new-q-form .cr-review-form-cancel", function( e ) {
			jQuery( this ).closest( ".cr-qna-block" ).removeClass( "cr-qna-new-q-form-open" );
			jQuery( this ).closest( ".cr-qna-new-q-form" ).removeClass( "cr-review-form-res" );
			cr_reset_qna_form( jQuery( this ) );
		} );
		jQuery( ".cr-qna-block" ).on( "click", ".cr-qna-new-q-form .cr-review-form-success", function( e ) {
			jQuery( this ).closest( ".cr-qna-block" ).removeClass( "cr-qna-new-q-form-open" );
			jQuery( this ).closest( ".cr-qna-new-q-form" ).removeClass( "cr-review-form-res" );
			cr_reset_qna_form( jQuery( this ) );
		} );
		jQuery( ".cr-qna-block" ).on( "click", ".cr-qna-new-q-form .cr-review-form-error", function( e ) {
			jQuery( this ).closest( ".cr-qna-new-q-form" ).removeClass( "cr-review-form-res" );
		} );
		jQuery( ".cr-qna-block" ).on( "click", ".cr-qna-list-inl-answ .cr-nav-left svg, .cr-qna-list-inl-answ .cr-nav-right svg, .cr-qna-list-inl-answ .cr-review-form-cancel", function( e ) {
			jQuery( this ).closest( ".cr-qna-list-q-b" ).removeClass( "cr-qna-ans-form-open" );
			jQuery( this ).closest( ".cr-qna-list-inl-answ" ).removeClass( "cr-review-form-res" );
			cr_reset_ans_form( jQuery( this ) );
		} );
		jQuery( ".cr-qna-block" ).on( "click", ".cr-qna-list-inl-answ .cr-review-form-success", function( e ) {
			jQuery( this ).closest( ".cr-qna-list-q-b" ).removeClass( "cr-qna-ans-form-open" );
			jQuery( this ).closest( ".cr-qna-list-inl-answ" ).removeClass( "cr-review-form-res" );
			cr_reset_ans_form( jQuery( this ) );
		} );
		jQuery( ".cr-qna-block" ).on( "click", ".cr-qna-list-inl-answ .cr-review-form-error", function( e ) {
			jQuery( this ).closest( ".cr-qna-list-inl-answ" ).removeClass( "cr-review-form-res" );
		} );

		// submit the review form
		jQuery( ".cr-review-form-wrap .cr-review-form-submit" ).on( "click", function( e ) {
			// check if media upload is in progress
			if ( 0 < jQuery( this ).closest( ".cr-review-form-wrap" ).find( ".cr-form-item-media-preview .cr-upload-images-containers:not(.cr-upload-ok)" ).length ) {
				return false;
			}
			jQuery( this ).closest( ".cr-review-form-wrap" ).find( ".cr-review-form-rating" ).removeClass( "cr-review-form-error" );
			jQuery( this ).closest( ".cr-review-form-wrap" ).find( ".cr-review-form-comment" ).removeClass( "cr-review-form-error" );
			jQuery( this ).closest( ".cr-review-form-wrap" ).find( ".cr-review-form-name" ).removeClass( "cr-review-form-error" );
			jQuery( this ).closest( ".cr-review-form-wrap" ).find( ".cr-review-form-email" ).removeClass( "cr-review-form-error" );
			jQuery( this ).closest( ".cr-review-form-wrap" ).find( ".cr-onsite-question" ).removeClass( "cr-review-form-error" );
			jQuery( this ).closest( ".cr-review-form-wrap" ).find( ".cr-form-item-media" ).removeClass( "cr-review-form-error" );
			jQuery( this ).closest( ".cr-review-form-wrap" ).find( ".cr-review-form-captcha" ).removeClass( "cr-review-form-error" );
			jQuery( this ).closest( ".cr-review-form-wrap" ).find( ".cr-review-form-terms" ).removeClass( "cr-review-form-error" );
			if( cr_validate_review_form( jQuery( this ) ) ) {
				// add custom onsite questions and ratings to the ajax call
				let onsiteQuestions = {};
				jQuery( this ).closest( ".cr-review-form-wrap" ).find( ".cr-review-form-rating input[type='hidden']" ).each(
					function() {
						onsiteQuestions[jQuery( this ).attr( 'name' )] = jQuery( this ).val();
					}
				)
				jQuery( this ).closest( ".cr-review-form-wrap" ).find( ".cr-onsite-question input" ).each(
					function() {
						onsiteQuestions[jQuery( this ).attr( 'name' )] = jQuery( this ).val();
					}
				)
				// if available, add captcha to the ajax call
				let captchaResponse = '';
				if ( 0 < jQuery( this ).closest( ".cr-review-form-wrap" ).find( '.cr-review-form-captcha .cr-recaptcha' ).length ) {
					if ( grecaptcha ) {
						captchaResponse = grecaptcha.getResponse();
					}
				}
				// submit the form if the validation is successful
				let cr_data = {
					"action": "cr_submit_review",
					"rating": jQuery( this ).closest( ".cr-review-form-wrap" ).find( ".cr-review-form-rating-overall .cr-review-form-rating-inp" ).val(),
					"review": jQuery( this ).closest( ".cr-review-form-wrap" ).find( ".cr-review-form-comment-txt" ).val().trim(),
					"name": jQuery( this ).closest( ".cr-review-form-wrap" ).find( ".cr-review-form-name .cr-review-form-txt" ).val().trim(),
					"id": jQuery( this ).closest( ".cr-review-form-wrap" ).find( ".cr-review-form-item-id" ).val(),
					"email": jQuery( this ).closest( ".cr-review-form-wrap" ).find( ".cr-review-form-email .cr-review-form-txt" ).val().trim(),
					"onsiteQuestions": onsiteQuestions,
					"cr-upload-images-ids": jQuery( this ).closest( ".cr-review-form-wrap" ).find( ".cr-form-item-media .cr-upload-images-containers input" ).map( function() {
						return jQuery( this ).val();
					} ).get(),
					'g-recaptcha-response': captchaResponse
				};
				jQuery( this ).closest( ".cr-review-form-wrap" ).addClass( "cr-review-form-submitting" );
				jQuery( this ).closest( ".cr-review-form-wrap" ).find( ".cr-review-form-continue" ).removeClass( "cr-review-form-success" );
				jQuery( this ).closest( ".cr-review-form-wrap" ).find( ".cr-review-form-continue" ).removeClass( "cr-review-form-error" );
				jQuery.post(
					{
						url: cr_ajax_object.ajax_url,
						data: cr_data,
						context: jQuery( this ),
						success: function( response ) {
							this.closest( ".cr-review-form-wrap" ).removeClass( "cr-review-form-submitting" );
							this.closest( ".cr-review-form-wrap" ).addClass( "cr-review-form-res" );
							this.closest( ".cr-review-form-wrap" ).find( ".cr-review-form-result span" ).html( response.description );
							this.closest( ".cr-review-form-wrap" ).find( ".cr-review-form-continue" ).html( response.button );
							if( 0 === response.code ) {
								this.closest( ".cr-review-form-wrap" ).find( ".cr-review-form-continue" ).addClass( "cr-review-form-success" );
							} else {
								this.closest( ".cr-review-form-wrap" ).find( ".cr-review-form-continue" ).addClass( "cr-review-form-error" );
							}
						},
						dataType: "json"
					}
				);
			};
		} );

		// submit a new question
		jQuery( ".cr-qna-block .cr-qna-new-q-form" ).on( "click", ".cr-review-form-submit", function( e ) {
			jQuery( this ).closest( ".cr-qna-new-q-form" ).find( ".cr-review-form-comment" ).removeClass( "cr-review-form-error" );
			jQuery( this ).closest( ".cr-qna-new-q-form" ).find( ".cr-review-form-name" ).removeClass( "cr-review-form-error" );
			jQuery( this ).closest( ".cr-qna-new-q-form" ).find( ".cr-review-form-email" ).removeClass( "cr-review-form-error" );
			jQuery( this ).closest( ".cr-qna-new-q-form" ).find( ".cr-review-form-terms" ).removeClass( "cr-review-form-error" );
			if( cr_validate_qna( jQuery( this ) ) ) {
				// submit the form if the validation is successful
				let cr_data = {
					"action": "cr_new_qna",
					"crNonce": jQuery( this ).closest( ".cr-qna-block" ).data( "nonce" ),
					"currentPostID": jQuery( this ).closest( ".cr-qna-new-q-form" ).find( ".cr-review-form-item-id" ).val(),
					"text": jQuery( this ).closest( ".cr-qna-new-q-form" ).find( ".cr-review-form-comment-txt" ).val().trim(),
					"name": jQuery( this ).closest( ".cr-qna-new-q-form" ).find( ".cr-review-form-name .cr-review-form-txt" ).val().trim(),
					"email": jQuery( this ).closest( ".cr-qna-new-q-form" ).find( ".cr-review-form-email .cr-review-form-txt" ).val().trim()
				};
				jQuery( this ).closest( ".cr-qna-new-q-form" ).addClass( "cr-review-form-submitting" );
				jQuery( this ).closest( ".cr-qna-new-q-form" ).find( ".cr-review-form-continue" ).removeClass( "cr-review-form-success" );
				jQuery( this ).closest( ".cr-qna-new-q-form" ).find( ".cr-review-form-continue" ).removeClass( "cr-review-form-error" );
				//
				const postQuestion = ( token, data, ref ) => {
					data.cptcha = token;
					jQuery.post(
						{
							url: cr_ajax_object.ajax_url,
							data: data,
							context: jQuery( ref ),
							success: function( response ) {
								this.closest( ".cr-qna-new-q-form" ).removeClass( "cr-review-form-submitting" );
								this.closest( ".cr-qna-new-q-form" ).addClass( "cr-review-form-res" );
								this.closest( ".cr-qna-new-q-form" ).find( ".cr-review-form-result span" ).html( response.description );
								this.closest( ".cr-qna-new-q-form" ).find( ".cr-review-form-continue" ).html( response.button );
								if( 0 === response.code ) {
									this.closest( ".cr-qna-new-q-form" ).find( ".cr-review-form-continue" ).addClass( "cr-review-form-success" );
								} else {
									this.closest( ".cr-qna-new-q-form" ).find( ".cr-review-form-continue" ).addClass( "cr-review-form-error" );
								}
							},
							dataType: "json"
						}
					);
				};
				//
				let cr_cptcha = jQuery(this).attr("data-crcptcha");
				var rf = this;
				if ( cr_cptcha && cr_cptcha.length > 0 ) {
					grecaptcha.ready(function() {
						grecaptcha.execute( cr_cptcha, {action: 'submit'} ).then( function(token) {
							postQuestion( token, cr_data, rf )
						} );
					} );
				} else {
					postQuestion( '', cr_data, rf );
				}
			};
		} );

		// submit a new answer
		jQuery( ".cr-qna-block" ).on( "click", ".cr-qna-list-inl-answ .cr-review-form-submit", function( e ) {
			jQuery( this ).closest( ".cr-qna-list-inl-answ" ).find( ".cr-review-form-comment" ).removeClass( "cr-review-form-error" );
			jQuery( this ).closest( ".cr-qna-list-inl-answ" ).find( ".cr-review-form-name" ).removeClass( "cr-review-form-error" );
			jQuery( this ).closest( ".cr-qna-list-inl-answ" ).find( ".cr-review-form-email" ).removeClass( "cr-review-form-error" );
			jQuery( this ).closest( ".cr-qna-list-inl-answ" ).find( ".cr-review-form-terms" ).removeClass( "cr-review-form-error" );
			if( cr_validate_ans( jQuery( this ) ) ) {
				// submit the form if the validation is successful
				let cr_data = {
					"action": "cr_new_qna",
					"crNonce": jQuery( this ).closest( ".cr-qna-block" ).data( "nonce" ),
					"currentPostID": jQuery( this ).closest( ".cr-qna-block" ).find( ".cr-review-form-item-id" ).val(),
					"questionID": jQuery( this ).closest( ".cr-qna-list-q-b" ).data( "question" ),
					"productID": jQuery( this ).closest( ".cr-qna-list-q-b" ).data( "post" ),
					"text": jQuery( this ).closest( ".cr-qna-list-inl-answ" ).find( ".cr-review-form-comment-txt" ).val().trim(),
					"name": jQuery( this ).closest( ".cr-qna-list-inl-answ" ).find( ".cr-review-form-name .cr-review-form-txt" ).val().trim(),
					"email": jQuery( this ).closest( ".cr-qna-list-inl-answ" ).find( ".cr-review-form-email .cr-review-form-txt" ).val().trim()
				};
				jQuery( this ).closest( ".cr-qna-list-inl-answ" ).addClass( "cr-review-form-submitting" );
				jQuery( this ).closest( ".cr-qna-list-inl-answ" ).find( ".cr-review-form-continue" ).removeClass( "cr-review-form-success" );
				jQuery( this ).closest( ".cr-qna-list-inl-answ" ).find( ".cr-review-form-continue" ).removeClass( "cr-review-form-error" );
				//
				const postQuestion = ( token, data, ref ) => {
					data.cptcha = token;
					jQuery.post(
						{
							url: cr_ajax_object.ajax_url,
							data: data,
							context: jQuery( ref ),
							success: function( response ) {
								this.closest( ".cr-qna-list-inl-answ" ).removeClass( "cr-review-form-submitting" );
								this.closest( ".cr-qna-list-inl-answ" ).addClass( "cr-review-form-res" );
								this.closest( ".cr-qna-list-inl-answ" ).find( ".cr-review-form-result span" ).html( response.description );
								this.closest( ".cr-qna-list-inl-answ" ).find( ".cr-review-form-continue" ).html( response.button );
								if( 0 === response.code ) {
									this.closest( ".cr-qna-list-inl-answ" ).find( ".cr-review-form-continue" ).addClass( "cr-review-form-success" );
								} else {
									this.closest( ".cr-qna-list-inl-answ" ).find( ".cr-review-form-continue" ).addClass( "cr-review-form-error" );
								}
							},
							dataType: "json"
						}
					);
				};
				//
				let cr_cptcha = jQuery(this).attr("data-crcptcha");
				var rf = this;
				if ( cr_cptcha && cr_cptcha.length > 0 && grecaptcha ) {
					grecaptcha.ready(function() {
						grecaptcha.execute( cr_cptcha, {action: 'submit'} ).then( function(token) {
							postQuestion( token, cr_data, rf )
						} );
					} );
				} else {
					postQuestion( '', cr_data, rf );
				}
			};
		} );

		// validate custom questions and ratings on submission of a review form on a product page
		jQuery( ".cr-single-product-review" ).on( "click", ".cr-single-product-rev-submit", function(t) {
			let validationResult = true;
			let reviewForm = jQuery( this ).closest( ".cr-single-product-review" );

			// validate ratings
			reviewForm.find( ".cr-review-form-rating-cont.cr-review-form-rating-req" ).each( function( index ) {
				if( 1 > jQuery( this ).find( ".cr-review-form-rating-actv" ).length ) {
					jQuery( this ).closest( ".cr-review-form-rating" ).addClass( "cr-review-form-error" );
					validationResult = false;
				}
			} );

			// validate custom questions
			reviewForm.find( ".cr-onsite-question.cr-review-form-que-req" ).each( function( index ) {
				if( 1 > jQuery( this ).find( "input[type=text]" ).val().trim().length ) {
					jQuery( this ).closest( ".cr-onsite-question" ).addClass( "cr-review-form-error" );
					validationResult = false;
				} else {
					jQuery( this ).closest( ".cr-onsite-question" ).removeClass( "cr-review-form-error" );
				}
			} );

			// validate the comment field
			reviewForm.find( ".cr-review-form-textbox" ).each( function( index ) {
				if( 1 > jQuery( this ).val().trim().length ) {
					jQuery( this ).addClass( "cr-review-form-error" );
					validationResult = false;
				} else {
					jQuery( this ).removeClass( "cr-review-form-error" );
				}
			} );

			// validate the terms checkbox
			if ( 0 < reviewForm.find( '.cr-review-form-terms' ).length ) {
				if ( ! reviewForm.find( '.cr-review-form-terms .cr-review-form-checkbox' ).is(':checked') ) {
					alert( 'Please tick the checkbox to proceed' );
					validationResult = false;
				}
			}

			if( ! validationResult ) {
				t.preventDefault();
			}
		} );

		// open the review form
		jQuery( ".cr-all-reviews-add-review" ).on( "click", function(t) {
			t.preventDefault();
			if ( 0 < jQuery( this ).closest( ".cr-all-reviews-shortcode" ).length ) {
				jQuery( this ).closest( ".cr-all-reviews-shortcode" ).addClass( "cr-all-reviews-new-review" );
			}
			if ( 0 < jQuery( this ).closest( ".cr-reviews-grid" ).length ) {
				jQuery( this ).closest( ".cr-reviews-grid" ).addClass( "cr-reviews-grid-new-review" );
			}
		} );

		// upload media trigger
		jQuery( ".cr-review-form-wrap .cr-form-item-media-none" ).on( "click", function( t ) {
			jQuery( this ).parent().find( "input.cr-form-item-media-file" ).trigger( "click" );
		} );

		// upload media trigger
		jQuery( ".cr-review-form-wrap .cr-form-item-media-preview" ).on( "click", ".cr-form-item-media-add", function( t ) {
			jQuery( this ).parents( ".cr-form-item-media" ).find( "input.cr-form-item-media-file" ).trigger( "click" );
		} );

		// upload media
		jQuery( ".cr-review-form-wrap .cr-form-item-media .cr-form-item-media-file" ).on( "change", function () {
			let allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif', 'video/mp4', 'video/mpeg', 'video/ogg', 'video/webm', 'video/quicktime', 'video/x-msvideo'],
			uploadFiles = jQuery( this ),
			countFiles = uploadFiles[0].files.length,
			lastIndex = 1,
			mediaPreview = jQuery( this ).parent().find( ".cr-form-item-media-preview" ),
			countUploaded = mediaPreview.children( ".cr-upload-images-containers" ).length;
			jQuery(this).closest(".cr-form-item-media").removeClass("cr-review-form-error");
			if( jQuery(this).attr("data-lastindex") ) {
				lastIndex = parseInt( jQuery( this ).attr( "data-lastindex" ) );
			}
			if( countFiles + countUploaded > cr_ajax_object.cr_images_upload_limit ) {
				jQuery(this).closest(".cr-form-item-media").addClass("cr-review-form-error");
				jQuery(this).closest(".cr-form-item-media").find(".cr-review-form-field-error").text(cr_ajax_object.cr_upload_error_too_many);
				uploadFiles.val("");
				return;
			}
			for(let i = 0; i < countFiles; i++) {
				if(!allowedTypes.includes(uploadFiles[0].files[i].type) ) {
					jQuery(this).closest(".cr-form-item-media").addClass("cr-review-form-error");
					jQuery(this).closest(".cr-form-item-media").find(".cr-review-form-field-error").text(cr_ajax_object.cr_upload_error_file_type);
					uploadFiles.val("");
					return;
				} else if( uploadFiles[0].files[i].size && uploadFiles[0].files[i].size > cr_ajax_object.cr_images_upload_max_size * 100 ) {
					jQuery(this).closest(".cr-form-item-media").addClass("cr-review-form-error");
					jQuery(this).closest(".cr-form-item-media").find(".cr-review-form-field-error").text(cr_ajax_object.cr_upload_error_file_size);
					uploadFiles.val("");
					return;
				} else {
					let container = jQuery( "<div/>", {class:"cr-upload-images-containers cr-upload-images-container-" + (lastIndex + i)} );
					let progressBar = jQuery( "<div/>", {class:"cr-upload-images-pbar"} );
					progressBar.append(
						jQuery( "<div/>", {class:"cr-upload-images-pbarin"} )
					);
					if( -1 === uploadFiles[0].files[i].type.indexOf( 'image' ) ) {
						container.append(
							jQuery( "<svg class='cr-upload-video-thumbnail' viewBox='0 0 576 512'><path d='M336.2 64H47.8C21.4 64 0 85.4 0 111.8v288.4C0 426.6 21.4 448 47.8 448h288.4c26.4 0 47.8-21.4 47.8-47.8V111.8c0-26.4-21.4-47.8-47.8-47.8zm189.4 37.7L416 177.3v157.4l109.6 75.5c21.2 14.6 50.4-.3 50.4-25.8V127.5c0-25.4-29.1-40.4-50.4-25.8z'></path></svg>" )
						);
					} else {
						container.append(
							jQuery( "<img>", {class:"cr-upload-images-thumbnail", src:URL.createObjectURL(uploadFiles[0].files[i])} )
						);
					}
					container.append(
						progressBar
					);
					let removeButton = jQuery( "<button/>", {class:"cr-upload-images-delete"} );
					removeButton.append(
						'<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><rect x="0" fill="none" width="20" height="20"/><g><path class="cr-no-icon" d="M12.12 10l3.53 3.53-2.12 2.12L10 12.12l-3.54 3.54-2.12-2.12L7.88 10 4.34 6.46l2.12-2.12L10 7.88l3.54-3.53 2.12 2.12z"/></g></svg>'
					);
					container.append(
						removeButton
					);
					container.append(
						jQuery( "<input>", {name:"cr-upload-images-ids[]",type:"hidden",value:""} )
					);
					container.append(
						jQuery( "<span/>", {class:"cr-upload-images-delete-spinner"} )
					);
					mediaPreview.find( ".cr-form-item-media-add" ).remove();
					mediaPreview.append( container );
					if( countFiles + countUploaded < cr_ajax_object.cr_images_upload_limit ) {
						mediaPreview.append(
							jQuery( "<div class='cr-form-item-media-add'>+</div>" )
						);
					}
				}
			}
			if( 0 < mediaPreview.children( ".cr-upload-images-containers" ).length && ! mediaPreview.hasClass( "cr-form-visible" ) ) {
				mediaPreview.parents( ".cr-form-item-subcontainer" ).addClass( "cr-form-visible" );
			}
			for(let i = 0; i < countFiles; i++) {
				let formData = new FormData();
				formData.append( "action", "cr_upload_media" );
				formData.append( "cr_file", uploadFiles[0].files[i] );
				formData.append( "cr_item", jQuery( this ).closest( ".cr-review-form-wrap" ).find( ".cr-review-form-item-id" ).val() );
				var currentFileInput = jQuery( this );
				jQuery.ajax({
					url: cr_ajax_object.ajax_url,
					data: formData,
					processData: false,
					contentType: false,
					dataType: "json",
					type: "POST",
					context: this,
					beforeSend: function() {
					},
					xhr: function() {
						var myXhr = jQuery.ajaxSettings.xhr();
						if ( myXhr.upload ) {
							myXhr.upload.addEventListener( 'progress', function(e) {
								if ( e.lengthComputable ) {
									let perc = ( e.loaded / e.total ) * 100;
									perc = perc.toFixed(0);
									currentFileInput.parent().find( ".cr-form-item-media-preview .cr-upload-images-containers.cr-upload-images-container-" + (lastIndex + i) + " .cr-upload-images-pbar .cr-upload-images-pbarin" ).width(perc + "%");
								}
							}, false );
						}
						return myXhr;
					},
					success: function(response) {
						if(200 === response["code"]) {
							let idkey = JSON.stringify( { "id": response["attachment"]["id"], "key": response["attachment"]["key"] } );
							currentFileInput.parent().find( ".cr-form-item-media-preview .cr-upload-images-containers.cr-upload-images-container-" + (lastIndex + i) + " input").val(idkey);
							currentFileInput.parent().find( ".cr-form-item-media-preview .cr-upload-images-containers.cr-upload-images-container-" + (lastIndex + i)).addClass("cr-upload-ok");
						} else if(500 <= response["code"]) {
							currentFileInput.parent().find( ".cr-form-item-media-preview .cr-upload-images-containers.cr-upload-images-container-" + (lastIndex + i)).remove();
							let mediaPreview = jQuery(this).closest(".cr-form-item-media").find(".cr-form-item-media-preview");
							let countUploaded = mediaPreview.find( ".cr-upload-images-containers" ).length;
							if( 0 < countUploaded ) {
								if( 0 === mediaPreview.children( ".cr-form-item-media-add" ).length ) {
									mediaPreview.append(
										jQuery( "<div class='cr-form-item-media-add'>+</div>" )
									);
								}
							} else {
								mediaPreview.removeClass( "cr-form-visible" );
								mediaPreview.parents( ".cr-form-item-subcontainer" ).removeClass( "cr-form-visible" );
							}
							jQuery(this).closest(".cr-form-item-media").addClass("cr-review-form-error");
							jQuery(this).closest(".cr-form-item-media").find(".cr-review-form-field-error").text(response["message"]);
						}
					}
				});
			}
			jQuery(this).attr("data-lastindex", lastIndex + countFiles);
			uploadFiles.val("");
		} );

		// delete uploaded image
		jQuery(".cr-review-form-wrap .cr-form-item-media-preview").on("click", ".cr-upload-images-delete", function (e) {
			e.preventDefault();
			let imgContainer = jQuery(this).parent(),
			mediaPreview = imgContainer.parent();
			let ajaxData = {
				"action": "cr_delete_media",
				"image": jQuery( this ).parent().children( "input" ).eq( 0 ).val()
			}
			imgContainer.addClass( "cr-upload-delete-pending" );
			jQuery.post( cr_ajax_object.ajax_url, ajaxData, function(response) {
				imgContainer.removeClass( "cr-upload-delete-pending" );
				if( 200 === response["code"] ) {
					imgContainer.remove();
					let countUploaded = mediaPreview.children( ".cr-upload-images-containers" ).length;
					if( 0 < countUploaded ) {
						if( 0 === mediaPreview.children( ".cr-form-item-media-add" ).length ) {
							mediaPreview.append(
								jQuery( "<div class='cr-form-item-media-add'>+</div>" )
							);
						}
					} else {
						mediaPreview.removeClass( "cr-form-visible" );
						mediaPreview.parents( ".cr-form-item-subcontainer" ).removeClass( "cr-form-visible" );
					}
				}
			}, "json" );
		} );

		cr_maybe_download_media_frontend();

		if( "object" === typeof elementorFrontend && "hooks" in elementorFrontend ) {
			elementorFrontend.hooks.addAction( "frontend/element_ready/widget", function( $scope ) {
				if( -1 !== $scope.data( "widget_type" ).indexOf( "shortcode" ) ) {
					if( 0 < $scope.find( ".cr-reviews-grid-inner" ).length ) {
						crResizeAllGridItems();
					}
				}
			} );
		}

	} );

	const crValidateEmail = (email) => {
		return email.match(
			/^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
		);
	};

	function initVoteClick(sel1, sel2, action) {
		jQuery(sel1).on("click", sel2, function(e) {
			e.preventDefault();

			let reviewIDhtml = jQuery(this).data("vote");
			let parent = jQuery(this).parents(".cr-voting-cont-uni");

			if(reviewIDhtml != null) {
				let reviewID = reviewIDhtml;
				let data = {
					"action": action,
					"reviewID": reviewID,
					"upvote": jQuery(this).data("upvote")
				};

				parent.find(".cr-voting-a").removeClass("cr-voting-active");
				parent.find(".cr-voting-a").addClass("cr-voting-update");
				jQuery.post(cr_ajax_object.ajax_url, data, function(response) {
					parent.find(".cr-voting-a").removeClass("cr-voting-update");
					if( response.code === 0 ) {
						if( response.votes ) {
							parent.find(".cr-voting-upvote-count").text("(" +  response.votes.upvotes + ")");
							parent.find(".cr-voting-downvote-count").text("(" +  response.votes.downvotes + ")");
						}
						if( 0 !== response.votes.current ) {
							if( 0 < response.votes.current ) {
								parent.find(".cr-voting-upvote").addClass("cr-voting-active");
							} else {
								parent.find(".cr-voting-downvote").addClass("cr-voting-active");
							}
						}
					}
				}, "json");
			}
		});
	}

	function cr_keyup_delay(fn, ms) {
		let timer = 0;
		return function(...args) {
			clearTimeout(timer);
			timer = setTimeout(fn.bind(this, ...args), ms || 0);
		};
	}

	function cr_filter_all_reviews( refElement, show_more = false ) {
		let attributes = refElement.parents(".cr-all-reviews-shortcode").data("attributes"),
		cr_rating = refElement.parents(".cr-all-reviews-shortcode").find(".ivole-summaryBox .ivole-histogramRow.ivole-histogramRow-s .cr-histogram-a").attr("data-rating"),
		cr_search = refElement.parents(".cr-all-reviews-shortcode").find(".cr-ajax-search input").val(),
		cr_sort = refElement.parents(".cr-all-reviews-shortcode").find(".cr-ajax-reviews-sort").children("option:selected").val();
		let cr_tags = [];
		refElement.parents(".cr-all-reviews-shortcode").find(".cr-review-tags-filter .cr-tags-filter.cr-tag-selected").each(
			function() {
				cr_tags.push( jQuery(this).attr("data-crtagid") );
			}
		);
		let cr_data = {
			"action": "cr_show_more_all_reviews",
			"attributes": attributes,
			"rating": cr_rating,
			"page": 0,
			"search": cr_search,
			"sort": cr_sort,
			"tags": cr_tags
		};
		//
		if( show_more ) {
			cr_data.page = refElement.data( "page" );
			// click on 'show more' button
			jQuery(".cr-search-no-reviews").hide();
			jQuery('.cr-show-more-button').hide();

			// dim the list of comments when dealing with the pagination
			if ( refElement.hasClass( "cr-page-numbers-a" ) ) {
				refElement.closest( ".cr-all-reviews-shortcode" ).find( ".commentlist" ).addClass( "cr-pagination-load" );
				refElement.closest( ".cr-all-reviews-shortcode" ).find( ".cr-all-reviews-pagination" ).addClass( "cr-pagination-load" );
			} else {
				refElement.closest( ".cr-all-reviews-shortcode" ).find( ".cr-show-more-review-spinner" ).show();
			}

			jQuery.post(
				{
					url: cr_ajax_object.ajax_url,
					data: cr_data,
					context: refElement,
					success: function(response) {
						let shcode = jQuery(this).closest( ".cr-all-reviews-shortcode" );
						shcode.find( ".cr-show-more-review-spinner" ).hide();
						if( response.html !== "" ) {
							if ( jQuery(this).hasClass( "cr-page-numbers-a" ) ) {
								shcode.find(".commentlist").find("*").not(".cr-pagination-review-spinner").remove();
								shcode.find(".commentlist").prepend(response.html);
							} else {
								shcode.find(".commentlist").append(response.html);
							}
							if( ! response.last_page ) {
								shcode.find(".cr-show-more-button").text( response.show_more_label );
								shcode.find(".cr-show-more-button").show();
							}
							shcode.find(".cr-show-more-button").data( "page", response.page );
							shcode.find(".cr-count-row .cr-count-row-count").html( response.count_row );
							if ( response.pagination !== "" ) {
								shcode.find(".cr-all-reviews-pagination").html(response.pagination);
							}
						} else {
							shcode.find(".cr-show-more-button").hide();
						}
						if( response.html == "" && response.page === 1 ){
							shcode.find( ".cr-search-no-reviews" ).show();
						}
						shcode.find( ".commentlist" ).removeClass( "cr-pagination-load" );
						shcode.find( ".cr-all-reviews-pagination" ).removeClass( "cr-pagination-load" );
					},
					dataType: "json"
				}
			);
		} else {
			// click on 'search' button
			refElement.closest(".cr-all-reviews-shortcode").find(".cr-search-no-reviews").hide();
			refElement.closest(".cr-all-reviews-shortcode").find(".cr-show-more-button").hide();
			refElement.closest(".cr-all-reviews-shortcode").find(".commentlist").hide();
			refElement.closest(".cr-all-reviews-shortcode").find(".cr-show-more-review-spinner").show();
			refElement.closest(".cr-all-reviews-shortcode").find(".ivole-summaryBox").addClass("cr-summaryBar-updating");
			refElement.closest(".cr-all-reviews-shortcode").find(".cr-seeAllReviews").addClass("cr-seeAll-updating");
			refElement.closest(".cr-all-reviews-shortcode").find(".cr-ajax-reviews-sort").addClass("cr-sort-updating");
			refElement.closest(".cr-all-reviews-shortcode").find(".cr-review-tags-filter").addClass("cr-tags-updating");
			refElement.closest(".cr-all-reviews-shortcode").find(".cr-all-reviews-pagination").hide();
			jQuery.post(
				{
					url: cr_ajax_object.ajax_url,
					data: cr_data,
					context: refElement,
					success: function(response) {
						let shcode = jQuery(this).closest( ".cr-all-reviews-shortcode" );
						shcode.find( ".cr-show-more-review-spinner" ).hide();
						shcode.find(".ivole-summaryBox").removeClass("cr-summaryBar-updating");
						shcode.find(".cr-seeAllReviews").removeClass("cr-seeAll-updating");
						shcode.find(".cr-ajax-reviews-sort").removeClass("cr-sort-updating");
						shcode.find(".cr-review-tags-filter").removeClass("cr-tags-updating");
						if(response.html !== ""){
							shcode.find(".commentlist").empty();
							shcode.find(".commentlist").append(response.html);
							shcode.find(".commentlist").show();
							shcode.find(".cr-show-more-button").data("page",response.page);
							if( !response.last_page ){
								shcode.find(".cr-show-more-button").text( response.show_more_label );
								shcode.find(".cr-show-more-button").show();
							}
						} else {
							shcode.find(".cr-search-no-reviews").show();
						}
						shcode.find(".cr-count-row .cr-count-row-count").html( response.count_row );
						shcode.find(".cr-all-reviews-pagination").html(response.pagination);
						shcode.find(".cr-all-reviews-pagination").show();
					},
					dataType: "json"
				}
			);
		}
	}

	function cr_maybe_download_media_frontend() {
		jQuery(".cr-comment-image-ext,.cr-comment-video-ext").each(function() {
			let ajaxData = {
				"action": "cr_auto_download_media_frontend",
				"reviewID": jQuery(this).data("reviewid")
			}
			jQuery.post(cr_ajax_object.ajax_url, ajaxData, function(response) {
				// do nothing
			}, "json");
			return false;
		});
	}

	function cr_validate_review_form( submitBtn ) {
		let validationResult = true;

		submitBtn.closest( ".cr-review-form-wrap" ).find( ".cr-review-form-rating-cont.cr-review-form-rating-req" ).each( function( index ) {
			if( 1 > jQuery( this ).find( ".cr-review-form-rating-actv" ).length ) {
				jQuery( this ).closest( ".cr-review-form-rating" ).addClass( "cr-review-form-error" );
				validationResult = false;
			}
		} );
		if( 1 > submitBtn.closest( ".cr-review-form-wrap" ).find( ".cr-review-form-comment-txt" ).val().trim().length ) {
			submitBtn.closest( ".cr-review-form-wrap" ).find( ".cr-review-form-comment" ).addClass( "cr-review-form-error" );
			validationResult = false;
		}
		if( 1 > submitBtn.closest( ".cr-review-form-wrap" ).find( ".cr-review-form-name .cr-review-form-txt" ).val().trim().length ) {
			submitBtn.closest( ".cr-review-form-wrap" ).find( ".cr-review-form-name" ).addClass( "cr-review-form-error" );
			validationResult = false;
		}
		if( ! crValidateEmail( submitBtn.closest( ".cr-review-form-wrap" ).find( ".cr-review-form-email .cr-review-form-txt" ).val().trim() ) ) {
			submitBtn.closest( ".cr-review-form-wrap" ).find( ".cr-review-form-email" ).addClass( "cr-review-form-error" );
			validationResult = false;
		}
		// validate custom questions
		submitBtn.closest( ".cr-review-form-wrap" ).find( ".cr-onsite-question.cr-review-form-que-req" ).each( function( index ) {
			if ( 0 < jQuery( this ).find( "input[type=text]" ).length ) {
				if( 1 > jQuery( this ).find( "input[type=text]" ).val().trim().length ) {
					jQuery( this ).closest( ".cr-onsite-question" ).addClass( "cr-review-form-error" );
					validationResult = false;
				} else {
					jQuery( this ).closest( ".cr-onsite-question" ).removeClass( "cr-review-form-error" );
				}
			}
			if ( 0 < jQuery( this ).find( "input[type=number]" ).length ) {
				if( 1 > jQuery( this ).find( "input[type=number]" ).val().trim().length ) {
					jQuery( this ).closest( ".cr-onsite-question" ).addClass( "cr-review-form-error" );
					validationResult = false;
				} else {
					jQuery( this ).closest( ".cr-onsite-question" ).removeClass( "cr-review-form-error" );
				}
			}
		} );
		// validate terms and conditions if available
		if ( 0 < submitBtn.closest( ".cr-review-form-wrap" ).find( '.cr-review-form-terms' ).length ) {
			if ( ! submitBtn.closest( ".cr-review-form-wrap" ).find( '.cr-review-form-terms .cr-review-form-checkbox' ).is(':checked') ) {
				submitBtn.closest( ".cr-review-form-wrap" ).find( ".cr-review-form-terms" ).addClass( "cr-review-form-error" );
				validationResult = false;
			}
		}
		// validate captcha if available
		if ( 0 < submitBtn.closest( ".cr-review-form-wrap" ).find( '.cr-review-form-captcha .cr-recaptcha' ).length ) {
			if ( grecaptcha ) {
				let widgetId = 0;
				// check if there are multiple captchas on a page
				if ( 0 < jQuery( ".cr-review-form-captcha .cr-recaptcha" ).length ) {
					jQuery( ".cr-review-form-captcha .cr-recaptcha" ).each(
						function( index ) {
							if (
								submitBtn.closest( '.cr-review-form-wrap' ).find( '.cr-review-form-captcha .cr-recaptcha' ).data( 'crcaptchaid' ) === jQuery(this).data( 'crcaptchaid' )
							) {
								widgetId = index;
							}
						}
					);
				}
				//
				let captchaCheck = "";
				if ( 0 < widgetId ) {
					captchaCheck = grecaptcha.getResponse( widgetId );
				} else {
					captchaCheck = grecaptcha.getResponse();
				}
				if ( ! captchaCheck.length > 0 ) {
					submitBtn.closest( ".cr-review-form-wrap" ).find( ".cr-review-form-captcha" ).addClass( "cr-review-form-error" );
					validationResult = false;
				}
			}
		}

		return validationResult;
	}

	function cr_validate_qna( submitBtn ) {
		let validationResult = true;
		if( 1 > submitBtn.closest( ".cr-qna-new-q-form" ).find( ".cr-review-form-comment-txt" ).val().trim().length ) {
			submitBtn.closest( ".cr-qna-new-q-form" ).find( ".cr-review-form-comment" ).addClass( "cr-review-form-error" );
			validationResult = false;
		}
		if( 1 > submitBtn.closest( ".cr-qna-new-q-form" ).find( ".cr-review-form-name .cr-review-form-txt" ).val().trim().length ) {
			submitBtn.closest( ".cr-qna-new-q-form" ).find( ".cr-review-form-name" ).addClass( "cr-review-form-error" );
			validationResult = false;
		}
		if( ! crValidateEmail( submitBtn.closest( ".cr-qna-new-q-form" ).find( ".cr-review-form-email .cr-review-form-txt" ).val().trim() ) ) {
			submitBtn.closest( ".cr-qna-new-q-form" ).find( ".cr-review-form-email" ).addClass( "cr-review-form-error" );
			validationResult = false;
		}
		if ( 0 < submitBtn.closest( ".cr-qna-new-q-form" ).find( '.cr-review-form-terms' ).length ) {
			if ( ! submitBtn.closest( ".cr-qna-new-q-form" ).find( '.cr-review-form-terms .cr-review-form-checkbox' ).is(':checked') ) {
				submitBtn.closest( ".cr-qna-new-q-form" ).find( ".cr-review-form-terms" ).addClass( "cr-review-form-error" );
				validationResult = false;
			}
		}
		return validationResult;
	}

	function cr_validate_ans( submitBtn ) {
		let validationResult = true;
		if( 1 > submitBtn.closest( ".cr-qna-list-inl-answ" ).find( ".cr-review-form-comment-txt" ).val().trim().length ) {
			submitBtn.closest( ".cr-qna-list-inl-answ" ).find( ".cr-review-form-comment" ).addClass( "cr-review-form-error" );
			validationResult = false;
		}
		if( 1 > submitBtn.closest( ".cr-qna-list-inl-answ" ).find( ".cr-review-form-name .cr-review-form-txt" ).val().trim().length ) {
			submitBtn.closest( ".cr-qna-list-inl-answ" ).find( ".cr-review-form-name" ).addClass( "cr-review-form-error" );
			validationResult = false;
		}
		if( ! crValidateEmail( submitBtn.closest( ".cr-qna-list-inl-answ" ).find( ".cr-review-form-email .cr-review-form-txt" ).val().trim() ) ) {
			submitBtn.closest( ".cr-qna-list-inl-answ" ).find( ".cr-review-form-email" ).addClass( "cr-review-form-error" );
			validationResult = false;
		}
		if ( 0 < submitBtn.closest( ".cr-qna-list-inl-answ" ).find( '.cr-review-form-terms' ).length ) {
			if ( ! submitBtn.closest( ".cr-qna-list-inl-answ" ).find( '.cr-review-form-terms .cr-review-form-checkbox' ).is(':checked') ) {
				submitBtn.closest( ".cr-qna-list-inl-answ" ).find( ".cr-review-form-terms" ).addClass( "cr-review-form-error" );
				validationResult = false;
			}
		}
		return validationResult;
	}

	function cr_reset_review_form( refElement ) {
		// reset the rating bar
		refElement.closest( ".cr-review-form-wrap" ).find( ".cr-review-form-rating-cont .cr-review-form-rating-inner" ).removeClass( "cr-review-form-rating-actv" );
		refElement.closest( ".cr-review-form-wrap" ).find( ".cr-review-form-rating-cont .cr-review-form-rating-inner .cr-rating-act" ).hide();
		refElement.closest( ".cr-review-form-wrap" ).find( ".cr-review-form-rating-cont .cr-review-form-rating-inner .cr-rating-deact" ).show();
		refElement.closest( ".cr-review-form-wrap" ).find( ".cr-review-form-rating-cont .cr-review-form-rating-nbr" ).text( "0/5" );
		refElement.closest( ".cr-review-form-wrap" ).find( ".cr-review-form-rating" ).removeClass( "cr-review-form-error" );

		// reset the comment field
		refElement.closest( ".cr-review-form-wrap" ).find( ".cr-review-form-comment-txt" ).val('');
		refElement.closest( ".cr-review-form-wrap" ).find( ".cr-review-form-comment" ).removeClass( "cr-review-form-error" );

		// reset the name field
		refElement.closest( ".cr-review-form-wrap" ).find( ".cr-review-form-name .cr-review-form-txt" ).val('');
		refElement.closest( ".cr-review-form-wrap" ).find( ".cr-review-form-name" ).removeClass( "cr-review-form-error" );

		// reset the email field
		refElement.closest( ".cr-review-form-wrap" ).find( ".cr-review-form-email .cr-review-form-txt" ).val('');
		refElement.closest( ".cr-review-form-wrap" ).find( ".cr-review-form-email" ).removeClass( "cr-review-form-error" );

		// reset the custom questions
		refElement.closest( ".cr-review-form-wrap" ).find( ".cr-onsite-questions .cr-onsite-question" ).removeClass( "cr-review-form-error" );
		refElement.closest( ".cr-review-form-wrap" ).find( ".cr-onsite-questions .cr-onsite-question input[type = 'text']" ).val('');
		refElement.closest( ".cr-review-form-wrap" ).find( ".cr-onsite-questions .cr-onsite-question input[type = 'number']" ).val('');

		// reset the media files
		refElement.closest( ".cr-review-form-wrap" ).find( ".cr-form-item-media .cr-upload-images-containers" ).remove();
		refElement.closest( ".cr-review-form-wrap" ).find( ".cr-form-item-media .cr-form-item-media-preview" ).removeClass( "cr-form-visible" );
		refElement.closest( ".cr-review-form-wrap" ).find( ".cr-form-item-media .cr-form-item-media-preview" ).parents( ".cr-form-item-subcontainer" ).removeClass( "cr-form-visible" );

		// reset the terms and conditions checkbox
		refElement.closest( ".cr-review-form-wrap" ).find( ".cr-review-form-terms .cr-review-form-checkbox" ).prop( 'checked', false );
		refElement.closest( ".cr-review-form-wrap" ).find( ".cr-review-form-terms" ).removeClass( "cr-review-form-error" );

		// reset recaptcha
		refElement.closest( ".cr-review-form-wrap" ).find( ".cr-review-form-captcha" ).removeClass( "cr-review-form-error" );
	}

	function cr_reset_qna_form( refElement ) {
		// reset the comment field
		refElement.closest( ".cr-qna-new-q-form" ).find( ".cr-review-form-comment-txt" ).val('');
		refElement.closest( ".cr-qna-new-q-form" ).find( ".cr-review-form-comment" ).removeClass( "cr-review-form-error" );

		// reset the name field
		const nameField = refElement.closest( ".cr-qna-new-q-form" ).find( ".cr-review-form-name" );
		nameField.find( ".cr-review-form-txt" ).val(nameField.find( ".cr-review-form-txt" ).data('defval'));
		nameField.removeClass( "cr-review-form-error" );

		// reset the email field
		const emailField = refElement.closest( ".cr-qna-new-q-form" ).find( ".cr-review-form-email" );
		emailField.find( ".cr-review-form-txt" ).val(emailField.find( ".cr-review-form-txt" ).data('defval'));
		emailField.removeClass( "cr-review-form-error" );

		// reset the terms and conditions checkbox
		refElement.closest( ".cr-qna-new-q-form" ).find( ".cr-review-form-terms .cr-review-form-checkbox" ).prop( 'checked', false );
		refElement.closest( ".cr-qna-new-q-form" ).find( ".cr-review-form-terms" ).removeClass( "cr-review-form-error" );
	}

	function cr_reset_ans_form( refElement ) {
		// reset the comment field
		refElement.closest( ".cr-qna-list-inl-answ" ).find( ".cr-review-form-comment-txt" ).val("");
		refElement.closest( ".cr-qna-list-inl-answ" ).find( ".cr-review-form-comment" ).removeClass( "cr-review-form-error" );

		// reset the name field
		const nameField = refElement.closest( ".cr-qna-list-inl-answ" ).find( ".cr-review-form-name" );
		nameField.find( ".cr-review-form-txt" ).val("");
		nameField.removeClass( "cr-review-form-error" );

		// reset the email field
		const emailField = refElement.closest( ".cr-qna-list-inl-answ" ).find( ".cr-review-form-email" );
		emailField.find( ".cr-review-form-txt" ).val("");
		emailField.removeClass( "cr-review-form-error" );

		// reset the terms and conditions checkbox
		refElement.closest( ".cr-qna-list-inl-answ" ).find( ".cr-review-form-terms .cr-review-form-checkbox" ).prop( 'checked', false );
		refElement.closest( ".cr-qna-list-inl-answ" ).find( ".cr-review-form-terms" ).removeClass( "cr-review-form-error" );
	}

	function crDebounce(callback, wait) {
		let timeout;
		return (...args) => {
			clearTimeout(timeout);
			if ( 0 < args.length && 13 === args[0].keyCode ) {
				wait = 0;
			} else {
				wait = 1000;
			}
			timeout = setTimeout(function () { callback.apply(this, args); }, wait);
		};
	}

	function crShowMoreReviewsPrd( refElement ) {
		let cr_product_id = refElement.parents(".cr-reviews-ajax-comments").find(".commentlist.cr-ajax-reviews-list").attr("data-product");
		let cr_nonce = refElement.parents(".cr-reviews-ajax-comments").attr("data-nonce");
		let cr_page = refElement.parents(".cr-reviews-ajax-comments").attr("data-page");
		let cr_sort = refElement.parents(".cr-reviews-ajax-comments").find(".cr-ajax-reviews-sort").children("option:selected").val();
		let cr_rating = refElement.parents(".cr-reviews-ajax-comments").find(".cr-summaryBox-ajax tr.ivole-histogramRow.ivole-histogramRow-s a.ivole-histogram-a").attr("data-rating");
		let cr_search = refElement.parents(".cr-reviews-ajax-comments").find(".cr-ajax-search input").val();
		let cr_tags = [];
		refElement.parents(".cr-reviews-ajax-comments").find(".cr-review-tags-filter .cr-tags-filter.cr-tag-selected").each(
			function() {
				cr_tags.push( jQuery(this).attr("data-crtagid") );
			}
		);
		if ( ! cr_rating ){
			cr_rating = 0;
		}
		let cr_data = {
			"action": "cr_show_more_reviews",
			"productID": cr_product_id,
			"page": cr_page,
			"sort": cr_sort,
			"rating": cr_rating,
			"search": cr_search,
			"tags": cr_tags,
			"security": cr_nonce
		};
		refElement.parents(".cr-reviews-ajax-comments").find(".cr-summaryBox-ajax").addClass("cr-summaryBar-updating");
		refElement.parents(".cr-reviews-ajax-comments").find(".cr-ajax-reviews-sort").addClass("cr-sort-updating");
		refElement.parents(".cr-reviews-ajax-comments").find(".cr-review-tags-filter").addClass("cr-review-tags-filter-disabled");
		refElement.parents(".cr-reviews-ajax-comments").find(".cr-search-no-reviews").hide();
		refElement.parents(".cr-reviews-ajax-comments").find(".cr-show-more-reviews-prd").hide();
		refElement.parents(".cr-reviews-ajax-comments").find(".cr-show-more-review-spinner").show();
		jQuery.post( {
			url: cr_ajax_object.ajax_url,
			data: cr_data,
			context: refElement,
			success: function(response) {
				jQuery(this).parents(".cr-reviews-ajax-comments").find(".cr-show-more-review-spinner").hide();
				jQuery(this).parents(".cr-reviews-ajax-comments").find(".cr-summaryBox-ajax").removeClass("cr-summaryBar-updating");
				jQuery(this).parents(".cr-reviews-ajax-comments").find(".cr-ajax-reviews-sort").removeClass("cr-sort-updating");
				jQuery(this).parents(".cr-reviews-ajax-comments").find(".cr-review-tags-filter").removeClass("cr-review-tags-filter-disabled");
				if( response.page > 0 ) {
					jQuery(this).parents(".cr-reviews-ajax-comments").find(".commentlist.cr-ajax-reviews-list").append( response.html );
					jQuery(this).parents(".cr-reviews-ajax-comments").attr("data-page",response.page);
					if ( response.show_more_label ) {
						jQuery(this).parents(".cr-reviews-ajax-comments").find(".cr-show-more-reviews-prd").text( response.show_more_label );
					}
					if ( response.count_row ) {
						jQuery(this).parents(".cr-reviews-ajax-comments").find(".cr-count-row .cr-count-row-count").html( response.count_row );
					}
					if ( ! response.last_page ) {
						jQuery(this).parents(".cr-reviews-ajax-comments").find(".cr-show-more-reviews-prd").show();
					}
					cr_maybe_download_media_frontend();
				}
				if ( response.html == null && response.page === 1 ) {
					jQuery(this).parents(".cr-reviews-ajax-comments").find(".cr-search-no-reviews").show();
				}
			},
			dataType: "json"
		} );
	}

})();

function crResizeAllGridItemsUtil(grids) {
	jQuery(grids).each( function() {
		if(800 > jQuery(this).width()) {
			jQuery(this).find(".cr-reviews-grid-col3").addClass("cr-reviews-grid-col-none");
		}
		if(550 > jQuery(this).width()) {
			jQuery(this).find(".cr-reviews-grid-col2").addClass("cr-reviews-grid-col-none");
		}
		jQuery(this).colcade( {
			columns: ".cr-reviews-grid-col",
			items: ".cr-review-card"
		} );
	} );
}

function crResizeAllGridItems() {
	if (
		typeof Colcade !== "undefined" &&
		typeof Colcade.makeJQueryPlugin !== "undefined" &&
		typeof Colcade.makeJQueryPlugin === "function"
	) {
		if (
			! typeof jQuery.fn.colcade === "function" ||
			typeof jQuery.fn.colcade === "undefined"
		) {
			Colcade.makeJQueryPlugin();
		}
	}
	crResizeAllGridItemsUtil( jQuery(".cr-reviews-grid-inner") );
}

function crResizeTrustBadges() {
	jQuery(".cr-trustbadgef").each(function() {
		let badge = jQuery(this).find(".cr-badge").eq(0);
		let scale = jQuery(this).width() / badge.outerWidth();
		if( 1 > scale ) {
			badge.css("transform", "scale(" + scale + ")");
		}
		badge.css("visibility", "visible");
	});
}
