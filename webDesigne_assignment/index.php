<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="index.css">

</head>
<body>
    <div class="head">

        <header class="header">
            <div>
                <img src="icdl-logo.svg" class="logo img">
            </div>
            <div class="left">
    
                <div id="mobile-language-select" class="drop">
                    <select   class="dropdwon">
        <option   >English</option>
        <option  >Français</option>
        <option >Español</option>
        <option  >中文 (中国)</option>
        <option >Português</option>
        <option >日本語</option>
        <option >Nederlands</option>
        
        </select>
            </div>
            <div class="nav-img">
                <img src="search-circle-white.svg" class="nav-img1 img">
                <img src="connect-circle-white.svg" class="nav-img2 img">
            </div>
            </div>
        </header>
        <nav>
            <a href="">ABOUT US</a>
            <a href="">PROGRAMMES</a>
            <a href="">INDIVIDUALS</a>
            <a href="">SCHOOLS</a>
            <a href="">UNIVERSTIES</a>
            <a href="">TRAINING PROVIDERS</a>
            <a href="">EMPLOYERS</a>
            <a href="">PARTNERSHIPS</a>
            <a href="">TEST CENTERS</a>
        </nav>
    </div>
    <main>
        <div>
            <img src="icdl.jpg" id="main-img">
        </div>
        <div class="middle">
            <div class="form">
                <h3>EMPLOYER PENSION MANAGENT SYSTEM</h3>
                <fORm>
                    <pre>
    
     EMPLOY NAME: <input type="text">
EMPLOYEE-ADDRESS: <input type="text">
  MONTHLY SALARY: <input type="text">
 EMPLOYEE-PERIOD: <input type="text">
    benefit in %: <input type="text">
                    </pre>
                </fORm>
            </div>
            <div class="CALCULATE">
                <button> CLICK TO CALCULATE</button>
                <label for="TOTAL">TOTAL AMOUNT:</label>
                <textarea name="TOTAL" id="TOTAL"></textarea>
                <label for="PER-MOUNTH">AMOUNT PER-MOUNTH:</label>
                <textarea name="PER-MOUNTH" id="PER-MOUNTH"></textarea>
            </div>
            <DIV id="BUTTON">
                <button>submit</button> 
                <button>retrive</button>
                <button>delete</button>
            </DIV>
        </div>
        <div>
            <img src="group.jpg" id="main-img">
        </div>
    </main>
    <footer>
        <h2 style="text-align: center; padding: 3px;">ICDL PROGRAMERS</h2>
        <div class="footer-div">
            <div class="div1">
                <h2>ICDL</h2>
            <H4>DIGITAL CITIZENS</H4>
            <P>Digital skills to access and build computer confidence</P>
        </div>
        <div class="div2">
            <h2>ICDL</h2>
            <H4>DIGITAL CITIZENS</H4>
            <P>Digital skills to access and build computer confidence</P>
        </div>
        <div class="div3">
            <h2>ICDL</h2>
            <H4>DIGITAL CITIZENS</H4>
            <P>Digital skills to access and build computer confidence</P>
        </div>
        <div class="div4">
            <h2>ICDL</h2>
            <H4>DIGITAL CITIZENS</H4>
            <P>Digital skills to access and build computer confidence</P>
        </div>
        <div class="div5">
            <h2>ICDL</h2>
            <H4>DIGITAL CITIZENS</H4>
            <P>Digital skills to access and build computer confidence</P>
        </div>
    </div>
    </footer>
</body>
</html> -->





