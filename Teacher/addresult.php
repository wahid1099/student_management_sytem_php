<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
  }
if (
    isset($_SESSION['teacher_id']) &&
    isset($_SESSION['role']) &&
    isset($_POST['dep']) &&
    isset($_POST['sem']) &&
    isset($_POST['year']) &&
    isset($_POST['section'])     &&
    isset($_POST['intake'])  &&
    isset($_POST['courseName'])
) {

    if ($_SESSION['role'] == 'Teacher') {
        include "../DB_connection.php";
        include "../admin/data/student.php";
        include "../admin/data/fee.php";
        include "data/techerRegCourse.php";


        $departments = $_POST['dep'];
        $semeters = $_POST['sem'];
        $years = $_POST['year'];
        $sections = $_POST['section'];
        $intakes = $_POST['intake'];
        $courses = $_POST['courseName'];
        $techer_id = $_SESSION['teacher_id'];
        $courseCode = getRegTeacherCourseId($techer_id, $courses, $conn);
        $credit = getRegTeacherCourseCredit($techer_id, $courses, $conn);
        $students =  getStdAndTechCouse($techer_id, $courseCode, $conn);




        if (empty($departments)) {
            $em  = "No Course Found";
            header("Location: selectForResult.php?error=$em&$data");
            exit;
        } else if (empty($semeters)) {
            $em  = "No Course Found";
            header("Location: selectForResult.php?error=$em&$data");
            exit;
        } else if (empty($sections)) {
            $em  = "No Course Found";
            header("Location: selectForResult.php?error=$em&$data");
            exit;
        } else if (empty($intakes)) {
            $em  = "No Course Found";
            header("Location: selectForResult.php?error=$em&$data");
            exit;
        } else if (empty($courses)) {
            $em  = "No Course Found";
            header("Location: selectForResult.php?error=$em&$data");
            exit;
        } else if (empty($courseCode)) {
            $em  = "No Course Found";
            header("Location: selectForResult.php?error=$em&$data");
            exit;
        } else if (empty($credit)) {
            $em  = "No Course Found";
            header("Location: selectForResult.php?error=$em&$data");
            exit;
        } else {
            $_SESSION["dep"] = $departments;
            $_SESSION["sem"] =  $semeters;
            $_SESSION["year"] = $years;
            $_SESSION["sec"] = $sections;
            $_SESSION["int"] =  $intakes;
            $_SESSION["course"] = $courses;
            $_SESSION["courseCode"] = $courseCode;
            $_SESSION["credit"] =  $credit;
        }



?>
        <?php
        include "inc/header.php";
        ?>



        <body>
            <?php
            include "inc/navbar.php";
            ?>
            <div class="container mt-5">

                <div class="text-center">
                    <h3><?php echo $departments ?></h3>
                    <h5>Semester: <?php echo $semeters . ", " . $years ?></h5>
                    <h5>Intake: <?php echo $intakes . ", Section: " . $sections ?></h5>
                    <hr>

                </div>
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
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Name</th>
                                    <th class="text-nowrap" scope="col">Course Name</th>
                                    <th class="text-nowrap" scope="col">Course Code</th>
                                    <th scope="col">Credit</th>
                                    <th scope="col">&nbsp;&nbsp;&nbsp;&nbsp;Mark</th>
                                </tr>
                            </thead>
                            <tbody>
                                <form action="req/save-score.php" method="post">

                                    <?php foreach ($students as $student) {
                                        $std_id = $student['std_id'];
                                    ?>
                                        <tr>
                                            <td>
                                                <?= $student['std_id'] ?>
                                                <input type="hidden" name="std_id[]" value="<?= $student['std_id'] ?>">
                                            </td>
                                            <td class="text-nowrap">
                                                <?= $student['std_name'] ?>
                                                <input type="hidden" name="std_name[]" value="<?= $student['std_name'] ?>">
                                            </td>
                                            <td class="text-nowrap"><?= $courses ?></td>
                                            <td class="text-nowrap"><?= $courseCode ?></td>
                                            <td class="text-nowrap"><?= $credit ?></td>
                                            <td class="text-nowrap"><input class="form-control" name="mark[]" type="text"></td>
                                        </tr>
                                    <?php } ?>
                                    <tr>
                                        <td colspan="8" class="text-right">
                                            <button type="submit" class="btn btn-success">Add Result</button>
                                        </td>
                                    </tr>

                                </form>


                            </tbody>
                        </table>
                    </div>
                </div>
            </div>


            <script src="../js/bootstrap.bundle.min.js"></script>
            <script>
                $(document).ready(function() {
                    $("#navLinks li:nth-child(4) a").addClass('active');
                });
            </script>

        </body>

        </html>
<?php

    } else {
        header("Location: addresult.php");
        exit;
    }
} else {
    $em  = "No Course Found";
            header("Location: selectForResult.php?error=$em&$data");
            exit;
    exit;
}

?>