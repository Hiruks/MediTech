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


                    <h1 style="font-weight: 800; font-size: 2.5rem;">Blacklist</h1>
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
                                <?php echo form_open('login/searchSubmit'); ?>

                                <div class="form-group mb-4 d-flex">
                                    <input type="text" name="value" class="form-control" placeholder="Search customer name">
                                    <input type="submit" class="btn btn-primary px-4 mx-4" value="Search"></input>
                                </div>
                                <?php echo form_close(); ?>

                                <!-- table view -->


                                <table class="table">

                                    <thead>
                                        <tr>
                                            <th>Customer ID</th>
                                            <th>Customer Name</th>
                                            <th>Email</th>
                                            <th>Contact Number</th>
                                            <th>Registered Date</th>
                                        </tr>
                                    </thead>

                                    <body>

                                        <?php foreach ($customer as $row) : ?>

                                            <tr>
                                                <td><?php echo $row->custID; ?></td>
                                                <td><?php echo $row->name; ?></td>
                                                <td><?php echo $row->email; ?></td>
                                                <td><?php echo $row->contactNo; ?></td>
                                                <td><?php echo $row->registered_date; ?></td>

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