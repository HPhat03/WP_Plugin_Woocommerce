<?php

namespace Brandy\Utils\Walkers;

class MenuWalker extends \Walker_Nav_Menu {

	public $menu_settings = null;

	public $layout = 'horizontal';

	public $level_output = array(
		'parent' => 'menu_item_parent',
		'id'     => 'db_id',
	);

	public $max_depth = PHP_INT_MAX;

	public $sub_menus = array();

	public function __construct( $settings, $layout = 'horizontal', $max_depth = PHP_INT_MAX ) {
		$this->menu_settings = $settings;
		$this->layout        = $layout;
		$this->max_depth     = $max_depth;
		add_filter( 'wp_nav_menu', array( $this, 'push_submenus' ), 100, 2 );
		add_filter( 'wp_page_menu', array( $this, 'push_submenus' ), 100, 2 );

	}

	public function push_submenus( $menu, $args ) {
		if ( 'vertical' === $this->layout ) {
			foreach ( array_reverse( $this->sub_menus ) as $sub_menu ) {
				$menu .= $sub_menu;
			}
		}
		remove_filter( 'wp_nav_menu', array( $this, 'push_submenus' ), 100 );
		remove_filter( 'wp_page_menu', array( $this, 'push_submenus' ), 100 );
		return $menu;
	}

	public function start_lvl( &$output, $depth = 1, $args = null, $element = null ) {
		if ( 'horizontal' === $this->layout ) {
			$output .= "\n<ul class='brandy-sub-menu'>\n";
		} else {
			$output .= "\n<ul class='brandy-sub-menu' parent-key='" . $element->object_id . "'>\n";
		}
	}

	public function end_lvl( &$output, $depth = 1, $args = null ) {
		$output .= '</ul>';
	}

	public function start_el( &$output, $item, $depth = 1, $args = array(), $id = 0 ) {
		if ( 'horizontal' === $this->layout ) {
			$this->start_el_horizontal( $output, $item, $depth, $args, $id );
		} else {
			$this->start_el_vertical( $output, $item, $depth, $args, $id );
		}
	}

	public function start_el_horizontal( &$output, $item, $depth = 1, $args = array(), $id = 0 ) {
		$item->classes       = empty( $item->classes ) ? array() : $item->classes;
		$has_children        = in_array( 'menu-item-has-children', $item->classes, true );
		$current_parent_item = $item->current_item_parent || in_array( 'current-menu-ancestor', $item->classes, true );
		$item_classes        = 'brandy-menu__item horizontal-item';
		if ( $item->current ) {
			$item_classes .= ' current-menu-item';
		}
		if ( $current_parent_item ) {
			$item_classes .= ' current-parent-item';
		}
		if ( $depth > 0 ) {
			$item_classes .= ' brandy-sub-menu__item';
		} else {
			$item_classes .= ' root-item';
		}
		if ( $has_children ) {
			$item_classes .= ' menu-item-has-children';
		}

		$item_attributes = array(
			'class'      => esc_attr( $item_classes ),
			'aria-label' => esc_html( $item->title ),
			'menu-key'   => esc_attr( $item->object_id ),
			'role'       => 'menuitem',
		);

		ob_start();
		?>
		<li <?php brandy_print_dom_attributes( $item_attributes ); ?> tabindex="<?php echo ( $item->current || $current_parent_item ) ? '0' : '-1'; ?>">
			<?php
			if ( 'yaycurrency-switcher' === $item->post_name ) :
				echo '<div>';
				echo do_shortcode( '[yaycurrency-menu-item-switcher]' );
				echo '</div>';
				?>
			<?php else : ?>
				<a href=<?php echo esc_url( $item->url ); ?>>
					<span class="brandy-menu-item__title"><?php echo do_shortcode( $item->title ); ?></span>
					<?php if ( $has_children ) : ?>
						<span class="brandy-menu-item__arrow">⌃</span>
					<?php endif; ?>
				</a>
			<?php endif; ?>
		<?php
		$html = ob_get_contents();
		ob_end_clean();
		$output .= $html;
	}

	public function start_el_vertical( &$output, $item, $depth = 1, $args = array(), $id = 0 ) {
		$item->classes       = empty( $item->classes ) ? array() : $item->classes;
		$has_children        = in_array( 'menu-item-has-children', $item->classes, true );
		$current_parent_item = $item->current_item_parent || in_array( 'current-menu-ancestor', $item->classes, true );

		$item_classes = 'brandy-menu__item vertical-item';
		if ( $item->current ) {
			$item_classes .= ' current-menu-item';
		}
		if ( $current_parent_item ) {
			$item_classes .= ' current-parent-item';
		}
		if ( $depth > 0 ) {
			$item_classes .= ' brandy-sub-menu__item';
		}
		if ( $has_children ) {
			$item_classes .= ' menu-item-has-children';
		}

		$item_attributes = array(
			'class'      => esc_attr( $item_classes ),
			'aria-label' => esc_html( $item->title ),
			'menu-key'   => esc_attr( $item->object_id ),
			'role'       => 'menuitem',
		);
		ob_start();
		?>
		<li <?php brandy_print_dom_attributes( $item_attributes ); ?> tabindex="<?php echo ( $item->current || $current_parent_item ) ? '0' : '-1'; ?>">
			<a href=<?php echo esc_url( $item->url ); ?>>
				<span class="brandy-menu-item__title"><?php echo do_shortcode( $item->title ); ?></span>
				<?php if ( $has_children && 1 != $this->max_depth ) : ?>
				<span class="brandy-menu-item__arrow">⌃</span>
				<?php endif; ?>
			</a>
		</li>
		<?php
		$html = ob_get_contents();
		ob_end_clean();
		$output .= $html;
	}

	public function end_el( &$output, $item, $depth = 1, $args = array() ) {
		$output .= '</li>';
	}

	public function display_element( $element, &$children_elements, $max_depth, $depth, $args, &$output ) {
		if ( 'page' === $element->post_type ) {
			if ( get_the_id() === $element->ID ) {
				$element->current = true;
			}
			$element->title     = $element->post_title;
			$element->url       = get_permalink( $element->ID );
			$element->object_id = $element->ID;
		}

		if ( 'horizontal' === $this->layout ) {
			$this->start_el_horizontal( $output, $element, $depth, $args );
			foreach ( $children_elements as $parent_id => $sub_elements ) {
				if ( $element->ID !== $parent_id ) {
					continue;
				}
				$this->start_lvl( $output );
				foreach ( $sub_elements as $sub_element ) {
					$this->display_element( $sub_element, $children_elements, $max_depth, $depth + 1, $args, $output );
				}
				$this->end_lvl( $output );
			}
			$this->end_el( $output, $element );
		} else {
			$this->start_el_vertical( $output, $element, $depth, $args );
			$this->end_el( $output, $element );
			foreach ( $children_elements as $parent_id => $sub_elements ) {
				if ( $element->ID !== $parent_id ) {
					continue;
				}
				$sub_menu_content = '';
				$this->start_lvl( $sub_menu_content, $depth + 1, $args, $element );
				foreach ( $sub_elements as $sub_element ) {
					$this->display_element( $sub_element, $children_elements, $max_depth, $depth + 1, $args, $sub_menu_content );
				}
				$this->end_lvl( $sub_menu_content );
				$this->sub_menus[] = $sub_menu_content;
			}
		}
	}

}
