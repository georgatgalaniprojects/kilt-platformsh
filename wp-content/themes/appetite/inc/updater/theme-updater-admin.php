<?php
/**
 * Theme updater admin page and functions.
 *
 * @package EDD Sample Theme
 */

class EDD_Theme_Updater_Admin {

	/**
	 * Variables required for the theme updater
	 *
	 * @since 1.0.0
	 * @type string
	 */
	 protected $remote_api_url = null;
	 protected $theme_slug = null;
	 protected $version = null;
	 protected $author = null;
	 protected $download_id = null;
	 protected $renew_url = null;
	 protected $strings = null;

	/**
	 * Initialize the class.
	 *
	 * @since 1.0.0
	 */
	function __construct( $config = array(), $strings = array() ) {

		$config = wp_parse_args( $config, array(
			'remote_api_url' => '',
			'theme_slug' => get_template(),
			'item_name' => '',
			'license' => '',
			'version' => '',
			'author' => '',
			'download_id' => '',
			'renew_url' => '',
			'beta' => false,
		) );

		// Set config arguments
		$this->remote_api_url = $config['remote_api_url'];
		$this->item_name = sanitize_key( $config['item_name'] );
		$this->theme_slug = sanitize_key( $config['theme_slug'] );
		$this->version = $config['version'];
		$this->author = $config['author'];
		$this->download_id = $config['download_id'];
		$this->renew_url = $config['renew_url'];
		$this->beta = $config['beta'];

		// Populate version fallback
		if ( '' == $config['version'] ) {
			$theme = wp_get_theme( $this->theme_slug );
			$this->version = $theme->get( 'Version' );
		}

		// Strings passed in from the updater config
		$this->strings = $strings;

		add_action( 'init', array( $this, 'updater' ) );
		add_action( 'admin_init', array( $this, 'register_option' ) );
		add_action( 'admin_init', array( $this, 'license_action' ) );
        add_action( 'admin_init', array( $this, 'redirect_on_activation' ) );
		add_action( 'admin_menu', array( $this, 'license_menu' ) );
		add_action( 'update_option_' . $this->theme_slug . '_license_key', array( $this, 'activate_license' ), 10, 2 );
		add_action( 'admin_notices', array( $this, 'show_license_notice' ), 7 );
		add_filter( 'http_request_args', array( $this, 'disable_wporg_request' ), 5, 2 );
        add_filter( 'site_transient_update_themes', array( $this, 'transient_update_themes' ) );
		add_filter( 'transient_update_themes', array( $this, 'transient_update_themes' ) );
        add_action( 'admin_enqueue_scripts', array( $this, 'admin_scripts' ) );

		add_action( 'admin_head', array( $this, 'dismiss_license_notice' ) );
		add_action( 'current_screen', array( $this, 'automatically_update_license_status' ) );
	}

	/**
	 * Creates the updater class.
	 *
	 * since 1.0.0
	 */
	function updater() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		if ( ! class_exists( 'EDD_Theme_Updater' ) ) {
			// Load our custom theme updater
			include( dirname( __FILE__ ) . '/theme-updater-class.php' );
		}

