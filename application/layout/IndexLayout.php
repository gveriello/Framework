<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>
        <?= $title; ?>
    </title>
</head>
<body>
    <?= $error; ?>
    <h1>
        Benvenuto in <?= $title; ?>
    </h1>
    <form method="post" action="<?= redirect_page('index', 'cosimo'); ?>">
        <input type="text" name="bho" value="" />
        <input type="text" name="bho2" value="" />
        <input type="submit" value="press"/>
        <?= $validator; ?>
    </form>
    <?= $table; ?>
    <?= $response; ?>
</body>
</html>