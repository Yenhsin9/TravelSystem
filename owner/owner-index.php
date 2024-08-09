<?php 
session_start();
if(!isset($_SESSION["email"])){
  header("location:../index.php");
}

include("navbar.php");
include("engine.php");

 ?>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="style.css">

</head>

<body>

 <div class="container-fluid">
  <ul class="nav nav-pills nav-justified">
    <li class="active" style="background-color: #FFF8DC"><a data-toggle="pill" href="#home">Profile</a></li>
    <li style="background-color: #FAC0E6"><a data-toggle="pill" href="#menu4">Messages</a></li>
    <li style="background-color: #FAF0E6"><a data-toggle="pill" href="#menu1">Add Property</a></li>
    <li style="background-color: #FFFACD"><a data-toggle="pill" href="#menu2">View Property</a></li>
    <li style="background-color: #FFFAF0"><a data-toggle="pill" href="#menu3">Update Property</a></li>
    <li style="background-color: #FAFAF0"><a data-toggle="pill" href="#menu6">Booked Property</a></li>
  </ul>

  <div class="tab-content">
    <div id="home" class="tab-pane fade in active">
      <center><h3>Admin </h3></center>
      <div class="container">
      <?php 
        include("../config/config.php");
        $u_email= $_SESSION["email"];

        $sql="SELECT * from owner where email='$u_email'";
        $result=mysqli_query($db,$sql);

        if(mysqli_num_rows($result)>0)
      {
          while($rows=mysqli_fetch_assoc($result)){
          
       ?>
        <div class="card">
  <img src="../images/avatar.png" alt="John" style="height:200px; width: 100%">
  <h1><?php echo $rows['full_name']; ?></h1>
  <p class="title"><?php echo $rows['email']; ?></p>
  <p><b>Phone No.: </b><?php echo $rows['phone_no']; ?></p>
  

  <!-- Trigger the modal with a button -->
  <p><button type="button" class="btn btn-lg" data-toggle="modal" data-target="#myModal">Update Profile</button></p>


  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Update Profile</h4>
        </div>
        <div class="modal-body">

            <form method="POST">
                <div class="form-group">
                  <label for="full_name">Full Name:</label>
                  <input type="hidden" value="<?php echo $rows['owner_id']; ?>" name="owner_id">
                  <input type="text" class="form-control" id="full_name" value="<?php echo $rows['full_name']; ?>" name="full_name">
                </div>
                <div class="form-group">
                  <label for="email">Email:</label>
                  <input type="email" class="form-control" id="email" value="<?php echo $rows['email']; ?>" name="email" readonly>
                </div>
                <div class="form-group">
                  <label for="phone_no">Phone No.:</label>
                  <input type="text" class="form-control" id="phone_no" value="<?php echo $rows['phone_no']; ?>" name="phone_no">
                </div>
                <hr>
                <center><button id="submit" name="owner_update" class="btn btn-primary btn-block">Update</button></center><br>
                
              </form>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
</div>
    </div>
    </div>






    <div id="menu4" class="tab-pane fade">
      <div class="container">
      <center><h3>See Messages</h3></center>
            <?php 
      $owner_id=$rows['owner_id']; 
      $sql1="SELECT * FROM chat where owner_id='$owner_id' ";
      $query1 = mysqli_query($db,$sql1);
      if(mysqli_num_rows($query1)>0)
      {
        while($row= mysqli_fetch_assoc($query1)){
          $tenant_id=$row['tenant_id'];
          $sql2="SELECT * FROM tenant where tenant_id='$tenant_id' ";
          $query2 = mysqli_query($db,$sql2);
          if(mysqli_num_rows($query2)>0)
  {
    while ($rows= mysqli_fetch_assoc($query2)){
    
?>

   
<link rel="stylesheet" type="text/css" href="message-style.css">

<div class="tab">   
  <button class="tablinks" id="defaultOpen" onmouseover="openCity(event, '<?php echo $rows["full_name"]; ?>')"><?php echo $rows["full_name"]; ?></button>
</div>

<div id="<?php echo $rows["full_name"]; ?>" class="tabcontent">
  <?php
   $sql3="SELECT * FROM chat where tenant_id='$tenant_id' AND owner_id='$owner_id' ";

    $query3 = mysqli_query($db,$sql3);

  if(mysqli_num_rows($query3)>0)
  {
    while($ro= mysqli_fetch_assoc($query3)){
      echo $ro["message"]."<br>";
    }}
  ?>
</div>

<div class="clearfix"></div>


<?php
        echo '<a href="send-message.php?owner_id='.$owner_id.'&tenant_id='.$tenant_id.'">'.$rows["full_name"].'</a>';
    }
  }}}}}?>
    </div>
    </div>


    <div id="menu1" class="tab-pane fade">
      <center><h3>Add Property</h3></center>
      <div class="container">

      
