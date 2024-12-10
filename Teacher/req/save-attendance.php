<?php
// Start the session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Ensure the teacher_id is available in session
if (!isset($_SESSION['teacher_id'])) {
    // Redirect to login or handle the case where the teacher is not logged in
    header("Location: login.php"); 
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['status'])) {
    include "../../DB_connection.php"; // Database connection

    // Fetch session data
    $teacher_id = $_SESSION['teacher_id'];
    $course_code = $_POST['course_code']; // course code should come from the form
    $date = date("Y-m-d"); // current date
    $statuses = $_POST['status']; // Get the statuses from the form

    try {
        // Begin a transaction
        $conn->beginTransaction();

        // Insert attendance for each student
        foreach ($statuses as $student_id => $status) {
            $stmt = $conn->prepare("INSERT INTO attendance (student_id, course_code, date, status, teacher_id) 
                                    VALUES (:student_id, :course_code, :date, :status, :teacher_id)");
            $stmt->bindParam(':student_id', $student_id);
            $stmt->bindParam(':course_code', $course_code);
            $stmt->bindParam(':date', $date);
            $stmt->bindParam(':status', $status);
            $stmt->bindParam(':teacher_id', $teacher_id);
            $stmt->execute();
        }

        // Commit the transaction
        $conn->commit();

        // Redirect with success message
        header("Location: attendance.php?success=Attendance recorded successfully!");
        exit;

    } catch (Exception $e) {
        // Rollback the transaction on error
        $conn->rollBack();

        // Redirect with error message
        header("Location: attendance.php?error=Failed to record attendance.");
        exit;
    }
}
?>
