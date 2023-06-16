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
  <main class="main">
    <?php require_once 'sidebar.php' ?>

    <section class="feed-container">
      <?php require_once 'nav.php'; ?>

      <div class="feed">
        <?php
          $search = isset($_POST['form-val']) ? strtolower($_POST['form-val']) : '';
          $matched = false;
          $reacts = $database->collection('postlikes')->documents();

          foreach ($blogs as $blog) {
            if ($search !== '' && strpos(strtolower($blog['title']), $search) === false)  {
              continue;
            }

          $matched = true; 
          $title = preg_replace("/($search)/i", "<b>$1</b>", $blog['title']);
          $body = $search !== '' ? preg_replace("/($search)/i", "<mark>$1</mark>", $blog['body']) : $blog['body'];
        ?>
          <div class="card w-50 mt-3">
            <div class="card-header">
              <h1 class="fs-6"> <?php echo $title ?> </h1>
            </div>
            <div class="card-body">
              <p class="card-text m-0"> <?php echo $body ?> </p>
              
            </div>
            <div class="card-footer">
              
            <?php if(isset($_SESSION['userid'])) : ?>
                <div class="container">
                  
                  <div class="d-flex justify-content-end gap-2 align-items-center">

                  <p class="card-text m-0 btn">Reactions: <?php echo $blog['reacts'] ?></p>
              <p class="card-text m-0 btn">Comments: <?php echo $blog['coms'] ?></p>
                <?php 
                  $likeQuery = $database->collection('postlikes')->where('post_id', '==', $blog->id())->where('user_id', '==', $uid)->documents();
                  $hasLiked = false;

                  foreach ($likeQuery as $likeDoc) {
                    $hasLiked = true;
                    break;
                  }
                ?>
                    <a href="process.php?liked=<?php echo $blog->id() ?>"><i class="<?php echo !$hasLiked ? 'bi bi-suit-heart' : 'bi bi-suit-heart-fill' ?>"></i></a>    
                    <a href="post.php?id=<?php echo $blog->id()?>"><i class="bi bi-chat"></i></a>

                    
                  </div>
                </div>
                <?php else: ?>
                <div class="container">
                  <div class="d-flex justify-content-end gap-2 align-items-center">
                    <a href="#"><i class="bi bi-suit-heart"></i></a>    
                    <a href="#"><i class="bi bi-chat"></i></a>
                    </div>
                  </div>
                <?php endif; ?>
              </div>
            </div>
        <?php } ?>
      </div>
    </section>
  </main> 
  
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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="js/modal.js"></script>
</body>
</html>