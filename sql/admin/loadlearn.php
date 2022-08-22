<?php
require('../../connect.php');

$table = 'user';
$primaryKey = 'id';


// รับค่า ID จาก index.php
if(isset($_GET['id'])){
    $id = mysqli_real_escape_string($con, $_GET['id']);
} else {
    $id = '';
}
    
$columns = array(
    array( 'db' => 'id', 'dt' => 0 ),
	array( 'db' => 'name', 'dt' => 1 ),
    array( 'db' => 'idcer', 'dt' => 2 ),
    array(
        'db'        => 'id',
        'dt'        => 3,
        'formatter' => function( $d, $row ) {
            return '<button type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#EditLearn" data-whatever="'.$d.'"><i class="far fa-edit"></i></button>
            <button type="button" data-toggle="modal" data-target="#DeleteLearn" data-whatever="'.$d.'" class="btn btn-sm btn-danger"> <i class="fas fa-trash"></i></button>';
        })
);

$sql_details = array(     
    'user' => $user,
    'pass' => $passwd,
    'db'   => $db,
    'host' => $host
    );


require( '../../datatable/ssp.class.php' );

echo json_encode(
	SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns, 'idpj=\'' . $id . '\'' )
);
?>