<?php
/**
* Plugin Name: Worthington-Functionality
* Plugin URI: https://bitbucket.org/advisantgroup/worthington-utilities
* Description: Plugin is the used to create the additional custom fields of weight, height, width and depth for the  product post type. Also, It shows all these information in the additional information tab as well.
* Version: 0.0.5
* Author URI: http://advisantgroup.com/
* Developer: Jimrising 
* Text Domain: woocommerce-extension
* License: GNU General Public License v3.0
* License URI: http://www.gnu.org/licenses/gpl-3.0.html
*/

defined( 'ABSPATH' ) or die();
require 'plugin_update_check.php';
$MyUpdateChecker = new PluginUpdateChecker_2_0 (
	'https://kernl.us/api/v1/updates/58a7226fea23b76a3633bfc7/',
	__FILE__,
	'worthington-functionality',
	1
);

if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {

	if ( ! class_exists( 'WC_Worthington' ) ) {

		class WC_Worthington
		{
			
			public function __construct()
			{
				//To filter out the addition information
				add_filter( 'wc_product_enable_dimensions_display', array(&$this, 'wc_custom_fields_data' ) );

				//Display the custom fields in the shopping data
				add_action( 'woocommerce_product_options_general_product_data', array(&$this,'wc_custom_add_custom_fields' ) );
				//Save the Additional information data
				add_action( 'woocommerce_process_product_meta', array(&$this, 'wc_custom_save_custom_fields' ) );
			}

			/**
			 * [wc_custom_add_custom_fields - Function prints the custom fields for the Weight, Height, Width & Depth]
			 */
			public function wc_custom_add_custom_fields() {
			    // Print a custom text field Weight
			    woocommerce_wp_text_input( array(
			        'id' => '_weight_',
			        'label' => 'Product Weight (lbs)',
			        'description' => 'Actual weight of product',
			        'desc_tip' => 'true',
			        'placeholder' => 'Weight'
			    ) );

			    // Print a custom text field Height
			    woocommerce_wp_text_input( array(
			        'id' => '_height_',
			        'label' => 'Product Height (in)',
			        'description' => 'Actual height of product',
			        'desc_tip' => 'true',
			        'placeholder' => 'Height'
			    ) );

			    // Print a custom text field Width
			    woocommerce_wp_text_input( array(
			        'id' => '_width_',
			        'label' => 'Product Width (in)',
			        'description' => 'Actual width of product',
			        'desc_tip' => 'true',
			        'placeholder' => 'Width'
			    ) );

			    // Print a custom text field Depth
			    woocommerce_wp_text_input( array(
			        'id' => '_depth_',
			        'label' => 'Product Depth (in)',
			        'description' => 'Actual depth of product',
			        'desc_tip' => 'true',
			        'placeholder' => 'Depth'
			    ) );
			}

			/**
			 * [wc_custom_save_custom_fields - Function updates the values for fields like Weight, Height, Width & Depth]
			 * @param  [int] $post_id [product post ID]
			 */
			public function wc_custom_save_custom_fields( $post_id ) {
//			    if ( ! empty( $_POST['_weight_'] ) ) {
			        update_post_meta( $post_id, '_weight_', esc_attr( $_POST['_weight_'] ) );
//			    }

//			    if ( ! empty( $_POST['_height_'] ) ) {
			        update_post_meta( $post_id, '_height_', esc_attr( $_POST['_height_'] ) );
//			    }

//			    if ( ! empty( $_POST['_width_'] ) ) {
			        update_post_meta( $post_id, '_width_', esc_attr( $_POST['_width_'] ) );
//			    }

//			    if ( ! empty( $_POST['_depth_'] ) ) {
			        update_post_meta( $post_id, '_depth_', esc_attr( $_POST['_depth_'] ) );
//			    }
			}	

			/**
			 * [wc_custom_fields_data - Function prints the collected information in the addition information tab of single product page]
			 * @return [string]         [prints the Custom field's value if it is present]
			 */
			public function wc_custom_fields_data(){

				$output = '';
			         
			    if ( get_post_meta( get_the_ID(), '_weight_', true ) ) : 

				    $output.= "<tr class>
						<th>Weight</th>
							<td><p>".get_post_meta( get_the_ID(), '_weight_', true )."lb.</p></td>
					</tr>";

				endif; 
			    if ( get_post_meta( get_the_ID(), '_height_', true ) ) :

				    $output.= "<tr class>
						<th>Height</th>
						<td><p>".get_post_meta( get_the_ID(), '_height_', true ).'"'."</p></td>
					</tr>";

				endif;

			    if ( get_post_meta( get_the_ID(), '_width_', true ) ) : 

			        $output.= "<tr>
						<th>Width</th>
						<td><p>".get_post_meta( get_the_ID(), '_width_', true ).'"'."</p></td>
					</tr>";
					
			    endif;

				if ( get_post_meta( get_the_ID(), '_depth_', true ) ) :

					$output.= "<tr>
						<th>Depth</th>
						<td><p>".get_post_meta( get_the_ID(), '_depth_', true ).'"'."</p></td>
					</tr>";

				endif;

				echo $output;
			}
		}

		// finally instantiate our plugin class and add it to the set of globals
		$GLOBALS['wc_worthington'] = new WC_Worthington();
	}
}


