<?php
	if (isset($_POST['simpan'])) {
		$kata=$_POST['kata'];

		mysqli_query($con,"insert into wordlist (kata) values ('$kata')");
	}
	if ($_GET['act']=="delete") {
		$id=$_GET['id'];

		mysqli_query($con,"delete from wordlist where id_wordlist=$id");
	}
?>
<div class="box-content">
	<h3 class="head">Halaman Wordlist</h3>
	<form action="" method="POST" style="width: 50%;padding-bottom: 10px;">
		<div class="input-group input-group-sm">
			<input type="text" name="kata" class="form-control" placeholder="Tambah Wordlist">
			<div class="input-group-btn">
				<button class="btn btn-primary" name="simpan" type="submit" style="color: white;">Simpan</button>
			</div>
		</div>
	</form>
	<table id="example" class="table table-striped table-bordered" width="100%">
		<thead>
			<tr>
				<th>No</th>
				<th>Wordlist</th>
				<th>Opsi</th>
			</tr>
		</thead>
		<tbody>
			<?php
				$select=mysqli_query($con,"select*from wordlist");$i=1;
				while ($data=mysqli_fetch_assoc($select)) {
					echo "<tr>";
					echo "<td style='text-align:center;'>".$i++."</td>";
					echo "<td>".$data['kata']."</td>";
					echo "<td>
					<!--a href='?page=edit-matkul&id=".$data['id_wordlist']."' title='Edit'><button class='btn btn-warning btn-xs'><i class='fa fa-edit'></i></button></a-->
					<a href='?page=Tabel Wordlist&act=delete&id=".$data['id_wordlist']."' title='Delete'><button class='btn btn-danger btn-xs'><i class='fa fa-trash'></i></button></a>
					</td>";
					echo "</tr>";
				}
			?>
		</tbody>
	</table>
</div>