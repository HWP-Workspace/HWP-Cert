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

require('structure/numthai.php');

$columns = array(
    array( 'db' => 'id', 'dt' => 0 ),
	array( 'db' => 'name', 'dt' => 1 ),
    array( 'db' => 'idcer', 'dt' => 2 ),
    array(
        'db'        => 'id',
        'dt'        => 3,
        'formatter' => function( $d, $row) {
            return  '<button onclick="PrintCer(\'' . $d . '\')" class="btn btn-sm btn-success"><i class="pe-1 far fa-arrow-alt-circle-down"></i> ดาวน์โหลด </button>';
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