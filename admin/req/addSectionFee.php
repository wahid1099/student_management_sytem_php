<?php 
session_start();

$department = $_SESSION['department'];
$semester = $_SESSION['semester'];
$year = $_SESSION['year'];
$intake = $_SESSION['intake'];
$section = $_SESSION['section'];

if (isset($_SESSION['admin_id']) && 
    isset($_SESSION['role'])) {

    if ($_SESSION['role'] == 'Admin') {
       
        if (isset($_POST['tution_fee']) &&
            isset($_POST['lab_fee']) && 
            isset($_POST['lib_fee'])&& 
            isset($_POST['medical_fee'])&& 
            isset($_POST['other_fee'])  ) {
            
            include '../../DB_connection.php';
            include '../data/res_std_course.php';

            $students = getAllStdRegBySemester($conn, $department, $semester, $year, $section);
            
            $tution_fee = $_POST['tution_fee'];
            $lab_fee = $_POST['lab_fee'];
            $lib_fee = $_POST['lib_fee'];
            $other_fee = $_POST['other_fee'];
            $medical_fee = $_POST['medical_fee'];
            
            if (empty($other_fee)) {
                $other_fee = 0;
            }

            if (empty($tution_fee) || !(is_numeric($tution_fee))) {
                $em  = "Credit Cost is required in Digit";
                header("Location: ../addSectionFee.php?error=$em");
                exit;
            }else if(empty($lab_fee)  || !(is_numeric($lab_fee))) {
                $em  = "Lab Fee is required in Digit";
                header("Location: ../addSectionFee.php?error=$em");
                exit;
            }else if (empty($lib_fee)  || !(is_numeric($lib_fee))) {
                    $em  = "Medical Fee is required in Digit";
                    header("Location: ../addSectionFee.php?error=$em");
                    exit;
            }else if (empty($medical_fee) || !(is_numeric($medical_fee))) {
                $em  = "Medical Fee is required in Digit";
                header("Location: ../addSectionFee.php?error=$em");
                exit;
            }else if ( !(empty($other_fee)) && !(is_numeric($other_fee))) {
                $em  = "Other Fee is required in Digit";
                header("Location: ../addSectionFee.php?error=$em");
                exit;
            }else{
                $flag=0;
                if ($students) {
                    // Loop through each student and print their details
                    foreach ($students as $student) {
                        $total_semester_fee = 0;
                        $studentId = $student['std_id']; // Assuming the student ID is stored in 'std_id'

                        $sql = "SELECT std_id FROM fee WHERE std_id=?";
                        $stmt = $conn->prepare($sql);
                        $stmt->execute([$studentId]); // Bind the student ID to the query

                        // Fetch the result directly as a single value
                        $std_exist = $stmt->fetchColumn();

                        if ($stmt->rowCount() > 0) {
                            $flag=0;
                        } 
                        else{
                            $std_id = $student['std_id'];
                            $std_name = $student['std_name'];
                            
                            //Fetch student credit
                            $sql = "SELECT DISTINCT SUM(credit) AS std_credit FROM register_std_course Where std_id=?";
                            $stmt = $conn->prepare($sql);
                            $stmt->execute([$std_id]);
                            $std_credit = $stmt->fetchColumn();
                            
                    
                            $total_tution_fee = $tution_fee * $std_credit;
                            $total_semester_fee = $total_tution_fee + $lab_fee + $lib_fee + $medical_fee + $other_fee; 
                            
                            $sql = "INSERT INTO fee(std_id, std_name, department, semester, year, section, tution_fee, lab_fee, library_fee,medicalFee, other_fee,total_fee)
                            VALUES(?,?,?,?,?,?,?,?,?,?,?,?)";
                            $stmt = $conn->prepare($sql);
                            $stmt->execute([$std_id, $std_name, $department, $semester, $year, $section, $total_tution_fee, $lab_fee, $lib_fee,$medical_fee, $other_fee, $total_semester_fee]);

                            if ($stmt->rowCount() >= 1) {
                                $flag=1;
                            }
                        }
                       
                    }

                    if($flag == 1){
                        $em  = "Fee Added Successfully";
                        header("Location:../addSectionFee.php?success=$em");
                        exit;
                    }else{
                        $em  = "Already Added Fees for this Section";
                        header("Location:../addSectionFee.php?error=$em");
                        exit;
                    }
                } else {
                    $em  = "No Register Student Found In This Section";
                    header("Location:../addSectionFee.php?error=$em");
                    exit;
                }    
            }  
        }
        else {
            $em  = "An Error Occured";
            header("Location:../../other.php?error=$em");
            exit;
        }   
    }
    else {
        $em  = "An Error Occured";
        header("Location:../../other.php?error=$em");
        exit;
    }   
    
}
else {
    $em  = "An Error Occured";
    header("Location:../../other.php?error=$em");
    exit;
}   
