<?php
	$host="localhost";
	$user="root";
	$pass="";
	$db="sentimen";

	$con=mysqli_connect($host,$user,$pass,$db);
	error_reporting(0);

	$avail_page=["Tabel Tweet","Tabel Wordlist","Tweet Testing","Tweet Training"];
?>