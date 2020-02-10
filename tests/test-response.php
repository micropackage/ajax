<?php
/**
 * Class TestResponse
 *
 * @package micropackage/ajax
 */

namespace Micropackage\Ajax\Test;

use Micropackage\Ajax\Response;
use phpmock\Mock;

/**
 * Response test case.
 */
class TestResponse extends \WP_UnitTestCase {

	use \phpmock\phpunit\PHPMock;

	public function setUp() {
		parent::setUp();
		$this->response = new Response();
	}

	public function tearDown() {
		parent::tearDown();
		Mock::disableAll();
	}

	public function test_add_error_should_add_1_error_and_return_self() {

		$errors = [
			'Err message',
		];

		$returned = $this->response->add_error( 'Err message' );

		$this->assertSame( $errors, $this->response->get_errors() );
		$this->assertSame( $this->response, $returned );

	}

	public function test_add_error_should_add_2_errors() {

		$errors = [
			'Err message 1',
			uniqid(),
		];

		foreach ( $errors as $error ) {
			$this->response->add_error( $error );
		}

		$this->assertSame( $errors, $this->response->get_errors() );

	}

	/**
	 * @doesNotPerformAssertions
	 */
	public function test_send_should_send_success_if_no_errors() {

		$wp_send_json_success = $this->getFunctionMock( 'Micropackage\Ajax', 'wp_send_json_success' );
		$wp_send_json_success->expects( $this->once() )->willReturn( true );

		$this->response->send();

	}

	/**
	 * @expectedException \Exception
	 */
	public function test_send_should_send_error_if_one_error_added() {

		$wp_send_json_error = $this->getFunctionMock( 'Micropackage\Ajax', 'wp_send_json_error' );
		$wp_send_json_error->expects( $this->once() )->will( $this->throwException( new \Exception() ) );

		$this->response->add_error( 'Err message' )->send();

	}

	/**
	 * @expectedException \Exception
	 */
	public function test_should_bail_if_nonce_not_verified() {

		$check_ajax_referer = $this->getFunctionMock( 'Micropackage\Ajax', 'check_ajax_referer' );
		$check_ajax_referer->expects( $this->once() )->willReturn( false );

		$wp_send_json_error = $this->getFunctionMock( 'Micropackage\Ajax', 'wp_send_json_error' );
		$wp_send_json_error->expects( $this->once() )->will( $this->throwException( new \Exception() ) );

		$this->response->verify_nonce();

	}

	/**
	 * @doesNotPerformAssertions
	 */
	public function test_should_verify_nonce() {

		$check_ajax_referer = $this->getFunctionMock( 'Micropackage\Ajax', 'check_ajax_referer' );
		$check_ajax_referer->expects( $this->once() )->willReturn( true );

		$wp_send_json_error = $this->getFunctionMock( 'Micropackage\Ajax', 'wp_send_json_error' );
		$wp_send_json_error->expects( $this->never() )->will( $this->throwException( new \Exception() ) );

		$this->response->verify_nonce();

	}

	/**
	 * @expectedException \Exception
	 */
	public function test_should_send_an_error_immediately() {

		$wp_send_json_error = $this->getFunctionMock( 'Micropackage\Ajax', 'wp_send_json_error' );
		$wp_send_json_error->expects( $this->once() )->will( $this->throwException( new \Exception() ) );

		$this->response->error( 'Error' );

	}

}
