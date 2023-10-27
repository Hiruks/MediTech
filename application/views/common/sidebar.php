<div class="col-2 sidebarcont">
<aside>

    <div class="sidebarr">
        <a href="<?php echo site_url(); ?>/login/dashboard" class="list-unstyled">
            <span class="material-icons">
                dashboard
            </span>
            <h3>Dashboard</h3>
        </a>
        <?php   $routings = $this->session->userdata('routing'); ?> 

        
            
        <a href="#" class="list-unstyled">
            <span class="material-icons">
                person_outline
            </span>
            <h3>Users</h3>
        </a>
        
        <a href="#" class="list-unstyled">
            <span class="material-icons">
                receipt_long
            </span>
            <h3>History</h3>
        </a>
     
      
        <a href="#" class="list-unstyled">
            <span class="material-icons">
                settings
            </span>
            <h3>Settings</h3>
        </a>

        <a href="<?php echo base_url().'login/logout' ?>" class="list-unstyled">
            <span class="material-icons">
                logout
            </span>
            <h3>Logout</h3>
        </a>
        
    </div>
</aside>
</div>