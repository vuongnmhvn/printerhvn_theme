<?php
/**
 * The header template - Pinterest Style Vertical Nav
 *
 * @package PinterHVN_Theme
 * @since 1.0.0
 */
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#primary">
		<?php _e( 'Skip to content', 'pinterhvn-theme' ); ?>
	</a>

	<!-- Vertical Navigation Sidebar -->
	<aside id="vertical-nav" class="vertical-navigation">
		<div class="vertical-nav-inner">
			
			<!-- Logo -->
			<div class="nav-logo">
				<?php if ( has_custom_logo() ) : ?>
					<?php the_custom_logo(); ?>
				<?php else : ?>
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php bloginfo( 'name' ); ?>">
						<svg width="189" height="168" viewBox="0 0 189 168" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M8.27942 156.882V136.642H12.6571V144.719H21.4124V136.642H25.6948V156.882H21.3172V148.425H12.5619V156.882H8.27942Z" fill="#231F20"/>
						<path d="M35.4018 156.882L27.8837 136.642H32.642L36.5438 149.28C36.639 149.565 36.7341 150.041 36.9244 150.706C37.1148 151.371 37.2099 152.226 37.4003 153.081C37.4954 152.226 37.6858 151.466 37.7809 150.801C37.8761 150.136 38.0664 149.565 38.1616 149.185L42.1586 136.737H46.9169L39.3988 156.977H35.4018V156.882Z" fill="#231F20"/>
						<path d="M49.2008 156.882V136.642H53.6736L62.6192 148.425C62.9047 148.71 63.1902 149.185 63.4757 149.85C63.7612 150.516 64.1419 151.181 64.4274 151.941C64.3322 151.371 64.2371 150.706 64.2371 150.136C64.2371 149.565 64.1419 148.805 64.1419 147.95V136.642H68.3292V156.882H64.0467L54.8156 144.909C54.5301 144.624 54.2446 144.149 53.9591 143.484C53.6736 142.819 53.2929 142.154 53.0075 141.298C53.1026 141.869 53.1978 142.439 53.1978 143.104C53.1978 143.674 53.2929 144.434 53.2929 145.384V156.977H49.2008V156.882Z" fill="#231F20"/>
						<path d="M91.645 146.145H100.876C100.876 146.24 100.876 146.43 100.876 146.525C100.876 146.62 100.876 146.905 100.876 147.19C100.876 150.231 100.02 152.701 98.3067 154.602C96.5937 156.502 94.3097 157.452 91.5499 157.452C88.4094 157.452 85.8399 156.407 83.7462 154.412C81.7478 152.416 80.7009 149.85 80.7009 146.81C80.7009 143.769 81.7478 141.203 83.7462 139.208C85.8399 137.212 88.4094 136.167 91.5499 136.167C93.1677 136.167 94.6904 136.547 96.1178 137.212C97.5453 137.878 98.6873 138.923 99.8293 140.348L96.8792 142.534C96.1179 141.584 95.3565 141.013 94.5952 140.538C93.8339 140.158 92.8822 139.968 91.8354 139.968C89.8369 139.968 88.2191 140.633 86.9819 141.869C85.7447 143.104 85.1737 144.814 85.1737 146.905C85.1737 148.995 85.7447 150.611 86.9819 151.846C88.2191 153.081 89.7417 153.746 91.7402 153.746C93.1677 153.746 94.3097 153.366 95.1662 152.701C96.0227 152.036 96.4985 151.181 96.4985 150.041V149.85H91.645V146.145Z" fill="#231F20"/>
						<path d="M119.053 156.882H114.009L108.68 147.38V156.882H104.302V136.642H110.488C112.962 136.642 114.77 137.117 116.007 138.068C117.245 139.018 117.816 140.443 117.816 142.344C117.816 143.769 117.435 144.909 116.578 145.955C115.722 146.905 114.675 147.475 113.343 147.665L119.053 156.882ZM108.68 145.289H109.346C111.059 145.289 112.296 145.099 112.867 144.719C113.438 144.339 113.723 143.674 113.723 142.724C113.723 141.774 113.438 141.013 112.772 140.633C112.201 140.253 111.059 139.968 109.346 139.968H108.68V145.289Z" fill="#231F20"/>
						<path d="M142.369 146.81C142.369 148.235 142.083 149.66 141.512 150.896C140.941 152.226 140.18 153.366 139.133 154.317C138.086 155.362 136.849 156.122 135.612 156.597C134.279 157.167 132.947 157.357 131.52 157.357C130.282 157.357 129.045 157.167 127.903 156.692C126.761 156.312 125.619 155.647 124.668 154.887C123.43 153.841 122.384 152.701 121.717 151.276C121.051 149.851 120.671 148.33 120.671 146.715C120.671 145.289 120.956 143.864 121.432 142.629C121.908 141.394 122.764 140.253 123.811 139.208C124.858 138.258 126 137.498 127.332 136.927C128.665 136.357 130.092 136.072 131.52 136.072C132.947 136.072 134.279 136.357 135.612 136.927C136.944 137.498 138.086 138.258 139.133 139.208C140.18 140.158 140.941 141.299 141.512 142.629C142.083 143.959 142.369 145.289 142.369 146.81ZM131.52 153.556C133.328 153.556 134.85 152.891 136.088 151.656C137.325 150.326 137.896 148.805 137.896 146.81C137.896 144.909 137.325 143.294 136.088 141.964C134.85 140.633 133.328 139.968 131.52 139.968C129.711 139.968 128.189 140.633 126.952 141.964C125.714 143.294 125.143 144.909 125.143 146.81C125.143 148.805 125.714 150.421 126.952 151.656C128.189 152.891 129.616 153.556 131.52 153.556Z" fill="#231F20"/>
						<path d="M163.4 136.642V149.185C163.4 151.941 162.639 154.032 161.211 155.362C159.784 156.692 157.595 157.357 154.645 157.357C151.695 157.357 149.506 156.692 147.983 155.362C146.556 154.032 145.794 151.941 145.794 149.185V136.547H150.077V148.425C150.077 150.136 150.458 151.371 151.219 152.226C151.98 153.081 153.027 153.461 154.55 153.461C156.072 153.461 157.119 153.081 157.881 152.226C158.642 151.371 159.023 150.136 159.023 148.425V136.547H163.4V136.642Z" fill="#231F20"/>
						<path d="M167.968 156.882V136.642H172.917C175.582 136.642 177.58 137.117 178.817 138.163C180.054 139.208 180.721 140.728 180.721 142.819C180.721 144.814 180.054 146.335 178.817 147.475C177.58 148.615 175.772 149.185 173.488 149.185H172.251V156.882H167.968ZM172.251 145.764H172.917C174.059 145.764 174.915 145.479 175.486 145.004C176.057 144.529 176.248 143.769 176.248 142.629C176.248 141.679 175.962 140.918 175.486 140.443C174.915 139.968 174.059 139.778 172.917 139.778H172.251V145.764Z" fill="#231F20"/>
						<path d="M94.5 87.0406L121.813 114.312H146.175L94.5 62.7148" fill="#E84443"/>
						<path d="M94.5 62.7148L42.7296 114.312H67.1873L94.5 87.0406" fill="#E84443"/>
						<path d="M42.7296 28.3168V87.3258V104.62L60.0499 87.3258V11.0227L42.7296 28.3168Z" fill="#E84443"/>
						<path d="M100.591 56.6336L110.964 66.896V56.6336V46.2761L100.591 56.6336Z" fill="#808080"/>
						<path d="M118.196 38.9595V74.2128L128.57 84.5703V73.0726V62.7151V50.4572V40.0997V28.697L118.196 38.9595Z" fill="#808080"/>
						<path d="M135.897 21.3802V91.7919L146.175 102.149V95.0227V84.6652V31.7376V21.3802V11.0227L135.897 21.3802Z" fill="#808080"/>
						</svg>
					</a>
				<?php endif; ?>
			</div>

			<!-- Navigation Menu -->
			<nav class="nav-menu">
				<ul>
					<li class="nav-item">
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="nav-link <?php echo ( is_front_page() && is_home() ) ? 'active' : ''; ?>" title="<?php esc_attr_e( 'Home', 'pinterhvn-theme' ); ?>">
							<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor">
								<path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
								<polyline points="9 22 9 12 15 12 15 22" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
							</svg>
							<span class="nav-label"><?php _e( 'Trang chủ', 'pinterhvn-theme' ); ?></span>
						</a>
					</li>

					<li class="nav-item">
						<a href="<?php echo esc_url( get_post_type_archive_link( 'digital_asset' ) ); ?>" class="nav-link <?php echo ( is_post_type_archive( 'digital_asset' ) ) ? 'active' : ''; ?>" title="<?php esc_attr_e( 'Explore', 'pinterhvn-theme' ); ?>">
							<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor">
								<circle cx="11" cy="11" r="8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
								<path d="m21 21-4.35-4.35" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
							</svg>
							<span class="nav-label"><?php _e( 'Khám phá', 'pinterhvn-theme' ); ?></span>
						</a>
					</li>

					<li class="nav-item">
						<a href="<?php echo esc_url( home_url( '/campaigns/' ) ); ?>" class="nav-link" title="<?php esc_attr_e( 'Campaigns', 'pinterhvn-theme' ); ?>">
							<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor">
								<circle cx="12" cy="12" r="10" stroke-width="2"/>
								<circle cx="12" cy="12" r="6" stroke-width="2"/>
								<circle cx="12" cy="12" r="2" stroke-width="2"/>
							</svg>
							<span class="nav-label"><?php _e( 'Chiến dịch', 'pinterhvn-theme' ); ?></span>
						</a>
					</li>

					<li class="nav-item">
						<a href="<?php echo esc_url( home_url( '/branding-guideline/' ) ); ?>" class="nav-link" title="<?php esc_attr_e( 'Campaigns', 'pinterhvn-theme' ); ?>">
							<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor">
								<path d="M4.5 16.5c-1.5 1.26-2 5-2 5s3.74-.5 5-2c.71-.84.7-2.13-.09-2.91a2.18 2.18 0 00-2.91-.09z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
								<path d="M12 15l-3-3a22 22 0 012-3.95A12.88 12.88 0 0122 2c0 2.72-.78 7.5-6 11a22.35 22.35 0 01-4 2z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
								<path d="M9 12H4s.55-3.03 2-4c1.62-1.08 5 0 5 0" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
								<path d="M12 15v5s3.03-.55 4-2c1.08-1.62 0-5 0-5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
							</svg>
							<span class="nav-label"><?php _e( 'Guideline', 'pinterhvn-theme' ); ?></span>
						</a>
					</li>

					<?php if ( is_user_logged_in() ) : ?>
					<li class="nav-item">
						<a href="<?php echo esc_url( home_url( '/my-collections/' ) ); ?>" class="nav-link" title="<?php esc_attr_e( 'Collections', 'pinterhvn-theme' ); ?>">
							<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor">
								<path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
								<polyline points="17 21 17 13 7 13 7 21" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
								<polyline points="7 3 7 8 15 8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
							</svg>
							<span class="nav-label"><?php _e( 'Bộ sưu tập', 'pinterhvn-theme' ); ?></span>
						</a>
					</li>
					<?php endif; ?>

					<?php if ( is_user_logged_in() && current_user_can( 'edit_posts' ) ) : ?>
					<li class="nav-item">
						<a href="<?php echo esc_url( home_url( '/upload-asset/' ) ); ?>" class="nav-link" title="<?php esc_attr_e( 'Upload', 'pinterhvn-theme' ); ?>">
							<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor">
								<circle cx="12" cy="12" r="10" stroke-width="2"/>
								<line x1="12" y1="8" x2="12" y2="16" stroke-width="2" stroke-linecap="round"/>
								<line x1="8" y1="12" x2="16" y2="12" stroke-width="2" stroke-linecap="round"/>
							</svg>
							<span class="nav-label"><?php _e( 'Tải lên', 'pinterhvn-theme' ); ?></span>
						</a>
					</li>
					<?php endif; ?>
				</ul>
			</nav>

			<!-- Bottom Section -->
			<div class="nav-bottom">
				<?php if ( is_user_logged_in() ) : ?>
					<!-- User Profile -->
					<div class="nav-item">
						<a href="<?php echo esc_url( home_url( '/my-profile/' ) ); ?>" class="nav-link" title="<?php esc_attr_e( 'Profile', 'pinterhvn-theme' ); ?>">
						<div class="nav-avatar">
								<?php echo get_avatar( get_current_user_id(), 32 ); ?>
							</div>
							<span class="nav-label"><?php _e( 'Cá nhân', 'pinterhvn-theme' ); ?></span>
						</a>
					</div>

					<!-- Settings -->
					<div class="nav-item">
						<a href="https://zalo.me/0986833385" class="nav-link" target="_blank" title="<?php esc_attr_e( 'Suuport Zalo', 'pinterhvn-theme' ); ?>">
						<svg _ngcontent-ng-c2925571332="" xmlns="http://www.w3.org/2000/svg" width="24" height="24	" viewBox="0 0 32 32" fill="none"><path _ngcontent-ng-c2925571332="" d="M7.42203 2.14049C8.3824 1.98932 9.3591 1.98841 10.3294 2.01014L10.246 2.08708C8.9764 2.91718 7.92352 4.05687 7.16266 5.36494C5.63731 7.98378 5.08139 11.0806 5.20745 14.0823C5.3326 16.5265 5.92025 18.9842 7.16629 21.1088C7.37487 21.489 7.7222 21.8248 7.72764 22.2865C7.76664 23.2768 7.27602 24.2101 6.61219 24.918C6.65572 24.9633 6.69834 25.0085 6.74187 25.0538C7.36308 25.7309 8.026 26.3673 8.65718 27.0354C9.55408 28.0474 10.5761 28.9436 11.4549 29.9737C9.993 29.9955 8.5139 30.0634 7.06925 29.7909C5.25098 29.4388 3.63675 28.1805 2.86591 26.4986C2.39887 25.5263 2.25921 24.4391 2.22294 23.3737C2.22203 18.4546 2.22203 13.5365 2.22294 8.61835C2.24289 6.97444 2.6791 5.2545 3.83808 4.03515C4.75583 3.00227 6.05537 2.33059 7.42203 2.14049Z" fill="#0068FF"></path><path _ngcontent-ng-c2925571332="" d="M20.7367 11.1729C21.1258 11.1729 21.5148 11.1729 21.9048 11.1729C21.8984 13.4477 21.8984 15.7235 21.9048 17.9983C21.5239 17.9449 20.89 18.1884 20.7467 17.6824C20.7231 15.5135 20.7449 13.3427 20.7367 11.1729Z" fill="#0068FF"></path><path _ngcontent-ng-c2925571332="" d="M8.83488 11.2535C10.645 11.2517 12.4533 11.24 14.2625 11.2526C14.2498 11.6066 14.2298 11.9922 13.9922 12.2783C12.7553 13.8153 11.5446 15.3724 10.3085 16.9094C11.6226 16.9176 12.9367 16.9122 14.2507 16.9122C14.2262 17.219 14.3341 17.5766 14.1346 17.8427C14.0095 18.0147 13.7828 17.9993 13.595 18.0012C11.9509 17.9921 10.3067 18.0093 8.66348 17.9921C8.66802 17.6454 8.67164 17.2616 8.91469 16.9855C10.1371 15.4547 11.3741 13.9348 12.5911 12.4005C11.3406 12.4023 10.0891 12.3923 8.83851 12.4059C8.83035 12.0221 8.83307 11.6374 8.83488 11.2535Z" fill="#0068FF"></path><path _ngcontent-ng-c2925571332="" d="M24.8004 12.7598C26.1026 12.4692 27.5155 13.3228 27.8719 14.6029C28.319 15.9345 27.5028 17.5177 26.1543 17.9233C25.0089 18.3261 23.6377 17.8001 23.0437 16.7464C22.5776 15.9679 22.5495 14.9486 22.973 14.1475C23.3321 13.4405 24.0259 12.9236 24.8004 12.7598ZM24.7786 13.9131C23.9842 14.1928 23.5561 15.1578 23.8663 15.9372C24.1229 16.674 24.9872 17.1248 25.7381 16.8985C26.5951 16.6939 27.1129 15.6918 26.8091 14.8708C26.5551 14.0579 25.5712 13.589 24.7786 13.9131Z" fill="#0068FF"></path><path _ngcontent-ng-c2925571332="" d="M15.153 13.7076C15.7797 12.9327 16.877 12.5507 17.8437 12.8268C18.1629 12.9074 18.4522 13.0667 18.7315 13.236C18.7288 13.1509 18.7225 12.9816 18.7197 12.8965C19.0852 12.8947 19.4498 12.8956 19.8152 12.8938C19.8134 14.5956 19.8116 16.2975 19.8162 18.0002C19.5477 17.993 19.2748 18.0247 19.0109 17.9703C18.8259 17.8952 18.7687 17.6933 18.6953 17.5286C17.6868 18.3107 16.1025 18.1333 15.2646 17.181C14.3713 16.2585 14.3251 14.6871 15.153 13.7076ZM16.6294 13.9357C15.7897 14.2308 15.3825 15.3108 15.8078 16.0893C16.1705 16.8478 17.1917 17.1665 17.9217 16.7483C18.5991 16.3934 18.912 15.5126 18.6209 14.8084C18.3389 14.0425 17.3876 13.6134 16.6294 13.9357Z" fill="#0068FF"></path><path _ngcontent-ng-c2925571332="" d="M10.246 2.08714C10.4491 2.0292 10.6614 2.0111 10.8717 2.00476C14.4983 2.01834 18.1249 2.00295 21.7515 2.00929C22.7209 2.02105 23.6958 1.95588 24.658 2.10343C25.9902 2.20482 27.2725 2.76787 28.2637 3.65772C29.5079 4.84448 30.1718 6.55357 30.1926 8.25812C30.1935 13.0568 30.1908 17.859 30.1953 22.6559C30.1826 22.6839 30.1581 22.7419 30.1455 22.7708C28.8532 24.2138 27.1156 25.1905 25.2991 25.8224C22.8515 26.6552 20.2297 26.9232 17.6569 26.7276C15.0842 26.5068 12.4914 25.836 10.3095 24.4166C9.19404 24.9117 7.96342 25.1543 6.74186 25.0538C6.69833 25.0086 6.65571 24.9633 6.61218 24.9181C7.27601 24.2102 7.76663 23.2769 7.72763 22.2865C7.72219 21.8249 7.37486 21.489 7.16628 21.1088C5.92024 18.9842 5.33259 16.5265 5.20744 14.0824C5.08139 11.0806 5.6373 7.98384 7.16265 5.36499C7.92352 4.05693 8.97639 2.91724 10.246 2.08714ZM20.7367 11.173C20.7448 13.3428 20.7231 15.5136 20.7467 17.6825C20.8899 18.1885 21.5238 17.945 21.9047 17.9984C21.8984 15.7236 21.8984 13.4478 21.9047 11.173C21.5148 11.173 21.1257 11.173 20.7367 11.173ZM8.83492 11.2535C8.83311 11.6374 8.83038 12.0221 8.83855 12.4059C10.0891 12.3923 11.3406 12.4023 12.5912 12.4005C11.3742 13.9348 10.1372 15.4547 8.91472 16.9855C8.67168 17.2616 8.66806 17.6454 8.66352 17.9921C10.3068 18.0093 11.9509 17.9921 13.5951 18.0012C13.7828 17.9994 14.0095 18.0147 14.1347 17.8427C14.3342 17.5766 14.2263 17.219 14.2507 16.9122C12.9367 16.9122 11.6226 16.9176 10.3086 16.9095C11.5446 15.3724 12.7553 13.8154 13.9923 12.2783C14.2299 11.9922 14.2498 11.6066 14.2625 11.2526C12.4533 11.24 10.645 11.2517 8.83492 11.2535ZM24.8004 12.7599C24.0259 12.9237 23.3321 13.4406 22.973 14.1476C22.5495 14.9487 22.5776 15.968 23.0438 16.7465C23.6378 17.8002 25.0089 18.3261 26.1543 17.9233C27.5028 17.5178 28.319 15.9345 27.8719 14.6029C27.5155 13.3229 26.1026 12.4693 24.8004 12.7599ZM15.1531 13.7076C14.3251 14.6871 14.3714 16.2586 15.2646 17.181C16.1026 18.1333 17.6869 18.3108 18.6953 17.5286C18.7688 17.6934 18.8259 17.8953 19.0109 17.9704C19.2748 18.0247 19.5478 17.993 19.8162 18.0003C19.8117 16.2975 19.8135 14.5957 19.8153 12.8938C19.4498 12.8956 19.0853 12.8947 18.7198 12.8965C18.7225 12.9816 18.7289 13.1509 18.7316 13.236C18.4523 13.0667 18.163 12.9074 17.8438 12.8268C16.877 12.5507 15.7797 12.9328 15.1531 13.7076Z" fill="white"></path><path _ngcontent-ng-c2925571332="" d="M16.6295 13.9357C17.3877 13.6134 18.339 14.0425 18.621 14.8083C18.9121 15.5126 18.5993 16.3934 17.9218 16.7482C17.1918 17.1665 16.1707 16.8478 15.8079 16.0892C15.3826 15.3107 15.7898 14.2308 16.6295 13.9357Z" fill="white"></path><path _ngcontent-ng-c2925571332="" d="M24.7786 13.9131C25.5712 13.589 26.5551 14.0579 26.809 14.8708C27.1128 15.6919 26.595 16.694 25.738 16.8986C24.9871 17.1249 24.1229 16.6741 23.8663 15.9372C23.5561 15.1578 23.9841 14.1928 24.7786 13.9131Z" fill="white"></path><path _ngcontent-ng-c2925571332="" d="M30.1454 22.7708L30.2171 22.693C30.2542 24.1079 30.101 25.5843 29.4054 26.8435C28.5965 28.3208 27.1292 29.418 25.4787 29.7692C24.5527 29.9602 23.6033 30.0028 22.6601 29.991C19.759 29.9919 16.858 29.991 13.9569 29.9919C13.1226 29.9783 12.2864 30.0172 11.4548 29.9738C10.5761 28.9436 9.55402 28.0475 8.65713 27.0354C8.02595 26.3673 7.36303 25.731 6.74182 25.0538C7.96338 25.1543 9.194 24.9117 10.3094 24.4166C12.4914 25.836 15.0841 26.5067 17.6569 26.7276C20.2297 26.9232 22.8515 26.6552 25.2991 25.8224C27.1156 25.1905 28.8531 24.2138 30.1454 22.7708Z" fill="#005BE0"></path></svg>
							<span class="nav-label"><?php _e( 'Hỗ trợ', 'pinterhvn-theme' ); ?></span>
						</a>
					</div>
				<?php else : ?>
					<!-- Login Button -->
					<div class="nav-item">
						<a href="<?php echo esc_url( wp_login_url( get_permalink() ) ); ?>" class="nav-link nav-login" title="<?php esc_attr_e( 'Login', 'pinterhvn-theme' ); ?>">
							<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor">
								<path d="M15 3h4a2 2 0 012 2v14a2 2 0 01-2 2h-4M10 17l5-5-5-5M15 12H3" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
							</svg>
							<span class="nav-label"><?php _e( 'Đăng nhập', 'pinterhvn-theme' ); ?></span>
						</a>
					</div>
				<?php endif; ?>
			</div>

		</div>

		<!-- Settings Dropdown (hidden by default) -->
		<?php if ( is_user_logged_in() ) : ?>
		<div class="nav-settings-dropdown" style="display: none;">
			<div class="settings-dropdown-inner">
				<a href="<?php echo esc_url( admin_url() ); ?>" class="settings-item">
					<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
						<rect x="3" y="3" width="18" height="18" rx="2" ry="2" stroke-width="2"/>
						<line x1="9" y1="3" x2="9" y2="21" stroke-width="2"/>
					</svg>
					<span><?php _e( 'Dashboard', 'pinterhvn-theme' ); ?></span>
				</a>
				<a href="<?php echo esc_url( get_edit_profile_url() ); ?>" class="settings-item">
					<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
						<path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
						<circle cx="12" cy="7" r="4" stroke-width="2"/>
					</svg>
					<span><?php _e( 'Edit Profile', 'pinterhvn-theme' ); ?></span>
				</a>
				<a href="<?php echo esc_url( wp_logout_url( home_url() ) ); ?>" class="settings-item">
					<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
						<path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4M16 17l5-5-5-5M21 12H9" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
					</svg>
					<span><?php _e( 'Logout', 'pinterhvn-theme' ); ?></span>
				</a>
			</div>
		</div>
		<?php endif; ?>
	</aside>

	<!-- Top Search Bar (sticky) -->
	<div class="top-search-bar">
		<div class="search-bar-inner">
			<form role="search" method="get" class="search-form-horizontal" action="<?php echo esc_url( home_url( '/' ) ); ?>">
				<svg width="20" height="20" viewBox="0 0 20 20" fill="none" stroke="currentColor" class="search-icon">
					<circle cx="9" cy="9" r="7" stroke-width="2"/>
					<path d="M14 14l5 5" stroke-width="2" stroke-linecap="round"/>
				</svg>
				<input 
					type="search" 
					name="s" 
					placeholder="<?php esc_attr_e( 'Nhập từ khoá cần tìm...', 'pinterhvn-theme' ); ?>"
					value="<?php echo get_search_query(); ?>"
					class="search-input"
				>
			</form>

			<!-- User Avatar & Menu (Right side) -->
			<?php if ( is_user_logged_in() ) : ?>
			<div class="search-bar-user">
				<button class="user-avatar-trigger" aria-label="<?php esc_attr_e( 'User menu', 'pinterhvn-theme' ); ?>">
					<?php echo get_avatar( get_current_user_id(), 40 ); ?>
					<svg width="12" height="12" viewBox="0 0 12 12" fill="none" class="chevron-down">
						<path d="M2 4l4 4 4-4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
					</svg>
				</button>

				<!-- User Mega Menu -->
				<div class="user-mega-menu">
					<div class="mega-menu-header">
						<div class="user-info">
							<?php echo get_avatar( get_current_user_id(), 48 ); ?>
							<div class="user-details">
								<div class="user-name"><?php echo wp_get_current_user()->display_name; ?></div>
								<div class="user-email"><?php echo wp_get_current_user()->user_email; ?></div>
							</div>
						</div>
					</div>

					<div class="mega-menu-body">
						<!-- Personal Profile -->
						<a href="<?php echo esc_url( home_url( '/my-profile/' ) ); ?>" class="mega-menu-item">
							<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
								<path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
								<circle cx="12" cy="7" r="4" stroke-width="2"/>
							</svg>
							<div class="item-content">
								<div class="item-title"><?php _e( 'Thông tin cá nhân', 'pinterhvn-theme' ); ?></div>
								<div class="item-desc"><?php _e( 'Chỉnh sửa thông tin cá nhân', 'pinterhvn-theme' ); ?></div>
							</div>
						</a>

						<!-- Collection Profile -->
						<a href="<?php echo esc_url( home_url( '/my-collections/' ) ); ?>" class="mega-menu-item">
							<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor">
								<path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
								<polyline points="17 21 17 13 7 13 7 21" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></polyline>
								<polyline points="7 3 7 8 15 8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></polyline>
							</svg>
							<div class="item-content">
								<div class="item-title"><?php _e( 'Bộ sưu tập', 'pinterhvn-theme' ); ?></div>
								<div class="item-desc"><?php _e( 'Xem assets đã lưu & collections', 'pinterhvn-theme' ); ?></div>
							</div>
						</a>

						<?php if ( current_user_can( 'edit_posts' ) ) : ?>
						<!-- Upload Asset -->
						<a href="<?php echo esc_url( home_url( '/wp-admin/' ) ); ?>" class="mega-menu-item">
							<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor">
								<circle cx="12" cy="12" r="3" stroke-width="2"></circle>
								<path d="M12 1v6m0 6v6M5.64 5.64l4.24 4.24m4.24 4.24l4.24 4.24M1 12h6m6 0h6M5.64 18.36l4.24-4.24m4.24-4.24l4.24-4.24" stroke-width="2" stroke-linecap="round"></path>
							</svg>
							<div class="item-content">
								<div class="item-title"><?php _e( 'Admin Dasboard', 'pinterhvn-theme' ); ?></div>
								<div class="item-desc"><?php _e( 'Cổng quản trị hệ thống', 'pinterhvn-theme' ); ?></div>
							</div>
						</a>
						<?php endif; ?>


						<?php if ( current_user_can( 'edit_posts' ) ) : ?>
						<!-- Upload Asset -->
						<a href="<?php echo esc_url( home_url( '/upload-asset/' ) ); ?>" class="mega-menu-item">
							<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
								<path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
								<polyline points="17 8 12 3 7 8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
								<line x1="12" y1="3" x2="12" y2="15" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
							</svg>
							<div class="item-content">
								<div class="item-title"><?php _e( 'Đăng tài nguyên', 'pinterhvn-theme' ); ?></div>
								<div class="item-desc"><?php _e( 'Upload asset mới', 'pinterhvn-theme' ); ?></div>
							</div>
						</a>
						<?php endif; ?>

						<!-- Logout -->
						<a href="<?php echo esc_url( wp_logout_url( home_url() ) ); ?>" class="mega-menu-item mega-menu-item-logout">
							<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
								<path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
								<polyline points="16 17 21 12 16 7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
								<line x1="21" y1="12" x2="9" y2="12" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
							</svg>
							<div class="item-content">
								<div class="item-title"><?php _e( 'Đăng xuất', 'pinterhvn-theme' ); ?></div>
							</div>
						</a>
					</div>
				</div>
			</div>
			<?php else : ?>
			<!-- Login Button -->
			<a href="<?php echo esc_url( wp_login_url( get_permalink() ) ); ?>" class="btn btn-primary">
				<?php _e( 'Đăng nhập', 'pinterhvn-theme' ); ?>
			</a>
			<?php endif; ?>
		</div>
	</div>
