<?php
get_header();
include("models/Location.php");
include("models/Programs.php");

$threeMonthsAhead = new DateTime('NOW');
$threeMonthsAhead->modify('+2 months');
$upcomingPrograms = Program::getAllProgramsForDateRange(new DateTime('NOW'), $threeMonthsAhead);

if (count($upcomingPrograms) > 0):
    wp_localize_script( 'jeta-react', 'WP_Programs', $upcomingPrograms );
    wp_localize_script( 'jeta-react', 'THEME_IMG_PATH', THEME_IMG_PATH );
    wp_localize_script( 'jeta-react', 'WP_AJAX_URL', admin_url('admin-ajax.php'));
    wp_enqueue_script( 'jeta-react' );
endif;
?>

<main id="root">
</main>

<?php
get_footer();