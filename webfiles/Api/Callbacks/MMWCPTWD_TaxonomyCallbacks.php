<?php 
/**
 * @package  getwebPlugin
 */ 
namespace rsCustomPost\Api\Callbacks;
if(!class_exists('MMWCPTWD_TaxonomyCallbacks')):
class MMWCPTWD_TaxonomyCallbacks
{
	public function mmwcptwd_tax_section_manager() {
		echo 'Create as many Custom Taxonomies as you want.';
	}

	public function mmwcptwd_tax_sanitize( $input )
	{
		$output = get_option('mmwcptwd_tax');

		if ( isset($_POST["remove"]) ) {
			unset($output[$_POST["remove"]]);
			return $output;
		}

		if ( count($output) == 0 ) {
			$output[$input['taxonomy']] = $input;

			return $output;
		}

		foreach ($output as $key => $value) {
			if ($input['taxonomy'] === $key) {
				$output[$key] = $input;
			} else {
				$output[$input['taxonomy']] = $input;
			}
		}
		
		return $output;
	}

	public function mmwcptwd_taxonomy_field( $args ) {
		switch ($args['type']) {

			case 'text':
				$output = '';
				$name = $args['label_for'];
				$option_name = $args['option_name'];
				$required_true = isset($args['required']) && $args['required'] == true ? 'required' : '';
				$value = '';

				if ( isset($_POST["edit_taxonomy"]) ) {
					$input = get_option( $option_name );
					$value = sanitize_text_field($input[$_POST["edit_taxonomy"]][$name]);
				}

				$output .= '<div class="form-group"><input type="' . esc_attr($args['type']) . '" class="russell-text form-control" id="' . esc_attr($name) . '" name="' . esc_attr($option_name . '[' . $name . ']') . '" value="' . esc_attr($value) . '" placeholder="' . esc_attr($args['placeholder']) . '" '.esc_attr($required_true).'></div>';
			echo $output;
			break;

			case 'checkbox':
			$output = '';
				$name = $args['label_for'];
				$classes = $args['class'];
				$option_name = $args['option_name'];
				$default        = esc_html($args['default']);
				$checked = false;

				if ( isset($_POST["edit_taxonomy"]) ) {
					$checkbox = get_option( $option_name );
					$checked = isset($checkbox[$_POST["edit_taxonomy"]][$name]) ?: false;
				}

				$output .= '<div class="form-group">
						<div class="onoffswitch">
				            <input type="' . esc_attr($args['type']) . '" id="' . esc_attr($name) . '" class="onoffswitch-checkbox" value="'.esc_attr($default).'" name="' . esc_attr($option_name . '[' . $name . ']') . '" style="display:none;" ' . ( esc_attr($checked ? 'checked' : '')) . '>
				            <label class="onoffswitch-label" for="' . esc_attr($name) . '" data-toggle="tooltip" title="Check this option to turn on the support"></label>
				        </div></div>';
				echo $output;
			break;

			case 'post_checkbox':
				$output = '';
				$name = $args['label_for'];
				$classes = $args['class'];
				$option_name = $args['option_name'];
				$default        = esc_html($args['default']);
				$checked = false;

				if ( isset($_POST["edit_taxonomy"]) ) {
					$checkbox = get_option( $option_name );
				}

				$post_types = get_post_types( array( 'show_ui' => true ) );

				foreach ($post_types as $post) {

					if ( isset($_POST["edit_taxonomy"]) ) {
						$checked = isset($checkbox[$_POST["edit_taxonomy"]][$name][$post]) ?: false;
					}

					$output .= '<div class="' . trim( strtolower( str_replace(' ', '-', $classes) ) ) . ' mb-10"><input type="checkbox" id="' . esc_attr($post) . '" name="' . esc_attr( $option_name . '[' . $name . ']['. $post . ']') . '" value="'.esc_attr($default).'" class="" ' . esc_attr(( $checked ? 'checked' : '')) . '><label for="' . esc_attr($post) . '"><div></div></label> <strong>' . esc_attr(ucfirst($post)) . '</strong></div>';

				
				}
				echo $output;
				break;

			default:
				$output = '';
				$name = $args['label_for'];
				$option_name = $args['option_name'];
				$required_true = isset($args['required']) && $args['required'] == true ? 'required' : '';
				$value = '';

				if ( isset($_POST["edit_taxonomy"]) ) {
					$input = get_option( $option_name );
					$value = sanitize_text_field($input[$_POST["edit_taxonomy"]][$name]);
				}

				$output .= '<div class="form-group"><input type="text" class="russell-text form-control" id="' . esc_attr($name) . '" name="' . esc_attr($option_name . '[' . $name . ']') . '" value="' . esc_attr($value) . '" placeholder="'.esc_attr('Ex. genre').'" '.esc_attr($required_true).'></div>';
				echo $output;
			break;
		}
	}
}
endif;