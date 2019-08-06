/**
 * Trigger AJAX request to save state when the WooCommerce notice is dismissed.
 *
 * @version 2.3.0
 *
 * @author StudioPress
 * @license GPL-2.0-or-later
 * @package GenesisRoyal Navy Golfing Society
 */

jQuery( document ).on(
	'click', '.genesis-rngs-woocommerce-notice .notice-dismiss', function() {

		jQuery.ajax(
			{
				url: ajaxurl,
				data: {
					action: 'genesis_rngs_dismiss_woocommerce_notice'
				}
			}
		);

	}
);
