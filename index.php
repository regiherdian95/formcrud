<?php
	// Koneksi Database
$server = "localhost";
$username = "root";
$password = "";
$database = "db_mahasiswa";
$koneksi = mysqli_connect($server, $username, $password, $database) or die (mysqli_error($koneksi));

	// Jika tombol simpan diklik
if(isset($_POST['bsimpan']))
{
	// Pengujian apakah data akan diedit atau disimpan baru
	if($_GET['halaman'] == "edit")
	{
		// Data akan diedit
		$edit = mysqli_query($koneksi, " UPDATE tabel_mahasiswa set
			nrp = '$_POST[tnrp]',
			nama = '$_POST[tnama]',
			alamat = '$_POST[talamat]',
			prodi = '$_POST[tprodi]'
			WHERE id_mahasiswa = '$_GET[id]'
			");

	if($edit) // Jika edit berhasil
	{
		echo "<script>
		alert ('Edit data berhasil!');
		documnet.location='index.php';
		</script>";
	} else 
	{
		echo "<script>
		alert ('Edit data gagal!');
		documnet.location='index.php';
		</script>";
	}
} else
{
		// Data akan disimpan baru
	$simpan = mysqli_query($koneksi, "INSERT INTO tabel_mahasiswa (nrp, nama, alamat, prodi)
		VALUES ('$_POST[tnrp]',
		'$_POST[tnama]',
		'$_POST[talamat]',
		'$_POST[tprodi]')
		");

	if($simpan) // Jika simpan berhasil
	{
		echo "<script>
		alert ('Simpan data berhasil!');
		documnet.location='index.php';
		</script>";
	} else 
	{
		echo "<script>
		alert ('Simpan data gagal!');
		documnet.location='index.php';
		</script>";
	}
}



}

	// Pengujian jika jika tombol Edit / Hapus diklik
if(isset($_GET['halaman']))
{
		// Pengujian jika edit data
	if($_GET['halaman'] == "edit")
	{
			// Tampilkan data yang akan diedit
		$tampil = mysqli_query($koneksi, "SELECT * FROM tabel_mahasiswa WHERE id_mahasiswa = '$_GET[id]' ");
		$data = mysqli_fetch_array($tampil);
		if($data)
		{
				// Jika data ditemukan, maka data ditampung kedalam variabel
			$vnrp = $data['nrp'];
			$vnama = $data['nama'];
			$valamat = $data['alamat'];
			$vprodi = $data['prodi'];
		}
	}
	else if ($_GET['halaman'] == "hapus")
	{
		// Persiapan hapus data
		$hapus = mysqli_query($koneksi, "DELETE FROM tabel_mahasiswa WHERE id_mahasiswa = '$_GET[id]' ");
		if ($hapus) {
			echo "<script>
			alert ('Hapus data berhasil!');
			documnet.location='index.php';
			</script>";
		}

	}
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>CRUD 2021 PHP, MYSQL DAN BOOTSTRAP 4</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
</head>
<body>
	<div class="container">
		<h3 class="text-center">CRUD 2021 PHP, MYSQL DAN BOOTSTRAP 4</h3>
		<h4 class="text-center">@RegiHerdian</h4>

		<!-- Awal Card Form -->
		<div class="card mt-3">
			<div class="card-header bg-primary text-white">
				Form Input Data Mahasiswa
			</div>
			<div class="card-body">
				<form method="post" action="">
					<div class="form-group">
						<label>NRP</label>
						<input type="number" name="tnrp" value="<?=@$vnrp?>" class="form-control" placeholder="Masukan NRP anda disini!" required>
					</div>

					<div class="form-group">
						<label>Nama</label>
						<input type="text" name="tnama" value="<?=@$vnama?>" class="form-control" placeholder="Masukan Nama anda disini!" required>
					</div>

					<div class="form-group">
						<label>Alamat</label>
						<textarea class="form-control" name="talamat" placeholder="Masukan Alamat anda disini!" ><?=@$valamat?></textarea>
					</div>

					<div class="form-group">
						<label>Program Studi</label>
						<select class="form-control" name="tprodi">
							<option value="<?=@$vprodi?>"><?=@$vprodi?></option>
							<option value="D3-Sistem Informasi">D3-Sistem Informasi</option>
							<option value="S1-Sistem Informasi">S1-Sistem Informasi</option>
							<option value="S1-Sistem Informasi">S1-Teknik Informatika</option>
							<option value="S2-Sistem Informasi">S2-Sistem Informasi</option>

						</select>
					</div>

					<button type="submit" class="btn btn-success" name="bsimpan">Simpan</button>
					<button type="submit" class="btn btn-danger" name="breset">Kosongkan</button>

				</form>
			</div>
		</div>
		<!-- Akhir Card Form -->

		<!-- Awal Card Tabel -->
		<div class="card mt-3">
			<div class="card-header bg-primary text-white">
				Daftar Mahasiswa
			</div>
			<div class="card-body">

				<table class="table table-bordered table-striped">
					<tr>
						<th>No.</th>
						<th>Nrp</th>
						<th>Nama</th>
						<th>Alamat</th>
						<th>Program Studi</th>
						<th>Aksi</th>
					</tr>

					<?php
					$no = 1;
					$tampil = mysqli_query($koneksi, "SELECT * from tabel_mahasiswa order by id_mahasiswa desc");
					while ($data = mysqli_fetch_array($tampil)) : 

						?>

						<tr>
							<td><?=$no++;?></td>
							<td><?=$data['nrp']?></td>
							<td><?=$data['nama']?></td>
							<td><?=$data['alamat']?></td>
							<td><?=$data['prodi']?></td>
							<td>
								<a href="index.php?halaman=edit&id=<?=$data['id_mahasiswa']?>" class="btn btn-warning"> Edit </a>
								<a href="index.php?halaman=hapus&id=<?=$data['id_mahasiswa']?>"
									onclick="return confirm('Apakah anda yakin akan menghapus data ini ?')" class="btn btn-danger"> Hapus </a>
								</td>
							</tr>
						<?php endwhile; // penutup perulangan while ?>

					</table>
				</div>
			</div>
			<!-- Akhir Card Tabel -->

		</div>

		<script type="text/javascript" src="js/bootstrap.min.js"></script>
	</body>
	</html>