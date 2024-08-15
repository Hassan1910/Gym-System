<?php
session_start();
include 'dbcon.php'; // Ensure this path is correct

if (!isset($_SESSION['user_id'])) {
    header('location:../index.php');
    exit();
}

$message = "";
$messageType = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['addCourse'])) {
    // Get form data
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $description = mysqli_real_escape_string($con, $_POST['description']);

    $pricePerMonth = $_POST['price_per_month'];
    $pricePer3Months = $_POST['price_per_3months'];
    $pricePer6Months = $_POST['price_per_6months'];
    $pricePerYear = $_POST['price_per_year'];

    // Handle file upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $allowed = ['jpg' => 'image/jpeg', 'png' => 'image/png', 'gif' => 'image/gif'];
        $fileName = $_FILES['image']['name'];
        $fileType = $_FILES['image']['type'];
        $fileSize = $_FILES['image']['size'];
        $fileTmpName = $_FILES['image']['tmp_name'];

        // Verify file extension
        $ext = pathinfo($fileName, PATHINFO_EXTENSION);
        if (!array_key_exists($ext, $allowed)) {
            die("Error: Please select a valid file format.");
        }

        // Verify file size - 5MB maximum
        $maxsize = 5 * 1024 * 1024;
        if ($fileSize > $maxsize) {
            die("Error: File size is larger than the allowed limit.");
        }

        // Verify MYME type of the file
        if (in_array($fileType, $allowed)) {
            // Check whether file exists before uploading it
            $newFileName = uniqid() . "-" . $fileName; // to avoid overwriting existing files
            $destination = "../uploads/" . $newFileName;

            if (move_uploaded_file($fileTmpName, $destination)) {
                $relativePath = "uploads/" . $newFileName;

                // Insert query
                $qry = "INSERT INTO courses (name, description, price_per_month, price_per_3months, price_per_6months, price_per_year, image_url) 
                        VALUES ('$name', '$description', '$pricePerMonth', '$pricePer3Months', '$pricePer6Months', '$pricePerYear', '$relativePath')";
                $result = mysqli_query($con, $qry);

                if (!$result) {
                    $message = "Error: " . mysqli_error($con);
                    $messageType = "error";
                } else {
                    $message = "Course added successfully!";
                    $messageType = "success";
                }
            } else {
                $message = "Error: There was a problem uploading your file. Please try again."; 
                $messageType = "error";
            }
        } else {
            $message = "Error: There was a problem with your upload. Invalid file type.";
            $messageType = "error";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Add New Course</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../css/bootstrap.min.css" />
    <link rel="stylesheet" href="../css/matrix-style.css" />
    <link rel="stylesheet" href="../css/matrix-media.css" />
    <link href="../font-awesome/css/fontawesome.css" rel="stylesheet" />
    <link href="../font-awesome/css/all.css" rel="stylesheet" />
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,800' rel='stylesheet' type='text/css'>
</head>
<body>

<!--Header-part-->
<div id="header">
  <h1><a href="dashboard.html">Perfect Gym Admin</a></h1>
</div>
<!--close-Header-part--> 


<!--top-Header-menu-->
<?php include 'includes/topheader.php'?>
<!--close-top-Header-menu-->
<!--start-top-serch-->
<!-- <div id="search">
  <input type="hidden" placeholder="Search here..."/>
  <button type="submit" class="tip-bottom" title="Search"><i class="fa-search fa-white"></i></button>
</div> -->
<!--close-top-serch-->

<!--sidebar-menu-->
<?php $page='add-equip'; include 'includes/sidebar.php'?>

<div id="content">
    <div id="content-header">
        <div id="breadcrumb"> <a href="dashboard.html" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#">Courses</a> <a href="#" class="current">Add Course</a> </div>
        <h1>Add New Course</h1>
    </div>
    <div class="container-fluid">
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
                        <h5>Course Info</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <?php if ($message != "") { ?>
                            <div class="alert alert-<?php echo $messageType; ?>">
                                <?php echo $message; ?>
                            </div>
                        <?php } ?>
                        <form action="addCourses.php" method="post" class="form-horizontal" enctype="multipart/form-data">
                            <div class="control-group">
                                <label class="control-label">Course Name :</label>
                                <div class="controls">
                                    <input type="text" class="span11" placeholder="Course name" name="name" required />
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Description :</label>
                                <div class="controls">
                                    <textarea class="span11" placeholder="Course description" name="description" required></textarea>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Price per Month :</label>
                                <div class="controls">
                                    <input type="text" class="span11" placeholder="Price per month" name="price_per_month" required />
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Price per 3 Months :</label>
                                <div class="controls">
                                    <input type="text" class="span11" placeholder="Price per 3 months" name="price_per_3months" required />
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Price per 6 Months :</label>
                                <div class="controls">
                                    <input type="text" class="span11" placeholder="Price per 6 months" name="price_per_6months" required />
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Price per Year :</label>
                                <div class="controls">
                                    <input type="text" class="span11" placeholder="Price per year" name="price_per_year" required />
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Image :</label>
                                <div class="controls">
                                    <input type="file" class="span11" name="image" required />
                                </div>
                            </div>
                            <div class="form-actions">
                                <button type="submit" class="btn btn-success" name="addCourse">Add Course</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row-fluid">
  <div id="footer" class="span12"> <?php echo date("Y");?> &copy; Developed By HASSAN ADAN</a> </div>
</div>


<script src="../js/jquery.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
</body>
</html>
