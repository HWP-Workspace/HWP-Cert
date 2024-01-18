<?php

$table = 'admin';
$primaryKey = 'id';

// Data - Datatable
$columns = array(
	array( 'db' => 'id', 'dt' => 0 ),
    array( 'db' => 'name',   'dt' => 1 ),
    array( 'db' => 'username',   'dt' => 2 ),
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
        'db'        => 'iddp',
        'dt'        => 4,
        'formatter' => function( $d, $row ) {
            require('../../connect.php');
            $sql = "SELECT * FROM dp WHERE id = '$d' ";
            $res = mysqli_query($con, $sql);
            while ($row = mysqli_fetch_assoc($res)) {
                $shortdp = $row['shortdp'];
                break;
            }
            return $shortdp;
        }
    ),
    array(
        'db'        => 'id',
        'dt'        => 5,
        'formatter' => function( $d, $row ) {
            if ($d == 1){
                return '
                <button type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#EditUser" data-whatever="'.$d.'" class="btn btn-warning"> <i class="far fa-edit"></i></button>
                <button data-toggle="modal" data-target="#DeleteUser" class="btn-sm btn btn-danger" disabled> <i class="fas fa-trash"></i></button>';
                }
    
                if ($d > 1){
                    return '	
                    <button type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#EditUser" data-whatever="'.$d.'" class="btn btn-warning"> <i class="far fa-edit"></i></button>
                    <button data-toggle="modal" data-target="#DeleteUser" data-whatever="'.$d.'" class="btn-sm btn btn-danger"> <i class="fas fa-trash"></i></button>';
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


