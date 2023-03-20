<?php
$curl->post(
	'https://api.github.com/graphql',
	array(
		'query' => 'mutation { updateProjectV2ItemFieldValue( input: { projectId: "PVT_kwDOB6B2784ANa0H" itemId: "PVTI_lADOB6B2784ANa0HzgFhigM" fieldId: "PVTSSF_lADOB6B2784ANa0HzgIkEpo" value: { singleSelectOptionId: "fae3adc8" } } ) { projectV2Item { id } } }',
	)
);

var_export( $curl->getHttpStatusCode() );
echo PHP_EOL . '--------' . PHP_EOL;
if ( $curl->error ) {
	var_export( $curl );
} else {
	var_export( $curl->response );
}
