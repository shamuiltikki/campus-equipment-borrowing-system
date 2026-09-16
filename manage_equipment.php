<?php
require_once "db.php";
$message="";
if($_SERVER["REQUEST_METHOD"]==="POST"){
  $name=trim($_POST['name']);$category=trim($_POST['category']);$description=trim($_POST['description']);
  $stmt=$conn->prepare("INSERT INTO equipment(name,category,description,availability) VALUES(?,?,?,'Available')");
  $stmt->bind_param("sss",$name,$category,$description);$stmt->execute();$stmt->close();
  header("Location: manage_equipment.php");exit;
}
$items=$conn->query("SELECT * FROM equipment ORDER BY id DESC");
?>
<!DOCTYPE html><html><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1.0"><title>Manage Equipment</title><link rel="stylesheet" href="style.css"></head>
<body><nav class="navbar"><div class="brand">Campus<span>Equip</span></div><div><a href="index.php">Home</a><a href="admin.php">Admin</a></div></nav>
<main class="container"><div class="section-head"><div><p class="eyebrow">INVENTORY</p><h1>Manage Equipment</h1></div></div>
<div class="form-card compact"><form method="post"><div class="three"><label>Name<input name="name" required></label><label>Category<input name="category" required></label><label>Description<input name="description" required></label></div><button class="btn">Add Equipment</button></form></div>
<div class="table-wrap"><table><thead><tr><th>ID</th><th>Name</th><th>Category</th><th>Availability</th><th>Action</th></tr></thead><tbody><?php while($i=$items->fetch_assoc()): ?><tr><td>#<?= $i['id'] ?></td><td><?= htmlspecialchars($i['name']) ?></td><td><?= htmlspecialchars($i['category']) ?></td><td><?= htmlspecialchars($i['availability']) ?></td><td><a class="danger" href="delete_equipment.php?id=<?= $i['id'] ?>" onclick="return confirm('Delete this equipment?')">Delete</a></td></tr><?php endwhile; ?></tbody></table></div></main></body></html>