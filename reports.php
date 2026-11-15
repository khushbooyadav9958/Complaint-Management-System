<?php

session_start();
include("../db.php");

// Check admin login
if(!isset($_SESSION['admin']))
{
    header("Location: admin_login.php");
    exit();
}


// --------------------------------------------------
// TOTAL COMPLAINTS
// --------------------------------------------------

$total_query = mysqli_query(
    $conn,
    "SELECT COUNT(*) AS total FROM complaints"
);

$total = mysqli_fetch_assoc($total_query)['total'];


// --------------------------------------------------
// PENDING
// --------------------------------------------------

$pending_query = mysqli_query(
    $conn,
    "SELECT COUNT(*) AS total
     FROM complaints
     WHERE status='Pending'"
);

$pending = mysqli_fetch_assoc($pending_query)['total'];


// --------------------------------------------------
// IN PROGRESS
// --------------------------------------------------

$progress_query = mysqli_query(
    $conn,
    "SELECT COUNT(*) AS total
     FROM complaints
     WHERE status='In Progress'"
);

$progress = mysqli_fetch_assoc($progress_query)['total'];


// --------------------------------------------------
// RESOLVED
// --------------------------------------------------

$resolved_query = mysqli_query(
    $conn,
    "SELECT COUNT(*) AS total
     FROM complaints
     WHERE status='Resolved'"
);

$resolved = mysqli_fetch_assoc($resolved_query)['total'];


// --------------------------------------------------
// CATEGORY DATA
// --------------------------------------------------

$category_query = mysqli_query(
    $conn,
    "SELECT category, COUNT(*) AS total
     FROM complaints
     GROUP BY category
     ORDER BY total DESC"
);

$category_names = [];
$category_counts = [];

while($row = mysqli_fetch_assoc($category_query))
{
    $category_names[] = $row['category'];
    $category_counts[] = $row['total'];
}


// --------------------------------------------------
// PRIORITY DATA
// --------------------------------------------------

$priority_query = mysqli_query(
    $conn,
    "SELECT priority, COUNT(*) AS total
     FROM complaints
     GROUP BY priority
     ORDER BY total DESC"
);

$priority_names = [];
$priority_counts = [];

while($row = mysqli_fetch_assoc($priority_query))
{
    $priority_names[] = $row['priority'];
    $priority_counts[] = $row['total'];
}

?>

<!DOCTYPE html>

<html>

<head>

<title>Complaint Reports</title>

<link rel="stylesheet" href="../css/style.css">

<!-- Chart.js -->

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


<style>

body
{
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    padding: 20px;
}

h1
{
    text-align: center;
    color: #333;
}


/* ----------------------------------
   EXPORT BUTTONS
----------------------------------- */

.export-buttons
{
    text-align: center;
    margin: 25px;
}


.export-buttons a
{
    display: inline-block;
    padding: 12px 25px;
    margin: 5px;

    color: white;
    text-decoration: none;

    border-radius: 5px;

    font-size: 16px;
}


.excel-btn
{
    background-color: #087cf5;
}


.pdf-btn
{
    background-color: #d9534f;
}


.excel-btn:hover
{
    opacity: 0.85;
}


.pdf-btn:hover
{
    opacity: 0.85;
}


/* ----------------------------------
   STATISTICS CARDS
----------------------------------- */

.dashboard
{
    display: flex;
    justify-content: center;
    gap: 20px;
    flex-wrap: wrap;
    margin: 30px 0;
}


.card
{
    background: white;

    width: 200px;

    padding: 25px;

    text-align: center;

    border-radius: 10px;

    box-shadow:
    0 2px 8px rgba(0,0,0,0.15);
}


.card h2
{
    font-size: 35px;

    margin: 10px;
}


.card p
{
    font-size: 18px;
}


/* ----------------------------------
   CHARTS
----------------------------------- */

.charts
{
    display: flex;

    justify-content: center;

    gap: 30px;

    flex-wrap: wrap;

    margin-top: 30px;
}


.chart-box
{
    background: white;

    width: 450px;

    padding: 20px;

    border-radius: 10px;

    box-shadow:
    0 2px 8px rgba(0,0,0,0.15);
}


.chart-box h2
{
    text-align: center;
}


.chart-container
{
    position: relative;

    height: 350px;
}


/* ----------------------------------
   TABLES
----------------------------------- */

.section
{
    background: white;

    width: 80%;

    margin: 30px auto;

    padding: 20px;

    border-radius: 10px;
}


