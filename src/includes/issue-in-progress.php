<?php
/**
 * Change issue item to "In Progress" whenever new branch is created for the issue
 * Environment variables available to use:
 * param1: issue number
 *
 * @package psmwsl
 */

use Curl\Curl;

$curl = new Curl();
PSMWSL_Functions::set_headers( $curl );
$item_id = PSMWSL_Functions::get_project_item_id( getenv( 'param1' ) );
echo 'Item id received';
$curl->post(
	'https://api.github.com/graphql',
	array(
		'query' => 'mutation ( $item_id: ID! ) {
			updateProjectV2ItemFieldValue(
				input: {
					projectId: "PVT_kwDOB6B2784ANa0H"
					itemId: $item_id
					fieldId: "PVTSSF_lADOB6B2784ANa0HzgIkEpo"
					value: { 
						singleSelectOptionId: "fae3adc8"
					}
				}
			) {
				projectV2Item {
					id
				}
			}
		} variables { "item_id": ' . $item_id . ' }',
	)
);
