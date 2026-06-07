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

        .content {
            margin-top: 40px;
            text-align: justify;
        }

        .signature {
            margin-top: 80px;
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
            CERTIFICATE OF INDIGENCY
        </div>
    </div>

    <div class="content">

        <p>
            TO WHOM IT MAY CONCERN:
        </p>

        <p>
            This is to certify that
            <strong>
                <?= strtoupper(trim($data['first_name'] . ' ' . $data['middle_name'] . ' ' . $data['last_name'])) ?>
            </strong>
            is a bona fide resident of Barangay Sayog.
        </p>

        <p>
            This office certifies that the above-named person belongs to an indigent family and has insufficient
            financial resources to support necessary expenses.
        </p>

        <p>
            This certification is issued upon request for:
            <strong><?= htmlspecialchars($data['purpose']) ?></strong>.
        </p>

        <p>
            Issued this <?= date('jS') ?> day of <?= date('F Y') ?>.
        </p>

    </div>

    <div class="signature">
        <strong>Barangay Captain</strong>
    </div>

</body>

</html>
