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


                    <h1 style="font-weight: 800; font-size: 2.5rem;">Update Order</h1>
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
                            <div class="col mt-4 innercont p-5 me-4">



                                <div class="card" style="border : none;">
                                    <div class="card-body">
                                        <div class="container mb-6 mt-3">
                                            <div class="row d-flex align-items-baseline">
                                                <div class="col-xl-9">
                                                    <p style="font-size: 20px;">Invoice &gt;&gt; <strong>ID: <?php echo $orders[0]->id; ?></strong></p>
                                                </div>
                                                <?php if ($orders[0]->isPaid == "0") { ?>
                                                <div class="col-xl-3">
                                                <a href="<?php echo site_url(); ?>login/orderUpdateForm/<?php echo $orders[0]->id ?>" class="btn btn-success shadow me-6" style="width=100px;">Confirm Payment<i class="fas fa-check-circle ms-2"></i></a>
                                                </div>
                                                <?php }?>
                                            </div>
                                            <div class="container">

                                                <div class="row mt-5 mb-5">
                                                    <div class="col-xl-9">
                                                        <ul class="list-unstyled">
                                                            <li class="text-muted mt-2">To: <span style=""><?php echo $orders[0]->name; ?></span></li>
                                                            <li class="text-muted mt-2"><i class="fas fa-envelope"></i> <?php echo $orders[0]->email; ?></li>

                                                            <li class="text-muted mt-2"><i class="fas fa-phone"></i> <?php echo $orders[0]->contactNo; ?></li>
                                                        </ul>
                                                    </div>
                                                    <div class="col-xl-3">
                                                        <p class="text-muted">Invoice</p>
                                                        <ul class="list-unstyled">
                                                            <li class="text-muted"><i class="fas fa-circle" style="color:#8f8061 ;"></i> <span class="fw-bold">ID: </span><?php echo $orders[0]->id; ?></li>
                                                            <li class="text-muted"><i class="fas fa-circle" style="color:#8f8061 ;"></i> <span class="fw-bold">Creation Date: </span><?php echo $orders[0]->created_date; ?></li>
                                                            <li class="text-muted"><i class="fas fa-circle" style="color:#8f8061;"></i> <span class="me-1 fw-bold">Status:</span><span <?php

                                                                                                                                                                                        if ($orders[0]->isPaid == 1) {
                                                                                                                                                                                            echo "class='text-success'";
                                                                                                                                                                                        } else {

                                                                                                                                                                                            echo "class='text-danger'";
                                                                                                                                                                                        }
                                                                                                                                                                                        ?>><?php

                                                                                                                                                                                            if ($orders[0]->isPaid == 1) {

                                                                                                                                                                                                echo "Paid";
                                                                                                                                                                                            } else {

                                                                                                                                                                                                echo "Unpaid";
                                                                                                                                                                                            }
                                                                                                                                                                                            ?></span></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <hr>

                                                <?php foreach ($products as $product) : ?>
                                                    <div class="row my-2 mx-1 justify-content-center">
                                                        <div class="col-md-2 mb-4 mb-md-0">
                                                            <div class="bg-image ripple rounded-5 mb-4 overflow-hidden d-block " data-ripple-color="light">

                                                                <img src="<?php echo site_url(); ?>/uploads/images/<?php echo $product->img; ?>" class="w-100" height="200px" alt="<?php echo $product->description; ?>" />

                                                                <a href="#!">
                                                                    <div class="hover-overlay">
                                                                        <div class="mask" style="background-color: hsla(0, 0%, 98.4%, 0.2)"></div>
                                                                    </div>
                                                                </a>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-7 mb-4 mb-md-0">
                                                            <p class="fw-bold"><?php echo $product->title; ?> x <?php echo $product->quantity; ?></p>
                                                            <p class="mb-1">
                                                                <span><?php echo $product->description; ?></span>
                                                            </p>
                                                            <p class="mb-1">
                                                                <span>x <?php echo $product->quantity; ?></span>
                                                            </p>
                                                        </div>
                                                        <div class="col-md-3 mb-4 mb-md-0">
                                                            <h5 class="mb-2">
                                                                <span class="align-middle">Rs <?php echo $product->price; ?></span>
                                                            </h5>
                                                        </div>
                                                    </div>
                                                <hr>

                                                <?php endforeach; ?>

                                                
                                                <div class="row">
                                                    <div class="col-xl-8">
                                                        <?php $msg = 'Overdue after ' . $credit[0]->overdue_period . ' months | Blacklisted after ' . $credit[0]->blacklisted_period . ' months'; ?>
                                                        <p class="ms-3"><?php echo $msg; ?></p>
                                                    </div>
                                                    <div class="col-xl-3">
                                                        <ul class="list-unstyled">
                                                            <li class="text-muted ms-3"><span class="text-black me-4">SubTotal</span>Rs <?php echo $orders[0]->value; ?></li>
                                                        </ul>
                                                        <p class="text-black float-start"><span class="text-black me-3"> Total Amount</span><span style="font-size: 25px;">Rs <?php echo $orders[0]->value; ?></span></p>
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
        </div>
    </div>
</body>

</html>