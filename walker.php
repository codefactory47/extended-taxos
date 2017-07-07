<?php


/**
 * Walker to output an unordered list of category checkbox <input> elements properly.
 *
 * @uses Walker
 */
if ( ! class_exists( 'Walker_ExtendedTaxonomyCheckboxes' ) ) {
    class Walker_ExtendedTaxonomyCheckboxes extends Walker {

        /**
         * Some member variables you don't need to worry too much about:
         */
        public $tree_type = 'category';
        public $db_fields = array(
            'parent' => 'parent',
            'id'     => 'term_id',
        );
        public $field = null;

        /**
         * Class constructor.
         *
         * @param array $args Optional arguments.
         */
        public function __construct( $args = null ) {
            if ( $args && isset( $args['field'] ) ) {
                $this->field = $args['field'];
            }
        }

        /**
         * Starts the list before the elements are added.
         *
         * @param string $output Passed by reference. Used to append additional content.
         * @param int    $depth  Depth of term in reference to parents.
         * @param array  $args   Optional arguments.
         */
        public function start_lvl( &$output, $depth = 0, $args = array() ) {
            $indent = str_repeat( "\t", $depth );
            $output .= "$indent<ul class='children'>\n";
        }

        /**
         * Ends the list of after the elements are added.
         *
         * @param string $output Passed by reference. Used to append additional content.
         * @param int    $depth  Depth of term in reference to parents.
         * @param array  $args   Optional arguments.
         */
        public function end_lvl( &$output, $depth = 0, $args = array() ) {
            $indent = str_repeat( "\t", $depth );
            $output .= "$indent</ul>\n";
        }

        /**
         * Start the element output.
         *
         * @param string $output            Passed by reference. Used to append additional content.
         * @param object $object            Term data object.
         * @param int    $depth             Depth of term in reference to parents.
         * @param array  $args              Optional arguments.
         * @param int    $current_object_id Current object ID.
         */
        public function start_el( &$output, $object, $depth = 0, $args = array(), $current_object_id = 0 ) {

            $tax = get_taxonomy( $args['taxonomy'] );

            if ( $this->field ) {
                $value = $object->{$this->field};
            } else {
                $value = $tax->hierarchical ? $object->term_id : $object->name;
            }

            if ( empty( $object->term_id ) && ! $tax->hierarchical ) {
                $value = '';
            }

            $output .= "\n<li id='{$args['taxonomy']}-{$object->term_id}'>" .
                       '<label class="selectit">' .
                       '<input value="' . esc_attr( $value ) . '" type="checkbox" name="tax_input[' . esc_attr( $args['taxonomy'] ) . '][]" ' .
                       'id="in-' . esc_attr( $args['taxonomy'] ) . '-' . intval( $object->term_id ) . '"' .
                       checked( in_array( $object->term_id, (array) $args['selected_cats'] ), true, false ) .
                       disabled( empty( $args['disabled'] ), false, false ) .
                       ' /> ' .
                       esc_html( apply_filters( 'the_category', $object->name ) ) .
                       '</label>';

        }

        /**
         * Ends the element output, if needed.
         *
         * @param string $output Passed by reference. Used to append additional content.
         * @param object $object Term data object.
         * @param int    $depth  Depth of term in reference to parents.
         * @param array $args Optional arguments.
         */
        public function end_el( &$output, $object, $depth = 0, $args = array() ) {
            $output .= "</li>\n";
        }

    }
}

/**
 * A term walker class for radio buttons.
 *
 * @uses Walker
 */
