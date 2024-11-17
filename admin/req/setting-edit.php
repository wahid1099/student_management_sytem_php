<?php 
session_start();
if (isset($_SESSION['admin_id']) && 
    isset($_SESSION['role'])) {

    if ($_SESSION['role'] == 'Admin') {
    	

if (isset($_POST['school_name']) &&
    isset($_POST['slogan']) &&
    isset($_POST['about']) && 
    isset($_POST['year']) && 
    isset($_POST['semester']) 
    ) {
    
    include '../../DB_connection.php';

    $school_name = $_POST['school_name'];
    $slogan = $_POST['slogan'];
    $about = $_POST['about'];
    $year = $_POST['year'];
    $semester = $_POST['semester'];

   

    if (empty($school_name)) {
        $em  = "School name is required";
        header("Location: ../settings.php?error=$em");
        exit;
    }else if (empty($slogan)) {
        $em  = "Slogan name is required";
        header("Location: ../settings.php?error=$em");
        exit;
    }else if (empty($about)) {
        $em  = "About name is required";
        header("Location: ../settings.php?error=$em");
        exit;
    }else {
        $sql  = "UPDATE setting 
                 SET school_name=?,
                     slogan=?,
                     about=?,
                     current_year=?,
                     current_semester=?
                     ";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$school_name, $slogan,$about,$year,$semester]);

        $semUpQue = "UPDATE students SET semester = ?, year = ?";
        $semUpStmt = $conn->prepare($semUpQue);
        $semUpStmt->execute([$semester, $year]);
        

        $sm = "Settings updated successfully";
        header("Location: ../settings.php?success=$sm&$data");
        exit;
	}
    
  }else {
  	$em = "An error occurred";
    header("Location: ../setting.php?error=$em");
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
