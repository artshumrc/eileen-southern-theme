<?php 
    echo head(array('title' => 'Gallery','bodyclass' => 'item show'));

    function hasDerivativeImage($file){
      return $file->has_derivative_image == 1;
    }

    function isPDF($file){
      $types = array('application/pdf', 'application/x-pdf');
      return in_array($file->mime_type, $types);
    }

    $all_files = $item->getFiles();
    // filter out those without derivative images
    $files_with_derivatives = array_filter($all_files, "hasDerivativeImage");

    $featured_file=null;
    if(count($files_with_derivatives) > 0){
      $temp = array_shift($files_with_derivatives);
      $featured_file = get_record_by_id('File', $temp->id);
    }

    // Get PDFs from $all_files
    $pdf_files = array_filter($all_files, "isPDF");

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
                if(count($files_with_derivatives) > 0){
                  echo file_markup(
                    $files_with_derivatives,
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
          <?php if (count($pdf_files) > 0): ?>
            <div class="pdf-files">
              <?php echo file_markup($pdf_files); ?>
            </div>
          <?php endif; ?>
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
