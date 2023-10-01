<?php
// Exit if accessed directly
if ( ! defined( 'DGWT_WCAS_FILE' ) ) {
	exit;
}

add_filter( 'body_class', function ( $classes ) {
	$classes[] = 'dgwt-wcas-theme-flatsome';

	return $classes;
} );

add_action( 'wp_loaded', function () {
	remove_shortcode( 'search' );
	add_shortcode( 'search', array( 'DgoraWcas\\Shortcode', 'addBody' ) );
} );

add_action( 'wp_head', function () { ?>
	<style>
		.dgwt-wcas-flatsome-up {
			margin-top: -40vh;
		}

		#search-lightbox .dgwt-wcas-sf-wrapp input[type=search].dgwt-wcas-search-input {
			height: 60px;
			font-size: 20px;
		}

		#search-lightbox .dgwt-wcas-search-wrapp {
			-webkit-transition: all 100ms ease-in-out;
			-moz-transition: all 100ms ease-in-out;
			-ms-transition: all 100ms ease-in-out;
			-o-transition: all 100ms ease-in-out;
			transition: all 100ms ease-in-out;
		}

		.dgwt-wcas-overlay-mobile-on .mfp-wrap .mfp-content {
			width: 100vw;
		}

		.dgwt-wcas-overlay-mobile-on .mfp-close,
		.dgwt-wcas-overlay-mobile-on .nav-sidebar {
			display: none;
		}

		.dgwt-wcas-overlay-mobile-on .main-menu-overlay {
			display: none;
		}

		.dgwt-wcas-open .header-search-dropdown .nav-dropdown {
			opacity: 1;
			max-height: inherit;
			left: -15px !important;
		}

		.dgwt-wcas-open:not(.dgwt-wcas-theme-flatsome-dd-sc) .nav-right .header-search-dropdown .nav-dropdown {
			left: auto;
			/*right: -15px;*/
		}

		.dgwt-wcas-theme-flatsome .nav-dropdown .dgwt-wcas-search-wrapp {
			min-width: 450px;
		}

		.header-search-form {
			min-width: 250px;
		}
	</style>
	<?php
} );

add_action( 'wp_footer', function () {
	// Overwriting search icon.
	if ( get_theme_mod( 'header_search_style', 'dropdown' ) === 'dropdown' ) {
		echo '<div id="wcas-theme-search" style="display: block;"><li>' . do_shortcode( '[fibosearch layout="icon"]' ) . '</li></div>';
		?>
		<style>
			.header-main .dgwt-wcas-search-wrapp.dgwt-wcas-layout-icon .dgwt-wcas-search-icon {
				width: 16px;
			}

			.header-main .dgwt-wcas-search-wrapp.dgwt-wcas-layout-icon .dgwt-wcas-ico-magnifier-handler {
				fill: hsla(0, 0%, 40%, .85);
				max-width: 16px;
			}

			.header-main .dgwt-wcas-search-wrapp.dgwt-wcas-layout-icon .dgwt-wcas-ico-magnifier-handler:hover {
				fill: hsla(0, 0%, 7%, .85);
			}

			.header-main.nav-dark .dgwt-wcas-search-wrapp.dgwt-wcas-layout-icon .dgwt-wcas-ico-magnifier-handler {
				fill: hsla(0, 0%, 100%, .8);
			}

			.header-main.nav-dark .dgwt-wcas-search-wrapp.dgwt-wcas-layout-icon .dgwt-wcas-ico-magnifier-handler:hover {
				fill: #ffffff;
			}
		</style>
		<script>
			wcasThemeSearch = document.querySelector('.header-search');
			if (wcasThemeSearch !== null) {
				wcasThemeSearch.replaceWith(document.querySelector('#wcas-theme-search > li'));
			}
			document.querySelector('#wcas-theme-search').remove();
		</script>
		<?php
	}

	$minChars = DGWT_WCAS()->settings->getOption( 'min_chars' );
	if ( empty( $minChars ) || ! is_numeric( $minChars ) ) {
		$minChars = 3;
	}
	?>
	<script>
		(function ($) {
			$(document).ready(function () {
				$(document).on('keyup', '#search-lightbox .dgwt-wcas-search-wrapp .dgwt-wcas-search-input', function () {
					if (this.value.length >= <?php echo $minChars; ?>) {
						if (!$(this).closest('.dgwt-wcas-search-wrapp').hasClass('dgwt-wcas-flatsome-up')) {
							setTimeout(function () {
								$(window).trigger('resize.autocomplete');
							}, 105);
						}
						$(this).closest('.dgwt-wcas-search-wrapp').addClass('dgwt-wcas-flatsome-up');
					}
				});

				var refreshDropdownPosition;
				var style = '';
				var positioning = false;
				$(document).on('mouseenter', '.header-search-dropdown a', function (e) {
					if (positioning) {
						return;
					}

					setTimeout(function () {
						var pos = $(e.target).closest('.header-search').find('.nav-dropdown').attr('style');

						if (typeof pos == 'string' && pos.length > 0) {
							style = pos;
						}

						refreshDropdownPosition = setInterval(function () {
							if ($('body').hasClass('dgwt-wcas-open') && style.length > 0) {
								$('.nav-dropdown').attr('style', style);
							}

							if (!$('body').hasClass('dgwt-wcas-open') && !$('.header-search').hasClass('current-dropdown')) {
								clearInterval(refreshDropdownPosition);
								$('.nav-dropdown').removeAttr('style');
								style = '';
								positioning = false;
							}

						}, 10)
					}, 400);

					positioning = true;
				});

				$(document).on('click', '.header-search-lightbox > a, .header-search-lightbox > .header-button > a', function () {
					var formWrapper = $('#search-lightbox').find('.dgwt-wcas-search-wrapp');
					setTimeout(function () {
						if (formWrapper.find('.dgwt-wcas-close')[0]) {
							formWrapper.find('.dgwt-wcas-close')[0].click();
						}

						formWrapper.removeClass('dgwt-wcas-flatsome-up');
						formWrapper.find('.dgwt-wcas-search-input').focus();
					}, 300);
				});

				// Mobile
				$(document).on('click', '.mobile-nav .header-search .icon-search', function () {

					var $handler = $('.mobile-nav .header-search').find('.js-dgwt-wcas-enable-mobile-form');
					if ($handler.length) {
						$handler[0].click();
					}
				});
			});
		})(jQuery);
	</script>
	<?php
}, 1000 );

