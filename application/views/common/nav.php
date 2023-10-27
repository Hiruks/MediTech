<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid px-4">
    
  <a class="navbar-brand" href="#">
    
        <div class="d-flex flex-row">
            <div class="align-self-center pe-2" style="justify-content: center;">
                <img src="<?php echo site_url();?>images/nav-logo-removebg-preview.png" height="40" width="40">
            </div>
            <div class="align-self-center" style="justify-content: center;">
            <h2 style="margin-bottom: 0rem;">Medi<span class="dangerr">Tech.</span></h2>
            
            </div>
            
        </div>
    
  </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      
    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#">Home</a>
        </li>
        
        
    </ul>
      
      <div class="d-flex" >
      
        
        <!-- The User Profile Buttons -->
        <div class="profile-dropdown" >
            <div class="profile-dropdown-btn" onclick="toggleMenu()">
                <div class="profile-img">
                    <i class="fa-solid fa-circle"></i>
                </div>
                <span>
                    Hitller
                    <i class="fa-solid fa-angle-down"></i>
                </span>
            </div>
            

            <ul class="profile-dropdown-list" id="subMenu">
                <li class="profile-dropdown-list-item">
                    <a href="<?php echo site_url(); ?>/login/profile">
                        <i class="fa-solid fa-user"></i>
                        <span>Profile</span>
                    </a>
                </li>
                <li class="profile-dropdown-list-item">
                    <a href="<?php echo site_url(); ?>/login/editProfile">
                        <i class="fa-solid fa-cog"></i>
                        <span>Edit User</span>
                    </a>
                </li>
                <li class="profile-dropdown-list-item">
                    <a href="<?php echo site_url(); ?>/login/logout">
                        <i class="fa-solid fa-sign-out-alt"></i>
                        <span>Logout</span>
                    </a>
                </li>
            </ul>
            </ul>
        </div>
        
      </div>
    </div>
  </div>
  <script>
    let subMenu = document.getElementById("subMenu");

    function toggleMenu() {
        subMenu.classList.toggle("active");
    }
  </script>
</nav>