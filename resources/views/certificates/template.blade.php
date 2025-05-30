<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Certificate of Completion</title>
    <style>
        @page {
            size: landscape;
            margin: 0;
        }
        body {
            font-family: 'DejaVu Sans', sans-serif;
            color: #333;
            text-align: center;
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
            background-color: #fff;
        }
        .certificate-container {
            width: 100%;
            height: 100%;
            position: relative;
            padding: 0;
            margin: 0;
            overflow: hidden;
        }
        .background-image {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }
        .logo-container {
            margin-top: 1.5cm;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 1.5cm;
            padding: 15px;
            border-radius: 8px;
            width: fit-content;
            margin-left: auto;
            margin-right: auto;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .logo {
            width: 2.8cm;
            height: 2.8cm;
            object-fit: contain;
        }
        .certificate-title {
            font-size: 92px;
            font-weight: bold;
            font-family: "Times New Roman", Times, Georgia, "Palatino Linotype", serif;
            color: #2a5a23;
            margin-top: 0.1cm;
            text-transform: uppercase;
            letter-spacing: 3px;
        }
        .certificate-subtitle {
            font-size: 46px;
            font-family: "Times New Roman", Times, Georgia, "Palatino Linotype", serif;
            color: #2a5a23;
            margin-top: 0.2cm;
            text-transform: uppercase;
            position: relative;
            letter-spacing: 2px;
        }
        .certificate-subtitle:before,
        .certificate-subtitle:after {
            content: '';
            display: inline-block;
            width: 5cm;
            height: 1px;
            background: linear-gradient(90deg, transparent, #555, transparent);
            margin: 0 0.8cm;
            vertical-align: middle;
        }
        .student-name {
            font-size: 74px;
            font-family: "Brush Script MT", "Lucida Handwriting", "Comic Sans MS", cursive;
            color: black;
            margin: 0.8cm auto 0.3cm;
            width: 80%;
            font-style: italic;
        }
        .completion-text {
            font-size: 30px;
            color: #444;
            margin: 0.4cm auto;
            width: 80%;
            line-height: 1.4;
            padding: 10px;
            border-radius: 5px;
        }
        .date-text {
            font-size: 32px;
            font-style: italic;
            color: #555;
            margin: 0.3cm auto;
            padding: 5px 10px;
            border-radius: 5px;
            display: inline-block;
        }
        .signature-section {
            margin: 1.2cm auto 0;
            padding: 0 2cm;
        }
        .signature-area {
            text-align: center;
            width: 8cm;
            margin: 0 auto;
            padding: 10px;
            border-radius: 5px;
        }
        .signature-name {
            font-weight: bold;
            font-size: 30px;
            margin-bottom: 0.1cm;
            color: #2a5a23;
        }
        .signature-title {
            font-size: 22px;
            color: #555;
            letter-spacing: 1px;
        }
        .certificate-number {
            position: absolute;
            bottom: 0.3cm;
            left: 1.5cm;
            font-size: 18px;
            color: yellow;
            padding: 5px 10px;
            border-radius: 3px;
        }
        .top-wave {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 2.5cm;
            background: linear-gradient(90deg, #4a8e3b 60%, #f2c94c 40%);
            clip-path: polygon(0 0, 100% 0, 100% 100%, 0 70%);
            opacity: 0.7;
        }
        .bottom-wave {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 2.5cm;
            background: linear-gradient(90deg, #f2c94c 40%, #4a8e3b 60%);
            clip-path: polygon(0 30%, 100% 0, 100% 100%, 0 100%);
            opacity: 0.7;
        }
    </style>
</head>
<body>
    <!-- Background image -->
    @php
        $backgroundImage = base64_encode(file_get_contents(public_path('assets/img/background.png')));
    @endphp
    <div class="background-image" style="background-image: url('data:image/png;base64,{{ $backgroundImage }}');"></div>
    
    <div class="certificate-container">
        <!-- Decorative elements -->
        <div class="top-wave"></div>
        <div class="bottom-wave"></div>
        
        <!-- Logo section -->
        @php
            $cmuLogo = base64_encode(file_get_contents(public_path('assets/img/logo_cmu.png')));
            $odpLogo = base64_encode(file_get_contents(public_path('assets/img/ODP-Logo.png')));
        @endphp

        <div class="logo-container">
            <img src="data:image/png;base64,{{ $cmuLogo }}" alt="CMU Logo" class="logo">
            <img src="data:image/png;base64,{{ $odpLogo }}" alt="ODP Logo" class="logo">
        </div>
        
        <!-- Certificate header -->
        <div class="certificate-title">CERTIFICATE</div>
        <div class="certificate-subtitle">OF COMPLETION</div>
        
        <!-- Student information -->
        <div class="student-name">{{ $userName }}</div>
        
        <!-- Completion details -->
        <div class="completion-text">
            has successfully completed the course <strong>"{{ $courseName }}"</strong>
            @if(isset($courseDescription))
            <br>{{ $courseDescription }}
            @endif
            <br> through the CoursePriva Learning Platform
        </div>
        
        <div class="date-text">
            Given this {{ date('jS', strtotime($completionDate)) }} day of {{ date('F Y', strtotime($completionDate)) }}
            at Central Mindanao University.
        </div>
        
        <!-- Signature section -->
        <div class="signature-section">
            <div class="signature-area">
                <div class="signature-name">ROLITO G. EBALLE</div>
                <div class="signature-title">University President</div>
            </div>
        </div>
        
        <!-- Certificate ID -->
        <div class="certificate-number">{{ $certificateId }}</div>
    </div>
</body>
</html>