<div id="map_canvas"></div>
        <form method="POST" enctype="multipart/form-data">
          <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
              <label for="LodgeName">Lodge Name:</label>
              <input type="text" class="form-control" id="LodgeName" placeholder="Enter Lodge Name" name="LodgeName">
            </div>

            <div class="form-group">
               <label for="RoomType">Room Type:</label>
                <select class="form-control" name="RoomType" required="required">
                      <option value="">--Select Room Type--</option>
                      <option value="Studio">Studio</option>
                      <option value="Suite">Suite</option>
                      <option value="Condo">Condo</option>
                </select>
            </div>     

            <div class="form-group">
              <label for="RoomPrice">Estimated Price:</label>
              <input type="text" class="form-control" id="RoomPrice" placeholder="Enter Room Price" name="RoomPrice">
            </div>

            <div class="form-group">
              <label for="Contact">Contact:</label>
              <input type="text" class="form-control" id="Contact" placeholder="Enter Contact" name="Contact">
            </div>

            <div class="form-group">
              <label for="PhoneNumber">Phone Number:</label>
              <input type="text" class="form-control" id="PhoneNumber" placeholder="Enter Phone Number" name="PhoneNumber">
            </div> 

            <div class="form-group">
              <label for="Location">Location:</label>
              <input type="text" class="form-control" id="Location" placeholder="Enter Location" name="Location">
            </div>
      
            <div class="form-group">
                    <label for="costofutilities">Cost of utilities:</label>
                    <textarea type="comment" class="form-control" id="costofutilities" placeholder="Enter cost of utilities" name="costofutilities"></textarea>
                  </div>
            <div class="form-group">
               <label for="Pet">Pet:</label>
                <select class="form-control" name="Pet" required="required">
                      <option value="">--Select options--</option>
                      <option value="Allowed">Allowed</option>
                      <option value="-">-</option>
                </select>
            </div> 
            <div class="form-group">
               <label for="securitysystem">Security System:</label>
                <select class="form-control" name="securitysystem" required="required">
                      <option value="">--Select options--</option>
                      <option value="Keycard">Keycard</option>
                      <option value="CCTV">CCTV</option>
                      <option value="Keycard and CCTV">Keycard, CCTV</option>
                      <option value="-">-</option>
                </select>
            </div>
            </div> 
        <div class="col-sm-6">
          
            <div class="form-group">
              <label for="time">Estimated time to campus:</label>
              <input type="text" class="form-control" id="time" placeholder="Enter time spent traveling to university" name="time">
            </div>
            <div class="form-group">
                    <label for="facilities">Facilities:</label>
                    <textarea type="comment" class="form-control" id="facilities" placeholder="Enter facilities" name="facilities"></textarea>
                  </div>
                  <div class="form-group">
                    <label for="service">Free service:</label>
                    <textarea type="comment" class="form-control" id="service" placeholder="Enter free service" name="service"></textarea>
                  </div>
                  <div class="form-group">
                    <label for="nearbyplaces">Near by place:</label>
                    <textarea type="comment" class="form-control" id="nearbyplaces" placeholder="Enter nearby places" name="nearbyplaces"></textarea>
                  </div>
                  <div class="form-group">
                    <label for="Description">Full Description:</label>
                    <textarea type="comment" class="form-control" id="Description" placeholder="Enter Property Description" name="Description"></textarea>
                  </div>
                  <table class="table table-bordered" border="0">  
                  <tr> 
                    <div class="form-group"> 
                    <label><b>Latitude/Longitude:</b><span style="color:red; font-size: 10px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; *Click on Button</span></label>                    
                    <td><input type="text" name="Latitude" placeholder="Latitude" id="Latitude" class="form-control name_list" readonly required /></td>
                    <td><input type="text" name="Longitude" placeholder="Longitude" id="Longitude" class="form-control name_list" readonly required /></td> 
                    <td><input type="button" value="Get Latitude and Longitude" onclick="getLocation()" class="btn btn-success col-lg-12"></td>  
                  </div>
                  </tr>  
                </table>
                  <table class="table" id="dynamic_field">  
                  <tr> 
                    <div class="form-group"> 
                    <label><b>Photos:</b></label>                    
                    <td><input type="file" name="p_photo[]" placeholder="Photos" class="form-control name_list" required accept="image/*" /></td> 
                    <td><button type="button" id="add" name="add" class="btn btn-success col-lg-12">Add More</button></td>  
                  </div>
                  </tr>  
                </table>
                <input name="Latitude" type="text" id="Latitude" hidden>
                <input name="Longitude" type="text" id="Longitude" hidden>
                  <hr>
                  <div class="form-group">
                    <input type="submit" class="btn btn-primary btn-lg col-lg-12" value="Add Property" name="add_property">
                  </div>
                </div>
              </div>
              </form>
              <br><br>
    </div>
    </div>
    <div id="menu2" class="tab-pane fade">
      <center><h3>View Property</h3></center>
      <div class="container-fluid">
      <input type="text" id="myInput" onkeyup="viewProperty()" placeholder="Search..." title="Type in a name">
            <div style="overflow-x:auto;">
              <table id="myTable">
                <tr class="header">
                  <th>Id.</th>
                  <th>Lodge Name</th>
                  <th>Room Type</th>
                  <th>Estmated Price</th>
                  <th>Contact</th>
                  <th>Phone Number</th>
                  <th>Location</th>
                  <th>Photos</th>
                </tr>
                <?php 
                $u_email=$_SESSION['email'];
        $sql1="SELECT * from owner where email='$u_email'";
        $result1=mysqli_query($db,$sql1);

        if(mysqli_num_rows($result1)>0)
      {
          while($rowss=mysqli_fetch_assoc($result1)){
            $owner_id=$rowss['owner_id'];

        $sql="SELECT * from add_property where owner_id='$owner_id'";
        $result=mysqli_query($db,$sql);

        if(mysqli_num_rows($result)>0)
      {
          while($rows=mysqli_fetch_assoc($result)){
          $property_id=$rows['property_id'];
       ?>
                <tr>
                  <td><?php echo $rows['property_id'] ?></td>
                  <td><?php echo $rows['LodgeName'] ?></td>
                  <td><?php echo $rows['RoomType'] ?></td>
                  <td><?php echo $rows['RoomPrice'] ?></td>
                  <td><?php echo $rows['Contact'] ?></td>
                  <td><?php echo $rows['PhoneNumber'] ?></td>
                  <td><?php echo $rows['Location'] ?></td>
                  <td>
<?php $sql2="SELECT * from property_photo where property_id='$property_id'";
        $query=mysqli_query($db,$sql2);

        if(mysqli_num_rows($query)>0)
      {
          while($row=mysqli_fetch_assoc($query)){ ?>
                  <img src="<?php echo $row['p_photo'] ?>" width="50px">
                <?php }}}}}} ?>
                </td>
                </tr>
              </table> 
            </div>
    </div>
    </div>

    <div id="menu3" class="tab-pane fade">
      <center><h3>Update Property</h3></center>
      <div class="container-fluid">
      <input type="text" id="myInput" onkeyup="updateProperty()" placeholder="Search..." title="Type in a name">
            <div style="overflow-x:auto;">
              <table id="myTable">
                <tr class="header">
                  <th>Id.</th>
                  <th>LodgeName</th>
                  <th>RoomType</th>
                  <th>RoomPrice</th>
                  <th>Contact</th>
                  <th>PhoneNumber</th>
                  <th>Location</th>
                  <th></th>
                  <th>Edit/Delete</th>
                </tr>
                <?php 
        $sql="SELECT * from add_property where owner_id='$owner_id'";
        $result=mysqli_query($db,$sql);
        
        if(mysqli_num_rows($result)>0)
      {
          while($rows=mysqli_fetch_assoc($result)){
          $property_id=$rows['property_id'];
       ?>
                <tr>
                  <td><?php echo $rows['property_id'] ?></td>
                  <td><?php echo $rows['LodgeName'] ?></td>
                  <td><?php echo $rows['RoomType'] ?></td>
                  <td><?php echo $rows['RoomPrice'] ?></td>
                  <td><?php echo $rows['Contact'] ?></td>
                  <td><?php echo $rows['PhoneNumber'] ?></td>
                  <td><?php echo $rows['Location'] ?></td>
                  <td>
<!--<?php $sql2="SELECT * from property_photo where property_id='$property_id'";
        $query=mysqli_query($db,$sql2);

        if(mysqli_num_rows($query)>0)
      {
          while($row=mysqli_fetch_assoc($query)){ ?>
                
                </td>
                <td>
                <img src="<?php echo $row['p_photo'] ?>" width="50px">
                </td>
                <?php }}  ?>-->
                <form method="POST">
                <td>
                  <input type="hidden" name="property_id" value="<?php echo $rows['property_id']; ?>"> 
                  <a data-toggle="pill" class="btn btn-success" name="edit_property" onclick="<?php $property_id = $rows['property_id'] ?>" href="#menu5">Edit</a><input type="submit" class="btn btn-danger" name="delete_property" value="Delete">
                  </td>
                </tr>
                </form>
                <?php }} ?>
              </table> 
            </div>
    </div>
    </div>




    <div id="menu5" class="tab-pane fade">
      <center><h3>Edit Property Details</h3></center>
      <div class="container">

      
