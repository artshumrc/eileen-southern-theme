<?php echo head(array('title' => metadata('exhibit', 'title'), 'bodyclass'=>'exhibits summary')); ?>

<!-- <h1><?php //echo metadata('exhibit', 'title'); ?></h1> -->
<?php //echo exhibit_builder_page_nav(); ?>

<main>
    <?php
    // $image = getCoverImage();
    $cover_image = record_image('exhibit', 'fullsize');
    debug_to_console($cover_image);
    if($cover_image):
    ?>
        <div class="banners">
            <?php echo $cover_image; ?>
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
                debug_to_console($page);
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
        <!-- <nav id="exhibit-pages"> -->
            <?php //echo $pageTree; ?>
        <!-- </nav> -->
    <?php endif; ?>
</main>


<?php echo foot(); ?>
