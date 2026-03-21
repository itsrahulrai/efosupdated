<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>EFOS Registration</title>
</head>

<body style="margin:0; padding:0; background:#f4f6fb; font-family:Arial, sans-serif;">

    <table width="100%" cellpadding="0" cellspacing="0" style="background:#f4f6fb; padding:30px 0;">
        <tr>
            <td align="center">

                <table width="600" cellpadding="0" cellspacing="0"
                    style="background:#ffffff; border-radius:10px; overflow:hidden; box-shadow:0 5px 15px rgba(0,0,0,0.08);">

                    <!-- Logo -->
                    <tr>
                        <td style="padding:25px; text-align:center;">
                            <img src="https://efos.in/public/assets/images/logo/logo.jpg" style="height:60px;">
                        </td>
                    </tr>

                    <!-- Content -->
                    <tr>
                        <td style="padding:35px;">

                            <h2 style="color:#111827; margin-top:0;">
                                Hello {{ $name }}
                            </h2>

                            <p style="color:#4b5563; font-size:15px; line-height:1.6;">
                                Welcome to <strong>EFOS</strong>! We are excited to have you join our learning
                                community.
                                Your registration has been completed successfully.
                            </p>

                            <!-- Credentials Box -->
                            <p style="margin:0; font-weight:bold; color:#111827;">Your Login Credentials</p>
                            <table width="100%" style="margin-top:15px;">
                                <tr>
                                    <td style="padding:8px 0; color:#374151;">
                                        User ID
                                    </td>

                                    <td style="padding:8px 0; font-weight:bold;">
                                        {{ $registration_number }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding:8px 0; color:#374151;">
                                        Email
                                    </td>

                                    <td style="padding:8px 0; font-weight:bold;">
                                        {{ $email }}
                                    </td>
                                </tr>

                                <tr>
                                    <td style="padding:8px 0; color:#374151;">
                                        Password
                                    </td>

                                    <td style="padding:8px 0; font-weight:bold;">
                                        {{ $password }}
                                    </td>
                                </tr>

                            </table>

                            <p style="color:#4b5563; font-size:15px;">
                                Please keep this information safe and do not share with anyone.
                            </p>
                             

                            <!-- Button -->
                            <table width="100%" style="margin:30px 0;">
                                <tr>
                                    <td align="center">

                                        <a href="{{ route('student.login') }}"
                                            style="
                                                background:#E62434;
                                                color:#ffffff;
                                                text-decoration:none;
                                                padding:14px 30px;
                                                border-radius:6px;
                                                font-weight:bold;
                                                display:inline-block;
                                                font-size:15px;
                                                ">

                                            Login Now

                                        </a>

                                    </td>
                                </tr>
                            </table>
                            
                            <p
                                style="color:#b91c1c; font-size:14px; background:#fef2f2; padding:12px; border-radius:6px;">
                                <strong>Important:</strong> For security reasons, please login and update your
                                password immediately from your Dashboard.
                            </p>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background:#f9fafb; padding:20px; text-align:center; font-size:13px; color:#6b7280;">
                            © {{ date('Y') }} EFOS. All Rights Reserved.
                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>

</body>

</html>
