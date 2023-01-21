<?php
session_start();
if (!isset($_SESSION['is_login']) && !$_SESSION['is_login']) {
  header('Location:login.php');
} else {
  $user = $_SESSION['name'];
}
?>

<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">

<?php
include "partial/header.php";
?>

<body class="vertical-layout vertical-menu-modern 2-columns   menu-expanded fixed-navbar" data-open="click" data-menu="vertical-menu-modern" data-col="2-columns">
  <!-- fixed-top-->
  <?php include "partial/nav.php" ?>
  <?php include "partial/sidebar.php" ?>
  <!-- ////////////////////////////////////////////////////////////////////////////-->
  <div class="app-content content">
    <div class="content-wrapper">
      <div class="content-header row">
      </div>
      <div class="content-body">
        <!-- Basic form layout section start -->
        <section id="basic-form-layouts">
          <div class="row match-height">
            <div class="col-md-12">
              <div class="card d-flex align-items-center justify-content-center">
                <div class="card-header">
                  <!-- user name -->
                  <h1 class="card-title font-weight-bold" style='font-size:2.5rem' id="basic-layout-form">Welcome: <?php echo $user; ?></h1>
                  <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>

                </div>
                <div class="card-content collapse show ">
                  <div class="card-body">
                    <p>Welcome in Books Friends Store Dashboard</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
        <!-- // Basic form layout section end -->
      </div>
    </div>
  </div>
  <!-- //////////////////////////////////////////////////////////////////////////// -->


  <!-- ////////////////////////////////////////////////////////////////////////////-->
  <?php
  include "partial/footer.php";
  ?>
</body>

</html>