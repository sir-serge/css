<?php
// Database connection configuration
$host = "localhost";  // Your database host
$username = "root";   // Your database username
$password = "";       // Your database password
$database = "pension_system"; // Your actual database name

// Initialize variables
$employName = "";
$employeeAddress = "";
$monthlySalary = 0;
$employeePeriod = 0;
$benefitPercentage = 0;
$totalAmount = 0;
$amountPerMonth = 0;
$message = "";

// Create database connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    $message = "Database connection failed: " . $conn->connect_error;
}

// Process form submission
if(isset($_POST['calculate'])) {
    // Get form data
    $employName = $_POST['employ_name'];
    $employeeAddress = $_POST['employee_address'];
    $monthlySalary = floatval($_POST['monthly_salary']);
    $employeePeriod = intval($_POST['employee_period']);
    $benefitPercentage = floatval($_POST['benefit_percentage']);
    
    // Validate inputs
    if(empty($employName) || empty($employeeAddress) || $monthlySalary <= 0 || $employeePeriod <= 0 || $benefitPercentage <= 0) {
        $message = "Please fill all fields with valid values";
    } else {
        // Calculate pension amounts
        $totalAmount = $monthlySalary * $employeePeriod * ($benefitPercentage / 100);
        $amountPerMonth = $totalAmount / ($employeePeriod * 12); // Monthly payment after retirement
    }
}

// Handle data submission to database
if(isset($_POST['submit'])) {
    // Get form data
    $employName = $_POST['employ_name'];
    $employeeAddress = $_POST['employee_address'];
    $monthlySalary = floatval($_POST['monthly_salary']);
    $employeePeriod = intval($_POST['employee_period']);
    $benefitPercentage = floatval($_POST['benefit_percentage']);
    
    // Recalculate to ensure correct values
    $totalAmount = $monthlySalary * $employeePeriod * ($benefitPercentage / 100);
    $amountPerMonth = $totalAmount / ($employeePeriod * 12);
    
    // Validate inputs before submission
    if(empty($employName) || empty($employeeAddress) || $monthlySalary <= 0 || $employeePeriod <= 0 || $benefitPercentage <= 0) {
        $message = "Please fill all fields with valid values before submitting";
    } else {
        // Prepare SQL statement with prepared statements to prevent SQL injection
        $stmt = $conn->prepare("INSERT INTO employee_pension (employ_name, employee_address, monthly_salary, employee_period, benefit_percentage, total_amount, amount_per_month) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssdiddd", $employName, $employeeAddress, $monthlySalary, $employeePeriod, $benefitPercentage, $totalAmount, $amountPerMonth);
        
        // Execute the statement
        if($stmt->execute()) {
            $message = "Record saved successfully!";
            // Clear form after successful submission
            $employName = "";
            $employeeAddress = "";
            $monthlySalary = 0;
            $employeePeriod = 0;
            $benefitPercentage = 0;
            $totalAmount = 0;
            $amountPerMonth = 0;
        } else {
            $message = "Error saving record: " . $conn->error;
        }
        
        // Close the statement
        $stmt->close();
    }
}

// Handle data retrieval
if(isset($_POST['retrieve'])) {
    $searchName = isset($_POST['employ_name']) ? $_POST['employ_name'] : '';
    
    if(empty($searchName)) {
        $message = "Please enter an employee name to retrieve records";
    } else {
        // Prepare SQL statement for retrieval
        $stmt = $conn->prepare("SELECT * FROM employee_pension WHERE employ_name LIKE ?");
        $searchParam = "%" . $searchName . "%";
        $stmt->bind_param("s", $searchParam);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if($result->num_rows > 0) {
            // Fetch the first matching record
            $row = $result->fetch_assoc();
            
            // Populate form with retrieved data
            $employName = $row['employ_name'];
            $employeeAddress = $row['employee_address'];
            $monthlySalary = $row['monthly_salary'];
            $employeePeriod = $row['employee_period'];
            $benefitPercentage = $row['benefit_percentage'];
            $totalAmount = $row['total_amount'];
            $amountPerMonth = $row['amount_per_month'];
            
            $message = "Record retrieved successfully!";
        } else {
            $message = "No records found for: " . $searchName;
        }
        
        $stmt->close();
    }
}

