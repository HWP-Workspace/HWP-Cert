<?php

$table = 'school';
$primaryKey = 'id';

// Data - Datatable
$columns = array(
	array( 'db' => 'id', 'dt' => 0 ),
	array( 'db' => 'name',  'dt' => 1 ),
	array( 'db' => 'shortname',   'dt' => 2 ),
	array(
        'db'        => 'id',
        'dt'        => 3,
        'formatter' => function( $d, $row ) {
            return '
            <button data-bs-toggle="modal" data-bs-target="#EditSchool" data-whatever="'.$d.'" class="btn btn-sm btn-warning"> <i class="far fa-edit"></i> แก้ไข </button>';
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


