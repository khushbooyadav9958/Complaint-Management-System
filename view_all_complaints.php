<?php

session_start();

include("../db.php");


// --------------------------------------------------
// ADMIN LOGIN CHECK
// --------------------------------------------------

if(!isset($_SESSION['admin']))
{
    header("Location: admin_login.php");
    exit();
}


// --------------------------------------------------
// ASSIGN COMPLAINT TO EMPLOYEE
// --------------------------------------------------

if(isset($_POST['assign']))
{
    $complaint_id = $_POST['complaint_id'];
    $employee_id = $_POST['employee_id'];


    // Get employee name

    $employee_query = mysqli_query(
        $conn,
        "SELECT name FROM employees WHERE id='$employee_id'"
    );


    if(mysqli_num_rows($employee_query) > 0)
    {
        $employee = mysqli_fetch_assoc($employee_query);

        $employee_name = $employee['name'];


        // Update complaint

        mysqli_query(
            $conn,
            "UPDATE complaints
             SET assigned_to='$employee_name'
             WHERE id='$complaint_id'"
        );


        echo "<script>
                alert('Complaint assigned successfully');
                window.location='view_all_complaints.php';
              </script>";

        exit();
    }
}


// --------------------------------------------------
// SEARCH AND FILTER
// --------------------------------------------------

$search = isset($_GET['search'])
    ? mysqli_real_escape_string($conn, $_GET['search'])
    : '';

$status = isset($_GET['status'])
    ? mysqli_real_escape_string($conn, $_GET['status'])
    : '';

$priority = isset($_GET['priority'])
    ? mysqli_real_escape_string($conn, $_GET['priority'])
    : '';

$category = isset($_GET['category'])
    ? mysqli_real_escape_string($conn, $_GET['category'])
    : '';


// --------------------------------------------------
// GET COMPLAINTS
// --------------------------------------------------

$sql = "SELECT * FROM complaints WHERE 1=1";


// Search

if($search != '')
{
    $sql .= " AND (
        complaint_no LIKE '%$search%'
        OR name LIKE '%$search%'
        OR email LIKE '%$search%'
        OR subject LIKE '%$search%'
    )";
}


// Status filter

if($status != '')
{
    $sql .= " AND status='$status'";
}


// Priority filter

if($priority != '')
{
    $sql .= " AND priority='$priority'";
}


// Category filter

if($category != '')
{
    $sql .= " AND category='$category'";
}


$sql .= " ORDER BY id DESC";


$result = mysqli_query($conn, $sql);


// --------------------------------------------------
// GET EMPLOYEES
// --------------------------------------------------

$employee_result = mysqli_query(
    $conn,
    "SELECT id, name FROM employees ORDER BY name ASC"
);


$employees = [];


while($employee = mysqli_fetch_assoc($employee_result))
{
    $employees[] = $employee;
}

?>

<!DOCTYPE html>

<html>

<head>

<title>View All Complaints</title>

<link rel="stylesheet" href="../css/style.css">


<style>

body
{
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 20px;
}


h2
{
    text-align: center;
    color: #333;
}


/* Search box */

.search-box
{
    background: white;
    padding: 20px;
    margin: 20px auto;
    width: 90%;
    text-align: center;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.15);
}


.search-box input,
.search-box select
{
    padding: 10px;
    margin: 5px;
    border: 1px solid #ccc;
    border-radius: 5px;
}


.search-box input[type="text"]
{
    width: 280px;
}


