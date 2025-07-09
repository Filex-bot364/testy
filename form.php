<?php
// Database connection
$servername = "localhost"; // Your MySQL host
$username = "root";        // Your MySQL username
$password = "";            // Your MySQL password
$dbname = "forms";         // Database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Form submission handling
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize form data
    $full_name = $_POST['full_name'];
    $whatsapp_number = $_POST['whatsapp_number'];
    $email = $_POST['email'];
    $message = $_POST['message'];
    $start_date = isset($_POST['start_date']) ? $_POST['start_date'] : null;
    $end_date = isset($_POST['end_date']) ? $_POST['end_date'] : null;

    // Check if start_date and end_date are provided, if not set them to a default value (could be today's date or a specific fallback)
    if ($start_date == null || $end_date == null) {
        echo "<script>alert('Please provide both start date and end date.');</script>";
    } else {
        // Prepare and bind
        $stmt = $conn->prepare("INSERT INTO formssb (full_name, whatsapp_number, email, message, start_date, end_date) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $full_name, $whatsapp_number, $email, $message, $start_date, $end_date);

        if ($stmt->execute()) {
            echo "<script>alert('Form submitted successfully');</script>";
        } else {
            echo "<script>alert('Error: " . $stmt->error . "');</script>";
        }

        $stmt->close();
        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Form</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f7f7f7;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .form-container {
            background-color: #fff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 600px;
            transition: transform 0.3s ease, opacity 0.3s ease;
        }
        .form-container h2 {
            text-align: center;
            color: #333;
            font-size: 28px;
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            font-weight: 600;
            color: #555;
            margin-bottom: 8px;
            display: block;
        }
        .form-group input, .form-group textarea, .form-group select {
            width: 100%;
            padding: 12px;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 16px;
            color: #333;
            transition: border 0.3s ease;
        }
        .form-group input:focus, .form-group textarea:focus, .form-group select:focus {
            border-color: #5cb85c;
            outline: none;
        }
        .form-group textarea {
            min-height: 150px;
            resize: vertical;
        }
        .form-group input::placeholder, .form-group textarea::placeholder {
            color: #888;
        }
        .submit-btn {
            width: 100%;
            padding: 14px;
            background-color: #5cb85c;
            border: none;
            color: white;
            font-size: 18px;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .submit-btn:hover {
            background-color: #4cae4c;
        }
        .form-container .form-group:last-child {
            margin-bottom: 0;
        }
        .form-container input, .form-container textarea {
            font-family: inherit;
        }
    </style>
</head>
<body>

    <div class="form-container">
        <h2>Contact Us</h2>
        <form method="POST" action="form.php">
            <div class="form-group">
                <label for="full_name">Full Name:</label>
                <input type="text" id="full_name" name="full_name" required placeholder="Your full name">
            </div>
            <div class="form-group">
                <label for="whatsapp_number">WhatsApp Number:</label>
                <input type="text" id="whatsapp_number" name="whatsapp_number" required placeholder="Your WhatsApp number">
            </div>
            <div class="form-group">
                <label for="email">Email Address:</label>
                <input type="email" id="email" name="email" required placeholder="Your email address">
            </div>
            <div class="form-group">
                <label for="message">Message:</label>
                <textarea id="message" name="message" required placeholder="Your message..."></textarea>
            </div>
            <div class="form-group">
                <label for="start_date">Start Date:</label>
                <input type="date" id="start_date" name="start_date" required>
            </div>
            <div class="form-group">
                <label for="end_date">End Date:</label>
                <input type="date" id="end_date" name="end_date" required>
            </div>
            <button type="submit" class="submit-btn">Submit</button>
        </form>
    </div>

</body>
</html>
