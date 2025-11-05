<?php
/**
 * The footer template - Minimalist (No visible footer)
 *
 * @package PinterHVN_Theme
 * @since 1.0.0
 */
?>

</div><!-- #page -->

<!-- Save to Collection Modal -->
<div id="save-to-collection-modal" class="modal">
	<div class="modal-content">
		<div class="modal-header">
			<h3 class="modal-title"><?php _e( 'Save to Collection', 'pinterhvn-theme' ); ?></h3>
			<button class="modal-close" type="button">&times;</button>
		</div>
		<div class="modal-body">
			<form id="save-to-collection-form">
				<input type="hidden" id="save-asset-id" name="asset_id" value="">
				
				<div class="form-group">
					<label><?php _e( 'Select Collections:', 'pinterhvn-theme' ); ?></label>
					<div id="collections-list" class="collections-checkboxes">
						<!-- Collections will be loaded here via AJAX -->
					</div>
				</div>

				<div class="form-group mt-3">
					<label for="new-collection-name"><?php _e( 'Or Create New Collection:', 'pinterhvn-theme' ); ?></label>
					<input 
						type="text" 
						id="new-collection-name" 
						name="new_collection_name" 
						placeholder="<?php esc_attr_e( 'Collection name', 'pinterhvn-theme' ); ?>"
					>
				</div>

				<div id="save-message" class="message mt-2" style="display: none;"></div>
			</form>
		</div>
		<div class="modal-footer">
			<button class="btn btn-secondary modal-close" type="button">
				<?php _e( 'Cancel', 'pinterhvn-theme' ); ?>
			</button>
			<button class="btn btn-primary" id="save-to-collection-btn" type="button">
				<?php _e( 'Save', 'pinterhvn-theme' ); ?>
			</button>
		</div>
	</div>
</div>

<!-- Share Modal -->
<div id="share-modal" class="modal">
	<div class="modal-content">
		<div class="modal-header">
			<h3 class="modal-title"><?php _e( 'Share Asset', 'pinterhvn-theme' ); ?></h3>
			<button class="modal-close" type="button">&times;</button>
		</div>
		<div class="modal-body">
			<div class="share-buttons">
				<button class="btn btn-outline share-btn" data-platform="copy">
					<svg width="20" height="20" viewBox="0 0 20 20" fill="none">
						<path d="M8 5H6C4.89543 5 4 5.89543 4 7V17C4 18.1046 4.89543 19 6 19H14C15.1046 19 16 18.1046 16 17V7C16 5.89543 15.1046 5 14 5H12" stroke="currentColor" stroke-width="2"/>
						<path d="M10 1V13M10 1L7 4M10 1L13 4" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
					</svg>
					<?php _e( 'Copy Link', 'pinterhvn-theme' ); ?>
				</button>
			</div>
			<input 
				type="text" 
				id="share-link-input" 
				readonly 
				class="mt-2"
				value=""
				style="width: 100%; padding: 0.75rem; border: 1px solid #cbd5e1; border-radius: 8px;"
			>
		</div>
	</div>
</div>

<!-- Scroll to Top Button -->
<button id="scroll-to-top" class="scroll-to-top" style="display: none;">
	<svg width="24" height="24" viewBox="0 0 24 24" fill="none">
		<path d="M12 19V5M12 5L5 12M12 5L19 12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
	</svg>
</button>

<?php wp_footer(); ?>

</body>
</html>
