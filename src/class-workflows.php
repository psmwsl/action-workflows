<?php
require_once '../vendor/autoload.php';

use Curl\Curl;

class WorkFlows {

	/**
	 * Intialize the class
	 *
	 * @return void
	 */
	public static function init() {

		$curl = new Curl();
		self::set_headers( $curl );
		self::exec( $curl );
	}

	/**
	 * Set headers along with auth token
	 *
	 * @param Curl $curl - curl object.
	 * @return void
	 */
	public static function set_headers( $curl ) {

		$curl->setHeader( 'Authorization', 'Bearer ' . getenv( 'GH_TOKEN' ) );
		$curl->setHeader( 'X-GitHub-Api-Version', '2022-11-28' );
	}

	/**
	 * Execute the current action
	 *
	 * @param Curl $curl - curl object.
	 * @return void
	 */
	public static function exec( $curl ) {

		switch ( getenv( 'ACTION' ) ) {

			case 'manual':
				require_once 'includes/manual.php';
				break;
		}
	}
}

WorkFlows::init();
