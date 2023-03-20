<?php
$curl->get( 'https://api.github.com/repos/psmwsl/supportcandy/issues' );
var_export( $curl->response );
