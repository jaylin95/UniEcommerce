<?php
$sql = "SELECT * FROM categories WHERE parent = 0";
$pquery = $db->query($sql);
?>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="#">Navbar</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
      </li>
      <?php while($parent = mysqli_fetch_assoc($pquery)) : ?>
        <?php 
        $parent_id =$parent['id']; 
        $sql2 = "SELECT * FROM categories WHERE parent = '$parent_id'";
        $cquery = $db->query($sql2);

        ?>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <?php echo $parent['category']; ?>
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <?php while($child = mysqli_fetch_assoc($cquery)) : ?>
          <a class="dropdown-item" href="category.php?cat=<?php echo $child['id'];?>"><?php echo $child['category']; ?></a>
          <?php endwhile; ?>
        </div>
      </li>
      <?php endwhile; ?>
      <li class="nav-item"><a class ="nav-link" href="basket.php"><i class="fas fa-shopping-basket"></i>My Basket</a></li>
      <li class="nav-item">
        <a class="nav-link" href="#">Link</a>
      </li>
      <li class="nav-item">
        <a class="nav-link disabled" href="#">Disabled</a>
      </li>
    </ul>
    <form class="form-inline my-2 my-lg-0">
      <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
    </form>
  </div>
</nav>