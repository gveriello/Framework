<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <?= Allocator::allocate_css("bootstrap.min"); ?>
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
        <input type="text" name="bho" value="" binding="ciao" />
        <input type="text" name="bho2" value="" />
        <input type="submit" value="press" />
        <?= $validator; ?>
    </form>
    <?= $table; ?>
    <?= $response; ?>
    <?= JavascriptHelper::allocate_jquery(); ?>
    <?= Allocator::allocate_js("bootstrap.min"); ?>
</body>
<?= JavascriptHelper::set_value('bho', 'binding', 'binding avvenuto'); ?>
</html>