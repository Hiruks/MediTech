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


                    <h1 style="font-weight: 800; font-size: 2.5rem;">Order Management</h1>
                    <?php

                    if (isset($success)) {
                        echo "<div class='alert alert-success' style='z-index: -1;'>";
                        echo $success;
                        echo "</div>";
                    }
                    if (isset($error)) {
                        echo "<div class='alert alert-danger' style='z-index: -1;'>";
                        echo $error;
                        echo "</div>";
                    }
                    ?>


                    <div class="container">
                        <div class="mt-4 innercont p-5 me-4" style="box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
                            <div class="d-flex justify-content-center align-items-center">
                                
                                <div class="rounded p-3 shadow" style="max-height: 400px; max-width: 300px;">
                                    
                                    <img src="<?php echo site_url(); ?>/uploads/recipts/<?php echo $records[0]->img; ?>" alt="Receipt Image" class="img-fluid" style="border-radius: var(--card-border-radius);">
                                </div>

                                
                                <div class="ms-4 row">
                                    <h4 class="fw-bold mb-0 col">Receipt Number:</h4>
                                    <h4 class="fw-bold mb-0 col"><?php echo $records[0]->reciptNo; ?></h4>
                                    
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
</body>

</html>