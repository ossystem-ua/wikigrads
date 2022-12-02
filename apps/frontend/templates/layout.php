<?php header('P3P: CP="IDC DSP COR ADM DEVi TAIi PSA PSD IVAi IVDi CONi HIS OUR IND CNT"'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <title>WikiGrads | <?php echo $sf_response->getTitle() ?></title>
    <link rel="shortcut icon" href="<?php echo image_path('favicon.ico')?>" />
    <?php include_http_metas() ?>
    <?php include_metas() ?>
    <meta property="og:title" content="WikiGrads | Academic Network" />
    <meta property="og:image" content="http://wikigrads.ossystem.com.ua/images/new_design/logo_media.png" />
    <meta property="og:description" content="Energize and expand classroom teaching and learning seamlessly." />
    <meta property="og:url" content="http://wikigrads.ossystem.com.ua" />
    <script src="/js/lib/jquery.js"></script>
    <script type="text/javascript" src="/js/lib/bootstrap.js"></script>
    <script type="text/javascript" src="/js/lib/bootstrap-tour.js"></script>
    <?php include_stylesheets(); ?>
</head>
<body>
    <div id="wiki-output-border">
        <?php include_component('main', 'wikiHeader') ?>
        <div id="wiki-block-main">

            <?php /*include_component('main', 'wikiContent')/**/ ?>

            <div id="wiki-content-main">
                <?php echo $sf_content ?>
            </div>

        </div>
        <?php include_component('main', 'wikiFooter') ?>
        <div class="clear-footer"></div>

        <?php include_javascripts(); ?>
        <div id="showWinLoad">
            <div>
                <img src="/images/loading.gif" />
            </div>
        </div>
    </div>
</body>
</html>