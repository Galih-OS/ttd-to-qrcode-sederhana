<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Real-Time Signature</title>
    <link rel="stylesheet" href="css/styles.css">
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
</head>
<body>
    <h1>Real-Time Signature</h1>
    <canvas id="signature-pad" class="signature-pad" width=400 height=200></canvas>
    <button id="save">Save</button>
    <button id="clear">Clear</button>

    <form id="signature-form" action="save_signature.php" method="post">
        <input type="hidden" name="signature" id="signature">
    </form>

    <script src="js/script.js"></script>
</body>
</html>
