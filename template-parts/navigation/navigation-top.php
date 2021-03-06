<?php
/**
 * Displays top navigation
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.2
 */

?>
<nav id="site-navigation" class="main-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Top Menu', 'svenskaskolaniseattle' ); ?>">
	<button class="menu-toggle" aria-controls="top-menu" aria-expanded="false">
		<?php
		echo 'bars';
		echo 'close';
		_e( 'Menu', 'svenskaskolaniseattle' );
		?>
	</button>

	<?php
	wp_nav_menu(
		array(
			'theme_location' => 'top',
			'menu_id'        => 'top-menu',
		)
	);
	?>

	<?php if ( ( svenskaskolaniseattle_is_frontpage() || ( is_home() && is_front_page() ) ) && has_custom_header() ) : ?>
		<a href="#content" class="menu-scroll-down">&gt;<span class="screen-reader-text"><?php _e( 'Scroll down to content', 'svenskaskolaniseattle' ); ?></span></a>
	<?php endif; ?>
</nav><!-- #site-navigation -->
