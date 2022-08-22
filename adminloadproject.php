<?php

$table = 'project';
$primaryKey = 'id';

// ดึงฟังก์ชัน
require('structure/datethai.php');

// รับค่า ID จาก admin.php
if(isset($_GET['id'])){
    $id = mysqli_real_escape_string($con, $_GET['id']);
} else {
    $id = '';
}
    
$sql = "SELECT * FROM `user` WHERE `idpj` = '$id' ";

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
			<button onclick="SettingPj(\'' . $d . '\')" class="btn btn-sm btn-primary"> <i class="fas fa-wrench"></i> ดำเนินการ </button>
			<button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#EditPj" data-whatever="'.$d.'"> <i class="far fa-edit"></i> แก้ไข </button>
            <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#DeletePj" data-whatever="'.$d.'"> <i class="fas fa-trash"></i> ลบ</button>';
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
	SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns, 'idpj=\'' . $id . '\''  )
);

?>


