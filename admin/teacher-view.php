<?php 
session_start();
if (isset($_SESSION['admin_id']) && 
    isset($_SESSION['role'])) {

    if ($_SESSION['role'] == 'Admin') {
       include "../DB_connection.php";
       include "data/teacher.php";
       include "data/tech_course.php";
       if(isset($_GET['teacher_id'])){

       $teacher_id = $_GET['teacher_id'];

       $teacher = getTeacherById($teacher_id,$conn);    
 ?>
<?php 
        include "req/header.php";
?> 

<body>
    <?php 
        include "inc/navbar.php";
        if ($teacher != 0) {
     ?>
     <div class="container mt-5">
          <div class="d-flex justify-content-center align-items-center">
          <div class="card w-50 mb-5 justify-content-center align-items-center">
            <div class="w-25 mt-5">
            <img src="../img/teacher-<?=$teacher['gender']?>.png" class="card-img-top" alt="...">
            </div>
          
          <div class="card-body w-75">
            <h5 class="card-title text-center">@<?=$teacher['username']?></h5>
          </div>
          <div class="card-body w-100">
          <ul class="list-group list-group-flush">
          <li class="list-group-item">Id: <?=$teacher['teacher_id']?></li>
            <li class="list-group-item">Name: <?=$teacher['fname'] . " " . $teacher['lname']?></li>
        
            <li class="list-group-item">Username: <?=$teacher['username']?></li>

            <li class="list-group-item">Employee number: <?=$teacher['employee_number']?></li>
            <li class="list-group-item">Address: <?=$teacher['address']?></li>
            <li class="list-group-item">Date of birth: <?=$teacher['date_of_birth']?></li>
            <li class="list-group-item">Phone number: <?=$teacher['phone_number']?></li>
            <li class="list-group-item">Qualification: <?=$teacher['qualification']?></li>
            <li class="list-group-item">Email address: <?=$teacher['email_address']?></li>
            <li class="list-group-item">Gender: <?=$teacher['gender']?></li>
            <li class="list-group-item">Date of joined: <?=$teacher['date_of_joined']?></li>
            <li class="list-group-item">Taken Course

            <?php
              // Get courses for the teacher
              $courses = getCoursesByTeacherId($teacher['teacher_id'], $conn);

              // Display course names
              if ($courses) {
                  echo "<ul>"; // Start unordered list
                  foreach ($courses as $course) {
                      echo "<li>" . $course['course_name'] . "</li>"; // Display each course name
                  }
                  echo "</ul>"; // End unordered list
              } else {
                  echo "No courses found for this teacher.";
              }
              ?>

            </li>
            <li class="list-group-item"></li>
          </ul>
          </div>
          
          <div class="card-body">
            <a href="teacher.php" class="card-link">Go Back</a>
          </div>
        </div>
          </div>
     </div>
     <?php 
        }else {
          header("Location: teacher.php");
          exit;
        }
     ?>
     
     <script src="../js/bootstrap.bundle.min.js"></script>		
    <script>
        $(document).ready(function(){
             $("#navLinks li:nth-child(4) a").addClass('active');
        });
    </script>

</body>
</html>
<?php 

    }else {
        header("Location: teacher.php");
        exit;
    }

  }else {
    header("Location: ../login.php");
    exit;
  } 
}else {
	header("Location: ../login.php");
	exit;
} 

?>