<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
    <style>
        body, html {
            background-image: url('/TechSolveForum/assets/images/bgimg2.jpg');
            background-color: #F5F5F5;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
            background-attachment: fixed;
        }
        .register-box {
            width: 350px;
            margin: auto;
            margin-top: 5%;
            padding: 20px;
            background: rgba(255, 255, 255, 0.0);
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .heading {
            text-align: center;
        }
        .form-field {
            margin-bottom: 15px;
        }
        .form-field input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        .form-field input[type="submit"] {
            background-color: Black;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        .form-field input[type="submit"]:hover {
            background-color: Blue;
        }
    </style>
    <!-- Include jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- Include Underscore.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.13.1/underscore-min.js"></script>
    <!-- Include Backbone.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/backbone.js/1.4.0/backbone-min.js"></script>
</head>
<body>
    <div class="register-box">
        <h2 class="heading">Sign Up</h2>
        <!-- Status message -->
        <div id="message" style="display: none; color: green;">Successfully Registered User!</div>
        <form id="registerForm">
            <div class="form-field">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" placeholder="Username" required>
            </div>
            <div class="form-field">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="example@gmail.com" required>
            </div>
            <div class="form-field">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="abcd123" required>
            </div>
            <div class="form-field">
                <input type="submit" name="signupSubmit" value="Sign up">
            </div>
            <p>Already have an account? <a href="<?= site_url('Auth/loadLogin'); ?>">Login here</a></p>
        </form>
    </div>
    <script>
        var PersonModel = Backbone.Model.extend({
            defaults: {
                username: '',
                email: '',
                password: ''
            }
        });

        var PersonView = Backbone.View.extend({
            el: "#registerForm",
            events: {
                'submit': 'savePerson'
            },
            initialize: function() {
                this.model = new PersonModel();
            },
            savePerson: function(event) {
                event.preventDefault();
                this.model.set({
                    username: this.$('#username').val(),
                    email: this.$('#email').val(),
                    password: this.$('#password').val()
                });
                $.ajax({
                    url: 'http://localhost/TechSolveForum/index.php/api/UsersApi/registration',
                    type: 'POST',
                    data: this.model.toJSON(),
                    success: function(response) {
                        console.log('Data saved successfully');
                        var message = 'User Registered Successfully';
                        var color = 'green';                        
                        $('#message').text(message).css('color', color).show();
                        $('#registerForm').find('input[type="text"], input[type="email"], input[type="password"]').val('');
                        setTimeout(function() {
                            $('#message').hide();                            
                        }, 5000); // Hide message after 5 seconds                        
                        
                    },
                    error: function(xhr, status, error) {
                        console.error('Error saving data:', error);
                        var message = 'User Registration Failed';
                        var color = 'red';
                        $('#message').text(message).css('color', color).show();
                    }
                });
            }
        });

        var personView = new PersonView();
    </script>
</body>
</html>
