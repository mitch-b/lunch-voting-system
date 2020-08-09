<?php
include('../include/security.inc.php');
if ($_SESSION['access'] == "administrator") {
?>
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>mitchbarry.com | cpanel</title>
        <link href="../assets/mitchbarry.css" rel="stylesheet" type="text/css" />
        <script src="../include/js/jquery-1.3.2.js"></script>
        <script src="../include/js/jquery.jgrowl.js"></script>
        <script src="../assets/custom.js"></script>
    </head>

    <body>
        <div id="container">
            <?php include("../include/left_column.php"); ?>
            <div id="center_column">
                <h4>CMS Control Panel</h4>
                <div id="cmsfunc">
                    <dt>Add New User</dt>
                    <dd><?php include("cpanel/adduser.php"); ?><br /><br /></dd>
                </div>
            </div>
            <div id="right_column">
                <h4>Links</h4>
                <a href="./logout.php">logout</a><br />
            </div>
        </div>
    </body>

    </html>
<?php
} else {
?>
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Forbidden</title>
        <link href="../assets/mitchbarry.css" rel="stylesheet" type="text/css" />
    </head>

    <body>
        <div id="container">
            <?php include("../include/left_column.php"); ?>
            <div id="center_column">
                <h4>Requested Resource Forbidden</h4>
                <p>You are just a user with permission : <?php echo $_SESSION['access']; ?> </p>
                <a href="javascript:history.back()">return</a>
            </div>
            <div id="right_column">
            </div>
        </div>
    </body>

    </html>
<?php } ?>