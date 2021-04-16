<?php echo head(array('bodyid'=>'home', 'bodyclass' =>'two-col')); ?>

<header>
    <h1 class="page-title txt-center index-title" data-aos="fade-in">
        <?php
            if ($homepageTitle = get_theme_option('Homepage Title')){
                echo $homepageTitle;
            }   
        ?>
    </h1> 
</header>

<main>
    <?php if ($homepageText = get_theme_option('Homepage Text')): ?>
        <div class="homepageText"><?php echo $homepageText; ?></div>
    <?php endif; ?>
</main>


<?php fire_plugin_hook('public_home', array('view' => $this)); ?>

<?php echo foot(); ?>
