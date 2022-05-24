<!DOCTYPE html>
<html lang="en">

<head>
    <title>SNAPP nature</title>
    <meta charset="UTF-8" />
    <meta name="keywords" content="Animals Plants Nature Social media" />
    <meta name="description" content="This website is a social madia like page where you can share your observations from nature with your friends and the world" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="<?= base_url()?>/css/bootstrap.css">
    <link rel="stylesheet" href="<?= base_url()?>/css/main.css">
    <link rel="stylesheet" href="<?= base_url()?>/css/reusable.css">

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Dosis:wght@500&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <?php if (isset($scripts_to_load)) foreach ($scripts_to_load as $script): ?>
        <script src="<?= base_url()?>/js/<?=$script?>?v=10" defer></script>
    <?php endforeach; ?>

    <style>
        #wrap {
            width: 100%;
            position: relative;
        }

        .inner {
            position: relative;
            z-index: 2;
        }

        #wrap:after {
            content: "\EA35";
            font-family: "Material Icons";
            font-style: normal;
            font-weight: normal;
            text-decoration: inherit;
            position: fixed;
            font-size: 500px;
            color: #E5F4F1;
            top: 30%;
            left: 60%;
            margin: -300px 0 0 -200px;
            z-index: 1;
        }

    </style>

</head>

<body class="container-fluid justify-content-center d-flex flex-column mx-auto bg-secondary" style="max-width:400px; height:100vh">
<main id="wrap">
    <div class="inner">
        <?=$content?>
    </div>
</main>
<footer>
    <p class="mt-5 mb-3 text-muted text-center">&copy; 2020 UXWD Team 6</p>
</footer>
</body>

</html>
