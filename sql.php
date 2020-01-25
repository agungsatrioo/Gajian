<?php
date_default_timezone_set( 'Asia/Jakarta' );
mysql_connect('localhost','root','');
mysql_select_db( 'gajian');

//Konfigurasi basis data untuk daftar karyawan

$act = isset( $_POST['act'] ) ? $_POST['act'] : '';
$page = isset( $_GET['page'] ) ? $_GET['page'] : '';

define( 'WEB', 'Gajian' );
define( 'URL', 'http://localhost/gajian' );

function Rupiah( $id ) {
	return number_format( $id, 0, ", ", "." );
}

function sqlQuery($command) {
	$sqlResult = mysql_query($command);
	return $sqlResult;
}

?>