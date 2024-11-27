<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Terms and Conditions</title>
    <style>
        /* General Styles */
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
            color: #444;
            line-height: 1.6;
        }

        /* Container */
        .container {
            max-width: 800px;
            margin: 30px auto;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            padding: 20px 30px;
        }

        /* Header Styles */
        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h1 {
            font-size: 28px;
            color: #333;
            margin: 0;
        }

        .header p {
            font-size: 14px;
            color: #666;
        }

        /* Section Headings */
        h2 {
            font-size: 20px;
            margin-top: 20px;
            color: #2c3e50;
            border-bottom: 2px solid #3498db;
            padding-bottom: 5px;
        }

        /* Text Styles */
        p, ul {
            font-size: 16px;
            margin: 10px 0;
        }

        ul {
            padding-left: 20px;
            list-style: disc;
        }

        ul li {
            margin-bottom: 8px;
        }

        /* Links */
        a {
            color: #3498db;
            text-decoration: none;
            font-weight: bold;
        }

        a:hover {
            text-decoration: underline;
        }

        /* Back Link */
        .back-link {
            text-align: center;
            margin-top: 20px;
            display: block;
            padding: 10px;
            background-color: #3498db;
            color: #fff;
            border-radius: 5px;
            text-decoration: none;
            font-size: 14px;
            width: 150px;
            margin-left: auto;
            margin-right: auto;
        }

        .back-link:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Terms and Conditions</h1>
            <p>Please read these terms carefully before using the RFID-Based Gate Pass Management System.</p>
        </div>

        <!-- Terms and Conditions Content -->
        <h2>1. Definitions</h2>
        <p>
            <strong>System:</strong> Refers to the RFID-Based Gate Pass Management System.<br>
            <strong>User:</strong> Refers to any individual authorized to use the system.<br>
            <strong>Administrator:</strong> Refers to the personnel responsible for managing the system.
        </p>

        <!-- Other sections go here -->

        <!-- Back Link -->
        <a id="backLink" class="back-link" href="#">Back to Home</a>
    </div>

    <script>
        // Redirect to the last visited page
        const backLink = document.getElementById('backLink');
        const referrer = document.referrer;

        if (referrer) {
            backLink.href = referrer; // Set the href to the last visited page
        } else {
            backLink.href = '/'; // Default to the home page if no referrer
        }
    </script>
</body>
</html>
