<?php  

if (isset($_POST['std_id']) &&
    isset($_POST['fname']) &&
    isset($_POST['pass']) &&
    isset($_POST['rating']) &&
    isset($_POST['comment'])) {

    include "../DB_connection.php";
	include "../admin/data/student.php";
	
    $std_id     = $_POST['std_id'];
	$full_name = $_POST['fname'];
    $pass = $_POST['pass'];
    $rating = $_POST['rating'];
	$comment   = $_POST['comment'];

	if (empty($std_id)) {
		$em  = "Student Id is required";
		header("Location: ../index.php?error=$em#ratting");
		exit;
	}else if (empty($full_name)) {
		$em  = "Full name is required";
		header("Location: ../index.php?error=$em#ratting");
		exit;
	}else if (empty($pass)) {
		$em  = "Password is required";
		header("Location: ../index.php?error=$em#ratting");
		exit;
	}else if (empty($comment)) {
		$em  = "Comment is required";
		header("Location: ../index.php?error=$em#ratting");
		exit;
	}else {

       $students =  getStudentById($std_id,$conn);
       
       if(!empty($students)){
            $student_id = $students['student_id'];
            $password = $students['password'];
            
            if($student_id == $student_id && password_verify($pass, $password)){
                $sql  = "INSERT INTO
                 feedback (student_id, student_name, rating, comment)
                 VALUES(?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->execute([$student_id, $full_name, $rating, $comment]);
                $sm = "Feedback Added successfully";
		        header("Location: ../index.php?success_ratting=$sm#ratting");
                exit;
            }else{
                $em  = "Password and student ID do not match";
                header("Location: ../index.php?error_ratting=$em#ratting");
                exit;
            }

        }else{
            $em  = "Your are not allowed to Given Feedback";
            header("Location: ../index.php?error=$em#ratting");
            exit;
        }


	}

}else{
	header("Location: ../index.php");
	exit;
}