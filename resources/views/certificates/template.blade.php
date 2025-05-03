<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Certificate of Completion</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            background-color: #f8f8f8;
            margin: 0;
            padding: 0;
        }
        .certificate-container {
            width: 800px;
            height: 600px;
            margin: 0 auto;
            background-color: white;
            border: 15px solid #1a5276;
            position: relative;
            text-align: center;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        .certificate-header {
            padding: 40px 0 20px;
        }
        .certificate-title {
            font-size: 36px;
            color: #1a5276;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .certificate-subtitle {
            font-size: 18px;
            color: #555;
            margin-bottom: 30px;
        }
        .certificate-body {
            padding: 20px 60px;
        }
        .certificate-text {
            font-size: 20px;
            margin-bottom: 30px;
            line-height: 1.6;
        }
        .certificate-user {
            font-size: 28px;
            font-weight: bold;
            color: #1a5276;
            margin: 30px 0;
        }
        .certificate-course {
            font-size: 22px;
            font-style: italic;
            margin-bottom: 30px;
        }
        .certificate-footer {
            margin-top: 40px;
            display: flex;
            justify-content: space-between;
            padding: 0 60px;
        }
        .signature {
            width: 200px;
            border-top: 1px solid #333;
            padding-top: 10px;
            text-align: center;
        }
        .certificate-id {
            position: absolute;
            bottom: 20px;
            right: 30px;
            font-size: 12px;
            color: #777;
        }
        .watermark {
            position: absolute;
            opacity: 0.1;
            font-size: 120px;
            color: #1a5276;
            transform: rotate(-30deg);
            left: 100px;
            top: 200px;
            z-index: -1;
        }
    </style>
</head>
<body>
    <div class="certificate-container">
        <div class="watermark">CoursePriva</div>
        
        <div class="certificate-header">
            <div class="certificate-title">Certificate of Completion</div>
            <div class="certificate-subtitle">This is to certify that</div>
        </div>
        
        <div class="certificate-body">
            <div class="certificate-user">{{ $userName }}</div>
            <div class="certificate-text">has successfully completed the course</div>
            <div class="certificate-course">"{{ $courseName }}"</div>
            <div class="certificate-text">on {{ $completionDate }}</div>
        </div>
        
        <div class="certificate-footer">
            <div class="signature">
                <div>_________________________</div>
                <div>CoursePriva Administrator</div>
            </div>
            <div class="signature">
                <div>_________________________</div>
                <div>Date: {{ $completionDate }}</div>
            </div>
        </div>
        
        <div class="certificate-id">Certificate ID: {{ $certificateId }}</div>
    </div>
</body>
</html>