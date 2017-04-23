<!DOCTYPE html>
<html>
<head>
    <?php if(isset($redirectUrl)): ?>
        <meta http-equiv="refresh" content="1;url=<?php echo $redirectUrl; ?>">
    <?php endif; ?>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Redirect...</title>
    <style>
        h1 {
            font-family: Calibri, Consolas, Arial, sans-serif;
        }
    </style>
</head>
<body>
    <p>Redirect in 1s...</p>