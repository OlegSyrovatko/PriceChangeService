<!-- resources/views/subscribe.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subscribe</title>
</head>
<body>
<form action="{{ url('/subscribe') }}" method="post">
    @csrf
    <label for="url">URL:</label>
    <input type="text" name="url" id="url" required>
    <br>
    <label for="email">Email:</label>
    <input type="email" name="email" id="email" required>
    <br>
    <button type="submit">Subscribe</button>
</form>
</body>
</html>
