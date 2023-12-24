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
    <script src="<?php echo base_url('script/echarts.min.js') ?>"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>


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

                    <div class="row">
                        <h1 style="font-weight: 800; font-size: 2.5rem;" class='col-md-2'>Dashboard</h1>



                    </div>

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
                            <div class="col mt-2  p-2">


                                <!-- Date selector -->

                                <div class="row  innercont mx-1 mb-4 d-flex">
                                    <?php $selectedMonth = $month; ?>


                                    <div class="align-items-center mb-4 col-md-10 pt-4 ps-4">
                                        <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                                            <input type="radio" class="btn-check" name="btnradio" id="btnradio1" autocomplete="off" <?php if ($selectedMonth > 12) { ?> checked>
                                        <?php } else { ?>
                                            >
                                        <?php } ?>
                                        <label class="btn btn-outline-primary" for="btnradio1" onclick="toggleDropdown('yearDropdown', 'productDropdown'), changeYear()">Yearly</label>

                                        <input type="radio" class="btn-check" name="btnradio" id="btnradio2" autocomplete="off" <?php if ($selectedMonth <= 12) { ?> checked>
                                    <?php } else { ?>
                                        >
                                    <?php } ?>
                                    <label class="btn btn-outline-primary" for="btnradio2" onclick="toggleDropdown('productDropdown', 'yearDropdown'), changeMonth()">Monthly</label>
                                        </div>
                                    </div>
                                    <div class="  align-items-center mb-4 col-md-2 pt-4 ps-5">



                                    <!-- Month Selector -->  

                                        <select id="productDropdown" name="product_id" class="form-control" style="width:100px; <?php if ($selectedMonth > 12) { ?>display:none;<?php } ?>">
                                            <option value="1" <?php if ($selectedMonth == 1) echo "selected"; ?>>Jan</option>
                                            <option value="2" <?php if ($selectedMonth == 2) echo "selected"; ?>>Feb</option>
                                            <option value="3" <?php if ($selectedMonth == 3) echo "selected"; ?>>Mar</option>
                                            <option value="4" <?php if ($selectedMonth == 4) echo "selected"; ?>>Apr</option>
                                            <option value="5" <?php if ($selectedMonth == 5) echo "selected"; ?>>May</option>
                                            <option value="6" <?php if ($selectedMonth == 6) echo "selected"; ?>>Jun</option>
                                            <option value="7" <?php if ($selectedMonth == 7) echo "selected"; ?>>Jul</option>
                                            <option value="8" <?php if ($selectedMonth == 8) echo "selected"; ?>>Aug</option>
                                            <option value="9" <?php if ($selectedMonth == 9) echo "selected"; ?>>Sep</option>
                                            <option value="10" <?php if ($selectedMonth == 10) echo "selected"; ?>>Oct</option>
                                            <option value="11" <?php if ($selectedMonth == 11) echo "selected"; ?>>Nov</option>
                                            <option value="12" <?php if ($selectedMonth == 12) echo "selected"; ?>>Dec</option>
                                        </select>



                                    <!-- Year Selector -->  

                                        <select id="yearDropdown" name="year" class="form-control" style="width:100px; <?php if ($selectedMonth <= 12) { ?>display:none;<?php } ?>">
                                            <?php
                                            $currentYear = date('Y');
                                            for ($i = $currentYear; $i >= $currentYear - 10; $i--) {
                                                echo "<option value=\"$i\"";
                                                if ($selectedMonth == $i) {
                                                    echo " selected";
                                                }
                                                echo ">$i</option>";
                                            }
                                            ?>
                                        </select>




                                        <div>

                                            <script>
                                                let selectedValue = document.getElementById("productDropdown").value;
                                                //console.log(<?php echo $selectedMonth ?>);
                                                // Function to update the href attribute of the "Add Product" link
                                                function changeMonth() {
                                                    const dropdown = document.getElementById("productDropdown");
                                                    const newSelectedValue = dropdown.value;

                                                    console.log(selectedValue);
                                                    //const selectedProduct = $products.find(product => product.productID === selectedValue);
                                                    //console.log(selectedValue);
                                                    //console.log(selectedProduct);

                                                    if (newSelectedValue !== selectedValue) {
                                                        selectedValue = newSelectedValue;

                                                        const data = {
                                                            value: selectedValue
                                                        };

                                                        // Create an XMLHttpRequest object
                                                        $.ajax({
                                                            url: "<?php echo site_url(); ?>login/refreshdash/",
                                                            data: data,
                                                            method: "GET",
                                                            success: function(response) {

                                                                console.log(response);
                                                                window.location.href = "<?php echo site_url(); ?>login/dashboard/" + selectedValue;
                                                                //break;
                                                            },
                                                            error: function(jqXHR, textStatus, errorThrown) {
                                                                console.log("AJAX Request Failed: " + errorThrown);
                                                            }
                                                        });
                                                    }

                                                }
                                                $("#productDropdown").change(changeMonth);


                                                //changeMonth();
                                            </script>

                                        </div>



                                        <div>
                                            <script>
                                                //let selectedValue = document.getElementById("productDropdown").value;

                                                function toggleDropdown(showId, hideId) {
                                                    let e = "productDropdown";
                                                    let s = "yearDropdown";

                                                    //if(!>12){
                                                    document.getElementById(showId).style.display = "block";
                                                    document.getElementById(hideId).style.display = "none";
                                                    //}else {
                                                    //     document.getElementById(s).style.display = "block";
                                                    // document.getElementById(e).style.display = "none";
                                                    // }


                                                }

                                                function changeYear() {
                                                    const dropdown = document.getElementById("yearDropdown");
                                                    const newSelectedValue = dropdown.value;

                                                    console.log(selectedValue);
                                                    //const selectedProduct = $products.find(product => product.productID === selectedValue);
                                                    //console.log(selectedValue);
                                                    //console.log(selectedProduct);

                                                    if (newSelectedValue !== selectedValue) {
                                                        selectedValue = newSelectedValue;

                                                        const data = {
                                                            value: selectedValue
                                                        };

                                                        // Create an XMLHttpRequest object
                                                        $.ajax({
                                                            url: "<?php echo site_url(); ?>login/refreshdash/",
                                                            data: data,
                                                            method: "GET",
                                                            success: function(response) {

                                                                console.log(response);
                                                                window.location.href = "<?php echo site_url(); ?>login/dashboard/" + selectedValue;
                                                                //break;
                                                            },
                                                            error: function(jqXHR, textStatus, errorThrown) {
                                                                console.log("AJAX Request Failed: " + errorThrown);
                                                            }
                                                        });
                                                    }
                                                }

                                                function updateDropdown() {
                                                    const ydropdown = document.getElementById("yearDropdown");
                                                    const mdropdown = document.getElementById("productDropdown");
                                                    if (ydropdown.outerHTML.includes == "checked>") {
                                                        toggleDropdown('yearDropdown', 'productDropdown');
                                                    }
                                                }

                                                $("#yearDropdown").change(changeYear);
                                                //$("#yearDropdown").update(updateDropdown);
                                                //$("#productDropdown").update(updateDropdown);

                                                //changeYear();
                                            </script>
                                        </div>
                                    </div>

                                </div>


                                <!-- Top Data Cards -->  
                                <div class="row justify-content-between flex d-flex">
                                        <!-- Orders -->
                                    <div class="col-sm-4" style="height:auto;">
                                        <div class="me-3 innercont p-4 ">
                                            <div class="value-part d-flex row justify-content-between pb-4">
                                                <div class="title col d-flex align-items-center">
                                                    <h2 style="font-weight: 400;">Orders</h2>
                                                    <i class="fas fa-shopping-cart ms-auto fa-lg"></i>
                                                </div>
                                                <h1 style="font-weight: 600; font-size: 2.7rem;" class="mt-1">
                                                    +<?php
                                                        $noOfOrders = 0;
                                                        foreach ($orders as $order) {
                                                            if ($order) {
                                                                $noOfOrders++;
                                                            }
                                                        }
                                                        echo $noOfOrders;
                                                        ?>
                                                </h1>
                                            </div>
                                            <div class="skill">
                                                <div class="skill-name">Paid Percentage</div>
                                                <div class="skill-bar">
                                                    <div class="skill-per" per="<?php
                                                                                $noOfOrdersP = 0;
                                                                                foreach ($orders as $order) {
                                                                                    if ($order->isPaid) {
                                                                                        $noOfOrdersP++;
                                                                                    }
                                                                                }
                                                                                if ($noOfOrdersP == 0) {
                                                                                    $outval = 0;
                                                                                    echo $outval;
                                                                                } else {
                                                                                    $outval = $noOfOrdersP / $noOfOrders * 100;
                                                                                    $outval = intval($outval);
                                                                                    echo $outval;
                                                                                }
                                                                                ?>%" style="max-width:<?php echo $outval; ?>%"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                        <!-- Overdue Orders -->
                                    <div class="col-sm-4">
                                        <div class="mx-1 innercont p-4">
                                            <div class="value-part d-flex row justify-content-between">
                                                <div class="title col d-flex align-items-center">
                                                    <h2 style="font-weight: 400;">Overdue Orders</h2>
                                                    <i class="fas fa-exclamation-triangle ms-auto fa-lg"></i>


                                                </div>
                                                <h1 style="font-weight: 600; font-size: 2.7rem;" class="mt-1">
                                                    <?php
                                                    $a = 0;
                                                    if ($overdue != 0) {
                                                        foreach ($overdue as $od) {
                                                            if ($od->isOverdue == 1) {
                                                                $a++;
                                                            }
                                                        }
                                                    } else {
                                                        $a = 0;
                                                    }
                                                    echo $a;
                                                    ?>
                                                </h1>
                                                <div class="col-md-6 mt-5">

                                                    <div class="row">
                                                        <h3>Total Orders: <?php echo $noOfOrders ?></h3>

                                                    </div>

                                                    <div class="col">
                                                        <h3>Overdue Orders: <?php echo $a ?></h3>

                                                    </div>


                                                </div>
                                                <div class="col-md-6" id="main4" style="height:100px; transform:translateY(-10px); transform:translateX(10px);"></div>

                                                <script type="text/javascript">
                                                    var pie = echarts.init(document.getElementById('main4'));

                                                    var option = {
                                                        color: ['#425A82', '#FF5757'],
                                                        tooltip: {
                                                            trigger: 'item'
                                                        },
                                                        series: [{

                                                            type: 'pie',
                                                            radius: ['40%', '70%'],
                                                            avoidLabelOverlap: false,
                                                            itemStyle: {
                                                                borderRadius: 3,
                                                                borderColor: '#fff',
                                                                borderWidth: 2
                                                            },
                                                            label: {
                                                                show: false,
                                                                position: 'center'
                                                            },
                                                            labelLine: {
                                                                show: false
                                                            },
                                                            data: [{
                                                                    value: <?php echo $noOfOrders - $a ?>,
                                                                    name: 'Orders'
                                                                },
                                                                {
                                                                    value: <?php echo $a ?>,
                                                                    name: 'Overdues'
                                                                },
                                                            ]
                                                        }]
                                                    };
                                                    pie.setOption(option);
                                                </script>
                                            </div>
                                        </div>
                                    </div>
                                        <!-- Customers -->
                                    <div class="col-sm-4">
                                        <div class="ms-3 innercont p-4">
                                            <div class="value-part d-flex row justify-content-between  pb-4">
                                                <div class="title col d-flex align-items-center">
                                                    <h2 style="font-weight: 400;">Customers</h2>
                                                    <i class="fas fa-users ms-auto fa-lg"></i>
                                                </div>
                                                <h1 style="font-weight: 600; font-size: 2.7rem;" class="mt-1">
                                                    +<?php
                                                        $noOfCustomers = 0;
                                                        foreach ($customers as $customer) {
                                                            if ($customer) {
                                                                $noOfCustomers++;
                                                            }
                                                        }
                                                        echo $noOfCustomers;
                                                        ?></h1>
                                            </div>
                                            <div class="skill">
                                                <div class="skill-name">Blacklisted Customers</div>
                                                <div class="skill-bar">
                                                    <div class="skill-per" per="<?php
                                                                                $noOfCustP = 0;
                                                                                foreach ($customers as $customer) {
                                                                                    if ($customer->status == 'blacklisted') {
                                                                                        $noOfCustP++;
                                                                                    }
                                                                                }

                                                                                if ($noOfCustP == 0) {
                                                                                    $outval = 0;
                                                                                    echo $outval;
                                                                                } else {
                                                                                    $outval = $noOfCustP / $noOfCustomers * 100;
                                                                                    $outval = intval($outval);
                                                                                    echo $outval;
                                                                                }
                                                                                ?>%" style="max-width:<?php echo $outval; ?>%"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                
                                <!-- Total Orders -->  
                                <div class="row justify-content-between flex d-flex">
                                    <div class=" mt-4 innercont mx-2">

                                        <div id="main" class="m-4" style="height:400px;"></div>

                                        <?php




                                        $dates = [];
                                        $values = [];
                                        $currentdate = null;

                                        foreach ($orders as $item) {
                                            if ($currentdate == $item->created_date) {

                                                $values[count($values) - 1] += $item->value;
                                            } else {

                                                $dates[] = $item->created_date;
                                                $values[] = $item->value;
                                            }

                                            $currentdate = $item->created_date;
                                        }


                                        // Convert arrays to JSON for use in JavaScript
                                        $datesJson = json_encode($dates);
                                        $valuesJson = json_encode($values);

                                        ?>

                                        <script type="text/javascript">
                                            var myChart = echarts.init(document.getElementById('main'));

                                            var dates = <?php echo $datesJson; ?>;
                                            var values = <?php echo $valuesJson; ?>;


                                            var option = {
                                                color: ['#80FFA5', '#00DDFF', '#37A2FF', '#FF0087', '#FFBF00'],
                                                title: {
                                                    text: 'Total Order Data'
                                                },
                                                tooltip: {
                                                    trigger: 'axis',
                                                    axisPointer: {
                                                        type: 'cross',
                                                        label: {
                                                            backgroundColor: '#6a7985'
                                                        }
                                                    }
                                                },
                                                legend: {
                                                    data: ['Orders', 'Line2', 'Line 3', 'Line 4', 'Line 5']
                                                },
                                                toolbox: {
                                                    feature: {
                                                        saveAsImage: {}
                                                    }
                                                },
                                                grid: {
                                                    left: '3%',
                                                    right: '4%',
                                                    bottom: '3%',
                                                    containLabel: true
                                                },
                                                xAxis: [{
                                                    type: 'category',
                                                    boundaryGap: false,
                                                    data: dates
                                                }],
                                                yAxis: [{
                                                    type: 'value'
                                                }],
                                                series: [{
                                                        name: 'Order Value',
                                                        type: 'line',
                                                        stack: 'Total',
                                                        smooth: true,
                                                        lineStyle: {
                                                            width: 0
                                                        },
                                                        showSymbol: false,
                                                        areaStyle: {
                                                            opacity: 0.8,
                                                            color: new echarts.graphic.LinearGradient(0, 0, 0, 1, [{
                                                                    offset: 0,
                                                                    color: '#425A82'
                                                                },
                                                                {
                                                                    offset: 1,
                                                                    color: '#7d8da1'
                                                                }
                                                            ])
                                                        },
                                                        emphasis: {
                                                            focus: 'series'
                                                        },
                                                        data: values
                                                    },

                                                ]
                                            };


                                            myChart.setOption(option);
                                        </script>

                                    </div>
                                </div>
                                
                                <!-- Second Chart Section -->  
                                <div class="row justify-content-between flex d-flex">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class=" mt-4 innercont mx-2 p-2">

                                                <div id="main2" class="m-4" style="height:400px;"></div>

                                                <?php

                                                $dates = [];
                                                $values = [];
                                                $currentdate = null;

                                                foreach ($orders as $item) {
                                                    if ($currentdate == $item->created_date) {
                                                        if ($item->isPaid) {
                                                            $values[count($values) - 1] += $item->value;
                                                        } else {
                                                            $values[count($values) - 1] += 0;
                                                        }
                                                    } else {

                                                        $dates[] = $item->created_date;
                                                        if ($item->isPaid) {
                                                            $values[] = $item->value;
                                                        } else {
                                                            $values[] = 0;
                                                        }
                                                    }

                                                    $currentdate = $item->created_date;
                                                }

                                                // Convert arrays to JSON for use in JavaScript
                                                $datesJson = json_encode($dates);
                                                $valuesJson = json_encode($values);

                                                ?>

                                                <script type="text/javascript">
                                                    var myChart = echarts.init(document.getElementById('main2'));

                                                    var dates = <?php echo $datesJson; ?>;
                                                    var values = <?php echo $valuesJson; ?>;


                                                    var option = {
                                                        color: ['#80FFA5', '#00DDFF', '#37A2FF', '#FF0087', '#FFBF00'],
                                                        title: {
                                                            text: 'Payments Recieved'
                                                        },
                                                        tooltip: {
                                                            trigger: 'axis',
                                                            axisPointer: {
                                                                type: 'cross',
                                                                label: {
                                                                    backgroundColor: '#6a7985'
                                                                }
                                                            }
                                                        },
                                                        legend: {
                                                            data: ['Payment Value', 'Line2', 'Line 3', 'Line 4', 'Line 5']
                                                        },
                                                        toolbox: {
                                                            feature: {
                                                                saveAsImage: {}
                                                            }
                                                        },
                                                        grid: {
                                                            left: '3%',
                                                            right: '4%',
                                                            bottom: '3%',
                                                            containLabel: true
                                                        },
                                                        xAxis: [{
                                                            type: 'category',
                                                            boundaryGap: false,
                                                            data: dates
                                                        }],
                                                        yAxis: [{
                                                            type: 'value'
                                                        }],
                                                        series: [{
                                                                name: 'Payment Value',
                                                                type: 'line',
                                                                stack: 'Total',
                                                                smooth: true,
                                                                lineStyle: {
                                                                    width: 0
                                                                },
                                                                showSymbol: false,
                                                                areaStyle: {
                                                                    opacity: 0.8,
                                                                    color: new echarts.graphic.LinearGradient(0, 0, 0, 1, [{
                                                                            offset: 0,
                                                                            color: '#425A82'
                                                                        },
                                                                        {
                                                                            offset: 1,
                                                                            color: '#7d8da1'
                                                                        }
                                                                    ])
                                                                },
                                                                emphasis: {
                                                                    focus: 'series'
                                                                },
                                                                data: values
                                                            },

                                                        ]
                                                    };


                                                    myChart.setOption(option);
                                                </script>

                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class=" mt-4 innercont mx-2 p-2">

                                                <div id="main3" class="m-4" style="height:400px;"></div>

                                                <?php
                                                $customerDates = [];
                                                $customerCounts = [];


                                                // Convert data into ECharts series format
                                                foreach ($customers as $customer) {
                                                    $registeredDate = new DateTime($customer->registered_date);

                                                    // Group by registered date
                                                    $dateKey = $registeredDate->format('Y-m-d');

                                                    if (isset($customerDates[$dateKey])) {
                                                        $customerCounts[$dateKey]++;
                                                    } else {
                                                        $customerDates[$dateKey] = $dateKey;
                                                        $customerCounts[$dateKey] = 1;
                                                    }
                                                }

                                                $customerDates = array_values($customerDates);
                                                $customerCounts = array_values($customerCounts);

                                                $customerDatesJson = json_encode($customerDates);
                                                $customerCountsJson = json_encode($customerCounts);
                                                ?>

                                                <script type="text/javascript">
                                                    var myChart = echarts.init(document.getElementById('main3'));

                                                    var dates = <?php echo $datesJson; ?>;
                                                    var values = <?php echo $valuesJson; ?>;


                                                    var option = {
                                                        color: ['#80FFA5', '#00DDFF', '#37A2FF', '#FF0087', '#FFBF00'],
                                                        title: {
                                                            text: 'Customers Gained'
                                                        },
                                                        tooltip: {
                                                            trigger: 'axis',
                                                            axisPointer: {
                                                                type: 'cross',
                                                                label: {
                                                                    backgroundColor: '#6a7985'
                                                                }
                                                            }
                                                        },
                                                        legend: {
                                                            data: ['Orders', 'Line2', 'Line 3', 'Line 4', 'Line 5']
                                                        },
                                                        toolbox: {
                                                            feature: {
                                                                saveAsImage: {}
                                                            }
                                                        },
                                                        grid: {
                                                            left: '3%',
                                                            right: '4%',
                                                            bottom: '3%',
                                                            containLabel: true
                                                        },
                                                        xAxis: [{
                                                            type: 'category',
                                                            boundaryGap: false,
                                                            data: <?php echo $customerDatesJson; ?>
                                                        }],
                                                        yAxis: [{
                                                            type: 'value'
                                                        }],
                                                        series: [{
                                                                name: 'No of Customers',
                                                                type: 'line',
                                                                stack: 'Total',
                                                                smooth: true,
                                                                lineStyle: {
                                                                    width: 0
                                                                },
                                                                showSymbol: false,
                                                                areaStyle: {
                                                                    opacity: 0.8,
                                                                    color: new echarts.graphic.LinearGradient(0, 0, 0, 1, [{
                                                                            offset: 0,
                                                                            color: '#425A82'
                                                                        },
                                                                        {
                                                                            offset: 1,
                                                                            color: '#7d8da1'
                                                                        }
                                                                    ])
                                                                },
                                                                emphasis: {
                                                                    focus: 'series'
                                                                },
                                                                data: <?php echo $customerCountsJson; ?>
                                                            },

                                                        ]
                                                    };


                                                    myChart.setOption(option);
                                                </script>

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
<style>
    .skills {
        width: 100%;
        padding: 0;
    }

    .skill-name {
        font-size: 13px;
        font-weight: 500;
        color: #425A82;
        margin: 20px 0;
    }

    .skill-bar {
        height: 14px;
        background: #b3bfce;
        border-radius: 3px;
    }

    .skill-per {
        height: 14px;
        background: #425A82;
        border-radius: 3px;
        position: relative;
        animation: fillBars 2.5s 1;
    }

    .skill-per::before {
        content: attr(per);
        position: absolute;
        padding: 4px 6px;
        background: #f1f1f1;
        border-radius: 4px;
        font-size: 12px;
        top: -35px;
        right: 0;
        transform: translateX(50%);
    }

    .skill-per::after {
        content: "";
        position: absolute;
        width: 10px;
        height: 10px;
        background: #f1f1f1;
        top: -15px;
        right: 0;
        transform: translateX(50%) rotate(45deg);
        border-radius: 2px;
    }

    @keyframes fillBars {
        from {
            width: 0;
        }

        to {
            width: 100%;
        }
    }
</style>


</html>