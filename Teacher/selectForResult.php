<?php
session_start();
if (
    isset($_SESSION['teacher_id']) &&
    isset($_SESSION['role'])
) {

    if ($_SESSION['role'] == 'Teacher') {
        $techer_id = $_SESSION['teacher_id'];
        include "../DB_connection.php";
        include "data/techerRegCourse.php";
        
        //die();
        $departments = getRegTeacherDept($techer_id, $conn);
        $semeters = getRegTeacherSemester($techer_id, $conn);
        $years = getRegTeacherYear($techer_id, $conn);
        $sections = getRegTeacherSection($techer_id, $conn);
        $intakes = getRegTeacherIntake($techer_id, $conn);
        $courses = getRegTeacherCoursse($techer_id, $conn);
        
?>
        <?php
        include "inc/header.php";
        ?>



        <body>
            <?php
            include "inc/navbar.php";
            ?>
            <div class="container mt-5">


                <a href="index.php" class="btn btn-dark">Go Back</a>
                <form method="post" class="shadow p-3 mt-5 form-w" action="addresult.php">

                    <h3>Select Section</h3>
                    <hr>
                    <?php if (isset($_GET['error'])) { ?>
                        <div class="alert alert-danger" role="alert">
                            <?= $_GET['error'] ?>
                        </div>
                    <?php } ?>
                    <?php if (isset($_GET['success'])) { ?>
                        <div class="alert alert-success" role="alert">
                            <?= $_GET['success'] ?>
                        </div>
                    <?php } ?>
                    <div class="mb-3">
                        <label class="form-label">Department</label>
                        <select class="form-control" name="dep">
                            <?php
                                foreach ($departments as $department) {
                                    echo '<option value="' . htmlspecialchars($department, ENT_QUOTES, 'UTF-8') . '">' . htmlspecialchars($department, ENT_QUOTES, 'UTF-8') . '</option>';
                                }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Semester</label>
                        <select class="form-control" name="sem">
                            <?php
                                foreach ($semeters as $semeter) {
                                    echo '<option value="' . htmlspecialchars($semeter, ENT_QUOTES, 'UTF-8') . '">' . htmlspecialchars($semeter, ENT_QUOTES, 'UTF-8') . '</option>';
                                }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Year</label>
                        <select class="form-control" name="year">
                            <?php
                                foreach ($years as $year) {
                                    echo '<option value="' . htmlspecialchars($year, ENT_QUOTES, 'UTF-8') . '">' . htmlspecialchars($year, ENT_QUOTES, 'UTF-8') . '</option>';
                                }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Intake</label>
                        <select class="form-control" name="intake">
                            <?php
                                foreach ($intakes as $intake) {
                                    echo '<option value="' . htmlspecialchars($intake, ENT_QUOTES, 'UTF-8') . '">' . htmlspecialchars($intake, ENT_QUOTES, 'UTF-8') . '</option>';
                                }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Section</label>
                        <select class="form-control" name="section">
                            <?php
                                foreach ($sections as $section) {
                                    echo '<option value="' . htmlspecialchars($section, ENT_QUOTES, 'UTF-8') . '">' . htmlspecialchars($section, ENT_QUOTES, 'UTF-8') . '</option>';
                                }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Course Name</label>
                        <select class="form-control" name="courseName">
                            <?php
                                foreach ($courses as $course) {
                                    echo '<option value="' . htmlspecialchars($course, ENT_QUOTES, 'UTF-8') . '">' . htmlspecialchars($course, ENT_QUOTES, 'UTF-8') . '</option>';
                                }
                            ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Next</button>
                </form>
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
        header("Location: ../login.php");
        exit;
    }
} else {
    header("Location: ../login.php");
    exit;
}

?>