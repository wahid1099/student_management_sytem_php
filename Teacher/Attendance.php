<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include "../DB_connection.php"; // Database connection

// Fetch options for dropdowns (Courses, Intakes, Sections)
$courses = $conn->query("SELECT DISTINCT courseCode, courseTitle FROM register_std_course")->fetchAll(PDO::FETCH_ASSOC);
$intakes = $conn->query("SELECT DISTINCT intake FROM register_std_course")->fetchAll(PDO::FETCH_ASSOC);
$sections = $conn->query("SELECT DISTINCT section FROM register_std_course")->fetchAll(PDO::FETCH_ASSOC);
$teacher_id = $_SESSION['teacher_id'] ?? ''; // Teacher's ID from session

$students = [];
$attendance_saved = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $selected_course = $_POST['course'] ?? '';
    $selected_intake = $_POST['intake'] ?? '';
    $selected_section = $_POST['section'] ?? '';
    $date = '';

    if (isset($_POST['date']) && !empty($_POST['date'])) {
        $date = $_POST['date'];
        $date_format = 'Y-m-d';
        $d = DateTime::createFromFormat($date_format, $date);
        if ($d && $d->format($date_format) == $date) {
            // Date is valid
        } else {
            // Invalid date format
            echo "Invalid date format. Please use YYYY-MM-DD.";
            $date = ''; // Or set it to today's date
        }
    }

    if (empty($date)) {
        // If date is empty or invalid, set it to today's date
        $date = date('Y-m-d');
    }


    // Continue with your database query and attendance logic
    $stmt = $conn->prepare("SELECT * FROM register_std_course WHERE courseCode = :course_code AND intake = :intake AND section = :section");
    $stmt->bindParam(':course_code', $selected_course);
    $stmt->bindParam(':intake', $selected_intake);
    $stmt->bindParam(':section', $selected_section);
    $stmt->execute();
    $students = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Handle attendance saving
    if (isset($_POST['status']) && !empty($_POST['status'])) {
        $statuses = $_POST['status']; // Get the statuses from the form

        try {
            // Start a transaction
            $conn->beginTransaction();

            // Insert attendance for each student
            foreach ($statuses as $student_id => $status) {
                $stmt = $conn->prepare("INSERT INTO attendance (student_id, course_code, date, status, teacher_id) 
                                        VALUES (:student_id, :course_code, :date, :status, :teacher_id)");
                $stmt->bindParam(':student_id', $student_id);
                $stmt->bindParam(':course_code', $selected_course);
                $stmt->bindParam(':date', $date);
                $stmt->bindParam(':status', $status);
                $stmt->bindParam(':teacher_id', $teacher_id);
                $stmt->execute();
            }

            // Commit the transaction
            $conn->commit();
            $attendance_saved = true;
        } catch (Exception $e) {
            // Rollback the transaction in case of error
            $conn->rollBack();
            $attendance_saved = false;
        }
    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .container {
            margin-top: 30px;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .header {
            margin-bottom: 20px;
        }

        .dropdown {
            margin-bottom: 15px;
        }

        table {
            margin-top: 20px;
        }

        th,
        td {
            text-align: center;
            vertical-align: middle;
        }

        .btn-save {
            margin-top: 20px;
        }
    </style>
</head>

<body>
<?php include "inc/header.php"; ?>
<?php include "inc/navbar.php"; ?>

<!-- Success/Error Message -->
<?php if ($attendance_saved): ?>
    <div class="alert alert-success">Attendance recorded successfully!</div>
<?php elseif (isset($_GET['error'])): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($_GET['error']) ?></div>
<?php endif; ?>

<div class="container">
    <div class="header text-center">
        <h2>Take Attendance</h2>
    </div>
    <form method="POST" class="text-center">
        <div class="row">
            <div class="col-md-4 dropdown">
                <label for="course" class="form-label">Select Course</label>
                <select id="course" name="course" class="form-select" required>
                    <option value="" disabled selected>Select Course</option>
                    <?php foreach ($courses as $course): ?>
                        <option value="<?= htmlspecialchars($course['courseCode']) ?>">
                            <?= htmlspecialchars($course['courseTitle']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-4 dropdown">
                <label for="intake" class="form-label">Select Intake</label>
                <select id="intake" name="intake" class="form-select" required>
                    <option value="" disabled selected>Select Intake</option>
                    <?php foreach ($intakes as $intake): ?>
                        <option value="<?= htmlspecialchars($intake['intake']) ?>">
                            <?= htmlspecialchars($intake['intake']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-4 dropdown">
                <label for="section" class="form-label">Select Section</label>
                <select id="section" name="section" class="form-select" required>
                    <option value="" disabled selected>Select Section</option>
                    <?php foreach ($sections as $section): ?>
                        <option value="<?= htmlspecialchars($section['section']) ?>">
                            <?= htmlspecialchars($section['section']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-4 offset-md-4">
                <label for="date" class="form-label">Select Date</label>
                <input type="date" id="date" name="date" class="form-control" value="<?= htmlspecialchars($date ?? '') ?>" required>
            </div>
        </div>

        <button type="submit" class="btn btn-primary mt-4">Show Students</button>
    </form>

    <?php if (!empty($students)): ?>
        <form method="POST">
            <table class="table table-bordered table-striped mt-4">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($students as $student): ?>
                        <tr>
                            <td><?= htmlspecialchars($student['std_id']) ?></td>
                            <td><?= htmlspecialchars($student['std_name']) ?></td>
                            <td>
                                <select name="status[<?= $student['std_id'] ?>]" class="form-select">
                                    <option value="Present">Present</option>
                                    <option value="Absent">Absent</option>
                                    <option value="Late">Late</option>
                                </select>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <button type="submit" class="btn btn-success btn-save">Save Attendance</button>
        </form>
    <?php elseif ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
        <div class="alert alert-warning mt-4">No students found for the selected criteria.</div>
    <?php endif; ?>

</div>
</body>

</html>
