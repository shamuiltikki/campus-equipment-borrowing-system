<?php
require_once "db.php";
$equipment = $conn->query("SELECT * FROM equipment ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Campus Equipment Borrowing System</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<nav class="navbar">
  <div class="brand">Campus<span>Equip</span></div>
  <div><a href="index.php">Home</a><a href="borrow.php">Borrow</a><a href="my_requests.php">My Requests</a><a href="admin.php">Admin</a></div>
</nav>
<header class="hero">
  <div>
    <p class="eyebrow">COLLEGE EQUIPMENT MANAGEMENT</p>
    <h1>Borrow campus equipment<br>without the paperwork.</h1>
    <p>Check availability, submit a borrowing request, and track its status from one simple portal.</p>
    <a class="btn" href="#equipment">Explore Equipment</a>
  </div>
</header>
<main class="container" id="equipment">
  <div class="section-head">
    <div><p class="eyebrow">AVAILABLE INVENTORY</p><h2>Equipment Catalogue</h2></div>
    <a class="btn secondary" href="borrow.php">New Request</a>
  </div>
  <div class="grid">
  <?php while($row = $equipment->fetch_assoc()): ?>
    <article class="card">
      <div class="icon">▣</div>
      <h3><?= htmlspecialchars($row['name']) ?></h3>
      <p><?= htmlspecialchars($row['description']) ?></p>
      <div class="meta"><span><?= htmlspecialchars($row['category']) ?></span><b class="<?= strtolower($row['availability']) == 'available' ? 'available' : 'unavailable' ?>"><?= htmlspecialchars($row['availability']) ?></b></div>
      <?php if (strtolower($row['availability']) == 'available'): ?>
        <a class="btn small" href="borrow.php?equipment_id=<?= $row['id'] ?>">Request Borrow</a>
      <?php else: ?><button class="btn small disabled" disabled>Currently Unavailable</button><?php endif; ?>
    </article>
  <?php endwhile; ?>
  </div>
</main>
<footer>© 2026 Campus Equipment Borrowing System</footer>
</body>
</html>