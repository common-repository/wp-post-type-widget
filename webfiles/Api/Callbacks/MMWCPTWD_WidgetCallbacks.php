<?php 
/**
 * @package  getwebPlugin
 */
namespace rsCustomPost\Api\Callbacks;
if(!class_exists('MMWCPTWD_WidgetCallbacks')):
class MMWCPTWD_WidgetCallbacks
{

	public function mmwcptwd_cwm_ectionManager()
	{
		echo 'Create as many Custom Widget as you want.';
	}

	public function mmwcptwd_cwm_sanitize( $input )
	{
		$output = get_option('mmwcptwd_cwm');

		if ( isset($_POST["remove"]) ) {
			unset($output[$_POST["remove"]]);

			return $output;
		}

		if ( count($output) == 0 ) {
			$output[$input['widget_id']] = $input;

			return $output;
		}

		foreach ($output as $key => $value) {
			if ($input['widget_id'] === $key) {
				$output[$key] = $input;
			} else {
				$output[$input['widget_id']] = $input;
			}
		}
		
		return $output;
	}
	

	public function mmwcptwd_widget_field( $args ) {
		switch ($args['type']) {
			case 'text':
				$output = '';
				$name = $args['label_for'];
				$option_name = $args['option_name'];
				$required_true = isset($args['required']) && $args['required'] == true ? 'required' : '';
				$value = '';
				
				if ( isset($_POST["edit_widgets"]) ) {
					$input = get_option( $option_name );
					$value = sanitize_text_field($input[$_POST["edit_widgets"]][$name]);
				}

				$output .= '<div class="form-group"><input type="' . esc_attr($args['type']) . '" class="regular-text form-control" id="' . esc_attr($name) . '" name="' . esc_attr($option_name . '[' . $name . ']') . '" value="' . esc_attr($value) . '" placeholder="' . esc_attr($args['placeholder']) . '" '.esc_attr($required_true).'></div>';

			echo $output;
			break;
			default:
			$output = '';
				$name = $args['label_for'];
				$option_name = $args['option_name'];
				$required_true = isset($args['required']) && $args['required'] == true ? 'required' : '';
				$value = '';

				if ( isset($_POST["edit_widgets"]) ) {
					$input = get_option( $option_name );
					$value = sanitize_text_field($input[$_POST["edit_widgets"]][$name]);
				}

				$output .= '<div class="form-group"><input type="text" class="regular-text form-control" id="' . esc_attr($name) . '" name="' . esc_attr($option_name . '[' . $name . ']') . '" value="' . esc_attr($value) . '" placeholder="' . esc_attr($args['placeholder']) . '" '.esc_attr($required_true).'></div>';
				echo $output;
			break;
		}
	}

}
endif;