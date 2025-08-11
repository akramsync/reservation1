<?php
$ticket_type = "Meet & Greet"; // défini en dur selon la page
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Canberra Bus</title>

    <link rel="stylesheet" href="assets/css/about_us.css">
  <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            background-color: #f5f7fa;
            margin: 0;
            padding: 20px;
            color: #333;
        }

        .formulaire {
            max-width: 600px;
            margin: 30px auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #2c3e50;
            margin-bottom: 30px;
        }

        .champ {
            margin-bottom: 25px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #2c3e50;
        }

        input, select {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            transition: border 0.3s;
        }

        input:focus, select:focus {
            border-color: #3498db;
            outline: none;
            box-shadow: 0 0 5px rgba(52, 152, 219, 0.5);
        }

        .btn {
            background-color: #3498db;
            color: white;
            border: none;
            padding: 12px 20px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            transition: background-color 0.3s;
        }

        .btn:hover {
            background-color: #2980b9;
        }

        .type-billet {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <?php include 'includes/header.php'; ?>
  <div class="formulaire">
        <h1>Réservation de Billets</h1>
        <form action="process_booking.php" method="POST">
            <div class="champ">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" required placeholder="Enter your email address">
            </div>
            
            <div class="champ">
                <label for="location">City</label>
                <input type="text" id="location" name="location" required placeholder="Enter your city">
            </div>
            
            <div class="champ">
                <label for="zip_code">Postal Code</label>
                <input type="text" id="zip_code" name="zip_code" required placeholder="Enter your postal code" pattern="[0-9]{5}" title="Veuillez entrer un code postal valide à 5 chiffres">
            </div>
            
            <div class="champ">
                <label for="ticket_type">Ticket Type</label>
                <select id="ticket_type" name="ticket_type">
                    <option value="Meet & Greet" selected>Meet & Greet Package
</option>
                   
                </select>
                <div class="type-billet">
                    <p><strong>Meet & Greet Package
</strong> grants access to all general areas of the event.</p>
                </div>
            </div>
  <div style="text-align: center; margin-top: 20px;">
    <button type="submit" name="pay_crypto" 
        style="
            display: inline-block;
            background-color: #28a745;
            padding: 12px 24px;
            border-radius: 6px;
            color: white;
            font-weight: bold;
            text-decoration: none;
            font-family: sans-serif;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            border: none;
            cursor: pointer;
        ">
        Payer en Crypto
    </button>
</div>
        </form>
    </div>

    <script>
        // Mise à jour de la description du billet
        document.getElementById('ticket_type').addEventListener('change', function() {
            const descriptions = {
                'general': 'Admission Générale donne accès à toutes les zones générales de l’événement.',
                'vip': 'Les billets VIP incluent des sièges premium, un accès rapide et un salon exclusif.',
                'premium': 'Les billets Premium offrent les meilleures places avec des avantages supplémentaires.',
                'student': 'Les billets Étudiant nécessitent une carte étudiante valide et sont à prix réduit.'
            };
            
            document.querySelector('.type-billet p').innerHTML = 
                `<strong>${this.options[this.selectedIndex].text}</strong> ${descriptions[this.value]}`;
        });
    </script>
    
    <!-- Let's create a custom CSS file for the new About Us page -->


    <!-- Include Font Awesome for social icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <?php include 'includes/footer.php'; ?>
</body>
</html>
