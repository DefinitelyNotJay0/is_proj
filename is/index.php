<?php
session_start();

// Database connection
$host = 'localhost';
$db = 'login';
$user = 'root';
$pass = '';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the user is already logged in
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    $show_dashboard = true;
} else {
    $show_dashboard = false;
}

// Handle login form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query to validate the user
    $stmt = $conn->prepare("SELECT * FROM admin WHERE firstName = ? AND password = ?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    // Debugging: Check if the query returns any rows
    if ($result->num_rows === 1) {
        $_SESSION['logged_in'] = true;
        $_SESSION['username'] = $username;
        header('Location: index.php'); // Refresh the page to show the dashboard
        exit;
    } else {
        $error_message = "Invalid username or password.";
        // Debugging: Log the entered username and password
        error_log("Login failed for username: $username and password: $password");
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>Admin Dashboard</title>

    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">

    <link rel="stylesheet" href="css/styles.css">
  </head>
  <body>
    <?php if (!$show_dashboard): ?>
        <!-- Login Form -->
        <div class="login-container">
            <h2>Login</h2>
            <?php if (isset($error_message)): ?>
                <p style="color: red;"><?php echo $error_message; ?></p>
            <?php endif; ?>
            <form method="POST" action="">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
                <button type="submit">Login</button>
            </form>
        </div>
    <?php else: ?>
        <!-- Dashboard -->
        <div class="grid-container">
            <!-- Header -->
            <header class="header">
                <div class="menu-icon" onclick="openSidebar()">
                    <span class="material-icons-outlined">menu</span>
                </div>
            </header>
            <!-- End Header -->

            <!-- Sidebar -->
            <aside id="sidebar">
                <div class="sidebar-title">
                    <div class="sidebar-brand">
                        <span class="material-icons-outlined">shopping_cart</span> NewGenCycling
                    </div>
                    <span class="material-icons-outlined" onclick="closeSidebar()">close</span>
                </div>

                <ul class="sidebar-list">
                    <li class="sidebar-list-item">
                        <a href="index.php" onclick="closeCurrentPage()"> 
                            <span class="material-icons-outlined">dashboard</span> Dashboard
                        </a>
                    </li>
                    <li class="sidebar-list-item">
                        <a href="products.php" onclick="closeCurrentPage()">
                            <span class="material-icons-outlined">inventory_2</span> Products
                        </a>
                    </li>
                    <li class="sidebar-list-item">
                        <a href="customer.php" onclick="closeCurrentPage()">
                            <span class="material-icons-outlined">groups</span> Customers
                        </a>
                    </li>
                    <li class="sidebar-list-item">
                        <a href="inventory.php" onclick="closeCurrentPage()">
                            <span class="material-icons-outlined">fact_check</span> Inventory
                        </a>
                    </li>
                    <li class="sidebar-list-item">
                        <a href="logout.php" onclick="closeCurrentPage()">
                            <span class="material-icons-outlined">logout</span> Logout
                        </a>
                    </li>
                </ul>
            </aside>
            <!-- End Sidebar -->

            <!-- Main -->
            <main class="main-container">
                <div class="main-title">
                    <h2>DASHBOARD</h2>
                </div>

                <div class="main-cards">
                    <div class="card">
                        <div class="card-inner">
                            <h3>PRODUCTS</h3>
                            <span class="material-icons-outlined">inventory_2</span>
                        </div>
                        <h1 id="productCount">Loading...</h1>
                    </div>

                    <div class="card">
                        <div class="card-inner">
                            <h3>CATEGORIES</h3>
                            <span class="material-icons-outlined">category</span>
                        </div>
                        <h1 id="categoryCount">Loading...</h1>
                    </div>

                    <div class="card">
                        <div class="card-inner">
                            <h3>CUSTOMERS</h3>
                            <span class="material-icons-outlined">groups</span>
                        </div>
                        <h1 id="userCount">Loading...</h1>
                    </div>

                    <div class="card">
                        <div class="card-inner">
                            <h3>ALERTS</h3>
                            <span class="material-icons-outlined">notification_important</span>
                        </div>
                        <h1>0</h1>
                    </div>
                </div>

                <div class="charts">
                    <div class="charts-card">
                        <h2 class="chart-title">Low Stocks Product</h2>
                        <div id="bar-chart"></div>
                    </div>

                    <div class="charts-card">
                        <h2 class="chart-title">Purchase and Sales Orders</h2>
                        <div id="area-chart"></div>
                    </div>
                    
                    <div class="charts-card">
                        <h2 class="chart-title">Most Purchased Products</h2>
                        <div id="doughnut-chart" style="width: 100%; height: 350px;"></div>
                    </div>
                </div>
            </main>
            <!-- End Main -->
        </div>
    <?php endif; ?>

    <!-- Scripts -->
    <!-- ApexCharts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.35.5/apexcharts.min.js"></script>
    <!-- Custom JS -->
    <script src="js/scripts.js"></script>
    <script>
  fetch('php/get_data_customer.php') // Adjust path if needed
    .then(response => response.json())
    .then(data => {
      document.getElementById('userCount').textContent = data.user_count;
    })
    .catch(error => console.error('Error fetching user count:', error));

    fetch('php/get_data_products.php')
    .then(response => response.json())
    .then(data => {
        document.getElementById('productCount').textContent = data.total_quantity;
    })
    .catch(error => console.error('Error fetching product quantity:', error));

    fetch('php/get_data_categories.php')
    .then(response => response.json())
    .then(data => {
        document.getElementById('categoryCount').textContent = data.category_count;
    })
    .catch(error => console.error('Error fetching category count:', error));
    
    const productData = {
      "products": ["Product A", "Product B", "Product C"],
      "quantities": [10, 20, 30]
    };
    console.log(productData);

</script>
  </body>
</html>