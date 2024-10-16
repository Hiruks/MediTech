<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login ~ MediTech</title>
    <link rel="stylesheet" href="<?php echo site_url(); ?>css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo site_url(); ?>css/custom/login.css">
</head>

<body>
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="row border rounded-5 p-3 bg-white shadow box-area">
            <div class="col-md-6 rounded-4 d-flex justify-content-center align-items-center left-box flex-column" style="background: rgb(212, 216, 224);">
                <div class="featured-image">
                    <img src="<?php echo site_url(); ?>images/logo-transparent.png" class="img-fluid" style="width : 250px">
                </div>
            </div>
            <div class="col-md-6 right-box">
                <div class="row align-items-center ">
                    <div class="header-text mt-4 ps-4 ">
                        <p class="fs-5" class="nice-font">Login</p>
                        <p class="fs-6">Hello, happy to have you back!</p>
                    </div>
                    <div class="reserved">

                    <?php
                   
                   if (isset($success)) {
                        echo "<div class='alert alert-success px-6'>";
                        echo $success;
                        echo "</div>";
                    }
                    if (isset($error)) {
                        echo "<div class='alert alert-danger px-6'>";
                        echo $error;
                        echo "</div>";
                    }
                    ?>

                
                   
                   <?php echo validation_errors('<div class="alert alert-danger px-6">', '</div>'); ?>


                    <?php echo form_open('login/loginSubmit') ?>
                    <table class="table table-borderless">
                        <tr>
                            <td>
                                <input class="form-control" type="text" name="email" placeholder="Login Email">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input class="form-control" type="password" name="password" placeholder="Password">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input class="btn btn-primary" type="submit" name="submit" value="Login">
                            </td>
                        </tr>
                    </table>
                    <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>