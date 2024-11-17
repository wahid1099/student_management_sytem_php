<?php 
session_start();
if (isset($_SESSION['admin_id']) && 
    isset($_SESSION['role'])) {

    if ($_SESSION['role'] == 'Admin') {
    	

if (isset($_POST['teacher_id']) &&
    isset($_POST['teacher_name']) &&
    isset($_POST['department']) &&
    isset($_POST['semester'])     &&
    isset($_POST['year'])  &&
    isset($_POST['section']) &&
    isset($_POST['intake'])) {
    
    include '../../DB_connection.php';
    include "../data/teacher.php";
    

    $teacher_id = $_POST['teacher_id'];
    $teacher_name = $_POST['teacher_name'];
    $department = $_POST['department'];
    $semester = $_POST['semester'];
    $year = $_POST['year'];
    $section = $_POST['section'];
    $course = $_POST['course'];
    $intake = $_POST['intake'];

    $data = 'uname='.$teacher_id.'&fname='.$teacher_name.'&lname='.$department.'&address='.$semester.'&en='.$year.'&pn='.$section.'&qf='.$course;

    if (empty($teacher_id)) {
		$em  = "First name is required";
		header("Location: ../teacher-add.php?error=$em&$data");
		exit;
	}else if (empty($teacher_name)) {
		$em  = "Last name is required";
		header("Location: ../teacher-add.php?error=$em&$data");
		exit;
	}else if (empty($department)) {
		$em  = "Username is required";
		header("Location: ../teacher-add.php?error=$em&$data");
		exit;
	}else if (empty($semester)) {
		$em  = "Password is required";
		header("Location: ../teacher-add.php?error=$em&$data");
		exit;
	}else if (empty($year)) {
        $em  = "Address is required";
        header("Location: ../teacher-add.php?error=$em&$data");
        exit;
    }else if (empty($section)) {
        $em  = "Employee number is required";
        header("Location: ../teacher-add.php?error=$em&$data");
        exit;
    }else if (empty($course)) {
        $em  = "All Course are Added";
        header("Location: ../add-tech-course.php?error=$em&$data");
        exit;
    }else {
        {
            $query = "SELECT courseCode, credit FROM courses WHERE courseTitle = ?";
    
            // Prepare the statement
            $stmt = $conn->prepare($query);
            echo $course;
            
            // Bind parameters
            $stmt->bindParam(1, $course);
            $stmt->execute();

            // Fetch the result
            $result = $stmt->fetch(PDO::FETCH_ASSOC); 

            // Store values in variables
            if ($result) {
                    $courseCode = $result['courseCode'];
                    $credit = $result['credit'];
                                // Your query
                    // Your query
                    $query = "INSERT INTO tech_reg_courses (teacher_id, course_name, course_code, credit, department, semester, year, section,intake) VALUES (?, ?, ?, ?, ?, ?, ?, ?,?)";

                    // Prepare the statement
                    $stmt = $conn->prepare($query);

                    // Bind parameters
                    $stmt->bindParam(1, $teacher_id);
                    $stmt->bindParam(2, $course);
                    $stmt->bindParam(3, $courseCode);
                    $stmt->bindParam(4, $credit);
                    $stmt->bindParam(5, $department);
                    $stmt->bindParam(6, $semester);
                    $stmt->bindParam(7, $year);
                    $stmt->bindParam(8, $section);
                    $stmt->bindParam(9, $intake);
                    // Execute the statement
                    if ($stmt->execute()) {
                        // Insertion successful, display a success message
                        $success_message = "Course added successfully";
                        header("Location: ../add-tech-course.php?success=$success_message");
                        exit;
                    } else {
                        $em = "Course added Faild";
                        header("Location: ../add-tech-course.php?error=$em");
                        exit;
                    }

            } else {
                $em = "Course Not Found";
                header("Location: ../add-tech-course.php?error=$em");
                exit;
            }
    
            
        }

	}
    
  }else {
  	$em = "An error occurred";
    header("Location: ../add-tech-course.php?error=$em");
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
