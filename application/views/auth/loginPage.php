<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/loginPage.css');?>">
    <title>Login</title>    
    <!-- Include jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- Include Underscore.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.13.1/underscore-min.js"></script>
    <!-- Include Backbone.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/backbone.js/1.4.0/backbone-min.js"></script>
</head>
<body>
    <div class="register-box">
        <h2 class="heading">Login</h2>
        <!-- Status message -->
        <div id="message" style="display: none; color: green;">Successfully Registered User!</div>
        <form id="loginForm">
            <div class="form-field">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="" required>
            </div>
            <div class="form-field">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="" required>
            </div>
            <div class="form-field">
                <input type="submit" value="Login">
            </div>
            <p>Don't have an account? <a href="<?= site_url('Auth/loadRegister'); ?>">Sign Up Now</a></p>
        </form>
    </div>
    <script>
        var PersonModel = Backbone.Model.extend({
            defaults: {
                email: '',
                password: ''
            }
        });

        var PersonView = Backbone.View.extend({
            el: "#loginForm",
            events: {
                'submit': 'savePerson'
            },
            initialize: function() {
                this.model = new PersonModel();
            },
            savePerson: function(event) {
                event.preventDefault();
                this.model.set({
                    email: this.$('#email').val(),
                    password: this.$('#password').val()
                });
                $.ajax({
                    url: 'http://localhost/TechSolveForum/index.php/api/UsersApi/login',
                    type: 'POST',
                    data: this.model.toJSON(),
                    xhrFields: {
                        withCredentials: true
                    },
                    success: function(response) {
                        console.log('Request successful');
                        console.log('Condition:', response.condition);
                        console.log('Session Data:', response.sessionData);
                        window.location.href = 'http://localhost/TechSolveForum/index.php/home';
                        setTimeout(function() {
                            $('#message').hide();
                        }, 10000); // Hide message after 6 seconds
                    },
                    error: function(xhr, status, error) {
                        console.error('Error saving data:', error);
                        var message = 'Invalid Email or Password';
                        $('#message').text(message).css('color', 'red').show();
                    }
                });
            }
        });

        var personView = new PersonView();
    </script>
</body>
</html>