<div id="map_canvas"></div>
        <form method="POST" enctype="multipart/form-data">
          <div class="row">
        <div class="col-sm-6">
          <div class="form-group">
              <label for="LodgeName">Lodge Name:</label>
              <input type="text" class="form-control" id="LodgeName" placeholder="Enter Lodge Name" name="LodgeName">
            </div>

            <div class="form-group">
               <label for="RoomType">Room Type:</label>
                <select class="form-control" name="RoomType" required="required">
                      <option value="">--Select Room Type--</option>
                      <option value="Studio">Studio</option>
                      <option value="Suite">Suite</option>
                      <option value="Condo">Condo</option>
                </select>
            </div>     

            <div class="form-group">
              <label for="RoomPrice">Estimated Price:</label>
              <input type="text" class="form-control" id="RoomPrice" placeholder="Enter Room Price" name="RoomPrice">
            </div>

            <div class="form-group">
              <label for="Contact">Contact:</label>
              <input type="text" class="form-control" id="Contact" placeholder="Enter Contact" name="Contact">
            </div>

            <div class="form-group">
              <label for="PhoneNumber">Phone Number:</label>
              <input type="text" class="form-control" id="PhoneNumber" placeholder="Enter Phone Number" name="PhoneNumber">
            </div> 

            <div class="form-group">
              <label for="facilities">Facilities:</label>
              <input type="text" class="form-control" id="facilities" placeholder="Enter Phone Number" name="facilities">
            </div>

            <div class="form-group">
              <label for="service">Free service:</label>
              <input type="text" class="form-control" id="service" placeholder="Enter Phone Number" name="service">
            </div>

            <div class="form-group">
              <label for="costofutilities">Cost of utilities:</label>
              <input type="text" class="form-control" id="costofutilities" placeholder="Enter Location" name="costofutilities">
            </div>

            <div class="form-group">
              <label for="time">Estimated time to campus:</label>
              <input type="text" class="form-control" id="time" placeholder="Enter Phone Number" name="time">
            </div>

            <div class="form-group">
              <label for="Location">Location:</label>
              <input type="text" class="form-control" id="Location" placeholder="Enter Location" name="Location">
            </div>


            <div class="form-group">
               <label for="securitysystem">Security System:</label>
                <select class="form-control" name="securitysystem" required="required">
                      <option value="">--Select options--</option>
                      <option value="Allowed">CCTV</option>
                      <option value="Allowed">Keycard</option>
                      <option value="Allowed">CCTV,Keycard</option>
                      <option value="NotAllow">-</option>
                </select>
            </div>

            <div class="form-group">
               <label for="Pet">Pet:</label>
                <select class="form-control" name="Pet" required="required">
                      <option value="">--Select options--</option>
                      <option value="Allowed">Allowed</option>
                      <option value="NotAllow">-</option>
                </select>
            </div> 

           </div> 

        <div class="col-sm-6">
        <div class="form-group">
                    <label for="Description">Full Description:</label>
                    <textarea type="comment" class="form-control" id="Description" placeholder="Enter Description" name="Description"></textarea>
                  </div>

                <table class="table table-bordered" border="0">  
                  <tr> 
                    <div class="form-group"> 
                    <label><b>Latitude/Longitude:</b><span style="color:red; font-size: 10px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; *Click on Button</span></label>                    
                    <td><input type="text" name="Latitude" placeholder="Latitude" id="Latitude" class="form-control name_list" readonly required /></td>
                    <td><input type="text" name="Longitude" placeholder="Longitude" id="Longitude" class="form-control name_list" readonly required /></td> 
                    <td><input type="button" value="Get Latitude and Longitude" onclick="getLocation()" class="btn btn-success col-lg-12"></td>  
                    </div>
                  </tr>  
                </table>

                <table class="table" id="dynamic_field">  
                  <tr> 
                    <div class="form-group"> 
                    <label><b>Photos:</b></label>                    
                    <td><input type="file" name="p_photo[]" placeholder="Photos" class="form-control name_list" required accept="image/*" /></td> 
                    <td><button type="button" id="add" name="add" class="btn btn-success col-lg-12">Add More</button></td>  
                    </div>
                  </tr>  
                </table>
                
                <input name="Latitude" type="text" id="Latitude" hidden>
                <input name="Longitude" type="text" id="Longitude" hidden>
                  <hr>
                  <div class="form-group">
                    <input type="submit" class="btn btn-primary btn-lg col-lg-12" value="Add Property" name="add_property">
                  </div>
                </div>
              </div>
              </form>
              <br><br>
    </div>
    </div>

