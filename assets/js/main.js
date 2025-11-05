/**
 * PinterHVN Theme Main JavaScript
 * 
 * Handles:
 * - Masonry layout
 * - Infinite scroll
 * - Video hover play
 * - Scroll to top
 *
 * @package PinterHVN_Theme
 * @since 1.0.0
 */

(function($) {
    'use strict';

    var PinterHVN = {
        $grid: null,
        currentPage: 1,
        isLoading: false,
        hasMore: true,

        init: function() {
            this.initMasonry();
            this.initInfiniteScroll();
            this.initScrollToTop();
        },

        initMasonry: function() {
            var self = this;
            this.$grid = $('.pinterhvn-grid');
            if (this.$grid.length === 0) return;

            this.$grid.imagesLoaded(function() {
                self.$grid.masonry({
                    itemSelector: '.grid-item',
                    columnWidth: '.grid-sizer',
                    percentPosition: true,
                    gutter: 20,
                    transitionDuration: '0.3s',
                    initLayout: true
                });

                if (self.hasMorePosts()) {
                    $('.load-more-wrapper').fadeIn();
                }
            });
        },

        initInfiniteScroll: function() {
            var self = this;

            $('#load-more-assets').on('click', function(e) {
                e.preventDefault();
                self.loadMoreAssets();
            });
        },

        loadMoreAssets: function() {
            var self = this;
            if (this.isLoading || !this.hasMore) return;

            this.isLoading = true;
            $('#load-more-assets').prop('disabled', true).addClass('loading');
            $('.load-more-wrapper .spinner').show();

            var data = {
                action: 'pinterhvn_load_more_assets',
                page: this.currentPage + 1,
                posts_per_page: 12,
                nonce: pinterhvnTheme.nonce
            };

            $.ajax({
                url: pinterhvnTheme.ajax_url,
                type: 'POST',
                data: data,
                success: function(response) {
                    if (response.success && response.data.html) {
                        var $newItems = $(response.data.html);
                        $newItems.imagesLoaded(function() {
                            self.$grid.append($newItems).masonry('appended', $newItems);
                            setTimeout(function() {
                                self.$grid.masonry('layout');
                            }, 100);
                            self.currentPage++;
                            if (!response.data.has_more) {
                                self.hasMore = false;
                                $('.load-more-wrapper').fadeOut();
                            }
                        });
                    } else {
                        self.hasMore = false;
                        $('.load-more-wrapper').fadeOut();
                    }
                },
                error: function() {
                    console.error('Load more failed');
                },
                complete: function() {
                    self.isLoading = false;
                    $('#load-more-assets').prop('disabled', false).removeClass('loading');
                    $('.load-more-wrapper .spinner').hide();
                }
            });
        },

        hasMorePosts: function() {
            return $('.pagination').length > 0;
        },

        initScrollToTop: function() {
            var $scrollBtn = $('#scroll-to-top');
            if ($scrollBtn.length === 0) return;

            $(window).on('scroll', function() {
                if ($(window).scrollTop() > 500) {
                    $scrollBtn.fadeIn();
                } else {
                    $scrollBtn.fadeOut();
                }
            });

            $scrollBtn.on('click', function() {
                $('html, body').animate({ scrollTop: 0 }, 600);
            });
        }
    };

    $(document).ready(function() {
        PinterHVN.init();
    });

    window.PinterHVN = PinterHVN;

})(jQuery);
