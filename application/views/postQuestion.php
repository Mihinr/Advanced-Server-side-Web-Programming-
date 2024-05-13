<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/postQuestions.css');?>">
    <title>Post Question</title>

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
// Backbone View for the form
var FormView = Backbone.View.extend({
    el: '#askQuestionForm',
    events: {
        'submit': 'handleSubmit'
    },
    handleSubmit: function(event) {
        event.preventDefault(); // Prevent default form submission

        var formData = new FormData(this.el); // Serialize form data
        var self = this; // Reference to the form view

        // Send AJAX request to backend
        $.ajax({
            url: 'http://localhost/TechSolveForum/index.php/api/QuestionsApi/create', // Updated endpoint
            type: 'POST',
            data: formData,
            processData: false, // Prevent jQuery from processing the data
            contentType: false, // Set content type to false for FormData
            success: function(response, textStatus, xhr) {
                console.log('Success', response);
                var message = '';
                var color = '';

                // Check for HTTP Status Code
                if (xhr.status === 201) { // HTTP_CREATED
                    message = 'Successfully Posted The Question';
                    color = 'green';
                    self.clearForm();
                } else if (xhr.status === 401) { // HTTP_UNAUTHORIZED
                    message = 'No user logged in';
                    color = 'red';
                } else if (xhr.status === 500) { // HTTP_INTERNAL_ERROR
                    message = 'Failed To Post Question... Please Try Again.';
                    color = 'red';
                } else if (xhr.status === 400) { // HTTP_BAD_REQUEST
                    message = 'Image Format Is Not Supported';
                    color = 'red';
                } else {
                    message = response.message || 'An error occurred';
                    color = 'red';
                }

                $('#message').text(message).css('color', color).show();
                setTimeout(function() {
                    $('#message').hide();
                }, 6000); // Hide message after 6 seconds
            },
            error: function(xhr, status, error) {
                console.error('Request failed:', status, error);
                var message = 'Incorrect image format';
                $('#message').text(message).css('color', 'red').show();
                setTimeout(function() {
                    $('#message').hide();
                }, 6000);
            }
        });
    },
    clearForm: function() {
        this.el.reset(); // Reset the form fields
    }
});

// Instantiate the form view
var formView = new FormView();


        </script>
    </div>

</body>
</html>