<div id="menu6" class="tab-pane fade">
      <center><h3>Booked Property</h3></center>
      <div class="container">
        <input type="text" id="myInput" onkeyup="bookedProperty()" placeholder="Search..." title="Type in a name">
              <table id="myTable">
                <tr class="header">
                  <th>Booked By</th>
                  <th>Lodge Name:</th>
                </tr>
      <?php 
        include("../config/config.php");
            $u_email= $_SESSION["email"];

        $sql3="SELECT * from owner where email='$u_email'";
            $result3=mysqli_query($db,$sql3);

            if(mysqli_num_rows($result3)>0)
          {
              while($rowss=mysqli_fetch_assoc($result3)){
                $owner_id=$rowss['owner_id'];

                $sql2="SELECT * from add_property where owner_id='$owner_id'";
        $result2=mysqli_query($db,$sql2);

        if(mysqli_num_rows($result2)>0)
      {
          while($ro=mysqli_fetch_assoc($result2)){
            $property_id=$ro['property_id'];

        $sql="SELECT * from booking where property_id='$property_id'";
        $result=mysqli_query($db,$sql);
        if(mysqli_num_rows($result)>0)
      {
          while($rows=mysqli_fetch_assoc($result)){
       ?>
                <tr> 
        <?php 
        $tenant_id=$rows['tenant_id'];
        $property_id=$rows['property_id'];
        $sql1="SELECT * from tenant where tenant_id='$tenant_id'";
        $result1=mysqli_query($db,$sql1);

        if(mysqli_num_rows($result1)>0)
      {
          while($row=mysqli_fetch_assoc($result1)){
          
       ?>
        <td><?php echo $row['full_name']; }}?></td>
        <td><?php echo $row['LodgeName']; ?></td>
                </tr>
              <?php 
      }}}}}} ?>
              </table> 
    </div>
    </div>

  </div>
