<?php
include "db.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $phone = trim($_POST["phone"]);
    $course = trim($_POST["course"]);

    // Image upload
    $imageName = "";

    if (isset($_FILES["image"]) &&
        $_FILES["image"]["error"] == 0) {

        $tmpName = $_FILES["image"]["tmp_name"];
        $fileSize = $_FILES["image"]["size"];

        // Validate image
        $imageInfo = getimagesize($tmpName);

        if ($imageInfo !== false && $fileSize <= 2*1024*1024) {

            $extension = image_type_to_extension(
                $imageInfo[2], false
            );

            $allowed = ["jpg", "jpeg", "png", "gif"];

            if (in_array($extension, $allowed)) {

                $imageName = uniqid("img_", true)
                             . "." . $extension;

                $uploadPath = "uploads/" . $imageName;

                if (!move_uploaded_file(
                    $tmpName, $uploadPath
                )) {
                    die("Image upload failed.");
                }

            } else {
                die("Invalid image format.");
            }

        } else {
            die("Invalid image or image exceeds 2MB.");
        }

    } else {
        die("Please select an image.");
    }

    // Insert data into MySQL
    $stmt = mysqli_prepare(
        $conn,
        "INSERT INTO students
        (name, email, phone, course, image)
        VALUES (?, ?, ?, ?, ?)"
    );

    mysqli_stmt_bind_param(
        $stmt,
        "sssss",
        $name,
        $email,
        $phone,
        $course,
        $imageName
    );

    if (mysqli_stmt_execute($stmt)) {

        $message = "Registration successful!";

    } else {

        $message = "Registration failed.";

    }

    mysqli_stmt_close($stmt);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Registration</title>
</head>
<body>

<h2>Student Registration Form</h2>

<p><?php echo htmlspecialchars($message); ?></p>

<form method="POST" enctype="multipart/form-data">

    Name:
    <input type="text" name="name" required>
    <br><br>

    Email:
    <input type="email" name="email" required>
    <br><br>

    Phone:
    <input type="text" name="phone">
    <br><br>

    Course:
    <select name="course" required>
        <option value="">Select Course</option>
        <option value="BCA">BCA</option>
        <option value="MCA">MCA</option>
        <option value="B.Tech">B.Tech</option>
    </select>
    <br><br>

    Upload Photo:
    <input type="file" name="image"
           accept="image/*" required>
    <br><br>

    <input type="submit" value="Register">

</form>

<br>

<a href="students.php">View Registered Students</a>

</body>
</html>
