<?php
/**
 * Displays footer site info
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */

?>
<div class="site-info">
	<?php
		if ( is_active_sidebar( 'site-info' ) ) {
	?>
		<div class="site-info-content">
			<?php dynamic_sidebar( 'site-info' ); ?>
		</div>
	<?php
		}
	?>
</div>
