<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Question Details | TechSolveForum</title>
    <style>
        
        body {
           
            background-color: #faf0e6; /* Fallback color */
            
        }

        #question-details, #answers, #post-answer {
            /* background-color: #fff; */
            padding: 20px;
            margin: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.8);
        }

        h1, h2 {
            color: #333;
        }

        #question-details img {
            max-width: 100%;
            height: auto;
            border-radius: 5px;
            margin-top: 15px;           

        }

        #question-details {
           
            background-color:#999b84;          

        }

        .answer-container {
            padding: 15px;
            border-top: 2px solid #ddd;
            margin-top: 15px;
            display: flex;
            justify-content: space-between;
            background-color:#e4d5b7;
        }

        .vote-container {
            display: flex;
            align-items: center;
            flex-direction: column;
        }

        .vote-container span {
            padding: 5px;
        }

        .answer-details {
            flex-grow: 1;
            padding-left: 20px;
            
        }

        .form-group {
            margin-bottom: 20px;
            

        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
        }

        .form-group textarea {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            resize: vertical;
            background-color:#7ac486;
        }

        .btn {
            background-color: green;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        .btn:hover {
            background-color: black;
        }

        #success-message {
            color: green;
            margin: 10px 20px;
            text-align: center;
            display: none; /* Hidden by default */
        }

        .vote-btn {
            border: none;
            background: none;
            cursor: pointer;
            padding: 5px 10px; /* Adjust padding as needed */
        }

        .vote-btn img {
            height: 20px; /* Adjust size as needed */
            width: auto;
            display: block; /* Centers the image in the button */
            
        }

        .postAnswer {
            /* background-color:#7ac486; */
            
        }

        .btn-accept {
            background-color: green;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        .btn-accept:hover {
            background-color: darkgreen;
        }

        .btn-reject {
            background-color: red;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        .btn-reject:hover {
            background-color: darkred;
        }
        
       
        
    </style>
</head>
<body>
    <div id="question-details">      
 
        <h1><?= htmlspecialchars($question['title'], ENT_QUOTES, 'UTF-8') ?></h1>
        <p>Asked by : <?= htmlspecialchars($question['username'], ENT_QUOTES, 'UTF-8') ?></p>
        <p>Posted date : <?= nl2br(htmlspecialchars($question['posted_date'], ENT_QUOTES, 'UTF-8')) ?></p>
        <p>Key Words : <?= nl2br(htmlspecialchars($question['body'], ENT_QUOTES, 'UTF-8')) ?></p>        
        <p>Answers :<?= nl2br(htmlspecialchars($question['answer_count'], ENT_QUOTES, 'UTF-8')) ?></p>

        <?php if ($question['is_answered']== 1): ?>
            <span class="isAnswered" > <b> ✔ Answered </b></span>
            
        <?php endif; ?>   


        <?php if (!empty($question['image_path'])): ?>
            <img src="<?= base_url($question['image_path']) ?>" alt="Question Image">
        <?php endif; ?>
    </div>

    <section id="answers">
        <h2>Answers</h2>
        <?php foreach ($answers as $answer): ?>
            <article class="answer-container">
                <div class="vote-container">

                <?php if ($answer['is_accepted']== 1): ?>
                    <span class="isAnswered" > Accepted</span>            
                <?php endif; ?>                    
                
                    <button class="vote-btn" onclick="voteAnswer(<?= $answer['answer_id'] ?>, 'up')">
                        <img src="/TechSolveForum/assets/images/up.png" alt="Upvote">
                    </button>
                    <span><?= $answer['votes'] ?></span>
                    <button class="vote-btn" onclick="voteAnswer(<?= $answer['answer_id'] ?>, 'down')">
                        <img src="/TechSolveForum/assets/images/down.png" alt="Downvote">
                    </button>
                </div>
                <div class="answer-details">
                    <p>Answered by: <?= htmlspecialchars($answer['username'], ENT_QUOTES, 'UTF-8') ?></p>
                    <div class="answerDetailsContainer">
                    <p><?= nl2br(htmlspecialchars($answer['body'], ENT_QUOTES, 'UTF-8')) ?></p>
                    </div>
                    <?php if ($this->session->userdata('userId') == $question['user_id']): ?>
                        <?php if (!$answer['is_accepted']): ?>           
                            <button onclick="acceptAnswer(<?= $answer['answer_id'] ?>, <?= $question['question_id'] ?>)" class="btn-accept">Accept Answer</button>                       
                        <?php else: ?>
                            <button onclick="rejectAnswer(<?= $answer['answer_id'] ?>, <?= $question['question_id'] ?>)" class="btn-reject">Reject Answer</button>
                        <?php endif; ?>
                    <?php endif; ?>
                    <p>Posted date :<?= nl2br(htmlspecialchars($answer['answered_date'], ENT_QUOTES, 'UTF-8')) ?></p>

                    
                </div>
                
            </article>
            
        <?php endforeach; ?>
    </section>

    <div id="success-message"></div>

    <section id="post-answer">
        <div class = "postAnswer">
        <h2>Your Answer</h2>
        <form id="answerForm">
            <div class="form-group">
                <label for="answer-body">Answer:</label>
                <textarea id="answer-body" name="body" rows="6" required></textarea>
            </div>
            <input type="hidden" name="question_id" value="<?= $question['question_id'] ?>" />
            <button type="submit" class="btn">Post Answer</button>
        </form>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            displayReloadMessage(); // Display any message that was set before reload
        });

        document.getElementById('answerForm').onsubmit = function(event) {
            event.preventDefault();
            var form = this;
            var formData = new FormData(form);
            var successMessage = document.getElementById('success-message');

            fetch('<?= site_url('answers/post_answer') ?>', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                setReloadMessage(data.message, data.status);
            })
            .catch(error => {
                console.error('Error:', error);
                setReloadMessage('Error posting answer.', 'error');
            });
        };

        function voteAnswer(answerId, direction) {
            fetch(`<?= site_url('answers/vote_answer/') ?>${answerId}/${direction}`, {
                method: 'POST'
            })
            .then(response => response.json())
            .then(data => {
                setReloadMessage(data.message, data.status);
            })
            .catch(error => {
                console.error('Error:', error);
                setReloadMessage('Error voting on answer.', 'error');
            });
        }

        function acceptAnswer(answerId, questionId) {
            fetch(`<?= site_url('answers/accept_answer/') ?>${answerId}/${questionId}`, {
                method: 'POST'
            })
            .then(response => response.json())
            .then(data => {
                setReloadMessage(data.message, data.status);
            })
            .catch(error => {
                console.error('Error:', error);
                setReloadMessage('Error accepting the answer.', 'error');
            });
        }

        function rejectAnswer(answerId, questionId) {
            fetch(`<?= site_url('answers/reject_answer/') ?>${answerId}/${questionId}`, {
                method: 'POST'
            })
            .then(response => response.json())
            .then(data => {
                setReloadMessage(data.message, data.status);
            })
            .catch(error => {
                console.error('Error:', error);
                setReloadMessage('Error rejecting the answer.', 'error');
            });
        }

        function displayMessage(message, status) {
            var successMessage = document.getElementById('success-message');
            successMessage.textContent = message;
            successMessage.style.display = 'block';
            successMessage.style.color = (status === 'success') ? 'green' : 'red';
        }

        function setReloadMessage(message, status) {
            sessionStorage.setItem('reloadMessage', JSON.stringify({ message, status }));
            location.reload();
        }

        function displayReloadMessage() {
            const messageData = sessionStorage.getItem('reloadMessage');
            if (messageData) {
                const { message, status } = JSON.parse(messageData);
                displayMessage(message, status);
                sessionStorage.removeItem('reloadMessage');
            }
        }
    </script>
</body>
</html>
