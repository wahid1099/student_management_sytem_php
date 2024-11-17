<?php 
session_start();
if (isset($_SESSION['student_id']) && 
    isset($_SESSION['role'])) {

    if ($_SESSION['role'] == 'Student') {
       include "../DB_connection.php";
       include "data/student.php";
       include "data/subject.php";
       include "data/result.php";
       

       $student_id = $_SESSION['student_id'];

       $student = getStudentById($student_id, $conn);
 ?>

<?php
   include "inc/header.php";
?>

<body>
    <?php 
        include "inc/navbar.php";
     ?>
    <?php 
        if ($student != 0) {
     ?>
    <div class="container">
        <div class="row">
            <div class="col-4 mt-5 mb-5" style="margin-left: -50px">

                <div class="card" style="width: 22rem;">
                    <div class="justify-content-center" style="text-align: center;">
                        <img src="../img/student-<?=$student['gender']?>.png" class="card-img-top w-75" alt="...">
                    </div>
                    <div class="card-body">
                        <h5 class="card-title text-center">@<?=$student['username']?></h5>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">Name: <?=$student['fname'] . " " . $student['lname']?></li>
                        <li class="list-group-item">Username: <?=$student['username']?></li>
                        <li class="list-group-item">Address: <?=$student['address']?></li>
                        <li class="list-group-item">Date of birth: <?=$student['date_of_birth']?></li>
                        <li class="list-group-item">Email address: <?=$student['email_address']?></li>
                        <li class="list-group-item">Gender: <?=$student['gender']?></li>
                        <li class="list-group-item">Date of joined: <?=$student['date_of_joined']?></li>

                        <li class="list-group-item">Department: <?=$student['department']?></li>
                        <li class="list-group-item">Semester: <?=$student['semester']?></li>
                        <li class="list-group-item">Section: <?=$student['year']?></li>
                        <li class="list-group-item">Parent first name: <?=$student['parent_fname']?></li>
                        <li class="list-group-item">Parent last name: <?=$student['parent_lname']?></li>
                        <li class="list-group-item">Parent phone number: <?=$student['parent_phone_number']?></li>
                        <li class="list-group-item"><b>CGPA:</b>
                        <?php 
                        $cgpa = getCgpa($conn, $student_id);
                        if($cgpa){
                            echo "<b>" . htmlspecialchars($cgpa) . "</b>";
                        }else{
                          echo htmlspecialchars("0.0");
                        }
                        ?></li>
                    </ul>
                </div>

            </div>

            <div class="col-8"  style="padding-top:150px; padding-left:50px">
                <div class="row">
                <div class="col-6 ">
                        <a href="student-profile.php" class="link-dark" style="text-decoration:none;">
                            <div class="card bg-c-pink order-card bg-dark text-white" style="border-radius: 10px;">
                                <div class="card-block pt-5 py-5 text-center">
                                <i class="fa fa fa-user fs-1 mb-1" aria-hidden="true"></i><br>
                                <h5>PROFILE</h5>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="register-course.php" style="text-decoration:none;"
                            class="link-dark link-underline-dark">
                            <div class="card bg-c-pink order-card bg-dark text-white" style="border-radius: 10px; ">
                                <div class="card-block pt-5 py-5 text-center">
                                <i class="fa fa-book fs-1 mb-1" aria-hidden="true"></i><br>
                                <h5>REGISTER COURSES</h5>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-6 mt-4">
                        <a href="fee.php" style="text-decoration:none;" class="link-dark link-underline-dark">
                            <div class="card bg-c-pink order-card bg-info bg-dark text-white"
                                style="border-radius: 10px;">
                                <div class="card-block pt-5 py-5 text-center">
                                <i class="fa-solid fa-comment-dollar fs-1 mb-1" aria-hidden="true"></i><br>
                                <h5>FEES</h5>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-6 mt-4">
                        <a href="result.php" style="text-decoration:none;" class="link-dark link-underline-dark">
                            <div class="card bg-c-pink order-card bg-dark text-white" style="border-radius: 10px;">
                                <div class="card-block pt-5 py-5 text-center">
                                <i class="fa-solid fa-square-poll-vertical fs-1 mb-1" aria-hidden="true"></i><br>
                                <h5>Result</h5>
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
          header("Location: student.php");
          exit;
        }
     ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
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