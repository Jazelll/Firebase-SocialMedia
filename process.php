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
                'avatar' => 'https://mdbootstrap.com/img/new/avatars/10.jpg',
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
            echo json_encode(['error' => 'Error: ' . $e->getMessage()]);
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
            $blogsColRef->document($postId)->set([
                'reacts' => FieldValue::increment(1)
            ], ['merge' => true]);
        } else {
            
            // Unlike the post
            // Decrement the 'reacts'
            $blogsColRef->document($postId)->set([
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

    if(isset($_GET['logout'])) {
        session_start(); 
        $_SESSION = array();
        session_destroy();
        
        header('Location: index.php');
        exit();
    }
?>