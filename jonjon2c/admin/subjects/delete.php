<?php

require_once "../../config/database.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: index.php");
    exit;
}

if (!isset($_POST['id'])) {
    header("Location: index.php");
    exit;
}

$id = $_POST['id'];

$stmt = $conn->prepare("DELETE FROM subjects WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    header("Location: index.php?message=subject+deleted+successfully");
    exit;
} else {
    header("Location: index.php?message=Error+deleting+subject");
    exit;
}
?>