.search-btn
{
    padding: 10px 20px;
    background-color: #087cf5;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}


.clear-btn
{
    display: inline-block;
    padding: 10px 20px;
    background-color: #777;
    color: white;
    text-decoration: none;
    border-radius: 5px;
}


.search-btn:hover
{
    background-color: #005fc4;
}


.clear-btn:hover
{
    background-color: #555;
}


/* Table */

table
{
    width: 100%;
    border-collapse: collapse;
    background-color: white;
}


th
{
    background-color: #087cf5;
    color: white;
    padding: 12px;
}


td
{
    padding: 12px;
    border: 1px solid #ddd;
    text-align: center;
}


tr:hover
{
    background-color: #f5f5f5;
}


/* Assign box */

.assign-box
{
    padding: 10px;
}


.assign-box select
{
    padding: 10px;
    width: 180px;
}


.assign-btn
{
    margin-top: 10px;
    padding: 8px 18px;
    background-color: #087cf5;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}


.assign-btn:hover
{
    background-color: #005fc4;
}


/* Update button */

.update-btn
{
    display: inline-block;
    padding: 8px 15px;
    background-color: #28a745;
    color: white;
    text-decoration: none;
    border-radius: 5px;
}


.update-btn:hover
{
    background-color: #218838;
}


/* Back button */

.back-btn
{
    display: inline-block;
    margin-top: 20px;
    padding: 10px 20px;
    background-color: #333;
    color: white;
    text-decoration: none;
    border-radius: 5px;
}


.back-btn:hover
{
    background-color: #111;
}

</style>

</head>


<body>


<h2>All Complaints</h2>


<!-- ==========================================
     SEARCH AND FILTER FORM
=========================================== -->

<div class="search-box">

<form method="GET">


<input
    type="text"
    name="search"
    placeholder="Search Complaint / Name / Email / Subject"
    value="<?php echo htmlspecialchars($search); ?>"
>


<select name="status">

<option value="">All Status</option>

<option value="Pending"
<?php
if($status == "Pending")
{
    echo "selected";
}
?>
>
Pending
</option>


<option value="In Progress"
<?php
if($status == "In Progress")
{
    echo "selected";
}
?>
>
In Progress
</option>


<option value="Resolved"
<?php
if($status == "Resolved")
{
    echo "selected";
}
?>
>
Resolved
</option>

</select>


<select name="priority">

<option value="">All Priority</option>

<option value="Low"
<?php
if($priority == "Low")
{
    echo "selected";
}
?>
>
Low
</option>


<option value="Medium"
<?php
if($priority == "Medium")
{
    echo "selected";
}
?>
>
Medium
</option>


<option value="High"
<?php
if($priority == "High")
{
    echo "selected";
}
?>
>
High
</option>

</select>


<select name="category">

<option value="">All Category</option>

<option value="General"
<?php
if($category == "General")
{
    echo "selected";
}
?>
>
General
</option>


<option value="Technical"
<?php
if($category == "Technical")
{
    echo "selected";
}
?>
>
Technical
</option>

</select>


<input
    type="submit"
    value="Search"
    class="search-btn"
>


<a
    href="view_all_complaints.php"
    class="clear-btn"
>
Clear
</a>


</form>

</div>


<!-- ==========================================
     COMPLAINT TABLE
=========================================== -->

<table>

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

<th>Assign Employee</th>

<th>Action</th>

</tr>


<?php

if(mysqli_num_rows($result) > 0)
{

    while($row = mysqli_fetch_assoc($result))
    {

?>


<tr>


<!-- Complaint Number -->

<td>

<?php

echo htmlspecialchars($row['complaint_no']);

?>

</td>


<!-- Name -->

<td>

<?php

echo htmlspecialchars($row['name']);

?>

</td>


<!-- Email -->

<td>

<?php

echo htmlspecialchars($row['email']);

?>

</td>


<!-- Subject -->

<td>

<?php

echo htmlspecialchars($row['subject']);

?>

</td>


<!-- Category -->

<td>

<?php

echo htmlspecialchars($row['category']);

?>

</td>


<!-- Priority -->

<td>

<?php

echo htmlspecialchars($row['priority']);

?>

</td>


<!-- Assigned To -->

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


<!-- Status -->

<td>

<?php

echo htmlspecialchars($row['status']);

?>

</td>


<!-- Admin Remarks -->

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


<!-- Date -->

<td>

<?php

echo htmlspecialchars($row['created_at']);

?>

</td>


<!-- Assign Employee -->

<td>

<div class="assign-box">


<form method="POST">


<input
    type="hidden"
    name="complaint_id"
    value="<?php echo $row['id']; ?>"
>


<select name="employee_id" required>


<option value="">
Select Employee
</option>


<?php

foreach($employees as $employee)
{

?>


<option
    value="<?php echo $employee['id']; ?>"
    <?php

    if(
        !empty($row['assigned_to'])
        &&
        $row['assigned_to'] == $employee['name']
    )
    {
        echo "selected";
    }

    ?>
>

<?php

echo htmlspecialchars($employee['name']);

?>

</option>


<?php

}

?>


</select>


<br>


<input
    type="submit"
    name="assign"
    value="Assign"
    class="assign-btn"
>


</form>


</div>

</td>


<!-- Update Status -->

<td>

<a
    href="update_status.php?id=<?php echo $row['id']; ?>"
    class="update-btn"
>
Update Status
</a>

</td>


</tr>


<?php

    }

}
else
{

?>


<tr>

<td colspan="12">

No complaints found.

</td>

</tr>


<?php

}

?>


</table>


<br>


<center>

<a
    href="admin_dashboard.php"
    class="back-btn"
>
Back to Dashboard
</a>

</center>


</body>

</html>