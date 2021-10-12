<?php echo head(array('title' => metadata('exhibit', 'title'), 'bodyclass'=>'exhibits summary')); ?>

<!-- <h1><?php //echo metadata('exhibit', 'title'); ?></h1> -->
<?php 
    //echo exhibit_builder_page_nav();

    /** Set up variables based on page */
    /* TODO not this */
    $curPageName = substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);  
    $requestUri = $_SERVER['REQUEST_URI'];
    //$pageName = ltrim($requestUri, '/'); // strip the leading slash
    $pageName = strtolower($exhibit->title);

    $serverName = $_SERVER['SERVER_NAME'];
    $prod = false;
    $fileDir = '/files/theme_uploads/';
    if($serverName == 'eileensouthern.omeka.fas.harvard.edu'){
        $prod = true;
        $fileDir = 'https://s3.amazonaws.com/atg-prod-oaas-files/eileensouthern/theme_uploads/';
    }
    function getBanner($page, $fileDir){
        $banner_var = $page . '_banner';
        $bannerImg = get_theme_option($banner_var);
        if($bannerImg){
            $fullpath = $fileDir . $bannerImg;
            return $fullpath;
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
    // $image = getCoverImage();
    // $cover_image = record_image('exhibit', 'fullsize');
    // debug_to_console($cover_image);
    $banner = getBanner($pageName, $fileDir);
    if($banner):
    // if($cover_image):
    ?>
        <div class="banners">
            <?php //echo $cover_image; ?>
            <img src="<?php echo $banner; ?>">
            <p class="caption"><?php echo getBannerCaption($pageName); ?></p>
        </div>
    <?php endif; ?>
    <div id="primary" class="container-narrow">
        <h3 class="txt-center aos-init aos-animate" data-aos="fade-in"><?php echo metadata('exhibit', 'title'); ?></h3>
        <?php if ($exhibitDescription = metadata('exhibit', 'description', array('no_escape' => true))): ?>
        <div class="exhibit-description">
            <?php echo $exhibitDescription; ?>
        </div>
        <?php endif; ?>

        <?php if (($exhibitCredits = metadata('exhibit', 'credits'))): ?>
        <div class="exhibit-credits">
            <h4><?php echo __('Credits'); ?></h4>
            <p><?php echo $exhibitCredits; ?></p>
        </div>
        <?php endif; ?>
    </div>

    <?php
    //$pageTree = exhibit_builder_page_tree();
    // if ($pageTree):

    debug_to_console($exhibit);
    $pages = $exhibit->PagesByParent[0];
    debug_to_console($pages);
    if($pages):
    ?>
        <div class="container-wide">
            <div class="flex-column aos-init aos-animate" data-aos="fade-up">
            <?php 
            foreach($pages as $page):
                $block_attachments = $page->getAllAttachments();
                // $first_attachment = null;
                $file_uri = null;
                $recordUrl = $page->getRecordUrl();
                if($block_attachments){
                    $first_attachment_file = $block_attachments[0]->getFile();
                    $file_uri = $first_attachment_file->getWebPath();
                    $page_title = $page->title;
                }
                if( ($page->order + 1) % 3 == 0){
                    $right_rule = false;
                } else {
                    $right_rule = true;
                }
            ?>
                <div class="publications-container pub-column aos-init aos-animate <?php if($right_rule){ echo 'right-rule'; }?>" data-aos="fade-up">
                    <?php if($file_uri): ?>
                        <a href="<?php echo $page->getRecordUrl(); ?>">
                            <img alt="<?php echo($page_title); ?>" src="<?php echo($file_uri); ?>" title="<?php echo($page_title);?>">
                        </a>
                    <?php endif; ?>
                    <h3 class="txt-center">
                        <a href="<?php echo $page->getRecordUrl(); ?>" class="dark-red"><?php echo $page->title; ?></a>
                    </h3>
                </div>
            <?php endforeach; ?>
            </div>
        </div>
        <!-- <nav id="exhibit-pages"> -->
            <?php //echo $pageTree; ?>
        <!-- </nav> -->
    <?php endif; ?>
</main>


<?php echo foot(); ?>
