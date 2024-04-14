<?php
// Check for error parameter in the URL
if (isset($_GET['error'])) {
    $error_message = $_GET['error'];
    echo '<p class="error-message">' . htmlspecialchars($error_message) . '</p>';
}
?>