// Handle data deletion
if(isset($_POST['delete'])) {
    $searchName = isset($_POST['employ_name']) ? $_POST['employ_name'] : '';
    
    if(empty($searchName)) {
        $message = "Please enter an employee name to delete records";
    } else {
        // Prepare SQL statement for deletion
        $stmt = $conn->prepare("DELETE FROM employee_pension WHERE employ_name = ?");
        $stmt->bind_param("s", $searchName);
        
        // Execute the statement
        if($stmt->execute()) {
            if($stmt->affected_rows > 0) {
                $message = "Record deleted successfully!";
                // Clear form after successful deletion
                $employName = "";
                $employeeAddress = "";
                $monthlySalary = 0;
                $employeePeriod = 0;
                $benefitPercentage = 0;
                $totalAmount = 0;
                $amountPerMonth = 0;
            } else {
                $message = "No record found for deletion with name: " . $searchName;
            }
        } else {
            $message = "Error deleting record: " . $conn->error;
        }
        
        $stmt->close();
    }
}
?>
// Don't close the connection here - close it at the end of the script

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ICDL - Employer Pension Management System</title>
    <link rel="stylesheet" href="icdl.sql">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .header {
            background-color: #00a2e0;
            color: white;
            padding: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .logo {
            height: 40px;
        }
        .navigation {
            background-color: white;
            display: flex;
            justify-content: space-around;
            padding: 10px 0;
            border-bottom: 1px solid #ccc;
        }
        .navigation a {
            color: #00a2e0;
            text-decoration: none;
            font-weight: bold;
        }
        .container {
            display: flex;
            margin: 20px;
        }
        .sidebar {
            flex: 1;
            padding: 20px;
            background-color: #00a2e0;
            color: white;
            margin-right: 10px;
        }
        .main-content {
            flex: 2;
            padding: 20px;
            border: 1px solid #ccc;
        }
        .promo {
            flex: 1;
            padding: 0;
            margin-left: 10px;
        }
        .pension-form {
            width: 100%;
        }
        .form-group {
            margin-bottom: 15px;
            display: flex;
        }
        .form-group label {
            width: 150px;
            text-align: right;
            margin-right: 10px;
        }
        .form-group input {
            flex: 1;
            padding: 5px;
        }
        .button-group {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }
        .result-area {
            margin-top: 20px;
        }
        .result-box {
            width: 100%;
            height: 50px;
            border: 1px solid #ccc;
            margin-top: 5px;
            resize: none;
        }
        .programs {
            display: flex;
            margin-top: 20px;
            text-align: center;
        }
        .program {
            flex: 1;
            padding: 20px;
            color: white;
        }
        .blue {
            background-color: #00a2e0;
        }
        .navy {
            background-color: #003366;
        }
        .green {
            background-color: #006633;
        }
        .teal {
            background-color: #009966;
        }
        .purple {
            background-color: #993399;
        }
        .message {
            color: red;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <img src="icdl_logo.png" alt="ICDL Logo" class="logo">
        <select>
            <option selected>English</option>
            <option>Français</option>
            <option>Español</option>
        </select>
    </div>
    
    <div class="navigation">
        <a href="#">ABOUT US</a>
        <a href="#">PROGRAMMES</a>
        <a href="#">INDIVIDUALS</a>
        <a href="#">SCHOOLS</a>
        <a href="#">UNIVERSITIES</a>
        <a href="#">TRAINING PROVIDERS</a>
        <a href="#">EMPLOYERS</a>
        <a href="#">PARTNERSHIPS</a>
        <a href="#">TEST CENTERS</a>
    </div>
    
    <div class="container">
        <div class="sidebar">
            <h2>ICDL</h2>
            <p>ICDL Foundation is a global social enterprise committed to raising standards of digital competence in the workforce, education and society. ICDL certification is now available in more than 100 countries, across our network of more than 20,000 testing centres, delivering more than 70 million ICDL certification tests to more than 17 million people worldwide.</p>
            <a href="#">Read more</a>
        </div>
        
        <div class="main-content">
            <h2>EMPLOYER PENSION MANAGEMENT SYSTEM</h2>
            
            <?php if(!empty($message)): ?>
                <div class="message"><?php echo $message; ?></div>
            <?php endif; ?>
            
            <form method="post" class="pension-form">
                <div class="form-group">
                    <label for="employ_name">EMPLOY NAME:</label>
                    <input type="text" id="employ_name" name="employ_name" value="<?php echo htmlspecialchars($employName); ?>">
                </div>
                
                <div class="form-group">
                    <label for="employee_address">EMPLOYEE-ADDRESS:</label>
                    <input type="text" id="employee_address" name="employee_address" value="<?php echo htmlspecialchars($employeeAddress); ?>">
                </div>
                
                <div class="form-group">
                    <label for="monthly_salary">MONTHLY SALARY:</label>
                    <input type="number" id="monthly_salary" name="monthly_salary" value="<?php echo $monthlySalary; ?>">
                </div>
                
                <div class="form-group">
                    <label for="employee_period">EMPLOYEE-PERIOD:</label>
                    <input type="number" id="employee_period" name="employee_period" value="<?php echo $employeePeriod; ?>">
                </div>
                
                <div class="form-group">
                    <label for="benefit_percentage">benefit in %:</label>
                    <input type="number" id="benefit_percentage" name="benefit_percentage" step="0.01" value="<?php echo $benefitPercentage; ?>">
                </div>
                
                <div style="text-align: center; margin: 20px 0;">
                    <input type="submit" name="calculate" value="CLICK TO CALCULATE">
                </div>
                
                <div class="result-area">
                    <label for="total_amount">TOTAL AMOUNT:</label>
                    <textarea id="total_amount" class="result-box" readonly><?php echo number_format($totalAmount, 2); ?></textarea>
                </div>
                
                <div class="result-area">
                    <label for="amount_per_month">AMOUNT PER-MOUNTH:</label>
                    <textarea id="amount_per_month" class="result-box" readonly><?php echo number_format($amountPerMonth, 2); ?></textarea>
                </div>
                
                <div class="button-group">
                    <input type="submit" name="submit" value="submit">
                    <input type="submit" name="retrieve" value="retrive">
                    <input type="submit" name="delete" value="delete">
                </div>
            </form>
        </div>
        
        <div class="promo">
            <img src="icdl_promo.jpg" alt="ICDL Workforce" style="width: 100%;">
        </div>
    </div>
    
    <h2 style="text-align: center;">ICDL PROGRAMERS</h2>
    
    <div class="programs">
        <div class="program blue">
            <h3>ICDL<br>DIGITAL CITIZENS</h3>
            <p>Digital skills to access and build computer confidence</p>
        </div>
        <div class="program navy">
            <h3>ICDL<br>DIGITAL CITIZENS</h3>
            <p>Digital skills to access and build computer confidence</p>
        </div>
        <div class="program green">
            <h3>ICDL<br>DIGITAL CITIZENS</h3>
            <p>Digital skills to access and build computer confidence</p>
        </div>
        <div class="program teal">
            <h3>ICDL<br>DIGITAL CITIZENS</h3>
            <p>Digital skills to access and build computer confidence</p>
        </div>
        <div class="program purple">
            <h3>ICDL<br>DIGITAL CITIZENS</h3>
            <p>Digital skills to access and build computer confidence</p>
        </div>
    </div>
</body>
</html>