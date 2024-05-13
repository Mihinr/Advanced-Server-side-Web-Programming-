<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/questionDetails.css');?>">
    <title>Question Details | TechSolveForum</title>   
</head>
<body>
    <!-- Question details section -->
    <div id="question-details">
        <h1><?= htmlspecialchars($question['title'], ENT_QUOTES, 'UTF-8') ?></h1>
        <p>Asked by: <?= htmlspecialchars($question['username'], ENT_QUOTES, 'UTF-8') ?></p>
        <p>Posted date: <?= nl2br(htmlspecialchars($question['posted_date'], ENT_QUOTES, 'UTF-8')) ?></p>
        <p>Description: <?= nl2br(htmlspecialchars($question['body'], ENT_QUOTES, 'UTF-8')) ?></p>
        <p>Key Words: <?= nl2br(htmlspecialchars($question['tags'], ENT_QUOTES, 'UTF-8')) ?></p>
        <p>Answers: <?= nl2br(htmlspecialchars($question['answer_count'], ENT_QUOTES, 'UTF-8')) ?></p>
        <?php if (!empty($question['image_path'])): ?>
            <img src="<?= base_url($question['image_path']) ?>" alt="Question Image">
        <?php endif; ?>
        <br>
        <button class="vote-btn" onclick="voteQuestion(<?= $question['question_id'] ?>, 'up')">
            <img src="/TechSolveForum/assets/images/up.png" alt="Upvote">
        </button>
        <span><?= $question['votes'] ?></span>
        <button class="vote-btn" onclick="voteQuestion(<?= $question['question_id'] ?>, 'down')">
            <img src="/TechSolveForum/assets/images/down.png" alt="Downvote">
        </button>
        <br><br>
        <?php if ($question['is_answered'] == 1): ?>
            <span class="isAnswered"><b>✔ Answered</b></span>
        <?php endif; ?>
    </div>

    <!-- Answer details section         -->
    <section id="answers">
        <h2>Answers</h2>
        <?php foreach ($answers as $answer): ?>
            <article class="answer-container">
                <div class="vote-container">
                    <?php if ($answer['is_accepted'] == 1): ?>
                        <span class="isAnswered">Accepted</span>
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
                    <p>Posted date: <?= nl2br(htmlspecialchars($answer['answered_date'], ENT_QUOTES, 'UTF-8')) ?></p>
                </div>
            </article>
        <?php endforeach; ?>
    </section>

    <div id="success-message"></div>

    <!-- Post answer section -->
    <section id="post-answer">
        <div class="postAnswer">
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
            displayReloadMessage();
        });

        document.getElementById('answerForm').onsubmit = function(event) {
            event.preventDefault();
            var formData = new FormData(this);
            fetch('<?= site_url('api/AnswersApi/post_answer') ?>', {
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

        //Vote answer
        function voteAnswer(answerId, direction) {
            fetch(`<?= site_url('api/AnswersApi/vote_answer/') ?>${answerId}/${direction}`, {
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

        //Vote question
        function voteQuestion(questionId, direction) {
            const url = `<?= site_url('api/QuestionsApi/vote_questions/') ?>${questionId}`;
            fetch(url, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ type: direction })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok: ' + response.statusText);
                }
                return response.json();
            })
            .then(data => {
                if (data.status === 'success') {
                    setReloadMessage(data.message, 'success');
                } else {
                    alert(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                setReloadMessage('Error voting on question.', 'error');
            });
        }

        //Accept answer
        function acceptAnswer(answerId, questionId) {
            fetch(`<?= site_url('api/AnswersApi/accept_answer/') ?>${answerId}/${questionId}`, {
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

        //Reject answer
        function rejectAnswer(answerId, questionId) {
            fetch(`<?= site_url('api/AnswersApi/reject_answer/') ?>${answerId}/${questionId}`, {
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

        //Display message
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
