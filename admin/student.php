<?php
session_start();
if (
  isset($_SESSION['admin_id']) &&
  isset($_SESSION['role'])
) {

  if ($_SESSION['role'] == 'Admin') {
    include "../DB_connection.php";
    include "data/student.php";
    include "data/fee.php";
    $students = getAllStudents($conn);
?>
    <?php
    include "req/header.php";
    ?>

    <body>
      <?php
      include "inc/navbar.php";
      if ($students != 0) {
      ?>
        <div class="container mt-5">
          <a href="student-add.php" class="btn btn-dark">Add New Student</a>
          <form action="student-search.php" class="mt-3 n-table" method="get">
            <div class="input-group mb-3">
              <input type="text" class="form-control" name="searchKey" placeholder="Search...">
              <button class="btn btn-primary">
                <i class="fa fa-search" aria-hidden="true"></i>
              </button>
            </div>
          </form>

          <?php if (isset($_GET['error'])) { ?>
            <div class="alert alert-danger mt-3 n-table" role="alert">
              <?= $_GET['error'] ?>
            </div>
          <?php } ?>

          <?php if (isset($_GET['success'])) { ?>
            <div class="alert alert-info mt-3 n-table" role="alert">
              <?= $_GET['success'] ?>
            </div>
          <?php } ?>

          <div class="table-responsive">
            <table class="table table-bordered mt-3 n-table">
              <thead>
                <tr>
                  <th scope="col">ID</th>
                  <th scope="col">Name</th>
                  <th scope="col">Username</th>
                  <th scope="col">Depatment</th>
                  <th scope="col">Semester</th>
                  <th scope="col">Year</th>
                  <th scope="col">Section</th>
                  <th scope="col">Intake</th>
                  <th scope="col">Parent&nbsp;Name</th>
                  <th scope="col">Parent&nbsp;Phone</th>
                  <th scope="col">Total&nbsp;Demand</th>
                  <th scope="col">Action</th>
                </tr>
              </thead>
              <tbody>
                  <?php 
                    foreach ($students as $student) {
                      $std_id = $student['student_id'];
                      $fee = getFeeOfStudent($conn, $std_id);                      
                      if($fee==null) {
                        $fee = 0;
                      }
                    ?>
                  <tr>

                    <td><?= $student['student_id'] ?></td>
                    <td>
                      <a href="student-view.php?student_id=<?= $student['student_id'] ?>">
                        <?= $student['fname'] . '&nbsp' . $student['lname'] ?>
                      </a>
                    </td>

                    
                    <td><?= $student['username'] ?></td>
                    <td><?= $student['department'] ?></td>
                    <td><?= $student['semester'] ?></td>
                    <td><?= $student['year'] ?></td>
                    <td><?= $student['section'] ?></td>
                    <td><?= $student['intake'] ?></td>
                    <td><?= $student['parent_lname'] ?></td>
                    <td><?= $student['parent_phone_number'] ?></td>
                    <td><?= $fee ?></td>

                    <td>
                      <a href="student-edit.php?student_id=<?= $student['student_id'] ?>" class="btn btn-warning mb-2">Edit</a>
                      <a href="student-delete.php?student_id=<?= $student['student_id'] ?>" class="btn btn-danger">Delete</a>
                    </td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        <?php } else { ?>
          <div class="alert alert-info .w-450 m-5" role="alert">
            Empty!
          </div>
        <?php } ?>
        </div>

        <script src="../js/bootstrap.bundle.min.js"></script>
        <script>
          $(document).ready(function() {
            $("#navLinks li:nth-child(3) a").addClass('active');
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