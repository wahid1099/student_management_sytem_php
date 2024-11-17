<?php
function getStudentFee($conn, $id){
    $sql = "SELECT * FROM fee
            WHERE std_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$id]);
 
    if ($stmt->rowCount() == 1) {
      $fee = $stmt->fetch();
      return $fee;
    }else {
     return 0;
    }
 }


?>

