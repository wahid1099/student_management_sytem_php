<?php 
session_start();
if (isset($_SESSION['admin_id']) && 
    isset($_SESSION['role'])) {

    if ($_SESSION['role'] == 'Admin') {
       
        if (isset($_POST['dep']) &&
            isset($_POST['sem']) && 
            isset($_POST['year'])&& 
            isset($_POST['intake']) && 
            isset($_POST['section']) &&
            isset($_POST['teacher_id']) &&
            isset($_POST['teacher_name']) 
            
            ) {
            
            include '../../DB_connection.php';
            include '../data/tech_course.php';
            $department = $_POST['dep'];
            $semester = $_POST['sem'];
            $year = $_POST['year'];
            $intake = $_POST['intake'];
            $section = $_POST['section'];
            $teacher_id = $_POST['teacher_id'];
            $teacher_name = $_POST['teacher_name'];

            $courses = techStdUnRegCouse($conn, $department, $year, $semester, $section, $intake);
            
            if(!$courses){
                $em  = "Also all courses are added or Course Found";
                $_SESSION['$teacher_id'] = $teacher_id;
                header("Location: ../selectSectionForCourse.php?error=$em");
                exit;
            }
            if (empty($department)) {
                $em  = "Department name is required";
                header("Location: ../selectSectionForCourse.php?error=$em");
                exit;
            }else if(empty($semester)) {
            $em  = "Semester code is required";
            header("Location: ../selectSectionForCourse.php?error=$em");
            exit;
            }else if (empty($year)) {
                    $em  = "Year is required";
                    header("Location: ../selectSectionForCourse.php?error=$em");
                    exit;
            }
            else if (empty($intake)) {
                $em  = "Intake is required";
                header("Location: ../selectSectionForCourse.php?error=$em");
                exit;
            }else if (empty($section)) {
                $em  = "Section is required";
                header("Location: ../selectSectionForCourse.php?error=$em");
                exit;
            }else{
                $query = "SELECT * FROM register_std_course WHERE department=? AND semester=? AND year=? AND section=?";

                // Prepare the statement
                $stmt = $conn->prepare($query);

                // Bind parameters
                $stmt->bindParam(1, $department);
                $stmt->bindParam(2, $semester);
                $stmt->bindParam(3, $year);
                $stmt->bindParam(4, $section);


                // Execute the statement
                $stmt->execute();

                // Check if any rows are found
                if ($stmt->rowCount() > 0) {
                    $_SESSION['course_dep'] = $department;
                    $_SESSION['course_sem'] = $semester;
                    $_SESSION['course_year'] = $year;
                    $_SESSION['course_intake'] = $intake;
                    $_SESSION['course_section'] = $section;
                    $_SESSION['course_teacher_id'] = $teacher_id;
                    $_SESSION['course_teacher_name'] = $teacher_name;
                    //echo $department . ' ' . $semester . ' ' . $year . ' ' . $section . ' ' .$intake . ' '. $teacher_id . ' ' . $teacher_name;
                    
                    header("Location: ../add-tech-course.php");
                    
                    exit; 
                 
                } else {
                    $em  = "Not Register Student Found in this query";
                    header("Location: ../selectSectionForCourse.php?error=$em");
                    exit;
                   
                }
                
            }


        }else{
            $em  = "An Error Occured";
            header("Location: ../selectSectionForCourse.php?error=$em");
            exit;
        }
    }else{
        $em  = "An Error Occured";
        header("Location: ../../other.php?error=$em");
        exit;
    }
}else{
    $em  = "An Error Occured";
    header("Location: ../../other.php?error=$em");
    exit;
}