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

    $serverName = $_SERVER['SERVER_NAME'];
    $prod = false;
    $fileDir = '/files/theme_uploads/';
    if($serverName == 'eileensouthern.omeka.fas.harvard.edu'){
        $prod = true;
        $fileDir = 'https://s3.amazonaws.com/atg-prod-oaas-files/eileensouthern/theme_uploads/';
    }
    debug_to_console($fileDir);

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
        $banner = getBanner($pageName, $fileDir);
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

    <!-- TIMELINE events start -->
    <?php if($pageName == 'timeline'): ?>
    <div class="container-wide white-bg">
    <?php
        $event_records = get_records('Item', array('type'=>'Event'), 200);
        $event_tags = get_records('Item', array('tags'=>'Event'), 200);
        $events = array_merge($event_records, $event_tags);
        debug_to_console($events);

        function make_date_obj($dateStr){
            if(substr_count($dateStr, "-") == 2){
                // Full date 1994-04-07
                $date = DateTime::createFromFormat('!Y-m-d', $dateStr);
                return $date;
            } elseif(substr_count($dateStr, "-") == 1){
                // Month and year 1994-04
                $date = DateTime::createFromFormat("!Y-m-d", $dateStr . '-01');
                return $date;
            } elseif(substr_count($dateStr, "-") == 0) {
                // Year 1994
                $date = DateTime::createFromFormat("!Y-m-d", $dateStr . '-01-01');
                return $date;
            } else {
                return null;
            }
        }

        // Sort  
        function date_sort($a, $b) {
            $dateA = metadata($a, array('Dublin Core', 'Date'));
            $dateB = metadata($b, array('Dublin Core', 'Date'));

            $dateAObj = make_date_obj($dateA);
            $dateBObj = make_date_obj($dateB);

            return $dateAObj > $dateBObj;
        }
        usort($events, "date_sort");
        debug_to_console($events);
        // print_r($arr);
        // debug_to_console($events);

        function print_year($item){
            $omeka_date_str = metadata($item, array('Dublin Core', 'Date'));
            $date = make_date_obj($omeka_date_str);
            return $date->format('Y');
        }

        foreach ($events as $item):
            $file=null;
            if($item->getFile(0)){
                $file = get_record_by_id('File', $item->getFile(0)->id);
            }
    ?>
    <div class="timeline-item">
        <div class="timeline-image-container">
            <?php if($file): ?>
                <a class="item-link" href="<?php echo metadata($item, 'permalink');?>">
                    <img data-aos="fade-up" src="<?php echo metadata($file, 'thumbnail_uri');?>" class="aos-init aos-animate">
                </a>
            <?php endif; ?>
        </div>
        <div class="timeline-data-container">
            <h2 class="timeline-event-date">
                <?php echo print_year($item); ?>
            </h2>
            <div class="timeline-description">
                <?php echo metadata($item, array('Dublin Core', 'Description')); ?>
            </div>
        </div>
    </div>
    <?php endforeach;?> <!-- events loop -->
    </div><!-- .container-wide -->
    <?php endif;?> <!-- events end -->
</main>

<?php echo foot(); ?>
