<?php
require_once "db.php";
if ($_SERVER["REQUEST_METHOD"]==="POST") {
  $id=(int)$_POST['id']; $status=$_POST['status'];
  $stmt=$conn->prepare("UPDATE borrowing_requests SET status=? WHERE id=?");
  $stmt->bind_param("si",$status,$id); $stmt->execute(); $stmt->close();
  header("Location: admin.php"); exit;
}
$requests=$conn->query("SELECT r.*, e.name AS equipment_name FROM borrowing_requests r JOIN equipment e ON r.equipment_id=e.id ORDER BY r.id DESC");
$count=$conn->query("SELECT COUNT(*) c FROM borrowing_requests")->fetch_assoc()['c'];
?>
<!DOCTYPE html><html><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1.0"><title>Admin Dashboard</title><link rel="stylesheet" href="style.css"></head>
<body><nav class="navbar"><div class="brand">Campus<span>Equip</span></div><div><a href="index.php">Home</a><a href="borrow.php">Borrow</a><a href="my_requests.php">My Requests</a><a href="admin.php">Admin</a></div></nav>
<main class="container"><div class="dashboard-head"><div><p class="eyebrow">ADMIN DASHBOARD</p><h1>Manage borrowing requests</h1></div><div class="stat"><b><?= $count ?></b><span>Total Requests</span></div></div>
<div class="table-wrap"><table><thead><tr><th>ID</th><th>Student</th><th>Equipment</th><th>Purpose</th><th>Dates</th><th>Status</th><th>Action</th></tr></thead><tbody>
<?php while($r=$requests->fetch_assoc()): ?><tr><td>#<?= $r['id'] ?></td><td><?= htmlspecialchars($r['student_name']) ?><small><?= htmlspecialchars($r['email']) ?></small></td><td><?= htmlspecialchars($r['equipment_name']) ?></td><td><?= htmlspecialchars($r['purpose']) ?></td><td><?= $r['borrow_date'] ?><br><?= $r['return_date'] ?></td><td><span class="status"><?= htmlspecialchars($r['status']) ?></span></td><td><form method="post" class="inline"><input type="hidden" name="id" value="<?= $r['id'] ?>"><select name="status"><option>Pending</option><option>Approved</option><option>Rejected</option><option>Issued</option><option>Returned</option></select><button class="btn tiny">Update</button></form></td></tr><?php endwhile; ?>
</tbody></table></div></main></body></html>