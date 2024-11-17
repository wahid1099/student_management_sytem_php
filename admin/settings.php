<?php 
session_start();
if (isset($_SESSION['admin_id']) && 
    isset($_SESSION['role'])) {

    if ($_SESSION['role'] == 'Admin') {
       include "../DB_connection.php";
       include "data/setting.php";
       $setting = getSetting($conn);
 ?>
<?php 
        include "req/header.php";
?>

<body>
    <?php 
        include "inc/navbar.php";

     ?>
    <div class="container mt-5">
        <form method="post" class="shadow p-3 mt-5 form-w" action="req/setting-edit.php">
            <h3>Edit</h3>
            <hr>
            <?php if (isset($_GET['error'])) { ?>
            <div class="alert alert-danger" role="alert">
                <?=$_GET['error']?>
            </div>
            <?php } ?>
            <?php if (isset($_GET['success'])) { ?>
            <div class="alert alert-success" role="alert">
                <?=$_GET['success']?>
            </div>
            <?php } ?>
            <div class="mb-3">
                <label class="form-label">Institute Name</label>
                <input type="text" class="form-control" value="<?=$setting['school_name']?>" name="school_name">
            </div>
            <div class="mb-3">
                <label class="form-label">Slogan</label>
                <input type="text" class="form-control" value="<?=$setting['slogan']?>" name="slogan">
            </div>
            <div class="mb-3 ">
                <!-- Hide about -->
                <textarea type="hidden" class="form-control" name="about" rows="4"
                    style="display:none;"><?=$setting['about']?></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Current Year</label>
                <select class="form-control" name="year">
                    <?php
                        $current_year = $setting['current_year']; // Assume this is the variable storing the current year from the database
                        for ($int = 2024; $int <= 2028; $int++) {
                            $selected = ($int == $current_year) ? 'selected' : '';
                            echo "<option value='$int' $selected>$int</option>";
                        }
                    ?>
                </select>

            </div>
            <div class="mb-3">
                <label class="form-label">Current Semester</label>
                <select class="form-control" name="semester">
                    <option value="Spring" <?= $setting['current_semester'] == 'Spring' ? 'selected' : '' ?>>Spring
                    </option>
                    <option value="Fall" <?= $setting['current_semester'] == 'Fall' ? 'selected' : '' ?>>Fall</option>
                </select>

            </div>


            <button type="submit" class="btn btn-primary">
                Update</button>
        </form>
    </div>

    <script src="../js/bootstrap.bundle.min.js"></script>
    <script>
    $(document).ready(function() {
        $("#navLinks li:nth-child(8) a").addClass('active');
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