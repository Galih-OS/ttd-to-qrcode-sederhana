document.addEventListener("DOMContentLoaded", function() {
    const canvas = document.getElementById('signature-pad');
    const signaturePad = new SignaturePad(canvas);
    const saveButton = document.getElementById('save');
    const clearButton = document.getElementById('clear');
    const signatureInput = document.getElementById('signature');

    saveButton.addEventListener('click', function() {
        if (signaturePad.isEmpty()) {
            alert("Please provide a signature first.");
        } else {
            const dataUrl = signaturePad.toDataURL();
            signatureInput.value = dataUrl;
            document.getElementById('signature-form').submit();
        }
    });

    clearButton.addEventListener('click', function() {
        signaturePad.clear();
    });
});
