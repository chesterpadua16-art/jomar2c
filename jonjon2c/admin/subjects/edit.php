<?php

require_once "../../config/database.php";

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = $_GET['id'];

// Get the subject
$stmt = $conn->prepare("SELECT * FROM subjects WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

$result = $stmt->get_result();
$subject = $result->fetch_assoc();

if (!$subject) {
    die("Subject not found.");
}

// Update subject
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $subject_code = $_POST['subject_code'];
    $subject_name = $_POST['subject_name'];
    $units = $_POST['units'];

    $stmt = $conn->prepare(
        "UPDATE subjects
         SET subject_code = ?, subject_name = ?, units = ?
         WHERE id = ?"
    );

    $stmt->bind_param(
        "ssii",
        $subject_code,
        $subject_name,
        $units,
        $id
    );

    if ($stmt->execute()) {
        header("Location: index.php?message=Subject+updated+successfully");
        exit;
    } else {
        $error = "Error updating subject.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Subject</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >
</head>

<body>

<div class="container py-5">

    <div class="card">
        <div class="card-body">

            <h2>Edit Subject</h2>

            <?php if (isset($error)): ?>
                <div class="alert alert-danger">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>

            <form method="POST">

                <div class="mb-3">
                    <label class="form-label">
                        Subject Code
                    </label>

                    <input
                        type="text"
                        name="subject_code"
                        class="form-control"
                        value="<?php echo htmlspecialchars($subject['subject_code']); ?>"
                        required
                    >
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        Subject Name
                    </label>

                    <input
                        type="text"
                        name="subject_name"
                        class="form-control"
                        value="<?php echo htmlspecialchars($subject['subject_name']); ?>"
                        required
                    >
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        Units
                    </label>

                    <input
                        type="number"
                        name="units"
                        class="form-control"
                        value="<?php echo htmlspecialchars($subject['units']); ?>"
                        required
                    >
                </div>

                <button
                    type="submit"
                    class="btn btn-primary"
                >
                    Update Subject
                </button>

                <a
                    href="index.php"
                    class="btn btn-secondary"
                >
                    Cancel
                </a>

            </form>

        </div>
    </div>

</div>

</body>
</html>