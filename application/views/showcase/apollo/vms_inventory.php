<?php
	if ( !empty( $inventory ) ) {
		$sim_value = '<div id="showcase-similar-vehicles">';
		$sim_value .= '<div id="showcase-similar-items">';
		$sim_counter = 0;
		foreach( $inventory as $inventory_sim):
			$sim_prices = $inventory_sim->prices;
			$sim_use_was_now = $sim_prices->{ 'use_was_now?' };
			$sim_use_price_strike_through = $sim_prices->{ 'use_price_strike_through?' };
			$sim_on_sale = $sim_prices->{ 'on_sale?' };
			$sim_sale_price = isset( $sim_prices->sale_price ) ? $sim_prices->sale_price : NULL;
			$sim_retail_price = $sim_prices->retail_price;
			$sim_default_price_text = $sim_prices->default_price_text;
			$sim_asking_price = $sim_prices->asking_price;

			$sim_vin = $inventory_sim->vin;
			$sim_stock_number = $inventory_sim->stock_number;
			$sim_year = $inventory_sim->year;
			$sim_drive_train = $inventory_sim->drive_train;
			$sim_make = urldecode( $inventory_sim->make );
			$sim_make_safe = str_replace( '/' , '%2F' ,  $sim_make );
			$sim_model = urldecode( $inventory_sim->model_name );
			$sim_model_safe = str_replace( '/' , '%2F' ,  $sim_model );
			$sim_trim = urldecode( $inventory_sim->trim );
			$sim_trim_safe = str_replace( '/' , '%2F' ,  $sim_trim );
			$sim_thumbnail = urldecode( $inventory_sim->photos[ 0 ]->small );
			$sim_saleclass = $inventory_sim->saleclass;
			$sim_ext_color = $inventory_sim->exterior_color;

			if( !empty( $wp_rewrite->rules ) ) {
				$sim_inventory_url = '/inventory/' . $sim_year . '/' . $sim_make_safe . '/' . $sim_model_safe . '/' . $state . '/' . $city . '/'. $sim_vin . '/';
			} else {
				$sim_inventory_url = '?taxonomy=inventory&amp;saleclass=' . $sim_saleclass . '&amp;make=' . $sim_make_safe . '&amp;model=' . $sim_model_safe . '&amp;state=' . $state . '&amp;city=' . $city . '&amp;vin='. $sim_vin;
			}

			$sim_generic_vehicle_title = $sim_year . ' ' . $sim_make . ' ' . $sim_model;

			// AIS Info
			$sim_ais_incentive = isset( $inventory_sim->ais_incentive->to_s ) ? $inventory_sim->ais_incentive->to_s : NULL;
			$sim_incentive_price = 0;
			if( $sim_ais_incentive != NULL ) {
				preg_match( '/\$\d*(\s)?/' , $sim_ais_incentive , $sim_incentive );
				$sim_incentive_price = isset( $sim_incentive[ 0 ] ) ? str_replace( '$' , NULL, $sim_incentive[ 0 ] ) : 0;
			}

			if( $sim_on_sale && $sim_sale_price > 0 ) {
				if( $sim_incentive_price > 0 ) {
					$sim_main_price = '$' . number_format( $sim_sale_price - $sim_incentive_price , 0 , '.' , ',' );
				} else {
					$sim_main_price = '$' . number_format( $sim_sale_price , 0 , '.' , ',' );
				}
			} else {
				if( $sim_asking_price > 0 ) {
					if( $sim_incentive_price > 0 ) {
						$sim_main_price = '$' . number_format( $sim_asking_price - $sim_incentive_price , 0 , '.' , ',' );
					} else {
						$sim_main_price = '$' . number_format( $sim_asking_price , 0 , '.' , ',' );
					}
				} else {
					$sim_main_price = $sim_default_price_text;
				}
			}

			if ( $sim_counter < $display_vms_count ) {
				$sim_counter = $sim_counter + 1;
				// Similar Start
				$sim_value .= '<div class="showcase-similar-item">';
				$sim_value .= '<a href="' . $sim_inventory_url . '" title="' . $sim_generic_vehicle_title . '" >';
				// Similar Photo
				$sim_value .= '<div class="showcase-similar-photo">';
				$sim_value .= '<img src="' . $sim_thumbnail . '" alt="' . $sim_generic_vehicle_title . '" title="' . $sim_generic_vehicle_title . '" />';
				$sim_value .= '</div>';
				// Similar Info
				$sim_value .= '<div class="showcase-similar-details">';
				$sim_value .= '<span class="showcase-similar-trim">' . $sim_trim . '</span>';
				$sim_value .= '<span class="showcase-similar-drive-train">' . $sim_drive_train . '</span><br>';
				$sim_value .= '<span class="showcase-similar-ext-color">Color: ' . $sim_ext_color . '</span>';
				$sim_value .= '<span class="showcase-similar-price">' . $sim_main_price . '</span>';
				$sim_value .= '</div>';
				// Similar text
				//$sim_value .= '<div class="showcase-similar-text">View</div>';
				// Similar End
				$sim_value .= '</a></div>';
			}
		endforeach;
		$sim_value .= '<div class="showcase-similar-link"><a href="/inventory/New/' . $make . '/' . $model .'/' . $added_param . '" title="Listings for ' . $make . ' ' . $model. '" >View All In-Stock</a></div>';
		$sim_value .= '</div></div>';
		echo $sim_value;
	}
?>
