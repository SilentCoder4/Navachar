<?php
header('Content-Type: application/json');

$host = "localhost";
$user = "root";
$password = "";
$dbname = "navachar";

$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "DB connection failed."]));
}

$data = json_decode(file_get_contents("php://input"), true);
$event_id = intval($data['event_id']);
$full_name = $conn->real_escape_string($data['name']);
$email = $conn->real_escape_string($data['email']);
$phone = isset($data['phone']) ? $conn->real_escape_string($data['phone']) : null;

// Check for duplicate
$check = $conn->query("SELECT id FROM event_registrations WHERE event_id = $event_id AND email = '$email'");
if ($check->num_rows > 0) {
    echo json_encode(["status" => "duplicate", "message" => "You already registered for this event."]);
    exit;
}

// Insert new
$sql = "INSERT INTO event_registrations (event_id, full_name, email, phone) 
        VALUES ($event_id, '$full_name', '$email', '$phone')";

if ($conn->query($sql)) {
    echo json_encode(["status" => "success", "message" => "Registered successfully."]);
} else {
    echo json_encode(["status" => "error", "message" => "Registration failed."]);
}

$conn->close();
?>