add_action( 'wp_footer', function () { ?>
	<script>
		(function ($) {
			// Fix Quantity buttons
			$(document).on('dgwtWcasDetailsPanelLoaded', function () {
				var $quantityFields = $('.dgwt-wcas-details-wrapp .quantity');

				if ($quantityFields.length) {
					$quantityFields.addQty();
				}
			});
		})(jQuery);
	</script>
	<?php
}, 1001 );

add_filter( 'dgwt/wcas/troubleshooting/tests', function ( $tests ) {
	$tests['direct'][] = array(
		'label' => 'Flatsome incompatible settings',
		'test'  => function () {
			$result = array(
				'label'       => '',
				'status'      => 'good',
				'description' => '',
				'actions'     => '',
				'test'        => 'FlatsomeIncompatibleSettings',
			);

			if (
				get_theme_mod( 'header_search_style' ) === 'lightbox' &&
				get_theme_mod( 'header_cart_style', 'dropdown' ) === 'off-canvas' &&
				DGWT_WCAS()->settings->getOption( 'show_details_box' ) === 'on'
			) {
				$customizeUrl = admin_url( 'customize.php' );

				$result['status']       = 'critical';
				$result['label']        = __( 'There is a conflict between Flatsome theme settings and our plugin', 'ajax-search-for-woocommerce' );
				$result['description']  = '<p style="max-width: 740px">' . __( "There is a rare combination of <b>FiboSearch</b> and <b>Flatsome</b> settings that might cause issues when adding a product to the cart from the autocomplete search results. Unfortunately, you have this combination. You can't use <b>Off-Canvas Sidebar</b> as <b>Cart Style (Flatsome)</b>, <b>Search Icon Type</b> as <b>Search Icon Type (Flatsome)</b>, and <b>Details Panel (FiboSearch)</b> at the same time. The solution is to resign from one of these options.", 'ajax-search-for-woocommerce' ) . '</p>';
				$result['description'] .= '<p><b>' . __( 'Solutions (you only need to use one of them)', 'ajax-search-for-woocommerce' ) . '</b></p>';
				$result['description'] .= '<ol><li>' . __( '(FiboSearch settings) Go to <code>Autocomplete</code> tab and disable <code>Show Details Panel</code> option.', 'ajax-search-for-woocommerce' ) . '</li>';
				$result['description'] .= '<li>' . sprintf( __( '(Flatsome settings) Go to <code>Appearance -> <a href="%s" target="_blank">Customize</a> -> Header -> Search</code> and change <code>Search Icon Type</code> option to <code>Dropdown</code>.', 'ajax-search-for-woocommerce' ), $customizeUrl ) . '</li>';
				$result['description'] .= '<li>' . sprintf( __( '(Flatsome settings) Go to <code>Appearance -> <a href="%s" target="_blank">Customize</a> -> Header -> Cart</code> and change <code>Cart Style</code> option to <code>Dropdown</code> or <code>Link only</code>.', 'ajax-search-for-woocommerce' ), $customizeUrl ) . '</li></ol>';
			}

			return $result;
		}
	);

	return $tests;
} );
