<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tailwind Test</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div>
    <h1 class="text-5xl font-extrabold text-blue-600 underline shadow-lg bg-white p-8 rounded-xl">
        Hello Tailwind! bla bla blaa
    </h1>
    </div>
    <div>
    <p>This is a simple test to see if Tailwind CSS is working correctly in our Laravel project.</p>
    <p>If you can see the styled heading above, then Tailwind is set up properly!</p>
</div>
</body>
</html>