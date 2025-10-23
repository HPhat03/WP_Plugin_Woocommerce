<?php

namespace Brandy\BlocksOverride\Gutenberg;

use Brandy\Traits\SingletonTrait;

/**
 * Override WP latest posts block
 */
class CoreCategories {
	use SingletonTrait;

	protected function __construct() {
		add_filter( 'block_type_metadata_settings', array( $this, 'override_callback' ), 10, 2 );
	}

	/**
	 * Override block callback
	 */
	public function override_callback( $settings, $metadata ) {
		if ( 'core/categories' === $metadata['name'] ) {
			$settings['render_callback'] = array( $this, 'render_callback' );
		}
		return $settings;
	}

	public function render_callback( $attributes, $content, $block ) {
		static $block_id = 0;
		++$block_id;

		$taxonomy = get_taxonomy( $attributes['taxonomy'] );

		$args = array(
			'echo'         => false,
			'hierarchical' => ! empty( $attributes['showHierarchy'] ),
			'orderby'      => 'name',
			'show_count'   => ! empty( $attributes['showPostCounts'] ),
			'taxonomy'     => $attributes['taxonomy'],
			'title_li'     => '',
			'hide_empty'   => empty( $attributes['showEmpty'] ),
		);
		if ( ! empty( $attributes['showOnlyTopLevel'] ) && $attributes['showOnlyTopLevel'] ) {
			$args['parent'] = 0;
		}

		if ( ! empty( $attributes['displayAsDropdown'] ) ) {
			$id                       = 'wp-block-categories-' . $block_id;
			$args['id']               = $id;
			$args['name']             = $taxonomy->query_var;
			$args['value_field']      = 'slug';
			$args['show_option_none'] = sprintf(
			/* translators: %s: taxonomy's singular name */
				__( 'Select %s', 'brandy' ),
				$taxonomy->labels->singular_name
			);

			// Get current category from URL if we're on a category archive
			if ( is_category() ) {
				$current_cat = get_queried_object();
				if ( $current_cat instanceof \WP_Term ) {
					$args['selected'] = $current_cat->slug;
				}
			}

			$show_label     = empty( $attributes['showLabel'] ) ? ' screen-reader-text' : '';
			$default_label  = $taxonomy->label;
			$label_text     = ! empty( $attributes['label'] ) ? wp_kses_post( $attributes['label'] ) : $default_label;
			$wrapper_markup = '<div %1$s><label class="wp-block-categories__label' . $show_label . '" for="' . esc_attr( $id ) . '">' . $label_text . '</label>%2$s</div>';
			$items_markup   = wp_dropdown_categories( $args );
			$type           = 'dropdown';

			if ( ! is_admin() ) {
				// Inject the dropdown script immediately after the select dropdown.
				$items_markup = preg_replace(
					'#(?<=</select>)#',
					build_dropdown_script_block_core_categories( $id ),
					$items_markup,
					1
				);
			}
		} else {
			$args['walker'] = new \Brandy\Utils\Walkers\ListCategoriesWalker();
			$args['show_option_none'] = $taxonomy->labels->no_terms;

			$wrapper_markup = '<ul %1$s>%2$s</ul>';
			$items_markup   = wp_list_categories( $args );
			$type           = 'list';

			if ( ! empty( $block->context['enhancedPagination'] ) ) {
				$p = new \WP_HTML_Tag_Processor( $items_markup );
				while ( $p->next_tag( 'a' ) ) {
					$p->set_attribute( 'data-wp-on--click', 'core/query::actions.navigate' );
				}
				$items_markup = $p->get_updated_html();
			}
		}

		$wrapper_attributes = get_block_wrapper_attributes( array( 'class' => "wp-block-categories-{$type}" ) );

		return sprintf(
			$wrapper_markup,
			$wrapper_attributes,
			$items_markup
		);
	}
}
