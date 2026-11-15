<?php

session_start();
include("../db.php");

// Check admin login
if(!isset($_SESSION['admin']))
{
    header("Location: admin_login.php");
    exit();
}


// Get all complaints
$sql = "SELECT
        complaint_no,
        name,
        email,
        subject,
        category,
        priority,
        assigned_to,
        status,
        admin_remarks,
        created_at
        FROM complaints
        ORDER BY id DESC";

$result = mysqli_query($conn, $sql);


// Excel file name
$filename = "complaints_report_" . date("Y-m-d") . ".xls";


// Excel headers
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=\"$filename\"");
header("Pragma: no-cache");
header("Expires: 0");

?>

<table border="1">

<tr>

<th>Complaint No</th>
<th>Name</th>
<th>Email</th>
<th>Subject</th>
<th>Category</th>
<th>Priority</th>
<th>Assigned To</th>
<th>Status</th>
<th>Admin Remarks</th>
<th>Date</th>

</tr>


<?php

while($row = mysqli_fetch_assoc($result))
{

?>

<tr>

<td>
<?php echo htmlspecialchars($row['complaint_no']); ?>
</td>

<td>
<?php echo htmlspecialchars($row['name']); ?>
</td>

<td>
<?php echo htmlspecialchars($row['email']); ?>
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
<?php

if(!empty($row['assigned_to']))
{
    echo htmlspecialchars($row['assigned_to']);
}
else
{
    echo "Not Assigned";
}

?>
</td>

<td>
<?php echo htmlspecialchars($row['status']); ?>
</td>

<td>
<?php

if(!empty($row['admin_remarks']))
{
    echo htmlspecialchars($row['admin_remarks']);
}
else
{
    echo "No Remarks";
}

?>
</td>

<td>
<?php echo htmlspecialchars($row['created_at']); ?>
</td>

</tr>

<?php

}

?>

</table>