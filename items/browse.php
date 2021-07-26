<?php
    $pageTitle = __('Gallery');
    echo head(array('title'=>$pageTitle,'bodyclass' => 'items browse'));
?>

<?php // echo pagination_links(); ?>

<main>
    
    <?php
        // From the admin theme config
        $gallery_text = get_theme_option('Gallery Text');
        if($gallery_text){
            echo($gallery_text);
        }  
    ?>
    <div class="container-wide">
        <div class="flex-column gallery-container">
            <?php foreach (loop('items') as $item): ?>
            <?php 
                debug_to_console($item);
                $file=null;
                if($item->getFile(0)){
                    $file = get_record_by_id('File', $item->getFile(0)->id);
                }
            ?>
            <div class="tri-column gallery-column item">
                <a href="<?php echo metadata('item', 'permalink');?>">
                    <div class="gallery-img-container" style="background-image: url(<?php if($file){ echo metadata($file, 'square_thumbnail_uri');}?>)"></div>
                </a>
                <h5 class="gallery-category">
                    <?php echo metadata('item', array('Dublin Core', 'Format')); ?>
                </h5>
                <p class="gallery-title">
                    <?php echo link_to_item(); ?>
                </p>

                <?php fire_plugin_hook('public_items_browse_each', array('view' => $this, 'item' =>$item)); ?>

            </div><!-- end class="item" -->
            <?php endforeach; ?>
        </div><!-- end gallery-container -->
    </div><!-- end container-wide -->
</main>

<?php //echo pagination_links(); ?>

<!-- <div id="outputs">
    <span class="outputs-label"><?php echo __('Output Formats'); ?></span>
    <?php //echo output_format_list(false); ?>
</div> -->

<?php fire_plugin_hook('public_items_browse', array('items'=>$items, 'view' => $this)); ?>

<?php echo foot(); ?>
