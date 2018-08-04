<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>
        <?= $title; ?>
    </title>
</head>
<body>
    <h1>
        Benvenuto in <?= $title; ?>
    </h1>
    <form method="get" action="<?= RedirectPage('login'); ?>">
        <input type="text" name="bho" value="ciao" />
        <input type="submit" value="press"/>
    </form>
    <?= $table; ?>
</body>
</html>