		new EDD_Theme_Updater(
			array(
				'remote_api_url' => $this->remote_api_url,
				'version' => $this->version,
				'license' => trim( get_option( $this->theme_slug . '_license_key' ) ),
				'item_name' => $this->item_name,
				'author' => $this->author,
				'beta' => $this->beta,
				'license_status' => $this->get_license_status(),
			),
			$this->strings
		);
	}

	/**
	 * Get local license status.
	 *
	 * Note if inactive, value is empty
	 *
	 * @return string status active, expired or empty (inactive)
	 */
	function get_license_status() {
		return get_option( $this->theme_slug . '_license_key_status', false );
	}

	/**
	 * Get local license key value.
	 *
	 * @return string license key value
	 */
	function get_license_key() {
		return trim( get_option( $this->theme_slug . '_license_key' ) );
	}

	/**
	 * Check if the license is locally active.
	 *
	 * @return bool True if active
	 */
	function is_license_active() {
		$active = false;

		if ( 'valid' === $this->get_license_status() ) {
			$active = true;
		}

		return $active;
	}

	/**
	 * Adds a menu item for the theme license under the appearance menu.
	 *
	 * since 1.0.0
	 */
	function license_menu() {

		$strings = $this->strings;

		add_theme_page(
			$strings['label']['getting_started'],
			$strings['label']['getting_started'],
			'manage_options',
			$this->theme_slug . '-license',
			array( $this, 'license_page' )
		);
	}

	/**
	 * Outputs the markup used on the theme license page.
	 *
	 * since 1.0.0
	 */
	function license_page() {
		$strings = $this->strings;

		$license = $this->get_license_key();
		$status = $this->get_license_status();

		// Checks license status to display under license key.
		if ( ! $license ) {
			$message = $strings['label']['enter_key'];
		} else {
			//delete_transient( $this->theme_slug . '_license_message' );
			if ( ! get_transient( $this->theme_slug . '_license_message', false ) ) {
				set_transient( $this->theme_slug . '_license_message', $this->check_license(), ( 60 * 60 * 24 ) );
			}

			$message = get_transient( $this->theme_slug . '_license_message' );
		}

        $changelog = get_transient( $this->theme_slug . '-update-response' );

        // Gets theme information.
        $theme = wp_get_theme( $this->theme_slug ); ?>

        <div class="wrap">

            <div id="getting-started" class="getting-started">
				<div class="page-header wp-clearfix">
				    <img src="<?php echo esc_url( get_template_directory_uri() . '/screenshot.png' ); ?>" alt="<?php esc_attr( $theme['Name'] ); ?>" class="theme-screenshot" />

					<div class="theme-info">
						<h1 class="page-title">
							<span><?php echo $strings['label']['getting_started'] ?></span>
							<?php echo esc_html( $theme['Name'] ); ?>
						</h1>
				        <div class="theme-description"><?php echo esc_html( $theme['Description'] ); ?></div>

						<div class="theme-meta wp-clearfix">
				            <p class="theme-version"><?php printf( $strings['label']['theme_version'], '<span>' . $theme['Version'] . '</span>' ); ?></p>

				            <p class="theme-author"><?php printf( $strings['label']['theme_author'], '<a href="'. esc_url( $theme['AuthorURI'] ) .'">' . $theme['Author'] . '</a>' ); ?></p>
				        </div><!-- .theme-meta -->
				    </div><!-- .theme-info -->
				</div><!-- .page-header -->

				<div class="page-content wp-clearfix">

					<ul class="page-tabs wp-clearfix">
				        <li class="active"><a href="#help"><?php echo $strings['label']['documentation']; ?></a></li>
				        <li><a href="#changelog"><?php echo $strings['label']['latest_updates']; ?></a></li>
				    </ul><!-- .page-tabs -->

					<div class="page-panels">

				        <div id="help" class="single-panel active">
				        	<?php
							$rss_url = esc_url( $this->remote_api_url . '/documentation/' . $this->theme_slug . '/feed/?withoutcomments=1' );

							$rss = fetch_feed( $rss_url );

				            if ( ! is_wp_error( $rss ) ) {
				                $maxitems = $rss->get_item_quantity( 1 );
				                $rss_items = $rss->get_items( 0, $maxitems );

				                if ( ! empty( $rss_items ) ) {
				                    foreach ( $rss_items as $item )  {
				                        echo $this->add_youtube_embeds( $item->get_content() );
				                    }
				                }

				            } else {
				                echo $strings['notice']['feed_error'];
				            } ?>
				        </div><!-- #help -->

				        <div id="changelog" class="single-panel">
					    <?php
							if ( $changelog && isset( $changelog->sections['changelog'] ) ) {
								echo $changelog->sections['changelog'];
							} else {
								echo $strings['notice']['latest_updates_error'];
							}
						?>
				        </div><!-- #changelog -->
				    </div><!-- .page-panels -->

					<div class="page-sidebar">
				        <div class="sidebar-widget">

				            <form class="license-form" method="post" action="options.php">
				                <?php settings_fields( $this->theme_slug . '-license' ); ?>

				                <div class="license-row">
				                    <p class="description"><?php echo $message; ?></p>

				                    <?php if ( $license ) : ?>

				                        <?php if ( 'valid' === $status ) : ?>
				                            <input type="submit" class="button-secondary" name="<?php echo $this->theme_slug; ?>_license_deactivate" value="<?php echo esc_attr( $strings['action']['deactivate_license'] ); ?>"/>
				                        <?php else : ?>
				                            <input type="submit" class="button-secondary" name="<?php echo $this->theme_slug; ?>_license_activate" value="<?php echo esc_attr( $strings['action']['activate_license'] ); ?>"/>
				                        <?php endif; ?>

				                    <?php endif; ?>

				                </div><!-- .license-row -->

				                <input id="<?php echo $this->theme_slug; ?>_license_key" name="<?php echo $this->theme_slug; ?>_license_key" type="text" class="regular-text license-key-input" value="<?php echo esc_attr( $license ); ?>" placeholder="<?php echo esc_attr( $strings['label']['license_key'] ); ?>"/>

				                <input type="submit" class="button-primary" name="submit" value="<?php echo esc_attr( $strings['action']['save_license'] ); ?>"/>

				                <?php wp_nonce_field( $this->theme_slug . '_nonce', $this->theme_slug . '_nonce' ); ?>

				            </form><!-- .enter-license -->

				        </div><!-- .sidebar-widget -->
				    </div><!-- .page-sidebar -->
				</div><!-- .page-content -->
            </div><!-- .getting-started -->
        </div><!-- .wrap -->
		<?php
	}

	/**
	 * Registers the option used to store the license key in the options table.
	 *
	 * since 1.0.0
	 */
	function register_option() {
		register_setting(
			$this->theme_slug . '-license',
			$this->theme_slug . '_license_key',
			array( $this, 'sanitize_license' )
		);
	}

	/**
	 * Sanitizes the license key.
	 *
	 * since 1.0.0
	 *
	 * @param string $new License key that was submitted.
	 * @return string $new Sanitized license key.
	 */
	function sanitize_license( $new ) {

		$old = $this->get_license_key();

		if ( $old && $old != $new ) {
			// New license has been entered, so must reactivate
			delete_option( $this->theme_slug . '_license_key_status' );
			delete_transient( $this->theme_slug . '_license_message' );
		}

		$new = trim( $new );

		return $new;
	}

	/**
	 * Makes a call to the API.
	 *
	 * @since 1.0.0
	 *
	 * @param array $api_params to be used for wp_remote_get.
	 * @return array $response decoded JSON response.
	 */
	 function get_api_response( $api_params ) {

		// Call the custom API.
		$verify_ssl = (bool) apply_filters( 'edd_sl_api_request_verify_ssl', true );

		$response = wp_remote_post( $this->remote_api_url, array(
			'timeout' => 15,
			'sslverify' => $verify_ssl,
			'body' => $api_params,
		) );

		$strings = $this->strings;

		// Make sure the response came back okay.
		if ( is_wp_error( $response ) ) {
			wp_die( $response->get_error_message(), $strings['status']['error'] . $response->get_error_code() );
		}

		return $response;
	 }

	/**
	 * Activates the license key.
	 *
	 * @since 1.0.0
	 */
	function activate_license() {

		$strings = $this->strings;

		// Data to send in our API request.
		$api_params = array(
			'edd_action' => 'activate_license',
			'license' => $this->get_license_key(),
			'item_name' => urlencode( $this->item_name ),
			'url' => home_url(),
		);

		$response = $this->get_api_response( $api_params );

		// make sure the response came back okay
		if ( is_wp_error( $response ) || 200 !== wp_remote_retrieve_response_code( $response ) ) {

			if ( is_wp_error( $response ) ) {
				$message = $response->get_error_message();
			} else {
				$message = $strings['notice']['error_occurred'];
			}

		} else {

			$license_data = json_decode( wp_remote_retrieve_body( $response ) );

			if ( false === $license_data->success ) {

				//delete_transient( $this->theme_slug . '_license_message' );

				switch( $license_data->error ) {

					case 'expired' :

						$message = sprintf(
							$strings['notice']['license_key_expired_%s'],
							date_i18n( get_option( 'date_format' ), strtotime( $license_data->expires, current_time( 'timestamp' ) ) )
						);
						break;

					case 'revoked' :

						$message = $strings['notice']['license_is_revoked'];
						break;

					case 'missing' :

						$message = $strings['notice']['license_is_invalid'];
						break;

					case 'invalid' :
					case 'site_inactive' :

						$message = $strings['notice']['site_inactive'];
						break;

					case 'item_name_mismatch' :

						$message = sprintf( $strings['notice']['item_name_mismatch_%s'], $api_params['item_name'] );
						break;

					case 'no_activations_left':

						$message = $strings['notice']['no_activations_left'];
						break;

					default :

						$message = $strings['notice']['error_occurred'];
						break;
				}

				if ( ! empty( $message ) ) {
					$base_url = admin_url( 'themes.php?page=' . $this->theme_slug . '-license' );
					$redirect = add_query_arg( array( 'sl_theme_activation' => 'false', 'message' => urlencode( $message ) ), $base_url );

					wp_redirect( $redirect );
					exit();
				}

			}

		}

		// $response->license will be either "active" or "inactive"
		if ( $license_data && isset( $license_data->license ) ) {
			update_option( $this->theme_slug . '_license_key_status', $license_data->license );
			delete_transient( $this->theme_slug . '_license_message' );
		}

		wp_redirect( admin_url( 'themes.php?page=' . $this->theme_slug . '-license' ) );
		exit();

	}

	/**
	 * Deactivates the license key.
	 *
	 * @since 1.0.0
	 */
	function deactivate_license() {

		$strings = $this->strings;

		// Data to send in our API request.
		$api_params = array(
			'edd_action' => 'deactivate_license',
			'license' => $this->get_license_key(),
			'item_name' => urlencode( $this->item_name ),
			'url' => home_url(),
		);

		$response = $this->get_api_response( $api_params );

		// make sure the response came back okay
		if ( is_wp_error( $response ) || 200 !== wp_remote_retrieve_response_code( $response ) ) {

			if ( is_wp_error( $response ) ) {
				$message = $response->get_error_message();
			} else {
				$message = $strings['notice']['error_occurred'];
			}

		} else {

			$license_data = json_decode( wp_remote_retrieve_body( $response ) );

			// $license_data->license will be either "deactivated" or "failed"
			if ( $license_data && ( $license_data->license == 'deactivated' ) ) {
				delete_option( $this->theme_slug . '_license_key_status' );
				delete_transient( $this->theme_slug . '_license_message' );
			}
		}

		if ( ! empty( $message ) ) {
			$base_url = admin_url( 'themes.php?page=' . $this->theme_slug . '-license' );
			$redirect = add_query_arg( array( 'sl_theme_activation' => 'false', 'message' => urlencode( $message ) ), $base_url );

			wp_redirect( $redirect );
			exit();
		}

		wp_redirect( admin_url( 'themes.php?page=' . $this->theme_slug . '-license' ) );
		exit();

	}

	/**
	 * Constructs a renewal link
	 *
	 * @since 1.0.0
	 */
	function get_renewal_link() {

		// If a renewal link was passed in the config, use that
		if ( '' != $this->renew_url ) {
			return $this->renew_url;
		}

		// If download_id was passed in the config, a renewal link can be constructed
		$license_key = trim( get_option( $this->theme_slug . '_license_key', false ) );
		if ( '' != $this->download_id && $license_key ) {
			$url = esc_url( $this->remote_api_url );
			$url .= '/checkout/?edd_license_key=' . $license_key . '&download_id=' . $this->download_id;
			return $url;
		}

		// Otherwise return the remote_api_url
		return $this->remote_api_url;

	}

	/**
	 * Checks if a license action was submitted.
	 *
	 * @since 1.0.0
	 */
	function license_action() {
		if ( isset( $_POST[ $this->theme_slug . '_license_activate' ] ) ) {
			if ( check_admin_referer( $this->theme_slug . '_nonce', $this->theme_slug . '_nonce' ) ) {
				$this->activate_license();
			}
		}

		if ( isset( $_POST[$this->theme_slug . '_license_deactivate'] ) ) {
			if ( check_admin_referer( $this->theme_slug . '_nonce', $this->theme_slug . '_nonce' ) ) {
				$this->deactivate_license();
			}
		}
	}

	/**
	 * Checks if license is valid and gets expire date.
	 *
	 * @since 1.0.0
	 *
	 * @return string $message License status message.
	 */
	function check_license() {

		$strings = $this->strings;

		$api_params = array(
			'edd_action' => 'check_license',
			'license' => $this->get_license_key(),
			'item_name' => urlencode( $this->item_name ),
			'url' => home_url(),
		);

		$response = $this->get_api_response( $api_params );

		// make sure the response came back okay
		if ( is_wp_error( $response ) || 200 !== wp_remote_retrieve_response_code( $response ) ) {

			if ( is_wp_error( $response ) ) {
				$message = $response->get_error_message();
			} else {
				$message = $strings['notice']['license_status_unknown'];
			}

		} else {

			$license_data = json_decode( wp_remote_retrieve_body( $response ) );

			// If response doesn't include license data, return.
			if ( ! isset( $license_data->license ) ) {
				return $strings['notice']['license_status_unknown'];
			}

			// We need to update the license status at the same time the message is updated
			if ( $license_data && isset( $license_data->license ) ) {
				update_option( $this->theme_slug . '_license_key_status', $license_data->license );
			}

			// Get expire date
			$expires = false;
			if ( isset( $license_data->expires ) && 'lifetime' != $license_data->expires ) {
				$expires = date_i18n( get_option( 'date_format' ), strtotime( $license_data->expires, current_time( 'timestamp' ) ) );
				$renew_link = '<a href="' . esc_url( $this->get_renewal_link() ) . '" target="_blank">' . $strings['action']['renew_license'] . '</a>';
			} elseif ( isset( $license_data->expires ) && 'lifetime' == $license_data->expires ) {
				$expires = 'lifetime';
			}

            // Stop and return message if invalid.
            if ( $license_data->license == 'invalid' ) {
				return $strings['notice']['license_keys_dont_match'];
			}

			// Get site counts
			$site_count = $license_data->site_count;
			$license_limit = $license_data->license_limit;

			// If unlimited
			if ( 0 == $license_limit ) {
				$license_limit = $strings['notice']['unlimited'];
			}

			if ( $license_data->license == 'valid' ) {
				$message = $strings['notice']['license_is_active'] . ' ';
				if ( isset( $expires ) && 'lifetime' != $expires ) {
					$message .= sprintf( $strings['notice']['expires_%s'], $expires ) . ' ';
				}
				if ( isset( $expires ) && 'lifetime' == $expires ) {
					$message .= $strings['notice']['license_expires_never'];
				}
				if ( $site_count && $license_limit ) {
					$message .= sprintf( $strings['notice']['%1$s_%2$_sites'], $site_count, $license_limit );
				}
			} else if ( $license_data->license == 'expired' ) {
				if ( $expires ) {
					$message = sprintf( $strings['notice']['license_key_expired_%s'], $expires );
				} else {
					$message = $strings['notice']['license_key_expired'];
				}
				if ( $renew_link ) {
					$message .= ' ' . $renew_link;
				}
			} else if ( $license_data->license == 'inactive' ) {
				$message = $strings['notice']['license_is_inactive'];
			} else if ( $license_data->license == 'disabled' ) {
				$message = $strings['notice']['license_is_disabled'];
			} else if ( $license_data->license == 'site_inactive' ) {
				// Site is inactive
				$message = $strings['notice']['site_is_inactive'];
			} else {
				$message = $strings['notice']['license_status_unknown'];
			}

		}

		return $message;
	}

	/**
	 * Disable requests to wp.org repository for this theme.
	 *
	 * @since 1.0.0
	 */
	function disable_wporg_request( $r, $url ) {

		// If it's not a theme update request, bail.
		if ( 0 !== strpos( $url, 'https://api.wordpress.org/themes/update-check/1.1/' ) ) {
 			return $r;
 		}

 		// Decode the JSON response
 		$themes = json_decode( $r['body']['themes'] );

 		// Remove the active parent and child themes from the check
 		$parent = get_option( 'template' );
 		$child = get_option( 'stylesheet' );
 		unset( $themes->themes->$parent );
 		unset( $themes->themes->$child );

 		// Encode the updated JSON response
 		$r['body']['themes'] = json_encode( $themes );

 		return $r;
	}

    /**
     * Load Getting Started styles in the admin.
     *
     * since 1.0.0
     */
    function admin_scripts() {

        global $pagenow;

        if ( 'themes.php' != $pagenow ) {
            return;
        }

        // Getting Started javascript
        wp_enqueue_script( 'getting-started', get_template_directory_uri() . '/inc/updater/assets/getting-started.js', array( 'jquery' ), '1.0.0', true );
        wp_enqueue_script( 'fitvids', get_template_directory_uri() . '/inc/updater/assets/jquery.fitvids.js', array( 'jquery' ), '1.1', true );

        // Getting Started styles
        wp_enqueue_style( 'getting-started', get_template_directory_uri() . '/inc/updater/assets/getting-started.css', false, '1.0.0' );
    }

    /**
     * Find youtube links and replace it with video player.
     *
     * since 1.0.0
     */
    function add_youtube_embeds( $content ) {

        $youtube_regex = '@(http|https)://(www\.)?youtu[^\s]*@i';
        $matches = array();

        preg_match_all( $youtube_regex, $content, $matches );

        foreach ( $matches[0] as $match ) {
            $youtube_embed = '<div class="responsive-video">' . wp_oembed_get( wp_strip_all_tags( $match ) ) . '</div>';

            $content = str_replace( $match, $youtube_embed, $content );
        }

        return $content;

    }

    /**
     * Redirect to Getting Started page on theme activation.
     *
     * since 1.0.0
     */
    function redirect_on_activation() {
        global $pagenow;

        if ( is_admin() && 'themes.php' == $pagenow && isset( $_GET['activated'] ) ) {
            wp_redirect( admin_url( 'themes.php?page=' . $this->theme_slug . '-license' ) );
        }
    }

     /**
	 * Prevent the theme to get updates from WordPress.org.
	 *
	 * since 1.0.0
	 */
    function transient_update_themes( $transient ) {

        if ( is_object( $transient ) && isset( $transient->response ) ) {

            $response = $transient->response;

            if ( isset( $response[$this->theme_slug]['url'] ) && 0 === strpos( $response[$this->theme_slug]['url'], 'https://wordpress.org/themes/' ) ) {
                unset( $response[$this->theme_slug] );
                $transient->response = $response;
            }
        }

        return $transient;
    }

	/**
	 * Update the license status.
	 */
	function update_license_status() {
		$api_params = array(
			'edd_action' => 'check_license',
			'license' => $this->get_license_key(),
			'item_name' => urlencode( $this->item_name ),
			'url' => home_url(),
		);

		$response = $this->get_api_response( $api_params );

		// Make sure the response came back okay.
		if ( ! is_wp_error( $response ) || 200 === wp_remote_retrieve_response_code( $response ) ) {
			$license_data = json_decode( wp_remote_retrieve_body( $response ) );

			if ( $license_data && isset( $license_data->license ) ) {
				update_option( $this->theme_slug . '_license_key_status', $license_data->license );
			}
		}
	}

	/**
	 * Automatically check for the license status change periodically on relevant pages.
	 */
	function automatically_update_license_status() {
		// Admin only.
		if ( ! is_admin() ) {
			return;
		}

		$screen = get_current_screen();

		if ( ! get_transient( $this->theme_slug . '_license_status_sync' ) && in_array( $screen->base, array( 'dashboard', 'themes', 'update-core' ) ) ) {
			$this->update_license_status();
			// Set transient to prevent check until next 72 hours.
			set_transient( $this->theme_slug . '_license_status_sync', true, 3 * DAY_IN_SECONDS );
		}
	}

	/**
	 * Register dismissal of license notices.
	 */
	function dismiss_license_notice() {
		if ( isset( $_GET['theme-license-notice'] ) && check_admin_referer( 'theme-license-notice' ) ) {
			set_transient( $this->theme_slug . '_hide_license_notice', true, MONTH_IN_SECONDS );
		}
	}

	/**
	 * Show inactive, expiring soon and expired license notices.
	 */
	function show_license_notice() {
		// Don't show on the notice if it was dissmised.
		if ( get_transient( $this->theme_slug . '_hide_license_notice' ) ) {
			return;
		}

		// Show only on relevant pages as not to overwhelm the admin.
		// Don't show on Theme License page -- redundant.
		$screen = get_current_screen();
		if ( ! in_array( $screen->base, array( 'dashboard', 'themes', 'update-core' ) ) ) {
			return;
		}

		// Inactive license.
		if ( ! $this->is_license_active() ) {
			$class = "notice-error";
			$notice = 'inactive_notice';
		}

		$strings = $this->strings;

		// Show the notice
		if ( ! empty( $notice ) && ! empty( $class ) ) : ?>
		<div class="notice is-dismissible wp-clearfix <?php echo esc_attr( $class ); ?>">
			<p><strong><?php echo $strings['notice']['license_is_inactive']; ?></strong></p>

			<p>
				<strong>
					<a href="<?php echo admin_url( 'themes.php?page=' . $this->theme_slug . '-license' ); ?>">
						<?php echo $strings['action']['activate_license']; ?>
					</a>
					<span> | </span>
					<a href="https://themesharbor.com/documentation/locating-license-key/" target="_blank">
						<?php echo $strings['action']['locate_license']; ?>
					</a>
					<span> | </span>
					<a href="<?php echo esc_url( wp_nonce_url( add_query_arg( 'theme-license-notice', 'dismiss_license_notice' ), 'theme-license-notice' ) ); ?>">
						<?php echo $strings['action']['dismiss_notice']; ?>
					</a>
				</strong>
			</p>
		</div><!-- .notice -->
		<?php
		endif;
	}
}

/**
 * This is a means of catching errors from the activation method above and displyaing it to the customer
 */
function edd_venture_theme_admin_notices() {
	if ( isset( $_GET['sl_theme_activation'] ) && ! empty( $_GET['message'] ) ) {

		switch( $_GET['sl_theme_activation'] ) {

			case 'false':
				$message = urldecode( $_GET['message'] );
				printf( '<div class="error"><p>%s</p></div>', $message );

				break;

			case 'true':
			default:

				break;
		}
	}
}
add_action( 'admin_notices', 'edd_venture_theme_admin_notices' );
