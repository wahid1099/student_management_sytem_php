<?php 

// Get techer course by teacher ID
// Get courses by teacher ID
function getCoursesByTeacherId($teacher_id, $conn) {
    $sql = "SELECT * FROM tech_reg_courses WHERE teacher_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$teacher_id]);
    
    // Fetch all courses associated with the teacher
    $courses = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    return $courses;
}

function techStdUnRegCouse($conn, $department, $year, $semester, $section, $intake) {
    $sql = "
        SELECT DISTINCT courseTitle 
        FROM register_std_course
        WHERE department = ?
          AND year = ?
          AND semester = ?
          AND section = ?
          AND intake = ?
          AND courseTitle NOT IN (
              SELECT course_name FROM tech_reg_courses
          );
    ";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$department, $year, $semester, $section, $intake]);
   

    $courses = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $courses;
}



