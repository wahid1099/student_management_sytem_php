<?php 

// All Students 
function getAllStudents($conn){
   $sql = "SELECT * FROM students";
   $stmt = $conn->prepare($sql);
   $stmt->execute();

   if ($stmt->rowCount() >= 1) {
     $students = $stmt->fetchAll();
     return $students;
   }else {
   	return 0;
   }
}



// Get Student By Id 
function getStudentById($id, $conn){
   $sql = "SELECT * FROM students
           WHERE student_id=?";
   $stmt = $conn->prepare($sql);
   $stmt->execute([$id]);

   if ($stmt->rowCount() == 1) {
     $student = $stmt->fetch();
     return $student;
   }else {
    return 0;
   }
}


// Check if the username Unique
function unameIsUnique($uname, $conn, $student_id=0){
   $sql = "SELECT username, student_id FROM students
           WHERE username=?";
   $stmt = $conn->prepare($sql);
   $stmt->execute([$uname]);
   
   if ($student_id == 0) {
     if ($stmt->rowCount() >= 1) {
       return 0;
     }else {
      return 1;
     }
   }else {
    if ($stmt->rowCount() >= 1) {
       $student = $stmt->fetch();
       if ($student['student_id'] == $student_id) {
         return 1;
       }else {
        return 0;
      }
     }else {
      return 1;
     }
   }
   
}


function studentPasswordVerify($student_pass, $conn, $student_id){
   $sql = "SELECT * FROM students
           WHERE student_id=?";
   $stmt = $conn->prepare($sql);
   $stmt->execute([$student_id]);

   if ($stmt->rowCount() == 1) {
     $student = $stmt->fetch();
     $pass  = $student['password'];

     if (password_verify($student_pass, $pass)) {
        return 1;
     }else {
        return 0;
     }
   }else {
    return 0;
   }
}

function getStudentRegCourses($conn, $student_id){
    $sql = "SELECT 
    register_std_course.courseTitle,  
    register_std_course.courseCode,  
    register_std_course.credit,  
    register_std_course.intake, 
    register_std_course.section, 
    courses.type
    FROM 
        register_std_course
    INNER JOIN 
        courses
    ON 
        register_std_course.courseTitle = courses.courseTitle
    WHERE 
        register_std_course.std_id = ?";


  $stmt = $conn->prepare($sql);
  $stmt->execute([$student_id]);

  if ($stmt->rowCount() >= 1) {
    $courses = $stmt->fetchAll();
    return $courses;
  }else {
    return 0;
  }
}