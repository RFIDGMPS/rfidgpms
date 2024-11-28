<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Incident Response and Recovery Plan</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
        }
        .container {
            margin-top: 20px;
        }
        .sidebar {
            height: 100%;
            background-color: #343a40;
            color: white;
            padding-top: 20px;
        }
        .sidebar a {
            color: white;
            padding: 10px 15px;
            text-decoration: none;
            display: block;
        }
        .sidebar a:hover {
            background-color: #575757;
        }
        .content {
            padding-left: 20px;
        }
        .section-title {
            margin-top: 20px;
            font-size: 24px;
            font-weight: bold;
            color: #007bff;
        }
        .section-content {
            font-size: 16px;
            line-height: 1.6;
        }
        .section-content ul {
            list-style-type: disc;
            margin-left: 20px;
        }
        .btn-back {
            margin-top: 20px;
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

<div class="d-flex">
    <!-- Sidebar -->
    <div class="sidebar col-md-3">
        <h4 class="text-center">Incident Response Plan</h4>
        <a href="#preparation">Preparation</a>
        <a href="#identification">Identification</a>
        <a href="#containment">Containment</a>
        <a href="#eradication">Eradication</a>
        <a href="#recovery">Recovery</a>
        <a href="#lessons-learned">Lessons Learned</a>
        <a href="#disaster-recovery">Disaster Recovery</a>
        <a href="#security-awareness">Security Awareness Training</a>
    </div>

    <!-- Main Content -->
    <div class="content col-md-9">
        <div id="preparation">
            <h2 class="section-title">1. Preparation</h2>
            <div class="section-content">
                <ul>
                    <li><strong>Incident Response Team (IRT):</strong> Form a dedicated response team consisting of system administrators, network security personnel, and key stakeholders.</li>
                    <li><strong>Tools and Resources:</strong> Ensure that necessary tools such as monitoring systems, forensic tools, and backup resources are in place.</li>
                    <li><strong>Incident Response Policy:</strong> Establish clear guidelines on what constitutes an "incident."</li>
                    <li><strong>Communication Protocol:</strong> Define communication channels and processes for reporting incidents.</li>
                </ul>
            </div>
        </div>

        <div id="identification">
            <h2 class="section-title">2. Identification</h2>
            <div class="section-content">
                <ul>
                    <li><strong>Incident Detection:</strong> Continuously monitor RFID-based gatepass logs, user access attempts, and system logs.</li>
                    <li><strong>Alert System:</strong> Implement an alerting system for unusual patterns or errors, such as repeated failed login attempts.</li>
                    <li><strong>Initial Assessment:</strong> Assess the situation to determine whether it is a real incident or a false alarm.</li>
                </ul>
            </div>
        </div>

        <div id="containment">
            <h2 class="section-title">3. Containment</h2>
            <div class="section-content">
                <ul>
                    <li><strong>Immediate Action:</strong> Isolate the affected part of the system to prevent further damage.</li>
                    <li><strong>Minimize Impact:</strong> Block compromised users, devices, or systems and disconnect affected RFID devices.</li>
                </ul>
            </div>
        </div>

        <div id="eradication">
            <h2 class="section-title">4. Eradication</h2>
            <div class="section-content">
                <ul>
                    <li><strong>Root Cause Analysis:</strong> Investigate the incident thoroughly to identify the root cause.</li>
                    <li><strong>Fix Vulnerabilities:</strong> Apply patches or fix configurations that allowed the incident to happen.</li>
                    <li><strong>Forensic Investigation:</strong> Document actions taken and preserve evidence for future audits.</li>
                </ul>
            </div>
        </div>

        <div id="recovery">
            <h2 class="section-title">5. Recovery</h2>
            <div class="section-content">
                <ul>
                    <li><strong>Restore Operations:</strong> Restore the system to normal operations, ensuring security settings are enhanced.</li>
                    <li><strong>Verify System Integrity:</strong> Run security scans and tests to ensure the system functions properly.</li>
                    <li><strong>Monitor:</strong> Increase monitoring of the system after recovery to ensure no further incidents occur.</li>
                </ul>
            </div>
        </div>

        <div id="lessons-learned">
            <h2 class="section-title">6. Lessons Learned</h2>
            <div class="section-content">
                <ul>
                    <li><strong>Post-Incident Review:</strong> Conduct a debriefing meeting to evaluate the incident and improve the system.</li>
                    <li><strong>Documentation:</strong> Update the Incident Response Plan based on lessons learned.</li>
                    <li><strong>Improve Defenses:</strong> Implement additional security controls to mitigate future risks.</li>
                </ul>
            </div>
        </div>

        <div id="disaster-recovery">
            <h2 class="section-title">7. Disaster Recovery Plan</h2>
            <div class="section-content">
                <ul>
                    <li><strong>Risk Assessment:</strong> Identify and prioritize key system components.</li>
                    <li><strong>Backup Strategy:</strong> Regularly back up critical data and systems.</li>
                    <li><strong>Recovery Strategy:</strong> Implement system failover and backup restoration strategies.</li>
                </ul>
            </div>
        </div>

        <div id="security-awareness">
            <h2 class="section-title">8. Security Awareness Training</h2>
            <div class="section-content">
                <ul>
                    <li><strong>RFID Security Best Practices:</strong> Educate users on safeguarding RFID cards and devices.</li>
                    <li><strong>Cybersecurity Awareness:</strong> Train staff on recognizing phishing attacks and social engineering.</li>
                    <li><strong>Incident Reporting:</strong> Teach staff how to report incidents promptly and follow escalation procedures.</li>
                    <li><strong>Simulation and Drills:</strong> Conduct regular training and simulated security breach scenarios.</li>
                </ul>
            </div>
        </div>

        <a href="#" id="backLink" class="back-link">Back to Home</a>
     </div>
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
