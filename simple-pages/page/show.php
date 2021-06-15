<?php
    echo head(array(
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
        $banner = get_theme_option($banner_var);
        if($banner){
            return '/files/theme_uploads/' . $banner;
        } else {
            return false;
        }
    }

    function getBannerCaption($page){
        $caption_var = $page . '_banner_caption';
        $caption = get_theme_option($caption_var);
        return $caption;
    }
?>

<main>
    <?php
        $banner = getBanner($pageName);
        if($banner):
    ?>
    <div class="banners">
        <img src="<?php echo $banner; ?>">
        <p class="caption"><?php echo getBannerCaption($pageName); ?></p>
    </div>

    <?php
        endif; // the banner
        $text = metadata('simple_pages_page', 'text', array('no_escape' => true));
        echo $this->shortcodes($text);
    ?>
</main>

<?php echo foot(); ?>
