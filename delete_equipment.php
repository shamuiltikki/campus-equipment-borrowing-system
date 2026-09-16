<?php
require_once "db.php";
$id=(int)($_GET['id']??0);
$stmt=$conn->prepare("DELETE FROM equipment WHERE id=?");
$stmt->bind_param("i",$id); $stmt->execute(); $stmt->close();
header("Location: manage_equipment.php"); exit;
?>