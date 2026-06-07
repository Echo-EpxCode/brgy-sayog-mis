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
</head>

<body>

    <div class="header">
        <h3>REPUBLIC OF THE PHILIPPINES</h3>
        <h3>BARANGAY SAYOG</h3>
        <h3>MISAMIS ORIENTAL</h3>

        <div class="title">
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
