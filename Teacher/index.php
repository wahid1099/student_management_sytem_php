<?php
session_start();
if (isset($_SESSION['teacher_id']) &&
    isset($_SESSION['role'])) {

    if ($_SESSION['role'] == 'Teacher') {
       include "../DB_connection.php";
       include "data/teacher.php";
       include "data/subject.php";
       include "data/grade.php";
       include "data/section.php";
       include "data/class.php";


       $teacher_id = $_SESSION['teacher_id'];
       $teacher = getTeacherById($teacher_id, $conn);
 ?>


<?php 
        include "inc/header.php";
?>

<body>
    <?php
        include "inc/navbar.php";

        if ($teacher != 0) {
     ?>
    <div class="container">
        <div class="row">

            <div class="col-4 mt-5 mb-5" style="margin-left: -50px">
                <div class="row">
                    <div class="card" style="width: 22rem;">
                        <img src="../img/teacher-<?=$teacher['gender']?>.png" class="card-img-top"
                            style="padding-top:10px" alt="...">
                        <div class="card-body bg-color">
                            <h5 class="card-title text-center">@<?=$teacher['username']?></h5>
                        </div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">First name: <?=$teacher['fname']?></li>
                            <li class="list-group-item">Last name: <?=$teacher['lname']?></li>
                            <li class="list-group-item">Username: <?=$teacher['username']?></li>

                            <li class="list-group-item">Employee number: <?=$teacher['employee_number']?></li>
                            <li class="list-group-item">Address: <?=$teacher['address']?></li>
                            <li class="list-group-item">Date of birth: <?=$teacher['date_of_birth']?></li>
                            <li class="list-group-item">Phone number: <?=$teacher['phone_number']?></li>
                            <li class="list-group-item">Qualification: <?=$teacher['qualification']?></li>
                            <li class="list-group-item">Email address: <?=$teacher['email_address']?></li>
                            <li class="list-group-item">Gender: <?=$teacher['gender']?></li>
                            <li class="list-group-item">Date of joined: <?=$teacher['date_of_joined']?></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-8" style="padding-top:150px">
                <div class="row" style="margin-left:50px">

                    <div class="col-6 ">
                        <a href="teacher-profile.php" class="link-dark" style="text-decoration:none;">
                            <div class="card bg-c-pink order-card bg-dark text-white" style="border-radius: 10px;">
                                <div class="card-block pt-5 py-5 text-center">
                                    <i class="fa fa fa-user fs-1 mb-1" aria-hidden="true"></i><br>
                                    <h5>PROFILE</h5>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="selectForResult.php" style="text-decoration:none;"
                            class="link-dark link-underline-dark">
                            <div class="card bg-c-pink order-card bg-dark text-white" style="border-radius: 10px; ">
                                <div class="card-block pt-5 py-5 text-center">
                                    <i class="fa-solid fa-square-poll-vertical fs-1 mb-1" aria-hidden="true"></i><br>
                                    <h5>ADD RESULT</h5>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-6 mt-4">
                        <a href="pass.php" style="text-decoration:none;" class="link-dark link-underline-dark">
                            <div class="card bg-c-pink order-card bg-info bg-dark text-white"
                                style="border-radius: 10px;">
                           
                                <div class="card-block pt-5 py-5 text-center">
                                    <i class="fa fa-cog fs-1 mb-1" aria-hidden="true"></i><br>
                                    <h5>CHANGE PASSOWRD</h5>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-6 mt-4">
                        <a href="../other.php" style="text-decoration:none;" class="link-dark link-underline-dark">
                            <div class="card bg-c-pink order-card bg-dark text-white" style="border-radius: 10px;">
                          
                        
                                <div class="card-block pt-5 py-5 text-center">
                                    <i class="fa fa-sign-out  fs-1 mb-1" aria-hidden="true"></i><br>
                                    <h5>SIGN OUT</h5>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <?php
        }else {
          header("Location: logout.php?error=An error occurred");
          exit;
        }
     ?>

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
    header("Location: ../other.php");
    exit;
  }
}else {
	header("Location: ../other.php");
	exit;
}

?>