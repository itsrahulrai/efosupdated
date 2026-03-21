<!DOCTYPE html>
<html>

<head>
    <title>Certificate</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@700;900&family=Poppins:wght@400;600&display=swap"
        rel="stylesheet">

    <style>
        body {
            margin: 0;
            padding: 0;
            background: #f8f9fa;
        }

        .certificate-container {
            position: relative;
            max-width: 1000px;
            margin: auto;
        }

        .certificate-img {
            width: 100%;
            height: auto;
            display: block;
        }

        .certificate-content {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }

        .student-name {
            position: absolute;
            top: 36%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 37px;
            font-weight: 700;
            font-family: 'Poppins', sans-serif;
            color: #000;
        }

        .course-name {
            position: absolute;
            top: 49%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-family: 'Poppins', sans-serif;
            font-size: 24px;
            font-weight: 900;
            letter-spacing: 1px;
            color: #000;
        }

        .serial-number {
            position: absolute;
            bottom: 20%;
            right: 21%;
            font-size: 14px;
            font-weight: 600;
            font-family: 'Poppins', sans-serif;
        }

        /* ================= PRINT SETTINGS ================= */
        @media print {
            @page {
                size: 210mm 297mm;
                /* A4 Portrait (Vertical) - width x height */
                margin: 0mm;
            }

            * {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            html {
                width: 210mm;
                height: 297mm;
                margin: 0;
                padding: 0;
            }

            body {
                margin: 0 !important;
                padding: 0 !important;
                width: 210mm !important;
                height: 297mm !important;
                min-height: 297mm !important;
                background: white !important;
                overflow: hidden !important;
            }

            /* Hide the print button */
            .btn,
            .mb-3,
            .text-center.mb-3 {
                display: none !important;
            }

            /* Container - full page */
            .container {
                max-width: 210mm !important;
                width: 210mm !important;
                height: 297mm !important;
                min-height: 297mm !important;
                padding: 0 !important;
                margin: 0 !important;
            }

            /* Certificate container - full page dimensions */
            .certificate-container {
                position: relative !important;
                width: 210mm !important;
                height: 297mm !important;
                min-height: 297mm !important;
                max-width: 210mm !important;
                max-height: 297mm !important;
                margin: 0 !important;
                padding: 0 !important;
                box-shadow: none !important;
                page-break-inside: avoid !important;
            }

            /* Image - stretch to full page height and width */
            .certificate-img {
                width: 210mm !important;
                height: 297mm !important;
                min-height: 297mm !important;
                max-width: 210mm !important;
                max-height: 297mm !important;
                object-fit: fill !important;
                display: block !important;
                margin: 0 !important;
                padding: 0 !important;
            }

            /* Content overlay - full dimensions */
            .certificate-content {
                position: absolute !important;
                top: 0 !important;
                left: 0 !important;
                width: 210mm !important;
                height: 297mm !important;
                min-height: 297mm !important;
            }

            /* Text elements */
            .student-name {
                position: absolute !important;
                top: 36% !important;
                left: 50% !important;
                transform: translate(-50%, -50%) !important;
                font-size: 37px !important;
                font-weight: 700 !important;
                font-family: 'Poppins', sans-serif !important;
                color: #000 !important;
                white-space: nowrap !important;
            }

            .course-name {
                position: absolute !important;
                top: 49% !important;
                left: 50% !important;
                transform: translate(-50%, -50%) !important;
                font-family: 'Poppins', sans-serif !important;
                font-size: 24px !important;
                font-weight: 900 !important;
                letter-spacing: 1px !important;
                color: #000 !important;
                white-space: nowrap !important;
            }

            .serial-number {
                position: absolute !important;
                bottom: 20% !important;
                right: 21% !important;
                font-size: 14px !important;
                font-weight: 600 !important;
                font-family: 'Poppins', sans-serif !important;
                white-space: nowrap !important;
            }
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="text-center mb-3">
            <button onclick="printCertificate()" class="btn btn-primary">
                Print Certificate
            </button>
        </div>
        <div class="certificate-container shadow-lg">

            <img src="{{ static_asset('assets/images/certificate-bg.jpeg') }}" class="certificate-img" alt="Certificate">

            <div class="certificate-content">

                <div class="student-name text-center">
                    {{ $certificate->student->name }}
                </div>

                <div class="course-name text-center">
                    {{ $certificate->course->title }}
                </div>

                <div class="serial-number">
                    {{ $certificate->certificate_number }}
                </div>

            </div>

        </div>
    </div>
    <script>
        function printCertificate() {
            window.print();
        }
    </script>
</body>

</html>
