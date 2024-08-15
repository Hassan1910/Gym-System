<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Perfect Gym Club</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="manifest" href="site.webmanifest">
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.ico">

    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f0f0f0;
        }
        .container {
            text-align: center;
        }
        .btn {
            display: block;
            padding: 15px 30px;
            margin: 10px auto;
            font-size: 18px;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        .btn-customer {
            background-color: #4CAF50; /* Green */
        }
        .btn-staff {
            background-color: #008CBA; /* Blue */
        }
        .btn-signup {
            background-color: #FF5733; /* Custom color for Sign Up button */
        }
        .btn-customer:hover {
            background-color: #45a049;
        }
        .btn-staff:hover {
            background-color: #007bb5;
        }
        .btn-signup:hover {
            background-color: #e64e20; /* Darker shade for Sign Up button */
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="customer/index.php" class="btn btn-customer">Customer Login</a>
        <!-- <a href="customer/pages/register-cust.php" class="btn btn-staff btn-signup">SIGN UP</a> -->

        <a href="staff/index.php" class="btn btn-staff">Staff Login</a>

        <div class="g">
            <a href="../index.php"><h6>Go Back</h6></a>
        </div>
    </div>
</body>
</html>
