<?php
require_once "db.php";
$search = trim($_GET['search'] ?? "");
if ($search !== "") {
  $like = "%".$search."%";
  $stmt = $conn->prepare("SELECT r.*, e.name AS equipment_name FROM borrowing_requests r JOIN equipment e ON r.equipment_id=e.id WHERE r.student_name LIKE ? OR r.email LIKE ? OR r.status LIKE ? ORDER BY r.id DESC");
  $stmt->bind_param("sss",$like,$like,$like); $stmt->execute(); $requests=$stmt->get_result();
} else {
  $requests=$conn->query("SELECT r.*, e.name AS equipment_name FROM borrowing_requests r JOIN equipment e ON r.equipment_id=e.id ORDER BY r.id DESC");
}
?>
<!DOCTYPE html><html><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1.0"><title>My Requests</title><link rel="stylesheet" href="style.css"></head>
<body><nav class="navbar"><div class="brand">Campus<span>Equip</span></div><div><a href="index.php">Home</a><a href="borrow.php">Borrow</a><a href="my_requests.php">My Requests</a><a href="admin.php">Admin</a></div></nav>
<main class="container"><div class="section-head"><div><p class="eyebrow">REQUEST TRACKING</p><h1>Borrowing Requests</h1></div></div>
<form class="search" method="get"><input name="search" value="<?= htmlspecialchars($search) ?>" placeholder="Search by name, email or status"><button class="btn small">Search</button></form>
<div class="table-wrap"><table><thead><tr><th>ID</th><th>Student</th><th>Equipment</th><th>Dates</th><th>Status</th></tr></thead><tbody>
<?php while($r=$requests->fetch_assoc()): ?><tr><td>#<?= $r['id'] ?></td><td><?= htmlspecialchars($r['student_name']) ?><small><?= htmlspecialchars($r['email']) ?></small></td><td><?= htmlspecialchars($r['equipment_name']) ?></td><td><?= htmlspecialchars($r['borrow_date']) ?> → <?= htmlspecialchars($r['return_date']) ?></td><td><span class="status"><?= htmlspecialchars($r['status']) ?></span></td></tr><?php endwhile; ?>
</tbody></table></div></main></body></html>