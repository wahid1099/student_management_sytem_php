

<?php  


function getRegTeacherDept($teacher_id, $conn){
    //Assuming you have a valid PDO connection in $conn and $teacher_id is set
    $sql = "SELECT DISTINCT department FROM tech_reg_courses WHERE teacher_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$teacher_id]);

    // Fetching all distinct departments
    $departments = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
    return $departments;
}


function getRegTeacherSection($teacher_id, $conn){
    //Assuming you have a valid PDO connection in $conn and $teacher_id is set
    $sql = "SELECT DISTINCT section FROM tech_reg_courses WHERE teacher_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$teacher_id]);

    // Fetching all distinct departments
    $sections = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
    return $sections;
}

function getRegTeacherIntake($teacher_id, $conn){
    //Assuming you have a valid PDO connection in $conn and $teacher_id is set
    $sql = "SELECT DISTINCT intake FROM tech_reg_courses WHERE teacher_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$teacher_id]);

    // Fetching all distinct departments
    $intakes = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
    return $intakes;
}
function getRegTeacherYear($teacher_id, $conn){
    //Assuming you have a valid PDO connection in $conn and $teacher_id is set
    $sql = "SELECT DISTINCT year FROM tech_reg_courses WHERE teacher_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$teacher_id]);

    // Fetching all distinct departments
    $year = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
    return $year;
}

function getRegTeacherCoursse($teacher_id, $conn){
    //Assuming you have a valid PDO connection in $conn and $teacher_id is set
    $sql = "SELECT course_name FROM tech_reg_courses WHERE teacher_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$teacher_id]);

    // Fetching all distinct departments
    $courses = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
    return $courses;
}

function getRegTeacherCourseId($teacher_id, $course_name, $conn){
    $sql = "SELECT course_code FROM tech_reg_courses WHERE teacher_id=? AND course_name=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$teacher_id, $course_name]);
    
    // Fetching a single course code
    $courseCode = $stmt->fetchColumn();
    return $courseCode;

}

function getStdAndTechCouse($teacher_id, $course_code,$conn){
    $sql = "SELECT std_id, std_name, courseTitle, courseCode, register_std_course.semester, register_std_course.year, register_std_course.section, tech_reg_courses.teacher_id
    FROM register_std_course
    INNER JOIN tech_reg_courses
    ON register_std_course.semester = tech_reg_courses.semester 
    AND register_std_course.year = tech_reg_courses.year 
    AND register_std_course.courseTitle = tech_reg_courses.course_name
    WHERE tech_reg_courses.course_code = ? AND tech_reg_courses.teacher_id=?";

    $stmt = $conn->prepare($sql);
    $stmt->execute([$course_code, $teacher_id]);

    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $results;
}

function getRegTeacherCourseCredit($teacher_id, $course_name, $conn){
    $sql = "SELECT credit FROM tech_reg_courses WHERE teacher_id=? AND course_name=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$teacher_id, $course_name]);
    
    // Fetching a single course code
    $credit = $stmt->fetchColumn();
    return $credit;

}

function getRegTeacherSemester($teacher_id, $conn){
    //Assuming you have a valid PDO connection in $conn and $teacher_id is set
    $sql = "SELECT DISTINCT semester FROM tech_reg_courses WHERE teacher_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$teacher_id]);

    // Fetching all distinct departments
    $courses = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
    return $courses;
}

?>
