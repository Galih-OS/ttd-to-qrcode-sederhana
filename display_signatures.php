<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete'])) {
    $idsToDelete = $_POST['delete'];
    if (!empty($idsToDelete)) {
        foreach ($idsToDelete as $id) {
            $stmt = $conn->prepare("SELECT signature_path, qr_code_path FROM signatures WHERE id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $stmt->bind_result($signaturePath, $qrCodePath);
            $stmt->fetch();
            $stmt->close();

            if (file_exists($signaturePath)) {
                unlink($signaturePath);
            }
            if (file_exists($qrCodePath)) {
                unlink($qrCodePath);
            }

            $stmt = $conn->prepare("DELETE FROM signatures WHERE id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $stmt->close();
        }
    }
}

$sql = "SELECT id, signature_path, qr_code_path, created_at FROM signatures ORDER BY created_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Display Signatures</title>
</head>
<body>
    <h1>Saved Signatures</h1>
    <a href="index.php">Back to Sign</a>
    <?php if ($result->num_rows > 0): ?>
        <form method="post" action="">
            <table border="1">
                <tr>
                    <th>Select</th>
                    <th>Signature</th>
                    <th>QR Code</th>
                    <th>Timestamp</th>
                </tr>
                <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><input type="checkbox" name="delete[]" value="<?php echo $row['id']; ?>"></td>
                    <td><img src="<?php echo $row['signature_path']; ?>" alt="Signature" width="200"></td>
                    <td><img src="<?php echo $row['qr_code_path']; ?>" alt="QR Code" width="200"></td>
                    <td><?php echo $row['created_at']; ?></td>
                </tr>
                <?php endwhile; ?>
            </table>
            <button type="submit">Delete Selected</button>
        </form>
    <?php else: ?>
        <p>No signatures found.</p>
    <?php endif; ?>
    <?php $conn->close(); ?>
</body>
</html>
