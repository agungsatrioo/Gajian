function hitung_gaji() {
	var jam_lembur = document.transfer.jam_lembur.value;
	var uang_lembur = document.transfer.uang_lembur.value;
	var gaji_utama = document.transfer.gaji_utama.value;
	uang_lembur = ( gaji_utama / 173 ) * jam_lembur;
	document.transfer.uang_lembur.value = Math.floor( uang_lembur );
}

function tanya(id) {
	var aa = confirm( 'Yakin akan menghapus data dengan ID - ' + id + '?' );
	if( aa == true ) return true;
	else return false;
}