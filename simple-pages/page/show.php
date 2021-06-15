<?php echo head(array(
    'title' => metadata('simple_pages_page', 'title'),
    'bodyclass' => 'page simple-page',
    'bodyid' => metadata('simple_pages_page', 'slug')
));

/** Set up variables based on page */
$curPageName = substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);  
$requestUri = $_SERVER['REQUEST_URI'];
$pageName = ltrim($requestUri, '/'); // strip the leading slash

function getBanner($page){
    $banner_var = $page . '_banner';
    $banner = '/files/theme_uploads/' . get_theme_option($banner_var);
    return $banner;
}

function getBannerCaption($page){
    $caption_var = $page . '_banner_caption';
    $caption = get_theme_option($caption_var);
    return $caption;
}


?>
<!-- <p id="simple-pages-breadcrumbs" class="navigation secondary-nav"><?php echo simple_pages_display_breadcrumbs(); ?></p> -->

<main>
    <div class="banners">
        <img src="<?php echo getBanner($pageName); ?>">
        <p class="caption"><?php echo getBannerCaption($pageName); ?></p>
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
