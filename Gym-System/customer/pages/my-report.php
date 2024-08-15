<!DOCTYPE html>
<html lang="en">
<head>
    <title>Gym System</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../css/bootstrap.min.css" />
    <link rel="stylesheet" href="../css/bootstrap-responsive.min.css" />
    <link rel="stylesheet" href="../css/fullcalendar.css" />
    <link rel="stylesheet" href="../css/matrix-style.css" />
    <link rel="stylesheet" href="../css/matrix-media.css" />
    <link href="../font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link rel="stylesheet" href="../css/jquery.gritter.css" />
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,800' rel='stylesheet' type='text/css'>
    <style>
        /* Hide unwanted elements when printing */
        @media print {
            body * {
                visibility: hidden;
            }
            #content, #content * {
                visibility: visible;
            }
            #content {
                position: absolute;
                left: 0;
                top: 0;
            }
        }
        #footer {
            color: white;
        }
    </style>
</head>
<body>
    <!-- Header-part -->
    <div id="header">
        <h1><a href="index.php">Perfect Gym System</a></h1>
    </div>
    <!-- close-Header-part -->

    <!-- top-Header-menu -->
    <?php include '../includes/topheader.php'; ?>
    <!-- close-top-Header-menu -->

    <!-- sidebar-menu -->
    <?php $page = "report"; include '../includes/sidebar.php'; ?>
    <!-- close-sidebar-menu -->

    <?php
    include 'dbcon.php';
    include "session.php";

    $user_id = $_SESSION['user_id'];
    $qry = "SELECT * FROM members WHERE user_id=?";
    $stmt = mysqli_prepare($con, $qry);
    mysqli_stmt_bind_param($stmt, 'i', $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    ?>

    <!-- main-container-part -->
    <div id="content">
        <!-- Your report content here -->
        <div id="content-header">
            <div id="breadcrumb">
                <a href="index.php" title="Go to Home" class="tip-bottom">
                    <i class="icon-home"></i> Home
                </a>
                <a href="my-report.php" class="current">My Report</a>
            </div>
        </div>
        <div class="container-fluid">
            <!-- Report content goes here -->
            <div class="row-fluid">
                <div class="span12">
                    <div class="widget-box">
                        <div class="widget-content">
                            <!-- Report content details -->
                            <div class="row-fluid">
                                <div class="span4">
                                    <table class="">
                                        <tbody>
                                            <tr>
                                                <td><h4>Perfect GYM Club</h4></td>
                                            </tr>
                                            <tr>
                                                <td>Meru town, Gitimbine opposite car wash</td>
                                            </tr>
                                            <tr>
                                                <td>Tel: 074 567 8765 <br/>Tel:  076 443 6743</td>
                                            </tr>
                                            <tr>
                                                <td>Email: support@perfectgym.com</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="span8">
                                    <table class="table table-bordered table-invoice-full">
                                        <thead>
                                            <tr>
                                                <th class="head0">Membership ID</th>
                                                <th class="head1">Services Taken</th>
                                                <th class="head0 right">My Plans (Upto)</th>
                                                <th class="head1 right">Address</th>
                                                <th class="head0 right">Charge</th>
                                                <th class="head0 right">Attendance Count</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><div class="text-center">PGC-SS-<?php echo $row['user_id']; ?></div></td>
                                                <td><div class="text-center"><?php echo $row['services']; ?></div></td>
                                                <td><div class="text-center"><?php echo $row['plan']; ?> Month/s</div></td>
                                                <td><div class="text-center"><?php echo $row['address']; ?></div></td>
                                                <td><div class="text-center"><?php echo '$'.$row['amount']; ?></div></td>
                                                <td><div class="text-center"><?php echo $row['attendance_count']; ?> Day/s</div></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <table class="table table-bordered table-invoice-full">
                                        <tbody>
                                            <tr>
                                                <td class="msg-invoice" width="55%"> 
                                                    <div class="text-center">
                                                        <h4>Last Payment Done:  $<?php echo $row['amount']; ?>/-</h4>
                                                        <em><a href="#" class="tip-bottom" title="Registration Date" style="font-size:15px;">Member Since: <?php echo $row['dor']; ?></a></em>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="row-fluid">
                                <div class="pull-left">
                                    <h4>Dear Member <?php echo $row['fullname']; ?>,<br/> <br/>Your Membership is currently <?php echo $row['status']; ?>! <br/></h4>
                                    <p>Thank you for choosing our services.<br/>- on behalf of the whole team</p>
                                </div>
                                <div class="pull-right">
                                    <h4><span>Approved By:</span></h4>
                                    <img src="../img/report/stamp-sample.png" width="124px;" alt="">
                                    <p class="text-center">Note: AutoGenerated</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end-main-container-part -->

    <!-- Print Button -->
    <div class="text-center">
        <button class="btn btn-danger" onclick="printReport()">
            <i class="fas fa-print"></i> Print
        </button>
    </div>

    <!-- Footer and Scripts -->
    <div class="row-fluid">
        <div id="footer" class="span12"><?php echo date("Y");?> &copy; Developed By HASSAN ADAN</div>
    </div>

    <script src="../js/excanvas.min.js"></script>
    <script src="../js/jquery.min.js"></script>
    <script src="../js/jquery.ui.custom.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/jquery.flot.min.js"></script>
    <script src="../js/jquery.flot.resize.min.js"></script>
    <script src="../js/jquery.peity.min.js"></script>
    <script src="../js/fullcalendar.min.js"></script>
    <script src="../js/matrix.js"></script>
    <script src="../js/matrix.dashboard.js"></script>
    <script src="../js/jquery.gritter.min.js"></script>
    <script src="../js/matrix.interface.js"></script>
    <script src="../js/matrix.chat.js"></script>
    <script src="../js/jquery.validate.js"></script>
    <script src="../js/matrix.form_validation.js"></script>
    <script src="../js/jquery.wizard.js"></script>
    <script src="../js/jquery.uniform.js"></script>
    <script src="../js/select2.min.js"></script>
    <script src="../js/matrix.popover.js"></script>
    <script src="../js/jquery.dataTables.min.js"></script>
    <script src="../js/matrix.tables.js"></script>

    <script type="text/javascript">
        function printReport() {
            window.print();
        }
    </script>
</body>
</html>
