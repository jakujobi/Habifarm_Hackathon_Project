<?php
// Exit if accessed directly
if ( ! defined( 'DGWT_WCAS_FILE' ) ) {
	exit;
}

add_filter( 'blocksy:header:item-view-path:search', function ( $path ) {
	return DGWT_WCAS_DIR . 'partials/themes/blocksy/search.php';
} );

add_filter( 'get_search_form', function ( $form, $args ) {
	// Used on 404 page.
	return do_shortcode( '[fibosearch layout="classic"]' );
}, 10, 2 );

add_action( 'wp_head', function () {
	?>
	<style>
		.dgwt-wcas-ico-magnifier, .dgwt-wcas-ico-magnifier-handler {
			max-width: none;
			fill: var(--icon-color, var(--color));
			max-height: var(--icon-size, 15px);
		}

		.dgwt-wcas-ico-magnifier:hover, .dgwt-wcas-ico-magnifier-handler:hover {
			fill: var(--icon-hover-color, var(--paletteColor2));
		}

		.dgwt-wcas-suggestion {
			transition: none;
		}
	</style>
	<?php
} );
