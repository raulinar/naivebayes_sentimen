<?php
	if(isset($_POST['submit'])){
		$_SESSION['testing']=$_POST['jumlah'];
	}
	if(isset($_POST['kata'])){
		$_SESSION['ntesting']=$_POST['n'];
	}
	$ntesting=(empty($_SESSION['ntesting'])?10:$_SESSION['ntesting']);
	// unset($_SESSION['training']);
	// unset($_SESSION['testing']);
?>
<div class="box-content">
	<h3 class="head">Halaman Tweet Testing</h3>

	<?php 
		if(!isset($_SESSION['training'])){
			echo "<div class='alert alert-danger'>Pilih Jumlah Tweet Training Dahulu.</div>";
		}else{
	?>
	<form action="" method="POST" class="form-group">
		<label style="float: left;margin-top: 3px;margin-right: 5px;">Pilih Jumlah Tweet : </label>
		<select name="jumlah" class="form-control input-sm jumlah" style="width: 100px;float: left;">
			<?php if(isset($_SESSION['testing'])){ ?><option hidden><?php echo $_SESSION['testing']; ?></option><?php } ?>
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
	<?php }?>

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
				$select=mysqli_query($con,"select*from tweet limit ".$_SESSION['training'].",".$_SESSION['testing']);$i=1;
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
				$positif=$negatif=$tp=$tn=$fp=$fn=$k=0;$i=1;
				$n=sizeof($_SESSION['frekuensi']);

				//ambil data tweet testing
				$select=mysqli_query($con,"select*from tweet limit ".$_SESSION['training']['jumlah'].",".$_SESSION['testing']['jumlah']);
				while ($data=mysqli_fetch_assoc($select)) {
					//cetak data tweet
					echo "<tr>";
					echo "<td style='text-align:center;'>".$i++."</td>";
					echo "<td>".$data['teks']."</td>";

					//preprocessing
					$lower=strtolower($data['teks']);
					$lower=preg_replace("/[^A-Za-z\ ]/", "", $lower);
					$teks=explode(" ", $lower);

					//pengecekan kata yang ada di wordlist
					foreach ($teks as $key => $value) {
						if(in_array($value, $wordlist)){
							$preprocessing[$data['id_tweet']]['kata'][$key]=$value;
							$preprocessing[$data['id_tweet']]['sentimen'][$key]=$data['sentimen'];
							
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

					//perhitungan metode
					foreach ($teks as $key => $value) {
						if($preprocessing[$data['id_tweet']]['sentimen'][$key]=="positif"){
							$y=$_SESSION['frekuensi'][$value." ".$data['sentimen']];
							$z[$data['id_tweet']]=((1+$y)/($n+$_SESSION['training']['positif']))*$_SESSION['prob']['positif'];
						}elseif($preprocessing[$data['id_tweet']]['sentimen'][$key]=="negatif"){
							$v=$_SESSION['frekuensi'][$value." ".$data['sentimen']];
							$x[$data['id_tweet']]=((1+$v)/($n+$_SESSION['training']['negatif']))*$_SESSION['prob']['negatif'];
						}
					}

					//klasifikasi sentimen
					if(empty($preprocessing[$data['id_tweet']])){
						echo "<td>unidentified</td>";
					}else{
						if($z[$data['id_tweet']]>$x[$data['id_tweet']]){
							$sentimen="positif";
							$positif++;
						}else{
							$sentimen="negatif";
							$negatif++;
						}
						echo "<td>$sentimen</td>";
					}
					echo "</tr>";

					//perhitungan akurasi
					if($data['sentimen']==$sentimen && $sentimen=="positif"){
						$tp++;
					}else if($data['sentimen']!=$sentimen && $sentimen=="positif"){
						$fp++;
					}else if($data['sentimen']!=$sentimen && $sentimen=="negatif"){
						$fn++;
					}else if($data['sentimen']==$sentimen && $sentimen=="negatif"){
						$tn++;
					}
				}

				if($_SESSION['testing']['jumlah']>--$i){
					echo '<script type="text/javascript">alert("Tweet tersisa yang dapat digunakan adalah '.$i.'")</script>';
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
			<option hidden><?php echo $ntesting; ?></option>
			<option>10</option>
			<option>20</option>
			<option>50</option>
		</select>
		<button class="btn btn-xs btn-primary" name="kata">Go</button>
	</form>
	<table border="0">
		<tr>
			<td>Total Tweet</td>
			<td>:</td>
			<td><?php echo 	$positif+$negatif; ?></td>
		</tr>
		<tr>
			<td>Total Positif</td>
			<td>:</td>
			<td><?php echo 	$positif; ?></td>
		</tr>
		<tr>
			<td>Total Negatif</td>
			<td>:</td>
			<td><?php echo 	$negatif; ?></td>
		</tr>
		<tr>
			<td>Akurasi</td>
			<td>:</td>
			<td><?php printf("%.2f",((($tp+$tn)/($tp+$tn+$fp+$fn))*100)); ?> %</td>
		</tr>
	</table>
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
						if($i==$ntesting) break;
					}
				?>
			</td>
			<td>
				<?php 
					$i=0;
					foreach ($freqTeks['negatif'] as $key => $value) {
						echo $key." : ".$value."<br>";
						$i++;
						if($i==$ntesting) break;
					}
				?>
			</td>
		</tr>
	</table>
</div>
	