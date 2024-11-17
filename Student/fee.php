<?php 
session_start();
if (isset($_SESSION['student_id']) && 
    isset($_SESSION['role'])) {

    if ($_SESSION['role'] == 'Student') {
     include "../DB_connection.php";
     include "data/student.php";
     include "data/fee.php";


     $student_id = $_SESSION['student_id'];
     $fee = getStudentFee($conn, $student_id);


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
                        <tr class="table-secondary">
                            <th class="text-nowrap" scope="col">Section of
                                fees&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                            </th>
                            <th scope="col">
                                Cost&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (is_array($fee)) { ?>
                        <tr>
                            <td>Tuition Fee</td>
                            <td><?php echo htmlspecialchars($fee['tution_fee']); ?></td>
                        </tr>
                        <tr>
                            <td>Lab Fee</td>
                            <td><?php echo htmlspecialchars($fee['lab_fee']); ?></td>
                        </tr>
                        <tr>
                            <td>Library Fee</td>
                            <td><?php echo htmlspecialchars($fee['library_fee']); ?></td>
                        </tr>
                        <tr>
                            <td>Medical Fee</td>
                            <td><?php echo htmlspecialchars($fee['medicalFee']); ?></td>
                        </tr>
                        <tr>
                            <td>Other Fee</td>
                            <td><?php echo htmlspecialchars($fee['other_fee']); ?></td>
                        </tr>
                        <tr class="table-info">
                            <td><b>Total Cost</b></td>
                            <td><b><?php echo htmlspecialchars($fee['total_fee']); ?></b></td>
                        </tr>
                        <?php } else { ?>
                        <tr>
                            <td colspan="2">Fee information is not available.</td>
                        </tr>
                        <?php } ?>
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
        $("#navLinks li:nth-child(5) a").addClass('active');
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