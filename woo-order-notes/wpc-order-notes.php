<?php
/*
Plugin Name: WPC Order Notes for WooCommerce
Plugin URI: https://wpclever.net/
Description: Order notes viewer for WooCommerce.
Version: 1.3.0
Author: WPClever.net
Author URI: https://wpclever.net
Text Domain: woo-order-notes
Domain Path: /languages/
Requires at least: 4.0
Tested up to: 5.6.0
WC requires at least: 3.0
WC tested up to: 4.8.0
*/

defined( 'ABSPATH' ) || exit;

! defined( 'WOOON_VERSION' ) && define( 'WOOON_VERSION', '1.3.0' );
! defined( 'WOOON_URI' ) && define( 'WOOON_URI', plugin_dir_url( __FILE__ ) );
! defined( 'WOOON_SUPPORT' ) && define( 'WOOON_SUPPORT', 'https://wpclever.net/support?utm_source=support&utm_medium=wooon&utm_campaign=wporg' );
! defined( 'WOOON_REVIEWS' ) && define( 'WOOON_REVIEWS', 'https://wordpress.org/support/plugin/woo-order-notes/reviews/?filter=5' );
! defined( 'WOOON_CHANGELOG' ) && define( 'WOOON_CHANGELOG', 'https://wordpress.org/plugins/woo-order-notes/#developers' );
! defined( 'WOOON_DISCUSSION' ) && define( 'WOOON_DISCUSSION', 'https://wordpress.org/support/plugin/woo-order-notes' );
! defined( 'WPC_URI' ) && define( 'WPC_URI', WOOON_URI );

include 'includes/wpc-dashboard.php';
include 'includes/wpc-menu.php';
include 'includes/wpc-kit.php';

