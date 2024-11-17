<?php 

// All Students 
function getAllFeeBySemester($conn){
   $sql = "SELECT * FROM department";
   $stmt = $conn->prepare($sql);
   $stmt->execute();

   if ($stmt->rowCount() >= 1) {
     $departments = $stmt->fetchAll();
     return $departments;
   }else {
   	return 0;
   }

}


function getFeeOfStudent($conn, $student_id){
  $sql = "SELECT total_fee FROM fee WHERE std_id=?";
  $stmt = $conn->prepare($sql);
  $stmt->execute([$student_id]);

  if ($stmt->rowCount() >= 1) {
      $fee = $stmt->fetch(PDO::FETCH_ASSOC);
      return $fee['total_fee'];
  } else {
      return null;
  }
}

?>

