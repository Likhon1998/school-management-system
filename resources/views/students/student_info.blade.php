<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $student->student_name }} - Student Info</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: #f9f9f9;
        }

        .card {
            width: 400px;
            margin: 30px auto;
            border: 1px solid #ddd;
            border-radius: 12px;
            background: #fff;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            overflow: hidden;
            padding: 20px;
        }

        .header {
            background-color: #4CAF50;
            color: white;
            text-align: center;
            padding: 12px;
            font-size: 20px;
            font-weight: bold;
            border-radius: 8px 8px 0 0;
        }

        .photo {
            width: 120px;
            height: 140px;
            border: 1px solid #ccc;
            border-radius: 8px;
            overflow: hidden;
            margin: 15px auto;
        }

        .photo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .details {
            margin-top: 10px;
        }

        .details p {
            margin: 6px 0;
            font-size: 14px;
        }

        .details p strong {
            width: 120px;
            display: inline-block;
        }

        .footer {
            text-align: center;
            font-size: 12px;
            color: #777;
            margin-top: 15px;
        }

        .divider {
            border-top: 1px dashed #ccc;
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <div class="card">
        <div class="header">🌟 School Name 🌟</div>

        <div class="photo">
            @if($student->photo)
                <img src="{{ public_path('storage/' . $student->photo) }}" alt="Student Photo">
            @else
                <div style="text-align:center; padding-top:50px; color:#aaa;">No Photo</div>
            @endif
        </div>

        <div class="details">
            <p><strong>Name:</strong> {{ $student->student_name }}</p>
            <p><strong>Student ID:</strong> {{ $student->student_id }}</p>
            <p><strong>Class:</strong> {{ $student->class->class_name ?? '-' }}</p>
            <p><strong>Section:</strong> {{ $student->section->section_name ?? '-' }}</p>
            <p><strong>Roll No:</strong> {{ $student->roll_number ?? '-' }}</p>
            <p><strong>Admission No:</strong> {{ $student->admission_number }}</p>
            <p><strong>Admission Date:</strong> {{ $student->admission_date }}</p>
            <p><strong>Blood Group:</strong> {{ $student->blood_group ?? '-' }}</p>
            <p><strong>DOB:</strong> {{ $student->date_of_birth ?? '-' }}</p>
            <p><strong>Gender:</strong> {{ ucfirst($student->gender ?? '-') }}</p>
            <p><strong>Address:</strong> {{ $student->address ?? '-' }}</p>
            <p><strong>Parent Name:</strong> {{ $student->father_name ?? '-' }}</p>
            <p><strong>Parent Phone:</strong> {{ $student->father_phone ?? '-' }}</p>
            <p><strong>Status:</strong> {{ ucfirst($student->status) }}</p>
        </div>

        <div class="divider"></div>
        <div class="footer">Authorized by School Management</div>
    </div>
</body>
</html>
