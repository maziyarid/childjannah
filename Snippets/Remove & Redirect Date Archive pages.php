// Redirect date-based archives (year, month, day) to the homepage
function redirect_date_archives_to_home() {
    if ( is_date() || is_year() || is_month() || is_day() ) {
        wp_redirect( home_url(), 301 );
        exit;
    }
}
add_action( 'template_redirect', 'redirect_date_archives_to_home' );