</div>
</body>




<script>
              function viewProperty() {
                var input, filter, table, tr, td, i, txtValue;
                input = document.getElementById("myInput");
                filter = input.value.toUpperCase();
                table = document.getElementById("myTable");
                tr = table.getElementsByTagName("tr");
                th = table.getElementsByTagName("th");
                for (i = 1; i < tr.length; i++) {
                  tr[i].style.display = "none";
                    for(var j=0; j<th.length; j++){
                      td = tr[i].getElementsByTagName("td")[j];      
                      if (td) {
                        if (td.innerHTML.toUpperCase().indexOf(filter.toUpperCase()) > -1)
                        {
                          tr[i].style.display = "";
                          break;
                         }
                      }
                    }
                }
              }
</script>
<script>
              function updateProperty() {
                var input, filter, table, tr, td, i, txtValue;
                input = document.getElementById("myInput");
                filter = input.value.toUpperCase();
                table = document.getElementById("myTable");
                tr = table.getElementsByTagName("tr");
                th = table.getElementsByTagName("th");
                for (i = 1; i < tr.length; i++) {
                  tr[i].style.display = "none";
                    for(var j=0; j<th.length; j++){
                      td = tr[i].getElementsByTagName("td")[j];      
                      if (td) {
                        if (td.innerHTML.toUpperCase().indexOf(filter.toUpperCase()) > -1)
                        {
                          tr[i].style.display = "";
                          break;
                         }
                      }
                    }
                }
              }
