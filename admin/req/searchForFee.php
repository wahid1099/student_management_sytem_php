<?php 
session_start();
if (isset($_SESSION['admin_id']) && 
    isset($_SESSION['role'])) {

    if ($_SESSION['role'] == 'Admin') {
       
        if (isset($_POST['dep']) &&
            isset($_POST['sem']) && 
            isset($_POST['year'])&& 
            isset($_POST['intake']) && 
            isset($_POST['section'])) {
            
            include '../../DB_connection.php';

            $department = $_POST['dep'];
            $semester = $_POST['sem'];
            $year = $_POST['year'];
            $intake = $_POST['intake'];
            $section = $_POST['section'];
            if (empty($department)) {
                $em  = "Department name is required";
                header("Location: ../add_fee.php?error=$em");
                exit;
            }else if(empty($semester)) {
            $em  = "Semester code is required";
            header("Location: ../add_fee.php?error=$em");
            exit;
            }else if (empty($year)) {
                    $em  = "Year is required";
                    header("Location: ../add_fee.php?error=$em");
                    exit;
            }
            else if (empty($intake)) {
                $em  = "Intake is required";
                header("Location: ../add_fee.php?error=$em");
                exit;
            }else if (empty($section)) {
                $em  = "Section is required";
                header("Location: ../add_fee.php?error=$em");
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
                    $_SESSION['department'] = $department;
                    $_SESSION['semester'] = $semester;
                    $_SESSION['year'] = $year;
                    $_SESSION['intake'] = $intake;
                    $_SESSION['section'] = $section;
                    
                    // Redirect to other.php
                    header("Location: ../addSectionFee.php");
                    exit; 
                 
                } else {
                    $em  = "Not Register Student Found in this query";
                    header("Location: ../add_fee.php?error=$em");
                    exit;
                   
                }
                
            }


        }else{
            $em  = "An Error Occured";
            header("Location: ../add_fee.php?error=$em");
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