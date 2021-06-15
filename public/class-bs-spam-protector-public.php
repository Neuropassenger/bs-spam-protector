<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://neuropassenger.ru
 * @since      1.0.0
 *
 * @package    Bs_Spam_Protector
 * @subpackage Bs_Spam_Protector/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Bs_Spam_Protector
 * @subpackage Bs_Spam_Protector/public
 * @author     Oleg Sokolov <turgenoid@gmail.com>
 */
class Bs_Spam_Protector_Public {

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
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Bs_Spam_Protector_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Bs_Spam_Protector_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/bs-spam-protector-public.css', array(), $this->version, 'all' );

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
		 * defined in Bs_Spam_Protector_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Bs_Spam_Protector_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/bs-spam-protector-public.js', array( 'jquery' ), $this->version, false );
		wp_localize_script( $this->plugin_name, 'bs_vars', array(
			'nonce'       =>  wp_create_nonce( 'cf7_bs_spam_protector' ),
			'expiration'  =>  time() + 60 * 120,
			'ajaxUrl'     =>  admin_url( 'admin-ajax.php' ),
		) );

	}

	public function ajax_get_validation_key() {
		$nonce = sanitize_key( $_POST['nonce'] );
		$expiration = intval( $_POST['expiration'] );
		$secret_key = get_option( 'bs_spam_protector_secret_key' );

		// Nonce check
		if ( ! wp_verify_nonce( $nonce, 'cf7_bs_spam_protector' ) ) {
			$response = array(
				'message' => 'Security Error',
				'status'  => 'error',
			);

			// Expiration check
		} elseif ( time() > $expiration ) {
			$response = array(
				'message' => 'Expiration Error',
				'status'  => 'error',
			);

			// Create validation key
		} else {
			$validation_key = hash_hmac( 'md5', $nonce . $expiration, $secret_key );
			$response = array(
				'validationKey'   => $validation_key,
				'status'    => 'ok',
			);
		}

        wp_send_json( $response );
	}

	public function is_spam_submission( $spam ) {
		if ( $spam ) {
			return $spam;
		}

		$submission = WPCF7_Submission::get_instance();

		if ( empty( $_POST['bs_hf_nonce'] ) || empty( $_POST['bs_hf_expiration'] ) || empty( $_POST['bs_hf_validation_key'] ) ) {
			$submission->add_spam_log( array(
				'agent' => 'bs_spam_protector',
				'reason' => "Validation fields are empty",
			) );

			return $spam = true;
		}

		$nonce = sanitize_key( $_POST['bs_hf_nonce'] );
		$expiration = intval( $_POST['bs_hf_expiration'] );
		$secret_key = get_option( 'bs_spam_protector_secret_key' );
		$validation_key = sanitize_key( $_POST['bs_hf_validation_key'] );
		$actual_validation_key = hash_hmac( 'md5', $nonce . $expiration, $secret_key );

		if ( time() > $expiration ) {
			$submission->add_spam_log( array(
				'agent' => 'bs_spam_protector',
				'reason' => "Validation key is expired",
			) );

			return $spam = true;
		} elseif ( $validation_key !== $actual_validation_key ) {
			$submission->add_spam_log( array(
				'agent' => 'bs_spam_protector',
				'reason' => "Invalid validation key",
			) );

			return $spam = true;
		} else {
			return $spam = false;
		}
	}

}
