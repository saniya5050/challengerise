<?php
include 'connect.php';
$name=$_POST['name'];
$contact=$_POST['contact'];
$dob=$_POST['dob'];
$email=$_POST['email'];
$password=$_POST['password'];
$cp=$_POST['cp'];
$sql="INSERT INTO registration VALUES ('$name','$contact','$dob','$email','$password','$cp')";
$s=$conn->query($sql);
if($s==TRUE)
{
	header("Location:home.html");
	exit();
}
else
	echo "error".$sql."<br>".$conn->error;
mysqli_close($conn);
?>
