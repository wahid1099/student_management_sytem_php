<?php 
session_start();
if (isset($_SESSION['student_id']) && 
    isset($_SESSION['role'])) {

    if ($_SESSION['role'] == 'Student') {
     include "../DB_connection.php";
     include "data/student.php";
     


     $student_id = $_SESSION['student_id'];
     $courses = getStudentRegCourses($conn, $student_id);


 ?>
<?php 
        include "inc/header.php";
?>

<body>
    <?php 
        include "inc/navbar.php";?>
    <div class="container mt-5">

        <?php if (isset($_GET['error'])) { ?>
        <div class="alert alert-danger mt-3 n-table" role="alert">
            <?= $_GET['error'] ?>
        </div>
        <?php } ?>

        <?php if (isset($_GET['success'])) { ?>
        <div class="alert alert-info mt-3 n-table" role="alert">
            <?= $_GET['success'] ?>
        </div>
        <?php } ?>
        <div class="d-flex justify-content-center">
            <div class="table-responsive">
                <table class="table table-bordered mt-3 n-table table-striped">
                    <thead>
                        <tr class="table-primary">
                            <th scope="col">Course Name</th>
                            <th scope="col">Course Code</th>
                            <th class="text-nowrap" scope="col">Credit</th>
                            <th class="text-nowrap" scope="col">Couse Type</th>
                            <th scope="col">Intake</th>
                            <th scope="col">Section</th>
                        </tr>
                    </thead>
                    <tbody>


                        <?php if (isset($courses) && is_array($courses)) {
                foreach ($courses as $course) { ?>
                        <tr>
                            <td class="text-nowrap"><?= htmlspecialchars($course['courseTitle']) ?></td>
                            <td class="text-nowrap"><?= htmlspecialchars($course['courseCode']) ?></td>
                            <td class="text-nowrap"><?= htmlspecialchars($course['credit']) ?></td>
                            <td class="text-nowrap"><?= htmlspecialchars($course['type']) ?></td>
                            <td class="text-nowrap"><?= htmlspecialchars($course['intake']) ?></td>
                            <td class="text-nowrap"><?= htmlspecialchars($course['section']) ?></td>
                        </tr>
                        <?php }
            } else {
                // Handle the case where $courses is not set or is not an array
                echo "<tr><td colspan='6'>No courses available.</td></tr>";
            } ?>
                    </tbody>
                </table>
                <div class="card-body">
                    <a href="index.php" class="card-link btn bg-primary text-white">Go Back</a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    $(document).ready(function() {
        $("#navLinks li:nth-child(4) a").addClass('active');
    });
    </script>
</body>

</html>
<?php 

  }else {
    header("Location: ../login.php");
    exit;
  } 
}else {
	header("Location: ../login.php");
	exit;
} 

?>