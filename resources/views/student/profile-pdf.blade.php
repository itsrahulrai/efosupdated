<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Profile Resume</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #333;
        }

        .container {
            width: 100%;
        }

        .row {
            display: table;
            width: 100%;
        }

        .col-left {
            width: 32%;
            display: table-cell;
            vertical-align: top;
            padding-right: 15px;
            background: #f8f9fa;
            padding: 15px;
        }

        .col-right {
            width: 68%;
            display: table-cell;
            vertical-align: top;
            padding: 15px;
        }

        .section {
            margin-bottom: 18px;
        }

        .title {
            font-weight: bold;
            border-bottom: 1px solid #ccc;
            margin-bottom: 8px;
            padding-bottom: 4px;
            font-size: 13px;
        }

        .small {
            font-size: 11px;
            line-height: 1.6;
        }

        .badge {
            display: inline-block;
            padding: 4px 10px;
            background: #0d6efd;
            color: #fff;
            font-size: 10px;
            border-radius: 12px;
            margin-top: 5px;
        }

        .profile-img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 10px;
        }

        .experience {
            margin-bottom: 12px;
            padding-bottom: 8px;
            border-bottom: 1px solid #eee;
        }

        .edu-box {
            border: 1px solid #ddd;
            padding: 8px;
            margin-bottom: 8px;
            background: #f7f7f7;
        }

        .pill {
            display: inline-block;
            padding: 3px 8px;
            font-size: 10px;
            background: #0d6efd;
            color: #fff;
            border-radius: 10px;
        }

        .pill.success {
            background: #198754;
        }

        .pill.warning {
            background: #ffc107;
            color: #000;
        }
    </style>
</head>

<body>
    {{-- ================= PDF HEADER WITH LOGO ================= --}}
    <div style="border-bottom:2px solid #000; margin-bottom:15px; padding-bottom:10px;">

        <table width="100%">
            <tr>
                <td width="60%">
                    <img src="{{ public_path('assets/images/logo/logo.jpg') }}" height="50"><br>
                    <strong style="font-size:16px;">EFOS Student Profile</strong><br>
                    <small>Employment Facilitation & Opportunity System</small>
                </td>

                <td width="40%" align="right" style="font-size:11px;">
                    <strong>Reg No:</strong> {{ $student->registration_number }}<br>
                    <strong>Date:</strong> {{ date('d M Y') }}
                </td>
            </tr>
        </table>

    </div>

    <div class="container">
        <div class="row">

            {{-- ================= LEFT ================= --}}
            <div class="col-left">

                {{-- PHOTO --}}
                @if ($student->photo)
                    @php
                        $photoPath = public_path($student->photo);
                    @endphp

                    @if (file_exists($photoPath))
                        <img src="{{ $photoPath }}"
                            style="width:100px;height:100px;border-radius:50%;object-fit:cover;">
                    @endif
                @endif


                <h3>{{ $student->name }}</h3>
                <span class="badge">{{ $student->present_status }}</span>

                <p class="small">
                    <strong>Reg No:</strong> {{ $student->registration_number }}<br>
                    <strong>Phone:</strong> {{ $student->phone }}<br>
                    <strong>Email:</strong> {{ $student->email }}<br>
                    <strong>Location:</strong> {{ $student->state }}, {{ $student->district }}
                </p>

                <div class="section">
                    <div class="title">Personal Details</div>
                    <p class="small">
                        <strong>Father:</strong> {{ $student->father_name }}<br>
                        <strong>Mother:</strong> {{ $student->mother_name }}<br>
                        <strong>Gender:</strong> {{ $student->gender }}<br>
                        <strong>Age Group:</strong> {{ $student->age_group }}<br>
                        <strong>Category:</strong> {{ $student->category }}<br>
                        <strong>Blood Group:</strong> {{ $student->blood_group }}<br>
                        <strong>Passport:</strong> {{ $student->passport }}<br>
                        <strong>Relocation:</strong> {{ $student->relocation }}
                    </p>
                </div>

                <div class="section">
                    <div class="title">Skills</div>
                    <p class="small">
                        {{ $student->skill_type }}<br>
                        {{ $student->skill_trade }}<br>
                        Year: {{ $student->skill_year }}
                    </p>
                </div>

            </div>

            {{-- ================= RIGHT ================= --}}
            <div class="col-right">

                <div class="section">
                    <div class="title">Profile Summary</div>
                    <p>{{ $student->profile_summary }}</p>
                </div>

                {{-- EXPERIENCE --}}
                @if ($student->experience_type === 'Experienced' && $student->experiences->count())
                    <div class="section">
                        <div class="title">Work Experience</div>

                        @foreach ($student->experiences as $exp)
                            <div class="experience">
                                <strong>{{ $exp->company_name }}</strong><br>
                                <span class="small">
                                    {{ $exp->job_profile }} |
                                    {{ $exp->job_duration }}<br>
                                    {{ $exp->job_state }}, {{ $exp->job_district }} |
                                    Salary: {{ $exp->salary_range }}
                                </span>
                                <p class="small">{{ $exp->job_summary }}</p>
                            </div>
                        @endforeach
                    </div>
                @endif

                {{-- EDUCATION --}}
                <div class="section">
                    <div class="title">Education</div>

                    @if ($student->highest_qualification)
                        <p class="small">
                            <strong>Highest Qualification:</strong>
                            <span class="pill">{{ strtoupper($student->highest_qualification) }}</span>
                        </p>
                    @endif

                    @if ($student->tenth_board)
                        <div class="edu-box">
                            <strong>10th Standard</strong><br>
                            <span class="small">
                                Board: {{ $student->tenth_board }} |
                                Year: {{ $student->tenth_year }} |
                                Marks: {{ $student->tenth_marks }}% |
                                Stream: {{ $student->tenth_stream }}
                            </span>
                        </div>
                    @endif

                    @if ($student->twelfth_board)
                        <div class="edu-box">
                            <strong>12th Standard</strong><br>
                            <span class="small">
                                Board: {{ $student->twelfth_board }} |
                                Year: {{ $student->twelfth_year }} |
                                Marks: {{ $student->twelfth_marks }}% |
                                Stream: {{ $student->twelfth_stream }}
                            </span>
                        </div>
                    @endif

                    @if ($student->graduation_university)
                        <div class="edu-box">
                            <strong>Graduation</strong><br>
                            <span class="small">
                                University: {{ $student->graduation_university }} |
                                Year: {{ $student->graduation_year }} |
                                Marks: {{ $student->graduation_marks }}% |
                                Field: {{ $student->graduation_field }}
                            </span>
                        </div>
                    @endif

                    @if ($student->pg_university)
                        <div class="edu-box">
                            <strong>Post Graduation</strong><br>
                            <span class="small">
                                University: {{ $student->pg_university }} |
                                Year: {{ $student->pg_year }} |
                                Marks: {{ $student->pg_marks }}% |
                                Field: {{ $student->pg_field }}
                            </span>
                        </div>
                    @endif

                    @if ($student->phd_university)
                        <div class="edu-box">
                            <strong>PhD</strong><br>
                            <span class="small">
                                University: {{ $student->phd_university }} |
                                Year: {{ $student->phd_year }} |
                                Subject: {{ $student->phd_subject }} |
                                Status:
                                <span class="pill {{ $student->phd_status === 'completed' ? 'success' : 'warning' }}">
                                    {{ ucfirst($student->phd_status) }}
                                </span>
                            </span>
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>

</body>

</html>
