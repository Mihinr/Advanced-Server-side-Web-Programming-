<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Results</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 20px;
            color: #333;
        }

        h2 {
            color: #333;
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        li {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <?php
    // Student data
    $students = array(
        "Samwise Gamgee" => 88,
        "Frodo Baggins" => 56,
        "Elrond Half-Elven" => 92,
        "Gandalf Mithrandir" => 35,
        "Merry Brandybuck" => 41,
        "Pippin Took" => 25,
        "Legolas Greenleaf" => 67
    );

    // Get the user input
    if (isset($_POST['mark'])) {
        $user_mark = intval($_POST['mark']);

        // Display students with marks equal to or above the user input
        echo "<h2>Students with Marks $user_mark and Above:</h2>";
        echo "<ul>";
        foreach ($students as $student => $mark) {
            if ($mark >= $user_mark) {
                echo "<li>$student - $mark</li>";
            }
        }
        echo "</ul>";
    } else {
        // If no user input, display a message
        echo "<p>Please enter a mark using the form above.</p>";
    }
    ?>
</body>
</html>
