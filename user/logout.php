<?php 
session_start();          // ✅ REQUIRED
session_destroy();        // ✅ Ends the session
header("Location: ../index.php"); // ✅ Redirect to homepage
exit();                  // ✅ Best practice after header
?>