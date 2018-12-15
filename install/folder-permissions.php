<?php
session_start();

if (!isset($_SESSION["purchase_code"])) {
    $_SESSION["error"] = "Invalid purchase code!";
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Varient - Installer</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../assets/vendor/bootstrap/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,500,700" rel="stylesheet">
    <!-- Font-awesome CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet"/>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<div class="container">
    <div class="row">
        <div class="col-md-8 col-sm-12 col-md-offset-2">

            <div class="row">
                <div class="col-sm-12 logo-cnt">
                    <h1 class="logo">Varient</h1>
                    <h1>Welcome to the Installer</h1>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">

                    <div class="install-box">


                        <div class="steps">
                            <div class="step-progress">
                                <div class="step-progress-line" data-now-value="66.66" data-number-of-steps="3" style="width: 66.66%;"></div>
                            </div>
                            <div class="step">
                                <div class="step-icon"><i class="fa fa-code"></i></div>
                                <p>Start</p>
                            </div>
                            <div class="step active">
                                <div class="step-icon"><i class="fa fa-folder-open"></i></div>
                                <p>Folder Permissions</p>
                            </div>
                            <div class="step">
                                <div class="step-icon"><i class="fa fa-database"></i></div>
                                <p>Database</p>
                            </div>
                            <div class="step">
                                <div class="step-icon"><i class="fa fa-user"></i></div>
                                <p>Admin</p>
                            </div>
                        </div>

                        <div class="messages">
                            <?php if (isset($_SESSION["success"])): ?>
                                <div class="alert alert-success">
                                    <strong><?php echo $_SESSION["success"]; ?></strong>
                                </div>
                            <?php elseif (isset($_SESSION["error"])): ?>
                                <div class="alert alert-danger">
                                    <strong><?php echo $_SESSION["error"]; ?></strong>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="step-contents">
                            <div class="tab-1">
                                <h1 class="step-title">Folder Permissions</h1>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <p><i class="fa fa-folder-open"></i> application/cache</p>
                                        <p><i class="fa fa-folder-open"></i> application/session</p>
                                        <p><i class="fa fa-folder-open"></i> application/language</p>
                                        <p><i class="fa fa-folder-open"></i> uploads/audios</p>
                                        <p><i class="fa fa-folder-open"></i> uploads/blocks</p>
                                        <p><i class="fa fa-folder-open"></i> uploads/files</p>
                                        <p><i class="fa fa-folder-open"></i> uploads/gallery</p>
                                        <p><i class="fa fa-folder-open"></i> uploads/images</p>
                                        <p><i class="fa fa-folder-open"></i> uploads/logo</p>
                                        <p><i class="fa fa-folder-open"></i> uploads/profile</p>
                                        <p><i class="fa fa-folder-open"></i> uploads/thumbnails</p>
                                        <p><i class="fa fa-folder-open"></i> uploads/tmp</p>
                                        <p><i class="fa fa-folder-open"></i> uploads/videos</p>
                                    </div>
                                    <div class="col-sm-6 text-right">
                                        <p><?php if (is_writable('../application/cache')) { ?><i class="fa fa-check text-success"></i><?php } else { ?><i class="fa fa-close text-danger"></i><?php } ?></p>
                                        <p><?php if (is_writable('../application/session')) { ?><i class="fa fa-check text-success"></i><?php } else { ?><i class="fa fa-close text-danger"></i><?php } ?></p>
                                        <p><?php if (is_writable('../application/language')) { ?><i class="fa fa-check text-success"></i><?php } else { ?><i class="fa fa-close text-danger"></i><?php } ?></p>
                                        <p><?php if (is_writable('../uploads/audios')) { ?><i class="fa fa-check text-success"></i><?php } else { ?><i class="fa fa-close text-danger"></i><?php } ?></p>
                                        <p><?php if (is_writable('../uploads/blocks')) { ?><i class="fa fa-check text-success"></i><?php } else { ?><i class="fa fa-close text-danger"></i><?php } ?></p>
                                        <p><?php if (is_writable('../uploads/files')) { ?><i class="fa fa-check text-success"></i><?php } else { ?><i class="fa fa-close text-danger"></i><?php } ?></p>
                                        <p><?php if (is_writable('../uploads/gallery')) { ?><i class="fa fa-check text-success"></i><?php } else { ?><i class="fa fa-close text-danger"></i><?php } ?></p>
                                        <p><?php if (is_writable('../uploads/images')) { ?><i class="fa fa-check text-success"></i><?php } else { ?><i class="fa fa-close text-danger"></i><?php } ?></p>
                                        <p><?php if (is_writable('../uploads/logo')) { ?><i class="fa fa-check text-success"></i><?php } else { ?><i class="fa fa-close text-danger"></i><?php } ?></p>
                                        <p><?php if (is_writable('../uploads/profile')) { ?><i class="fa fa-check text-success"></i><?php } else { ?><i class="fa fa-close text-danger"></i><?php } ?></p>
                                        <p><?php if (is_writable('../uploads/thumbnails')) { ?><i class="fa fa-check text-success"></i><?php } else { ?><i class="fa fa-close text-danger"></i><?php } ?></p>
                                        <p><?php if (is_writable('../uploads/tmp')) { ?><i class="fa fa-check text-success"></i><?php } else { ?><i class="fa fa-close text-danger"></i><?php } ?></p>
                                        <p><?php if (is_writable('../uploads/videos')) { ?><i class="fa fa-check text-success"></i><?php } else { ?><i class="fa fa-close text-danger"></i><?php } ?></p>
                                    </div>
                                </div>

                                <div class="buttons">
                                    <a href="index.php" class="btn btn-success btn-custom pull-left">Prev</a>
                                    <a href="database.php" class="btn btn-success btn-custom pull-right">Next</a>
                                </div>

                            </div>
                        </div>


                    </div>
                </div>
            </div>


        </div>


    </div>


</div>

<style>
    .text-success {
        color: #41AD49;
    }
</style>

</body>
</html>

