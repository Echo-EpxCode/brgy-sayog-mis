<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <title>Certificate of Indigency</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #fff;
            font-family: "Times New Roman", serif;
        }

        .certificate-container {
            max-width: 900px;
            margin: 30px auto;
            padding: 50px;
            border: 3px solid #000;
        }

        .certificate-title {
            text-align: center;
            font-size: 32px;
            font-weight: bold;
            letter-spacing: 2px;
            margin-top: 40px;
            margin-bottom: 40px;
        }

        .certificate-body {
            font-size: 20px;
            line-height: 2;
            text-align: justify;
        }

        .signature-section {
            margin-top: 80px;
        }

        .signature-line {
            border-top: 1px solid #000;
            width: 250px;
            margin-left: auto;
            text-align: center;
            padding-top: 8px;
        }

        @media print {

            .no-print {
                display: none;
            }

            .certificate-container {
                border: none;
                margin: 0;
                max-width: 100%;
            }

        }
    </style>

</head>

<body>

    <div class="container">

        <!-- PRINT BUTTON -->
        <div class="text-end my-3 no-print">

            <button onclick="window.print()" class="btn btn-primary">

                Print Certificate

            </button>

        </div>

        <div class="certificate-container">

            <!-- HEADER -->
            <div class="text-center">

                <h5 class="mb-0">Republic of the Philippines</h5>
                <h5 class="mb-0">Province of Misamis Oriental</h5>
                <h5 class="mb-0">Municipality of __________</h5>

                <h4 class="fw-bold mt-2">
                    BARANGAY SAYOG
                </h4>

            </div>

            <!-- TITLE -->
            <div class="certificate-title">
                CERTIFICATE OF INDIGENCY
            </div>

            <!-- BODY -->
            <div class="certificate-body">

                <p>TO WHOM IT MAY CONCERN:</p>

                <p>

                    This is to certify that

                    <strong>
                        <?= htmlspecialchars($full_name) ?>
                    </strong>

                    , a resident of Barangay Sayog, is currently belonging to a low-income household
                    based on the assessment of this barangay.

                </p>

                <p>

                    The above-named individual is requesting this certificate for

                    <strong>
                        <?= htmlspecialchars($certificate['purpose']) ?>
                    </strong>

                    and is hereby endorsed as indigent and eligible for assistance programs.

                </p>

                <p>

                    This certification is issued upon request for whatever legal purpose it may serve.

                </p>

                <p>

                    Issued this

                    <strong>
                        <?= date('F d, Y', strtotime($certificate['issued_date'])) ?>
                    </strong>

                    at Barangay Sayog.

                </p>

            </div>

            <!-- DETAILS -->
            <div class="mt-5">

                <table class="table table-bordered">

                    <tr>
                        <th width="30%">Civil Status</th>
                        <td>
                            <?= htmlspecialchars($certificate['civil_status'] ?? '') ?>
                        </td>
                    </tr>

                    <tr>
                        <th>Occupation</th>
                        <td>
                            <?= htmlspecialchars($certificate['occupation'] ?? '') ?>
                        </td>
                    </tr>

                    <tr>
                        <th>Address</th>
                        <td>
                            <?= htmlspecialchars($certificate['address'] ?? '') ?>
                        </td>
                    </tr>

                    <tr>
                        <th>Certificate No.</th>
                        <td>
                            <?= htmlspecialchars($certificate['certificate_no']) ?>
                        </td>
                    </tr>

                </table>

            </div>

            <!-- SIGNATURE -->
            <div class="signature-section">

                <div class="signature-line">
                    <strong>Barangay Captain</strong>
                </div>

            </div>

        </div>

    </div>

</body>

</html>
