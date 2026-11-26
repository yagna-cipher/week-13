<?php
include "db.php";

$result = mysqli_query($conn, "SELECT * FROM students");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Registered Students</title>
</head>
<body>

<h2>Registered Students</h2>

<table border="1" cellpadding="10">

    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Course</th>
        <th>Image</th>
    </tr>

    <?php while($row = mysqli_fetch_assoc($result)) { ?>

    <tr>

        <td><?php echo $row['id']; ?></td>

        <td>
            <?php echo htmlspecialchars($row['name']); ?>
        </td>

        <td>
            <?php echo htmlspecialchars($row['email']); ?>
        </td>

        <td>
            <?php echo htmlspecialchars($row['phone']); ?>
        </td>

        <td>
            <?php echo htmlspecialchars($row['course']); ?>
        </td>

        <td>
            <img src="uploads/<?php
                echo htmlspecialchars($row['image']);
            ?>" width="100">
        </td>

    </tr>

    <?php } ?>

</table>

<br>

<a href="registration.php">Back to Registration</a>

</body>
</html>
