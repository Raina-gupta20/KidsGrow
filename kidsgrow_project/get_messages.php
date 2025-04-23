<?php
$filename = "messages.txt";

if (file_exists($filename)) {
  $lines = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
  foreach (array_reverse($lines) as $line) {
    if (strpos($line, "||") !== false) {
      list($name, $msg) = explode("||", $line);
      echo "<div class='message-card'>";
      echo "<h4>" . htmlspecialchars($name) . "</h4>";
      echo "<p>" . htmlspecialchars($msg) . "</p>";
      echo "</div>";
    }
  }
} else {
  echo "<p>No messages yet. Be the first to leave one!</p>";
}
?>
