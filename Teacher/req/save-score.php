<?php 
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}
if (isset($_SESSION['teacher_id']) && 
    isset($_SESSION['role'])) {

    if ($_SESSION['role'] == 'Teacher') {
    	

if (isset($_SESSION['dep']) &&
    isset($_SESSION['sem']) &&
    isset($_SESSION['year']) &&
    isset($_SESSION['sec']) &&
    isset($_SESSION['int']) &&
    isset($_SESSION['course']) &&
    isset($_SESSION['courseCode']) &&
    isset($_SESSION['credit']) &&
    isset($_POST['std_id']) &&
    isset($_POST['std_name']) &&
    isset($_POST['mark']
    )
    ) {
   
    $dep = $_SESSION['dep'];
    $sem = $_SESSION['sem']; 
    $year = $_SESSION['year'];
    $sec = $_SESSION['sec'];
    $int = $_SESSION['int'];
    $course = $_SESSION['course'];
    $courseCode = $_SESSION['courseCode'];
    $std_ids = $_POST['std_id'];
    $std_names = $_POST['std_name'];
    $marks = $_POST['mark'];
    $credit = $_SESSION["credit"];
    $teacher_id = $_SESSION['teacher_id'];

    include '../../DB_connection.php';
    include '../data/result.php';

    
    

    //$alreaydAdd = selectStudentAlreadyAdded($std_id, $course_code, $conn);

    for ($i = 0; $i < count($std_ids); $i++) {
      if (empty($marks[$i])) {
        $em = "Mark is required for all students";
        header("Location: ../selectForResult.php?error=$em");
        exit();
      }
      
    }
   
    for ($i = 0; $i < count($std_ids); $i++) {
      $std_id = $std_ids[$i];
      $std_name = $std_names[$i];
      $mark = $marks[$i];
      $grade = getGrade($mark);
      $sql = "INSERT INTO result (tech_id, std_id, department, courseName, courseCode, credit, semester, year, section, intake, mark, grade)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

      $stmt = $conn->prepare($sql);

      // Bind parameters
      $stmt->bindParam(1, $teacher_id);
      $stmt->bindParam(2, $std_id);
      $stmt->bindParam(3, $dep);
      $stmt->bindParam(4, $course);
      $stmt->bindParam(5, $courseCode);
      $stmt->bindParam(6, $credit);
      $stmt->bindParam(7, $sem);
      $stmt->bindParam(8, $year);
      $stmt->bindParam(9, $sec);
      $stmt->bindParam(10, $int);
      $stmt->bindParam(11, $mark);
      $stmt->bindParam(12, $grade);

      // Execute the statement
      $stmt->execute();

    

      



      $delet_sql = "DELETE FROM register_std_course 
        WHERE std_id=? AND courseCode=? AND semester=? AND department=? AND year=?";

      $delet_stmt = $conn->prepare($delet_sql);

      // Bind parameters
      $delet_stmt->bindParam(1, $std_id);
      $delet_stmt->bindParam(2, $courseCode);
      $delet_stmt->bindParam(3, $sem);
      $delet_stmt->bindParam(4, $dep);
      $delet_stmt->bindParam(5, $year);

      $delet_stmt->execute();
    }
      
      // Optionally, check if the insertion was successful
      if ($stmt->rowCount() > 0) {
        $em = "Successfully inserted";

        $sql = "DELETE FROM tech_reg_courses 
        WHERE teacher_id=? AND course_code=? AND semester=? AND department=? AND year=? AND section=? AND intake=?";
        $stmt = $conn->prepare($sql);

        // Bind parameters
        $stmt->bindParam(1, $teacher_id);
        $stmt->bindParam(2, $courseCode);
        $stmt->bindParam(3, $sem);
        $stmt->bindParam(4, $dep);
        $stmt->bindParam(5, $year);
        $stmt->bindParam(6, $sec);
        $stmt->bindParam(7, $int);

        // Execute the statement
        $stmt->execute();

        $sql = "DELETE FROM register_std_course 
        WHERE courseCode=? AND semester=? AND department=? AND year=? AND section=? AND intake=?";

        $stmt->bindParam(2, $courseCode);
        $stmt->bindParam(3, $sem);
        $stmt->bindParam(4, $dep);
        $stmt->bindParam(5, $year);
        $stmt->bindParam(6, $sec);
        $stmt->bindParam(7, $int);

        for ($i = 0; $i < count($std_ids); $i++){
          $studentSem = selectStudentSem($conn, $std_id);   
          $currentSemester = $studentSem['semester'];
          $currentYear = $studentSem['year'];
          $std_id = $std_ids[$i];

          if(isResultFullPublished($conn, $std_id)){
            
            $sqlFeeDelete = "DELETE FROM fee WHERE std_id=?";
            $stmtDelete = $conn->prepare($sqlFeeDelete);
            $stmtDelete->execute([$std_id]);
            
            $results = getStudentResult($conn, $std_id, $sem, $year );
            $creditCount = 0;
            $calculatePoint=0;
            foreach ($results as $result) {
                $point = getGradePoint($result['mark']);
                $credit = $result['credit'];
                $calculatePoint += ($point * $credit);
                $creditCount += $credit;
            }
           
            $sgpa = round($calculatePoint / $creditCount, 2);
            $sqlstmt = "INSERT INTO gpa(std_id, department, semester, year, intake, sgpa)
            VALUES (?, ?, ?, ?, ?, ?)";
            $stmtInsert = $conn->prepare($sqlstmt);
            $stmtInsert->bindParam(1, $std_id);
            $stmtInsert->bindParam(2, $dep);
            $stmtInsert->bindParam(3, $sem);
            $stmtInsert->bindParam(4, $year);
            $stmtInsert->bindParam(5, $int);
            $stmtInsert->bindParam(6, $sgpa);
    
            // Execute the statement
            $stmtInsert->execute();
           }
        }
        
        


        header("Location: ../selectForResult.php?success=$em");
        exit();
      } else {
          echo "Error: Unable to insert record.";
      }

    
   
    
  }else {
  	$em = "An error occurred";
    header("Location: ../classes.php?error=$em");
    exit;
  }

  }else {
    header("Location: ../../logout.php");
    exit;
  } 
}else {
	header("Location: ../../logout.php");
	exit;
} 
