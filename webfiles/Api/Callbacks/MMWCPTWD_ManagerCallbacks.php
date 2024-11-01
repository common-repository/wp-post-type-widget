<?php 
/**
 * @package  getwebPlugin
 */
namespace rsCustomPost\Api\Callbacks;

use rsCustomPost\Base\MMWCPTWD_BaseController;
if(!class_exists('MMWCPTWD_ManagerCallbacks')):
	class MMWCPTWD_ManagerCallbacks extends MMWCPTWD_BaseController
	{
		public function mmwcptwd_checkbox_sanitize( $input )
		{
			$output = array();

			foreach ( $this->managers as $key => $value ) {
				$output[$key] = isset( $input[$key] ) ? true : false;
			}

			return $output;
		}

		public function mmwcptwd_admin_section_manager()
		{
			echo 'Manage the Sections and Features of this Plugin by activating the checkboxes from the following list.';
		}

		public function mmwcptwd_checkbox_field( $args )
		{
			$name = $args['label_for'];
			$classes = $args['class'];
			$option_name = $args['option_name'];
			$default        = esc_html($args['default']);
			$checkbox = get_option( $option_name );
			$checked = isset($checkbox[$name]) ? ($checkbox[$name] ? true : false) : false;
			
			echo '<div class="form-group">
			<div class="onoffswitch">
	            <input type="' . esc_attr($args['input_type']) . '" id="' . esc_attr($name) . '" class="onoffswitch-checkbox russell-text" value="'.esc_attr($default).'" name="' . esc_attr($option_name . '[' . $name . ']') . '" style="display:none;" ' . esc_attr(( $checked ? 'checked' : '')) . '>
	            <label class="onoffswitch-label" for="' . esc_attr($name) . '" data-toggle="tooltip" title="Check this option to turn on the support"></label>
	        </div></div>';
		}
	}
endif;