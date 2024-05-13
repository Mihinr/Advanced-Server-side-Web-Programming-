<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">    
    <link rel="stylesheet" href="<?php echo base_url('assets/css/searchResults.css');?>">
    <title>Search Results</title>   
</head>
<body>
    <div class="search-results-section">
        <h2>Search Results for "<?php echo htmlspecialchars($searchedFor, ENT_QUOTES, 'UTF-8'); ?>"</h2>

        <?php if (empty($results)): ?>
            <p>No results found.</p>
        <?php else: ?>
            <?php foreach ($results as $result): ?>
                <div class="result">
                    <h3 class="result-title">
                        <a href="<?php echo site_url('questions/question_details/' . $result['question_id']); ?>">
                            <?php echo $result['title']; ?>
                        </a>
                    </h3>
                    <p class="result-content"><?php echo $result['body']; ?></p>
                    <div class="result-footer">
                        <span class="answers"><?php echo $result['answers']; ?> Answers</span>
                        <span class="views"><?php echo $result['views']; ?> Views</span>
                        <span class="votes"><?php echo $result['votes']; ?> Votes</span>
                        <span class="posted-date">Posted on: <?php echo $result['posted_date']; ?></span>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</body>
</html>
