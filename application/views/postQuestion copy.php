<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post Question</title>

    <style>

/* General styling */
        body {
            /* font-family: Arial, sans-serif; */
            background-color: grey;
            /* margin: 20px;
            padding: 0; */
            font-family: 'Roboto Black Roman', sans-serif;
        }

        .main-container {
            display: flex;
            align-items: flex-start;
            justify-content: center;
            padding: 20px;
        }

        .content-left {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center; /* Center items horizontally */
            justify-content: center; /* Center items vertically */
            margin-right: 20px; /* Adjust as necessary for spacing between content and form */
        }

        .content-left img {
            max-width: 100%;
            height: auto;
            border-radius: 8px; /* Optional, for rounded corners on the image */
        }       

        /* Styles the form */
        #askQuestionForm {
            background-color: #b1bac4;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            margin-top: 2%;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            flex: 1;
            margin-left: 20px;
        }

        .form-group,
        .button-group {
            margin-bottom: 15px;
        }

        .form-group {
            margin-bottom: 30px; /* Increase space between form groups */
        }

        /* Styles the labels */
        .form-group label {
            display: block;
            margin-bottom: 5px; /* Reduced space between label and input */
            font-size: 16px;
            font-weight: bold; /* Optional: makes the label text bold */
        }

        /* Styles inputs and textarea */
        .form-group input[type="text"],
        .form-group textarea {
            width: 100%;
            padding: 10px;
            margin-top: 0; /* Removed top margin to bring label closer */
            display: block; /* Ensures input takes a new line after label */
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 16px;
        }

        /* Styles the file input */
        .form-group input[type="file"] {
            border: none;
            margin-top: 8px;
        }

        /* Styles the buttons */
        .button-group button,
        .button-group input[type="submit"] {
            width: auto; /* Adjust the width as desired, or use auto to fit content */
            padding: 10px 15px; /* Adjust padding as needed */
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            display: inline-block; /* This will place buttons side by side */
            box-sizing: border-box; /* This ensures that padding and border are included in the width */
        }

        /* Additional CSS to ensure the buttons don't wrap */
        .button-group {
            display: flex;
            justify-content: flex-end; /* Aligns buttons to the right */
            flex-wrap: wrap; /* Allows button wrapping if needed */
            margin-bottom: 20px;
            gap: 10px; /* This adds space between buttons when they wrap */
        }


        .button-group button,
        .button-group input[type="submit"] {
            padding: 10px 15px; /* Adjust padding as needed */
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            min-width: 120px; /* Minimum width for buttons */
            box-sizing: border-box;
        }

        .button-group button[type="reset"],
        .button-group input[type="submit"] {
            background-color: Black;
            color: white;
            width: max-content; /* Ensures the button is only as wide as its content, respecting the padding */
        }

        .button-group button[type="reset"]:hover,
        .button-group input[type="submit"]:hover {
            opacity: 0.9;
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
    <div class="main-container">

        <!-- Content on the left -->
    <div class="content-left">
        <h1><b>Welcome To TechSolveForum</b></h1>
        <p style="text-align: center;">Welcome to TechSolveForum, your one-stop solution for all technical queries! Whether you're a seasoned developer or just starting your tech journey, our platform caters to all. From coding to hardware troubleshooting, join our vibrant community to explore, share knowledge, and make us your go-to destination for everything tech. Ask, contribute, and let's delve into the world of technology together! Welcome aboard!</p>
        <img src="/TechSolveForum/assets/images/displayimage.jpg" alt="Descriptive Alt Text">
    </div>
         <!-- Ask Question Form on the right -->
        <form id="askQuestionForm" >
            <div id="message" style="display: none; color: green;">Successfully Registered User!</div>

            <h2><b>Ask A Question</b></h2><br>
            <div class="form-group">
                <label for="title">Title Of The Question</label>
                <input type="text" id ="title" name="title" placeholder="Title" required >
            </div>
            <div class="form-group">
                <label for="tags">Tags</label>
                <input type="text" id="tags" name="tags" placeholder="Tags (comma separated)" required>
            </div>
            <div class="form-group">
                <label for="image">Upload Image</label>
                <input type="file" id="image" name="image">
            </div>
            <div class="form-group">
                <label for="body">Description</label>
                <textarea name="body" id="body" placeholder="Description" required rows="10"></textarea>
            </div>
            
            
            <div class="button-group">
                <button type="reset">Clear Fields</button>
                <input type="submit" value="Submit">
            </div>
        </form>


        <script>
            // Backbone View for the form
            var FormView = Backbone.View.extend({
                el: '#askQuestionForm',
                events: {
                    'submit': 'handleSubmit'
                },
                handleSubmit: function(event) {
                    event.preventDefault(); // Prevent default form submission

                    var formData = new FormData(this.el); // Serialize form data
                    

                    // Send AJAX request to backend
                    $.ajax({
                        url: 'http://localhost/TechSolveForum/index.php/Questions/post_questiontest', // Replace 'backend.php' with your PHP endpoint
                        type: 'POST',
                        data: formData,
                        processData: false, // Prevent jQuery from processing the data
                        contentType: false, // Set content type to false for FormData
                        success: function(response) {
                            // Handle success response
                            console.log('Success');
                        // Display message based on condition
                        var message = '';
                            var color = '';
                            if (response.condition === 'A') {
                                message = 'Successfully Posted The Question';
                                color = 'green';
                              
                                
                            } else if (response.condition === 'B') {
                                message = 'Failed To Post Question... Please Try Again.';
                                color = 'red';
                            } 
                            else if (response.condition === 'D') {
                                message = 'No user logged in';
                                color = 'red';
                            } 
                            else {
                                // Default message if condition is neither A nor B
                                message = 'Image Format Is Not Supported';
                                color = 'red';
                            }

                            $('#message').text(message).css('color', color).show();


                            setTimeout(function() {
                                $('#message').hide();
                            }, 6000); // Hide message after 6 seconds
                        },
                        error: function(xhr, status, error) {
                            // Handle error
                            console.error(error);
                        }
                    });
                }
            });
           
            

            // Instantiate the form view
            var formView = new FormView();

        </script>
    </div>

</body>
</html>