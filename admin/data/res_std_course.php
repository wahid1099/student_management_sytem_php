<?php 

// All Students 
function getAllRegCourse($conn){
   $sql = "SELECT DISTINCT courseTitle FROM register_std_course";
   $stmt = $conn->prepare($sql);
   $stmt->execute();

   if ($stmt->rowCount() >= 1) {
     $courses = $stmt->fetchAll();
     return $courses;
   }else {
   	return 0;
   }
}

function getAllStdRegBySemester($conn, $department, $semester, $year, $section){
  $sql = "SELECT DISTINCT std_id, std_name FROM register_std_course Where
  department=? AND semester=? AND year=? AND section=?";
  
  $stmt = $conn->prepare($sql);
  $stmt->execute([$department, $semester, $year, $section]);
 

  if ($stmt->rowCount() >= 1) {
    $students = $stmt->fetchAll();
    return $students;
  }else {
    return 0;
  }
}

function getStudentForReg($conn, $department, $semester, $year, $intake) {
  $sql = "SELECT student_id, fname, lname FROM students WHERE department=? AND semester=? AND year=? AND intake=?";

  $stmt = $conn->prepare($sql);
  $stmt->execute([$department, $semester, $year, $intake]);

  if ($stmt->rowCount() >= 1) {
      $students = $stmt->fetchAll();
      return $students;
  } else {
      return []; // Return an empty array if no students found
  }
}

function getStudentCourse($conn, $stdId) {
  $sql = "SELECT courseTitle FROM register_std_course WHERE std_id=?";

  $stmt = $conn->prepare($sql);
  $stmt->execute([$stdId]);

  if ($stmt->rowCount() >= 1) {
      $students = $stmt->fetchAll();
      return $students;
  } else {
      return []; // Return an empty array if no students found
  }
}


function getStudentCompleteCourse($conn, $stdId) {
  $sql = "SELECT COUNT(std_id) FROM result WHERE std_id=?";

  $stmt = $conn->prepare($sql);
  $stmt->execute([$stdId]);

  $count = $stmt->fetchColumn();

  // Check if any rows were found
  if ($count > 0) {
      return $count;
  } else {
      return 0; // Return 0 if no rows found
  }
}

