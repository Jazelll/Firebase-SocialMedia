/*global $, document, window, setTimeout, navigator, console, location*/
$(document).ready(function () {

    'use strict';

    var usernameError = true,
        firstnameError= true,
        lastnameError = true,
        emailError    = true,
        passwordError = true,
        passConfirm   = true;

    // Detect browser for css purpose
    if (navigator.userAgent.toLowerCase().indexOf('firefox') > -1) {
        $('.form form label').addClass('fontSwitch');
    }

    // Label effect
    $('input').focus(function () {
        $(this).siblings('label').addClass('active');
    });

    // Form validation
    $('input').blur(function () {
        // User Name
        if ($(this).hasClass('username')) {
            if ($(this).val().length === 0) {
                $(this).siblings('span.error').text('Please type your user name').fadeIn().parent('.form-group').addClass('hasError');
                usernameError = true;
            } else if ($(this).val().length > 1 && $(this).val().length <= 5) {
                $(this).siblings('span.error').text('Please type at least 6 characters').fadeIn().parent('.form-group').addClass('hasError');
                usernameError = true;
            } else {
                $(this).siblings('.error').text('').fadeOut().parent('.form-group').removeClass('hasError');
                usernameError = false;
            }
        }
        // Email
        if ($(this).hasClass('email')) {
            if ($(this).val().length == '') {
                $(this).siblings('span.error').text('Please type your email address').fadeIn().parent('.form-group').addClass('hasError');
                emailError = true;
            } else {
                $(this).siblings('.error').text('').fadeOut().parent('.form-group').removeClass('hasError');
                emailError = false;
            }
        }

        if ($(this).hasClass('firstname')) {
            if ($(this).val().length == '') {
                $(this).siblings('span.error').text('Please type your first name').fadeIn().parent('.form-group').addClass('hasError');
                firstnameError = true;
            } else {
                $(this).siblings('.error').text('').fadeOut().parent('.form-group').removeClass('hasError');
                firstnameError = false;
            }
        }

        if ($(this).hasClass('lastname')) {
            if ($(this).val().length == '') {
                $(this).siblings('span.error').text('Please type your last name').fadeIn().parent('.form-group').addClass('hasError');
                lastnameError = true;
            } else {
                $(this).siblings('.error').text('').fadeOut().parent('.form-group').removeClass('hasError');
                lastnameError = false;
            }
        }        

        // PassWord
        if ($(this).hasClass('pass')) {
            if ($(this).val().length < 8) {
                $(this).siblings('span.error').text('Please type at least 8 charcters').fadeIn().parent('.form-group').addClass('hasError');
                passwordError = true;
            } else {
                $(this).siblings('.error').text('').fadeOut().parent('.form-group').removeClass('hasError');
                passwordError = false;
            }
        }

        // PassWord confirmation
        if ($('.pass').val() !== $('.passConfirm').val()) {
            $('.passConfirm').siblings('.error').text('Passwords don\'t match').fadeIn().parent('.form-group').addClass('hasError');
            passConfirm = false;
        } else {
            $('.passConfirm').siblings('.error').text('').fadeOut().parent('.form-group').removeClass('hasError');
            passConfirm = false;
        }

        // label effect
        if ($(this).val().length > 0) {
            $(this).siblings('label').addClass('active');
        } else {
            $(this).siblings('label').removeClass('active');
        }
    });

    // form switch
    $('a.switch').click(function (e) {
        $(this).toggleClass('active');
        e.preventDefault();

        if ($('a.switch').hasClass('active')) {
            $(this).parents('.form-peice').addClass('switched').siblings('.form-peice').removeClass('switched');
        } else {
            $(this).parents('.form-peice').removeClass('switched').siblings('.form-peice').addClass('switched');
        }
    });

    // Form submit
    $('form.signup-form').submit(function (event) {
        event.preventDefault();
    
        if (usernameError || firstnameError || lastnameError || emailError || passwordError || passConfirm) {
            $('.username, .firstname, .lastname, .email, .pass, .passConfirm').blur();
        } else {
    
            $.ajax({
                url: 'process.php',
                type: 'POST',
                data: {
                    Register: true, // Identifier for the register method
                    // Include other form field values here
                    username: $('#username').val(),
                    lastname: $('#lastname').val(),
                    firstname: $('#firstname').val(),
                    email: $('#email').val(),
                    password: $('#password').val(),
                },
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        // Registration successful
                        window.location.href = 'login.php'; // Redirect to success page
                    } else {
                        // Error occurred during registration
                        alert('Registration failed: ' + response.error); // Display error message
                    }
                },
                error: function (xhr, status, error) {
                    console.log(error);
                    alert('An error occurred during registration. Please try again.'); // Display generic error message
                }
            });
            
        }
    });

    $('form.login-form').submit(function (event) {
        event.preventDefault();

        $.ajax({
            url: 'process.php',
            type: 'POST',
            data: {
                Login: true, // Identifier for the register method
                // Include other form field values here
                email: $('#loginEmail').val(),
                password: $('#loginPassword').val(),
            },
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    // Registration successful
                    window.location.href = 'index.php'; // Redirect to success page
                } else {
                    // Error occurred during registration
                    alert('Log in failed: ' + response.error); // Display error message
                }
            },
            error: function (xhr, status, error) {
                console.log(error);
                alert('An error occurred during logging in. Please try again.'); // Display generic error message
            }
        });
    });
});