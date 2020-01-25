<?php
include "sql.php";

$in_nip = !empty( $_POST['in_nip'] ) ? $_POST['in_nip'] : '';
$in_nama = !empty( $_POST['in_nama'] ) ? $_POST['in_nama'] : '';
$in_tgl_lahir = !empty( $_POST['in_tgl_lahir'] ) ? $_POST['in_tgl_lahir'] : '';
$in_jenkel = !empty( $_POST['in_jenkel'] ) ? $_POST['in_jenkel'] : '';
$in_alamat = !empty( $_POST['in_alamat'] ) ? $_POST['in_alamat'] : '';
$in_golongan = !empty( $_POST['in_golongan'] ) ? $_POST['in_golongan'] : '';

$action = !empty( $_GET['action'] ) ? $_GET['action'] : '';
$target_id = !empty( $_GET['for_id'] ) ? $_GET['for_id'] : '';

if(!empty($in_nip)) {
	addData($in_nip,$in_nama,$in_tgl_lahir,$in_jenkel,$in_alamat,$in_golongan);
}

switch($action) {
	case 'delete':
		delData($target_id);
	break;
}

function addData($id, $nama, $lahir, $jenkel, $alamat, $golongan) {
	$sql = mysql_query("INSERT INTO karyawan (nip, nama, tgl_lahir, jenkel, alamat, golongan) VALUES ('$id', '$nama', '$lahir', '$jenkel', '$alamat', '$golongan')");
	header('Location: index.php?page=data_karyawan');
	if(!$sql) $_SESSION['log'] = "Data tidak dapat dimasukkan. Mungkin ada kesalahan penulisan, data yang akan dimasukkan sudah ada sebelumnya, atau kesalahan basis data. ";
}

function delData($id) {
	$sql = mysql_query("DELETE FROM karyawan WHERE nip = $id");
	header('Location: index.php?page=data_karyawan');
	if(!$sql) $_SESSION['log'] = "Data tidak dapat dihapus. Mungkin data yang akan dimasukkan sudah hilang sebelumnya, atau kesalahan basis data. ";
}

function makeMessage($type,$message) {
	?>
	<div class="msg">
		<div class='mi <?php echo $type ?>'></div>
		<font><?php echo $message; ?></font>
	</div>
	<?php
}

function Record($section) {
	if($section=="karyawan") return array("nip"=>"NIP","nama"=>"Nama","tgl_lahir"=>"Tanggal<br>Lahir","jenkel"=>"Jenis<br>Kelamin","alamat"=>"Alamat","golongan"=>"Gol");
	if($section=="gaji") return array("golongan"=>"Golongan","upah_jam"=>"Upah per Jam","tunjangan_hari"=>"Tunjangan per Hari");
}

function GetWidth($section) {
	if($section=="karyawan") return array(0,60,177,329,438,572,695);
}

function makeAction($target_id="",$transfer=false,$edit=false,$delete=false) {
	?><td><?php
	if($transfer==true) echo "<a href='?page=transfer&for_id=$target_id'><div class='mi payment two'></div></a>";
	if($edit==true) echo "<a href='?page=edit&for_id=$target_id'><div class='mi edit'></div></a>";
	if($delete==true) echo "<a href='?action=delete&for_id=$target_id'><div class='mi delete'></div></a>";
	?></td><?php
}

function idle() {
	?>
		<h1>Selamat datang di panel Gajian.</h1>
		<p>Sepertinya, Anda belum melakukan kegiatan apapun di sini. Jika ingin, Anda dapat menekan salahsatu dari kedua menu di atas.</p>
	<?php
}

function logout() {
	header('Location: index.php?page=home');
}

function listKaryawan() {
	?>
		<h1>Data Karyawan</h1><hr>
	<?php
	makeTable("karyawan", Record("karyawan"),false,true);

	?>
		<tr>
		<td colspan="7">Gunakan formulir di bawah untuk menambah karyawan baru.</td>
		</tr>
		<tr>
		<form action ="" method="post">
			<td><input type="number" name="in_nip" style="width:90%" placeholder="NIP Baru" required></td>
			<td><input type="text" name="in_nama"  style="width:90%" placeholder="Nama" required></td>
			<td><input type="date" name="in_tgl_lahir" style="width:90%" placeholder="Tanggal Lahir" required></td>
			<td>
				<select name="in_jenkel" >
					<option>Laki-laki</option>
					<option>Perempuan</option>
				</select>
			</td>
			<td><textarea name="in_alamat" style="width:95%" placeholder="Alamat"></textarea></td>
			<td>
				<select name="in_golongan" style="width:100%">
					<?php
					
						$sql = mysql_query("select golongan from gaji");
						while($sqlOpts = mysql_fetch_array($sql)) echo "<option>".$sqlOpts['golongan']."</option>"; 
					?>
				</select>
			</td>
			<td><input type="submit" value="Tambah"></td>
		</form>
		</tr>
		</table>
	<?php
}


function makeTable($table,$contents,$ended=true,$with_Buttons=false) {
	$i=0;
	$sql_ret = sqlQuery("select * from $table");
	$tableWidths  = GetWidth($table);
	
	if(mysql_num_rows( $sql_ret ) == 0) {
	?>
	<div id="lists">
		<p>Tidak ada hasil.</p>
	</div>
	<?php
	} else {
	makeMessage("warning","Aksi yang telah dilakukan TIDAK dapat diurungkan lagi. Perhatikan apa yang ingin Anda lakukan!") ;
	makeMessage("info",!empty($_SESSION['log']) ? $_SESSION['log']:"Tidak ada kesalahan"); 
		?>
		<div id="lists">
		<table border=1>
			<tr>
				<?php foreach($contents as $title=>$caption) { 
				$i++; ?>
					<th><?php echo $caption ?></th>
				<?php }  ?>
			</tr>
		<?php
		$i=0;
		while($sqlRow = mysql_fetch_assoc($sql_ret)) {
			?>
				<tr class='<?php echo ($i%2==0)?"even":"odd"?>'>
					<?php foreach($contents as $title=>$caption) { ?>
					<td><?php echo $sqlRow[$title]?></td>
					<?php } if($with_Buttons) makeAction($sqlRow['nip'],true,true,true)?>
				</tr>
			<?php
			$i++;

		}
		if ($ended==true) echo "</table>";
		mysql_close();
	}
}

function listGaji() {
	?>
		<h1>Data Gaji</h1><hr>
	<?php
	makeTable("gaji", Record("gaji"));
}

?>