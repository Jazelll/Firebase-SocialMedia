<?php require_once __DIR__ .'/db.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <title>Social Media</title>
</head>
<body>
    <?php include 'nav.php'; ?>

    <div class="container mt-3 d-flex flex-column justify-content-center align-items-center">
        <div class="container d-flex justify-content-center align-items-center flex-wrap flex-column">
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
                    <div class="card m-2">
                        
                        <div class="text-box-wrapper">
                            <div class="text-box">
                                <h1 class="heading"> <?php echo $title ?> </h1>
                                <p class="text"> <?php echo $body ?> </p>
                            </div>
                        </div>

                <?php if(isset($_SESSION['userid'])) : ?>
                        <div class="container">
                            <div class="d-flex justify-content-around align-items-center p-2">
                            <?php $likeQuery = $database->collection('postlikes')
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
                                <a href="process.php?liked=<?php echo $blog->id() ?>" class="ml-3"><i class="<?php echo !$hasLiked ? 'bi bi-suit-heart' : 'bi bi-suit-heart-fill' ?>"></i></a>    

                                <p class="card-text mb-0">Reactions: <?php echo $blog['reacts'] ?></p>
                                <a href="post.php?id=<?php echo $blog->id()?>" class="ml-3"><p class="card-text mb-0">Comments: <?php echo $blog['coms'] ?></p></a>
                            </div>
                        </div>
                        <?php else: ?>
                            <div class="container">
                                <div class="d-flex justify-content-around align-items-center p-2">
                                    <a href="#" class="ml-3 like-btn"><i class="bi bi-suit-heart"></i></a>    
                                    <a href="#" class="ml-3 comment-btn"><i class="bi bi-chat"></i></a>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>  
          <?php } if (!$matched) { ?>
                    <p>No posts were found.</p>
          <?php } ?>
        </div>  
    </div>

    <!-- Modal -->
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var likeButtons = document.querySelectorAll('.like-btn');
            var commentButtons = document.querySelectorAll('.comment-btn');

            likeButtons.forEach(function(button) {
                button.addEventListener('click', function(event) {
                    event.preventDefault();
                    $('#exampleModal').modal('show');
                });
            });

            commentButtons.forEach(function(button) {
                button.addEventListener('click', function(event) {
                    event.preventDefault();
                    $('#exampleModal').modal('show');
                });
            });
        });
    </script>
</body>
</html>