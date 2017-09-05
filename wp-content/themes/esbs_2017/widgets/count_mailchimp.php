<?php


use Elementor\Controls_Manager;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use Elementor\Scheme_Color;
use Elementor\Scheme_Typography;


class CountMailchimplWidget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'count-mailchimp';
	}

	public function get_title() {
		return 'Count MailChimp';
	}

	public function get_icon() {
		return 'eicon-slider-push';
	}


	protected function _register_controls() {

		$this->start_controls_section(
			'section_slides',
			[
				'label' => __( 'MailChimp lists' ),
			]
		);

		$this->add_control(
			'list', [
				'label' => 'List id',
				'type'  => Controls_Manager::TEXT,
			]
		);

		$this->end_controls_section();
	}

	public function render() {

		$settings = $this->get_settings();

		$list_id = $settings['list'];

		$list = (array) mc4wp_get_api_v3()->get_list($list_id);

		$list_stats = (array) $list['stats'];

		echo $list_stats['member_count'];
	}

}

