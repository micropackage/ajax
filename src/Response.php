<?php
/**
 * Response class
 *
 * @package micropackage/ajax
 */

namespace Micropackage\Ajax;

/**
 * Response class
 */
class Response {

	/**
	 * Response errors
	 *
	 * @var array
	 */
	protected $errors = [];

	/**
	 * Verifies nonce string
	 *
	 * @param  string $action    Action name, as defined while creating nonce hash.
	 *                           Default: -1.
	 * @param  string $query_arg $_REQUEST array key where to search for nonce.
	 *                           Default 'nonce'.
	 * @param  string $send      If the response should be send in case of errors.
	 *                           Default true.
	 * @return void
	 */
	public function verify_nonce( $action = '-1', $query_arg = 'nonce', $send = true ) {
		if ( check_ajax_referer( $action, $query_arg, false ) === false ) {
			$this->add_error( 'Wrong nonce' );
			if ( $send ) {
				$this->send();
			}
		}
	}

	/**
	 * Adds error to the response
	 *
	 * @since  1.0.0
	 * @param  string $message Error message, optional.
	 * @return $this
	 */
	public function add_error( $message = '' ) {
		$this->errors[] = $message;
		return $this;
	}

	/**
	 * Gets all errors
	 *
	 * @since  1.0.0
	 * @return array
	 */
	public function get_errors() {
		return $this->errors;
	}

	/**
	 * Sends the error
	 *
	 * @since  1.0.0
	 * @param  string $message Error message, optional.
	 * @return void
	 */
	public function error( $message = '' ) {
		$this->add_error( $message )->send();
	}

	/**
	 * Sends the response
	 *
	 * @since  1.0.0
	 * @param  mixed $success_message Success message.
	 *                                Default: null.
	 * @return void
	 */
	public function send( $success_message = null ) {

		$errors = $this->get_errors();

		if ( ! empty( $errors ) ) {
			wp_send_json_error( $errors );
		}

		wp_send_json_success( $success_message );

	}

}
