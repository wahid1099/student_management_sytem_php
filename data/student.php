<?php 
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
?>