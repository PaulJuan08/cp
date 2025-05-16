<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Certificate of Participation</title>
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
            background: #fff;
        }
        .certificate-container {
            width: 100%;
            height: 100%;
            position: relative;
            padding: 0;
            margin: 0;
        }
        .corner-decoration {
            position: absolute;
            width: 25%;
            height: 25%;
        }
        .top-left {
            top: 0;
            left: 0;
            border-top: 40px solid #4a8e3b;
            border-right: 40px solid transparent;
        }
        .top-right {
            top: 0;
            right: 0;
            border-top: 40px solid #f2c94c;
            border-left: 40px solid transparent;
        }
        .bottom-left {
            bottom: 0;
            left: 0;
            border-bottom: 40px solid #4a8e3b;
            border-right: 40px solid transparent;
        }
        .bottom-right {
            bottom: 0;
            right: 0;
            border-bottom: 40px solid #f2c94c;
            border-left: 40px solid transparent;
        }
        .logo-container {
            margin-top: 2cm;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 1cm;
        }
        .logo {
            width: 2.5cm;
            height: 2.5cm;
        }
        .certificate-title {
            font-size: 48px;
            font-weight: bold;
            color: #325f28;
            margin-top: 1cm;
            text-transform: uppercase;
            letter-spacing: 2px;
        }
        .certificate-subtitle {
            font-size: 24px;
            color: #555;
            margin-top: 0.5cm;
            text-transform: uppercase;
            position: relative;
        }
        .certificate-subtitle:before,
        .certificate-subtitle:after {
            content: '';
            display: inline-block;
            width: 5cm;
            height: 1px;
            background: #555;
            margin: 0 0.5cm;
            vertical-align: middle;
        }
        .student-name {
            font-size: 42px;
            font-family: 'Script MT Bold', 'Brush Script MT', cursive;
            color: #325f28;
            margin: 1.5cm auto 0.5cm;
            width: 80%;
            font-style: italic;
        }
        .participation-text {
            font-size: 16px;
            color: #555;
            margin: 0.5cm auto;
            width: 80%;
            line-height: 1.5;
        }
        .date-text {
            font-size: 16px;
            font-style: italic;
            color: #555;
            margin: 0.5cm auto;
        }
        .signature-section {
            margin: 1.5cm auto 0;
            padding: 0 2cm;
        }
        .signature-area {
            text-align: center;
            width: 7cm;
            margin: 0 auto;
        }
        .signature-line {
            width: 7cm;
            border-bottom: 1px solid #333;
            margin: 0 auto 0.3cm;
        }
        .signature-name {
            font-weight: bold;
            font-size: 18px;
            margin-bottom: 0.1cm;
        }
        .signature-title {
            font-size: 14px;
            color: #555;
        }
        .certificate-number {
            position: absolute;
            bottom: 0.5cm;
            left: 0.5cm;
            font-size: 10px;
            color: #777;
        }
        .top-wave {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 2cm;
            background: linear-gradient(90deg, #4a8e3b 60%, #f2c94c 40%);
            clip-path: polygon(0 0, 100% 0, 100% 100%, 0 60%);
            z-index: -1;
        }
        .bottom-wave {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 2cm;
            background: linear-gradient(90deg, #f2c94c 40%, #4a8e3b 60%);
            clip-path: polygon(0 0, 100% 40%, 100% 100%, 0 100%);
            z-index: -1;
        }
    </style>
</head>
<body>
    <div class="certificate-container">
        <!-- Decorative elements -->
        <div class="top-wave"></div>
        <div class="bottom-wave"></div>
        
        <!-- Logo section -->
        <div class="logo-container">
            <img src="{{ public_path('assets/img/logo_cmu.png') }}" alt="CMU Logo" class="logo">
            <img src="{{ public_path('assets/img/ODP-Logo.png') }}" alt="Shield Logo" class="logo">
        </div>
        
        <!-- Certificate header -->
        <div class="certificate-title">CERTIFICATE</div>
        <div class="certificate-subtitle">OF PARTICIPATION</div>
        
        <!-- Student information -->
        <div class="student-name">{{ $userName }}</div>
        
        <!-- Participation details -->
        <div class="participation-text">
            for participating in the Awareness on "Data Privacy Act of 2012 and 
            Responsible Technology Use" on {{ $completionDate }} held at the
            College of Education Hall, Central Mindanao University
        </div>
        
        <div class="date-text">
            Given this {{ date('jS', strtotime($completionDate)) }} day of {{ date('F Y', strtotime($completionDate)) }} at the College of Education Hall,
            Central Mindanao University
        </div>
        
        <!-- Signature section -->
        <div class="signature-section">
            <div class="signature-area">
                <div class="signature-line"></div>
                <div class="signature-name">EMELIO C. NAVAJA</div>
                <div class="signature-title">Data Protection Officer</div>
            </div>
        </div>
        
        <!-- Certificate ID -->
        <div class="certificate-number">{{ $certificateId }}</div>
    </div>
</body>
</html>