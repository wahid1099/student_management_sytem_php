<?php 
    function selectStudentAlreadyAdded($std_id, $course_code, $conn){
        $sql = "SELECT std_id FROM result WHERE std_id=? AND courseCode=?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$std_id	, $course_code]);
        
        // Fetching a single course code
        $credit = $stmt->fetchColumn();
        return $credit;
    
    }

    function getGrade($score) {
        if ($score >= 80) {
            return "A+";
        } elseif ($score >= 75) {
            return "A";
        } elseif ($score >= 70) {
            return "A-";
        } elseif ($score >= 65) {
            return "B+";
        } elseif ($score >= 60) {
            return "B";
        } elseif ($score >= 55) {
            return "B-";
        } elseif ($score >= 50) {
            return "C+";
        } elseif ($score >= 45) {
            return "C";
        } elseif ($score >= 40) {
            return "D";
        } else {
            return "F";
        }
    }

    function getStudentResult($conn, $student_id, $semseter, $year){
        $sql = "SELECT * FROM result WHERE std_id = ? AND semester=? AND year=?";


    $stmt = $conn->prepare($sql);
    $stmt->execute([$student_id, $semseter, $year]);

    if ($stmt->rowCount() >= 1) {
        $result = $stmt->fetchAll();
        return $result;
    }else {
        return 0;
    }

    }


    function isResultFullPublished($conn, $student_id){
        $sql = "SELECT * FROM register_std_course WHERE std_id = ?";
    
        $stmt = $conn->prepare($sql);
        $stmt->execute([$student_id]);
    
        if ($stmt->rowCount() >= 1) {
            return 0;
        } else {
            return 1;
        }
    }

    function getGradePoint($score) {
        $point = 0;
    
        if ($score >= 80) {
            $point = 4.00;
        } elseif ($score >= 75) {
            $point = 3.75;
        } elseif ($score >= 70) {
            $point = 3.50;
        } elseif ($score >= 65) {
            $point = 3.25;
        } elseif ($score >= 60) {
            $point = 3.00;
        } elseif ($score >= 55) {
            $point = 2.75;
        } elseif ($score >= 50) {
            $point = 2.50;
        } elseif ($score >= 45) {
            $point = 2.25;
        } elseif ($score >= 40) {
            $point = 2.00;
        } else {
            $point = 0.00;
        }
    
        return $point;
    }


    function selectStudentSem($conn, $student_id){
        $sql = "SELECT * FROM students WHERE student_id = ?";
    
        $stmt = $conn->prepare($sql);
        $stmt->execute([$student_id]);
    
        if ($stmt->rowCount() >= 1) {
            $semseter = $stmt->fetch();
            return $semseter;
        } else {
            return null;
        }
    }

    
?>