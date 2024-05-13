<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/profile.css');?>">
    <title>TechSolveForum Profile</title>   
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>
<body>
    <!-- <div id="profile-section"> -->
        <div class="profile-header">
            <h1>My Profile</h1>          
        </div>

        <div class="questions-answers">
            <div class="questions">
                <h3>Questions</h3>
                <?php foreach ($questions as $question): ?>
                    <div class="question" data-question-id="<?php echo $question['question_id']; ?>">

                        <h4 class="question-title" style="text-align: left;"><a href="http://localhost/TechSolveForum/index.php/questions/question_details/<?php echo $question['question_id']; ?>" >  <?php echo $question['title']; ?> </a> </h4>
                        <p><?php echo $question['body']; ?></p>
                        <p><?php echo $question['answer_count']; ?> Answers <?php echo $question['views']; ?> Views Posted on <?php echo $question['posted_date']; ?></p>
                        <button class="delete-question">Delete</button>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="answers">
                <h3>Answers</h3>
                <?php foreach ($answers as $answer): ?>
                    <div class="answer" data-answer-id="<?php echo $answer['answer_id']; ?>">
                    <a href="http://localhost/TechSolveForum/index.php/questions/question_details/<?php echo $answer['question_id']; ?>" > Link to question  </a> </h4>
                        <h4 style="text-align: left;"class="question-title"><p class="answer-content"><?php echo $answer['body']; ?></p>
                        <p>Answered on <?php echo $answer['answered_date']; ?></p>
                        <button class="delete-answer" >Delete</button>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            $(".delete-question").click(function () {
                var questionDiv = $(this).closest(".question");
                var questionId = questionDiv.data("question-id");
                $.ajax({
                    url: "<?php echo site_url('profile/delete_question'); ?>/" + questionId,
                    type: "DELETE",
                    success: function (response) {
                        questionDiv.remove();
                    }
                });
            });

            $(".delete-answer").click(function () {
                var answerDiv = $(this).closest(".answer");
                var answerId = answerDiv.data("answer-id");
                $.ajax({
                    url: "<?php echo site_url('profile/deleteAnswer'); ?>/" + answerId,
                    type: "DELETE",
                    success: function (response) {
                        answerDiv.remove();
                    }
                });
            });
        });
    </script>
</body>
</html>
