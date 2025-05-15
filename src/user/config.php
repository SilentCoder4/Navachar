<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the posted form data
    $username = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    // Simple validation (add more as needed)
    if ($username && $email && $password) {
        // Hash the password for security
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Create a new user entry
        $newUser = array(
            "username" => $username,
            "email" => $email,
            "password" => $hashedPassword
        );

        $file = 'users.json';

        // Load existing data
        if (file_exists($file)) {
            $json = file_get_contents($file);
            $data = json_decode($json, true);
        } else {
            $data = [];
        }

        // Append new user data
        $data[] = $newUser;

        // Save updated data
        file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT));

        echo '<script>alert("User saved successfully.")</script>';
    } else {
        echo '<script>alert("All fields are required.")</script>';
    }
} else {
    echo "Invalid request method.";
}
?>