<?php
$position = isset($options['file-position'])
    ? html_escape($options['file-position'])
    : ''; //setting default to none instead of left
$size = isset($options['file-size'])
    ? html_escape($options['file-size'])
    : 'fullsize';
$captionPosition = isset($options['captions-position'])
    ? html_escape($options['captions-position'])
    : 'center';
?> <!-- TODO remove publications-container and move it to a new layout? -->
<div class="exhibit-items <?php echo $position; ?> <?php echo $size; ?> captions-<?php echo $captionPosition; ?> publications-container single-pub-page aos-init aos-animate" data-aos="fade-up">
    <?php foreach ($attachments as $attachment): ?>
        <?php echo $this->exhibitAttachment($attachment, array('imageSize' => $size)); ?>
    <?php endforeach; ?>
</div>
<?php echo $text; ?>
