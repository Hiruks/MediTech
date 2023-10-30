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


                    <h1 style="font-weight: 800; font-size: 2.5rem;">Product Management</h1>

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
                        <div class="row">
                            <!-- Product Addition Page -->
                            
                            <div class="mt-4 innercont p-5 me-4">

                                <!-- Product addition card -->
                                <?php echo form_open_multipart('login/editProductSubmit/' . $info[0]->productID); ?>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-4">
                                            <label>Product Title</label>
                                            <input type="text" name="title" value="<?php echo $info[0]->title; ?>" class="form-control" placeholder="Enter product name">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group mb-4">
                                            <label>Product Image</label>
                                            <input type="file" name="userfile" class="form-control" placeholder="Enter customer email address" size="20" required>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group mb-4">
                                            <label>Description</label>
                                            <input type="textarea" name="description" value="<?php echo $info[0]->description; ?>"  class="form-control" style="height: 100px;" >
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <input type="submit" class="btn btn-primary px-4" value="Edit Product"></input>
                                        </div>
                                    </div>

                                </div>
                                <?php echo form_close(); ?>
                            </div>



                            <div class="mt-4 innercont p-5 me-4">

                                <!-- Products viewer -->

                                <div class="container">
                                    <div class="row">
                                        <?php foreach ($product as $card) : ?>
                                            <div class="col-md-4 mb-4">
                                                <div class="card">
                                                    <div class="text-center">
                                                        <img src="<?php echo site_url(); ?>/uploads/images/<?php echo $card->img; ?>" class="card-img-top prdimg" alt="...">
                                                    </div>
                                                    <div class="card-body mt-4 ">
                                                        <h5 class="card-title1"><?php echo $card->title; ?></h5>
                                                        <p class="card-text"> <?php echo $card->description; ?></p>
                                                        <hr>
                                                        <div class="d-flex justify-content-between">
                                                            <div>
                                                                <div class="flex">
                                                                <a href="<?php echo site_url(); ?>login/editProduct/<?php echo $card->productID; ?>" class="btn btn-success btn-sm">Edit</a>
                                                                    
                                                                    <a href="<?php echo site_url(); ?>login/delProduct/<?php echo $card->productID; ?>" class="btn btn-danger btn-sm">Delete</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        <?php endforeach; ?>



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