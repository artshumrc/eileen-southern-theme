<?php echo head(array(
    'title' => metadata('simple_pages_page', 'title'),
    'bodyclass' => 'page simple-page',
    'bodyid' => metadata('simple_pages_page', 'slug')
));

/** Set up variables based on page */
$curPageName = substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);  
$requestUri = $_SERVER['REQUEST_URI'];
$bannerUri = '';
switch($requestUri){
    case '/about':
        $bannerUri = 'images/page_banner_12.png';
        break;
}




?>
<h3 style="color:white"><?php echo $curPageName . ' ' . $_SERVER['REQUEST_URI']?></h3>
<p id="simple-pages-breadcrumbs" class="navigation secondary-nav"><?php echo simple_pages_display_breadcrumbs(); ?></p>
<h1><?php echo metadata('simple_pages_page', 'title'); ?></h1>
<div id="primary">
    <?php
    $text = metadata('simple_pages_page', 'text', array('no_escape' => true));
    echo $this->shortcodes($text);
    ?>
</div>

<?php echo foot(); ?>