</script>
<script>
              function bookedProperty() {
                var input, filter, table, tr, td, i, txtValue;
                input = document.getElementById("myInput");
                filter = input.value.toUpperCase();
                table = document.getElementById("myTable");
                tr = table.getElementsByTagName("tr");
                th = table.getElementsByTagName("th");
                for (i = 1; i < tr.length; i++) {
                  tr[i].style.display = "none";
                    for(var j=0; j<th.length; j++){
                      td = tr[i].getElementsByTagName("td")[j];      
                      if (td) {
                        if (td.innerHTML.toUpperCase().indexOf(filter.toUpperCase()) > -1)
                        {
                          tr[i].style.display = "";
                          break;
                         }
                      }
                    }
                }
              }
</script>
<script>  
 $(document).ready(function(){  
      var i=1;  
      $('#add').click(function(){  
           i++;  
           $('#dynamic_field').append('<tr id="row'+i+'"><td><input type="file" name="p_photo[]" placeholder="Photos" class="form-control name_list" required accept="image/*" /></td></td> <td><button id="'+i+'" class="btn btn-danger btn_remove">X</button></td></tr>'); 
      });  

      $(document).on('click', '.btn_remove', function(){  
           var button_id = $(this).attr("id");   
           $('#row'+button_id+'').remove();  
      }); 

      $('#submit').click(function(){            
           $.ajax({  
                url:"name.php",  
                method:"POST",  
                data:$('#add_name').serialize(),  
                success:function(data)  
                {  
                     alert(data);  
                     $('#add_name')[0].reset();  
                }  
           });  
      });  
 });  
 </script>

 <script>
   if (status == google.maps.GeocoderStatus.OK) {
    map.setCenter(results[0].geometry.location);
    var marker = new google.maps.Marker;
    document.getElementById('Latitude').value = results[0].geometry.location.Latitude();
    document.getElementById('Longitude').value = results[0].geometry.location.Longitude();


   // add this
    var latt=results[0].geometry.location.Latitude();
    var lngg=results[0].geometry.location.Longitude();
    $.ajax({
        url: "your-php-code-url-to-save-in-database",
        dataType: 'json',
        type: 'POST',
        data:{ Latitude: Latitude, Longitude: Longitude },
        success: function(data)     {                
           //check here whether inserted or not 
        }
   });


 }
 </script>


 <script>
  //For Latitude and Longitude
function getLocation() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(showPosition);
  } else { 
    document.getElementById("Latitude").value = "Geolocation is not supported by this browser.";
    document.getElementById("Longitude").value = "Geolocation is not supported by this browser.";
  }
}

function showPosition(position) {
  document.getElementById("Latitude").value = position.coords.Latitude;
  document.getElementById("Longitude").value = position.coords.Longitude;
}
</script>
