<?php 
    putenv("FIREBASE_AUTH_EMULATOR_HOST=localhost:9099");
    putenv("FIRESTORE_EMULATOR_HOST=localhost:8080");

    require_once __DIR__ . '/vendor/autoload.php';
    require_once __DIR__ . '/db.php';
    
    use Google\Cloud\Firestore\FieldValue;
    use Kreait\Firebase\Factory;

    $factory = (new Factory)->withServiceAccount('keys\fir-exam-b59e5-firebase-adminsdk-yg51y-83af7ab592.json');
    $uid = $_SESSION['userid'];

    $postId2 = $blogsColRef->add([
        'userid' => $uid,
        'title' => 'Gusto ko na mag bakasyonnnn!!!',
        'body' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque faucibus aliquam enim et lacinia. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.',
        'date' => FieldValue::serverTimestamp(),
        'reacts' => 0,
        'coms' => 0,
    ])->id();

        $database->collection('postcomments')->add([
            'post_id' => $postId2,
            'user_id' => $uid,
            'comment' => 'Bakasyon please',
            'date' => FieldValue::serverTimestamp()
        ]);

        $database->collection('postcomments')->add([
            'post_id' => $postId2,
            'user_id' => $uid,
            'comment' => 'Same',
            'date' => FieldValue::serverTimestamp()
        ]);


    $postId = $blogsColRef->add([
        'userid' => $uid,
        'title' => 'Sample post',
        'body' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque faucibus aliquam enim et lacinia. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.',
        'date' => FieldValue::serverTimestamp(),
        'reacts' => 0,
        'coms' => 0,
    ])->id();

        $database->collection('postcomments')->add([
            'post_id' => $postId,
            'user_id' => $uid,
            'comment' => 'Hellooooo',
            'date' => FieldValue::serverTimestamp()
        ]);

        $database->collection('postcomments')->add([
            'post_id' => $postId,
            'user_id' => $uid,
            'comment' => 'Worldddd',
            'date' => FieldValue::serverTimestamp()
        ]);

            // $database->collection('postlikes')->add([
            //     'post_id' => $postId,
            //     'user_id' => $uid,
            //     'date' => FieldValue::serverTimestamp()
            // ]);

    $postId2 = $blogsColRef->add([
        'userid' => $uid,
        'title' => 'This is a sample post.',
        'body' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque faucibus aliquam enim et lacinia. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.',
        'date' => FieldValue::serverTimestamp(),
        'reacts' => 0,
        'coms' => 0,
    ])->id();

        $database->collection('postcomments')->add([
            'post_id' => $postId2,
            'user_id' => $uid,
            'comment' => 'Bakasyon please',
            'date' => FieldValue::serverTimestamp()
        ]);

        $database->collection('postcomments')->add([
            'post_id' => $postId2,
            'user_id' => $uid,
            'comment' => 'Test Test',
            'date' => FieldValue::serverTimestamp()
        ]);

header('Location: index.php');