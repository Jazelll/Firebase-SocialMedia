<?php require_once __DIR__ . '/db.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <link rel="stylesheet" href="css/styles.css">
  <title>Document</title>
</head>
<body>
  <div class="grid-container">

    <header class="navbar navbar-expand-md bg-light d-flex justify-content-center">
      <div class="container d-flex justify-content-between align-items-e gap-2">
        <a href="index.php" class="btn btn-outline-warning col-12 col-lg-2"><i class="bi bi-caret-left-fill"></i> Home</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto">
            <?php if(isset($_SESSION['userid'])) :
              $uid = $_SESSION['userid'];
              $user = $database->collection('users')->document($uid)->snapshot(); 
            ?>
              <li class="nav-item dropdown">
                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre> Welcome, <strong><?php echo $user['username']; ?>!</strong></a>

                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                  <a class="dropdown-item" href="profile.php?logout">Profile</a>
                  <a class="dropdown-item" href="process.php?logout">Logout</a>
                </div>
              </li>
                
            <?php else :  ?>
              <a href="login.php" class="btn">Login</a>
            <?php endif; ?>
            </ul>
        </div>
      </div>
    </header>

    <div class="item3">
      <div class="posts-container">
        <div class="card-post" style="width: 80%; height: 80vh">
          <div class="card-left">
            <img src="<?php echo $user['avatar']; ?>">
          </div>
          <div class="card-right">
            <form class="content" method="POST" action="process.php">
              <h1 class="mt-3">User Profile <i class="bi bi-pencil-square" id="edit"></i></h1>
              <div class="row col-11 mb-2 p-2">
                <div class="col">
                  <label for="firstname" class="form-label">First Name:</label>
                  <input type="text" class="form-control" name="firstname" value="<?php echo $user['name']['first']; ?>" disabled>
                </div>
                <div class="col">
                  <label for="lastname" class="form-label">Last Name:</label>
                  <input type="text" class="form-control" name="lastname" value="<?php echo $user['name']['last']; ?>" disabled>
                </div>
              </div>
              <div class="row col-11 mb-2 p-2">
                <div class="col">
                  <label for="username" class="form-label">Username:</label>
                  <input type="text" class="form-control" name="username" value="<?php echo $user['username']; ?>" disabled>
                </div>
                <div class="col">
                  <label for="email" class="form-label">Email Address:</label>
                  <input type="text" class="form-control" name="email" value="<?php echo $user['email']; ?>" disabled>
                </div>
              </div>
              <div class="row col-11 mb-4 px-3">
                <label for="avatar" class="form-label">Profile photo link</label>
                <input type="text" class="form-control" name="avatar" value="<?php echo $user['avatar']; ?>" disabled>
              </div>

              <div class="row col-11 mb-2 px-3">
                <button type="submit" class="btn mb-2 btn-outline-success float-end d-none profile" name="edit-profile">Update profile</button>
                <a class="btn mb-2 btn-outline-danger float-end d-none profile" id="cancel">Cancel Edit</a>
              </div>
            </form>
          </div>
        </div>
      </div>  
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="js/modal.js"></script>
</body>
</html>