<?php 
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

    function getStudentResultAll($conn, $student_id){
        $sql = "SELECT * FROM result WHERE std_id = ?";


    $stmt = $conn->prepare($sql);
    $stmt->execute([$student_id]);

    if ($stmt->rowCount() >= 1) {
        $result = $stmt->fetchAll();
        return $result;
    }else {
        return 0;
    }
    }


    function getCgpa($conn, $student_id) {
        $sql = "SELECT 
                    std_id,
                    AVG(sgpa) AS cgpa
                FROM 
                    gpa
                WHERE 
                    std_id = ?
                GROUP BY 
                    std_id";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$student_id]); // Use $student_id which is the parameter of the function
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($result && $result['cgpa'] !== null) {
            return round($result['cgpa'], 2);
        } else {
            return 0;
        }
    }



?>