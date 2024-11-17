<?php
include "DB_connection.php";
include "data/setting.php";
$setting = getSetting($conn);

if ($setting != 0) {

?>
<?php
	include "req/header.php";
	?>

<body class="body-home">
    <div class="black-fill"><br /> <br />
        <div class="container">

            <nav class="navbar navbar-expand-lg bg-light fixed-top" id="homeNav">
                <div class="container">
                    <a class="navbar-brand" href="#">
                        <img src="logo.png" width="40">
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0 ">
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="#">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="login.php">Sign In</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="other.php">Admin</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#about">About us</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#ratting">Feedback</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#contact">Contact us</a>
                            </li>
                        </ul>
                        <ul class="navbar-nav me-right mb-2 mb-lg-0">

                        </ul>
                    </div>
                </div>
            </nav>
            <section class="welcome-text d-flex justify-content-center align-items-center flex-column">
                <img src="logo.png">
                <h4>Welcome to DIU-<?= $setting['school_name'] ?></h4>
                <p><?= $setting['slogan'] ?></p>
            </section>
           <section id="about" class="d-flex justify-content-center align-items-center flex-column">
    <div class="card mb-3 card-1">
        <div class="row g-0">
            <div class="col-md-12 text-center">
                <div class="card-body">
                    <h5 class="card-title">About Us</h5><br>

                    <!-- Team Section -->
                    <section id="team" class="d-flex justify-content-center align-items-center flex-column">
                        <h3>Meet Our Developers</h3>
                        <div class="row text-center d-flex justify-content-center gap-3">
                            <div class="col-sm-6 col-md-4 col-lg-2 mb-4">
                                <img src="img/w2.jpg" class="rounded-circle img-fluid" alt="Developer 1">
                                <p>MD WAHID</p>
                            </div>
                            <div class="col-sm-6 col-md-4 col-lg-2 mb-4">
                                <img src="img/sadman.jpg" class="rounded-circle img-fluid" alt="Developer 2">
                                <p>SADMAN ZAHID</p>
                            </div>
                            <div class="col-sm-6 col-md-4 col-lg-2 mb-4">
                                <img src="img/rafi.jpg" class="rounded-circle img-fluid" alt="Developer 3">
                                <p>T.M RAFIUL ISLAM</p>
                            </div>
                            <div class="col-sm-6 col-md-4 col-lg-2 mb-4">
                                <img src="img/fatin.jpg" class="rounded-circle img-fluid" alt="Developer 4">
                                <p>FATIN ISHRAQ</p>
                            </div>
                            <div class="col-sm-6 col-md-4 col-lg-2 mb-4">
                                <img src="img/ridoy.jpg" class="rounded-circle img-fluid" alt="Developer 5">
                                <p>RIDOY HASAN</p>
                            </div>
                        </div>
                    </section>

                    <!-- Mission and Vision Section -->
                    <p><b><u>Our Mission</u></b></p>
                    <p class="mission-text">To empower educational institutions by providing a streamlined, intuitive, and comprehensive student management system that enhances communication, organization, and efficiency. We aim to simplify the management of student records, attendance, grading, and communication, allowing educators and administrators to focus more on student success and growth..</p>
                    <p><b><u>Our Vision</u></b></p>
                    <p class="mission-text">To create a unified platform that supports every aspect of student and academic administration, making education management easier, more accessible, and insightful. By continually innovating and improving our system, we envision a future where educational institutions of all sizes can operate seamlessly, harnessing data-driven insights to enhance student outcomes and foster academic excellence.</p>
                </div>
            </div>
        </div>
    </div>
</section>


            <section id="ratting" class="ratting d-flex justify-content-center align-items-center flex-column">
                <form method="post" action="req/ratting.php">
                    <h3>Feedback</h3>
                    <?php if (isset($_GET['error_ratting'])) { ?>
                    <div class="alert alert-danger" role="alert">
                        <?= $_GET['error_ratting'] ?>
                    </div>
                    <?php } ?>
                    <?php if (isset($_GET['success_ratting'])) { ?>
                    <div class="alert alert-success" role="alert">
                        <?= $_GET['success_ratting'] ?>
                    </div>
                    <?php } ?>
                    <div class="mb-3">
                        <label class="form-label">Stuent Id</label>
                        <input type="text" name="std_id" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Full Name</label>
                        <input type="text" name="fname" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" class="form-control" name="pass">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Give you feedback</label>
                        <div class="rateyo" id="rating" data-rateyo-rating="4" data-rateyo-num-stars="5"
                            data-rateyo-score="3">
                        </div>
                        <br>
                        <b><span class='result'>Rating: 4</span></b>
                        <input type="hidden" name="rating">
                        <br>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Comment</label>
                        <textarea class="form-control" name="comment" rows="4"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Send</button>
                </form>
            </section>

            <section id="contact" class="d-flex justify-content-center align-items-center flex-column">
                <form method="post" action="req/contact.php">
                    <h3>Contact Us</h3>

                    <?php if (isset($_GET['error_contact'])) { ?>
                    <div class="alert alert-danger" role="alert">
                        <?= $_GET['error_contact'] ?>
                    </div>
                    <?php } ?>
                    <?php if (isset($_GET['success_contact'])) { ?>
                    <div class="alert alert-success" role="alert">
                        <?= $_GET['success_contact'] ?>
                    </div>
                    <?php } ?>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Email address</label>
                        <input type="email" class="form-control" id="exampleInputEmail1" name="email"
                            aria-describedby="emailHelp">
                        <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Full Name</label>
                        <input type="text" name="full_name" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Message</label>
                        <textarea class="form-control" name="message" rows="4"></textarea>

                    </div>
                    <button type="submit" class="btn btn-primary">Send</button>
                </form>
            </section>
            <div class="text-center text-light">
                Copyright DIU &copy; <?= $setting['current_year'] ?> <?= $setting['school_name'] ?>. All rights reserved.
            </div>

        </div>
    </div>
    <script>
    $(function() {
        $(".rateyo").rateYo().on("rateyo.change", function(e, data) {
            var rating = data.rating;
            $(this).parent().find('.score').text('score :' + $(this).attr('data-rateyo-score'));
            $(this).parent().find('.result').text('Rating :' + rating);
            $(this).parent().find('input[name=rating]').val(rating); //add rating value to input field
        });
    });
    </script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.js"></script>
</body>

</html>
<?php } else {
	header("Location: login.php");
	exit;
}  ?>