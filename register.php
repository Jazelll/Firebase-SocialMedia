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

    <div class="container-md d-flex justify-content-center">
        <div class="card w-100" >
            <div class="card-body">
                <div class="row h-100 d-flex justify-content-center align-items-center">
                    <div class="col-lg-6">
                        <!-- Left Column Content -->
                    </div>
                    <div class="col-lg-6">
                        <!-- Right Column Content -->
                        <div class="login-ctn d-flex justify-content-center align-items-center">
                            <form action="process.php" method="POST">
                                <h1 class="text-center">LOGIN USER</h1>
                                <div class="d-flex flex-column align-items-center pt-3">
                                    <div class="mb-3">
                                        <div class="col-sm-12">
                                            <input type="email" name="email" class="form-control" placeholder="Email" style="width: 350px;">
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <div class="col-sm-12">
                                            <input type="password" name="password" class="form-control" placeholder="Password" style="width: 350px;">
                                        </div>
                                    </div>
                                    <p>Don't have an account? <a href="register.php">Register here</a></p>
                                </div>
                                <button type="submit" name="login" class="btn btn-success" style="width: 350px;">Login</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="container d-flex justify-content-center">
        <div style="position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%)">
            <div class="login-ctn d-flex justify-content-center align-items-center">
                <form action="process.php" method="POST" class="container-md d-flex flex-column">
                    <h1>REGISTER USER</h1>
                    <div class="d-flex flex-column align-items-center pt-3">
                        <div class="mb-3 row pt-3">
                            <div class="col-sm-6">
                                <input type="text" name="firstname" class="form-control" placeholder="First Name" style="width: 238px;">
                            </div>

                            <div class="col-sm-6">
                                <input type="text" name="lastname" class="form-control" placeholder="Last Name" style="width: 238px;">
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="col-sm-12">
                                <input type="text" name="username" class="form-control" placeholder="Username" style="width: 500px;">
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="col-sm-12">
                                <input type="email" name="email" class="form-control" placeholder="Email" style="width: 500px;">
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="col-sm-12">
                                <input type="password" name="password" class="form-control" placeholder="Password" style="width: 500px;">
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="col-sm-12">
                                <input type="password" name="confirmpassword" class="form-control" placeholder="Confirm Password" style="width: 500px;">
                            </div>
                        </div>
                        

                        <!-- <div class="mb-3">
                            <div class="col-sm-12">
                                <input type="password" name="confirmpassword" class="form-control  // ?php echo isset($_SESSION['errors']['password']) ? 'is-invalid' : ''; ?>" placeholder="Confirm Password" style="width: 500px;">

                                <div class="invalid-feedback">
                                    ?php // if (isset($_SESSION['errors']['password'])) { ?>
                                        <p class="text-danger">?php echo $_SESSION['errors']['password']; ?></p>
                                    ?php } ?>
                                </div>

                            </div>
                        </div> -->

                        <p>Already have an account? <a href="index.php">Login here</a></p>
                    </div>
                    <button type="submit" name="register" class="btn btn-success">Register</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>