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
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


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
                        <div class="row">

                            <div class=" mt-4 innercont p-5 me-4">
                                <div class="d-flex box-button">

                                    <a href="<?php echo site_url(); ?>/login/selectCustomer" class="btn btn-primary shadow"><span class="material-icons custom-icon">shopping_cart</span> Add Order</a>
                                    <a href="<?php echo site_url(); ?>/login/addcustomer" class="btn btn-primary mx-4 shadow"><span class="material-icons custom-icon">person</span> New Customer</a>

                                </div>
                            </div>

                            <div class=" mt-4 innercont p-5 me-4">



                                <?php echo form_open('login/searchOrderSubmit'); ?>

                                <div class="form-group mb-4 d-flex">
                                    <input type="text" name="value" class="form-control" placeholder="Search order by customer">
                                    <input type="submit" class="btn btn-primary px-4 mx-4" value="Search"></input>
                                </div>
                                <?php echo form_close(); ?>

                                <!-- table view -->


                                <table class="table">

                                    <thead>
                                        <tr>
                                            <th>Order ID</th>
                                            <th>Customer Name</th>
                                            <th>Value</th>
                                            <th>Status</th>
                                            <th>Created Date</th>
                                        </tr>
                                    </thead>

                                    <body>

                                        <?php foreach ($orders as $order) : ?>

                                            <tr>


                                                <td><?php echo $order->id; ?></td>
                                                <td><?php echo $order->name ?></td>
                                                <td><?php echo $order->value; ?></td>
                                                <td <?php

                                                    if ($order->isPaid == 1) {
                                                        echo "class='text-success'";
                                                    } else {

                                                        echo "class='text-danger'";
                                                    }
                                                    ?>><?php

                                                    if ($order->isPaid == 1) {

                                                        echo "Paid";
                                                    } else {

                                                        echo "Unpaid";

                                                        
                                                    if($order->isOverdue == 1){
                                                        echo "<div class='ms-3 pt-1 pb-1 px-2 alert alert-warning alert-dismissible fade show d-inline-block row' role='alert' type='button' data-dismiss='alert' style=' ' aria-label='Close' aria-hidden='true'>
                                                        Overdue
                                                        
                                                      </div>";
                                                    }
                                                    

                                                    }
                                                    ?></td>
                                                <td><?php echo $order->created_date; ?></td>
                                                <td>
                                                <div class="flex">
                                                    <a href="<?php echo site_url(); ?>login/orderUpdate/<?php echo $order->id; ?>" class="btn btn-success shadow-sm btn-sm"><?php if ($order->isPaid == 1) {?>Details <?php } else{?>Update<?php }?></a>
                                                </div>
                                                </td>

                                                <td>
                                                    
                                                </td>



                                            </tr>
                                        <?php endforeach; ?>
                                    </body>

                                </table>





                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>