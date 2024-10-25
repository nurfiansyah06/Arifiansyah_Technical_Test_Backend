<!DOCTYPE html>
<html>
<head>
    <title>Welcome to Our Platform</title>
    <style>
        /* General reset */
        * {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        /* Container */
        .container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            background-color: #ffffff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        /* Header */
        .header {
            text-align: center;
            background-color: #4CAF50;
            color: #ffffff;
            padding: 20px;
            border-radius: 8px 8px 0 0;
        }

        .header h1 {
            font-size: 24px;
        }

        /* Content */
        .content {
            padding: 20px;
            line-height: 1.6;
            color: #333333;
        }

        .content p {
            margin: 10px 0;
        }

        /* Footer */
        .footer {
            text-align: center;
            font-size: 12px;
            color: #777777;
            margin-top: 20px;
            padding: 10px;
            border-top: 1px solid #e0e0e0;
        }

        /* Button */
        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            margin-top: 20px;
        }

        .button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>Welcome to Our Platform!</h1>
        </div>

        <!-- Content -->
        <div class="content">
            <p>Hello,</p>
            <p>We are excited to let you know that a new user has been successfully added to our platform!</p>
            <p><strong>Your Username:</strong> {{ $username }}</p>
            <p><strong>Your Password:</strong> {{ $password }}</p>

            <a href="https://yourplatform.com/login" class="button">Log in Now</a>

            <p>If you have any questions, feel free to contact our support team.</p>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>&copy; {{ date('Y') }} Your Platform. All rights reserved.</p>
            <p><a href="https://yourplatform.com/unsubscribe" style="color: #4CAF50;">Unsubscribe</a></p>
        </div>
    </div>
</body>
</html>
