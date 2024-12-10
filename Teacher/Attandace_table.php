<?php
include "../DB_connection.php"; // Database connection

// Fetch the list of courses for the filter dropdown
$courses_stmt = $conn->query("SELECT DISTINCT courseCode, courseTitle FROM register_std_course");
$courses = $courses_stmt->fetchAll(PDO::FETCH_ASSOC);

// Handle course filter
$selected_course = $_GET['course'] ?? '';

// Base query to fetch attendance records
$query = "SELECT a.date, a.status, CONCAT(s.fname, ' ', s.lname) AS std_name, c.courseTitle 
          FROM attendance a
          JOIN register_std_course c ON a.course_code = c.courseCode
          JOIN students s ON a.student_id = s.student_id"; // Concatenate fname and lname for full name

// Add condition for course filter if selected
if ($selected_course) {
    $query .= " WHERE a.course_code = :course_code";
}

$query .= " ORDER BY a.date DESC";

$stmt = $conn->prepare($query);

// Bind course filter parameter if selected
if ($selected_course) {
    $stmt->bindParam(':course_code', $selected_course);
}

$stmt->execute();
$attendance_records = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance Records</title>
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
    </style>
</head>

<body>
<?php include "inc/header.php"; ?>
<?php include "inc/navbar.php"; ?>

<div class="container">
    <div class="header text-center">
        <h2>Attendance Records</h2>
    </div>

    <!-- Filter Form -->
    <form method="GET" class="mb-4">
        <div class="row">
            <div class="col-md-4 offset-md-4">
                <label for="course" class="form-label">Select Course</label>
                <select id="course" name="course" class="form-select">
                    <option value="">All Courses</option>
                    <?php foreach ($courses as $course): ?>
                        <option value="<?= htmlspecialchars($course['courseCode']) ?>"
                                <?= ($selected_course === $course['courseCode']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($course['courseTitle']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Filter</button>
    </form>

    <?php if (empty($attendance_records)): ?>
        <div class="alert alert-warning">No attendance records found.</div>
    <?php else: ?>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Student Name</th>
                    <th>Course</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($attendance_records as $record): ?>
                    <tr>
                        <td><?= htmlspecialchars($record['date']) ?></td>
                        <td><?= htmlspecialchars($record['std_name']) ?></td>
                        <td><?= htmlspecialchars($record['courseTitle']) ?></td>
                        <td><?= htmlspecialchars($record['status']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

</body>

</html>
