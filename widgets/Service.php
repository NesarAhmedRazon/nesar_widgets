<?php

namespace WPC\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH')) exit; // Exit if accessed directly


class Service extends Widget_Base
{

	public function get_style_depends()
	{

		wp_register_style('nesar_wid_service', plugin_dir_url(__DIR__) . 'decor_service.css');
		return [
			'nesar_wid_service'
		];
	}

	public function get_name()
	{
		return 'service';
	}

	public function get_title()
	{
		return esc_html__('Tallyfy Service', 'nesar-widgets');
	}

	public function get_icon()
	{
		return 'eicon-favorite';
	}

	public function get_categories()
	{
		return ['general'];
	}

	protected function register_controls()
	{

		$this->start_controls_section(
			'style_section',
			[
				'label' => esc_html__('Style Section'),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'website_link',
			[
				'label' => esc_html__('Link'),
				'type' => \Elementor\Controls_Manager::URL,
				'placeholder' => esc_html__('https://your-link.com'),
				'separator' => 'after',
				'default' => [
					'url' => '',
					'custom_attributes' => '',
				],
			]
		);

		$this->add_control(
			'title',
			[
				'label' => esc_html__('Title'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'placeholder' => esc_html__('Enter Heading'),

			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'label' => esc_html__('Title Style'),
				'selector' => '{{WRAPPER}} .title',
				'separator' => 'after',
			]
		);
		$this->add_control(
			'description',
			[
				'rows' => 5,
				'label' => esc_html__('Description'),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'default' => esc_html__('Default description'),
				'placeholder' => esc_html__('Type your description here'),

			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'body_typography',
				'label' => esc_html__('Description Style'),
				'selector' => '{{WRAPPER}} .description',
			]
		);
		$this->add_control(
			'more_options',
			[
				'label' => esc_html__('Background Color', 'plugin-name'),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->start_controls_tabs(
			'style_tabs'
		);

		$this->start_controls_tab(
			'style_normal_tab',
			[
				'label' => esc_html__('Normal'),
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'background',
				'label' => esc_html__('Background'),
				'types' => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}} .service',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'style_hover_tab',
			[
				'label' => esc_html__('Hover'),
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'background_hover',
				'label' => esc_html__('Background'),
				'types' => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}}:hover .service',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();
		$this->add_control(
			'Transition time',
			[
				'label' => esc_html__('Transition time'),
				'label_block' => true,
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => ['ms'],
				'range' => [
					'ms' => [
						'min' => 0,
						'max' => 1000,
						'step' => 50,
					]
				],
				'default' => [
					'unit' => ['ms'],
					'size' => 500,
				],
				'selectors' => [
					'{{WRAPPER}} .service' => 'transition-duration: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}


	protected function render()
	{
		$settings = $this->get_settings_for_display();
		if (!empty($settings['website_link']['url'])) {
			$this->add_link_attributes('website_link', $settings['website_link']);
		}
		$this->add_inline_editing_attributes('label_heading', 'basic');
		$this->add_render_attribute(
			'title',
			[
				'class' => ['service__title-heading'],
			]
		);

?>
<a class="service" <?php echo $this->get_render_attribute_string('website_link'); ?>>
    <div class="title" <?php echo $this->get_render_attribute_string('title'); ?>>
        <?php echo $settings['title'] ?>
    </div>
    <div class="description" <?php echo $this->get_render_attribute_string('description'); ?>>
        <?php echo $settings['description'] ?>
    </div>
</a>
<?php
	}

	protected function content_template()
	{
	?>
<# view.addInlineEditingAttributes( 'label_heading' , 'basic' ); view.addRenderAttribute( 'title' , { 'class' :
    [ 'service__title-heading' ], } ); #>
    <a class="service" href="{{ settings.website_link.url }}">
        <div class="title" {{{ view.getRenderAttributeString( 'title' ) }}}>{{{ settings.title }}}</div>
        <div class="description">
            {{{ settings.content }}}
        </div>
        </div>
    </a>
    <?php
	}
}
