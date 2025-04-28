<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout Confirmation</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f8f9fa;
        }
        .logout-box {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.15);
            text-align: center;
            width: 350px;
        }
        .logout-box h2 {
            margin-bottom: 25px;
            font-size: 20px;
        }
        .logout-box button {
            margin: 10px;
            padding: 12px 24px;
            border: none;
            cursor: pointer;
            font-size: 18px;
            border-radius: 5px;
            transition: 0.3s;
        }
        .btn-logout {
            background-color: #dc3545;
            color: white;
        }
        .btn-cancel {
            background-color: #6c757d;
            color: white;
        }
        .btn-logout:hover { background-color: #c82333; }
        .btn-cancel:hover { background-color: #5a6268; }
    </style>
</head>
<body>

<div class="logout-box">
    <h2>Are you sure you want to log out?</h2>
    <form id="logout-form" action="{{ route('logout') }}" method="POST">
    @csrf
    <button type="submit">Logout</button>
</form>
        <button type="button" class="btn-cancel" onclick="window.history.back();">Cancel</button>
    </form>
</div>

</body>
</html> -->
