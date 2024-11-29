
<form method="POST" action="session.php">
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password" required>

    <label>Choose verification method:</label><br>
    <input type="radio" name="verification_method" value="email" required> Email<br>
    <input type="radio" name="verification_method" value="contact" required> Contact Number<br>

    <img src="captcha.php" alt="CAPTCHA">
    <input type="text" name="captcha" placeholder="Enter CAPTCHA" required>
    <button type="submit">Login</button>
</form>
