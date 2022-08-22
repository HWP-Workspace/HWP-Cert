<?php
require('connect.php');

$table = 'user';
$primaryKey = 'id';


// รับค่า ID จาก index.php
if(isset($_GET['id'])){
    $id = mysqli_real_escape_string($con, $_GET['id']);
} else {
    $id = '';
}
    
    $sql = "SELECT * FROM `user` WHERE `idpj` = '$id' ";

$columns = array(
	array( 'db' => 'name', 'dt' => 0 ),
    array( 'db' => 'idcer', 'dt' => 1 ),
    array(
        'db'        => 'id',
        'dt'        => 2,
        'formatter' => function( $d, $row ) {
            return '<button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#EditUser" data-whatever="'.$d.'"><i class="far fa-edit"></i> แก้ไข </button>
            <button type="button" data-bs-toggle="modal" data-bs-target="#DeleteUser" data-whatever="'.$d.'" class="btn btn-sm btn-danger"> <i class="fas fa-trash"></i> ลบ</button>';
        })
);

$sql_details = array(     
    'user' => $user,
    'pass' => $passwd,
    'db'   => $db,
    'host' => $host
    
    );


require( 'datatable/ssp.class.php' );

echo json_encode(
	SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns, 'idpj=\'' . $id . '\'' )
);
?>