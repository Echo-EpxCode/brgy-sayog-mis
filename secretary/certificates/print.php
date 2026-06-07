<?php

require '../../config/database.php';
require '../../config/session.php';

if (!isset($_GET['id'])) {
    die("Invalid request");
}

$id = (int) $_GET['id'];

$stmt = mysqli_prepare(
    $conn,
    "SELECT c.*, dr.purpose, dt.document_name,
            r.first_name, r.middle_name, r.last_name, r.suffix, r.address
     FROM certificates c
     INNER JOIN document_requests dr ON c.request_id = dr.id
     INNER JOIN document_types dt ON dr.document_type_id = dt.id
     INNER JOIN residents r ON dr.resident_id = r.id
     WHERE c.id = ?"
);

mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
$data = mysqli_fetch_assoc($result);

if (!$data) {
    die("Certificate not found");
}

$full_name = trim(
    $data['first_name'] . ' ' .
    $data['middle_name'] . ' ' .
    $data['last_name'] . ' ' .
    $data['suffix']
);

?>

<!DOCTYPE html>
<html>

<head>

    <title>Official Certificate</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        @page {
            margin: 20mm;
        }

        body {
            font-family: "Times New Roman", serif;
            background: #fff;
            color: #000;
        }

        .cert-wrapper {
            border: 2px solid #000;
            padding: 40px;
        }

        /* HEADER */
        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .barangay-name {
            font-size: 18px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .municipality {
            font-size: 14px;
        }

        .title {
            margin-top: 20px;
            font-size: 22px;
            font-weight: bold;
            text-decoration: underline;
        }

        /* BODY */
        .content {
            margin-top: 30px;
            font-size: 16px;
            line-height: 1.8;
            text-align: justify;
        }

        .indent {
            text-indent: 50px;
        }

        /* FOOTER */
        .footer {
            margin-top: 60px;
            display: flex;
            justify-content: space-between;
        }

        .signature {
            text-align: center;
            width: 250px;
        }

        .line {
            border-top: 1px solid #000;
            margin-top: 60px;
        }

        .meta {
            margin-top: 30px;
            font-size: 14px;
        }

        /* PRINT CONTROL */
        .no-print {
            display: none;
        }

        @media print {
            .no-print {
                display: none !important;
            }
        }
    </style>

</head>

<body>

    <!-- SCREEN ONLY BUTTONS -->
    <div class="no-print mb-3">

        <button onclick="window.print()" class="btn btn-primary">
            Print Certificate
        </button>

        <a href="history.php" class="btn btn-secondary">
            Back
        </a>

    </div>

    <div class="cert-wrapper">

        <!-- HEADER -->
        <div class="header">

            <div class="barangay-name">
                REPUBLIC OF THE PHILIPPINES<br>
                PROVINCE / CITY / MUNICIPALITY<br>
                BARANGAY OFFICE
            </div>

            <div class="municipality">
                Barangay Sayog Management Information System
            </div>

            <div class="title">
                    <?= htmlspecialchars($data['document_name']) ?>
            </div>

        </div>

        <!-- BODY -->
        <div class="content">

            <p class="indent">
                TO WHOM IT MAY CONCERN:
            </p>

            <p class="indent">
                This is to certify that <b><?= htmlspecialchars($full_name) ?></b>,
                of legal age, residing at <?= htmlspecialchars($data['address']) ?>,
                is a bona fide resident of this barangay.
            </p>

            <p class="indent">
                This certification is being issued upon the request of the above-named person
                for <b><?= htmlspecialchars($data['purpose']) ?></b>.
            </p>

            <p class="indent">
                Issued this <?= date('jS \d\a\y \o\f F, Y', strtotime($data['issued_date'])) ?>
                at the Barangay Office.
            </p>

        </div>

        <!-- META -->
        <div class="meta">

            Certificate No: <b><?= htmlspecialchars($data['certificate_no']) ?></b>

        </div>

        <!-- FOOTER -->
        <div class="footer">

            <div></div>

            <div class="signature">
                <div class="line"></div>
                <b>Barangay Captain</b>
                <br>
                Authorized Signatory
            </div>

        </div>

    </div>

</body>

</html>
