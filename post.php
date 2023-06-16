<?php     
  require_once __DIR__ .'/db.php';
  $uid = $_SESSION['userid'];

  if(isset($_GET['id'])) {
    $postid = $_GET['id'];
    $blog = $database->collection('blogs')->document($_GET['id'])->snapshot();
    $posted = $database->collection('users')->document($blog['userid'])->snapshot();

    // get all comments collection
    $coms = $database->collection('postcomments')->documents();
    $reacts = $database->collection('postlikes')->documents();
    $dt = new DateTime($blog['date'], new DateTimeZone('UTC'));
    $dt->setTimezone(new DateTimeZone('Asia/Manila'));
    $newDate = $dt->format('m/d h:i A');
  }
?>

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
          <div class="card-post" style="width: 90%; height: 90vh">
            <div class="card-left">
              <img src="<?php echo $blog['photo'] ?>">
            </div>
            <div class="card-right">
              <div class="content">
                <div class="d-flex align-items-center mb-2">
                  <img
                    src="<?= isset($posted['avatar']) ? $posted['avatar'] : 'https://www.vhv.rs/dpng/d/550-5508649_person-image-placeholder-clipart-png-download-no-profile.png' ?>"
                    style="width: 20px; height: 20px"
                    class="rounded-circle"
                  />
                  <div class="ms-2">
                    <h6 class="fw-semibold mt-2" style="font-size: 24px;"><?= $posted['name']['first'] ?></h6>
                  </div>
                </div>

                <span><?php echo $newDate; ?></span>
                <h1><?php echo $blog['title']; ?></h1>
                <p style="font-size: 19px"><?php echo $blog['body'];?></p>

                <?php $likeQuery = $database
                                        ->collection('postlikes')
                                        ->where('post_id', '==', $blog->id())
                                        ->where('user_id', '==', $uid)
                                        ->limit(1)
                                        ->documents();

                                $hasLiked = false;

                                foreach ($likeQuery as $likeDoc) {
                                    $hasLiked = true;
                                    break;
                                }
                            ?>

                <div class="actions d-flex gap-3 w-75">
                  <a href="process.php?liked=<?php echo $blog->id(); ?>"><i class="<?php echo !$hasLiked ? 'bi bi-suit-heart mt-n1' : 'bi bi-suit-heart-fill mt-n1' ?>"></i></a>
                  <p class="counts mt-1">Reactions: <?php echo $blog['reacts'] ?></p>
                  <p class="counts mt-1">Comments: <?php echo $blog['coms'] ?></p> 
                </div>
          <?php if(isset($_SESSION['userid'])) : 
                  $likeQuery = $database->collection('postlikes')->where('post_id', '==', $blog->id())->where('user_id', '==', $uid)->documents();
                  $hasLiked = false;

                  foreach ($likeQuery as $likeDoc) {
                    $hasLiked = true;
                    break;
                  }
          ?>
                    <div class="card-body border-top">
              <?php foreach($coms as $com) {
                    if($com['post_id'] === $_GET['id']) {
                      $userCommented = $database->collection('users')->document($com['user_id'])->snapshot();
                      ?>

                      <div class="card-body comments p-2 mb-0">
                        <div class="d-flex align-items-center">
                          <img
                            src="<?= isset($userCommented['avatar']) ? $userCommented['avatar'] : 'https://www.vhv.rs/dpng/d/550-5508649_person-image-placeholder-clipart-png-download-no-profile.png' ?>"
                            style="width: 20px; height: 20px"
                            class="rounded-circle"
                          />
                          <div class="ms-2">
                            <h6 class="fw-semibold mb-0 comments" style="font-size: 15px;"><?= $userCommented['name']['first'] ?></h6>
                          </div>
                        </div>
                        <div class="ps-1 ms-4 d-flex align-items-center">
                        
                          <p class="mb-0 fw-light text-dark" style="font-size: 13px;"><?= $com['comment'] ?></p>
                          <?php if ($com['user_id'] === $uid) : ?>
                              <!-- Display delete button or option here -->
                              <a href="process.php?delete-comment=<?php echo $com->id() ?>&post=<?=$postid?>"><i class="bi bi-trash"></i></a>
                          <?php endif; ?>
                        </div>
                      </div>  
                <?php } } ?>
                    </div>


                

                 
      <?php endif; ?>
              </div>
<div class="container new-comment">
                  <div class="row">
                    <form action="process.php" method="post">
                      <div class="mb-3 d-flex">
                        <input type="hidden" name="userid" value="<?= $uid ?>">
                        <input type="hidden" name="postid" value="<?= $_GET['id'] ?>">
                        <input type="text" class="form-control border" name="content" placeholder="Comment here ...">
                        <button type="submit" name="comment" class="btn"><i class="bi bi-chat me-2"></i></button>
                      </div>
                    </form>
                  </div>
                </div> 

                    
                </div>
              
            </div>
          </div>
      </div>  
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>