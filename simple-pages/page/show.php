<?php echo head(array(
    'title' => metadata('simple_pages_page', 'title'),
    'bodyclass' => 'page simple-page',
    'bodyid' => metadata('simple_pages_page', 'slug')
));

/** Set up variables based on page */
$curPageName = substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);  
$requestUri = $_SERVER['REQUEST_URI'];
$bannerUri = '/themes/eileen-southern-theme/images/';
switch($requestUri){
    case '/about':
        $bannerUri .= 'page_banner_12.png';
        break;
}




?>
<!-- <h3 style="color:white"><?php echo $curPageName . ' ' . $_SERVER['REQUEST_URI']?></h3> -->
<!-- <p id="simple-pages-breadcrumbs" class="navigation secondary-nav"><?php echo simple_pages_display_breadcrumbs(); ?></p> -->
<main>
    <div class="banners">
        <img src="<?php echo $bannerUri; ?>">
        <p class="caption">Image caption ...</p>
    </div>
    <div class="container-narrow lengthen-page">
    <?php
        $text = metadata('simple_pages_page', 'text', array('no_escape' => true));
        echo $this->shortcodes($text);
    ?>
    </div>
</main>
<!-- <h1><?php echo metadata('simple_pages_page', 'title'); ?></h1>
<div id="primary">
    <?php
    $text = metadata('simple_pages_page', 'text', array('no_escape' => true));
    echo $this->shortcodes($text);
    ?>
</div> -->

<?php echo foot(); ?>
