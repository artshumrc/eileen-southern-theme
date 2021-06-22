<!DOCTYPE html>
<html lang="<?php echo get_html_lang(); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php if ($author = option('author')): ?>
    <meta name="author" content="<?php echo $author; ?>" />
    <?php endif; ?>
    <?php if ($copyright = option('copyright')): ?>
    <meta name="copyright" content="<?php echo $copyright; ?>" />
    <?php endif; ?>
    <?php if ( $description = option('description')): ?>
    <meta name="description" content="<?php echo $description; ?>" />
    <?php endif; ?>
    <?php
    if (isset($title)) {
        $titleParts[] = strip_formatting($title);
    }
    $titleParts[] = option('site_title');
    ?>
    <title><?php echo implode(' &middot; ', $titleParts); ?></title>

    <?php echo auto_discovery_link_tags(); ?>

    <!-- Plugin Stuff -->

    <?php fire_plugin_hook('public_head', array('view'=>$this)); ?>


    <!-- Stylesheets -->
    <?php
    queue_css_file(array('iconfonts','style'));
    queue_css_url('//fonts.googleapis.com/css?family=PT+Serif:400,700,400italic,700italic');

    /** Southern CSS */
    queue_css_file('aos');
    queue_css_url('//fonts.googleapis.com/css2?family=Oswald:wght@600&display=swap');
    queue_css_url('//fonts.googleapis.com/css2?family=DM+Sans:ital,wght@0,400;0,700;1,400&display=swap');

    echo head_css();

    echo theme_header_background();
    ?>

    <?php
    ($backgroundColor = get_theme_option('background_color')) || ($backgroundColor = "#FFFFFF");
    ($textColor = get_theme_option('text_color')) || ($textColor = "#444444");
    ($linkColor = get_theme_option('link_color')) || ($linkColor = "#888888");
    ($buttonColor = get_theme_option('button_color')) || ($buttonColor = "#000000");
    ($buttonTextColor = get_theme_option('button_text_color')) || ($buttonTextColor = "#FFFFFF");
    ($titleColor = get_theme_option('header_title_color')) || ($titleColor = "#000000");
    ?>
    <style>
 
    </style>
    <!-- JavaScripts -->
    <?php
    queue_js_file('vendor/modernizr');
    queue_js_file('vendor/selectivizr', 'javascripts', array('conditional' => '(gte IE 6)&(lte IE 8)'));
    queue_js_file('vendor/respond');
    queue_js_file('vendor/jquery-accessibleMegaMenu');
    queue_js_file('vendor/aos'); /** Southern */
    queue_js_file('globals');
    queue_js_file('default');
    echo head_js();
    ?>
</head>

<?php
    // set up body
    $requestUri = $_SERVER['REQUEST_URI'];
    function pageTitle($self){
        if(!property_exists($self, 'title')){
            return "Exhibition";
        } else {
            return $self->title;
        }
    }
?>
<?php echo body_tag(array('id' => @$bodyid, 'class' => @$bodyclass)); ?>
    <a href="#content" id="skipnav"><?php echo __('Skip to main content'); ?></a>
    <?php fire_plugin_hook('public_body', array('view'=>$this)); ?>

        <header>
            <h1 class="page-title txt-center aos-init aos-animate" data-aos="fade-in">
                <?php 
                    echo pageTitle($this);
                ?>
            </h1>
        </header>

        <div id="wrap">
            <div class="nav-container" id="navbar">
                <div class="logo">
                    <a href="/">
                        <h2>Eileen Southern</h2>
                        <h3 class="subtitle">And the Music of<br>Black Americans</h3>
                    </a>    
                </div>
                <!-- <div class="menu-button button">Menu</div> -->
                <nav>
                    <input class="menu-btn" type="checkbox" id="menu-btn" />
                    <label class="menu-icon" for="menu-btn"><span class="navicon"></span></label>
                    <ul class="menu">
                        <li class="category-name dark-yellow pad-top">Exhibition
                            <ul>
                                <li class="page-link dark-yellow-bg"><a href="/career">Life + Career</a></li>
                                <li class="page-link dark-yellow-bg"><a href="/timeline">Timeline</a></li>
                                <li class="page-link dark-yellow-bg"><a href="/exhibits/show/scholarship">Scholarship</a></li>
                                <li class="page-link dark-yellow-bg"><a href="/teaching">Teaching</a></li>
                                <li class="page-link dark-yellow-bg"><a href="/map">Map</a></li>

                            </ul>
                        </li>
                        <li class="category-name light-teal">Gallery
                            <ul>
                                <li class="page-link light-teal-bg"><a href="/items/browse">Images</a></li>
                                <li class="page-link light-teal-bg"><a href="/interviews">Interviews</a></li>
                            </ul>
                        </li>
                        <li class="category-name orange">About
                            <ul>
                                <li class="page-link orange-bg"><a href="/about">About the Project</a></li>
                                <li class="page-link orange-bg"><a href="/glossary">Glossary</a></li>
                                <li class="page-link orange-bg"><a href="/team">Our Team</a></li>
                                <li class="page-link orange-bg"><a href="/contact">Contact</a></li>
                                <li class="page-link orange-bg"><a href="/bibliography">Bibliography</a></li>
                            </ul>
                        </li>
                    </ul>                   
                </nav>
            </div>

            <div id="content" role="main" tabindex="-1">
                <?php fire_plugin_hook('public_content_top', array('view'=>$this)); ?>