if ( ! class_exists( 'Walker_ExtendedTaxonomyRadios' ) ) {
    class Walker_ExtendedTaxonomyRadios extends Walker {

        /**
         * Some member variables you don't need to worry too much about:
         */
        public $tree_type = 'category';
        public $db_fields = array(
            'parent' => 'parent',
            'id'     => 'term_id',
        );
        public $field = null;

        /**
         * Class constructor.
         *
         * @param array $args Optional arguments.
         */
        public function __construct( $args = null ) {
            if ( $args && isset( $args['field'] ) ) {
                $this->field = $args['field'];
            }
        }

        /**
         * Starts the list before the elements are added.
         *
         * @param string $output Passed by reference. Used to append additional content.
         * @param int    $depth  Depth of term in reference to parents.
         * @param array  $args   Optional arguments.
         */
        public function start_lvl( &$output, $depth = 0, $args = array() ) {
            $indent = str_repeat( "\t", $depth );
            $output .= "{$indent}<ul class='children'>\n";
        }

        /**
         * Ends the list of after the elements are added.
         *
         * @param string $output Passed by reference. Used to append additional content.
         * @param int    $depth  Depth of term in reference to parents.
         * @param array  $args   Optional arguments.
         */
        public function end_lvl( &$output, $depth = 0, $args = array() ) {
            $indent = str_repeat( "\t", $depth );
            $output .= "{$indent}</ul>\n";
        }

        /**
         * Start the element output.
         *
         * @param string $output            Passed by reference. Used to append additional content.
         * @param object $object            Term data object.
         * @param int    $depth             Depth of term in reference to parents.
         * @param array  $args              Optional arguments.
         * @param int    $current_object_id Current object ID.
         */
        public function start_el( &$output, $object, $depth = 0, $args = array(), $current_object_id = 0 ) {

            $tax = get_taxonomy( $args['taxonomy'] );

            if ( $this->field ) {
                $value = $object->{$this->field};
            } else {
                $value = $tax->hierarchical ? $object->term_id : $object->name;
            }

            if ( empty( $object->term_id ) && ! $tax->hierarchical ) {
                $value = '';
            }

            $output .= "\n<li id='{$args['taxonomy']}-{$object->term_id}'>" .
                       '<label class="selectit">' .
                       '<input value="' . esc_attr( $value ) . '" type="radio" name="tax_input[' . esc_attr( $args['taxonomy'] ) . '][]" ' .
                       'id="in-' . esc_attr( $args['taxonomy'] ) . '-' . esc_attr( $object->term_id ) . '"' .
                       checked( in_array( $object->term_id, (array) $args['selected_cats'] ), true, false ) .
                       disabled( empty( $args['disabled'] ), false, false ) .
                       ' /> ' .
                       esc_html( apply_filters( 'the_category', $object->name ) ) .
                       '</label>';

        }

        /**
         * Ends the element output, if needed.
         *
         * @param string $output Passed by reference. Used to append additional content.
         * @param object $object Term data object.
         * @param int    $depth  Depth of term in reference to parents.
         * @param array  $args   Optional arguments.
         */
        public function end_el( &$output, $object, $depth = 0, $args = array() ) {
            $output .= "</li>\n";
        }

    }
}

/**
 * A term walker class for a dropdown menu.
 *
 * @uses Walker
 */
if ( ! class_exists( 'Walker_ExtendedTaxonomyDropdown' ) ) {
    class Walker_ExtendedTaxonomyDropdown extends Walker {

        /**
         * Some member variables you don't need to worry too much about:
         */
        public $tree_type = 'category';
        public $db_fields = array(
            'parent' => 'parent',
            'id'     => 'term_id',
        );
        public $field = null;

        /**
         * Class constructor.
         *
         * @param array $args Optional arguments.
         */
        public function __construct( $args = null ) {
            if ( $args && isset( $args['field'] ) ) {
                $this->field = $args['field'];
            }
        }

        /**
         * Start the element output.
         *
         * @param string $output            Passed by reference. Used to append additional content.
         * @param object $object            Term data object.
         * @param int    $depth             Depth of term in reference to parents.
         * @param array  $args              Optional arguments.
         * @param int    $current_object_id Current object ID.
         */
        public function start_el( &$output, $object, $depth = 0, $args = array(), $current_object_id = 0 ) {

            $pad = str_repeat( '&nbsp;', $depth * 3 );
            $tax = get_taxonomy( $args['taxonomy'] );

            if ( $this->field ) {
                $value = $object->{$this->field};
            } else {
                $value = $tax->hierarchical ? $object->term_id : $object->name;
            }

            if ( empty( $object->term_id ) && ! $tax->hierarchical ) {
                $value = '';
            }

            $cat_name = apply_filters( 'list_cats', $object->name, $object );
            $output .= "\t<option class=\"level-{$depth}\" value=\"" . esc_attr( $value ) . '"';

            if ( isset( $args['selected_cats'] ) && in_array( $value, (array) $args['selected_cats'] ) ) {
                $output .= ' selected="selected"';
            } elseif ( isset( $args['selected'] ) && in_array( $object->term_id, (array) $args['selected'] ) ) {
                $output .= ' selected="selected"';
            }

            $output .= '>';
            $output .= $pad . esc_html( $cat_name );
            if ( $args['show_count'] ) {
                $output .= '&nbsp;&nbsp;(' . esc_html( number_format_i18n( $object->count ) ) . ')';
            }
            $output .= "</option>\n";
        }

    }
}