<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Welcome to EFOS Mentor Panel</title>
</head>

<body style="margin:0; padding:0; background:#f4f6fb; font-family:Arial, sans-serif;">

    <table width="100%" cellpadding="0" cellspacing="0" style="background:#f4f6fb; padding:30px 0;">
        <tr>
            <td align="center">

                <table width="600" cellpadding="0" cellspacing="0"
                    style="background:#ffffff; border-radius:10px; overflow:hidden; box-shadow:0 5px 15px rgba(0,0,0,0.08);">

                    <!-- Header -->
                    <tr>
                        <td style="background:#ffffff; padding:25px; text-align:center;">

                            <img src="https://efos.in/public/assets/images/logo/logo.jpg" alt="EFOS Logo"
                                style="height:60px; display:block; margin:0 auto 10px;">

                        </td>
                    </tr>


                    <!-- Welcome Section -->
                    <tr>
                        <td style="padding:35px;">

                            <h2 style="color:#111827; margin-top:0;">
                                Hello {{ $name }},
                            </h2>


                            <p style="color:#4b5563; font-size:15px; line-height:1.6;">
                                Welcome to <strong>EFOS Mentor Platform</strong>!
                                Your mentor profile has been successfully created.
                                Students can now connect with you and book sessions based on your expertise.
                            </p>


                            <!-- Login Credentials -->
                            <table width="100%" style="background:#eef2ff; border-radius:8px; margin:25px 0;">

                                <tr>
                                    <td style="padding:20px;">
                                        <p style="margin:0; font-weight:bold; color:#111827;">
                                            Your Login Credentials
                                        </p>

                                        <table width="100%" style="margin-top:15px;">
                                            <tr>
                                                <td style="padding:6px 0; color:#374151;">Email</td>

                                                <td style="padding:6px 0; font-weight:bold;">{{ $email }}</td>
                                            </tr>
                                            <tr>
                                                <td style="padding:6px 0; color:#374151;"> Password</td>

                                                <td style="padding:6px 0; font-weight:bold;">{{ $password }}</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                            <p style="color:#4b5563; font-size:15px;">
                                Please login to your mentor dashboard and complete your profile
                            </p>

                            <!-- Login Button -->
                            <table width="100%" style="margin:30px 0;">
                                <tr>
                                    <td align="center">
                                        <a href="{{ route('login') }}"
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
                                            Login to Mentor Dashboard

                                        </a>

                                    </td>

                                </tr>

                            </table>



                            <p
                                style="color:#b91c1c; font-size:14px; background:#fef2f2; padding:12px; border-radius:6px;">

                                <strong>Important:</strong>

                                For security reasons, please login and change your password immediately.

                            </p>


                        </td>

                    </tr>


                    <!-- Footer -->
                    <tr>

                        <td style="background:#f9fafb; padding:20px; text-align:center; font-size:13px; color:#6b7280;">

                            <p style="margin:0;">

                                © {{ date('Y') }} EFOS. All Rights Reserved.

                            </p>

                        </td>

                    </tr>


                </table>

            </td>

        </tr>

    </table>

</body>

</html>
