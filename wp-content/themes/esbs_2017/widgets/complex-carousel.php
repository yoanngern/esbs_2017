<?php


use Elementor\Controls_Manager;
use Elementor\Repeater;


class ComplexCarouselWidget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'complex-carousel';
	}

	public function get_title() {
		return 'Complex Carousel';
	}

	public function get_icon() {
		return 'eicon-slider-push';
	}

	public function get_script_depends() {
		return [ 'elementor-slider' ];

	}



	protected function _register_controls() {

		$this->start_controls_section(
			'section_slides',
			[
				'label' => __( 'Slides' ),
			]
		);

		$this->add_control(
			'nb_slide', [
				'label' => 'Nb slide /page',
				'type'  => Controls_Manager::NUMBER,
			]
		);

		$repeater = new Repeater();


		$repeater->start_controls_tabs( 'slides_repeater' );


		$repeater->add_control(
			'image',
			[
				'label'       => 'Image',
				'type'        => Controls_Manager::MEDIA,
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'name',
			[
				'label'       => 'Name',
				'type'        => Controls_Manager::TEXT,
				'default'     => 'John Smith',
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'title',
			[
				'label'       => 'Title',
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'statement',
			[
				'label'       => 'Statement',
				'type'        => Controls_Manager::TEXTAREA,
				'label_block' => true,
			]
		);


		$this->add_control(
			'slides',
			[
				'label'       => 'Items',
				'type'        => Controls_Manager::REPEATER,
				'show_label'  => true,
				'fields'      => array_values( $repeater->get_controls() ),
				'title_field' => '{{{ name }}}',
			]
		);


		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	public function render() {

		$settings = $this->get_settings();

		$slides   = $settings['slides'];
		$nb_slide = $settings['nb_slide'];
		$id_elem  = $settings['_element_id'];

		shuffle( $slides );

		$slides_content = "";

		$page_no = 1;


		foreach ( $slides as $key => $slide ) {

			$id        = $slide['_id'];
			$image_url = $slide['image']['url'];
			$name      = $slide['name'];
			$title     = $slide['title'];
			$statement = $slide['statement'];

			$nb = $key + 1;

			$slide_content = "
			
			
			<article id='$id' class='slide' data-index='$nb'>
				<div class='image'>
					<img src='$image_url' alt='$name'>
				</div>
				<h1>$name</h1>
				<h2>$title</h2>
				<p>$statement</p>
			</article>	 
			
			";

			if ( $key % $nb_slide == 0 ) {

				$class = 'page nb_slide-' . $nb_slide;

				if ( $key == 0 ) {
					$class = 'page actual nb_slide-' . $nb_slide;
				}

				$slides_content .= "<div class='$class' id='page-$page_no'>";
				$page_no ++;
			}

			$slides_content .= $slide_content;

			if ( $nb % $nb_slide == 0 ) {

				$slides_content .= "</div>";

			}


		}

		if ( sizeof( $slides ) % $nb_slide != 0 ) {
			$slides_content .= "</div>";
		}


		echo "
			
			<section class='elementor-slider' id='$id_elem' data-nb='$nb_slide'>
				<div id='prev' class='nav'></div>
				<div id='next' class='nav'></div>
				<div class='container' data-nb='$nb_slide'>
					<div class='content'>$slides_content</div>
				</div>
				
			</section>
			
		";
	}

}