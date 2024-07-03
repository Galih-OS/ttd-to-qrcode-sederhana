<?php
require 'db.php';
require 'lib/phpqrcode/qrlib.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['signature'])) {
    $signatureData = $_POST['signature'];
    $signatureData = str_replace('data:image/png;base64,', '', $signatureData);
    $signatureData = str_replace(' ', '+', $signatureData);
    $signature = base64_decode($signatureData);

    $signatureFile = 'uploads/signature_' . time() . '.png';
    file_put_contents($signatureFile, $signature);

    $qrCodeFile = 'uploads/qrcode_' . time() . '.png';
    QRcode::png($signatureFile, $qrCodeFile);

    $stmt = $conn->prepare("INSERT INTO signatures (signature_path, qr_code_path) VALUES (?, ?)");
    $stmt->bind_param("ss", $signatureFile, $qrCodeFile);
    $stmt->execute();
    $stmt->close();
    $conn->close();

    header("Location: display_signatures.php");
}
?>
