<?php
/**
 * Default Layout - a Layout similar with the classic Header and Footer files.
 */

// Generate the Language Changer menu.
$language = Language::code();

$languages = Config::get('languages');

//
$html = '';

foreach ($languages as $code => $info) {
    // Make bold the name of curent Language
    $linkName = ($language == $code) ? '<b>' .$info['name'] .'</b>' : $info['name'];

    $html .= '<a href="' .site_url('language/' .$code) .'">' .$linkName .'</a> | ' .PHP_EOL;
}

$langMenu = rtrim(trim($html), ' |') .PHP_EOL;
?>
<!DOCTYPE html>
<html lang="<?php echo LANGUAGE_CODE; ?>">
<head>
    <meta charset="utf-8">
    <title><?= $title .' - ' .SITETITLE; ?></title>
<?php
echo $meta; // Place to pass data / plugable hook zone

Assets::css([
    'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css',
    'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css',
    'https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css',
    template_url('css/style.css', 'Default'),
]);

echo $css; // Place to pass data / plugable hook zone
?>
</head>
<body>
<?= $afterBody; // Place to pass data / plugable hook zone ?>

<div class="container">
    <p class="pull-right">
        <?= $langMenu; ?>
    </p>
    <div class="clearfix"></div>
    <p>
        <img src='<?= template_url('images/nova.png', 'Default'); ?>' alt='<?= SITETITLE; ?>'>
    </p>

    <?= $content; ?>
</div>

<?php
Assets::js([
    'https://code.jquery.com/jquery-1.12.1.min.js',
    'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js',
]);

echo $js; // Place to pass data / plugable hook zone
echo $footer; // Place to pass data / plugable hook zone
?>

</body>
</html>
