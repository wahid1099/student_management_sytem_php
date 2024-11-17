<?php
session_start();
if (
  isset($_SESSION['student_id']) &&
  isset($_SESSION['role'])
) {

  if ($_SESSION['role'] == 'Student') {
    include "../DB_connection.php";
    include "../admin/data/student.php";
    include "../admin/data/res_std_course.php";
    include "../admin/data/fee.php";
    include "data/result.php";
    
   

    if (isset($_SESSION['student_id'])) {

      $student_id = $_SESSION['student_id'];

      $student = getStudentById($student_id, $conn);
      $fee = getFeeOfStudent($conn, $student_id);
      if ($fee == null) {
        $fee = 0;
      }
?>

<?php
    include "inc/header.php";
?>

<body>
    <?php
        include "inc/navbar.php";
        if ($student != 0) {
        ?>
    <div class="container mt-5">
        <div class="d-flex justify-content-center align-items-center">
            <div class="card w-50 mb-5 justify-content-center align-items-center">
                <div class="w-25 mt-5">
                    <img src="../img/student-<?= $student['gender'] ?>.png" class="card-img-top" alt="...">
                </div>
                <div class="card-body w-75">
                    <h5 class="card-title text-center">@<?= $student['username'] ?></h5>
                </div>
                <div class="card-body w-100">
                    <ul class="list-group list-group-flush ">
                        <li class="list-group-item">ID: <?= $student['student_id'] ?></li>
                        <li class="list-group-item">Name: <?= $student['fname'] . " " . $student['lname'] ?></li>
                        <li class="list-group-item">Username: <?= $student['username'] ?></li>
                        <li class="list-group-item">Address: <?= $student['address'] ?></li>
                        <li class="list-group-item">Date of birth: <?= $student['date_of_birth'] ?></li>
                        <li class="list-group-item">Email address: <?= $student['email_address'] ?></li>
                        <li class="list-group-item">Gender: <?= $student['gender'] ?></li>
                        <li class="list-group-item">Department: <?= $student['department'] ?></li>
                        <li class="list-group-item">Semester: <?= $student['semester'] ?></li>
                        <li class="list-group-item">Year: <?= $student['year'] ?></li>
                        <li class="list-group-item">Intake: <?= $student['intake'] ?></li>
                        <li class="list-group-item">Section: <?= $student['section'] ?></li>
                        <li class="list-group-item">Parent name:
                            <?= $student['parent_fname'] . " " . $student['parent_lname'] ?></li>
                        <li class="list-group-item">Parent phone number: <?= $student['parent_phone_number'] ?></li>
                        <li class="list-group-item">Register Courses:
                            <?php
                              // Get courses for the teacher
                            $courses = getStudentCourse($conn, $student['student_id']);

                              // Display course names
                            if ($courses) {
                                  echo "<ul>"; // Start unordered list
                                  foreach ($courses as $course) {
                                      echo "<li>" . $course['courseTitle'] . "</li>"; // Display each course name
                                  }
                                  echo "</ul>"; // End unordered list
                            } else {
                                  echo "0";
                            }
                            ?>

                        </li>
                        <li class="list-group-item">Complete Courses:
                          <?php
                            $competeCourses = getStudentCompleteCourse($conn, $student['student_id']);
                            echo htmlspecialchars($competeCourses);
                            ?>
                        </li>
                        <li class="list-group-item">Demand: <?= $fee ?></li>
                        <li class="list-group-item">Cgpa: 
                      <?php 
                        $cgpa = getCgpa($conn, $student['student_id']);
                        if($cgpa){
                          echo htmlspecialchars($cgpa);
                        }else{
                          echo htmlspecialchars("0.0");
                        }
                        ?>
                     </li>

                    </ul>
                </div>

                <div class="card-body">
                    <a href="index.php" class="card-link btn bg-primary text-white">Go Back</a>
                </div>
            </div>
        </div>
    </div>
    <?php
        } else {
          header("Location: teacher.php");
          exit;
        }
        ?>

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
      header("Location: student.php");
      exit;
    }
  } else {
    header("Location: ../login.php");
    exit;
  }
} else {
  header("Location: ../login.php");
  exit;
}

?>