<?php 
session_start();
if (isset($_SESSION['student_id']) && 
    isset($_SESSION['role'])) {

    if ($_SESSION['role'] == 'Student') {
     include "../DB_connection.php";
     include "data/result.php";
     


     $student_id = $_SESSION['student_id'];
     $studentSem = selectStudentSem($conn, $student_id);   
     $semester = $studentSem['semester'];
     $year = $studentSem['year'];
     $results = getStudentResultALL($conn, $student_id);
 ?>
<?php 
        include "inc/header.php";
?>

<body>
    <?php 
        include "inc/navbar.php";?>
    <div class="container mt-5">

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
                                <th  class="text-nowrap" scope="col">Course Name</th>
                                <th  class="text-nowrap" scope="col">Course Code</th>
                                <th class="text-nowrap" scope="col">Credit</th>
                                <th class="text-nowrap" scope="col">Couse Type</th>
                                <th class="text-nowrap" scope="col">Semester</th>
                                <th class="text-nowrap" scope="col">Year</th>
                                <th class="text-nowrap"  scope="col">Score</th>
                                <th class="text-nowrap"  scope="col">Grade</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (isset($results) && is_array($results)) {
                            $flag = 1;    
                            foreach ($results as $result) {    
                                ?>
                            <tr>
                                <td class="text-nowrap"><?= htmlspecialchars($result['courseName']) ?></td>
                                <td class="text-nowrap"><?= htmlspecialchars($result['courseCode']) ?></td>
                                <td class="text-nowrap"><?= htmlspecialchars($result['credit']) ?></td>
                                <td class="text-nowrap">
                                    <?php
                                    $credit = htmlspecialchars($result['credit']);
                                    if ($credit == 1.5) {
                                        $type = "Lab";
                                    } elseif ($credit == 3) {
                                        $type = "Theory";
                                    } else {
                                        $type = "Project";
                                    }
                                    echo $type;
                                ?>
                                </td>
                                <td class="text-nowrap"><?= htmlspecialchars($result['semester']) ?></td>
                                <td class="text-nowrap"><?= htmlspecialchars($result['year']) ?></td>
                                <td class="text-nowrap"><?= htmlspecialchars($result['mark']) ?></td>
                                <td class="text-nowrap"><?= htmlspecialchars($result['grade']) ?></td>
                            </tr>
                            <?php  
                            }
                        } else {
                            // Handle the case where $courses is not set or is not an array
                            echo "<tr><td colspan='6'>Result Not Published for any Course.</td></tr>";
                        } ?>
                        </tbody>
                    </table>
                    <div class="card-body text-center">
                        <a href="result.php" class="card-link btn bg-primary text-white">Go Back</a>
                    </div>
                </div>
            </div>
        </div>


        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
        <script>
        $(document).ready(function() {
            $("#navLinks li:nth-child(6) a").addClass('active');
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