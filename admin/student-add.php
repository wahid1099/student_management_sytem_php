<?php 
session_start();
if (isset($_SESSION['admin_id']) && 
    isset($_SESSION['role'])) {

    if ($_SESSION['role'] == 'Admin') {
      
       include "../DB_connection.php";
      



       $fname = '';
       $lname = '';
       $uname = '';
       $address = '';
       $email = '';
       $pfn = '';
       $pln = '';
       $ppn = '';
       $dep = '';
       $sem ='';
       $year ='';


       if (isset($_GET['fname'])) $fname = $_GET['fname'];
       if (isset($_GET['lname'])) $lname = $_GET['lname'];
       if (isset($_GET['uname'])) $uname = $_GET['uname'];
       if (isset($_GET['address'])) $address = $_GET['address'];
       if (isset($_GET['email'])) $email = $_GET['email'];
       if (isset($_GET['pfn'])) $pfn = $_GET['pfn'];
       if (isset($_GET['pln'])) $pln = $_GET['pln'];
       if (isset($_GET['ppn'])) $ppn = $_GET['ppn'];
       if (isset($_GET['dep'])) $dep = $_GET['dep'];
       if (isset($_GET['sem'])) $sem = $_GET['sem'];
       if (isset($_GET['year'])) $year = $_GET['year'];
       if (isset($_GET['sec'])) $sec = $_GET['sec'];
 ?>
<?php 
        include "req/header.php";
?> 


<body>
    <?php 
        include "inc/navbar.php";
     ?>
    <div class="container mt-5">
        <a href="student.php" class="btn btn-dark">Go Back</a>

        <form method="post" class="shadow p-3 mt-5 form-w" action="req/student-add.php">
            <h3>Add New Student</h3>
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
                <label class="form-label">First name</label>
                <input type="text" class="form-control" value="<?=$fname?>" name="fname">
            </div>
            <div class="mb-3">
                <label class="form-label">Last name</label>
                <input type="text" class="form-control" value="<?=$lname?>" name="lname">
            </div>
            <div class="mb-3">
                <label class="form-label">Address</label>
                <input type="text" class="form-control" value="<?=$address?>" name="address">
            </div>
            <div class="mb-3">
                <label class="form-label">Email address</label>
                <input type="text" class="form-control" value="<?=$email?>" name="email_address">
            </div>
            <div class="mb-3">
                <label class="form-label">Date of birth</label>
                <input type="date" class="form-control" name="date_of_birth">
            </div>
            <div class="mb-3">
                <label class="form-label">Gender</label><br>
                <input type="radio" value="Male" checked name="gender"> Male
                &nbsp;&nbsp;&nbsp;&nbsp;
                <input type="radio" value="Female" name="gender"> Female
            </div><br>
            <hr>
            <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" class="form-control" value="<?=$uname?>" name="username">
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <div class="input-group mb-3">
                    <input type="text" class="form-control" name="pass" id="passInput">
                    <button class="btn btn-secondary" id="gBtn">
                        Random</button>
                </div>

            </div><br>
            <hr>
            <div class="mb-3">
                <label class="form-label">Parent first name</label>
                <input type="text" class="form-control" value="<?=$pfn?>" name="parent_fname">
            </div>
            <div class="mb-3">
                <label class="form-label">Parent last name</label>
                <input type="text" class="form-control" value="<?=$pln?>" name="parent_lname">
            </div>
            <div class="mb-3">
                <label class="form-label">Parent phone number</label>
                <input type="text" class="form-control" value="<?=$ppn?>" name="parent_phone_number">
            </div><br>

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
                    <option>2024</option>
                    <option>2025</option>
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
                <select class="form-control" name="sec">
                     <?php
                    for ($int = 1; $int <= 10; $int++) {
                        echo "<option value='$int'>$int</option>";
                    }
                    ?>
                </select>
            </div>

            

            <button type="submit" class="btn btn-primary">Register</button>
        </form>
    </div>

    <script src="../js/bootstrap.bundle.min.js"></script>	
    <script>
    $(document).ready(function() {
        $("#navLinks li:nth-child(3) a").addClass('active');
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

  }else {
    header("Location: ../login.php");
    exit;
  } 
}else {
	header("Location: ../login.php");
	exit;
} 

?>