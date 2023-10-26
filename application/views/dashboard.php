<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo site_url(); ?>css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
    <link href="<?php echo site_url(); ?>css/custom/dashboard.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Symbols+Sharp" rel="stylesheet" />


    <title>Dashboard ~ MediTech</title>
</head>

<body>
    <div class="container-fluid px-6">     
    <div class="row">
    <?php $this->load->view('/common/sidebar.php'); ?>

        <div class="dashboard-content col-10">
            
        <h1>hellooo</h1>
        <?php 
                    if(isset($success)){
                        echo "<div class='alert alert-success'>";
                        echo $success;
                        echo "</div>";
                    }
                    if(isset($error)){
                        echo "<div class='alert alert-danger'>";
                        echo $error;
                        echo "</div>";
                    }
                    
                ?> 
        </div>
    </div>     
    </div>
</body>

</html>