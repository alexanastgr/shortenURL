<?php

require_once 'inc/database.php';

$shortURL = "";

/**
 * Generates a random string
 *
 * @param int $length The length of the generated string.
 * @return string The shortened URL key.
 */
function shortenURL($length = 6)
{
    return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
}

// check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['long'])) {
    $long_url = trim($_POST['long']);
    $short_code = shortenURL();

    // insert using PDO prepared statement
    $stmt = $pdo->prepare("INSERT INTO urls (long_url, short_code) VALUES (:long_url, :short_code)");
    $stmt->execute([
        ':long_url' => $long_url,
        ':short_code' => $short_code
    ]);

    // for demo purpose, replace with your domain
    $shortURL =  "http://yourdomain.com/$short_code";
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="icon" href="favicon.svg" type="image/svg+xml">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <title>ShortURL</title>
</head>

<body>
    <div class="relative flex min-h-screen text-gray-800 antialiased flex-col justify-center overflow-hidden bg-gray-100 py-6 sm:py-12">
        <form method="POST" class="relative py-3 sm:w-96 mx-auto text-center">
            <span class="text-2xl font-light ">Short Your URL</span>
            <div class="mt-4 bg-white shadow-md rounded-lg text-left">
                <div class="h-2 bg-[#00d26a] rounded-t-md"></div>
                <div class="px-8 py-6 ">
                    <label class="block font-semibold">Enter URL</label>
                    <input name="long" type="text" required placeholder="https://somedomain.com" class="border w-full h-5 px-3 py-5 mt-2 hover:outline-none focus:outline-none focus:ring-indigo-500 focus:ring-1 rounded-md">

                    <label class="block font-semibold mt-2">Shorted URL</label>
                    <input value="<?= $shortURL; ?>type=" text" disabled class="border w-full h-5 px-3 py-5 mt-2 hover:outline-none focus:outline-none focus:ring-indigo-500 focus:ring-1 rounded-md">
                    <div class="flex justify-between items-baseline">
                        <button type="submit" class="mt-4 w-full bg-[#00d26a] text-white py-2 px-6 rounded-md hover:bg-[#00B058]">Short</button>
                    </div>
                </div>

            </div>
        </form>

</body>

</html>