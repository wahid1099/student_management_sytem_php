<?php 
session_start();
if (isset($_SESSION['admin_id']) && 
    isset($_SESSION['role'])) {

    if ($_SESSION['role'] == 'Admin') {

      if (isset($_POST['dep']) &&
        isset($_POST['sem']) && 
        isset($_POST['year']) &&
        isset($_POST['section']) &&
        isset($_POST['intake'])
        ) {
        
        include '../../DB_connection.php';
        include '../data/res_std_course.php';

        

        $department = $_POST['dep'];
        $semester = $_POST['sem'];
        $year = $_POST['year'];
        $section = $_POST['section'];
        $intake = $_POST['intake'];


        if (empty($department)) {
          $em  = "Department name is required";
          header("Location: ../course-add.php?error=$em");
          exit;
        }else if(empty($semester)) {
          $em  = "Semester code is required";
          header("Location: ../course-add.php?error=$em");
          exit;
        }else if (empty($year)) {
          $em  = "Year is required";
          header("Location: ../course-add.php?error=$em");
          exit;
        }else if (empty($section)) {
          $em  = "Section is required";
          header("Location: ../course-add.php?error=$em");
          exit;
        }else {
       
          $studentsForReg = getStudentForReg($conn, $department, $semester, $year, $intake);
          
          // Check if data is found
          if (!empty($studentsForReg)) {
            
            //Select semester no for this year
            $sql = "SELECT semno FROM sem_course_list WHERE dept=? AND year=? AND semester=? AND intake=?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$department, $year, $semester, $intake]);
            
            if ($stmt->rowCount() > 0){
                  $semno = $stmt->fetch(); // Fetch the first row
                  $semno = $semno['semno'];
                  $sql = "SELECT courseCode,courseTitle,credit FROM courses WHERE semester=?";
                  $stmt = $conn->prepare($sql);
                  $stmt->execute([$semno]);
                  $courses = $stmt->fetchAll(PDO::FETCH_ASSOC);

            }else{
              $em  = "No Semester found for Specified Query";
              header("Location: ../course-add.php?error=$em");
              exit;
            }
          
            
            //Select subject List for selected semester

            $flag =0;
            // Print or process the data
            foreach ($studentsForReg as $student) {
              $student_id = $student['student_id'];
              $student_name = $student['fname'] . " " . $student['lname'];
              
              $sql = "SELECT std_id FROM register_std_course WHERE std_id=?";
              $stmt = $conn->prepare($sql);
              $stmt->execute([$student_id]);

              if (!($stmt->rowCount() > 0)) {
                //seclect each the students who not registered yet
                

                if (!empty( $courses)) {
                  foreach ($courses as $course) {
                      $courseCode = $course['courseCode']; 
                      $courseTitle = $course['courseTitle'];
                      $courseCredit = $course['credit'];

                      $sql = "INSERT INTO register_std_course(std_id, std_name, courseTitle, courseCode, credit, semester, year, semester_no, department, section, intake) 
                      VALUES (?,?,?,?,?,?,?,?,?,?,?)";
                      $stmt = $conn->prepare($sql);
                      $result = $stmt->execute([$student_id, $student_name, $courseTitle, $courseCode,$courseCredit, $semester, $year,$semno, $department, $section, $intake]);
                      if ($result) {
                        if ($stmt->rowCount() > 0) {
                          $flag=1; 
                        }
                      }else {
                        echo "Error: " . $stmt->errorInfo()[2];
                      }

                      //testing purposes
                      //////////////////////////////////////////////////
                      // echo "Student Id:" . $student_id . "<br>";
                      // echo "Student Nmae: " . $student_name . "<br>";
                      // echo "Department: " . $department . "<br>";;
                      // echo "Semester: " . $semester . "<br>";;
                      // echo "year: " . $year . "<br>";;
                      // echo "Course Code: " . $courseCode . "<br>";
                      // echo "Course Title: " .$courseTitle . "<br>";
                      // echo "Credit: " . $courseCredit . "<br>";
                      // echo "Semester No: " . $semno . "<br>";
                      // echo "Intake No: " . $intake . "<br>";
                      // echo "Section No: " . $section . "<br>";


                      // echo "<br>";
                    }
                  } else {
                    $em  = "No courses found for the specified semester.";
                    header("Location: ../course-add.php?sucssfull=$em");
                    exit;
                  }
              }
            }
            
            if($flag==1){
              $em  = "Course added successfully.";
              header("Location: ../course-add.php?success=$em");
              exit;
            }else{
              $em  = "Already Added All Students For This Program";
              header("Location: ../course-add.php?error=$em");
              exit;
            }

          } else {
            $em  = "No Student found for Specified Query";
            header("Location: ../course-add.php?error=$em");
            exit;
          }

                          
        }
    }
  }
}