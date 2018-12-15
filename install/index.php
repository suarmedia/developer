<?php
session_start();

if (!function_exists('curl_init')) {
    die('cURL is not available on your server! Please enable cURL to continue the installation. You can read the documentation for more information.');
}

function currentUrl($server)
{
    $http = 'http';
    if (isset($server['HTTPS'])) {
        $http = 'https';
    }
    $host = $server['HTTP_HOST'];
    $requestUri = $server['REQUEST_URI'];
    return $http . '://' . htmlentities($host) . '/' . htmlentities($requestUri);
}

$current_url = currentUrl($_SERVER);

if (isset($_POST["btn_license_code"])) {

    $_SESSION["license_code"] = $_POST['license_code'];
    $response = "";

    $url = "http://license.codingest.com/api/check_varient_license_code?license_code=" . $_POST['license_code'] . "&domain=" . $current_url;

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);

    if (empty($response)) {
        $url = "https://license.codingest.com/api/check_varient_license_code?license_code=" . $_POST['license_code'] . "&domain=" . $current_url;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
    }

    $data = json_decode($response);

    if (!empty($data)) {

        if ($data->code == "error") {
            $_SESSION["error"] = "Invalid License Code!";
        } else {
            $_SESSION["purchase_code"] = $data->code;
            header("Location: folder-permissions.php");
            exit();
        }
    } else {
        $_SESSION["error"] = "Invalid License Code!";
    }

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
                                <div class="step-progress-line" data-now-value="33.33" data-number-of-steps="3" style="width: 33.33%;"></div>
                            </div>
                            <div class="step active">
                                <div class="step-icon"><i class="fa fa-code"></i></div>
                                <p>Start</p>
                            </div>
                            <div class="step">
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
                                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                                    <div class="tab-content">
                                        <div class="tab_1">
                                            <h1 class="step-title">Start</h1>

                                            <div class="form-group text-center">
                                                <a href="http://license.codingest.com/varient-license" target="_blank" class="btn btn-success btn-custom">Get License Code</a>
                                            </div>

                                            <div class="form-group">
                                                <label for="email">License Code</label>
                                                <textarea name="license_code" class="form-control form-input" style="resize: vertical; height: 100px;line-height: 24px;padding: 10px;" placeholder="Enter License Code" required><?php echo @$_SESSION["license_code"]; ?></textarea>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="tab-footer">
                                        <button type="submit" name="btn_license_code" class="btn-custom pull-right">Next</button>
                                    </div>
                                </form>
                            </div>
                        </div>


                    </div>
                </div>
            </div>


        </div>


    </div>


</div>


<?php

unset($_SESSION["error"]);
unset($_SESSION["success"]);

?>

</body>
</html>
