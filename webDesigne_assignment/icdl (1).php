<?php
// Initialize variables
$employName = "";
$employeeAddress = "";
$monthlySalary = 0;
$employeePeriod = 0;
$benefitPercentage = 0;
$totalAmount = 0;
$amountPerMonth = 0;
$message = "";

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

// Handle data retrieval
if(isset($_POST['retrieve'])) {
    // This would typically connect to a database
    // For demonstration, we'll just show a message
    $message = "Data retrieval functionality would connect to the database";
}

// Handle data deletion
if(isset($_POST['delete'])) {
    // This would typically connect to a database to delete records
    // For demonstration, we'll just clear the form
    $employName = "";
    $employeeAddress = "";
    $monthlySalary = 0;
    $employeePeriod = 0;
    $benefitPercentage = 0;
    $totalAmount = 0;
    $amountPerMonth = 0;
    $message = "Form data cleared";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ICDL - Employer Pension Management System</title>
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
<!-- Code injected by live-server -->
<script>
	// <![CDATA[  <-- For SVG support
	if ('WebSocket' in window) {
		(function () {
			function refreshCSS() {
				var sheets = [].slice.call(document.getElementsByTagName("link"));
				var head = document.getElementsByTagName("head")[0];
				for (var i = 0; i < sheets.length; ++i) {
					var elem = sheets[i];
					var parent = elem.parentElement || head;
					parent.removeChild(elem);
					var rel = elem.rel;
					if (elem.href && typeof rel != "string" || rel.length == 0 || rel.toLowerCase() == "stylesheet") {
						var url = elem.href.replace(/(&|\?)_cacheOverride=\d+/, '');
						elem.href = url + (url.indexOf('?') >= 0 ? '&' : '?') + '_cacheOverride=' + (new Date().valueOf());
					}
					parent.appendChild(elem);
				}
			}
			var protocol = window.location.protocol === 'http:' ? 'ws://' : 'wss://';
			var address = protocol + window.location.host + window.location.pathname + '/ws';
			var socket = new WebSocket(address);
			socket.onmessage = function (msg) {
				if (msg.data == 'reload') window.location.reload();
				else if (msg.data == 'refreshcss') refreshCSS();
			};
			if (sessionStorage && !sessionStorage.getItem('IsThisFirstTime_Log_From_LiveServer')) {
				console.log('Live reload enabled.');
				sessionStorage.setItem('IsThisFirstTime_Log_From_LiveServer', true);
			}
		})();
	}
	else {
		console.error('Upgrade your browser. This Browser is NOT supported WebSocket for Live-Reloading.');
	}
	// ]]>
</script>
</body>
</html>