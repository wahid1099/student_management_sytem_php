<?php
session_start();


// Retrieve data from session variables
$department = $_SESSION['department'];
$semester = $_SESSION['semester'];
$year = $_SESSION['year'];
$intake = $_SESSION['intake'];
$section = $_SESSION['section'];

$_SESSION['department'] = $department;
$_SESSION['semester'] = $semester;
$_SESSION['year'] = $year;
$_SESSION['intake'] = $intake;
$_SESSION['section'] = $section;

if (
  isset($_SESSION['admin_id']) &&
  isset($_SESSION['role'])
) {

  if ($_SESSION['role'] == 'Admin') {
    include '../DB_connection.php';
?>


    <?php
    include "req/header.php";
    ?>

    <body>
      <?php
      include "inc/navbar.php";
      ?>
      <div class="container mt-5">

        <form method="post" class="shadow p-3 mt-5 form-w" action="req/addSectionFee.php">

          <h3>Enter Amount For Each Sector</h3>
          <hr>
          <?php if (isset($_GET['error'])) { ?>
            <div class="alert alert-danger" role="alert">
              <?= $_GET['error'] ?>
            </div>
          <?php } ?>
          <?php if (isset($_GET['success'])) { ?>
            <div class="alert alert-success" role="alert">
              <?= $_GET['success'] ?>
            </div>
          <?php } ?>

          <div class="mb-3">
            <label class="form-label">Credit Cost</label>
            <input type="text" class="form-control" name="tution_fee">
          </div>
          <div class="mb-3">
            <label class="form-label">Lab Fee</label>
            <input type="text" class="form-control" name="lab_fee">
          </div>
          <div class="mb-3">
            <label class="form-label">Library Fee</label>
            <input type="text" class="form-control" name="lib_fee">
          </div>
          <div class="mb-3">
            <label class="form-label">Medical Fee</label>
            <input type="text" class="form-control" name="medical_fee">
          </div>
          <div class="mb-3">
            <label class="form-label">Other Fee</label>
            <input type="text" class="form-control" name="other_fee">
          </div>
          <button type="submit" class="btn btn-primary">Add Fee</button>
        </form>
      </div>


      <script src="../js/bootstrap.bundle.min.js"></script>
      <script>
        $(document).ready(function() {
          $("#navLinks li:nth-child(6) a").addClass('active');
        });
      </script>

    </body>

    </html>
<?php

  } else {
    header("Location: ../login.php");
    exit;
  }
} else {
  header("Location: ../login.php");
  exit;
}

?>