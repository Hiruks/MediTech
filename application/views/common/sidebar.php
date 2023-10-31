<div class="col-2 sidebarcont">
    <aside>

        <div class="sidebarr">
            <a href="<?php echo site_url(); ?>/login/dashboard" class="list-unstyled">
                <span class="material-icons">
                    dashboard
                </span>
                <h3>Dashboard</h3>
            </a>

            <?php $routings = $this->session->userdata('routing'); ?>

            <?php if (isset($routings['customers'])) { ?>

                <!-- Customers -->

                <a href="<?php echo site_url(); ?>/login/customerMng" class="list-unstyled">
                    <span class="material-symbols-rounded">
                        group
                    </span>
                    <h3>Customers</h3>
                </a>
            <?php } ?>

            <?php if (isset($routings['blacklist'])) { ?>

                <!-- blacklist -->

                <a href="<?php echo site_url(); ?>/login/blacklist" class="list-unstyled">
                    <span class="material-symbols-rounded">
                        contract_delete
                    </span>
                    <h3>Blacklist</h3>
                </a>

            <?php } ?>

            <?php if (isset($routings['orders'])) { ?>

                <!-- orders -->

                <a href="#" class="list-unstyled">
                    <span class="material-symbols-rounded">
                        orders
                    </span>
                    <h3>Orders</h3>
                </a>

            <?php } ?>


            <?php if (isset($routings['user-management'])) { ?>

                <!-- user management -->

                <a href="#" class="list-unstyled">
                    <span class="material-symbols-rounded">
                        engineering
                    </span>
                    <h3>System Users</h3>
                </a>
            <?php } ?>


            <?php if (isset($routings['products'])) { ?>

                <!-- Products -->

                <a href="<?php echo site_url(); ?>login/products" class="list-unstyled">
                    <span class="material-symbols-rounded">
                        inventory_2
                    </span>
                    <h3>Products</h3>
                </a>
            <?php } ?>

            
            <?php if (isset($routings['reports'])) { ?>

                <!-- reports -->

                <a href="#" class="list-unstyled">
                    <span class="material-symbols-rounded">
                        description
                    </span>
                    <h3>Reports</h3>
                </a>

            <?php } ?>

            <a href="<?php echo base_url() . 'login/logout' ?>" class="list-unstyled">
                <span class="material-icons">
                    logout
                </span>
                <h3>Logout</h3>
            </a>

        </div>
    </aside>
</div>