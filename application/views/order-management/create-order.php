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
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>

    <script>
        var aimage = null;
        var aprice = null;
        var atitle = null;
        var aproductID = null;
    </script>
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


                                <div class="row">

                                    <section class="">
                                        <div class="container py-3 mb-5">
                                            <div class="row d-flex justify-content-center align-items-center">
                                                <div class="col-11">
                                                    <?php echo form_open('login/addOrderSubmit/' . $customer[0]->custID, array('method' => 'post')) ?>
                                                    <div class="d-flex justify-content-between align-items-center mb-4">

                                                        <select id="productDropdown" name="product_id" class="form-control" style="width:300px">
                                                            <?php $i = 0; ?>
                                                            <?php foreach ($products as $product) : ?>

                                                                <option value="<?php echo $product->productID; ?>"><?php echo $product->title; ?></option><span></span>
                                                                <?php $i++; ?>

                                                            <?php endforeach; ?>
                                                        </select>

                                                        <div>

                                                            <script>
                                                                selectedValue = null;


                                                                // Function to update the href attribute of the "Add Product" link
                                                                function updateAddProductLink() {
                                                                    const dropdown = document.getElementById("productDropdown");
                                                                    selectedValue = dropdown.value;
                                                                    //const selectedProduct = $products.find(product => product.productID === selectedValue);
                                                                    //console.log(selectedValue);
                                                                    //console.log(selectedProduct);

                                                                    const data = {
                                                                        value: selectedValue
                                                                    };

                                                                    // Create an XMLHttpRequest object
                                                                    $.ajax({
                                                                        url: "<?php echo site_url(); ?>login/ajaxRequestHandler",
                                                                        data: data,
                                                                        method: "GET",
                                                                        success: function(response) {

                                                                            console.log(response.products);

                                                                            var products = response.products;

                                                                            if (products.length > 0) {
                                                                                var product = products[0]; // Assuming you want the first product

                                                                                aimg = product.img;
                                                                                aprice = product.price;
                                                                                atitle = product.title;
                                                                                aproductID = product.productID;

                                                                                // Now you can use the img, price, and title variables as needed
                                                                            }

                                                                            console.log(aprice, atitle, aimg, aproductID);

                                                                        },
                                                                        error: function(jqXHR, textStatus, errorThrown) {
                                                                            console.log("AJAX Request Failed: " + errorThrown);
                                                                        }
                                                                    });

                                                                }



                                                                // Attach an event listener to the dropdown to update the link when the selection changes
                                                                document.getElementById("productDropdown").addEventListener("change", updateAddProductLink);

                                                                // Initial setup when the page loads
                                                                updateAddProductLink();
                                                            </script>

                                                            <a class="btn btn-primary shadow me-6" style="width: 150px;" onclick="addProductCard(), calculateTotalOrderValue()" id="addPrdBtn">
                                                                Add Product
                                                            </a>

                                                        </div>
                                                    </div>
                                                    <?php echo form_close(); ?>


                                                    <?php echo form_open('login/addOrderSubmit/' . $customer[0]->custID) ?>

                                                    <div class="card rounded-3 mb-4" id="cont2">

                                                    </div>




                                                    <div class="card mb-4">
                                                        <div class="card-body p-4  row">
                                                            <div class="form-group col-md-9">

                                                                <label>Select a credit terms:</label>

                                                                <select name="type" class="form-control" style="max-width:500px;">
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

                                                            <div class="form-group col-md-3">
                                                                <span id="totalindicator" style="font-size: 25px;">Rs 0</span>
                                                            </div>
                                                        </div>
                                                    </div>





                                                    <input type="hidden" name="total_order_value" id="total_order_value" value="0">

                                                    <button type="submit" class="btn btn-primary btn-block btn-lg" onclick="calculateTotalOrderValue()">Proceed to Pay</button>

                                                    <?php echo form_close(); ?>


                                                </div>
                                            </div>
                                        </div>
                                    </section>




                                </div>

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
    <div class="invisible">
        <div id="product-card-<?php echo time(); ?>">
            <div class="card-body p-4">
                <div class="row d-flex justify-content-between align-items-center">
                    <div class="col-md-2 col-lg-2 col-xl-2">
                        <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-shopping-carts/img1.webp" class="img-fluid rounded-3" alt="Cotton T-shirt">
                    </div>
                    <div class="col-md-3 col-lg-3 col-xl-3">
                        <p class="lead fw-normal mb-2">Title</p>
                        <p><span class="text-muted">Price: </span>Rs100</p>
                    </div>
                    <div class="col-md-3 col-lg-3 col-xl-2 d-flex">


                        <input id="form1" min="0" name="quantity" value="2" type="number" class="form-control form-control-sm" />

                    </div>
                    <div class="col-md-3 col-lg-2 col-xl-2 offset-lg-1">
                        <h5 class="mb-0">Rs499.00</h5>
                    </div>
                    <div class="col-md-1 col-lg-1 col-xl-1 text-end">
                        <a href="javascript:void(0);" class="text-danger" onclick="removeProductCard('product-card-<?php echo time(); ?>')">
                            <i class="fas fa-trash fa-lg"></i>
                        </a>
                    </div>


                </div>
            </div>
        </div>
    </div>

    <script>
        let nextProductCardId = 1;

        /*function addProductCard(productCardId) {
            // Create a new product card element
            const newProductCard = document.getElementById(productCardId).cloneNode(true);

            // Append the new product card to the container
            const container = document.getElementById("cont2");
            container.appendChild(newProductCard);
        }*/

        function updatePrice(cardID, price) {
            let qnt = "form" + cardID;
            const quantityContainer = document.getElementById(qnt);

            let currentQuantity = parseInt(quantityContainer.textContent, 10);
            currentQuantity++;
            quantityContainer.textContent = currentQuantity;

            console.log(cardID);



            let labelID = "price" + cardID;
            console.log(labelID);
            const label = document.getElementById(labelID);

            label.textContent = "Rs " + price * currentQuantity;
            let i = calculateTotalOrderValue();
            document.getElementById("totalindicator").innerHTML = "Rs " + i;

        }

        function updateQuantity(productId, quantityID) {
            let qnt = "form" + quantityID;
            const quantityContainer = document.getElementById(qnt);

            let currentQuantity = parseInt(quantityContainer.textContent, 10);
            document.getElementById('quantity_' + productId).value = currentQuantity + 1;
        }

        function addProductCard() {



            // Generate a unique product card ID and increment the counter
            const productCardId = `product-card-${nextProductCardId}`;


            // Create a new product card element
            const newProductCard = document.createElement("div");
            newProductCard.id = productCardId;
            newProductCard.className = "card";

            // Create card body
            const cardBody = document.createElement("div");
            cardBody.className = "card-body p-4";

            // Create the row for content
            const contentRow = document.createElement("div");
            contentRow.className = "row d-flex justify-content-between align-items-center";

            // Image column
            const imageColumn = document.createElement("div");
            imageColumn.className = "col-md-2 col-lg-2 col-xl-2";
            const image = document.createElement("img");
            image.className = "img-fluid rounded-3";
            image.src = "<?php echo site_url(); ?>/uploads/images/" + aimg;
            image.alt = "Product Image";
            imageColumn.appendChild(image);

            // Title and Price column
            const titlePriceColumn = document.createElement("div");
            titlePriceColumn.className = "col-md-3 col-lg-3 col-xl-3";
            const title = document.createElement("p");
            title.className = "lead fw-normal mb-2";
            title.textContent = atitle;
            const price = document.createElement("p");

            price.innerHTML = '<span class="text-muted">Price:' + aprice + '</span>';

            titlePriceColumn.appendChild(title);
            titlePriceColumn.appendChild(price);

            // Quantity controls column
            const quantityColumn = document.createElement("div");
            quantityColumn.className = "col-md-3 col-lg-3 col-xl-2 d-flex";

            const idlabel = document.createElement("label");
            idlabel.className = "invisible";
            idlabel.value = aproductID;
            idlabel.textContent = nextProductCardId;
            idlabel.id = aprice;


            const quantityInput = document.createElement("input");
            quantityInput.type = "hidden";
            quantityInput.name = "product_quantities[" + idlabel.value + "]";
            quantityInput.value = 1; // Set default quantity
            quantityInput.id = "quantity_" + idlabel.value;
            quantityInput.className = "quantity";

            const productIdInput = document.createElement("input");
            productIdInput.type = "hidden";
            productIdInput.name = "product_ids[]";
            productIdInput.value = aproductID;
            quantityInput.className = "";





            const quantityContainer = document.createElement("div");
            quantityContainer.id = "form" + nextProductCardId; // Generate a unique container ID
            quantityContainer.className = "quantity-container";
            quantityContainer.textContent = 1;
            quantityContainer.onclick = function() {
                let qnt = idlabel.textContent;
                let id = idlabel.value;
                let pric = idlabel.id;
                updateQuantity(id, qnt);
                updatePrice(qnt, pric);
                calculateTotalOrderValue()
            };
            quantityContainer.style = "height: 50px; line-height: 50px; width:100px;";




            quantityColumn.appendChild(productIdInput);
            quantityColumn.appendChild(quantityInput);


            quantityColumn.appendChild(idlabel);

            quantityColumn.appendChild(quantityContainer);



            // Price column
            const priceColumn = document.createElement("div");
            priceColumn.className = "col-md-3 col-lg-2 col-xl-2 offset-lg-1";
            priceColumn.id = "priceCol" + nextProductCardId;
            const priceValue = document.createElement("h5");
            priceValue.className = "mb-0";
            priceValue.textContent = "Rs " + aprice * 1;
            priceValue.id = "price" + nextProductCardId;
            priceColumn.appendChild(priceValue);

            // Remove button column
            const removeColumn = document.createElement("div");
            removeColumn.className = "col-md-1 col-lg-1 col-xl-1 text-end";
            const removeButton = document.createElement("a");
            removeButton.href = "javascript:void(0)";
            removeButton.className = "text-danger";
            removeButton.onclick = function() {
                removeProductCard(productCardId);
                removeValues(idlabel.value);
            };
            removeButton.innerHTML = '<i class="fas fa-trash fa-lg"></i';
            removeColumn.appendChild(removeButton);

            // Append all columns to the content row
            contentRow.appendChild(imageColumn);
            contentRow.appendChild(titlePriceColumn);
            contentRow.appendChild(quantityColumn);
            contentRow.appendChild(priceColumn);
            contentRow.appendChild(removeColumn);

            // Append the content row to the card body
            cardBody.appendChild(contentRow);

            // Append the card body to the new product card
            newProductCard.appendChild(cardBody);

            // Append the new product card to the container
            const container = document.getElementById("cont2");

            container.appendChild(newProductCard);
            let i = calculateTotalOrderValue();
            document.getElementById("totalindicator").innerHTML = "Rs " + i;
            nextProductCardId++;
        }



        function calculateTotalOrderValue() {
            let totalOrderValue = 0;

            // Get all product cards
            const productCards = document.querySelectorAll('[id^="product-card-"]');

            // Iterate through all product cards
            productCards.forEach(productCard => {
                // Get the quantity and price elements
                const quantityElement = productCard.querySelector('.quantity-container');
                const priceElement = productCard.querySelector('.text-muted');

                // Check if elements are found
                if (quantityElement && priceElement) {
                    // Parse quantity and price values
                    const quantity = parseInt(quantityElement.textContent, 10);
                    const price = parseFloat(priceElement.textContent.replace('Price:', ''));

                    // Check if parsing was successful
                    if (!isNaN(quantity) && !isNaN(price)) {
                        // Calculate total price for the current product
                        const totalPrice = quantity * price;

                        // Add to the total order value
                        totalOrderValue += totalPrice;
                    }
                }
            });

            // Display or use the total order value as needed
            console.log('Total Order Value: Rs ' + totalOrderValue.toFixed(2));
            document.getElementById('total_order_value').value = totalOrderValue.toFixed(2);
            return totalOrderValue;
        }





        // Example usage (you can trigger this function when needed, e.g., on button click)
        document.querySelector('.btn-warning').addEventListener('click', function() {
            const totalOrderValue = calculateTotalOrderValue();
            // Perform further actions with the total order value as needed
            console.log('Proceeding to pay with Total Order Value: Rs ' + totalOrderValue);
        });





        function removeProductCard(productCardId) {
            // Find the product card by its unique ID
            const productCard = document.getElementById(productCardId);

            if (productCard) {
                // Remove the specified product card from the DOM
                productCard.remove();
            }
        }

        function removeValues(productId) {

            const productIdInput = document.querySelector('input[name="product_ids[]"][value="' + productId + '"]');

            if (productIdInput) {
                productIdInput.remove();
            }

            const quantityInput = document.getElementById("quantity_" + productId);

            if (quantityInput) {
                quantityInput.remove();
            }


            let i = calculateTotalOrderValue();
            document.getElementById("totalindicator").innerHTML = "Rs " + i;


        }
    </script>
</body>

</html>