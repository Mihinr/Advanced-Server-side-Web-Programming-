<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Module Mark Result</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        div {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            text-align: center;
            width: 300px;
        }

        h1 {
            color: #333;
        }

        p {
            margin: 10px 0;
            color: #555;
        }
    </style>
</head>
<body>
    <div>
        <h1>Module Mark Result</h1>

        <?php
        // Check if form is submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Retrieve marks from the form
            $cw1 = isset($_POST['cw1']) ? $_POST['cw1'] : 0;
            $cw2 = isset($_POST['cw2']) ? $_POST['cw2'] : 0;

            // Validate marks (you can add additional validation if needed)

            // Calculate overall module mark
            $overallMark = ($cw1 * 0.4) + ($cw2 * 0.6);

            // Display the result
            echo "<p>Coursework 1 Mark: $cw1</p>";
            echo "<p>Coursework 2 Mark: $cw2</p>";
            echo "<p>Overall Module Mark: $overallMark</p>";
        } else {
            // If the form is not submitted, display an error message
            echo "<p>Error: Form not submitted.</p>";
        }
        ?>

    </div>
</body>
</html>
