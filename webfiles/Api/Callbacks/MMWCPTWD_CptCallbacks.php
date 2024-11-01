<?php  
/**
 * @package  getwebPlugin
 */
namespace rsCustomPost\Api\Callbacks;
if(!class_exists('MMWCPTWD_CptCallbacks')):
	class MMWCPTWD_CptCallbacks
	{

		public function mmwcptwd_cpt_section_manager()
		{
			echo '';
		}

		public function mmwcptwd_cpt_sanitize( $input )
		{
			$output = get_option('mmwcptwd_cpt');

			if ( isset($_POST["remove"]) ) {
				unset($output[$_POST["remove"]]);

				return $output;
			}

			if ( count($output) == 0 ) {
				$output[$input['post_type']] = $input;

				return $output;
			}

			foreach ($output as $key => $value) {
				if ($input['post_type'] === $key) {
					$output[$key] = $input;
				} else {
					$output[$input['post_type']] = $input;
				}
			}
			
			return $output;
		}
		public function mmwcptwd_cpt_field( $args ) {
			switch ($args['type']) {

				case 'text':
					$output = '';
					$name = $args['label_for'];
					$option_name = $args['option_name'];
					$required_true = isset($args['required']) && $args['required'] == true ? 'required' : '';
					$value = '';

					if ( isset($_POST["edit_post"]) ) {
						$input = get_option( $option_name );
						$value = sanitize_text_field($input[$_POST["edit_post"]][$name]);
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

					if ( isset($_POST["edit_post"]) ) {
						$checkbox = get_option( $option_name );
						$checked = isset($checkbox[$_POST["edit_post"]][$name]) ?: false;
					}

					$output .= '<div class="form-group">
							<div class="onoffswitch">
					            <input type="' . esc_attr($args['type']) . '" id="' . esc_attr($name) . '" class="onoffswitch-checkbox" value="'.esc_attr($default).'" name="' . esc_attr($option_name . '[' . $name . ']') . '" style="display:none;" ' . esc_attr(( $checked ? 'checked' : '')) . '>
					            <label class="onoffswitch-label" for="' . esc_attr($name) . '" data-toggle="tooltip" title="Check this option to turn on the support"></label>
					        </div></div>';
					echo $output;
				break;

				case 'select_menu_position':
					$output = '';
					$name = $args['label_for'];
					$option_name = $args['option_name'];
					$value = '';

					if ( isset($_POST["edit_post"]) ) {
						$input = get_option( $option_name );
						$value = sanitize_text_field($input[$_POST["edit_post"]][$name]);
					}

					$output .= '<div class="form-group"><input type="text" class="russell-text form-control" id="' . esc_attr($name) . '" name="' . esc_attr($option_name . '[' . $name . ']') . '" value="' . esc_attr($value) . '" placeholder="' . esc_attr($args['placeholder']) . '" required>
					<span class="menu_position_nb">NB: 5 - Below Posts, 10 - Below Media, 15 - Below Links, 20 - Below Pages, 25 - Below comments, 60 - Below first separator, 65 - Below Plugins, 70 - Below Users, 75 - Below Tools, 80 - Below Settings, 100 - Below second separator</span>
					</div>';
					echo $output;
				break;

				default:
					$output = '';
					$name = $args['label_for'];
					$option_name = $args['option_name'];
					$required_true = isset($args['required']) && $args['required'] == true ? 'required' : '';
					$value = '';

					if ( isset($_POST["edit_post"]) ) {
						$input = get_option( $option_name );
						$value = sanitize_text_field($input[$_POST["edit_post"]][$name]);
					}

					$output .= '<div class="form-group"><input type="' . esc_attr($args['type']) . '" class="russell-text form-control" id="' . esc_attr($name) . '" name="' . esc_attr($option_name . '[' . $name . ']') . '" value="' . esc_attr($value) . '" placeholder="' . esc_attr($args['placeholder']) . '" '.esc_attr($required_true).'></div>';
					echo $output;
				break;
			}
		}
	}
endif;