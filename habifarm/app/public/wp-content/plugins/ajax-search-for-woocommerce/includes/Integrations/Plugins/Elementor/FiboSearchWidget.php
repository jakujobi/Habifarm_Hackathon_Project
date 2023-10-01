<?php

namespace DgoraWcas\Integrations\Plugins\Elementor;

use Elementor\Controls_Manager;
use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * FiboSearchWidget Class
 */
class FiboSearchWidget extends Widget_Base {
	public function get_name(): string {
		return 'fibosearch';
	}

	public function get_title(): string {
		return esc_html__( 'FiboSearch', 'ajax-search-for-woocommerce' );
	}

	public function get_icon(): string {
		return 'fibosearchicon-fibosearch';
	}

	public function get_categories(): array {
		return [ 'woocommerce-elements' ];
	}

	public function get_keywords(): array {
		return [ 'fibo', 'search', 'fibosearch' ];
	}


	public function get_custom_help_url(): string {
		// TODO Sprecyzować link do strony z opisem dla Elementora.
		return 'https://fibosearch.com/documentation/';
	}

	protected function register_controls() {
		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'Appearance', 'ajax-search-for-woocommerce' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'layout',
			[
				'type'    => Controls_Manager::SELECT,
				'label'   => esc_html__( 'Layout', 'ajax-search-for-woocommerce' ),
				'options' => [
					'default'           => esc_html__( 'Default', 'ajax-search-for-woocommerce' ),
					'classic'           => esc_html__( 'Search bar', 'ajax-search-for-woocommerce' ),
					'icon'              => esc_html__( 'Search icon', 'ajax-search-for-woocommerce' ),
					'icon-flexible'     => esc_html__( 'Icon on mobile, search bar on desktop', 'ajax-search-for-woocommerce' ),
					'icon-flexible-inv' => esc_html__( 'Icon on desktop, search bar on mobile', 'ajax-search-for-woocommerce' ),
				],
				'default' => 'default',
			]
		);

		$this->add_control(
			'mobile_overlay',
			[
				'type'  => Controls_Manager::SWITCHER,
				'label' => esc_html__( 'Overlay on mobile', 'ajax-search-for-woocommerce' ),
			]
		);

		$this->end_controls_section();
	}

	/**
	 * @return void
	 */
	protected function render() {
		$params = '';

		// Layout.
		$layout = $this->get_settings_for_display( 'layout' );
		if ( in_array( $layout, [ 'classic', 'icon', 'icon-flexible', 'icon-flexible-inv' ] ) ) {
			$params .= ' layout="' . $layout . '"';
		}

		// Overlay on mobile.
		$mobile_overlay = $this->get_settings_for_display( 'mobile_overlay' );
		if ( $mobile_overlay === 'yes' ) {
			$params .= ' mobile_overlay="1"';
		}

		echo do_shortcode( '[fibosearch' . $params . ']' );
	}
}
