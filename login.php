<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/login.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
    <title>Document</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
</head>
<body>
    <div class="container">
        <section id="formHolder">
            <div class="row">
                <div class="col-sm-6 brand">
                    <a href="#" class="logo">Share your thoughts <span>.</span></a>
                    <div class="heading">
                    <div class="image-container">
                        <img src="/assets/images/ShareSpace.png" alt="My Image">
                    </div>
                        <p>We're Aliens.</p>
                    </div>
                </div>
                <!-- Form Box -->
                <div class="col-sm-6 form">
                    <!-- Login Form -->
                    <div class="login form-peice"> <!-- switching is here -->
                        <form class="login-form" action="#" method="post">
                            <div class="form-group">
                                <label for="email">Email Address</label>
                                <input type="email" name="loginEmail" id="loginEmail" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" name="loginPassword" id="loginPassword" required>
                            </div>
                            <div class="CTA">
                                <input type="submit" value="Login" name="Login" id="Login">
                                <a href="#" class="switch">I'm New</a>
                            </div>
                        </form> 
                    </div>

                    <!-- Signup Form -->
                   <div class="signup form-peice switched">  <!-- switching is here -->
                        <form class="signup-form" action="#" method="post">
                            <div class="form-group">
                                <label for="name">User Name</label>
                                <input type="text" name="username" id="username" class="username">
                                <span class="error"></span>
                            </div>
                            <div class="form-group">
                                <label for="firstname">First Name</label>
                                <input type="text" name="firstname" id="firstname" class="firstname">
                                <span class="error"></span>
                            </div>
                            <div class="form-group">
                                <label for="lastname">Last Name</label>
                                <input type="text" name="lastname" id="lastname" class="lastname">
                                <span class="error"></span>
                            </div>
                            <div class="form-group">
                                <label for="email">Email Address</label>
                                <input type="email" name="email" id="email" class="email">
                                <span class="error"></span>
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" name="password" id="password" class="pass">
                                <span class="error"></span>
                            </div>
                            <div class="form-group">
                                <label for="passwordCon">Confirm Password</label>
                                <input type="password" name="passwordCon" id="passwordCon" class="passConfirm">
                                <span class="error"></span>
                            </div>
                            <div class="CTA">
                                <input type="submit" name="Register" value="Register" id="Register">

                                <a href="#" class="switch">I have an account</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script src="../js/ajax.js"></script>
</body>
</html>
