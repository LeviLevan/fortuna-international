<?php
/**
 * Template part for top panel in header.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Kava
 */

// Don't show top panel if all elements are disabled.
if ( ! kava_is_top_panel_visible() ) {
	return;
} ?>

<div class="top-panel container">
	<div class="space-between-content">
		<div class="top-panel-content__left">
			<?php do_action( 'kava-theme/top-panel/elements-left' ); ?>
		</div>
		<div class="top-panel-content__right">
			<?php do_action( 'kava-theme/top-panel/elements-right' ); ?>
		</div>
	</div>
</div>