<?php
// Database connection configuration
$host = "localhost";  // Your database host
$username = "root";   // Your database username
$password = "";       // Your database password
$database = "pension_management"; // Updated database name

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
        $stmt = $conn->prepare("INSERT INTO pension_records (employ_name, employee_address, monthly_salary, employee_period, benefit_percentage, total_amount, amount_per_month) VALUES (?, ?, ?, ?, ?, ?, ?)");
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
        $stmt = $conn->prepare("SELECT * FROM pension_records WHERE employ_name LIKE ?");
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
        $stmt = $conn->prepare("DELETE FROM pension_records WHERE employ_name = ?");
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
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="index.css">
</head>
<body>
    <div class="head">
        <header class="header">
            <div>
                <img src="icdl-logo.svg" class="logo img">
            </div>
            <div class="left">
                <div id="mobile-language-select" class="drop">
                    <select class="dropdwon">
                        <option>English</option>
                        <option>Français</option>
                        <option>Español</option>
                        <option>中文 (中国)</option>
                        <option>Português</option>
                        <option>日本語</option>
                        <option>Nederlands</option>
                    </select>
                </div>
                <div class="nav-img">
                    <img src="search-circle-white.svg" class="nav-img1 img">
                    <img src="connect-circle-white.svg" class="nav-img2 img">
                </div>
            </div>
        </header>
        <nav>
            <a href="">ABOUT US</a>
            <a href="">PROGRAMMES</a>
            <a href="">INDIVIDUALS</a>
            <a href="">SCHOOLS</a>
            <a href="">UNIVERSTIES</a>
            <a href="">TRAINING PROVIDERS</a>
            <a href="">EMPLOYERS</a>
            <a href="">PARTNERSHIPS</a>
            <a href="">TEST CENTERS</a>
        </nav>
    </div>
    <main>
        <div>
            <img src="icdl.jpg" id="main-img">
        </div>
        <div class="middle">
            <div class="form">
                <h3>EMPLOYER PENSION MANAGENT SYSTEM</h3>
                
                <?php if(!empty($message)): ?>
                    <div style="color: red; margin-bottom: 10px;"><?php echo $message; ?></div>
                <?php endif; ?>
                
                <form method="post" action="">
                    <pre>           
      EMPLOY NAME: <input type="text" name="employ_name" value="<?php echo htmlspecialchars($employName); ?>">
 EMPLOYEE-ADDRESS: <input type="text" name="employee_address" value="<?php echo htmlspecialchars($employeeAddress); ?>">
   MONTHLY SALARY: <input type="number" name="monthly_salary" value="<?php echo $monthlySalary; ?>">
  EMPLOYEE-PERIOD: <input type="number" name="employee_period" value="<?php echo $employeePeriod; ?>">
     benefit in %: <input type="number" step="0.01" name="benefit_percentage" value="<?php echo $benefitPercentage; ?>">
                    </pre>
            </div>
            <div class="CALCULATE">
                <button type="submit" name="calculate">CLICK TO CALCULATE</button>
                <label for="TOTAL">TOTAL AMOUNT:</label>
                <textarea name="TOTAL" id="TOTAL" readonly><?php echo number_format($totalAmount, 2); ?></textarea>
                <label for="PER-MOUNTH">AMOUNT PER-MOUNTH:</label>
                <textarea name="PER-MOUNTH" id="PER-MOUNTH" readonly><?php echo number_format($amountPerMonth, 2); ?></textarea>
            </div>
            <DIV id="BUTTON">
                <button type="submit" name="submit">submit</button>
                <button type="submit" name="retrieve">retrive</button>
                <button type="submit" name="delete">delete</button>
            </DIV>
            </form>
        </div>
        <div>
            <img src="group.jpg" id="main-img">
        </div>
    </main>
    <footer>
        <h2 style="text-align: center; padding: 3px;">ICDL PROGRAMERS</h2>
        <div class="footer-div">
            <div class="div1">
                <h2>ICDL</h2>
                <H4>DIGITAL CITIZENS</H4>
                <P>Digital skills to access and build computer confidence</P>
            </div>
            <div class="div2">
                <h2>ICDL</h2>
                <H4>DIGITAL CITIZENS</H4>
                <P>Digital skills to access and build computer confidence</P>
            </div>
            <div class="div3">
                <h2>ICDL</h2>
                <H4>DIGITAL CITIZENS</H4>
                <P>Digital skills to access and build computer confidence</P>
            </div>
            <div class="div4">
                <h2>ICDL</h2>
                <H4>DIGITAL CITIZENS</H4>
                <P>Digital skills to access and build computer confidence</P>
            </div>
            <div class="div5">
                <h2>ICDL</h2>
                <H4>DIGITAL CITIZENS</H4>
                <P>Digital skills to access and build computer confidence</P>
            </div>
        </div>
    </footer>
</body>
</html>
<?php
// Close the database connection
// $conn->close();
?>