<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">    
    <link rel="stylesheet" href="<?php echo base_url('assets/css/homePage.css');?>">
    <title>TechSolveForum Questions</title>   
</head>
<body>
<div class="main-container">

    <!-- Left side -->      
    <div class="left-side">
        <div class="welcome-text">
       
            <h1><b>Welcome To TechSolveForum</b></h1>
            <p>Welcome to TechSolveForum, your one-stop solution for all technical queries! Whether you're a seasoned developer or just starting your tech journey, our platform caters to all. From coding to hardware troubleshooting, join our vibrant community to explore, share knowledge, and make us your go-to destination for everything tech. Ask, contribute, and let's delve into the world of technology together! Welcome aboard!</p>
        </div>
        <div class="image-container">
            <!-- The background image will cover this container -->
        </div>
    </div>

    <div class="right-side">
       <!-- Right side -->   
            <br>
            <div id="filter-buttons">                
                <button id="filter-latest">Latest</button>
                <button id="filter-top">Top</button>
                <button id="filter-unanswered">Unanswered</button>
            </div>

            <div id="question-section"></div>

            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.13.1/underscore-min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/backbone.js/1.4.0/backbone-min.js"></script>
            <script>
                var Question = Backbone.Model.extend({});

                var QuestionsCollection = Backbone.Collection.extend({
                    model: Question,
                    url: 'http://localhost/TechSolveForum/index.php/api/QuestionsApi/questions',  // Adjust this to match your CI URL structure

                    filterQuestions: function(filterType) {
                        this.fetch({
                            data: { filter: filterType },
                            reset: true
                        });
                    }
                });

                var QuestionsView = Backbone.View.extend({
                    el: '#question-section',

                    initialize: function() {
                        this.listenTo(this.collection, 'reset', this.render);
                    },

                    render: function() {
                        this.$el.html('');
                        this.collection.each(this.addQuestion, this);
                        return this;
                    },

                    addQuestion: function(question) {

                        var fullName = question.get('username');

                        var answeredSpan = ''; // Initialize an empty string for the answered span
                        if (question.get('is_answered')== 1) {
                            answeredSpan = '<span class="status answered">✔ Answered</span>';
                        }
                        
                        var questionHtml = `<div class="question">
                            <div class="question-header">
                                <span class="author">Posted by: ${fullName}</span>
                                ${answeredSpan}
                            </div>
                            <h2 class="question-title">
                                <a href="http://localhost/TechSolveForum/index.php/questions/question_details/${question.get('question_id')}">${question.get('title')}</a>
                            </h2>
                            <p class="question-content">${question.get('body')}</p>
                            <div class="question-footer">
                                <span class="answers">${question.get('answer_count')} Answers</span>
                                <span class="views">${question.get('views')} Views</span>
                                <span class="votes">${question.get('votes')} Votes</span>
                                <span class="posted-date">Posted on: ${question.get('posted_date')}</span>
                            </div>
                        </div>`;
                        this.$el.append(questionHtml);
                    }
                });

                var FilterView = Backbone.View.extend({
                    el: '#filter-buttons',
 
                    events: {
                        'click #filter-latest': function() { this.filterQuestions('latest'); },
                        'click #filter-top': function() { this.filterQuestions('top'); },
                        'click #filter-unanswered': function() { this.filterQuestions('unanswered'); }
                    },

                    initialize: function(options) {
                        this.questionsView = options.questionsView;
                    },

                    filterQuestions: function(filterType) {
                        this.questionsView.collection.filterQuestions(filterType);
                    }
                });

                $(function() {
                    var questionsCollection = new QuestionsCollection();
                    var questionsView = new QuestionsView({ collection: questionsCollection });
                    var filterView = new FilterView({ questionsView: questionsView });

                    // Loading latest questions as default
                    filterView.filterQuestions('latest');
                });
            </script>
        </div>
    </div>
</div>
</body>
</html>
