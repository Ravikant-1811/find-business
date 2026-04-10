<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Location Test</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; max-width: 800px; margin: 0 auto; }
        .success { color: green; font-weight: bold; }
        .error { color: red; font-weight: bold; }
        .box { background: #f5f5f5; padding: 15px; border-radius: 8px; margin: 15px 0; }
        button { background: #f97316; color: white; border: none; padding: 12px 24px; border-radius: 8px; cursor: pointer; font-size: 16px; margin: 5px; }
        button:hover { background: #ea580c; }
        #result { margin-top: 20px; padding: 15px; border: 2px solid #ddd; border-radius: 8px; min-height: 150px; background: #fff; }
        pre { background: #1e1e1e; color: #0f0; padding: 15px; border-radius: 8px; overflow-x: auto; font-size: 13px; }
        h1 { color: #f97316; }
    </style>
</head>
<body>

<h1>🔍 Location API Test</h1>

<div class="box">
    <h3>✅ System Status</h3>
    <p>PHP: <?php echo phpversion(); ?> | 
       Session: <?php echo session_status() === PHP_SESSION_ACTIVE ? 'OK' : 'ERROR'; ?> | 
       cURL: <?php echo function_exists('curl_init') ? 'OK' : 'Missing'; ?></p>
    <p>
        key.php: <?php echo file_exists(__DIR__ . '/key.php') ? '✅' : '❌'; ?> |
        update-location.php: <?php echo file_exists(__DIR__ . '/update-location.php') ? '✅' : '❌'; ?>
    </p>
</div>

<div class="box">
    <h3>📍 Current Session</h3>
    <?php if (isset($_SESSION['user_location'])): ?>
        <p><strong>City:</strong> <?php echo htmlspecialchars($_SESSION['user_location']['city'] ?? 'Not set'); ?></p>
        <p><strong>State:</strong> <?php echo htmlspecialchars($_SESSION['user_location']['state'] ?? 'Not set'); ?></p>
        <p><strong>Coords:</strong> <?php echo ($_SESSION['user_location']['lat'] ?? 0) . ', ' . ($_SESSION['user_location']['lng'] ?? 0); ?></p>
    <?php else: ?>
        <p class="error">No location in session</p>
    <?php endif; ?>
</div>

<div class="box">
    <h3>🧪 Test Buttons</h3>
    <button onclick="testWithFetch()">1️⃣ Test Fetch POST</button>
    <button onclick="testWithXHR()">2️⃣ Test XMLHttpRequest</button>
    <button onclick="testWithGET()">3️⃣ Test GET Method</button>
    <button onclick="testBrowserGPS()">🎯 Test Your GPS Location</button>
    <br><br>
    <button onclick="clearSession()" style="background:#666;">🗑️ Clear Session</button>
</div>

<div id="result">
    <p style="color:#999;">👆 Click a test button above...</p>
</div>

<?php if (isset($_GET['clear'])): unset($_SESSION['user_location']); ?>
<script>window.location.href = 'test-location.php';</script>
<?php endif; ?>

<script>
var resultDiv = document.getElementById('result');

function log(msg, type) {
    var color = type === 'error' ? 'red' : type === 'success' ? 'green' : '#333';
    resultDiv.innerHTML += '<p style="color:' + color + '">' + msg + '</p>';
}

function clearLog() {
    resultDiv.innerHTML = '';
}

// Test 1: Fetch POST
function testWithFetch() {
    clearLog();
    log('⏳ Testing with Fetch POST...');
    
    var data = {lat: 20.3867, lng: 72.9058}; // Vapi coordinates
    
    fetch('update-location.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        },
        body: JSON.stringify(data),
        credentials: 'same-origin'
    })
    .then(r => r.text())
    .then(text => {
        log('📄 Response: <pre>' + text + '</pre>');
        handleResponse(text);
    })
    .catch(err => {
        log('❌ Fetch Error: ' + err.message, 'error');
    });
}

// Test 2: XMLHttpRequest
function testWithXHR() {
    clearLog();
    log('⏳ Testing with XMLHttpRequest...');
    
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'update-location.php', true);
    xhr.setRequestHeader('Content-Type', 'application/json');
    
    xhr.onload = function() {
        log('📡 Status: ' + xhr.status);
        log('📄 Response: <pre>' + xhr.responseText + '</pre>');
        handleResponse(xhr.responseText);
    };
    
    xhr.onerror = function() {
        log('❌ XHR Network Error', 'error');
    };
    
    xhr.send(JSON.stringify({lat: 20.3867, lng: 72.9058}));
}

// Test 3: GET Method (Fallback)
function testWithGET() {
    clearLog();
    log('⏳ Testing with GET method...');
    
    var url = 'update-location.php?lat=20.3867&lng=72.9058';
    
    fetch(url)
    .then(r => r.text())
    .then(text => {
        log('📄 Response: <pre>' + text + '</pre>');
        handleResponse(text);
    })
    .catch(err => {
        log('❌ Error: ' + err.message, 'error');
    });
}

// Test Browser GPS
function testBrowserGPS() {
    clearLog();
    
    if (!navigator.geolocation) {
        log('❌ Geolocation not supported', 'error');
        return;
    }
    
    log('⏳ Getting GPS location...');
    
    navigator.geolocation.getCurrentPosition(
        function(pos) {
            var lat = pos.coords.latitude;
            var lng = pos.coords.longitude;
            log('✅ Got GPS: ' + lat.toFixed(4) + ', ' + lng.toFixed(4), 'success');
            
            // Try GET method (most reliable)
            var url = 'update-location.php?lat=' + lat + '&lng=' + lng;
            log('⏳ Sending to server...');
            
            fetch(url)
            .then(r => r.text())
            .then(text => {
                log('📄 Response: <pre>' + text + '</pre>');
                handleResponse(text);
            })
            .catch(err => {
                log('❌ Error: ' + err.message, 'error');
            });
        },
        function(err) {
            var msg = ['Unknown', 'Permission denied', 'Position unavailable', 'Timeout'][err.code] || 'Error';
            log('❌ GPS Error: ' + msg, 'error');
        },
        {enableHighAccuracy: true, timeout: 10000}
    );
}

function handleResponse(text) {
    try {
        var json = JSON.parse(text);
        if (json.success) {
            log('✅ SUCCESS! City: ' + json.city + ', ' + json.state, 'success');
            log('🔄 Reloading in 2 seconds...');
            setTimeout(function() { location.reload(); }, 2000);
        } else {
            log('❌ Failed: ' + (json.error || 'Unknown'), 'error');
        }
    } catch(e) {
        log('❌ Parse Error: ' + e.message, 'error');
    }
}

function clearSession() {
    window.location.href = 'test-location.php?clear=1';
}
</script>

</body>
</html>