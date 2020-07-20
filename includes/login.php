
<?php
session_start();
include('includes/config.php');

//if form is submitted or not
//if the form is submitted
if(isset($_POST['login']))
{
  $email = mysqli_real_escape_string($db,$_POST['email']);
  $password_1 = mysqli_real_escape_string($db,$_POST['password_1']); 

            $sql ="SELECT email,Password_1 FROM tblusers WHERE email=:email and password =:password_1";
               $result = mysqli_query($dbh,$sql);
               $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
               $active = $row['active'];
               
               $count = mysqli_num_rows($result);
               
               // If result matched $email and $password_1, table row must be 1 row
             
               if($count == 1) {
                  session_register("email");
                  $_SESSION['login'] = $email;
                  
                  header("location: dashboard.php");
               }else {
                  $error = "Your Login email or Password is invalid";
               }
            }
         ?>

<div class="modal fade" id="loginform">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button"  class="close" data-dismiss="modal" aria-label="Close">
        <!--close pop up-->
        <span aria-hidden="true">&times;</span>
        </button>
        <h3 class="modal-title">Login</h3>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="login_wrap">
            <div class="col-md-12 col-sm-6">
              <form method="post" action="login.php">
                <div class="form-group">
                  <input type="email" class="form-control" name="email" placeholder="Email address*">
                </div>
                <div class="form-group">
                  <input type="password" class="form-control" name="password" placeholder="Password*">
                </div>
                <div class="form-group checkbox">
                  <input type="checkbox" id="remember">
               
                </div>
                <div class="form-group">
                  <input type="submit" name="login" value="Login" class="btn btn-block">
                </div>
              </form>
            </div>
           
          </div>
        </div>
      </div>
      <div class="modal-footer text-center">
        <p>Don't have an account? <a href="#registerform" data-toggle="modal" data-dismiss="modal">Register as a new user Here</a></p>
        <p><a href="#forgotpassword" data-toggle="modal" data-dismiss="modal">Forgot Password ?</a></p>
      </div>
    </div>
  </div>
</div>