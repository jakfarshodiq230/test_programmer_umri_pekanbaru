<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Email</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .email-container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 400px;
            width: 100%;
        }

        .email-content h1 {
            font-size: 24px;
            color: #333333;
        }

        .email-content p {
            font-size: 16px;
            color: #666666;
            margin: 10px 0 20px;
        }

        .verify-button {
            display: inline-block;
            background-color: #4CAF50;
            color: #ffffff;
            padding: 15px 25px;
            font-size: 16px;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .verify-button:hover {
            background-color: #45a049;
        }
    </style>
</head>

<body>
    <div class="email-container">
        <div class="email-content">
            <h1>Verifikasi Alamat Email Anda</h1>
            <p>Terima kasih telah mendaftar! Silakan klik tombol di bawah ini untuk memverifikasi alamat email Anda:</p>
            <a href="{{$data['link']}}" class="verify-button">Verifikasi Email</a>
        </div>
    </div>
</body>

</html>
