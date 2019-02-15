<?php
$conn = mysqli_connect("localhost", "root", "", "login");


$name=$_POST['username'];
$password =( $_POST['password']);
$email= $_POST['email'];

//set value on table using query
 $sql="INSERT INTO login(username, password, email) VALUES('$name','$password','$email')";
mysqli_query($conn,$sql);


header("Location:login.php");

?>