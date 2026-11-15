<?php

session_start();
include("db.php");

// Check employee login
if (!isset($_SESSION['employee_id'])) {
    header("Location: employee_login.php");
    exit();
}

$employee_id = $_SESSION['employee_id'];
$employee_name = $_SESSION['employee_name'];

// Get complaints assigned to this employee
$sql = "SELECT * FROM complaints
        WHERE assigned_to = '$employee_name'
        ORDER BY id DESC";

$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html>

<head>

    <title>Employee Dashboard</title>

    <link rel="stylesheet" href="css/style.css">

</head>

<body>

<h1>Employee Dashboard</h1>

<h2>
    Welcome, <?php echo htmlspecialchars($employee_name); ?> 👋
</h2>

<hr>

<h2>My Assigned Complaints</h2>

<table border="1" cellpadding="10" cellspacing="0">

    <tr>

        <th>Complaint No</th>
        <th>Name</th>
        <th>Subject</th>
        <th>Category</th>
        <th>Priority</th>
        <th>Status</th>
        <th>Date</th>
        <th>Action</th>

    </tr>

<?php

if (mysqli_num_rows($result) > 0) {

    while ($row = mysqli_fetch_assoc($result)) {

?>

    <tr>

        <td>
            <?php echo htmlspecialchars($row['complaint_no']); ?>
        </td>

        <td>
            <?php echo htmlspecialchars($row['name']); ?>
        </td>

        <td>
            <?php echo htmlspecialchars($row['subject']); ?>
        </td>

        <td>
            <?php echo htmlspecialchars($row['category']); ?>
        </td>

        <td>
            <?php echo htmlspecialchars($row['priority']); ?>
        </td>

        <td>
            <?php echo htmlspecialchars($row['status']); ?>
        </td>

        <td>
            <?php echo htmlspecialchars($row['created_at']); ?>
        </td>

        <td>

            <a href="employee_update_status.php?id=<?php echo $row['id']; ?>">
                Update Status
            </a>

        </td>

    </tr>

<?php

    }

} else {

?>

    <tr>

        <td colspan="8" align="center">

            No complaints assigned to you.

        </td>

    </tr>

<?php

}

?>

</table>

<br><br>

<a href="employee_logout.php">

    <button class="btn">
        Logout
    </button>

</a>

</body>

</html>