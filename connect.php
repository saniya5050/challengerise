<?php
$servername="localhost";
$username="root";
$password="";
$database="project";
$conn=mysqli_connect($servername,$username,$password,$database);
if(!$conn)
	echo "not connected".mysqli_connect_error();
?>
