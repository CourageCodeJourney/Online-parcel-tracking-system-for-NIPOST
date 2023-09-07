<!DOCTYPE html>
<html lang="en">
<style>
  .header {
      background-color: #107BFF;
      padding: 20px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      width: 100%;
    }

    .header-logo {
      display: flex;
      align-items: center;
    }

    .header-logo img {
      height: 80px;
      margin-right: 10px;
    }

    .header-title {
      font-size: 24px;
      margin: 0;
    }

    .header-links {
      list-style: none;
      margin: 0;
      padding: 0;
      display: flex;
      align-items: center;
    }

    .header-links li {
      margin-left: 20px;
    }

    .header-links a {
      text-decoration: none;
      color: #fff;
      font-size: 16px;
    }

   .footer {
      border: 1px solid #DEE2E6;
      background-color: white;
      color: gray;
      padding: 18px;
      text-align: center;
      position: fixed;
      bottom: 0;
      left: 0;
      width: 100%;
      display: flex;
      justify-content: space-between; /* Aligns items to the left and right */
      align-items: center;
    }

    .footer-left {
      text-align: left;
    }

    .footer-right {
      text-align: right;
    }
</style>
<?php 
session_start();
include('./db_connect.php');
  ob_start();
  // if(!isset($_SESSION['system'])){

    $system = $conn->query("SELECT * FROM system_settings")->fetch_array();
    foreach($system as $k => $v){
      $_SESSION['system'][$k] = $v;
    }
  // }
  ob_end_flush(); 
?>
<?php 
if(isset($_SESSION['login_id']))
header("location:index.php?page=home");

?>
<?php include 'header.php' ?>
<body>
<div class="header">
    <div class="header-logo">
      <img src="nipost logo.png" alt="Nipost Logo"></a>
      <h1 class="header-title" style="color: white;"><strong> NIPOST ONLINE PARCEL TRACKING SYSTEM</h1></strong>
    </div>
    <ul class="header-links">
      <li><a href="homepage.php"><h5>HOME</h5></a></li>
      <li><a href="ABOUT US.html"> <h5>ABOUT US</h5></a></li>
      <li><a href="CONTACT US.html"><h5>CONTACT US</h5></a></li>
    </ul>
  </div>
<div class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <form action="" id="login-form">
        <div class="input-group mb-3">
          <input type="email" class="form-control" name="email" required placeholder="Email">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" name="password" required placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="remember">
              <label for="remember">
                Remember Me
              </label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">LOGIN</button>
          </div>
          <!-- /.col -->
        </div>
      </form>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
</div>
<!-- /.login-box -->
<div class="footer">
    <div class="footer-left">
     <strong>Copyright &copy; 2023 PAUL LABHANI COURAGE</strong>      
    </div>
    <div class="footer-right">
    <strong>NIPOST ONLINE PARCEL TRACKING SYSTEM</strong> 
    </div>
<script>
  $(document).ready(function(){
    $('#login-form').submit(function(e){
    e.preventDefault()
    start_load()
    if($(this).find('.alert-danger').length > 0 )
      $(this).find('.alert-danger').remove();
    $.ajax({
      url:'ajax.php?action=login',
      method:'POST',
      data:$(this).serialize(),
      error:err=>{
        console.log(err)
        end_load();

      },
      success:function(resp){
        if(resp == 1){
          location.href ='index.php?page=home';
        }else{
          $('#login-form').prepend('<div class="alert alert-danger">Username or password is incorrect.</div>')
          end_load();
        }
      }
    })
  })
  })
</script>
<?php include 'footer.php' ?>

</body>
</html>
