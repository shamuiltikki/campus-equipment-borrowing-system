<?php
require_once "db.php";
$selected = isset($_GET['equipment_id']) ? (int)$_GET['equipment_id'] : 0;
$equipment = $conn->query("SELECT id,name FROM equipment WHERE availability='Available' ORDER BY name");
$message = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST["student_name"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $equipment_id = (int)($_POST["equipment_id"] ?? 0);
    $borrow_date = $_POST["borrow_date"] ?? "";
    $return_date = $_POST["return_date"] ?? "";
    $purpose = trim($_POST["purpose"] ?? "");

    if ($name && filter_var($email, FILTER_VALIDATE_EMAIL) && $equipment_id && $borrow_date && $return_date && $purpose) {
        $stmt = $conn->prepare("INSERT INTO borrowing_requests (student_name,email,equipment_id,borrow_date,return_date,purpose,status) VALUES (?,?,?,?,?,?, 'Pending')");
        $stmt->bind_param("ssisss", $name, $email, $equipment_id, $borrow_date, $return_date, $purpose);
        $stmt->execute();
        $ticket = $stmt->insert_id;
        $stmt->close();
        header("Location: success.php?id=".$ticket);
        exit;
    } else {
        $message = "Please fill all fields correctly.";
    }
}
?>
<!DOCTYPE html>
<html lang="en"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1.0"><title>Borrow Equipment</title><link rel="stylesheet" href="style.css"></head>
<body>
<nav class="navbar"><div class="brand">Campus<span>Equip</span></div><div><a href="index.php">Home</a><a href="borrow.php">Borrow</a><a href="my_requests.php">My Requests</a><a href="admin.php">Admin</a></div></nav>
<main class="container narrow">
<div class="form-card"><p class="eyebrow">BORROW REQUEST</p><h1>Request equipment</h1><p class="muted">Submit your details and the administrator can approve the request.</p>
<?php if($message): ?><div class="alert"><?= htmlspecialchars($message) ?></div><?php endif; ?>
<form method="post">
<label>Student Name<input type="text" name="student_name" required></label>
<label>Email<input type="email" name="email" required></label>
<label>Equipment<select name="equipment_id" required><option value="">Select equipment</option><?php while($e=$equipment->fetch_assoc()): ?><option value="<?= $e['id'] ?>" <?= $selected==$e['id']?'selected':'' ?>><?= htmlspecialchars($e['name']) ?></option><?php endwhile; ?></select></label>
<div class="two"><label>Borrow Date<input type="date" name="borrow_date" required></label><label>Return Date<input type="date" name="return_date" required></label></div>
<label>Purpose<textarea name="purpose" rows="4" placeholder="Why do you need this equipment?" required></textarea></label>
<button class="btn" type="submit">Submit Borrow Request</button>
</form></div></main>
</body></html>