<?php
function getLocation() {
    $ip = $_SERVER['REMOTE_ADDR']; // Get the user's IP address
    $url = "http://ip-api.com/json/{$ip}";

    $response = file_get_contents($url);
    $data = json_decode($response, true);

    if ($data && $data['status'] === 'success') {
        return $data['city'] . ', ' . $data['regionName'] . ', ' . $data['country'];
    }

    return 'Location not available';
}

function getDevice() {
    $userAgent = $_SERVER['HTTP_USER_AGENT'];

    // Detect the operating system
    if (preg_match('/linux/i', $userAgent)) {
        $os = 'Linux';
    } elseif (preg_match('/macintosh|mac os x/i', $userAgent)) {
        $os = 'Mac';
    } elseif (preg_match('/windows|win32/i', $userAgent)) {
        $os = 'Windows';
    } else {
        $os = 'Unknown OS';
    }

    // Detect the browser
    if (preg_match('/MSIE/i', $userAgent) && !preg_match('/Opera/i', $userAgent)) {
        $browser = 'Internet Explorer';
    } elseif (preg_match('/Firefox/i', $userAgent)) {
        $browser = 'Firefox';
    } elseif (preg_match('/Chrome/i', $userAgent)) {
        $browser = 'Chrome';
    } elseif (preg_match('/Safari/i', $userAgent)) {
        $browser = 'Safari';
    } elseif (preg_match('/Opera/i', $userAgent)) {
        $browser = 'Opera';
    } else {
        $browser = 'Unknown Browser';
    }

    return $os . ' - ' . $browser;
}

// Get location and device
$location = getLocation();
$device = getDevice();

echo "Location: " . $location . "<br>";
echo "Device: " . $device;
?>
