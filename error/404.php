<?php
    $pageTitle = __('Page Not Found');
    echo head(array('title'=>$pageTitle));
?>
    <main>
        <div class="banners">
            <img src="<?php echo img('page_banner_07.png'); ?>">
            <p class="caption">image detail from book titled etc.</p>
        </div>
        <div class="container-narrow">
            <h2>Are you lost in the Archive?</h2>
            <p><?php echo __('%s', html_escape($badUri)); ?> isn't a valid page.</p>
            <p><a href="/">Head back home.</a></p>
        </div>
    </main>
<?php echo foot(); ?>