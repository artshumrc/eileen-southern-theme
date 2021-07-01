<?php
echo head(array(
    // 'title' => metadata('exhibit_page', 'title') . ' &middot; ' . metadata('exhibit', 'title'),
    'title' => metadata('exhibit', 'title'),
    'bodyclass' => 'exhibits show'));
    $exhibitNavOption = get_theme_option('exhibits_nav');

    $slugMap = array(
        "the-music-of-black-americans" => "scholarship_moba_banner",
        "the-black-perspective-in-music" => "scholarship_black_perspective_banner",
        "renaissance-scholarship" => "scholarship_renaissance_banner",
        "interviews" => "interviews_banner"
    );

    debug_to_console($this);

    // Prod or local - S3 plugin
    $serverName = $_SERVER['SERVER_NAME'];
    $prod = false;
    $fileDir = '/files/theme_uploads/';
    if($serverName == 'eileensouthern.omeka.fas.harvard.edu'){
        $prod = true;
        $fileDir = 'https://s3.amazonaws.com/atg-prod-oaas-files/eileensouthern/theme_uploads/';
    }

    // which exhibit?
    $interviews = false;
    if($exhibit_page->slug == 'interviews'){
        $interviews = true;
    }

    function getBanner($exhibitPage, $slugMap, $fileDir){
        // debug_to_console("getBanner");
        //debug_to_console($exhibitPage);
        $config_var_name = $slugMap[$exhibitPage->slug];
        $banner = get_theme_option($config_var_name);
        // debug_to_console($banner);
        // debug_to_console(img($banner));
        if($banner){
            $fullpath = $fileDir . $banner;
            return $fullpath;
        } else {
            return false;
        }
    }

    function getBannerCaption($exhibitPage, $slugMap){
        $config_var_name = $slugMap[$exhibitPage->slug] . "_caption";
        $caption = get_theme_option($config_var_name);
        return $caption;
    }

    

    /**
     * Render the markup for an exhibit page.
     *
     * @param ExhibitPage|null $exhibitPage
     */
    function exhibit_builder_render_exhibit_page_southern($exhibitPage = null)
    {
        if ($exhibitPage === null) {
            $exhibitPage = get_current_record('exhibit_page');
        }
        
        $blocks = $exhibitPage->ExhibitPageBlocks;
        $rawAttachments = $exhibitPage->getAllAttachments();
        $attachments = array();
        foreach ($rawAttachments as $attachment) {
            $attachments[$attachment->block_id][] = $attachment;
        }
        foreach ($blocks as $index => $block) {
            $layout = $block->getLayout();
            // debug_to_console($layout->getViewPartial()); //exhibit_layouts/file-text/layout.php
            echo '<div class="exhibit-block layout-' . html_escape($layout->id) . '">';
            echo get_view()->partial($layout->getViewPartial(), array(
                'index' => $index,
                'options' => $block->getOptions(),
                'text' => get_view()->shortcodes($block->text),
                'attachments' => array_key_exists($block->id, $attachments) ? $attachments[$block->id] : array(),
                'block' => $block,
            ));
            echo '</div>';
        }
    }
?>

<main>
    <?php if(getBanner($exhibit_page, $slugMap, $fileDir))?>
    <div class="banners">
        <img src="<?php echo getBanner($exhibit_page, $slugMap, $fileDir); ?>" >
        <p class="caption"><?php echo getBannerCaption($exhibit_page, $slugMap); ?></p>
    </div>
    <?php if($interviews): ?>
    <div class="container-wide">
    <div class="container-wide clear-bg">
    <?php else: ?>
    <div class="container-narrow">
        <h3 class="txt-center aos-init aos-animate" data-aos="fade-in"><?php echo metadata('exhibit_page', 'title');?></h3>
    <?php endif;?>
        <?php if ($exhibitNavOption == 'full'): ?>
        <nav id="exhibit-pages" class="full">
            <?php echo exhibit_builder_page_nav(); ?>
        </nav>
        <?php endif; ?>

        <!-- <h1><span class="exhibit-page"><?php echo metadata('exhibit_page', 'title'); ?></span></h1> -->

        <?php if (count(exhibit_builder_child_pages()) > 0 && $exhibitNavOption == 'full'): ?>
            <nav id="exhibit-child-pages" class="secondary-nav">
                <?php echo exhibit_builder_child_page_nav(); ?>
            </nav>
        <?php endif; ?>

        <div role="main" id="exhibit-blocks">
            <?php exhibit_builder_render_exhibit_page_southern(); ?>
        </div>
        <?php if($interviews){ echo '</div>'; } ?>
    </div><!-- end div container-wide or container-narrow -->

    <?php
        debug_to_console($exhibit_page);
        // debug_to_console($exhibit);
        $pages = $exhibit->PagesByParent[0];
        // debug_to_console($pages);

        // Filter the current page from the nav
        $filtered = array_filter($pages, function($page) use($exhibit_page){
            return($exhibit_page->slug != $page->slug);
        });
        // debug_to_console($filtered);

        if($filtered):
        ?>
        <div class="container-wide southern-exhibit-nav">
            <div class="flex-column aos-init aos-animate" data-aos="fade-up">
            <?php 
            foreach($filtered as $page):
                // debug_to_console($page);
                $block_attachments = $page->getAllAttachments();
                $first_attachment = null;
                if($block_attachments){
                    $first_attachment = $this->exhibitAttachment($block_attachments[0], array('imageSize' => 'fullsize'));
                }
                if( ($page->order + 1) % 3 == 0){
                    $right_rule = false;
                } else {
                    $right_rule = true;
                }
            ?>
                <div class="publications-container pub-column aos-init aos-animate <?php if($right_rule){ echo 'right-rule'; }?>" data-aos="fade-up">
                    <?php if($first_attachment): ?>
                        <a href="<? echo $page->getRecordUrl(); ?>">
                            <?php echo $first_attachment; ?>
                        </a>
                    <?php 
                    endif; ?>
                    <h3 class="txt-center">
                        <a href="<? echo $page->getRecordUrl(); ?>" class="dark-red"><?php echo $page->title; ?></a>
                    </h3>
                </div>
            <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>
</main>


<?php echo foot(); ?>
