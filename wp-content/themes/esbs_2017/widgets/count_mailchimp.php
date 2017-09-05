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

		$this->start_controls_section(
			'section_title_style',
			[
				'label' => __( 'Title', 'elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'title_color',
			[
				'label' => __( 'Text Color', 'elementor' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-heading-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'typography',
				'scheme' => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .elementor-heading-title',
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'text_shadow',
				'selector' => '{{WRAPPER}} .elementor-heading-title',
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

