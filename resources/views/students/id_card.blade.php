<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $student->student_id }} - ID Card</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f0f4f8;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .id-card {
            width: 360px;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 6px 18px rgba(0,0,0,0.25);
            background-color: #ffffff;
            display: flex;
            flex-direction: column;
            border: 1px solid #ddd;
        }

        /* Header */
        .header {
            background-color: #2f855a;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-weight: bold;
            font-size: 14px;
            padding: 8px 12px;
        }

        .header span {
            font-size: 13px;
            font-weight: normal;
        }

        /* Body */
        .body {
            display: flex;
            padding: 12px;
            border-bottom: 1px solid #e5e5e5;
            align-items: center; /* ✅ Vertically center photo + info */
        }

        /* Photo */
        .photo-section {
            flex: 0 0 90px;
        }

        .photo {
            width: 90px;
            height: 110px;
            border-radius: 6px;
            object-fit: cover;
            border: 1px solid #ccc;
        }

        /* Info */
        .info {
            flex: 1;
            margin-left: 15px;
            font-size: 13px;
            color: #333;
        }

        .info p {
            margin: 3px 0;
        }

        .info strong {
            color: #2f855a;
        }

        /* Footer Button */
        .footer {
            padding: 10px;
            text-align: center;
        }

    </style>
</head>
<body>
    <div class="id-card">
        <!-- Header -->
        <div class="header">
            <div>SCHOOL NAME</div>
            <span>STUDENT ID CARD</span>
        </div>

        <!-- Body -->
        <div class="body">
            <!-- Photo -->
            <div class="photo-section">
                <img src="{{ $student->photo ? public_path('storage/' . $student->photo) : public_path('images/default-avatar.png') }}" 
                     class="photo" alt="Student Photo">
            </div>

            <!-- Info -->
            <div class="info">
                <p><strong>Name:</strong> {{ $student->student_name }}</p>
                <p><strong>ID:</strong> {{ $student->student_id }}</p>
                <p><strong>Gov ID:</strong> {{ $student->government_id ?? '-' }}</p>
                <p><strong>Class:</strong> {{ $student->class->class_name ?? '-' }}</p>
                <p><strong>Section:</strong> {{ $student->section->section_name ?? '-' }}</p>
                <p><strong>Year:</strong> {{ $student->academicYear->year_name ?? '-' }}</p>
            </div>
        </div>
    </div>
</body>
</html>
