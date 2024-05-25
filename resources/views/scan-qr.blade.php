<!-- resources/views/scan-qr.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Сканировать QR</title>
    <script src="https://unpkg.com/qr-scanner/qr-scanner.umd.min.js"></script>
</head>
<body>
<button onclick="scanQr()">Сканировать QR</button>
<script>
    function scanQr() {
        const qrScanner = new QrScanner(
            document.createElement('video'),
            result => handleQrResult(result)
        );
        qrScanner.start();
    }

    function handleQrResult(result) {
        const [eventId, qrCode] = result.split('/');
        fetch(`/validate-qr/${eventId}/${qrCode}`)
            .then(response => response.json())
            .then(data => alert(data.message))
            .catch(error => alert('Ошибка при сканировании QR-кода'));
    }
</script>
</body>
</html>
