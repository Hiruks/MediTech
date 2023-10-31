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


                    <h1 style="font-weight: 800; font-size: 2.5rem;">User Management</h1>
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




                                <div class="d-flex mb-3">

                                    <a href="<?php echo site_url(); ?>/login/adduser" class="btn btn-primary">Add user</a>

                                </div>

                                <!-- table view -->


                                <table class="table">

                                    <thead>
                                        <tr>
                                            <th>User ID</th>
                                            <th>User Name</th>
                                            <th>Branch ID</th>
                                            <th>Contact Number</th>
                                            <th>Email</th>
                                            <th>User Type</th>
                                            <th>Registered Date</th>
                                        </tr>
                                    </thead>

                                    <body>
                                        <?php foreach ($user as $row) : ?>

                                            <tr>
                                                <td><?php echo $row->userid; ?></td>
                                                <td><?php echo $row->name; ?></td>
                                                <td><?php echo $row->branchID; ?></td>
                                                <td><?php echo $row->contactNo; ?></td>
                                                <td><?php echo $row->email; ?></td>
                                                <td><?php echo $row->userType; ?></td>
                                                <td><?php echo $row->registered_date; ?></td>

                                                <td>
                                                    <div class="flex">
                                                    <a href="<?php echo site_url(); ?>login/editUser/<?php echo $row->userid; ?>" class="btn btn-success btn-sm">Edit</a>
                                                        <a href="<?php echo site_url(); ?>login/delUser/<?php echo $row->userid; ?>" class="btn btn-danger btn-sm">Delete</a>
                                                    </div>


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