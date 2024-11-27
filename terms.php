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
            border-bottom: 2px solid #ffc107;
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
            background-color: #ffc107;
            color: #fff;
            border-radius: 5px;
            text-decoration: none;
            font-size: 14px;
            width: 150px;
            margin-left: auto;
            margin-right: auto;
        }

        .back-link:hover {
            background-color: #fd7e14;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Terms and Conditions</h1>
            <p>Please read these terms carefully before using the RFID-Based Gate Pass Management System.</p>
        </div>

        <h2>1. Definitions</h2>
        <p>
            <strong>System:</strong> Refers to the RFID-Based Gate Pass Management System.<br>
            <strong>User:</strong> Refers to any individual authorized to use the system.<br>
            <strong>Administrator:</strong> Refers to the personnel responsible for managing the system.
        </p>

        <h2>2. Acceptance of Terms</h2>
        <p>By using the system, you acknowledge that you have read, understood, and agree to these terms and conditions.</p>

        <h2>3. Purpose</h2>
        <p>The system is designed to enhance safety by tracking the entry and exit of personnel and visitors.</p>

        <h2>4. User Responsibilities</h2>
        <ul>
            <li>Ensure your RFID card/tag is secure and used only by you.</li>
            <li>Report any loss or theft of your RFID card/tag immediately.</li>
            <li>Follow school policies when using the system.</li>
        </ul>

        <h2>5. Data Collection and Privacy</h2>
        <p>
            The system collects personal information for tracking and management purposes.
            Your data is securely stored and will not be shared with unauthorized third parties.
        </p>

        <h2>6. System Access</h2>
        <p>Access is restricted to authorized personnel. Unauthorized tampering or hacking is prohibited.</p>

        <h2>7. Liability</h2>
        <p>
            The institution is not liable for unauthorized use of the system. In case of malfunctions, we aim to resolve issues promptly.
        </p>

        <h2>8. Prohibited Actions</h2>
        <ul>
            <li>Sharing RFID cards/tags with others.</li>
            <li>Using someone else’s RFID card/tag.</li>
            <li>Disrupting system operations.</li>
        </ul>

        <h2>9. Penalties for Misuse</h2>
        <p>Misuse of the system will result in disciplinary action per institutional policies.</p>

        <h2>10. System Maintenance</h2>
        <p>Maintenance may cause temporary unavailability. Users will be informed of scheduled downtime.</p>

        <h2>11. Amendments</h2>
        <p>The institution reserves the right to amend these terms at any time. Users will be notified of changes.</p>

        <h2>12. Contact</h2>
        <p>For questions or concerns, contact the system administrator.</p>

        <a href="#" id="backLink" class="back-link">Back to Home</a>
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
