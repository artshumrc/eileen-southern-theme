<?php 
    echo head(array('title' => 'Gallery','bodyclass' => 'item show'));
    $featured_file=null;
    if($item->getFile(0)){
        $featured_file = get_record_by_id('File', $item->getFile(0)->id);
    }
      $files = $item->getFiles();
      debug_to_console("FILES");
      debug_to_console($files);

    all_element_texts('item', array(
        'show_element_set_headings' => false,
        'partial' => 'common/southern-metadata.php',
    ))
?>
<main>
    <div class="container-wide">
        <div class="flex-column">
          <div class="gallery-image-single">
            <a data-lightbox="<?php echo 'lightbox-item-' . $item->id; ?>" href="<?php if($featured_file){ echo metadata($featured_file, 'fullsize_uri');}?>">
              <img data-aos="fade-up" src="<?php if($featured_file){ echo metadata($featured_file, 'fullsize_uri');}?>">
            </a>
            <div class="all-item-images">
              <?php
                $other_files = array_slice($files, 1);
                if(count($other_files) > 0){
                  echo file_markup(
                    $other_files,
                    array(
                      'imageSize' => 'square_thumbnail',
                      'linkAttributes' => array(
                        'rel' => 'lightbox',
                        'data-lightbox' => 'lightbox-item-' . $item->id
                      )
                    )
                  );
                }
              ?>
          </div>
          </div>
          <div class="gallery-description-single">
            <h6>Object <?php echo $item->id . '/' . total_records('Item');?> </h6>
            <h4><?php echo metadata('item', 'display_title');?></h4>
            <h5 class="gallery-category"><?php echo metadata('item', array('Dublin Core', 'Format')); ?></h5>
            <?php if(metadata('item', array('Dublin Core', 'Description'))): ?>
                <div class="gallery-description">
                    <?php echo metadata('item', array('Dublin Core', 'Description')); ?>
                </div>
            <?php endif; ?>
            <div class="gallery-data-container">
                <?php
                    echo all_element_texts('item', array(
                        'show_element_set_headings' => false,
                        'partial' => 'common/southern-metadata.php',
                    ));
                ?>
            </div>
          </div>

          <div class="sub-nav">
            <h6><?php echo link_to_previous_item_show('← Previous'); ?></h6>
            <a href="/items/browse"><img src="<?php echo img('thumb-icon.svg'); ?>"></a>
            <h6><?php echo link_to_next_item_show('Next →'); ?></h6>
          </div>
        </div>
      </div>

</main>

<?php fire_plugin_hook('public_items_show', array('view' => $this, 'item' => $item)); ?>

<?php echo foot(); ?>
