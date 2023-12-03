<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo site_url(); ?>css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
    <link href="<?php echo site_url(); ?>css/custom/dashboard.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Symbols+Rounded" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <link rel="stylesheet" href="<?php echo site_url(); ?>css/custom/nav.css">
    <link href="<?php echo site_url(); ?>css/custom/public-dashboard.css" rel="stylesheet" />


    <title>Dashboard ~ MediTech</title>
</head>

<body>

    <div class="container-fluid px-6">
        <div class="row">
            <?php $this->load->view('/common/nav.php'); ?>
        </div>
        <div class="row">
            <?php $this->load->view('/common/sidebar.php'); ?>

            <div class="dashboard-content col-10">

                <div class="dynamic-page container m-2">


                    <h1 style="font-weight: 800; font-size: 2.5rem;">Dashboard</h1>

                    <?php

                    if (isset($success)) {
                        echo "<div class='alert alert-success mt-3' style='z-index: -1;'>";
                        echo $success;
                        echo "</div>";
                    }
                    if (isset($error)) {
                        echo "<div class='alert alert-danger mt-3' style='z-index: -1;'>";
                        echo $error;
                        echo "</div>";
                    }
                    ?>
                    <div class="container">
                        <div class="row">
                            <div class="col mt-4  p-2">

                                <div class="row justify-content-between flex d-flex">
                                    <!-- Upper Data bar -->
                                    <div class="col-sm-4">
                                        <div class="me-3 innercont p-4">
                                            <div class="value-part d-flex row justify-content-between">
                                                <div class="title col d-flex align-items-center">
                                                    <h2 style="font-weight: 400;">Orders</h2>
                                                    <i class="fas fa-shopping-cart ms-auto fa-lg"></i> 
                                                </div>
                                                <h1 style="font-weight: 600; font-size: 2.7rem;" class="mt-1">82</h1>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="mx-1 innercont p-4">
                                            <div class="value-part d-flex row justify-content-between">
                                                <div class="title col d-flex align-items-center">
                                                    <h2 style="font-weight: 400;">Customers</h2>
                                                    <i class="fas fa-users ms-auto fa-lg"></i>
                                                </div>
                                                <h1 style="font-weight: 600; font-size: 2.7rem;" class="mt-1">53</h1>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="ms-3 innercont p-4">
                                            <div class="value-part d-flex row justify-content-between">
                                                <div class="title col d-flex align-items-center">
                                                    <h2 style="font-weight: 400;">Overdue Orders</h2>
                                                    <i class="fas fa-exclamation-triangle ms-auto fa-lg"></i>

                                                </div>
                                                <h1 style="font-weight: 600; font-size: 2.7rem;" class="mt-1">6</h1>
                                            </div>
                                        </div>
                                    </div>
                                </div>



                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>