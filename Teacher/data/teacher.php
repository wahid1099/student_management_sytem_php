<?php  

// Get Teacher by ID
function getTeacherById($teacher_id, $conn){
   $sql = "SELECT * FROM teachers
           WHERE teacher_id=?";
   $stmt = $conn->prepare($sql);
   $stmt->execute([$teacher_id]);

   if ($stmt->rowCount() == 1) {
     $teacher = $stmt->fetch();
     return $teacher;
   }else {
    return 0;
   }
}

function teacherPasswordVerify($student_pass, $conn, $teacher_id){
  $sql = "SELECT * FROM teachers
          WHERE teacher_id=?";
  $stmt = $conn->prepare($sql);
  $stmt->execute([$teacher_id]);

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
