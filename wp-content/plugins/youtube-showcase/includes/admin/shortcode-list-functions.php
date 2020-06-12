<?php
add_action('emd_show_shortcodes_page','emd_show_shortcodes_page',1);
/**
 * Show shortcodes builder page
 *
 * @param string $app
 * @since WPAS 4.4
 *
 * @return html page content
 */
if (!function_exists('emd_show_shortcodes_page')) {
	function emd_show_shortcodes_page($app){
		global $title;
		add_thickbox();
		?>
		<div class="wrap">
		<h2><?php 
		$has_bulk = 0;
		if(function_exists('emd_std_media_js') || function_exists('emd_analytics_media_js')){	
			echo '<span style="padding-right:10px;">' . __('Visual ShortCode Builder','emd-plugins') . '</span>'; 
			$has_bulk = 1;
			$create_url = admin_url('admin.php?page=' . $app . '_shortcodes#TB_inline?width=640&height=750&inlineId=wpas-component');
			echo '<a href="' . $create_url . '" class="thickbox button button-primary">' . esc_html('Create New', 'emd-plugins') . '</a>';
			echo '</h2>';
			echo '<p>' . __('The following shortcodes are provided by default. To use the shortcode, click copy button and paste it in a page.','emd-plugins');
			echo ' ' . __('To create advanced shortcodes click Create New button.','emd-plugins') . '</p>';
		}
		else {
			echo '<span style="padding-right:10px;">' . __('ShortCodes','emd-plugins') . '</span>'; 
			echo '<a href="#" class="button button-primary btn-primary upgrade-pro">' . esc_html('Create New', 'emd-plugins') . '</a>';
			echo '<a href="#" class="add-new-h2 upgrade-pro" style="padding:6px 10px;">' . esc_html('Import', 'emd-plugins') . '</a>';
			echo '<a href="#" class="add-new-h2 upgrade-pro" style="padding:6px 10px;">' . esc_html('Export', 'emd-plugins') . '</a>';
			echo '</h2>';
			echo '<p>' . __('The following shortcodes are provided by default. To use the shortcode, click copy button and paste it in a page.','emd-plugins');
			echo ' ' . sprintf(__('To learn more on how to create new shortcodes with filters go to the %s documentation.%s','emd-plugins'),'<a href="https://docs.emdplugins.com/docs/' . str_replace('_','-',$app) . '" target="_blank">','</a>') . '</p>';
			echo '<style>.tablenav.top{display:none;}</style>';
		}
		$list_table = new Emd_List_Table($app,'shortcode',$has_bulk);
                $list_table->prepare_items();
?>
		<div class="emd-shortcode-list-admin-content">
		<form id="emd-shortcode-list-table" method="get" action="<?php echo admin_url( 'admin.php?page=' . $app . '_shortcodes'); ?>">
		<input type="hidden" name="page" value="<?php echo $app . '_shortcodes';?>"/>
		<?php $list_table->views(); ?>
		<?php $list_table->display(); ?>
		</form>
		</div>
<?php
	}
}
