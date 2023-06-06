<?php
    session_start();

    require_once __DIR__ .'/vendor/autoload.php';
    use Google\Cloud\Firestore\FirestoreClient;

    putenv('FIRESTORE_EMULATOR_HOST=localhost:8080');
    $database = new FirestoreClient([
        // 'keyFilePath' => 'keys\fir-exam-b59e5-firebase-adminsdk-yg51y-83af7ab592.json',
        'projectId' => 'fir-exam-b59e5'
    ]);

    $blogsColRef = $database->collection('blogs');
    $blogs = $blogsColRef->documents();