<?php
session_start();
include "function.php";
session_destroy();
$user_id = isset( $_SESSION['user_id'] ) ? $_SESSION['user_id'] : '';

?>
<!DOCTYPE html>
	<head>
		<link rel="stylesheet" href="main.css">
	<?php
		if(true) { //User sudah login
		?>
			<title>Gajian: Home</title>
			</head>
			<body>
				<div id="home-page">
					<div id="home-panel">
						<h1>Gajian Main Panel</h1>
						<p id="description">Versi 1.01 (login sebagai <b><?php echo $user_id ?></b>. <a href="?page=logout">Keluar</a>)</p>
						<nav><hr>
							<ul>
								<li><a href="?page=home"><div class="mi home"></div>Rumah</a></li>
								<li><a href="?page=data_karyawan"><div class="mi person"></div>Data karyawan</a></li>
								<li><a href="?page=data_gaji"><div class="mi payment"></div>Data Gaji</a></li>
								<li><a href="?page=cari"><div class="mi search"></div>Cari</a></li>
							</ul>
						<hr></nav>
						<article>
							<?php
							switch($page) {
								case "data_karyawan":
									listKaryawan();
									break;
								case "data_gaji": 
									listGaji();
									break;
								case "home":
									idle();
									break;								
								case "logout":
									logout();
									break;
								case "transfer":
									
									break;							
								case "edit":
									
									break;
								default:
									idle();
									break;
							} 
							?>
						</article>
					</div>
				</div>
		<?php
		} else { //User belum login
			?>
			<title>Gajian: Login</title>
			</head>
			<body>
				<div id="login-page">
					<div id="login-panel">
						<h1>Login page</h1><hr>
						<form action="" method="post" name="login">
							<input type="text" name="user" placeholder="Username" required><br>
							<input type="password" name="pswd" placeholder="Password" required><br>
							<input type="submit" name="page" value="login">
						</form>
					</div>
				<div>
		<?php } ?>
	</body>
</html>