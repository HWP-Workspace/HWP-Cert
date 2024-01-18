<?php
require('../../connect.php');

$table = 'project';
$primaryKey = 'id';

// ดึงฟังก์ชัน
require('../../structure/datethai.php');

// รับค่า DP จาก admin.php
if(isset($_GET['iddp'])){
    $iddp = mysqli_real_escape_string($con, $_GET['iddp']);
} else {
    $iddp = '';
}

// Data - Datatable
$columns = array(
	array( 'db' => 'id', 'dt' => 0 ),
	array(
		'db'        => 'tempate', 
		'dt'        => 1,
		'formatter' => function( $d, $row ) {
            if($d != ''){
				return '<i class="fas fa-check-circle fa-2x text-success align-middle mr-2"></i> เผยแพร่';
			}else{
				return '<i class="fas fa-2x fa-exclamation-circle align-middle text-warning mr-2"></i> แม่แบบ';
			}
		}
	),
	array( 'db' => 'name',  'dt' => 2),
	array(
        'db'        => 'iddp',
        'dt'        => 3,
        'formatter' => function( $d, $row ) {
            require('../../connect.php');
            $sql = "SELECT * FROM dp WHERE id = '$d' ";
            $res = mysqli_query($con, $sql);
            while ($row = mysqli_fetch_assoc($res)) {
                $name = $row['name'];
                break;
            }
            return $name;
        }
    ),
	array(
		'db'        => 'date', 
		'dt'        => 4,
		'formatter' => function( $d, $row ) {
            return DateThai(date( 'j M Y', strtotime($d))); 
		}
	),
	array(
        'db'        => 'id',
        'dt'        => 5,
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

if($iddp == 1){
    echo json_encode(
        SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns, null)
    );
}else{
    echo json_encode(
        SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns, null, ["`iddp` = '$iddp'"])
    );
}


?>


