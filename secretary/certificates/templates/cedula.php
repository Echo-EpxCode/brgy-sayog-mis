<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: "Times New Roman", serif;
            font-size: 14px;
            line-height: 1.8;
            margin: 50px;
        }

        .header {
            text-align: center;
        }

        .title {
            margin-top: 30px;
            font-size: 22px;
            font-weight: bold;
            text-decoration: underline;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 25px;
        }

        table,
        td,
        th {
            border: 1px solid #000;
            padding: 8px;
        }

        .signature {
            margin-top: 60px;
            text-align: right;
        }
    </style>
    <?php
    // Convert logo to base64 (fixed path resolution)
    
    $logoPath = __DIR__ . '/../../../assets/images/logo.jpg';

    if (!file_exists($logoPath)) {
        die("Logo file not found at: " . $logoPath);
    }

    $logoType = pathinfo($logoPath, PATHINFO_EXTENSION);
    $logoData = file_get_contents($logoPath);

    $logoBase64 = 'data:image/' . $logoType . ';base64,' . base64_encode($logoData);
    ?>
</head>

<body>

    <div class="header" style="text-align:center;">

        <img src="<?= $logoBase64 ?>" width="120" style="margin-bottom:10px;">

        <h3 style="margin:0;">REPUBLIC OF THE PHILIPPINES</h3>
        <h3 style="margin:0;">BARANGAY SAYOG</h3>
        <h3 style="margin:0;">SAN MIGUEL, ZAMBOANGA DEL SUR</h3>

        <div class="title" style="margin-top:15px; font-size:18px; font-weight:bold;">
            COMMUNITY TAX CERTIFICATE
        </div>
    </div>

    <table>
        <tr>
            <th>Full Name</th>
            <td>
                <?= strtoupper(trim($data['first_name'] . ' ' . $data['middle_name'] . ' ' . $data['last_name'])) ?>
            </td>
        </tr>

        <tr>
            <th>Address</th>
            <td><?= htmlspecialchars($data['address']) ?></td>
        </tr>

        <tr>
            <th>Civil Status</th>
            <td><?= htmlspecialchars($data['civil_status']) ?></td>
        </tr>

        <tr>
            <th>Citizenship</th>
            <td><?= htmlspecialchars($data['citizenship']) ?></td>
        </tr>

        <tr>
            <th>Occupation</th>
            <td><?= htmlspecialchars($data['occupation']) ?></td>
        </tr>

        <tr>
            <th>Purpose</th>
            <td><?= htmlspecialchars($data['purpose']) ?></td>
        </tr>
    </table>

    <div class="signature">
        <strong>Barangay Treasurer</strong>
    </div>

</body>

</html>
