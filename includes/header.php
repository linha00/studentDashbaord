<!-- header.php -->
<!-- This is used for page navigations, feel free to change -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? $pageTitle : 'NUSGS Test Page'; ?></title>
    <link rel="stylesheet" href="css/style.css"> <!-- Your stylesheet -->
</head>
<body>
<header>
    <h1>NUSGS Test Website</h1>
    <nav>
        <div>
            <a href="/index.php">Home</a>
            <a href="/form.php">Form</a>
        </div>
    </nav>
</header>