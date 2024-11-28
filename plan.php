<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Incident Response and Recovery Plan</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #e9ecef;
        }
        .container {
            margin-top: 30px;
        }
        .card {
            border-radius: 10px;
            margin-bottom: 20px;
        }
        .card-header {
            background-color: #007bff;
            color: white;
            font-size: 1.25rem;
            font-weight: bold;
        }
        .card-body {
            background-color: #ffffff;
            padding: 20px;
            font-size: 1rem;
            line-height: 1.6;
        }
        .btn-back {
            margin-top: 30px;
            display: block;
            width: 200px;
            margin: 30px auto;
        }
        .section-title {
            font-size: 1.5rem;
            font-weight: bold;
            color: #007bff;
        }
        .section-content {
            margin-top: 15px;
        }
        .section-content ul {
            list-style-type: disc;
            margin-left: 20px;
        }
        .section-content ul li {
            margin-bottom: 10px;
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
    <h2 class="text-center mb-5 text-primary">Incident Response and Recovery Plan</h2>
    
    <!-- Preparation Section -->
    <div class="card">
        <div class="card-header">1. Preparation</div>
        <div class="card-body">
            <p class="section-title">Incident Response Team (IRT):</p>
            <div class="section-content">
                <ul>
                    <li>Form a dedicated response team consisting of system administrators, network security personnel, and key stakeholders.</li>
                    <li>Ensure that necessary tools such as monitoring systems, forensic tools, and backup resources are in place.</li>
                    <li>Establish clear guidelines on what constitutes an "incident."</li>
                    <li>Define communication channels and processes for reporting incidents.</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Identification Section -->
    <div class="card">
        <div class="card-header">2. Identification</div>
        <div class="card-body">
            <p class="section-title">Incident Detection:</p>
            <div class="section-content">
                <ul>
                    <li>Continuously monitor RFID-based gatepass logs, user access attempts, and system logs.</li>
                    <li>Implement an alerting system for unusual patterns or errors, such as repeated failed login attempts.</li>
                    <li>Assess the situation to determine whether it is a real incident or a false alarm.</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Containment Section -->
    <div class="card">
        <div class="card-header">3. Containment</div>
        <div class="card-body">
            <p class="section-title">Immediate Action:</p>
            <div class="section-content">
                <ul>
                    <li>Isolate the affected part of the system to prevent further damage.</li>
                    <li>Block compromised users, devices, or systems and disconnect affected RFID devices.</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Eradication Section -->
    <div class="card">
        <div class="card-header">4. Eradication</div>
        <div class="card-body">
            <p class="section-title">Root Cause Analysis:</p>
            <div class="section-content">
                <ul>
                    <li>Investigate the incident thoroughly to identify the root cause.</li>
                    <li>Apply patches or fix configurations that allowed the incident to happen.</li>
                    <li>Document actions taken and preserve evidence for future audits.</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Recovery Section -->
    <div class="card">
        <div class="card-header">5. Recovery</div>
        <div class="card-body">
            <p class="section-title">Restore Operations:</p>
            <div class="section-content">
                <ul>
                    <li>Restore the system to normal operations, ensuring security settings are enhanced.</li>
                    <li>Run security scans and tests to ensure the system functions properly.</li>
                    <li>Increase monitoring of the system after recovery to ensure no further incidents occur.</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Lessons Learned Section -->
    <div class="card">
        <div class="card-header">6. Lessons Learned</div>
        <div class="card-body">
            <p class="section-title">Post-Incident Review:</p>
            <div class="section-content">
                <ul>
                    <li>Conduct a debriefing meeting to evaluate the incident and improve the system.</li>
                    <li>Update the Incident Response Plan based on lessons learned.</li>
                    <li>Implement additional security controls to mitigate future risks.</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Disaster Recovery Plan Section -->
    <div class="card">
        <div class="card-header">7. Disaster Recovery Plan</div>
        <div class="card-body">
            <p class="section-title">Risk Assessment:</p>
            <div class="section-content">
                <ul>
                    <li>Identify and prioritize key system components.</li>
                    <li>Regularly back up critical data and systems.</li>
                    <li>Implement system failover and backup restoration strategies.</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Security Awareness Training Section -->
    <div class="card">
        <div class="card-header">8. Security Awareness Training</div>
        <div class="card-body">
            <p class="section-title">RFID Security Best Practices:</p>
            <div class="section-content">
                <ul>
                    <li>Educate users on safeguarding RFID cards and devices.</li>
                    <li>Train staff on recognizing phishing attacks and social engineering.</li>
                    <li>Teach staff how to report incidents promptly and follow escalation procedures.</li>
                    <li>Conduct regular training and simulated security breach scenarios.</li>
                </ul>
            </div>
        </div>
    </div>

    <a href="#" id="backLink" class="back-link">Back to Home</a>
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
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

    

