<?php
require('../../connect.php');

$table = 'project';
$primaryKey = 'id';

// ดึงฟังก์ชัน
require('../../structure/datethai.php');

// รับค่า DP จาก admin.php
if(isset($_GET['dp'])){
    $dp = mysqli_real_escape_string($con, $_GET['dp']);
} else {
    $dp = '';
}

// Data - Datatable
$columns = array(
	array( 'db' => 'id', 'dt' => 0 ),
	array( 'db' => 'name',  'dt' => 1 ),
	array( 'db' => 'dp',   'dt' => 2),
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
            return '
			<button onclick="SettingPj(\'' . $d . '\')" class="btn btn-sm btn-primary"> <i class="fas fa-wrench"></i></button>
			<button type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#EditPj" data-whatever="'.$d.'"> <i class="far fa-edit"></i></button>
            <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#DeletePj" data-whatever="'.$d.'"> <i class="fas fa-trash"></i></button>';
        }
    )
);

// Databate Require
$sql_details = array(    
'user' => $user,
'pass' => $passwd,
'db'   => $db,
'host' => $host

);

// DataTable Require
require( '../../datatable/ssp.class.php' );


echo json_encode(
	SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns, null, ["`dp` = '$dp'"])
);

?>


