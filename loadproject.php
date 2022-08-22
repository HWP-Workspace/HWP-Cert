<?php

$table = 'project';
$primaryKey = 'id';

require('structure/datethai.php');


// Data - Datatable
$columns = array(
	array( 'db' => 'id', 'dt' => 0 ),
	array( 'db' => 'name',  'dt' => 1 ),
	array( 'db' => 'dp',   'dt' => 2 ),
	array(
		'db'        => 'date', 
		'dt'        => 3,
		'formatter' => function( $d, $row ) {
            return DateThai(date( 'j M Y', strtotime($d))); 
		}
	),
	array(
        'db'        => 'id',
        'dt'        => 4,
        'formatter' => function( $d, $row ) {
            return '<button onclick="UserRow(\'' . $d . '\')" class="btn btn-sm btn-primary "><i class="pe-1 fas fa-user"></i> รายชื่อ</button>';
        }
    )
);

// Databate Require
require('connect.php');
$sql_details = array(    
'user' => $user,
'pass' => $passwd,
'db'   => $db,
'host' => $host

);

// DataTable Require
require( 'datatable/ssp.class.php' );

echo json_encode(
	SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns )
);

?>


