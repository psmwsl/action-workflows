<?php
$curl->post(
	'https://api.github.com/graphql',
	array(
		'query' => 'mutation {
			updateProjectV2ItemFieldValue(
				input: {
					projectId: "PVT_kwDOB6B2784ANa0H"
					itemId: "I_kwDOJJ6Te85hDxZN"
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
		}',
	)
);