if ( ! class_exists( 'WPCleverWooon' ) ) {
	class WPCleverWooon {
		function __construct() {
			// textdomain
			add_action( 'plugins_loaded', array( $this, 'load_textdomain' ) );

			// menu
			add_action( 'admin_menu', array( $this, 'admin_menu' ) );

			// enqueue
			add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ), 99 );

			// footer
			add_action( 'admin_footer', array( $this, 'admin_footer' ) );

			// quickview
			add_action( 'wp_ajax_wooon_quickview', array( $this, 'ajax_quickview' ) );

			// settings link
			add_filter( 'plugin_action_links', array( $this, 'settings_link' ), 10, 2 );

			// order column
			add_filter( 'manage_shop_order_posts_columns', array( $this, 'shop_order_columns' ), 99 );
			add_action( 'manage_shop_order_posts_custom_column', array(
				$this,
				'shop_order_columns_content'
			), 99, 2 );
		}

		function load_textdomain() {
			load_plugin_textdomain( 'woo-order-notes', false, basename( __DIR__ ) . '/languages/' );
		}

		function admin_menu() {
			add_submenu_page( 'wpclever', esc_html__( 'WPC Order Notes', 'woo-order-notes' ), esc_html__( 'Order Notes', 'woo-order-notes' ), 'manage_options', 'wpclever-wooon', array(
				&$this,
				'admin_menu_content'
			) );
			add_submenu_page( 'woocommerce', esc_html__( 'Notes', 'woo-order-notes' ), esc_html__( 'Notes', 'woo-order-notes' ), 'manage_options', 'wpc-order-notes', array(
				&$this,
				'notes_content'
			) );
		}

		function admin_menu_content() {
			$page_slug  = 'wpclever-wooon';
			$active_tab = isset( $_GET['tab'] ) ? $_GET['tab'] : 'how';
			?>
            <div class="wpclever_settings_page wrap">
                <h1 class="wpclever_settings_page_title"><?php echo esc_html__( 'WPC Order Notes for WooCommerce', 'woo-order-notes' ) . ' ' . WOOON_VERSION; ?></h1>
                <div class="wpclever_settings_page_desc about-text">
                    <p>
						<?php printf( esc_html__( 'Thank you for using our plugin! If you are satisfied, please reward it a full five-star %s rating.', 'woo-order-notes' ), '<span style="color:#ffb900">&#9733;&#9733;&#9733;&#9733;&#9733;</span>' ); ?>
                        <br/>
                        <a href="<?php echo esc_url( WOOON_REVIEWS ); ?>"
                           target="_blank"><?php esc_html_e( 'Reviews', 'woo-order-notes' ); ?></a> | <a
                                href="<?php echo esc_url( WOOON_CHANGELOG ); ?>"
                                target="_blank"><?php esc_html_e( 'Changelog', 'woo-order-notes' ); ?></a>
                        | <a href="<?php echo esc_url( WOOON_DISCUSSION ); ?>"
                             target="_blank"><?php esc_html_e( 'Discussion', 'woo-order-notes' ); ?></a>
                    </p>
                </div>
                <div class="wpclever_settings_page_nav">
                    <h2 class="nav-tab-wrapper">
                        <a href="?page=<?php echo $page_slug; ?>&amp;tab=how"
                           class="nav-tab <?php echo $active_tab == 'how' ? 'nav-tab-active' : ''; ?>">
							<?php esc_html_e( 'How to use?', 'woo-order-notes' ); ?>
                        </a>
                        <a href="<?php echo esc_url( WOOON_SUPPORT ); ?>" target="_blank" class="nav-tab">
							<?php esc_html_e( 'Support', 'woo-order-notes' ); ?>
                        </a>
                        <a href="<?php echo esc_url( admin_url( 'admin.php?page=wpclever-kit' ) ); ?>"
                           class="nav-tab">
							<?php esc_html_e( 'Essential Kit', 'woo-order-notes' ); ?>
                        </a>
                    </h2>
                </div>
                <div class="wpclever_settings_page_content">
					<?php if ( $active_tab === 'how' ) { ?>
                        <div class="wpclever_settings_page_content_text">
                            <p><?php esc_html_e( '1. View all order notes', 'woo-order-notes' ); ?></p>
                            <p>
                                <img src="<?php echo esc_url( WOOON_URI ); ?>assets/images/how-01.jpg"/>
                            </p>
                            <p><?php esc_html_e( '2. Quick view all notes of an order', 'woo-order-notes' ); ?></p>
                            <p>
                                <img src="<?php echo esc_url( WOOON_URI ); ?>assets/images/how-02.jpg"/>
                            </p>
                            <p><?php esc_html_e( '3. Open the order page', 'woo-order-notes' ); ?></p>
                            <p>
                                <img src="<?php echo esc_url( WOOON_URI ); ?>assets/images/how-03.jpg"/>
                            </p>
                        </div>
					<?php } ?>
                </div>
            </div>
			<?php
		}

		function settings_link( $links, $file ) {
			static $plugin;

			if ( ! isset( $plugin ) ) {
				$plugin = plugin_basename( __FILE__ );
			}

			if ( $plugin == $file ) {
				$settings = '<a href="' . admin_url( 'admin.php?page=wpclever-wooon' ) . '">' . esc_html__( 'How to use?', 'woo-order-notes' ) . '</a>';
				array_unshift( $links, $settings );
			}

			return $links;
		}

		function admin_enqueue_scripts() {
			wp_dequeue_style( 'jquery-ui-style' );
			wp_enqueue_style( 'wooon-backend', WOOON_URI . 'assets/css/backend.css' );
			wp_enqueue_script( 'wooon-backend', WOOON_URI . 'assets/js/backend.js', array(
				'jquery',
				'jquery-ui-dialog'
			), WOOON_VERSION, true );
			wp_localize_script( 'wooon-backend', 'wooon_vars', array(
					'url'   => admin_url( 'admin-ajax.php' ),
					'nonce' => wp_create_nonce( 'wooon_nonce' )
				)
			);
		}

		function notes_count() {
			global $wpdb;
			$total = 0;
			$count = $wpdb->get_results( "
					SELECT comment_approved, COUNT(*) AS num_comments
					FROM {$wpdb->comments}
					WHERE comment_type IN ('order_note')
					GROUP BY comment_approved
				", ARRAY_A );

			foreach ( (array) $count as $row ) {
				// Don't count post-trashed toward totals.
				if ( 'post-trashed' !== $row['comment_approved'] && 'trash' !== $row['comment_approved'] ) {
					$total += $row['num_comments'];
				}
			}

			return $total;
		}

		function notes_content() {
			$number      = 20;
			$total_notes = self::notes_count();
			$total_pages = floor( $total_notes / $number ) + 1;
			$page        = isset( $_GET['pg'] ) ? (int) $_GET['pg'] : 1;
			$offset      = $number * ( $page - 1 );
			?>
            <div class="wrap">
                <h1 class="wp-heading-inline">Notes</h1>
                <hr class="wp-header-end">
                <div class="tablenav top">
                    <div class="alignleft actions">
                        <select onchange="if (this.value) {window.location.href=this.value}">
                            <option>Page</option>
							<?php
							for ( $i = 1; $i <= $total_pages; $i ++ ) {
								echo '<option value="' . admin_url( 'admin.php?page=wpc-order-notes&pg=' . $i ) . '" ' . ( $page == $i ? 'selected' : '' ) . '>' . $i . '</option>';
							}
							?>
                        </select>
                    </div>
                    <div class="tablenav-pages one-page">
					<span class="displaying-num">
						<?php echo $total_notes . ' notes in ' . $total_pages . ' pages'; ?>
					</span>
                    </div>
                    <br class="clear">
                </div>
                <table class="wp-list-table widefat fixed striped posts">
                    <thead>
                    <tr>
                        <th scope="col" class="manage-column" style="width: 60px">
							<?php esc_html_e( 'Order', 'woo-order-notes' ); ?>
                        </th>
                        <th scope="col" class="manage-column">
							<?php esc_html_e( 'Note', 'woo-order-notes' ); ?>
                        </th>
                        <th scope="col" class="manage-column">
							<?php esc_html_e( 'Time', 'woo-order-notes' ); ?>
                        </th>
                        <th scope="col" class="manage-column">
							<?php esc_html_e( 'Note to customer', 'woo-order-notes' ); ?>
                        </th>
                        <th scope="col" class="manage-column">
							<?php esc_html_e( 'Quick view', 'woo-order-notes' ); ?>
                        </th>
                    </tr>
                    </thead>
                    <tbody id="the-list">
					<?php
					$args = array(
						'post_id' => 0,
						'orderby' => 'comment_ID',
						'order'   => 'DESC',
						'approve' => 'approve',
						'type'    => 'order_note',
						'number'  => $number,
						'offset'  => $offset,
					);
					remove_filter( 'comments_clauses', array( 'WC_Comments', 'exclude_order_comments' ), 10, 1 );
					$notes = get_comments( $args );
					add_filter( 'comments_clauses', array( 'WC_Comments', 'exclude_order_comments' ), 10, 1 );

					if ( $notes ) {
						foreach ( $notes as $note ) {
							$post_id  = $note->comment_post_ID;
							$order    = wc_get_order( $post_id );
							$order_id = $order->get_order_number();
							?>
                            <tr>
                                <td style="width: 60px">
                                    <a href="<?php echo get_edit_post_link( $order_id ); ?>"><strong>#<?php echo $order_id; ?></strong></a>
                                </td>
                                <td>
									<?php echo wpautop( wptexturize( wp_kses_post( $note->comment_content ) ) ); ?>
                                </td>
                                <td>
									<?php printf( esc_html__( '%1$s %2$s', 'woo-order-notes' ), date_i18n( wc_date_format(), strtotime( $note->comment_date ) ), date_i18n( wc_time_format(), strtotime( $note->comment_date ) ) ); ?><?php if ( $note->comment_author != 'WooCommerce' ) {
										printf( ' ' . esc_html__( 'by %s', 'woo-order-notes' ), $note->comment_author );
									} ?>
                                </td>
                                <td>
									<?php
									if ( get_comment_meta( $note->comment_ID, 'is_customer_note', true ) === '1' ) {
										echo '<i class="dashicons dashicons-yes"></i>';
									}
									?>
                                </td>
                                <td>
                                    <a href="#" class="wooon-quickview" data-order="<?php echo $order_id; ?>"
                                       data-current="<?php echo $note->comment_ID; ?>">
                                        <i class="dashicons dashicons-format-chat"></i>
                                    </a>
                                </td>
                            </tr>
							<?php
						}
					}
					?>
                    </tbody>
                    <tfoot>
                    <tr>
                        <th scope="col" class="manage-column" style="width: 60px">
							<?php esc_html_e( 'Order', 'woo-order-notes' ); ?>
                        </th>
                        <th scope="col" class="manage-column">
							<?php esc_html_e( 'Note', 'woo-order-notes' ); ?>
                        </th>
                        <th scope="col" class="manage-column">
							<?php esc_html_e( 'Time', 'woo-order-notes' ); ?>
                        </th>
                        <th scope="col" class="manage-column">
							<?php esc_html_e( 'Note to customer', 'woo-order-notes' ); ?>
                        </th>
                        <th scope="col" class="manage-column">
							<?php esc_html_e( 'Quick view', 'woo-order-notes' ); ?>
                        </th>
                    </tr>
                    </tfoot>
                </table>
                <div class="tablenav bottom">
                    <div class="alignleft actions">
                        <select onchange="if (this.value) {window.location.href=this.value}">
                            <option><?php esc_html_e( 'Page', 'woo-order-notes' ); ?></option>
							<?php
							for ( $i = 1; $i <= $total_pages; $i ++ ) {
								echo '<option value="' . admin_url( 'admin.php?page=wpc-order-notes&pg=' . $i ) . '" ' . ( $page == $i ? 'selected' : '' ) . '>' . $i . '</option>';
							}
							?>
                        </select>
                    </div>
                    <div class="tablenav-pages one-page">
					<span class="displaying-num">
						<?php printf( esc_html__( '%d notes in %d pages', 'woo-order-notes' ), $total_notes, $total_pages ); ?>
					</span>
                    </div>
                    <br class="clear">
                </div>
            </div>
			<?php
		}

		function admin_footer() {
			?>
            <div class="wooon-dialog" id="wooon_dialog" style="display: none"
                 title="<?php esc_html_e( 'Order Notes', 'woo-order-notes' ); ?>"></div>
			<?php
		}

		function ajax_quickview() {
			if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( $_POST['nonce'], 'wooon_nonce' ) ) {
				die( esc_html__( 'Permissions check failed', 'woo-order-notes' ) );
			}

			$notes_html = '';

			if ( isset( $_POST['order'] ) ) {
				ob_start();
				$notes = wc_get_order_notes( array( 'order_id' => $_POST['order'] ) );
				include dirname( WC_PLUGIN_FILE ) . '/includes/admin/meta-boxes/views/html-order-notes.php';
				$notes_html = ob_get_clean();
			}

			echo $notes_html;

			die();
		}

		function shop_order_columns( $columns ) {
			$columns['wooon_latest']    = esc_html__( 'Latest Note', 'woo-order-notes' );
			$columns['wooon_quickview'] = esc_html__( 'Notes', 'woo-order-notes' );

			return $columns;
		}

		function shop_order_columns_content( $column, $order_id ) {
			if ( $column == 'wooon_latest' ) {
				$args = array(
					'post_id' => (int) $order_id,
					'orderby' => 'comment_ID',
					'order'   => 'DESC',
					'approve' => 'approve',
					'type'    => 'order_note',
					'number'  => 1
				);
				remove_filter( 'comments_clauses', array( 'WC_Comments', 'exclude_order_comments' ), 10, 1 );
				$notes = get_comments( $args );
				add_filter( 'comments_clauses', array( 'WC_Comments', 'exclude_order_comments' ), 10, 1 );

				if ( $notes ) {
					foreach ( $notes as $note ) {
						?>
                        <div class="wooon_latest_note">
                            <div class="note_content">
								<?php echo wpautop( wptexturize( wp_kses_post( $note->comment_content ) ) ); ?>
                            </div>
                            <div class="note_meta">
								<?php
								printf( esc_html__( '%1$s %2$s', 'woo-order-notes' ), date_i18n( wc_date_format(), strtotime( $note->comment_date ) ), date_i18n( wc_time_format(), strtotime( $note->comment_date ) ) );

								if ( $note->comment_author != 'WooCommerce' ) {
									printf( ' ' . esc_html__( 'by %s', 'woo-order-notes' ), $note->comment_author );
								}

								if ( get_comment_meta( $note->comment_ID, 'is_customer_note', true ) === '1' ) {
									echo ' <i class="dashicons dashicons-yes"></i> ' . esc_html__( 'Note to customer', 'woo-order-notes' );
								}
								?>
                            </div>
                        </div>
						<?php
					}
				}
			}

			if ( $column == 'wooon_quickview' ) {
				?>
                <a href="#" class="wooon-quickview" data-order="<?php echo $order_id; ?>"
                   data-current="0">
                    <i class="dashicons dashicons-format-chat"></i>
                </a>
				<?php
			}
		}
	}

	new WPCleverWooon();
}