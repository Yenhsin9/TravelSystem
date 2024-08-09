<?php 
$property_id='';
$LodgeName='';
$RoomType='';
$RoomPrice='';
$Contact='';
$PhoneNumber='';
$Pet='';
$Location='';
$Description='';
$Latitude='';
$Longitude='';
$owner_id='';
$nearbyplaces='';
$costofutilities= '';
$facilities='';
$securitysystem='';
$time=''; 
$service='';



$db = new mysqli('localhost','root','','renthouse');

if($db->connect_error){
	echo "Error connecting database";
}

if(isset($_POST['add_property'])){
	add_property();
}

if(isset($_POST['owner_update'])){
	owner_update();
}


function add_property(){

	global $property_id,$LodgeName,$RoomType,$RoomPrice,$Contact,$Pet,$Location,$Description,$Latitude,$Longitude,$owner_id,$booked, $db, $nearbyplaces, $costofutilities, $facilities, $securitysystem, $time, $service;

	$LodgeName=validate($_POST['LodgeName']);
	$RoomType=validate($_POST['RoomType']);
	$RoomPrice=validate($_POST['RoomPrice']);
	$Contact=validate($_POST['Contact']);
	$PhoneNumber=validate($_POST['PhoneNumber']);
	$Pet=validate($_POST['Pet']);
	$Location=validate($_POST['Location']);
	$Latitude=validate($_POST['Latitude']);
   	$Longitude=validate($_POST['Longitude']);
	$Description=validate($_POST['Description']);
	$facilities=validate($_POST['facilities']);
	$securitysystem=validate($_POST['securitysystem']);
	$time=validate($_POST['time']);
	$service=validate($_POST['service']);
	$nearbyplaces=validate($_POST['nearbyplaces']);
	$costofutilities=validate($_POST['costofutilities']);
   	$booked='No';
   	$u_email=$_SESSION['email'];
        $sql1="SELECT * from owner where email='$u_email'";
        $result1=mysqli_query($db,$sql1);

        if(mysqli_num_rows($result1)>0)
      {
          while($rowss=mysqli_fetch_assoc($result1)){
            $owner_id=$rowss['owner_id'];

   	$sql = "INSERT INTO add_property(LodgeName,RoomType,RoomPrice,Contact,PhoneNumber,Pet,Location,Latitude,Longitude,Description,booked,owner_id, nearbyplaces, costofutilities, facilities, securitysystem,time, service) VALUES('$LodgeName','$RoomType','$RoomPrice','$Contact','$PhoneNumber','$Pet','$Location','$Latitude','$Longitude','$Description','$booked','$owner_id', '$nearbyplaces', '$costofutilities', '$facilities', '$securitysystem','$time', '$service')";
		$query=mysqli_query($db,$sql);
		$property_id = mysqli_insert_id($db);
		$countfiles = count($_FILES['p_photo']['name']);
	for($i=0;$i<$countfiles;$i++){
	$paths = $_FILES['p_photo']['tmp_name'][$i];
		  if($paths!="")
			{
		    	$path="product-photo/" . $_FILES['p_photo']['name'][$i];
				if(move_uploaded_file($paths, $path)) {
		        $sql2 = "INSERT INTO property_photo(p_photo,property_id) VALUES('$path','$property_id')";
				$query=mysqli_query($db,$sql2);
			}}
 }
		if(!empty($query)){
			
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
<script>
	window.setTimeout(function() {
    $(".alert").fadeTo(1000, 0).slideUp(500, function(){
        $(this).remove(); 
    });
}, 2000);
</script>
<div class="container">
<div class="alert" role='alert'>
  <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
  <center><strong>Your Product has been uploaded.</strong></center>
</div></div>


<?php
		}
		else{
			echo "error";
		}

}
}}

function owner_update(){
	global $owner_id,$full_name,$email,$password,$phone_no,$db;
	$owner_id=validate($_POST['owner_id']);
	$full_name=validate($_POST['full_name']);
	$email=validate($_POST['email']);
	$phone_no=validate($_POST['phone_no']);
	$password = md5($password); // Encrypt password
		$sql = "UPDATE owner SET full_name='$full_name',email='$email',phone_no='$phone_no' WHERE owner_id='$owner_id'";
		$query=mysqli_query($db,$sql);
		if(!empty($query)){
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
<script>
	window.setTimeout(function() {
    $(".alert").fadeTo(1000, 0).slideUp(500, function(){
        $(this).remove(); 
    });
}, 2000);
</script>
<div class="container">
<div class="alert" role='alert'>
  <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
  <center><strong>Your Information has been updated.</strong></center>
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