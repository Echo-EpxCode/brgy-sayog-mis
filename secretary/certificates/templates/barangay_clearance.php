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
</head>

<body>

    <div class="header">
        <h3>REPUBLIC OF THE PHILIPPINES</h3>
        <h3>BARANGAY SAYOG</h3>
        <h3>MISAMIS ORIENTAL</h3>

        <div class="title">
            BARANGAY CLEARANCE
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
            </strong>,
            of legal age, residing at
            <strong><?= htmlspecialchars($data['address']) ?></strong>,
            Barangay Sayog, is known to be a resident of this barangay.
        </p>

        <p>
            Based on available records, the above-named person has no derogatory record on file in this office as of
            this date.
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
