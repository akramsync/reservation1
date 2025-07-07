<?php
include 'includes/db_connect.php';
session_start();

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Fetch user balance and recharge code
$user_query = "SELECT balance, recharge_code FROM users WHERE id = '{$_SESSION['user_id']}'";
$user_result = $conn->query($user_query);
$user = $user_result->fetch_assoc();
$user_balance = $user['balance'];
$recharge_code = $user['recharge_code'];

// Fetch routes
$routes_query = "SELECT * FROM routes";
$routes_result = $conn->query($routes_query);

// Initialize variables
$available_buses = [];
$route_name = '';
$booked_seat_message = '';
$booking_successful = false;

// Handle bus search
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['search_buses'])) {
    $route_id = $_POST['route_id'];
    $search_date = $_POST['search_date'];

    // Fetch active buses for the selected route and date, ignoring inactive buses
    $bus_query = "SELECT * FROM buses WHERE route_id = '$route_id' AND date = '$search_date' AND status = 'active'";
    $bus_result = $conn->query($bus_query);
    while ($bus = $bus_result->fetch_assoc()) {
        $available_buses[] = $bus;
    }
}

// Handle booking submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['book_now'])) {
    $bus_id = $_POST['bus_id'];
    $selected_seats = $_POST['seats'];  // Array of selected seat numbers
    $total_fare = $_POST['total_fare']; // Total fare calculated by the JavaScript

    if ($user_balance >= $total_fare) {
        // Deduct the total fare from user's balance
        $new_balance = $user_balance - $total_fare;
        $conn->query("UPDATE users SET balance = '$new_balance' WHERE id = '{$_SESSION['user_id']}'");

        // Insert booking record into the bookings table
        $seat_numbers_string = implode(',', $selected_seats);
        $booking_query = "INSERT INTO bookings (user_id, bus_id, seat_numbers, recharge_code) VALUES ('{$_SESSION['user_id']}', '$bus_id', '$seat_numbers_string', '$recharge_code')";
        $conn->query($booking_query);

        // Mark selected seats as reserved using the query
        $seats_query = "UPDATE seats SET status = 'reserved' WHERE seat_number IN ($seat_numbers_string) AND bus_id = '$bus_id'";
        $conn->query($seats_query);

        $booking_successful = true;
        $booked_seat_message = "Successfully booked seat(s): " . implode(', ', $selected_seats) . " at the cost of $total_fare AUD!";
    } else {
        $error_message = "Insufficient balance!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Your Tickets - Canberra Bus</title>
    <link rel="stylesheet" href="assets/css/book_tickets.css">
    <script src="assets/js/book_tickets.js" defer></script>
</head>
<body>
    <?php include 'includes/header.php'; ?>




<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ticketType = $_POST["ticket_type"] ?? '';
    $numTickets = intval($_POST["num_tickets"] ?? 0);

    $prices = [
        "general" => 250,
        "floor" => 450,
        "golden-circle" => 950,
        "vip" => 1500,
        "meet-greet" => 8500
    ];

    $unitPrice = $prices[$ticketType] ?? 0;
    $totalPrice = $unitPrice * $numTickets;
} else {
    header("Location: booking_form.php");
    exit;
}
?>
<style>
  body, html {
    height: 100%;
    margin: 0;
    padding: 0;
  }

  .summary-container {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    background-image: linear-gradient(120deg, rgba(67, 67, 103, 0.9), rgb(80 18 18 / 54%)), url(../images/4.jpeg);
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
  }

  .summary-box {
    background: white;
    padding: 2rem 2.5rem;
    border-radius: 16px;
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
    max-width: 500px;
    width: 100%;
    backdrop-filter: blur(5px);
  }

  h2 {
    text-align: center;
    color: #065f46;
    margin-bottom: 1.2rem;
  }

  .info {
    font-size: 1.1rem;
    margin-bottom: 0.75rem;
    color: #222;
  }

  .highlight {
    font-weight: bold;
    color: #047857;
  }
   .btn-payment {
    margin-top: 30px;
    background: linear-gradient(45deg, #10b981, #047857);
    border: none;
    padding: 15px 40px;
    font-size: 1.2rem;
    font-weight: 600;
    color: white;
    border-radius: 50px;
    cursor: pointer;
    box-shadow: 0 8px 15px rgba(4, 120, 87, 0.3);
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
  }
  
  .btn-payment::before {
    content: "";
    position: absolute;
    top: 50%;
    left: -25%;
    width: 50%;
    height: 200%;
    background: rgba(255, 255, 255, 0.3);
    transform: skewX(-25deg) translateX(-100%);
    transition: all 0.5s ease;
    pointer-events: none;
  }

  .btn-payment:hover {
    background: linear-gradient(45deg, #047857, #065f46);
    box-shadow: 0 12px 20px rgba(4, 120, 87, 0.5);
  }

  .btn-payment:hover::before {
    transform: skewX(-25deg) translateX(200%);
  }

  .btn-payment:focus {
    outline: none;
  }
</style>


 <?php
header('Content-Type: text/plain');

class NowPaymentsIPN {
    private $ipn_secret;
    
    public function __construct($ipn_secret) {
        $this->ipn_secret = $ipn_secret;
    }

    public function validate_ipn() {
        // Get all headers
        $headers = getallheaders();
        $received_hmac = $headers['X-Nowpayments-Sig'] ?? null;
        
        if (!$received_hmac) {
            // Alternative header check for different server configurations
            $received_hmac = $_SERVER['HTTP_X_NOWPAYMENTS_SIG'] ?? null;
        }
        
        if (!$received_hmac) {
            file_put_contents('ipn_errors.log', date('Y-m-d H:i:s')." - No HMAC signature found in headers\n", FILE_APPEND);
            return ['valid' => false, 'error' => 'No HMAC signature sent'];
        }

        $request_json = file_get_contents('php://input');
        
        if (empty($request_json)) {
            return ['valid' => false, 'error' => 'Empty request data'];
        }

        $request_data = json_decode($request_json, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            return ['valid' => false, 'error' => 'Invalid JSON: ' . json_last_error_msg()];
        }

        // Sort and encode the data
        ksort_recursive($request_data);
        $sorted_request_json = json_encode($request_data, JSON_UNESCAPED_SLASHES);
        
        $hmac = hash_hmac("sha512", $sorted_request_json, trim($this->ipn_secret));

        if (hash_equals($hmac, $received_hmac)) {
            return [
                'valid' => true,
                'data' => $request_data,
                'payment_id' => $request_data['payment_id'] ?? null,
                'payment_status' => $request_data['payment_status'] ?? null
            ];
        } else {
            file_put_contents('ipn_errors.log', 
                date('Y-m-d H:i:s')." - HMAC mismatch\nReceived: $received_hmac\nCalculated: $hmac\n", 
                FILE_APPEND);
            return ['valid' => false, 'error' => 'HMAC signature does not match'];
        }
    }
}

// Recursive key sorting function
function ksort_recursive(&$array) {
    ksort($array);
    foreach ($array as &$value) {
        if (is_array($value)) {
            ksort_recursive($value);
        }
    }
}

// Initialize with your IPN secret
$ipn_secret = "your_ipn_secret_here";
$ipn = new NowPaymentsIPN($ipn_secret);

// Validate the IPN
$validation = $ipn->validate_ipn();

if ($validation['valid']) {
    // Process successful payment
    http_response_code(200);
    echo "OK";
    
    // Log successful payment
    file_put_contents('ipn_success.log', 
        date('Y-m-d H:i:s')." - Valid IPN: ".json_encode($validation['data'])."\n", 
        FILE_APPEND);
} else {
    // Handle invalid IPN
    http_response_code(400);
    echo "ERROR: ".$validation['error'];
    
    // Log error
    file_put_contents('ipn_errors.log', 
        date('Y-m-d H:i:s')." - Invalid IPN: ".$validation['error']."\n", 
        FILE_APPEND);
}
?>









<?php
class NowPaymentsButton {
    private $api_key;
    
    public function __construct($api_key) {
        $this->api_key = $api_key;
    }
    
    public function create_payment($params) {
        $defaults = [
            'price_amount' => 0,
            'price_currency' => 'usd',
            'order_id' => '',
            'ipn_callback_url' => '',
            'success_url' => '',
            'cancel_url' => '',
            'order_description' => ''
        ];
        
        $data = array_merge($defaults, $params);
        
        $ch = curl_init();
        $options = [
            CURLOPT_URL => 'https://api.nowpayments.io/v1/payment',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                'x-api-key: ' . $this->api_key,
                'Content-Type: application/json'
            ],
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_TIMEOUT => 30,
            CURLOPT_SSL_VERIFYPEER => true,
            // For Windows users who can't verify SSL:
            // CURLOPT_SSL_VERIFYPEER => false,
            // CURLOPT_SSL_VERIFYHOST => 0
        ];
        
        // Try to find CA bundle automatically
        $ca_bundle = $this->find_ca_bundle();
        if ($ca_bundle) {
            $options[CURLOPT_CAINFO] = $ca_bundle;
        }
        
        curl_setopt_array($ch, $options);
        
        $response = curl_exec($ch);
        
        if (curl_errno($ch)) {
            $error = curl_error($ch);
            curl_close($ch);
            return ['error' => "CURL error: $error"];
        }
        
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        $result = json_decode($response, true);
        
        if ($http_code !== 200) {
            return [
                'error' => "API error ($http_code)",
                'message' => $result['message'] ?? 'Unknown error',
                'response' => $result
            ];
        }
        
        return $result;
    }
    
    private function find_ca_bundle() {
        $locations = [
            '/etc/ssl/certs/ca-certificates.crt',        // Linux
            '/etc/pki/tls/certs/ca-bundle.crt',         // Linux (RHEL)
            '/usr/local/etc/openssl/cert.pem',          // macOS Homebrew
            'C:\\windows\\system32\\curl-ca-bundle.crt',// Windows
            'C:\\xampp\\apache\\bin\\curl-ca-bundle.crt'// XAMPP
        ];
        
        foreach ($locations as $path) {
            if (file_exists($path)) {
                return $path;
            }
        }
        
        return false;
    }
}

// Usage example:
$api_key = "your_api_key_here";
$button = new NowPaymentsButton($api_key);

$payment = $button->create_payment([
    'price_amount' => 100,
    'price_currency' => 'usd',
    'order_id' => 'ORDER-' . uniqid(),
    'ipn_callback_url' => 'https://yourdomain.com/ipn_handler.php',
    'success_url' => 'https://yourdomain.com/success.php',
    'cancel_url' => 'https://yourdomain.com/cancel.php',
    'order_description' => 'Ticket purchase'
]);

if (isset($payment['payment_url'])) {
    echo '<a href="' . htmlspecialchars($payment['payment_url']) . '" class="nowpayments-button">Pay with Crypto</a>';
} else {
    echo '<div class="error">';
    echo '<p>Error creating payment:</p>';
    echo '<pre>' . htmlspecialchars(print_r($payment, true)) . '</pre>';
    echo '</div>';
}
?>

</div>  
</div>
</div>


  <!-- <script async src="https://atlos.io/packages/app/atlos.js"></script>
    <button onclick="atlos.Pay({
  merchantId: 'RB73WL1JG9',
  orderId: '123', 
  orderAmount: 19.95})">
  Click to Pay
  
