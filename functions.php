<?php
/**
 * Modify a hex color by the given number of steps (out of 255).
 *
 * Adapted from a solution by Torkil Johnsen.
 *
 * @param string $color
 * @param int $steps
 * @link http://stackoverflow.com/questions/3512311/how-to-generate-lighter-darker-color-with-php
 */
function thanksroy_brighten($color, $steps) {
    $steps = max(-255, min(255, $steps));
    $hex = str_replace('#', '', $color);
    $r = hexdec(substr($hex,0,2));
    $g = hexdec(substr($hex,2,2));
    $b = hexdec(substr($hex,4,2));

    $r = max(0,min(255,$r + $steps));
    $g = max(0,min(255,$g + $steps));  
    $b = max(0,min(255,$b + $steps));

    $r_hex = str_pad(dechex($r), 2, '0', STR_PAD_LEFT);
    $g_hex = str_pad(dechex($g), 2, '0', STR_PAD_LEFT);
    $b_hex = str_pad(dechex($b), 2, '0', STR_PAD_LEFT);

     return '#'.$r_hex.$g_hex.$b_hex;
}

function debug_to_console( $data ) {
	echo "<script>
		console.log(" . json_encode($data) . ");
		</script>";
}

/**
 * Get the main navigation for the Eileen Southern site.
 */
function eileen_nav_main()
{
    $view = get_view();
    $nav = new Omeka_Navigation;
    $nav->loadAsOption(Omeka_Navigation::PUBLIC_NAVIGATION_MAIN_OPTION_NAME);
    $nav->addPagesFromFilter(Omeka_Navigation::PUBLIC_NAVIGATION_MAIN_FILTER_NAME);
    return $view->navigation()->menu($nav);
    // return $view->navigation()->menu($nav)->setPartial('/partials/menu');
}