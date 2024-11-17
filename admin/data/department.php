<?php 

// All Students 
function getAllDepartment($conn){
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
