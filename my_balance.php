<?php
include 'includes/db_connect.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Fetch the user's balance and recharge code from the database
$user_id = $_SESSION['user_id'];
$query = "SELECT recharge_code, balance FROM users WHERE id = '$user_id'";
$result = $conn->query($query);
$user_data = $result->fetch_assoc();
$recharge_code = $user_data['recharge_code'];
$balance = $user_data['balance'];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_balance'])) {
    $amount = $_POST['amount'];

    // Dummy card details validation (for testing purposes)
    $card_number = $_POST['card_number'];
    $expiry_date = $_POST['expiry_date'];
    $cvv = $_POST['cvv'];

    if ($card_number == '4111111111111111' && $expiry_date == '12/25' && $cvv == '123') {
        // Update the user's balance
        $new_balance = $balance + $amount;
        $update_query = "UPDATE users SET balance = '$new_balance' WHERE id = '$user_id'";
        if ($conn->query($update_query)) {
            // Insert transaction details into the 'transactions' table
            $transaction_query = "INSERT INTO transactions (user_id, amount, transaction_date, status) 
                                  VALUES ('$user_id', '$amount', NOW(), 'completed')";
            if ($conn->query($transaction_query)) {
                $balance = $new_balance;
                $message = "Balance added successfully and transaction recorded!";
            } else {
                $error_message = "Error recording transaction: " . $conn->error;
            }
        } else {
            $error_message = "Error updating balance: " . $conn->error;
        }
    } else {
        $error_message = "Invalid card details. Please use the dummy card for testing.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Balance - Canberra Bus</title>
    <link rel="stylesheet" href="assets/css/my_balance.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>
     <!-- Balance Tips Section -->
     <section class="mb-tips-section">
        <div class="mb-extras-container">
            <h2 class="mb-extras-title">Balance Tips</h2>
            <ul class="mb-tips-list">
                <li>Your recharge code is unique—keep it safe and don't share it with others.</li>
                <li>Use your balance to book tickets instantly, no need to re-enter payment details.</li>
                <li>All top-ups are processed securely. For large top-ups, contact support.</li>
                <li>Check your transaction history for a record of all balance changes.</li>
            </ul>
        </div>
    </section>
    <main>
        <h2>My Balance</h2>
        <p><strong>Recharge Code:</strong> <?php echo $recharge_code; ?></p>
        <p><strong>Current Balance:</strong> AUD <?php echo number_format($balance, 2); ?></p>

        <?php if (isset($message)): ?>
            <div class="success-message"><?php echo $message; ?></div>
        <?php elseif (isset($error_message)): ?>
            <div class="error-message"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <h3>Add Balance</h3>
        <form action="my_balance.php" method="POST">
            <div class="form-group">
                <label for="amount">Amount (AUD):</label>
                <input type="number" id="amount" name="amount" min="1" required>
            </div>
            <div class="form-group">
                <label for="card_number">Card Number:</label>
                <input type="text" id="card_number" name="card_number" required>
                <small>Use dummy card: 4111 1111 1111 1111</small>
            </div>
            <div class="form-group">
                <label for="expiry_date">Expiry Date (MM/YY):</label>
                <input type="text" id="expiry_date" name="expiry_date" required>
                <small>Use dummy expiry date: 12/25</small>
            </div>
            <div class="form-group">
                <label for="cvv">CVV:</label>
                <input type="text" id="cvv" name="cvv" required>
                <small>Use dummy CVV: 123</small>
            </div>
            <button type="submit" name="add_balance">Add Balance</button>
        </form>
    </main>
    
   

    <!-- Balance FAQs Section -->
    <section class="mb-faq-section">
        <div class="mb-extras-container">
            <h2 class="mb-extras-title">Frequently Asked Questions</h2>
            <div class="mb-faq-list">
                <div class="mb-faq-item">
                    <div class="mb-faq-question">How do I recharge my balance? <i class="fas fa-chevron-down"></i></div>
                    <div class="mb-faq-answer">Enter the amount and dummy card details above, then click 'Add Balance'.</div>
                </div>
                <div class="mb-faq-item">
                    <div class="mb-faq-question">Is my payment information secure? <i class="fas fa-chevron-down"></i></div>
                    <div class="mb-faq-answer">Yes, all payments are processed securely and your card details are never stored.</div>
                </div>
                <div class="mb-faq-item">
                    <div class="mb-faq-question">Can I get a refund for unused balance? <i class="fas fa-chevron-down"></i></div>
                    <div class="mb-faq-answer">Refunds are available for unused balance upon request. Please contact support for assistance.</div>
                </div>
                <div class="mb-faq-item">
                    <div class="mb-faq-question">What if my balance is not updated? <i class="fas fa-chevron-down"></i></div>
                    <div class="mb-faq-answer">If your balance does not update after a successful payment, please contact support immediately.</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Need Help Banner -->
    <section class="mb-support-banner">
        <div class="mb-support-content">
            <i class="fas fa-headset"></i>
            <span>Need help with your balance or payments? <a href="contact_us.php">Contact our support team</a> for quick assistance.</span>
        </div>
    </section>

    <link rel="stylesheet" href="assets/css/my_balance_extras.css">
    <script>
    // FAQ Accordion for my balance page
    const mbFaqItems = document.querySelectorAll('.mb-faq-item');
    mbFaqItems.forEach(item => {
        item.querySelector('.mb-faq-question').addEventListener('click', () => {
            item.classList.toggle('active');
            mbFaqItems.forEach(other => {
                if (other !== item) other.classList.remove('active');
            });
        });
    });
    </script>
    <?php include 'includes/footer.php'; ?>

</body>
</html>
