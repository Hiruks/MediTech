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

                    <h1 style="font-weight: 800; font-size: 2.5rem;">User Profile</h1>

                    <div class="container">
                        <div class="row">
                        <div class="col mt-4 innercont p-5 me-4">

                                
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
                                <?php
                                // print_r($this->session->userdata('userinfo'));
                                // print_r($myprofile);

                                echo "<table class='table'>";
                                $userId = 0;
                                foreach ($myprofile as $key => $value) {
                                    // print_r($value->id);
                                    $userId = $value->userid;
                                    echo "<tr>";
                                    echo "<td>";
                                    echo "User ID";
                                    echo "</td>";
                                    echo "<td>";
                                    echo $value->userid;
                                    echo "</td>";

                                    echo "</tr>";

                                    echo "<tr>";
                                    echo "<td>";
                                    echo "User Type";
                                    echo "</td>";
                                    echo "<td>";
                                    echo $value->userType;
                                    echo "</td>";

                                    echo "</tr>";

                                    echo "<tr>";
                                    echo "<td>";
                                    echo "Branch ID";
                                    echo "</td>";
                                    echo "<td>";
                                    echo $value->branchID;
                                    echo "</td>";

                                    echo "</tr>";
                                    echo "<tr>";
                                    echo "<td>";
                                    echo "Email";
                                    echo "</td>";
                                    echo "<td>";
                                    echo $value->email;
                                    echo "</td>";
                                    echo "</tr>";

                                    echo "<tr>";
                                    echo "<td>";
                                    echo "Name";
                                    echo "</td>";
                                    echo "<td>";
                                    echo $value->name;
                                    echo "</td>";
                                    echo "</tr>";

                                    echo "<tr>";
                                    echo "<td>";
                                    echo "Contact Number";
                                    echo "</td>";
                                    echo "<td>";
                                    echo $value->contactNo;
                                    echo "</td>";
                                    echo "</tr>";

                                    echo "<tr>";
                                    echo "<td>";
                                    echo "Registerd Date";
                                    echo "</td>";
                                    echo "<td>";
                                    echo $value->registered_date;
                                    echo "</td>";
                                    echo "</tr>";
                                }
                                echo "</table>";
                                ?>

                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>
</body>

</html>