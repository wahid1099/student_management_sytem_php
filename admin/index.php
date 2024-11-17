<?php 
session_start();
if (isset($_SESSION['admin_id']) && 
    isset($_SESSION['role'])) {

    if ($_SESSION['role'] == 'Admin') {
 ?>
<?php 
        include "req/header.php";
?> 

<body>
    <?php 
        include "inc/navbar.php";
     ?>
    <div class="container mt-5">
        <div class="container text-center">
            <div class="row row-cols-4">
                <a href="student.php" class="col btn btn-dark m-2 py-3">
                    <i class="fa fa-graduation-cap fs-1" aria-hidden="true"></i><br>
                    Students
                </a>
                <a href="teacher.php" class="col btn btn-dark m-2 py-3">
                    <i class="fa fa-user-md fs-1" aria-hidden="true"></i><br>
                    Teachers
                </a>
                <a href="add_fee.php" class="col btn btn-dark m-2 py-3">
                  <i class="fa-solid fa-comment-dollar fs-1" aria-hidden="true"></i><br>
                    Add Fee
                </a>

                <a href="course-add.php" class="col btn btn-dark m-2 py-3">
                    <i class="fa fa-book fs-1" aria-hidden="true"></i><br>
                    Course Registration
                </a>
                <a href="message.php" class="col btn btn-dark m-2 py-3">
                    <i class="fa fa-envelope fs-1" aria-hidden="true"></i><br>
                    Message
                </a>
                <a href="settings.php" class="col btn btn-dark m-2 py-3">
                    <i class="fa fa-cogs fs-1" aria-hidden="true"></i><br>
                    Settings
                </a>
                <a href="../logout.php" class="col btn btn-warning m-2 py-3">
                    <i class="fa fa-sign-out fs-1" aria-hidden="true"></i><br>
                    Sign Out
                </a>
            </div>
        </div>
    </div>

    <script src="../js/bootstrap.bundle.min.js"></script>
    <script>
    $(document).ready(function() {
        $("#navLinks li:nth-child(1) a").addClass('active');
    });
    </script>

</body>

</html>
<?php 

  }else {
    header("Location: ../login.php");
    exit;
  } 
}else {
	header("Location: ../login.php");
	exit;
} 

?>