<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <title>
        Barangay Clearance
    </title>

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

        <div class="text-end my-3 no-print">

            <button onclick="window.print()" class="btn btn-primary">

                Print Certificate

            </button>

        </div>

        <div class="certificate-container">

            <!-- HEADER -->

            <div class="text-center">

                <h5 class="mb-0">
                    Republic of the Philippines
                </h5>

                <h5 class="mb-0">
                    Province of Misamis Oriental
                </h5>

                <h5 class="mb-0">
                    Municipality of __________
                </h5>

                <h4 class="fw-bold mt-2">
                    BARANGAY SAYOG
                </h4>

            </div>

            <!-- TITLE -->

            <div class="certificate-title">

                BARANGAY CLEARANCE

            </div>

            <!-- CERTIFICATE BODY -->

            <div class="certificate-body">

                <p>

                    TO WHOM IT MAY CONCERN:

                </p>

                <p>

                    This is to certify that

                    <strong>
                        <?= htmlspecialchars($full_name) ?>
                    </strong>

                    is a bonafide resident of Barangay Sayog and is known to be
                    a person of good moral character and law-abiding citizen
                    of this community.

                </p>

                <p>

                    Based on the records available in this barangay, no derogatory
                    information has been filed against the above-named individual
                    as of this date.

                </p>

                <p>

                    This certification is issued upon the request of the above-named
                    person for

                    <strong>
                        <?= htmlspecialchars($certificate['purpose']) ?>
                    </strong>

                    and for whatever legal purpose it may serve.

                </p>

                <p>

                    Issued this

                    <strong>
                        <?= date(
                            'F d, Y',
                            strtotime($certificate['issued_date'])
                        ) ?>
                    </strong>

                    at Barangay Sayog.

                </p>

            </div>

            <!-- CERTIFICATE DETAILS -->

            <div class="mt-5">

                <table class="table table-bordered">

                    <tr>

                        <th width="30%">
                            Certificate No.
                        </th>

                        <td>
                            <?= htmlspecialchars(
                                $certificate['certificate_no']
                            ) ?>
                        </td>

                    </tr>

                    <tr>

                        <th>
                            Household No.
                        </th>

                        <td>
                            <?= htmlspecialchars(
                                $certificate['household_no'] ?? ''
                            ) ?>
                        </td>

                    </tr>

                    <tr>

                        <th>
                            Address
                        </th>

                        <td>
                            <?= htmlspecialchars(
                                $certificate['address'] ?? ''
                            ) ?>
                        </td>

                    </tr>

                </table>

            </div>

            <!-- SIGNATURE -->

            <div class="signature-section">

                <div class="signature-line">

                    <strong>
                        Barangay Captain
                    </strong>

                </div>

            </div>

        </div>

    </div>

</body>

</html>
