<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://reloadedpd.com
 * @since      1.0.0
 *
 * @package    Give_Square_Gateway
 * @subpackage Give_Square_Gateway/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Give_Square_Gateway
 * @subpackage Give_Square_Gateway/public
 * @author     Joe McFrederick <jomcfred@gmail.com>
 */
class Give_Square_Gateway_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	private $form_id;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	* Give Hook for added content below the credit card form
	* @param int form_id
	* @return string
	*/
	public function give_square_before_cc_fields( $form_id )
	{ 
		echo $this->square_inline_javascript($form_id);
	}

	/**
	 * Give Checkout Button Purchase
	 *
	 * Renders the Purchase button on the Checkout
	 * @since  1.0
	 *
	 * @param  int $form_id
	 *
	 * @return string
	 */
	function give_square_checkout_button_purchase( $form_id ) {

		$display_label_field = get_post_meta( $form_id, '_give_checkout_label', true );
		$display_label       = ( ! empty( $display_label_field ) ? $display_label_field : esc_html__( 'Donate Now', 'give' ) );
		ob_start(); ?>
		<div class="give-submit-button-wrap give-clearfix">
			<input type="submit" class="give-submit give-btn" id="give-purchase-button" name="give-purchase" value="<?php echo $display_label; ?>"  onclick="requestCardNonce(event)"/>
			<span class="give-loading-animation"></span>
		</div>
		<?php
	}

	/**
	* Process Square Purchase
	* @param array $purchase_data Purchase Data
	* @return void
	*/
	public function give_process_square_purchase( $purchase_data ) {
		$form_id  = intval( $purchase_data['post_data']['give-form-id'] );
		$price_id = isset( $purchase_data['post_data']['give-price-id'] ) ? $purchase_data['post_data']['give-price-id'] : '';

		// Collect payment data.
		$payment_data = array(
			'price'           => $purchase_data['price'],
			'give_form_title' => $purchase_data['post_data']['give-form-title'],
			'give_form_id'    => $form_id,
			'give_price_id'   => $price_id,
			'date'            => $purchase_data['date'],
			'user_email'      => $purchase_data['user_email'],
			'purchase_key'    => $purchase_data['purchase_key'],
			'currency'        => give_get_currency(),
			'user_info'       => $purchase_data['user_info'],
			'status'          => 'pending',
			'gateway'         => 'paypal'
		);

		var_dump($payment_data, $purchase_data);exit();
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Give_Square_Gateway_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Give_Square_Gateway_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/give-square-gateway-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Give_Square_Gateway_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Give_Square_Gateway_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/give-square-gateway-public.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( 'square-connect', "https://js.squareup.com/v2/paymentform", array(), $this->version, false );

	}

	protected function square_inline_javascript($form_id) {
		$square_application_id = give_get_option('square_application_id');

		return "
		<input type=\"hidden\" name=\"card-nonce\" id=\"card-nonce-$form_id\" value=\"\"/>
		<script type=\"text/javascript\">
			console.log('square_inline_javascript');
			var applicationId = '$square_application_id';

			  if (applicationId == '') {
			    alert('You need to provide a value for the applicationId variable.');
			  }

			  var paymentForm = new SqPaymentForm({
			    applicationId: applicationId,
			    inputClass: 'sq-input',
			    inputStyles: [
			      {
			        fontSize: '15px'
			      }
			    ],
			    cardNumber: {
			      elementId: 'card_number-$form_id',
			      placeholder: '•••• •••• •••• ••••'
			    },
			    cvv: {
			      elementId: 'card_cvc-$form_id',
			      placeholder: 'CVV'
			    },
			    expirationDate: {
			      elementId: 'card_expiry-$form_id',
			      placeholder: 'MM/YY'
			    },
			    postalCode: {
			      elementId: 'card_zip'
			    },
			    callbacks: {

			      cardNonceResponseReceived: function(errors, nonce, cardData) {
			        if (errors) {
			          console.log(\"Encountered errors:\");

			          errors.forEach(function(error) {
			            console.log('  ' + error.message);
			          });

			        // No errors occurred. Extract the card nonce.
			        } else {
					  alert('Nonce Received: ' + nonce);
			          document.getElementById('card-nonce-$form_id').value = nonce;
			          document.getElementById('give-form-$form_id').submit();

			        }
			      },

			      unsupportedBrowserDetected: function() {
			        // Fill in this callback to alert buyers when their browser is not supported.
			      },

			      // Fill in these cases to respond to various events that can occur while a
			      // buyer is using the payment form.
			      inputEventReceived: function(inputEvent) {
			        switch (inputEvent.eventType) {
			          case 'focusClassAdded':
			            // Handle as desired
			            break;
			          case 'focusClassRemoved':
			            // Handle as desired
			            break;
			          case 'errorClassAdded':
			            // Handle as desired
			            break;
			          case 'errorClassRemoved':
			            // Handle as desired
			            break;
			          case 'cardBrandChanged':
			            // Handle as desired
			            break;
			          case 'postalCodeChanged':
			            // Handle as desired
			            break;
			        }
			      },

			      paymentFormLoaded: function() {
			        // Fill in this callback to perform actions after the payment form is
			        // done loading (such as setting the postal code field programmatically).
			        // paymentForm.setPostalCode('94103');
			      }
			    }
			  });

			  function requestCardNonce(event) {
			    event.preventDefault();
			    paymentForm.requestCardNonce();
			  }
		</script>";
	}

}