table
{
    width: 100%;

    border-collapse: collapse;
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


/* ----------------------------------
   BACK BUTTON
----------------------------------- */

.back
{
    text-align: center;

    margin-top: 30px;
}


.back a
{
    background-color: #333;

    color: white;

    padding: 10px 20px;

    text-decoration: none;

    border-radius: 5px;
}

</style>

</head>


<body>


<h1>Complaint Reports & Statistics</h1>


<!-- ==========================================
     EXPORT BUTTONS
=========================================== -->

<div class="export-buttons">


<a
    href="export_excel.php"
    class="excel-btn"
>

📥 Export to Excel

</a>


<a
    href="export_pdf.php"
    class="pdf-btn"
>

📄 Export to PDF

</a>


</div>


<!-- ==========================================
     STATISTICS CARDS
=========================================== -->

<div class="dashboard">


<div class="card">

<h2>

<?php echo $total; ?>

</h2>

<p>Total Complaints</p>

</div>


<div class="card">

<h2>

<?php echo $pending; ?>

</h2>

<p>Pending</p>

</div>


<div class="card">

<h2>

<?php echo $progress; ?>

</h2>

<p>In Progress</p>

</div>


<div class="card">

<h2>

<?php echo $resolved; ?>

</h2>

<p>Resolved</p>

</div>


</div>


<!-- ==========================================
     CHARTS
=========================================== -->

<div class="charts">


<!-- STATUS CHART -->

<div class="chart-box">

<h2>Status Statistics</h2>

<div class="chart-container">

<canvas id="statusChart"></canvas>

</div>

</div>


<!-- CATEGORY CHART -->

<div class="chart-box">

<h2>Category Statistics</h2>

<div class="chart-container">

<canvas id="categoryChart"></canvas>

</div>

</div>


<!-- PRIORITY CHART -->

<div class="chart-box">

<h2>Priority Statistics</h2>

<div class="chart-container">

<canvas id="priorityChart"></canvas>

</div>

</div>


</div>


<!-- ==========================================
     CATEGORY TABLE
=========================================== -->

<div class="section">

<h2>Category-wise Complaints</h2>


<table>

<tr>

<th>Category</th>

<th>Total Complaints</th>

</tr>


<?php

$category_table = mysqli_query(
    $conn,
    "SELECT category, COUNT(*) AS total
     FROM complaints
     GROUP BY category
     ORDER BY total DESC"
);


if(mysqli_num_rows($category_table) > 0)
{

    while($row = mysqli_fetch_assoc($category_table))
    {

?>

<tr>

<td>

<?php

echo htmlspecialchars($row['category']);

?>

</td>


<td>

<?php

echo $row['total'];

?>

</td>

</tr>

<?php

    }

}
else
{

?>

<tr>

<td colspan="2">

No category data available.

</td>

</tr>

<?php

}

?>

</table>

</div>


<!-- ==========================================
     PRIORITY TABLE
=========================================== -->

<div class="section">

<h2>Priority-wise Complaints</h2>


<table>

<tr>

<th>Priority</th>

<th>Total Complaints</th>

</tr>


<?php

$priority_table = mysqli_query(
    $conn,
    "SELECT priority, COUNT(*) AS total
     FROM complaints
     GROUP BY priority
     ORDER BY total DESC"
);


if(mysqli_num_rows($priority_table) > 0)
{

    while($row = mysqli_fetch_assoc($priority_table))
    {

?>

<tr>

<td>

<?php

echo htmlspecialchars($row['priority']);

?>

</td>


<td>

<?php

echo $row['total'];

?>

</td>

</tr>

<?php

    }

}
else
{

?>

<tr>

<td colspan="2">

No priority data available.

</td>

</tr>

<?php

}

?>

</table>

</div>


<!-- ==========================================
     BACK TO DASHBOARD
=========================================== -->

<div class="back">

<a href="admin_dashboard.php">

Back to Dashboard

</a>

</div>


<!-- ==========================================
     CHART JAVASCRIPT
=========================================== -->

<script>


// --------------------------------------------
// STATUS CHART
// --------------------------------------------

const statusChart =
document.getElementById('statusChart');


new Chart(
    statusChart,
    {
        type: 'doughnut',

        data:
        {
            labels:
            [
                'Pending',
                'In Progress',
                'Resolved'
            ],

            datasets:
            [
                {
                    label: 'Complaints',

                    data:
                    [
                        <?php echo $pending; ?>,
                        <?php echo $progress; ?>,
                        <?php echo $resolved; ?>
                    ]
                }
            ]
        },

        options:
        {
            responsive: true,

            maintainAspectRatio: false
        }
    }
);


// --------------------------------------------
// CATEGORY CHART
// --------------------------------------------

const categoryChart =
document.getElementById('categoryChart');


new Chart(
    categoryChart,
    {
        type: 'bar',

        data:
        {
            labels:

            <?php

            echo json_encode($category_names);

            ?>,

            datasets:
            [
                {
                    label: 'Complaints',

                    data:

                    <?php

                    echo json_encode($category_counts);

                    ?>

                }
            ]
        },

        options:
        {
            responsive: true,

            maintainAspectRatio: false,

            scales:
            {
                y:
                {
                    beginAtZero: true,

                    ticks:
                    {
                        stepSize: 1
                    }
                }
            }
        }
    }
);


// --------------------------------------------
// PRIORITY CHART
// --------------------------------------------

const priorityChart =
document.getElementById('priorityChart');


new Chart(
    priorityChart,
    {
        type: 'pie',

        data:
        {
            labels:

            <?php

            echo json_encode($priority_names);

            ?>,

            datasets:
            [
                {
                    label: 'Complaints',

                    data:

                    <?php

                    echo json_encode($priority_counts);

                    ?>

                }
            ]
        },

        options:
        {
            responsive: true,

            maintainAspectRatio: false
        }
    }
);

</script>


</body>

</html>