<?php
session_start(); // Session shuru karein
session_unset(); // Saare session variables ko khali karein
session_destroy(); // Session ko puri tarah khatam karein

// Logout ke baad user ko sidha Home Page (index.php) par bhej dein
header("location:index.php");
exit();
?>
