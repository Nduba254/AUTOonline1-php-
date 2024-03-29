
<?php 
session_start();
include('includes/config.php');

// initializing variables
$username = "";
$email    = "";
$password_1 = $password_2 = "";
$username_err = $password_1_err = $password_2_err = "";
$errors = array(); 

// connect to the database
$db = mysqli_connect('localhost', 'root', '', 'vehiclepurchase');

// REGISTER USER
if (isset($_POST['submit'])) {
  // receive all input values from the form
  $username = mysqli_real_escape_string($db, $_POST['username']);
  $email = mysqli_real_escape_string($db, $_POST['email']);
  $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
  $password_2 = mysqli_real_escape_string($db, $_POST['password_2']);

  // form validation: ensure that the form is correctly filled ...
  // by adding (array_push()) corresponding error unto $errors array
  if (empty($username)) { array_push($errors, "Username is required"); }
  if (empty($email)) { array_push($errors, "Email is required"); }
  if (empty($password_1)) { array_push($errors, "Password is required"); }
  if ($password_1 != $password_2) {
	array_push($errors, "The two passwords do not match");
  }

  // first check the database to make sure a user does not already exist with the same username and/or email
  $user_check_query = "SELECT * FROM tblusers WHERE username='$username' OR email='$email' LIMIT 1";
  $result = mysqli_query($db, $user_check_query);
  $user = mysqli_fetch_assoc($result);
  
  if ($user) { // if user and/or email exists
    if ($user['username'] === $username) {
      array_push($errors, "Username already exists");
    }

     if ($user['email'] === $email) {
      array_push($errors, "email already exists");
     }
  }

  // Finally, register user if there are no errors in the form
  if (count($errors) == 0) {
  	$password = md5($password_1);//encrypt the password before saving in the database

  	$query = "INSERT INTO tblusers (username, email, password_1, password_2)
  			  VALUES('$username', '$email', '$password' , '$password_1, '$password_2'  )" ;
  	mysqli_query($db, $query);
	  $_SESSION['username'] = $username;
	  $_SESSION['alogin']=$_POST['username'];
  	$_SESSION['success'] = "You are now logged in";
  	header('location: dashboard.php');
  }
}

// ... 

// LOGIN user
if (isset($_POST['login'])) {
  $username = mysqli_real_escape_string($db, $_POST['username']);
  $password = mysqli_real_escape_string($db, $_POST['password_1']);

  if (empty($username)) {
    array_push($errors, "Username is required");
  }
  if (empty($password_1)) {
    array_push($errors, "Password is required");
  }

  if (count($errors) == 0) {
    $password_1 = md5($password_1);
    $query = "SELECT * FROM tblusers WHERE username='$username' AND password='$password'";
    $results = mysqli_query($db, $query);
    if (mysqli_num_rows($results) == 0) {
	 //$_SESSION['username'] = $username;
	  $_SESSION['alogin']=$_POST['username'];
      $_SESSION['success'] = "You are now logged in";
      header('location: dashboard.php');
    }else {
      array_push($errors, "Wrong username/password combination");
    }
  }
}

?>

<div class="modal fade" id="registerform">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3 class="modal-title">Register user</h3>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="signup_wrap">
            <div class="col-md-12 col-sm-6">
              <form  method="POST" name="register" onSubmit="return valid();">
                <div class="form-group">
                  <input type="text" class="form-control" name="username" placeholder="Full Name" required="required">
                </div>
                      <div class="form-group">
                  <input type="text" class="form-control" name="mobileno" placeholder="Mobile Number" maxlength="10" required="required">
                </div>
                <div class="form-group">
                  <input type="email" class="form-control" name="email" id="email" onBlur="checkAvailability()" placeholder="Email Address" required="required">
                   <span id="user-availability-status" style="font-size:12px;"></span> 
                </div>
                <div class="form-group">
                  <input type="password" class="form-control" name="password_1" placeholder="Password" required="required">
                </div>
                <div class="form-group">
                  <input type="password" class="form-control" name="password_2" placeholder="Confirm Password" required="required">
                </div>
                <div class="form-group checkbox">
                  <input type="checkbox" id="terms_agree" required="required" checked="">
                  <label for="terms_agree">I Agree with <a href="#">Terms and Conditions</a></label>
                </div>
                <div class="form-group">
                  <input type="submit" value="Register" name="signup" id="submit" class="btn btn-block">
                </div>
              </form>
            </div>
            
          </div>
        </div>
      </div>
      <div class="modal-footer text-center">
        <p>Already a registered user? <a href="#loginform" data-toggle="modal" data-dismiss="modal">Access your Dashboard!</a></p>
      </div>
    </div>
  </div>
</div>