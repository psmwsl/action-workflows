<?php
use Curl\Curl;

class PSMWSL_Functions {

	/**
	 * Set headers along with auth token
	 *
	 * @param Curl $curl - curl object.
	 * @return void
	 */
	public static function set_headers( $curl ) {

		$curl->setHeader( 'Authorization', 'Bearer ' . getenv( 'GH_TOKEN' ) );
		$curl->setHeader( 'Content-Type', 'application/json' );
	}

	/**
	 * Get project item_id linked to the given issue number
	 *
	 * @param integer $issue_number - issue number.
	 * @return string
	 */
	public static function get_project_item_id( $issue_number ) {

		$curl = new Curl();
		self::set_headers( $curl );
		$curl->post(
			'https://api.github.com/graphql',
			array(
				'query' => 'query { 
					repository(owner:"psmwsl" name:"supportcandy") {
					  issue(number: ' . $issue_number . '){
						projectItems(first: 1){
						  nodes{
							id
						  }
						}
					  }
					}
				  }',
			),
		);
		return $curl->response->data->repository->issue->projectItems->nodes[0]->id;
	}
}
