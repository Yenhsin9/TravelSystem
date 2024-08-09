<?php 

$owner_id='';
$full_name='';
$email='';
$password='';
$phone_no='';

$errors=array();
$db = new mysqli('localhost','root','','renthouse');
if($db->connect_error){
	echo "Error connecting database";
}

if(isset($_POST['owner_register'])){
	owner_register();
}

if(isset($_POST['owner_login'])){
	owner_login();
}

function owner_register(){
	global $owner_id,$full_name,$email,$password,$phone_no,$errors,$db;
	$owner_id=validate($_POST['owner_id']);
	$full_name=validate($_POST['full_name']);
	$email=validate($_POST['email']);
	$password=validate($_POST['password']);
	$phone_no=validate($_POST['phone_no']);
		$sql = "INSERT INTO owner(owner_id,full_name,email,password,phone_no) VALUES('$owner_id','$full_name','$email','$password','$phone_no')";
		if($db->query($sql)===TRUE){
			header("location:owner-login.php");
	}
}

function owner_login(){
	global $password,$email,$db;
	$email=validate($_POST['email']);
	$password=validate($_POST['password']);
		$sql = "SELECT * FROM owner where email='$email' AND password='$password' LIMIT 1";
		$result = $db->query($sql);
		if($result->num_rows==1){
			$data = $result-> fetch_assoc();
			$logged_user = $data['email'];
			session_start();
			$_SESSION['email']=$email;
			header('location:owner/owner-index.php');
		}
		else{
			
?>

<style>
.alert {
  padding: 20px;
  background-color: #DC143C;
  color: white;
}

.closebtn {
  margin-left: 15px;
  color: white;
  font-weight: bold;
  float: right;
  font-size: 22px;
  line-height: 20px;
  cursor: pointer;
  transition: 0.3s;
}

.closebtn:hover {
  color: black;
}
</style>
<div class="container">
<div class="alert">
  <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
  <strong>Incorrect Email/Password or not registered.</strong> Click here to <a href="owner-register.php" style="color: lightblue;"><b>Register</b></a>.
</div></div>


<?php
		}
}


function validate($data){
	$data = trim($data);
	$data = stripcslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}



 ?>