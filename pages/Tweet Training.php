<?php
	if(isset($_POST['submit'])){
		$_SESSION['training']=$_POST['jumlah'];
	}
?>
<div class="box-content">
	<h3 class="head">Halaman Tweet Training</h3>
	<form action="" method="POST" class="form-group">
		<label style="float: left;margin-top: 3px;margin-right: 5px;">Pilih Jumlah Tweet : </label>
		<select name="jumlah" class="form-control input-sm jumlah" style="width: 100px;float: left;">
			<?php if(isset($_SESSION['training'])){ ?><option hidden><?php echo $_SESSION['training']; ?></option><?php } ?>
			<option>100</option>
			<option>200</option>
			<option>300</option>
			<option>400</option>
			<option>500</option>
			<option>600</option>
			<option>700</option>
			<option>800</option>
			<option>900</option>
			<option>1000</option>
		</select>
		<button class="btn btn-xs btn-primary" name="submit">Go</button>
	</form>
	<table id="example" class="table table-striped table-bordered" width="100%">
		<thead>
			<tr>
				<th>No</th>
				<th>Teks (Tweet)</th>
				<th>Sentimen</th>
			</tr>
		</thead>
		<tbody>
			<?php
				$select=mysqli_query($con,"select*from tweet limit 0,".$_SESSION['training']);$i=1;
				while ($data=mysqli_fetch_assoc($select)) {
					echo "<tr>";
					echo "<td style='text-align:center;'>".$i++."</td>";
					echo "<td>".$data['teks']."</td>";
					echo "<td>".$data['sentimen']."</td>";
					echo "</tr>";
				}
			?>
			<?php
				//ambil data wordlist
				$word=mysqli_query($con,"select*from wordlist");
				while ($list=mysqli_fetch_assoc($word)) {
					$wordlist[]=$list['kata'];
				}
				
				//inisialisasi variabel
				$positif=0;$negatif=0;$tweetpositif=0;$tweetnegatif=0;

				//ambil data tweet training
				$select=mysqli_query($con,"select*from tweet limit 0,".$_SESSION['training']['jumlah']);$i=1;
				while ($data=mysqli_fetch_assoc($select)) {
					//hitung jumlah tweet sesuai sentimen
					if($data['sentimen']=="positif"){
						$tweetpositif++;
					}else{
						$tweetnegatif++;
					}

					//cetak data tweet
					echo "<tr>";
					echo "<td style='text-align:center;'>".$i++."</td>";
					echo "<td>".$data['teks']."</td>";
					echo "<td>".$data['sentimen']."</td>";

					//preprocessing
					$lower=strtolower($data['teks']);
					$lower=preg_replace("/[^A-Za-z\ ]/", "", $lower);
					$teks=explode(" ", $lower);

					//pengecekan kata yang ada di wordlist
					foreach ($teks as $key => $value) {
						if(in_array($value, $wordlist)){
							$preprocessing[$data['id_tweet']]['kata'][]=$value;
							$preprocessing[$data['id_tweet']]['sentimen'][]=$data['sentimen'];
							if($data['sentimen']=="positif"){
								$positif++;
							}else{
								$negatif++;
							}

							if($data['sentimen']=="positif"){
								if(!empty($freqTeks['positif'][$value])){
									$freqTeks['positif'][$value]++;
								}else{
									$freqTeks['positif'][$value]=1;
								}
							}else{
								if(!empty($freqTeks['negatif'][$value])){
									$freqTeks['negatif'][$value]++;
								}else{
									$freqTeks['negatif'][$value]=1;
								}
							}
						}
					}

					//hitung frekuensi kemunculan kata
					foreach ($preprocessing[$data['id_tweet']]['kata'] as $key => $value) {
						$_SESSION['frekuensi'][$value." ".$preprocessing[$data['id_tweet']]['sentimen'][$key]]++;
					}
					echo "</tr>";
				}


				//sorting
				arsort($freqTeks['positif']);
				arsort($freqTeks['negatif']);
				unset($freqTeks['negatif']['']);
				unset($freqTeks['positif']['']);
			?>
		</tbody>
	</table>
	<hr>
	<form action="" method="POST" class="form-group">
		<label style="float: left;margin-top: 3px;margin-right: 5px;">Pilih Jumlah Kata : </label>
		<select name="n" class="form-control input-sm jumlah" style="width: 100px;float: left;">
			<option hidden><?php echo $ntraining; ?></option>
			<option>10</option>
			<option>20</option>
			<option>50</option>
		</select>
		<button class="btn btn-xs btn-primary" name="kata">Go</button>
	</form>
	<table border="0" width="100%">
		<tr style="text-align: center;">
			<th>Frekuensi Kata Positif</th>
			<th>Frekuensi Kata Negatif</th>
		</tr>
		<tr>
			<td>
				<?php 
					$i=0;
					foreach ($freqTeks['positif'] as $key => $value) {
						echo $key." : ".$value."<br>";
						$i++;
						if($i==$ntraining) break;
					}
				?>
			</td>
			<td>
				<?php 
					$i=0;
					foreach ($freqTeks['negatif'] as $key => $value) {
						echo $key." : ".$value."<br>";
						$i++;
						if($i==$ntraining) break;
					}
				?>
			</td>
		</tr>
	</table>
</div>
<?php
	//simpan variabel ke dalam session
	$_SESSION['training']['positif']=$positif;
	$_SESSION['training']['negatif']=$negatif;
	unset($_SESSION['frekuensi'][' negatif']);
	unset($_SESSION['frekuensi'][' positif']);
	$_SESSION['prob']['positif']=$tweetpositif/$_SESSION['training']['jumlah'];
	$_SESSION['prob']['negatif']=$tweetnegatif/$_SESSION['training']['jumlah'];
?>
		</tbody>
	</table>
