<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = trim($_POST["name"]);
  $message = trim($_POST["message"]);

  if (!empty($name) && !empty($message)) {
    $entry = htmlspecialchars($name) . "||" . htmlspecialchars($message) . "\n";
    file_put_contents("messages.txt", $entry, FILE_APPEND);
    
  } else {
    echo "Please enter both name and message.";
  }
}
?>
