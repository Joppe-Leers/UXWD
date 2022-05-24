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
    <link rel="stylesheet" href="<?= base_url()?>/css/fonts.css">

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <style>body { font-family: 'Dosis', monospace; }</style>

    <?php if (isset($scripts_to_load)) foreach ($scripts_to_load as $script): ?>
        <script src="<?= base_url()?>/js/<?=$script?>?v=11" defer></script>
    <?php endforeach; ?>
    <?php if (isset($scripts_to_load_from_net)) foreach ($scripts_to_load_from_net as $script): ?>
        <script src="<?=$script?>" defer></script>
    <?php endforeach; ?>
</head>

<body class="d-flex flex-column font-dark bg-primary">
    <header class="navbar fixed-top py-0 text-secondary bg-primary">
        <?php if(isset($back_route)):?>
            <a href="<?= base_url()?>/<?=$back_route?>"><span class="material-icons my-auto" style="font-size:45px; color: #FAFEFD" id="header_icon_1"><?=$header_icon_1?></span></a>
        <?php else:?>
            <span class="material-icons my-auto" style="font-size:45px; color: #FAFEFD" id="header_icon_1"><?=$header_icon_1?></span>
        <?php endif;?>
        <h3 class="my-auto"><?=$title?></h3>
        <a class="d-flex align-items-center" href="<?= base_url()?>/search"><span class="material-icons my-auto text-secondary" style="font-size:45px;" id="header_icon_2"><?=$header_icon_2?></span></a>
    </header>
    <main id="wrap" class="bg-secondary">
        <div class="main-content w-100 container-fluid py-1 inner d-flex flex-column align-items-center">
            <?=$content?>
        </div>
    </main>
    <footer>
        <nav class="navbar fixed-bottom bg-primary">
            <?php foreach ($menu_items as $menu): ?>
                <a href="<?= base_url()?>/<?=$menu['link']?>" id="<?=$menu['id']?>" class="<?=$menu['className']?> d-flex align-items-center"><span class="material-icons " ><?=$menu['iconName']?></span></a>
            <?php endforeach; ?>
        </nav>
    </footer>
</body>
<input type="hidden" id="hidden_base_url" value="<?=$base_url?>"/>
</html>
