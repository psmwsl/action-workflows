<?php
/**
 * Change issue item to "Bugs" whenever someone lables the pull request as "bug"
 * Environment variables available to use:
 * param1: head branch name
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
							singleSelectOptionId: "a0987b60"
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
}
