<?php 
session_start();
include('dbcon.php');

$errors = [];

if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($con, $_POST['user']);
    $password = mysqli_real_escape_string($con, $_POST['pass']);
    $hashed_password = md5($password);

    $query = mysqli_query($con, "SELECT * FROM members WHERE password='$hashed_password' AND username='$username' AND status='Active'");
    $row = mysqli_fetch_array($query);
    $num_row = mysqli_num_rows($query);

    if ($num_row > 0) {			
        $_SESSION['user_id'] = $row['user_id'];
        header('location:pages/index.php');
        exit();
    } else {
        $errors[] = "Invalid Username/Password!";
    }
}

if (isset($_POST['register'])) {
    $username = mysqli_real_escape_string($con, $_POST['user']);
    $password = mysqli_real_escape_string($con, $_POST['pass']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $dob = mysqli_real_escape_string($con, $_POST['dob']);
    $reg_date = date('Y-m-d'); // Current date as registration date
    
    // Validate date of birth to ensure user is over 18
    $dob_timestamp = strtotime($dob);
    $min_age = 18;
    $diff = time() - $dob_timestamp;
    $age = floor($diff / (365 * 60 * 60 * 24));
    
    if ($age < $min_age) {
        $errors[] = "You must be 18 years or older to register.";
    } elseif (!preg_match("/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.(com)$/", $email)) {
        $errors[] = "Email must be a valid email address ending with '.com'.";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT); // Hash the password

        $query = "INSERT INTO members (username, password, email, dob, reg_date) VALUES ('$username', '$hashed_password', '$email', '$dob', '$reg_date')";
        
        if (mysqli_query($con, $query)) {
            $_SESSION['user_id'] = mysqli_insert_id($con);
            header('location:pages/index.php');
            exit();
        } else {
            $errors[] = "Registration failed. Please try again.";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Gym System</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/matrix-style.css">
    <link rel="stylesheet" href="css/matrix-login.css">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,700,800" rel="stylesheet" type="text/css">
</head>
<body>
    <div id="loginbox">
        <form id="loginform" class="form-vertical" method="POST" action="#">
            <div class="control-group normal_text">
                <h3>Customer Login</h3>
            </div>
            <div class="control-group">
                <div class="controls">
                    <div class="main_input_box">
                        <span class="add-on bg_lg"><i class="icon-user"></i></span>
                        <input type="text" name="user" placeholder="Username" required>
                    </div>
                </div>
            </div>
            <div class="control-group">
                <div class="controls">
                    <div class="main_input_box">
                        <span class="add-on bg_ly"><i class="icon-lock"></i></span>
                        <input type="password" name="pass" placeholder="Password" required>
                    </div>
                </div>
            </div>
            <div class="form-actions">
                <span class="pull-left">
                    <a href="#" class="flip-link btn btn-info" id="to-recover">SIGN UP</a>
                </span>
                <span class="pull-right">
                    <button type="submit" name="login" class="btn btn-success"> LOGIN</button>
                </span>
            </div>
            <div class="g">
                <a href="../logins.php"><h6>Go Back</h6></a>
            </div>
            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger alert-dismissible" role="alert">
                    <?php foreach ($errors as $error): ?>
                        <?php echo $error; ?><br>
                    <?php endforeach; ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php endif; ?>
        </form>
        <!-- Registration form -->
        <form id="recoverform" action="../customer/pages/register-cust.php" method="POST" class="form-vertical">
            <p class="normal_text">Enter your details below and we will send your details for further activation process.</p>
            <div class="controls">
                <div class="main_input_box">
                    <span class="add-on bg_lo"><i class="icon-pencil"></i></span>
                    <input type="text" name="fullname" placeholder="Fullname" required />
                </div>
            </div>
            <br>
            <div class="controls">
                <div class="main_input_box">
                    <span class="add-on bg_lo"><i class="icon-leaf"></i></span>
                    <input type="text" name="username" placeholder="Username" required />
                </div>
            </div>
            <br>
            <div class="controls">
                <div class="main_input_box">
                    <span class="add-on bg_lo"><i class="icon-asterisk"></i></span>
                    <input type="password" name="password" placeholder="Password" required />
                </div>
            </div>
            <br>
            <div class="controls">
                <div class="main_input_box">
                    <span class="add-on bg_lo"><i class="icon-leaf"></i></span>
                    <input type="number" name="contact" placeholder="Contact Number" required />
                </div>
            </div>
            <br>
            <div class="controls">
                <div class="main_input_box">
                    <span class="add-on bg_lo"><i class="icon-asterisk"></i></span>
                    <input type="text" name="address" placeholder="Address" required />
                </div>
            </div>
            <br>
            <div class="control-group">
                <div class="controls">
                    <div class="main_input_box">
                        <span class="add-on bg_lo"><i class="icon-calendar"></i></span>
                        <input type="date" name="dob" placeholder="Date of Birth" required>
                    </div>
                </div>
            </div>
            <br>
            <div class="control-group">
                <div class="controls">
                    <div class="main_input_box">
                        <span class="add-on bg_lo"><i class="icon-calendar"></i></span>
                        <input type="date" name="reg_date" value="<?php echo date('Y-m-d'); ?>" readonly>
                    </div>
                </div>
            </div>
            <br>
            <div class="control-group">
                <div class="controls">
                  <!--  <div class="main_input_box">
                        <span class="add-on bg_lo"><i class="icon-envelope"></i></span>
                        <input type="email" name="email" placeholder="Email" required>
                    </div> -->
                </div>
            </div>
            <br>
            <div class="controls">
                <div class="main_input_box">
                    <select name="gender" required>
                        <option value="" disabled selected>Select Gender</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
            </div>
            <br>
            <div class="controls">
                <div class="main_input_box">
                    <select name="plan" required>
                        <option value="" disabled selected>Select Plan</option>
                        <option value="1">One Month</option>
                        <option value="3">Three Months</option>
                        <option value="6">Six Months</option>
                        <option value="12">One Year</option>
                    </select>
                </div>
            </div>
            <br>
            <div class="controls">
                <div class="main_input_box">
                    <select name="services" required>
                        <option value="" disabled selected>Select Service</option>
                        <option value="Fitness">Fitness</option>
                        <option value="Sauna">Sauna</option>
                        <option value="Cardio">Cardio</option>
                    </select>
                </div>
            </div>
            <div class="form-actions">
                <span class="pull-left"><a href="#" class="flip-link btn btn-success" id="to-login">&laquo; Back to login</a></span>
                <span class="pull-right"><button class="btn btn-info" type="submit">Submit Details</button></span>
            </div>
        </form>
    </div>

    <!-- JavaScript -->
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/matrix.login.js"></script>
    <script src="js/matrix.js"></script>
    <!-- Date of Birth validation and contact number validation -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const dobInput = document.querySelector('input[name="dob"]');
            const contactInput = document.querySelector('input[name="contact"]');

            dobInput.addEventListener('change', function() {
                const dob = new Date(this.value);
                const currentDate = new Date();
                const age = currentDate.getFullYear() - dob.getFullYear();

                if (age < 18) {
                    alert('You must be 18 years or older to register.');
                    this.value = ''; // Clear the date input
                }
            });

            contactInput.addEventListener('blur', function() {
                const contactValue = this.value;

                // Ensure the input is numeric and has at least 10 digits
                if (!/^\d{10,}$/.test(contactValue)) {
                    alert('Contact number must be numeric and at least 10 digits.');
                    this.value = ''; // Clear the contact input if it doesn't meet the requirement
                }
            });
        });
    </script>
</body>
</html>
