<?php     
require_once __DIR__ .'/db.php';
$uid = $_SESSION['userid'];

if(isset($_GET['id'])) {
    $blogs = $database->collection('blogs')->document($_GET['id'])->snapshot();
    $posted = $database->collection('users')->document($blogs['userid'])->snapshot();

    // get all comments collection
    $coms = $database->collection('postcomments')->documents();
    $reacts = $database->collection('postlikes')->documents();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <title>Social Media</title>
</head>
<body>
    <?php include 'nav.php'; ?>
    <div class="container mt-3 d-flex flex-column justify-content-center align-items-center">
        <div class="card m-2">
            <div class="text-box-wrapper">
                <div class="text-box">
                    <div class="d-flex align-items-center mb-2">
                        <img
                            src="<?= $posted['avatar'] ?>"
                            style="width: 20px; height: 20px"
                            class="rounded-circle"
                        />
                        <div class="ms-2">
                            <h6 class="fw-semibold mt-2" style="font-size: 13px;"><?= $posted['name']['first'] ?></h6>
                        </div>
                    </div>
                    <h1 class="heading"> <?php echo $blogs['title'] ?> </h1>
                    <p class="text"> <?php echo $blogs['body'] ?> </p>
                </div>
            </div>

            <div class="card-body border-top">
                <?php 
                    foreach($coms as $com) {
                        if($com['post_id'] === $_GET['id']) {
                            $userCommented = $database->collection('users')->document($com['user_id'])->snapshot(); ?>

                            <div class="card-body p-2 mb-0">
                                <div class="d-flex align-items-center">
                                    <img
                                        src="<?= $userCommented['avatar'] ?>"
                                        style="width: 20px; height: 20px"
                                        class="rounded-circle"
                                    />
                                    <div class="ms-2">
                                        <h6 class="fw-semibold mb-0" style="font-size: 13px;"><?= $userCommented['name']['first'] ?></h6>
                                    </div>
                                </div>
                                <div class="ps-1 ms-4">
                                    <p class="mb-0 fw-light text-dark" style="font-size: 10px;"><?= $com['comment'] ?></p>
                                </div>
                            </div>  
                <?php } } ?>
            </div>
            <div class="container">
                <div class="row">
                    <form action="process.php" method="post">
                        <div class="mb-3 d-flex">
                            <input type="hidden" name="userid" value="<?= $uid ?>">
                            <input type="hidden" name="postid" value="<?= $_GET['id'] ?>">
                            <input type="text" class="form-control border" name="content">
                            <button type="submit" name="comment" class="btn"><i class="bi bi-chat me-2"></i></button>
                        </div>
                    </form>
                </div>

                <div class="d-flex justify-content-around align-items-center p-2">
                    <?php $likeQuery = $database
                                ->collection('postlikes')
                                ->where('post_id', '==', $blogs->id())
                                ->where('user_id', '==', $uid)
                                ->limit(1)
                                ->documents();

                        $hasLiked = false;

                        foreach ($likeQuery as $likeDoc) {
                            $hasLiked = true;
                            break;
                        }
                    ?>
                    <a href="process.php?liked=<?php echo $blogs->id() ?>" class="ml-3"><i class="<?php echo !$hasLiked ? 'bi bi-suit-heart' : 'bi bi-suit-heart-fill' ?>"></i></a> 
                    <p class="card-text mb-0">Reactions: <?php echo $blogs['reacts'] ?></p>
                    <p class="card-text mb-0">Comments: <?php echo $blogs['coms'] ?></p>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
</body>
</html >