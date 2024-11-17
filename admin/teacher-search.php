<?php
session_start();
if (
    isset($_SESSION['admin_id']) &&
    isset($_SESSION['role'])
) {

    if ($_SESSION['role'] == 'Admin') {
        if (isset($_GET['searchKey'])) {

            $search_key = $_GET['searchKey'];
            include "../DB_connection.php";
            include "data/teacher.php";
            include "data/tech_course.php";
            $teachers = searchTeachers($search_key, $conn);

?>
            <?php
            include "req/header.php";
            ?>

            <body>
                <?php
                include "inc/navbar.php";
                if ($teachers != 0) {
                ?>
                    <div class="container mt-5">
                        <a href="teacher-add.php" class="btn btn-dark">Add New Teacher</a>

                        <form action="teacher-search.php" method="get" class="mt-3 n-table">
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" name="searchKey" value="<?= $search_key ?>" placeholder="Search...">
                                <button class="btn btn-primary">
                                    <i class="fa fa-search" aria-hidden="true"></i>
                                </button>
                            </div>
                        </form>


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

                        <div class="table-responsive">
                            <table class="table table-bordered mt-3 n-table">
                                <thead>
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Username</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Phone No</th>
                                        <th scope="col">Taken Course</th>
                                        <th class="text-center" scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 0;
                                    foreach ($teachers as $teacher) {
                                        $i++;  ?>
                                        <tr>
                                            <td><?= $teacher['teacher_id'] ?></td>
                                            <td><a href="teacher-view.php?teacher_id=<?= $teacher['teacher_id'] ?>">
                                                <?= $teacher['fname'] . '&nbsp' . $teacher['lname'] ?></a></td>
                                            <td><?= $teacher['username'] ?></td>
                                            <td><?= $teacher['email_address'] ?></td>
                                            <td><?= $teacher['phone_number'] ?></td>
                                            <td>
                                                <?php
                                                // Get courses for the teacher
                                                $courses = getCoursesByTeacherId($teacher['teacher_id'], $conn);

                                                // Display course names
                                                if ($courses) {
                                                    echo "<ul>"; // Start unordered list
                                                    foreach ($courses as $course) {
                                                        echo "<li>" . $course['course_name'] . "</li>"; // Display each course name
                                                    }
                                                    echo "</ul>"; // End unordered list
                                                } else {
                                                    echo "No courses found for this teacher.";
                                                }
                                                ?>
                                            </td>

                                            <td class="text-center d-flex justify-content-center align-items-center">
                                                <div>
                                                    <a href="teacher-edit.php?teacher_id=<?= $teacher['teacher_id'] ?>" class="btn btn-warning">Edit</a>
                                                </div>
                                                <div class="mx-3">
                                                    <a href="teacher-delete.php?teacher_id=<?= $teacher['teacher_id'] ?>" class="btn btn-danger">Delete</a>
                                                </div>
                                                <div>
                                                    <a href="add-tech-course.php?teacher_id=<?= $teacher['teacher_id'] ?>" class="btn btn-primary">Add&nbsp;Course</a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    <?php } else { ?>
                        <div class="alert alert-info .w-450 m-5" role="alert">
                            No Results Found
                            <a href="teacher.php" class="btn btn-dark">Go Back</a>
                        </div>
                    <?php } ?>
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
            header("Location: teacher.php");
            exit;
        }
    } else {
        header("Location: ../login.php");
        exit;
    }
} else {
    header("Location: ../login.php");
    exit;
}

?>