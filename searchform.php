<?php
/**
 * Custom search form
 *
 * @package PinterHVN_Theme
 * @since 1.0.0
 */
?>

<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label>
		<span class="screen-reader-text"><?php echo _x( 'Search for:', 'label', 'pinterhvn-theme' ); ?></span>
		<input 
			type="search" 
			class="search-field" 
			placeholder="<?php echo esc_attr_x( 'Search assets...', 'placeholder', 'pinterhvn-theme' ); ?>" 
			value="<?php echo get_search_query(); ?>" 
			name="s" 
		/>
	</label>
	<button type="submit" class="search-submit">
		<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
			<path d="M9 17C13.4183 17 17 13.4183 17 9C17 4.58172 13.4183 1 9 1C4.58172 1 1 4.58172 1 9C1 13.4183 4.58172 17 9 17Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
			<path d="M19 19L14.65 14.65" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
		</svg>
		<span class="screen-reader-text"><?php echo _x( 'Search', 'submit button', 'pinterhvn-theme' ); ?></span>
	</button>
</form>
