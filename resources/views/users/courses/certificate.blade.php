<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Certificate of Excellence</title>
    <style>
        @page {
            size: landscape;
            margin: 0;
        }
        
        body {
            font-family: 'Georgia', serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
            /* Force landscape orientation */
            min-height: 100vh;
            min-width: 100vw;
        }
        
        .certificate-container {
            width: 100%;
            height: 100vh;
            margin: 0 auto;
            position: relative;
            overflow: hidden;
            /* Ensure landscape orientation */
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .certificate {
            width: 1050px;
            height: 750px;
            background: linear-gradient(to right, #ffffff, #f9f9f9);
            border: none;
            box-shadow: 0 0 25px rgba(0, 0, 0, 0.1);
            position: relative;
            /* Force landscape aspect ratio */
            aspect-ratio: 1.4 / 1;
        }
        
        .certificate-border {
            position: absolute;
            top: 20px;
            left: 20px;
            right: 20px;
            bottom: 20px;
            border: 2px solid #0C4B33;
            box-shadow: inset 0 0 0 1px #0C4B33;
        }
        
        .certificate-frame {
            position: absolute;
            top: 30px;
            left: 30px;
            right: 30px;
            bottom: 30px;
            border: 3px double #0C4B33;
            padding: 40px;
            background-image: url("/api/placeholder/1050/750");
            background-size: cover;
            background-blend-mode: overlay;
            background-color: rgba(255, 255, 255, 0.95);
        }
        
        .corner {
            position: absolute;
            width: 50px;
            height: 50px;
            border: 5px solid #0C4B33;
        }
        
        .top-left {
            top: 10px;
            left: 10px;
            border-right: none;
            border-bottom: none;
        }
        
        .top-right {
            top: 10px;
            right: 10px;
            border-left: none;
            border-bottom: none;
        }
        
        .bottom-left {
            bottom: 10px;
            left: 10px;
            border-right: none;
            border-top: none;
        }
        
        .bottom-right {
            bottom: 10px;
            right: 10px;
            border-left: none;
            border-top: none;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .title {
            font-size: 48px;
            color: #0C4B33;
            font-family: 'Georgia', serif;
            letter-spacing: 3px;
            text-transform: uppercase;
            margin-bottom: 5px;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1);
        }
        
        .subtitle {
            font-size: 24px;
            color: #555;
            font-style: italic;
            margin: 15px 0 40px;
        }
        
        .name {
            font-size: 42px;
            font-weight: bold;
            color: #333;
            margin: 40px 0;
            font-family: 'Times New Roman', Times, serif;
            border-bottom: 2px solid #0C4B33;
            display: inline-block;
            padding: 0 40px 10px;
        }
        
        .course {
            font-size: 28px;
            margin: 20px 0;
            color: #444;
        }
        
        .course-name {
            font-size: 32px;
            font-weight: bold;
            color: #0C4B33;
            margin: 15px 0 40px;
        }
        
        .date {
            font-size: 20px;
            margin-top: 80px;
            font-style: italic;
            color: #555;
        }
        
        .signature {
            width: 200px;
            margin: 60px auto 0;
            text-align: center;
        }
        
        .signature-line {
            border-top: 1px solid #333;
            margin-bottom: 10px;
        }
        
        .signature-title {
            font-size: 16px;
            color: #555;
        }
        
        .stamp {
            position: absolute;
            bottom: 80px;
            right: 80px;
            width: 130px;
            height: 130px;
            background: linear-gradient(45deg, #0C4B33, #198754);
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            transform: rotate(-15deg);
            opacity: 0.7;
            border: 2px dashed #fff;
        }
        
        .stamp-text {
            color: white;
            font-weight: bold;
            font-size: 16px;
            text-align: center;
        }
        
        .ribbon {
            position: absolute;
            top: 0;
            right: 50px;
            width: 40px;
            height: 120px;
            background-color: #0C4B33;
            box-shadow: -2px 0 5px rgba(0, 0, 0, 0.1);
        }
        
        .ribbon:before {
            content: '';
            position: absolute;
            bottom: -20px;
            left: 0;
            width: 0;
            height: 0;
            border-style: solid;
            border-width: 0 20px 20px 20px;
            border-color: transparent #0C4B33 transparent #0C4B33;
        }
        
        .ornament {
            position: absolute;
            width: 200px;
            height: 60px;
            border: 3px solid #0C4B33;
            border-radius: 30px;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            opacity: 0.1;
        }

        /* Clean up print settings */
        @media print {
            @page {
                size: landscape;
                margin: 0;
            }
            
            body {
                margin: 0;
                padding: 0;
                width: 100%;
                height: 100%;
            }
            
            .certificate-container {
                width: 100%;
                height: 100%;
                margin: 0;
                padding: 0;
            }
            
            .certificate {
                width: 100%;
                height: 100%;
                box-shadow: none;
            }
        }
    </style>
</head>
<body>
    <div class="certificate-container">
        <div class="certificate">
            <div class="certificate-border"></div>
            <div class="certificate-frame">
                <div class="corner top-left"></div>
                <div class="corner top-right"></div>
                <div class="corner bottom-left"></div>
                <div class="corner bottom-right"></div>
                
                <div class="ornament"></div>
                <div class="ribbon"></div>
                
                <div class="header">
                    <div class="title">Certificate of Excellence</div>
                    <div class="subtitle">Is Proudly Presented To</div>
                </div>
                
                <div style="text-align: center;">
                    <div class="name">{{ $user->name }}</div>
                    
                    <div class="course">For successfully completing with distinction</div>
                    <div class="course-name">{{ $course->course_name }}</div>
                    
                    <div class="date">Awarded on {{ $date }}</div>
                </div>
                
                <div class="stamp">
                    <div class="stamp-text">OFFICIALLY CERTIFIED</div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>