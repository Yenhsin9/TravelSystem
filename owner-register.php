<?php 

include("navbar.php");

 ?>

<div class="container">
  <h3 style="font-weight: bold; text-align: center;">Owner Register</h3><hr><br>
  <form method="POST" action="owner-engine.php" enctype="multipart/form-data">
    <div class="form-group">
      <label for="full_name">Full Name:</label>
      <input type="text" class="form-control" id="full_name" placeholder="Enter Full Name" name="full_name" required>
    </div>
    <div class="form-group">
      <label for="email">Email:</label>
      <input type="email" class="form-control" id="email" placeholder="Enter Email" name="email" required>
    </div>
    <div class="form-group">
      <label for="password1">Password:</label>
      <input type="password" class="form-control" id="password1" placeholder="Enter Password" name="password" required>
    </div>
    <div class="form-group">
      <label for="password2">Confirm Password:</label>
      <input type="password" class="form-control" id="password2" placeholder="Enter Password Again" required>
    </div>
    <div class="form-group">
      <label for="phone_no">Phone No.:</label>
      <input type="text" class="form-control" id="phone_no" placeholder="Enter Phone No." name="phone_no" required>
    </div>

    <hr>
    <center><button id="submit" name="owner_register" class="btn btn-primary btn-block" onclick="return Validate()">Register</button></center><br>
    <div class="form-group text-right">
      <label class="">Register as a <a href="tenant-register.php">Tenant</a>?</label><br>
    </div><br><br>
  </form>
</div>

<script type='text/javascript'>
        function preview_image(event)
        {
            var reader = new FileReader();
            reader.onload = function()
            {
                var output = document.getElementById('output_image');
                output.src = reader.result;
            }
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
    <script type="text/javascript">
    function Validate() {
        var password = document.getElementById("password1").value;
        var confirmPassword = document.getElementById("password2").value;
        if (password != confirmPassword) {
            alert("Passwords do not match.");
            return false;
        }
        return true;
    }
</script>