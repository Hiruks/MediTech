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


                    <h1 style="font-weight: 800; font-size: 2.5rem;">Create an order</h1>


                    <div class="container">
                        <div class="row">


                            <div class=" mt-4 innercont p-5 me-4">
                                <?php

                                if (isset($success)) {
                                    echo "<div class='alert alert-success'>";
                                    echo $success;
                                    echo "</div>";
                                }
                                if (isset($error)) {
                                    echo "<div class='alert alert-danger'>";
                                    echo $error;
                                    echo "</div>";
                                }
                                
                                ?>
                                

                                <!-- order addition card -->
                                
                                <h2>Customer Details</h2>
                                <div class="row alert">
                                    <label class="">Name : <?php echo $customer[0]->name ?></label>
                                    <label class="mt-2">Email : <?php echo $customer[0]->email ?></label>
                                    <label class="mt-2">Contact number : <?php echo $customer[0]->contactNo ?></label>
                                </div>


                                <?php echo form_open('login/addOrderSubmit/' . $customer[0]->custID) ?>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-4">
                                            <label>Value</label>
                                            <input type="text" name="value" class="form-control" placeholder="Enter order value">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group mb-4">

                                            <label >Select a credit terms:</label>
                                            
                                            <select name="type" class="form-control">
                                                <?php
                                                // Assuming $result contains the query result
                                                if ($terms) { // Extract ENUM values and split them into an array
                                                   
                                                    foreach ($terms as $option) {
                                                        $msg = 'Overdue after ' . $option->overdue_period . ' months | Blacklisted after ' . $option->blacklisted_period . ' months';
                                                        echo "<option value='$option->id'>$msg</option>";

                                                    }
                                                }

                                                ?>



                                            </select>


                                        </div>
                                    </div>

                                    <div class="col-md-12 mt-1">
                                        <div class="form-group">
                                            <input type="submit" class="btn btn-primary px-4" value="Add Customer"></input>
                                        </div>
                                    </div>

                                </div>
                                <?php echo form_close(); ?>
                            </div>




                            <!-- <div class=" mt-4 innercont p-5 me-4"> -->

                            <!-- table view -->
                            <!-- TODO -->




                            <!--</div> -->
                        </div>



                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</body>

</html>