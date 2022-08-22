<?php

$table = 'dp';
$primaryKey = 'id';

// Data - Datatable
$columns = array(
	array( 'db' => 'id', 'dt' => 0 ),
    array( 'db' => 'name',   'dt' => 1 ),
	array( 'db' => 'shortdp',  'dt' => 2 ),
    array(
        'db'        => 'id',
        'dt'        => 3,
        'formatter' => function( $d, $row ) {
            require('../../connect.php');
            $sql = "SELECT * FROM admin WHERE iddp = '$d' ";
            $res = mysqli_query($con, $sql);
            $num = mysqli_num_rows($res);
            return $num;
        }
    ),
    array(
        'db'        => 'id',
        'dt'        => 4,
        'formatter' => function( $d, $row ) {
            require('../../connect.php');
            $sql = "SELECT * FROM project WHERE iddp = '$d' ";
            $res = mysqli_query($con, $sql);
            $num = mysqli_num_rows($res);
            return $num;
        }
    ),
    array(
        'db'        => 'id',
        'dt'        => 5,
        'formatter' => function( $d, $row ) {
            require('../../connect.php');
            $sql_p = "SELECT * FROM project WHERE iddp = '$d' ";
            $res_p = mysqli_query($con, $sql_p);
            $num_p = mysqli_num_rows($res_p);

            $sql_a = "SELECT * FROM admin WHERE iddp = '$d' ";
            $res_a = mysqli_query($con, $sql_a);
            $num_a = mysqli_num_rows($res_a);

            if ($d == 1 || $num_p != 0 || $num_a != 0){
                return '
                <button type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#EditDP" data-whatever="'.$d.'" class="btn btn-warning"> <i class="far fa-edit"></i></button>
                <button data-toggle="modal" data-target="#DeleteDP" class="btn-sm btn btn-danger" disabled> <i class="fas fa-trash"></i></button>';
                }
    
                if ($d > 1){
                    return '	
                    <button type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#EditDP" data-whatever="'.$d.'" class="btn btn-warning"> <i class="far fa-edit"></i></button>
                    <button data-toggle="modal" data-target="#DeleteDP" data-whatever="'.$d.'" class="btn-sm btn btn-danger"> <i class="fas fa-trash"></i></button>';
                    }

        }
    )

);

// Databate Require
require('../../connect.php');
$sql_details = array(    
'user' => $user,
'pass' => $passwd,
'db'   => $db,
'host' => $host

);

// DataTable Require
require( '../../datatable/ssp.class.php' );

echo json_encode(
	SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns )
);

?>


