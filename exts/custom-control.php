<?php
namespace Elementor\CustomControl;

use \Elementor\Base_Data_Control;

class Direction_Control extends Base_Data_Control {


	const Direction = 'image_selector';

	/**
	 * Set control type.
	 */
	public function get_type() {
		return self::Direction;
	}

	/**
	 * Enqueue control scripts and styles.
	 */
	// public function enqueue() {
	// 	$url = plugin_dir_path(__FILE__).'/inc/elementor/assets/css/';
	// 	// Styles
	// 	wp_enqueue_style('image-selector', $url.'image-selector.css', array(), '');
	// }

	/**
	 * Set default settings
	 */
	protected function get_default_settings() {
		return [
			'label_block' => true,
			'toggle' => true,
			'options' => [],
            'selectors' => [],
		];
	}
	
	/**
	 * control field markup
	 */
	public function content_template() {
		$control_uid = $this->get_control_uid('{{ value }}');
		?>
        <div class="elementor-control-content">
			<div class="elementor-control-field">
			<label class="elementor-control-title">{{{ data.label }}}</label>
			<div class="elementor-control-input-wrapper na_ma">
				<div class="elementor-choices">
					<# _.each( data.options, function( options, value ) { #>
					<input id="<?php echo $control_uid; ?>" type="radio" name="elementor-choose-{{ data.name }}-{{ data._cid }}" value="{{ value }}" data-setting="{{ data.name }}">
					<label class="elementor-choices-label elementor-control-unit-1 tooltip-target" for="<?php echo $control_uid; ?>" data-tooltip="{{ options.title }}" original-title="{{ options.title }}">
						<i class="{{ options.icon }}" aria-hidden="true"></i>
						<span class="elementor-screen-only">{{ options.title }}</span>
					</label>
					<# } ); #>
					
				</div>
			</div>
            <# if ( data.description ) { #>
                <div class="elementor-control-field-description">{{{ data.description }}}</div>
            <# } #>
		</div>

		
					
		<?php
	}

}