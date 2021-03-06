<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="/phpstuff/admin/index.php">Admin Home</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">

      <li class="nav-item"><a class ="nav-link" href="brands.php">Brands</a></li>
      <li class="nav-item"><a class ="nav-link" href="categories.php">Categories</a></li>
      <li class="nav-item"><a class ="nav-link" href="products.php">Products</a></li>
      <?php if(has_permission('admin')): ?>
      <li class="nav-item"><a class ="nav-link" href="users.php">Users</a></li>
    <?php endif; ?>
      <li class="nav-item dropdown">
        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Hello <?php echo $user_data['first'];?>!
        </a>
        <ul class="dropdown-menu" role="menu">
          <li><a class="dropdown-item" href="change_password.php">Change Password</a></li>
          <li><a class="dropdown-item" href="logout.php">Log Out</a></li>
        </ul>
      </li>


      <!-- <li class="nav-item active">
        <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
      </li>
    
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="#"></a>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Link</a>
      </li>
      <li class="nav-item">
        <a class="nav-link disabled" href="#">Disabled</a>
      </li> -->
    </ul>
    <!-- <form class="form-inline my-2 my-lg-0">
      <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
    </form> -->
  </div>
</nav>