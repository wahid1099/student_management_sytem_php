<?php 
session_start();
if (isset($_SESSION['admin_id']) && 
    isset($_SESSION['role'])) {

    if ($_SESSION['role'] == 'Admin') {
      include '../DB_connection.php';
     

 ?>
<?php 
        include "req/header.php";
?> 

<body>
    <?php 
        include "inc/navbar.php";
     ?>
     <div class="container mt-5">
      
       

        <form method="post"
              class="shadow p-3 mt-5 form-w" 
              action="req/searchForFee.php">

        <h3>Select Option For Add Fee</h3><hr>
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
                <label class="form-label">Department</label>
                <select class="form-control" name="dep">
                    <option>Computer Science & Engineering</option>
                    <option>Electrical and Electronics Enigineering</option>
                    <option>Civil Engineering</option>
                </select>
         </div>
         <div class="mb-3">
                <label class="form-label">Semester</label>
                <select class="form-control" name="sem">
                    <option>Spring</option>
                    <option>Fall</option>
                </select>
         </div>
         <div class="mb-3">
                <label class="form-label">Year</label>
                <select class="form-control" name="year">
                   <?php
                        for ($int = 2024; $int <= 2050; $int++) {
                            echo "<option value='$int'>$int</option>";
                        }
                    ?>
                </select>
         </div>
         <div class="mb-3">
                <label class="form-label">Intake</label>
                <select class="form-control" name="intake">
                    <?php
                        for ($int = 1; $int <= 10; $int++) {
                            echo "<option value='$int'>$int</option>";
                        }
                    ?>
                </select>
         </div>
         <div class="mb-3">
                <label class="form-label">Section</label>
                <select class="form-control" name="section">
                    <?php
                        for ($int = 1; $int <= 10; $int++) {
                            echo "<option value='$int'>$int</option>";
                        }
                    ?>
                </select>
         </div>
      <button type="submit" class="btn btn-primary">Next</button>
     </form>
     </div>
     

     
     <script src="../js/bootstrap.bundle.min.js"></script>	
     <script>
        $(document).ready(function(){
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