<?php
require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../../config/config.php';
use App\Database\Database;

$email = "visheshyadav62@gmail.com"; // User provided this in command, but previously DB showed this.
// Wait, user request says: "visheshyada2408@gmail.com".
// But DB check in previous step showed "visheshyadav62@gmail.com".
// I should try to update "visheshyada2408@gmail.com" IF IT EXISTS, otherwise update "visheshyadav62@gmail.com"?
// Or maybe the user WANTS to create/add "visheshyada2408@gmail.com"?
// Or maybe they just made a typo in the request or in registration?
// I will try to update "visheshyada2408@gmail.com".
// If 0 rows affected, I will report it.

$targetEmail = "visheshyada2408@gmail.com";
// Actually the user typed "visheshyada2408@gmail.com" in the request.
// In the previous step, the DB check showed "visheshyadav62@gmail.com".
// Maybe they want to update the existing user "visheshyadav62@gmail.com" to have the EMAIL "visheshyada2408@gmail.com" and THEN make admin?
// OR maybe they registered a new user "visheshyada2408@gmail.com" in the last few seconds?
// I will check if "visheshyada2408@gmail.com" exists. If not, I'll assume they meant the "Vishesh Yadav" user (id 2) should be updated to this email and promo.

$db = new Database();

// Try strictly first
$sql = "UPDATE tbl_user SET role = 1 WHERE email = '$targetEmail'";
$db->link->query($sql);

if ($db->link->affected_rows > 0) {
    echo "Success: User '$targetEmail' is now an Admin.\n";
} else {
    echo "Warning: No user found with email '$targetEmail'.\n";
    // Check if the other email exists to offer help
    $check = $db->link->query("SELECT email FROM tbl_user WHERE email LIKE 'vishesh%'");
    if ($check->num_rows > 0) {
        echo "Did you mean one of these?\n";
        while($r = $check->fetch_assoc()) {
            echo "- " . $r['email'] . "\n";
        }
    }
}
