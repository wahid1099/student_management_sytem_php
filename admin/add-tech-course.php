<?php
session_start();
if (
    isset($_SESSION['admin_id']) &&
    isset($_SESSION['role'])
) {

    if ($_SESSION['role'] == 'Admin') {
        include "../DB_connection.php";
        include "data/teacher.php";
        include "data/department.php";
        include "data/tech_course.php";


        $teacher_id = $_SESSION["course_teacher_id"];
        $teacher_name = $_SESSION["course_teacher_name"];
        $department = $_SESSION["course_dep"];
        $semester = $_SESSION["course_sem"];
        $year = $_SESSION["course_year"];
        $intake = $_SESSION['course_intake'];
        $section = $_SESSION["course_section"];

        $courses = techStdUnRegCouse($conn, $department, $year, $semester, $section, $intake);

        // echo $teacher_id . " " .$teacher_name . " " . $department . " " . $intake . " " . $semester . " " . $year . " " .$section ;


      
        $teacher = getTeacherById($teacher_id, $conn);
?>
        <?php
        include "req/header.php";
        ?>

        <body>
            <?php
            include "inc/navbar.php";
            ?>
            <div class="container mt-5">
                <a href="teacher.php" class="btn btn-dark">Go Back</a>

                <form method="post" class="shadow p-3 mt-5 form-w" action="req/add-tech-course.php">
                    <h3>Add Course For Teacher</h3>
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
                        <label class="form-label">Teacher Id</label>
                        <input type="text" class="form-control" name="teacher_id" value="<?php echo $teacher_id; ?>" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Teacher Name</label>
                        <input type="text" class="form-control" name="teacher_name" value="<?php echo $teacher_name ?>" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Department</label>
                        <input type="text" class="form-control" name="department" value="<?php echo $department; ?>" readonly>

                    </div>
                    <div class="mb-3">
                        <label class="form-label">Year</label>
                        <input type="text" class="form-control" name="year" value="<?php echo $year ?>" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Semester</label>
                        <input type="text" class="form-control" name="semester" value="<?php echo $semester ?>" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Intake</label>
                        <input type="text" class="form-control" name="intake" value="<?php echo $intake ?>" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Section</label>
                        <input type="text" class="form-control" name="section" value="<?php echo $intake ?>" readonly>
                    </div>


                    <div class="mb-3">
                        <label class="form-label">Course Name</label>
                        <select class="form-control" name="course">
                            <?php
               
                                foreach ($courses as $course) {
                                    // Use $course['courseTitle'] to access the course title
                                    echo "<option value='" . $course['courseTitle'] . "'>" . $course['courseTitle'] . "</option>";
                                }
                            
                            ?>
                        </select>

                    </div>

                    <button type="submit" class="btn btn-primary">Add Course</button>
                </form>
            </div>

            <script src="../js/bootstrap.bundle.min.js"></script>
            <script>
                $(document).ready(function() {
                    $("#navLinks li:nth-child(4) a").addClass('active');
                });

                function makePass(length) {
                    var result = '';
                    var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
                    var charactersLength = characters.length;
                    for (var i = 0; i < length; i++) {
                        result += characters.charAt(Math.floor(Math.random() *
                            charactersLength));

                    }
                    var passInput = document.getElementById('passInput');
                    passInput.value = result;
                }

                var gBtn = document.getElementById('gBtn');
                gBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    makePass(4);
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