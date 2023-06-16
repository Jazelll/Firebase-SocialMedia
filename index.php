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
        <a href="createpost.php" class="btn btn-outline-warning col-12 col-lg-2 <?php echo !isset($_SESSION['userid']) ? 'like-btn' : '' ?>"><i class="bi bi-patch-plus-fill"></i> New</a>
        <form class="d-flex align-items-center justify-content-end col-lg-8 col-9" method="POST">
          <i class="p-2 bi bi-search position-absolute"></i>
          <input type="text" name="form-val" class="form-control border-warning" placeholder="Search posts ..." value="<?php echo isset($_POST['form-val']) ? $_POST['form-val'] : '' ?>">
        </form>
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
                  <a class="dropdown-item" href="profile.php">Profile</a>
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
      <?php
        $search = isset($_POST['form-val']) ? strtolower($_POST['form-val']) : '';
        $matched = false;
        $reacts = $database->collection('postlikes')->documents();
              
        foreach($blogs as $blog) :
          if($search !== '' && strpos(strtolower($blog['title']), $search) === false) :
            continue;
          endif;

          $matched = true; 
          $title = $search !== '' ? preg_replace("/($search)/i", "<mark>$1</mark>", $blog['title'])  : $blog['title'];
          $body = $search !== '' ? preg_replace("/($search)/i", "<mark>$1</mark>", $blog['body']) : $blog['body'];
          $dt = new DateTime($blog['date'], new DateTimeZone('UTC'));
          $dt->setTimezone(new DateTimeZone('Asia/Manila'));
          $newDate = $dt->format('m/d h:i A');
      ?>
          <div class="card-post">
            <div class="card-left">
              <img src="<?php echo $blog['photo'] ?>">
            </div>
            <div class="card-right">
              <div class="content">
                <span><?php echo $newDate; ?></span>
                <h1><?php echo $title; ?></h1>
                <p><?php echo $body; ?></p>
      <?php if(isset($_SESSION['userid'])) : 
            $likeQuery = $database->collection('postlikes')->where('post_id', '==', $blog->id())->where('user_id', '==', $uid)->documents();
              $hasLiked = false;

              foreach ($likeQuery as $likeDoc) {
                $hasLiked = true;
                break;
              }
      ?>
                <div class="d-flex w-75">
                  <p class="counts">Reactions: <?php echo $blog['reacts'] ?></p>
                  <p class="counts">Comments: <?php echo $blog['coms'] ?></p>  
                </div>
                <div class="actions">
                  <a href="process.php?liked=<?php echo $blog->id(); ?>"><i class="<?php echo !$hasLiked ? 'bi bi-suit-heart' : 'bi bi-suit-heart-fill' ?>"></i></a>
                  <a href="post.php?id=<?php echo $blog->id(); ?>"><i class="bi bi-chat-text"></i></a>
                </div>
      <?php else: ?>
                <div class="actions">
                  <a href="" class="like-btn"><i class="bi bi-suit-heart"></i></a>
                  <a href="" class="comment-btn"><i class="bi bi-chat-text"></i></a>
                </div>
      <?php endif; ?>
              </div>
              
            </div>
          </div>
      <?php endforeach; ?>
      </div>  
    </div>
  </div>

  <div class="modal fade" id="exampleModal" tabindex="1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content p-5">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel"> ... </h1>
        </div>
        <div class="modal-body">
          Login to join the conversation. <span>Once you join ShareSpace, you can respond to this.</span>
          <div class="container mt-5 d-flex flex-column align-items-center">
            <a href="login.php" class="btn btn-primary w-50 mb-2 p-1">Login</a>
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