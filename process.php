<?php
    putenv("FIREBASE_AUTH_EMULATOR_HOST=localhost:9099");
    putenv("FIRESTORE_EMULATOR_HOST=localhost:8080");

    require_once __DIR__ . '/vendor/autoload.php';
    require_once __DIR__ . '/db.php';
    
    use Google\Cloud\Firestore\FieldValue;
    use Kreait\Firebase\Exception\Auth\EmailExists;
    use Kreait\Firebase\Factory;

    $factory = (new Factory)->withServiceAccount('keys\fir-exam-b59e5-firebase-adminsdk-yg51y-83af7ab592.json');

    if (isset($_POST['Register'])) {
        $username = $_POST['username'];
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        $userProps = [
            'email' => $email,
            'password' => $password,
        ];

        $auth = $factory->createAuth();

        try {
            $user = $auth->createUser($userProps);
            $firestore = $factory->createFirestore();

            $firestore->database()->collection('users')->document($user->uid)->set([
                'email' => $email,
                'password' => $password,
                'username' => $username,
                'name' => [
                    'first' => $firstname,
                    'last' => $lastname
                ],
                'avatar' => 'https://www.pngitem.com/pimgs/m/649-6490124_katie-notopoulos-katienotopoulos-i-write-about-tech-round.png',
            ]);

            // Send success response
            echo json_encode(['success' => true]);
        } catch(EmailExists $err) {
            // Send error response
            echo json_encode(['error' => 'Email already registered']);
        } catch(Exception $err) {
            // Send error response
            echo json_encode(['error' => 'Error: ' . $err->getMessage()]);
        }
    }

    if (isset($_POST['Login'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $auth = $factory->createAuth();

        try {
            $result = $auth->signInWithEmailAndPassword($email, $password);
            $_SESSION['userid'] = $result->firebaseUserId();

            echo json_encode(['success' => true]);
        } catch(\Exception $e) {
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    if (isset($_GET['liked'])) {
        $postId = $_GET['liked'];
        $uid = $_SESSION['userid'];
    
        // Check if the user has already liked the post
        $likeQuery = $database->collection('postlikes')
            ->where('post_id', '=', $postId)
            ->where('user_id', '=', $uid)
            ->limit(1)
            ->documents();
    
        $likeExists = false;
    
        foreach ($likeQuery as $likeDoc) {
            $likeExists = true;
            $likeDoc->reference()->delete();
            break;
        }
    
        if (!$likeExists) {
            // Like the post if the user has not liked it
            $database->collection('postlikes')->add([
                'post_id' => $postId,
                'user_id' => $uid,
                'date' => FieldValue::serverTimestamp()
            ]);
    
            // Increment the 'reacts'
            $database->collection('blogs')->document($postId)->set([
                'reacts' => FieldValue::increment(1)
            ], ['merge' => true]);
        } else {
            
            // Unlike the post
            // Decrement the 'reacts'
            $database->collection('blogs')->document($postId)->set([
                'reacts' => FieldValue::increment(-1)
            ], ['merge' => true]);
        }
    
        // Redirect back to the previous page
        $lastUrl = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
        header('Location: ' . $lastUrl);
        exit();
    }  

    if (isset($_POST['comment'])) {
        $comment = $_POST['content'];
        $userid = $_POST['userid'];
        $postid = $_POST['postid'];

        $database->collection('postcomments')->add([
            'date' => FieldValue::serverTimestamp(),
            'user_id' => $userid,
            'post_id' => $postid,
            'comment' => $comment
        ]);

        $getDoc = $database->collection('blogs')->document($postid)->snapshot();
        $current = $getDoc['coms'];
        $database->collection('blogs')->document($postid)->set([
            'coms' => ++$current
        ], ['merge' => true]);

        header('Location: post.php?id=' . $postid);
    }

    if(isset($_GET['delete-comment'])) {
        $commentId = $_GET['delete-comment'];
        $postid = $_GET['post'];
    
        $commentRef = $database->collection('postcomments')->document($commentId)->delete();
        $getDoc = $database->collection('blogs')->document($postid)->snapshot();
        $current = $getDoc['coms'];
        $database->collection('blogs')->document($postid)->set([
            'coms' => --$current
        ], ['merge' => true]);
    
        header('Location: post.php?id=' . $postid);
        exit();
      }

    if(isset($_GET['logout'])) {
        session_start(); 
        $_SESSION = array();
        session_destroy();
        
        header('Location: index.php');
        exit();
    }

    if (isset($_POST['edit-profile'])) {
        $newfirstname = $_POST['firstname'];
        $newlastname = $_POST['lastname'];
        $newUsername = $_POST['username'];
        $newavatar = $_POST['avatar'];
        $uid = $_SESSION['userid'];

        $database->collection('users')->document($uid)->set([
            'username' => $newUsername,
            'name' => [
                'first' => $newfirstname,
                'last' => $newlastname
            ],
            'avatar' => $newavatar
        ], ['merge' => true]);
    
        header('Location: profile.php');
        exit();
    }

    if (isset($_POST['new-post'])) {
        $title = $_POST['title'];
        $body = $_POST['body'];
        $photo = $_POST['photo'];
        $currentDateTime = new DateTime();
        $uid = $_SESSION['userid'];

        $database->collection('blogs')->add([
            'title' => $title,
            'body' => $body,
            'date' => $currentDateTime,
            'photo' => $photo,
            'reacts' => 0,
            'coms' => 0,
            'userid' => $uid
        ]);
    
        header('Location: index.php');
        exit();
    }
?>