</button> 
 -->




    <!-- <main>
        <h2>Book Your Tickets</h2>

       
        <?php if ($booking_successful): ?>
            <div class="success-message">
                <p><?php echo $booked_seat_message; ?></p>
                <button onclick="window.location.href='booking_history.php';">Check Your Booking</button>
                <button onclick="window.location.href='book_tickets.php';">Book Another Seat</button>
            </div>
        <?php elseif (isset($error_message)): ?>
            <div class="error-message">
                <p><?php echo $error_message; ?></p>
            </div>
        <?php endif; ?>

       
        <section class="route-selection">
            <h3>Select Your Route and Date</h3>
            <form action="book_tickets.php" method="POST">
                <div class="form-group">
                    <label for="route_id">Choose Route:</label>
                    <select id="route_id" name="route_id" required>
                        <?php while ($route = $routes_result->fetch_assoc()): ?>
                            <option value="<?php echo $route['id']; ?>"><?php echo $route['route_name']; ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="search_date">Select Date:</label>
                    <input type="date" id="search_date" name="search_date" value="<?php echo date('Y-m-d'); ?>" min="<?php echo date('Y-m-d'); ?>" max="<?php echo date('Y-m-d', strtotime('+3 days')); ?>" required>
                </div>
                <button type="submit" name="search_buses">Search Available Buses</button>
            </form>
        </section>

      
        <?php if (!empty($available_buses)): ?>
            <section class="bus-selection">
                <h3>Available Buses for <?php echo $route_name; ?> on <?php echo $_POST['search_date']; ?></h3>
                <div class="bus-list">
                    <?php foreach ($available_buses as $bus): ?>
                        <div class="bus-item" id="bus-<?php echo $bus['id']; ?>">
                            <p>Bus Number: <?php echo $bus['bus_number']; ?></p>
                            <p>Departure Time: <?php echo $bus['time']; ?></p>
                            <button class="select-bus" data-bus-id="<?php echo $bus['id']; ?>">Select</button>
                        </div>
                    <?php endforeach; ?>
                </div>
            </section>
        <?php endif; ?>

       
        <section class="seat-selection hidden">
            <h3>Select Your Seats</h3>
            <div class="seat-legend">
                <div class="legend-item"><div class="seat driver"></div> Driver</div>
                <div class="legend-item"><div class="seat staff"></div> Staff</div>
                <div class="legend-item"><div class="seat available"></div> Available</div>
                <div class="legend-item"><div class="seat reserved"></div> Reserved</div>
            </div>
            <div class="seat-layout">
              
            </div>
            <form action="book_tickets.php" method="POST" id="booking-form">
                <input type="hidden" id="bus_id" name="bus_id" value="">
                <input type="hidden" id="selected_seats" name="seats[]" required>
                <input type="hidden" id="total_fare" name="total_fare" value="">
                <div id="fare-calculator">
                    <p>Total Fare: <span id="fare-amount">0</span> AUD</p>
                    <p>Your Balance: <span id="user-balance"><?php echo $user_balance; ?></span> AUD</p>
                </div>
                <div class="form-group">
                    <label for="recharge_code">Enter Recharge Code:</label>
                    <input type="text" id="recharge_code" name="recharge_code" value="<?php echo $recharge_code; ?>" readonly>
                </div>
                <button type="submit" name="book_now">Book Now</button>
            </form>
        </section>

        
        <section class="upcoming-buses">
            <h3>Upcoming Buses</h3>
            <div class="slider">
                <?php
                // Fetch the upcoming buses (within the next 3 hours)
                $upcoming_buses_query = "SELECT * FROM buses WHERE status = 'active' AND date = CURDATE() AND time > NOW() LIMIT 10";
                $upcoming_buses_result = $conn->query($upcoming_buses_query);

                while ($upcoming_bus = $upcoming_buses_result->fetch_assoc()):
                ?>
                    <div class="bus-slide">
                        <p>Bus Number: <?php echo $upcoming_bus['bus_number']; ?></p>
                        <p>Departure Time: <?php echo $upcoming_bus['time']; ?></p>
                    </div>
                <?php endwhile; ?>
            </div>
        </section>
    </main>
 -->    <?php include 'includes/footer.php'; ?>
</body>
</html>
