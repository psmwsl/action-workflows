<?php
/**
 * Change issue item to "In Review" whenever new pull request created or new commit added to pull request.
 * Environment variables available to use:
 * param1: head branch name
 * param2: pull_request number
 *
 * @package psmwsl
 */

use Curl\Curl;

$curl = new Curl();
PSMWSL_Functions::set_headers( $curl );

// retrive issue number from branch name.
if ( preg_match( '/^(\d+)-\S+$/i', getenv( 'param1' ), $matches ) ) {

	$item_id = PSMWSL_Functions::get_project_item_id( $matches[1] );
	$curl->post(
		'https://api.github.com/graphql',
		array(
			'query' => 'mutation {
				updateProjectV2ItemFieldValue(
					input: {
						projectId: "PVT_kwDOB6B2784ANa0H"
						itemId: "' . $item_id . '"
						fieldId: "PVTSSF_lADOB6B2784ANa0HzgIkEpo"
						value: { 
							singleSelectOptionId: "969b826a"
						}
					}
				) {
					projectV2Item {
						id
					}
				}
			}',
		)
	);

	// get the labels of the branch so that we can remove 'bug' if found.
	$curl->post(
		'https://api.github.com/graphql',
		array(
			'query' => 'query {
				repository(owner:"psmwsl" name:"supportcandy") {
				  pullRequest(number: ' . getenv( 'param2' ) . ') {
					id
					labels(first: 10) {
					  nodes {
						id
						name
					  }
					}
				  }
				}
			  }',
		)
	);

	// pull request node id.
	$pl_id = $curl->response->data->repository->pullRequest->id;

	// check whether 'bug' available.
	$lables = array_filter(
		array_map(
			fn( $label ) => $label->name == 'bug' ? array( 'id' => $label->id, 'name' => $label->name ) : false, // phpcs:ignore
			$curl->response->data->repository->pullRequest->labels->nodes
		)
	);

	// remove 'bug' label if available.
	if ( $lables ) {
		$curl->post(
			'https://api.github.com/graphql',
			array(
				'query' => 'mutation {
					removeLabelsFromLabelable(
					  input: {
						labelableId: "' . $pl_id . '",
						labelIds: [ "' . $lables[0]['id'] . '" ]
					  }
					) {
					  clientMutationId
					}
				  }',
			)
		);
	}
}
