<?php

$table = 'admin';
$primaryKey = 'id';

// Data - Datatable
$columns = array(
	array( 'db' => 'id', 'dt' => 0 ),
	array( 'db' => 'username',  'dt' => 1 ),
	array( 'db' => 'name',   'dt' => 2 ),
	array( 'db' => 'dp',   'dt' => 3 ),
    array( 'db' => 'shortdp',   'dt' => 4 ),
	array(
        'db'        => 'id',
        'dt'        => 5,
        'formatter' => function( $d, $row ) {
            return '	
            <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#EditAdmin" data-whatever="'.$d.'" class="btn btn-warning"> <i class="far fa-edit"></i> แก้ไข </button>
            <button data-bs-toggle="modal" data-bs-target="#DeleteAdmin" data-whatever="'.$d.'" class="btn-sm btn btn-danger"> <i class="fas fa-trash"></i> ลบ</button>';
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


