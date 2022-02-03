<div class="box-content">
	<h3 class="head">Halaman Tweet</h3>
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
				$select=mysqli_query($con,"select*from tweet");$i=1;
				while ($data=mysqli_fetch_assoc($select)) {
					echo "<tr>";
					echo "<td style='text-align:center;'>".$i++."</td>";
					echo "<td>".$data['teks']."</td>";
					echo "<td>".$data['sentimen']."</td>";
					echo "</tr>";
				}
			?>
		</tbody>
	</table>
</div>