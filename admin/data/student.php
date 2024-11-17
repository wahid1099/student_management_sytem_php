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

// All Students 
function getAllDepartment($conn){
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
function removeTeacher($id, $conn){
  $sql2 = "DELETE FROM tech_reg_courses WHERE teacher_id=?";
  $stmt2 = $conn->prepare($sql2);
  
  $sql1 = "DELETE FROM teachers WHERE teacher_id=?";
  $stmt1 = $conn->prepare($sql1); 
  
  $result2 = $stmt2->execute([$id]);
  $result1 = $stmt1->execute([$id]);  
  
  return $result1 && $result2;
}
// DELETE
function removeStudent($id, $conn){
   $sql3  = "DELETE FROM fee WHERE std_id=?";
   $stmt3 = $conn->prepare($sql3); 
   $result3 = $stmt3->execute([$id]);

   $sql2  = "DELETE FROM register_std_course WHERE std_id=?";
   $stmt2 = $conn->prepare($sql2); 
   $result2 = $stmt2->execute([$id]);

   $sql1  = "DELETE FROM students WHERE student_id=?";
   $stmt1 = $conn->prepare($sql1); 
   $result1 = $stmt1->execute([$id]);
   
   return $result1 && $result2 && $result3;
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


// Search 
function searchStudents($key, $conn){
   $key = preg_replace('/(?<!\\\)([%_])/', '\\\$1',$key);
   $sql = "SELECT * FROM students
           WHERE student_id LIKE ? 
           OR fname LIKE ?
           OR address LIKE ?
           OR email_address LIKE ?
           OR parent_fname LIKE ?
           OR parent_lname LIKE ?
           OR parent_phone_number LIKE ?
           OR lname LIKE ?
           OR username LIKE ?";
   $stmt = $conn->prepare($sql);
   $stmt->execute([$key, $key, $key, $key, $key, $key, $key, $key, $key]);

   if ($stmt->rowCount() == 1) {
     $students = $stmt->fetchAll();
     return $students;
   }else {
    return 0;
   }
}