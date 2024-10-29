<?php

/**
 * This class adds the options with the related callbacks and validations.
 */
class Daextauttol_Menu_Options {

	/**
	 * Instance of the shared class.
	 *
	 * @var Daexthrmal_Shared|null
	 */
	private $shared = null;

	public function __construct( $shared ) {

		//assign an instance of the plugin info
		$this->shared = $shared;

	}

	public function register_options() {

		//section style ---------------------------------------------------------------------------------------------
		add_settings_section(
			'daextauttol_style_settings_section',
			null,
			null,
			'daextauttol_style_options'
		);

		add_settings_field(
			'style_tooltip_background_color',
			esc_html__( 'Tooltip Background Color', 'automatic-tooltips' ),
			array( $this, 'style_tooltip_background_color_callback' ),
			'daextauttol_style_options',
			'daextauttol_style_settings_section'
		);

		register_setting(
			'daextauttol_style_options',
			'daextauttol_style_tooltip_background_color',
			'sanitize_hex_color'
		);

		add_settings_field(
			'style_tooltip_font_color',
			esc_html__( 'Tooltip Font Color', 'automatic-tooltips' ),
			array( $this, 'style_tooltip_font_color_callback' ),
			'daextauttol_style_options',
			'daextauttol_style_settings_section'
		);

		register_setting(
			'daextauttol_style_options',
			'daextauttol_style_tooltip_font_color',
			'sanitize_hex_color'
		);

		add_settings_field(
			'style_tooltip_font_family',
			esc_html__( 'Tooltip Font Family', 'automatic-tooltips' ),
			array( $this, 'style_tooltip_font_family_callback' ),
			'daextauttol_style_options',
			'daextauttol_style_settings_section'
		);

		register_setting(
			'daextauttol_style_options',
			'daextauttol_style_tooltip_font_family',
			array( $this, 'font_family_validation' )
		);

		add_settings_field(
			'style_tooltip_font_weight',
			esc_html__( 'Tooltip Font Weight', 'automatic-tooltips' ),
			array( $this, 'style_tooltip_font_weight_callback' ),
			'daextauttol_style_options',
			'daextauttol_style_settings_section'
		);

		register_setting(
			'daextauttol_style_options',
			'daextauttol_style_tooltip_font_weight',
			'sanitize_key'
		);

		add_settings_field(
			'style_tooltip_font_size',
			esc_html__( 'Tooltip Font Size', 'automatic-tooltips' ),
			array( $this, 'style_tooltip_font_size_callback' ),
			'daextauttol_style_options',
			'daextauttol_style_settings_section'
		);

		register_setting(
			'daextauttol_style_options',
			'daextauttol_style_tooltip_font_size',
			array( $this, 'sanitize_int' )
		);

		add_settings_field(
			'style_tooltip_font_line_height',
			esc_html__( 'Tooltip Font Line Height', 'automatic-tooltips' ),
			array( $this, 'style_tooltip_font_line_height_callback' ),
			'daextauttol_style_options',
			'daextauttol_style_settings_section'
		);

		register_setting(
			'daextauttol_style_options',
			'daextauttol_style_tooltip_font_line_height',
			array( $this, 'sanitize_int' )
		);

		add_settings_field(
			'style_tooltip_horizontal_padding',
			esc_html__( 'Tooltip Horizontal Padding', 'automatic-tooltips' ),
			array( $this, 'style_tooltip_horizontal_padding_callback' ),
			'daextauttol_style_options',
			'daextauttol_style_settings_section'
		);

		register_setting(
			'daextauttol_style_options',
			'daextauttol_style_tooltip_horizontal_padding',
			array( $this, 'sanitize_int' )
		);

		add_settings_field(
			'style_tooltip_vertical_padding',
			esc_html__( 'Tooltip Vertical Padding', 'automatic-tooltips' ),
			array( $this, 'style_tooltip_vertical_padding_callback' ),
			'daextauttol_style_options',
			'daextauttol_style_settings_section'
		);

		register_setting(
			'daextauttol_style_options',
			'daextauttol_style_tooltip_vertical_padding',
			array( $this, 'sanitize_int' )
		);

		add_settings_field(
			'style_tooltip_border_radius',
			esc_html__( 'Tooltip Border Radius', 'automatic-tooltips' ),
			array( $this, 'style_tooltip_border_radius_callback' ),
			'daextauttol_style_options',
			'daextauttol_style_settings_section'
		);

		register_setting(
			'daextauttol_style_options',
			'daextauttol_style_tooltip_border_radius',
			array( $this, 'sanitize_int' )
		);

		add_settings_field(
			'style_tooltip_max_width',
			esc_html__( 'Tooltip Max Width', 'automatic-tooltips' ),
			array( $this, 'style_tooltip_max_width_callback' ),
			'daextauttol_style_options',
			'daextauttol_style_settings_section'
		);

		register_setting(
			'daextauttol_style_options',
			'daextauttol_style_tooltip_max_width',
			array( $this, 'sanitize_int' )
		);

		add_settings_field(
			'style_tooltip_text_alignment',
			esc_html__( 'Tooltip Text Alignment', 'automatic-tooltips' ),
			array( $this, 'style_tooltip_text_alignment_callback' ),
			'daextauttol_style_options',
			'daextauttol_style_settings_section'
		);

		register_setting(
			'daextauttol_style_options',
			'daextauttol_style_tooltip_text_alignment',
			'sanitize_key'
		);

		add_settings_field(
			'style_tooltip_drop_shadow',
			esc_html__( 'Tooltip Drop Shadow', 'automatic-tooltips' ),
			array( $this, 'style_tooltip_drop_shadow_callback' ),
			'daextauttol_style_options',
			'daextauttol_style_settings_section'
		);

		register_setting(
			'daextauttol_style_options',
			'daextauttol_style_tooltip_drop_shadow',
			array( $this, 'sanitize_int' )
		);

		add_settings_field(
			'style_tooltip_animation',
			esc_html__( 'Tooltip Animation', 'automatic-tooltips' ),
			array( $this, 'style_tooltip_animation_callback' ),
			'daextauttol_style_options',
			'daextauttol_style_settings_section'
		);

		register_setting(
			'daextauttol_style_options',
			'daextauttol_style_tooltip_animation',
			array( $this, 'sanitize_int' )
		);

		add_settings_field(
			'style_tooltip_animation_transition_duration',
			esc_html__( 'Tooltip Animation Transition Duration', 'automatic-tooltips' ),
			array( $this, 'style_tooltip_animation_transition_duration_callback' ),
			'daextauttol_style_options',
			'daextauttol_style_settings_section'
		);

		register_setting(
			'daextauttol_style_options',
			'daextauttol_style_tooltip_animation_transition_duration',
			array( $this, 'sanitize_int' )
		);

		add_settings_field(
			'style_tooltip_arrow_size',
			esc_html__( 'Tooltip Arrow Size', 'automatic-tooltips' ),
			array( $this, 'style_tooltip_arrow_size_callback' ),
			'daextauttol_style_options',
			'daextauttol_style_settings_section'
		);

		register_setting(
			'daextauttol_style_options',
			'daextauttol_style_tooltip_arrow_size',
			array( $this, 'sanitize_int' )
		);

		add_settings_field(
			'style_keyword_background_color',
			esc_html__( 'Keyword Background Color', 'automatic-tooltips' ),
			array( $this, 'style_keyword_background_color_callback' ),
			'daextauttol_style_options',
			'daextauttol_style_settings_section'
		);

		register_setting(
			'daextauttol_style_options',
			'daextauttol_style_keyword_background_color',
			'sanitize_hex_color'
		);

		add_settings_field(
			'style_keyword_font_color',
			esc_html__( 'Keyword Font Color', 'automatic-tooltips' ),
			array( $this, 'style_keyword_font_color_callback' ),
			'daextauttol_style_options',
			'daextauttol_style_settings_section'
		);

		register_setting(
			'daextauttol_style_options',
			'daextauttol_style_keyword_font_color',
			'sanitize_hex_color'
		);

		add_settings_field(
			'style_keyword_font_family',
			esc_html__( 'Keyword Font Family', 'automatic-tooltips' ),
			array( $this, 'style_keyword_font_family_callback' ),
			'daextauttol_style_options',
			'daextauttol_style_settings_section'
		);

		register_setting(
			'daextauttol_style_options',
			'daextauttol_style_keyword_font_family',
			'font_family_validation'
		);

		add_settings_field(
			'style_keyword_font_weight',
			esc_html__( 'Keyword Font Weight', 'automatic-tooltips' ),
			array( $this, 'style_keyword_font_weight_callback' ),
			'daextauttol_style_options',
			'daextauttol_style_settings_section'
		);

		register_setting(
			'daextauttol_style_options',
			'daextauttol_style_keyword_font_weight',
			'sanitize_key'
		);

		add_settings_field(
			'style_keyword_font_size',
			esc_html__( 'Keyword Font Size', 'automatic-tooltips' ),
			array( $this, 'style_keyword_font_size_callback' ),
			'daextauttol_style_options',
			'daextauttol_style_settings_section'
		);

		register_setting(
			'daextauttol_style_options',
			'daextauttol_style_keyword_font_size',
			array( $this, 'sanitize_int' )
		);

		add_settings_field(
			'style_keyword_decoration',
			esc_html__( 'Keyword Decoration', 'automatic-tooltips' ),
			array( $this, 'style_keyword_decoration_callback' ),
			'daextauttol_style_options',
			'daextauttol_style_settings_section'
		);

		register_setting(
			'daextauttol_style_options',
			'daextauttol_style_keyword_decoration',
			'sanitize_text_field'
		);

		//section defaults ---------------------------------------------------------------------------------------------
		add_settings_section(
			'daextauttol_defaults_settings_section',
			null,
			null,
			'daextauttol_defaults_options'
		);

		add_settings_field(
			'defaults_category_id',
			esc_html__( 'Category', 'automatic-tooltips' ),
			array( $this, 'defaults_category_id_callback' ),
			'daextauttol_defaults_options',
			'daextauttol_defaults_settings_section'
		);

		register_setting(
			'daextauttol_defaults_options',
			'daextauttol_defaults_category_id',
			array( $this, 'sanitize_int' )
		);

		add_settings_field(
			'defaults_post_types',
			esc_html__( 'Post Types', 'automatic-tooltips' ),
			array( $this, 'defaults_post_types_callback' ),
			'daextauttol_defaults_options',
			'daextauttol_defaults_settings_section'
		);

		register_setting(
			'daextauttol_defaults_options',
			'daextauttol_defaults_post_types',
			array( $this, 'sanitize_array_of_keys' )
		);

		add_settings_field(
			'defaults_categories',
			esc_html__( 'Categories', 'automatic-tooltips' ),
			array( $this, 'defaults_categories_callback' ),
			'daextauttol_defaults_options',
			'daextauttol_defaults_settings_section'
		);

		register_setting(
			'daextauttol_defaults_options',
			'daextauttol_defaults_categories',
			array( $this, 'sanitize_array_of_keys' )
		);

		add_settings_field(
			'defaults_tags',
			esc_html__( 'Tags', 'automatic-tooltips' ),
			array( $this, 'defaults_tags_callback' ),
			'daextauttol_defaults_options',
			'daextauttol_defaults_settings_section'
		);

		register_setting(
			'daextauttol_defaults_options',
			'daextauttol_defaults_tags',
			array( $this, 'sanitize_array_of_keys' )
		);

		add_settings_field(
			'defaults_case_sensitive_search',
			esc_html__( 'Case Sensitive Search', 'automatic-tooltips' ),
			array( $this, 'defaults_case_sensitive_search_callback' ),
			'daextauttol_defaults_options',
			'daextauttol_defaults_settings_section'
		);

		register_setting(
			'daextauttol_defaults_options',
			'daextauttol_defaults_case_sensitive_search',
			array( $this, 'sanitize_int' )
		);

		add_settings_field(
			'defaults_left_boundary',
			esc_html__( 'Left Boundary', 'automatic-tooltips' ),
			array( $this, 'defaults_left_boundary_callback' ),
			'daextauttol_defaults_options',
			'daextauttol_defaults_settings_section'
		);

		register_setting(
			'daextauttol_defaults_options',
			'daextauttol_defaults_left_boundary',
			array( $this, 'sanitize_int' )
		);

		add_settings_field(
			'defaults_right_boundary',
			esc_html__( 'Right Boundary', 'automatic-tooltips' ),
			array( $this, 'defaults_right_boundary_callback' ),
			'daextauttol_defaults_options',
			'daextauttol_defaults_settings_section'
		);

		register_setting(
			'daextauttol_defaults_options',
			'daextauttol_defaults_right_boundary',
			array( $this, 'sanitize_int' )
		);

		add_settings_field(
			'defaults_limit',
			esc_html__( 'Limit', 'automatic-tooltips' ),
			array( $this, 'defaults_limit_callback' ),
			'daextauttol_defaults_options',
			'daextauttol_defaults_settings_section'
		);

		register_setting(
			'daextauttol_defaults_options',
			'daextauttol_defaults_limit',
			array( $this, 'defaults_limit_validation' )
		);

		add_settings_field(
			'defaults_priority',
			esc_html__( 'Priority', 'automatic-tooltips' ),
			array( $this, 'defaults_priority_callback' ),
			'daextauttol_defaults_options',
			'daextauttol_defaults_settings_section'
		);

		register_setting(
			'daextauttol_defaults_options',
			'daextauttol_defaults_priority',
			array( $this, 'defaults_priority_validation' )
		);

		//section analysis ---------------------------------------------------------------------------------------------
		add_settings_section(
			'daextauttol_analysis_settings_section',
			null,
			null,
			'daextauttol_analysis_options'
		);

		add_settings_field(
			'analysis_set_max_execution_time',
			esc_html__( 'Set Max Execution Time', 'automatic-tooltips' ),
			array( $this, 'analysis_set_max_execution_time_callback' ),
			'daextauttol_analysis_options',
			'daextauttol_analysis_settings_section'
		);

		register_setting(
			'daextauttol_analysis_options',
			'daextauttol_analysis_set_max_execution_time',
			array( $this, 'sanitize_int' )
		);

		add_settings_field(
			'analysis_max_execution_time_value',
			esc_html__( 'Max Execution Time Value', 'automatic-tooltips' ),
			array( $this, 'analysis_max_execution_time_value_callback' ),
			'daextauttol_analysis_options',
			'daextauttol_analysis_settings_section'
		);

		register_setting(
			'daextauttol_analysis_options',
			'daextauttol_analysis_max_execution_time_value',
			array( $this, 'analysis_max_execution_time_value_validation' )
		);

		add_settings_field(
			'analysis_set_memory_limit',
			esc_html__( 'Set Memory Limit', 'automatic-tooltips' ),
			array( $this, 'analysis_set_memory_limit_callback' ),
			'daextauttol_analysis_options',
			'daextauttol_analysis_settings_section'
		);

		register_setting(
			'daextauttol_analysis_options',
			'daextauttol_analysis_set_memory_limit',
			array( $this, 'sanitize_key' )
		);

		add_settings_field(
			'analysis_memory_limit_value',
			esc_html__( 'Memory Limit Value', 'automatic-tooltips' ),
			array( $this, 'analysis_memory_limit_value_callback' ),
			'daextauttol_analysis_options',
			'daextauttol_analysis_settings_section'
		);

		register_setting(
			'daextauttol_analysis_options',
			'daextauttol_analysis_memory_limit_value',
			array( $this, 'analysis_memory_limit_value_validation' )
		);

		add_settings_field(
			'analysis_limit_posts_analysis',
			esc_html__( 'Limit Posts Analysis', 'automatic-tooltips' ),
			array( $this, 'analysis_limit_posts_analysis_callback' ),
			'daextauttol_analysis_options',
			'daextauttol_analysis_settings_section'
		);

		register_setting(
			'daextauttol_analysis_options',
			'daextauttol_analysis_limit_posts_analysis',
			array( $this, 'analysis_limit_posts_analysis_validation' )
		);

		add_settings_field(
			'analysis_post_types',
			esc_html__( 'Post Types', 'automatic-tooltips' ),
			array( $this, 'analysis_post_types_callback' ),
			'daextauttol_analysis_options',
			'daextauttol_analysis_settings_section'
		);

		register_setting(
			'daextauttol_analysis_options',
			'daextauttol_analysis_post_types',
			array( $this, 'sanitize_array_of_keys' )
		);

		//section advanced ---------------------------------------------------------------------------------------------
		add_settings_section(
			'daextauttol_advanced_settings_section',
			null,
			null,
			'daextauttol_advanced_options'
		);

		add_settings_field(
			'advanced_enable_tooltips',
			esc_html__( 'Enable Tooltips', 'automatic-tooltips' ),
			array( $this, 'advanced_enable_tooltips_callback' ),
			'daextauttol_advanced_options',
			'daextauttol_advanced_settings_section'
		);

		register_setting(
			'daextauttol_advanced_options',
			'daextauttol_advanced_enable_tooltips',
			array( $this, 'sanitize_int' )
		);

		add_settings_field(
			'advanced_filter_priority',
			esc_html__( 'Filter Priority', 'automatic-tooltips' ),
			array( $this, 'advanced_filter_priority_callback' ),
			'daextauttol_advanced_options',
			'daextauttol_advanced_settings_section'
		);

		register_setting(
			'daextauttol_advanced_options',
			'daextauttol_advanced_filter_priority',
			array( $this, 'advanced_filter_priority_validation' )
		);

		add_settings_field(
			'advanced_enable_test_mode',
			esc_html__( 'Test Mode', 'automatic-tooltips' ),
			array( $this, 'advanced_enable_test_mode_callback' ),
			'daextauttol_advanced_options',
			'daextauttol_advanced_settings_section'
		);

		register_setting(
			'daextauttol_advanced_options',
			'daextauttol_advanced_enable_test_mode',
			array( $this, 'sanitize_int' )
		);

		add_settings_field(
			'advanced_random_prioritization',
			esc_html__( 'Random Prioritization', 'automatic-tooltips' ),
			array( $this, 'advanced_random_prioritization_callback' ),
			'daextauttol_advanced_options',
			'daextauttol_advanced_settings_section'
		);

		register_setting(
			'daextauttol_advanced_options',
			'daextauttol_advanced_random_prioritization',
			array( $this, 'sanitize_int' )
		);

		add_settings_field(
			'advanced_categories_and_tags_verification',
			esc_html__( 'Categories & Tags Verification', 'automatic-tooltips' ),
			array( $this, 'advanced_categories_and_tags_verification_callback' ),
			'daextauttol_advanced_options',
			'daextauttol_advanced_settings_section'
		);

		register_setting(
			'daextauttol_advanced_options',
			'daextauttol_advanced_categories_and_tags_verification',
			array( $this, 'advanced_categories_and_tags_verification_validation' )
		);

		add_settings_field(
			'advanced_general_limit_mode',
			esc_html__( 'General Limit Mode', 'automatic-tooltips' ),
			array( $this, 'advanced_general_limit_mode_callback' ),
			'daextauttol_advanced_options',
			'daextauttol_advanced_settings_section'
		);

		register_setting(
			'daextauttol_advanced_options',
			'daextauttol_advanced_general_limit_mode',
			array( $this, 'sanitize_int' )
		);

		add_settings_field(
			'advanced_general_limit_characters_per_tooltip',
			esc_html__( 'General Limit (Characters per Tooltip)', 'automatic-tooltips' ),
			array( $this, 'advanced_general_limit_characters_per_tooltip_callback' ),
			'daextauttol_advanced_options',
			'daextauttol_advanced_settings_section'
		);

		register_setting(
			'daextauttol_advanced_options',
			'daextauttol_advanced_general_limit_characters_per_tooltip',
			array( $this, 'advanced_general_limit_characters_per_tooltip_validation' )
		);

		add_settings_field(
			'advanced_general_limit_amount',
			esc_html__( 'General Limit (Amount)', 'automatic-tooltips' ),
			array( $this, 'advanced_general_limit_amount_callback' ),
			'daextauttol_advanced_options',
			'daextauttol_advanced_settings_section'
		);

		register_setting(
			'daextauttol_advanced_options',
			'daextauttol_advanced_general_limit_amount',
			array( $this, 'advanced_general_limit_amount_validation' )
		);

		add_settings_field(
			'advanced_protected_tags',
			esc_html__( 'Protected Tags', 'automatic-tooltips' ),
			array( $this, 'advanced_protected_tags_callback' ),
			'daextauttol_advanced_options',
			'daextauttol_advanced_settings_section'
		);

		register_setting(
			'daextauttol_advanced_options',
			'daextauttol_advanced_protected_tags',
			array( $this, 'sanitize_array_of_keys' )
		);

		add_settings_field(
			'advanced_protected_gutenberg_blocks',
			esc_html__( 'Protected Gutenberg Blocks', 'automatic-tooltips' ),
			array( $this, 'advanced_protected_gutenberg_blocks_callback' ),
			'daextauttol_advanced_options',
			'daextauttol_advanced_settings_section'
		);

		register_setting(
			'daextauttol_advanced_options',
			'daextauttol_advanced_protected_gutenberg_blocks',
			array( $this, 'sanitize_array' )
		);

		add_settings_field(
			'advanced_protected_gutenberg_custom_blocks',
			esc_html__( 'Protected Gutenberg Custom Blocks', 'automatic-tooltips' ),
			array( $this, 'advanced_protected_gutenberg_custom_blocks_callback' ),
			'daextauttol_advanced_options',
			'daextauttol_advanced_settings_section'
		);

		register_setting(
			'daextauttol_advanced_options',
			'daextauttol_advanced_protected_gutenberg_custom_blocks',
			array( $this, 'advanced_protected_gutenberg_custom_blocks_validation' )
		);

		add_settings_field(
			'advanced_protected_gutenberg_custom_void_blocks',
			esc_html__( 'Protected Gutenberg Custom Void Blocks', 'automatic-tooltips' ),
			array( $this, 'advanced_protected_gutenberg_custom_void_blocks_callback' ),
			'daextauttol_advanced_options',
			'daextauttol_advanced_settings_section'
		);

		register_setting(
			'daextauttol_advanced_options',
			'daextauttol_advanced_protected_gutenberg_custom_void_blocks',
			array( $this, 'advanced_protected_gutenberg_custom_void_blocks_validation' )
		);

	}

	//General validation functions -------------------------------------------------------------------------------------
	public function sanitize_int( $input ) {

		return intval( $input, 10 );

	}

	public function sanitize_array_of_keys( $input ) {

		if ( is_array( $input ) ) {
			return array_map( function ( $a ) {
				return sanitize_key( $a );
			}, $input );
		} else {
			return '';
		}

	}

	public function sanitize_array( $input ) {

		if ( is_array( $input ) ) {
			return array_map( function ( $a ) {
				return sanitize_text_field( $a );
			}, $input );
		} else {
			return '';
		}

	}

	public function font_family_validation( $input ) {

		$input = sanitize_text_field( $input );

		if ( ! preg_match( $this->shared->font_family_regex, $input ) or strlen( $input ) > 1000 ) {
			add_settings_error( 'daextautol_style_tooltip_font_family', 'daextautol_style_tooltip_font_family',
				esc_html__( 'Please enter a valid value in the "Tooltip Font Family" option.', 'automatic-tooltips' ) );
			$output = get_option( "daextauttol_style_tooltip_font_family" );
		} else {
			$output = $input;
		}

		return $output;

	}

	//Style options and callbacks --------------------------------------------------------------------------------------
	public function style_tooltip_background_color_callback() {

		echo '<input class="wp-color-picker" maxlength="7" type="text" id="daextauttol_style_tooltip_background_color" name="daextauttol_style_tooltip_background_color" class="regular-text" value="' . esc_attr( get_option( "daextauttol_style_tooltip_background_color" ) ) . '" />';
		echo '<div class="help-icon" title="' . esc_attr__( 'The background color of the tooltip.', 'automatic-tooltips' ) . '"></div>';

	}

	public function style_tooltip_font_color_callback() {

		echo '<input class="wp-color-picker" maxlength="7" type="text" id="daextauttol_style_tooltip_font_color" name="daextauttol_style_tooltip_font_color" class="regular-text" value="' . esc_attr( get_option( "daextauttol_style_tooltip_font_color" ) ) . '" />';
		echo '<div class="help-icon" title="' . esc_attr__( 'The font color of the text displayed in the tooltip.', 'automatic-tooltips' ) . '"></div>';

	}

	public function style_tooltip_font_family_callback() {

		echo '<input maxlength="1000" type="text" id="daextauttol_style_tooltip_font_family" name="daextauttol_style_tooltip_font_family" class="regular-text" value="' . esc_attr( get_option( "daextauttol_style_tooltip_font_family" ) ) . '" />';
		echo '<div class="help-icon" title="' . esc_attr__( 'The font family of the text displayed in the tooltip.', 'automatic-tooltips' ) . '"></div>';

	}

	public function style_tooltip_font_weight_callback() {

		echo '<select id="daextauttol-style-tooltip-font-weight" name="daextauttol_style_tooltip_font_weight" class="daext-display-none">';
		echo '<option ' . selected( intval( get_option( "daextauttol_style_tooltip_font_weight" ) ), 'inherit',
				false ) . ' value="inherit">' . esc_html__( 'inherit', 'automatic-tooltips' ) . '</option>';
		echo '<option ' . selected( intval( get_option( "daextauttol_style_tooltip_font_weight" ) ), '100',
				false ) . ' value="100">' . esc_html__( '100', 'automatic-tooltips' ) . '</option>';
		echo '<option ' . selected( intval( get_option( "daextauttol_style_tooltip_font_weight" ) ), '200',
				false ) . ' value="200">' . esc_html__( '200', 'automatic-tooltips' ) . '</option>';
		echo '<option ' . selected( intval( get_option( "daextauttol_style_tooltip_font_weight" ) ), '300',
				false ) . ' value="300">' . esc_html__( '300', 'automatic-tooltips' ) . '</option>';
		echo '<option ' . selected( intval( get_option( "daextauttol_style_tooltip_font_weight" ) ), '400',
				false ) . ' value="400">' . esc_html__( '400', 'automatic-tooltips' ) . '</option>';
		echo '<option ' . selected( intval( get_option( "daextauttol_style_tooltip_font_weight" ) ), '500',
				false ) . ' value="500">' . esc_html__( '500', 'automatic-tooltips' ) . '</option>';
		echo '<option ' . selected( intval( get_option( "daextauttol_style_tooltip_font_weight" ) ), '600',
				false ) . ' value="600">' . esc_html__( '600', 'automatic-tooltips' ) . '</option>';
		echo '<option ' . selected( intval( get_option( "daextauttol_style_tooltip_font_weight" ) ), '700',
				false ) . ' value="700">' . esc_html__( '700', 'automatic-tooltips' ) . '</option>';
		echo '<option ' . selected( intval( get_option( "daextauttol_style_tooltip_font_weight" ) ), '800',
				false ) . ' value="800">' . esc_html__( '800', 'automatic-tooltips' ) . '</option>';
		echo '<option ' . selected( intval( get_option( "daextauttol_style_tooltip_font_weight" ) ), '900',
				false ) . ' value="900">' . esc_html__( '900', 'automatic-tooltips' ) . '</option>';
		echo '</select>';
		echo '<div class="help-icon" title="' . esc_attr__( 'The font-weight of the text displayed in the tooltip', 'automatic-tooltips' ) . '"></div>';

	}

	public function style_tooltip_font_size_callback() {

		echo '<input maxlength="7" type="text" id="daextauttol_style_tooltip_font_size" name="daextauttol_style_tooltip_font_size" class="regular-text" value="' . esc_attr( get_option( "daextauttol_style_tooltip_font_size" ) ) . '" />';
		echo '<div class="help-icon" title="' . esc_attr__( 'The font size of the text displayed in the tooltip.', 'automatic-tooltips' ) . '"></div>';

	}

	public function style_tooltip_font_line_height_callback() {

		echo '<input maxlength="7" type="text" id="daextauttol_style_tooltip_font_line_height" name="daextauttol_style_tooltip_font_line_height" class="regular-text" value="' . esc_attr( get_option( "daextauttol_style_tooltip_font_line_height" ) ) . '" />';
		echo '<div class="help-icon" title="' . esc_attr__( 'The line-height of the text displayed in the tooltip.', 'automatic-tooltips' ) . '"></div>';

	}

	public function style_tooltip_horizontal_padding_callback() {

		echo '<input maxlength="7" type="text" id="daextauttol_style_tooltip_horizontal_padding" name="daextauttol_style_tooltip_horizontal_padding" class="regular-text" value="' . esc_attr( get_option( "daextauttol_style_tooltip_horizontal_padding" ) ) . '" />';
		echo '<div class="help-icon" title="' . esc_attr__( 'The horizontal padding of the tooltip.', 'automatic-tooltips' ) . '"></div>';

	}

	public function style_tooltip_vertical_padding_callback() {

		echo '<input maxlength="7" type="text" id="daextauttol_style_tooltip_vertical_padding" name="daextauttol_style_tooltip_vertical_padding" class="regular-text" value="' . esc_attr( get_option( "daextauttol_style_tooltip_vertical_padding" ) ) . '" />';
		echo '<div class="help-icon" title="' . esc_attr__( 'The vertical padding of the tooltip.', 'automatic-tooltips' ) . '"></div>';

	}

	public function style_tooltip_border_radius_callback() {

		echo '<input maxlength="7" type="text" id="daextauttol_style_tooltip_border_radius" name="daextauttol_style_tooltip_border_radius" class="regular-text" value="' . esc_attr( get_option( "daextauttol_style_tooltip_border_radius" ) ) . '" />';
		echo '<div class="help-icon" title="' . esc_attr__( 'The border radius of the tooltip.', 'automatic-tooltips' ) . '"></div>';

	}

	public function style_tooltip_max_width_callback() {

		echo '<input maxlength="7" type="text" id="daextauttol_style_tooltip_max_width" name="daextauttol_style_tooltip_max_width" class="regular-text" value="' . esc_attr( get_option( "daextauttol_style_tooltip_max_width" ) ) . '" />';
		echo '<div class="help-icon" title="' . esc_attr__( 'The max width of the tooltip.', 'automatic-tooltips' ) . '"></div>';

	}

	public function style_tooltip_text_alignment_callback() {

		echo '<select id="daextauttol-style-tooltip-text-alignment" name="daextauttol_style_tooltip_text_alignment" class="daext-display-none">';
		echo '<option ' . selected( get_option( "daextauttol_style_tooltip_text_alignment" ), 'left',
				false ) . ' value="left">' . esc_html__( 'Left', 'automatic-tooltips' ) . '</option>';
		echo '<option ' . selected( get_option( "daextauttol_style_tooltip_text_alignment" ), 'center',
				false ) . ' value="center">' . esc_html__( 'Center', 'automatic-tooltips' ) . '</option>';
		echo '<option ' . selected( get_option( "daextauttol_style_tooltip_text_alignment" ), 'right',
				false ) . ' value="right">' . esc_html__( 'Right', 'automatic-tooltips' ) . '</option>';
		echo '</select>';
		echo '<div class="help-icon" title="' . esc_attr__( 'The text alignment of the tooltip.', 'automatic-tooltips' ) . '"></div>';

	}

	public function style_tooltip_drop_shadow_callback() {

		echo '<select id="daextauttol-style-tooltip-drop-shadow" name="daextauttol_style_tooltip_drop_shadow" class="daext-display-none">';
		echo '<option ' . selected( intval( get_option( "daextauttol_style_tooltip_drop_shadow" ) ), 0,
				false ) . ' value="0">' . esc_html__( 'No', 'automatic-tooltips' ) . '</option>';
		echo '<option ' . selected( intval( get_option( "daextauttol_style_tooltip_drop_shadow" ) ), 1,
				false ) . ' value="1">' . esc_html__( 'Yes', 'automatic-tooltips' ) . '</option>';
		echo '</select>';
		echo '<div class="help-icon" title="' . esc_attr__( 'Whether to apply or not a drop shadow effect to the tooltip.', 'automatic-tooltips' ) . '"></div>';

	}

	public function style_tooltip_animation_callback() {

		echo '<select id="daextauttol-advanced-enable-tooltips" name="daextauttol_style_tooltip_animation" class="daext-display-none">';
		echo '<option ' . selected( intval( get_option( "daextauttol_style_tooltip_animation" ) ), 0,
				false ) . ' value="0">' . esc_html__( 'No', 'automatic-tooltips' ) . '</option>';
		echo '<option ' . selected( intval( get_option( "daextauttol_style_tooltip_animation" ) ), 1,
				false ) . ' value="1">' . esc_html__( 'Yes', 'automatic-tooltips' ) . '</option>';
		echo '</select>';
		echo '<div class="help-icon" title="' . esc_attr__( 'Whether to apply or not an animation effect to the tooltip.', 'automatic-tooltips' ) . '"></div>';

	}

	public function style_tooltip_animation_transition_duration_callback() {

		echo '<input maxlength="7" type="text" id="daextauttol_style_tooltip_animation_transition_duration" name="daextauttol_style_tooltip_animation_transition_duration" class="regular-text" value="' . esc_attr( get_option( "daextauttol_style_tooltip_animation_transition_duration" ) ) . '" />';
		echo '<div class="help-icon" title="' . esc_attr__( 'The transition duration of the animation applied to the tooltip.', 'automatic-tooltips' ) . '"></div>';

	}

	public function style_tooltip_arrow_size_callback() {

		echo '<input maxlength="7" type="text" id="daextauttol_style_tooltip_arrow_size" name="daextauttol_style_tooltip_arrow_size" class="regular-text" value="' . esc_attr( get_option( "daextauttol_style_tooltip_arrow_size" ) ) . '" />';
		echo '<div class="help-icon" title="' . esc_attr__( 'The size of the arrow displayed below the tooltip.', 'automatic-tooltips' ) . '"></div>';

	}

	public function style_keyword_font_color_callback() {

		echo '<input class="wp-color-picker" maxlength="7" type="text" id="daextauttol_style_keyword_font_color" name="daextauttol_style_keyword_font_color" class="regular-text" value="' . esc_attr( get_option( "daextauttol_style_keyword_font_color" ) ) . '" />';
		echo '<div class="help-icon" title="' . esc_attr__( 'The color of the keyword used to generate the tooltip.', 'automatic-tooltips' ) . '"></div>';

	}

	public function style_keyword_font_size_callback() {

		echo '<input maxlength="7" type="text" id="daextauttol_style_keyword_font_size" name="daextauttol_style_keyword_font_size" class="regular-text" value="' . esc_attr( get_option( "daextauttol_style_keyword_font_size" ) ) . '" />';
		echo '<div class="help-icon" title="' . esc_attr__( 'The font size of the keyword.', 'automatic-keywords' ) . '"></div>';

	}

	public function style_keyword_font_family_callback() {

		echo '<input maxlength="1000" type="text" id="daextauttol_style_keyword_font_family" name="daextauttol_style_keyword_font_family" class="regular-text" value="' . esc_attr( get_option( "daextauttol_style_keyword_font_family" ) ) . '" />';
		echo '<div class="help-icon" title="' . esc_attr__( 'The font family of the keyword.', 'automatic-keywords' ) . '"></div>';

	}

	public function style_keyword_font_weight_callback() {

		echo '<select id="daextauttol-style-keyword-font-weight" name="daextauttol_style_keyword_font_weight" class="daext-display-none">';
		echo '<option ' . selected( intval( get_option( "daextauttol_style_keyword_font_weight" ) ), 'inherit',
				false ) . ' value="inherit">' . esc_html__( 'inherit', 'automatic-tooltips' ) . '</option>';
		echo '<option ' . selected( intval( get_option( "daextauttol_style_keyword_font_weight" ) ), '100',
				false ) . ' value="100">' . esc_html__( '100', 'automatic-tooltips' ) . '</option>';
		echo '<option ' . selected( intval( get_option( "daextauttol_style_keyword_font_weight" ) ), '200',
				false ) . ' value="200">' . esc_html__( '200', 'automatic-tooltips' ) . '</option>';
		echo '<option ' . selected( intval( get_option( "daextauttol_style_keyword_font_weight" ) ), '300',
				false ) . ' value="300">' . esc_html__( '300', 'automatic-tooltips' ) . '</option>';
		echo '<option ' . selected( intval( get_option( "daextauttol_style_keyword_font_weight" ) ), '400',
				false ) . ' value="400">' . esc_html__( '400', 'automatic-tooltips' ) . '</option>';
		echo '<option ' . selected( intval( get_option( "daextauttol_style_keyword_font_weight" ) ), '500',
				false ) . ' value="500">' . esc_html__( '500', 'automatic-tooltips' ) . '</option>';
		echo '<option ' . selected( intval( get_option( "daextauttol_style_keyword_font_weight" ) ), '600',
				false ) . ' value="600">' . esc_html__( '600', 'automatic-tooltips' ) . '</option>';
		echo '<option ' . selected( intval( get_option( "daextauttol_style_keyword_font_weight" ) ), '700',
				false ) . ' value="700">' . esc_html__( '700', 'automatic-tooltips' ) . '</option>';
		echo '<option ' . selected( intval( get_option( "daextauttol_style_keyword_font_weight" ) ), '800',
				false ) . ' value="800">' . esc_html__( '800', 'automatic-tooltips' ) . '</option>';
		echo '<option ' . selected( intval( get_option( "daextauttol_style_keyword_font_weight" ) ), '900',
				false ) . ' value="900">' . esc_html__( '900', 'automatic-tooltips' ) . '</option>';
		echo '</select>';
		echo '<div class="help-icon" title="' . esc_attr__( 'The font-weight of the keyword used to generate the tooltip', 'automatic-tooltips' ) . '"></div>';

	}

	public function style_keyword_background_color_callback() {

		echo '<input class="wp-color-picker" maxlength="7" type="text" id="daextauttol_style_keyword_background_color" name="daextauttol_style_keyword_background_color" class="regular-text" value="' . esc_attr( get_option( "daextauttol_style_keyword_background_color" ) ) . '" />';
		echo '<div class="help-icon" title="' . esc_attr__( 'The color of the keyword used to generate the tooltip.', 'automatic-tooltips' ) . '"></div>';

	}

	public function style_keyword_decoration_callback() {

		echo '<select id="daextauttol-style-keyword-decoration" name="daextauttol_style_keyword_decoration" class="daext-display-none">';
		echo '<option ' . selected( get_option( "daextauttol_style_keyword_decoration" ), 'none',
				false ) . ' value="none">' . esc_html__( 'none', 'automatic-tooltips' ) . '</option>';
		echo '<option ' . selected( get_option( "daextauttol_style_keyword_decoration" ), 'underline dashed',
				false ) . ' value="underline dashed">' . esc_html__( 'underline dashed', 'automatic-tooltips' ) . '</option>';
		echo '<option ' . selected( get_option( "daextauttol_style_keyword_decoration" ), 'underline dotted',
				false ) . ' value="underline dotted">' . esc_html__( 'underline dotted', 'automatic-tooltips' ) . '</option>';
		echo '<option ' . selected( get_option( "daextauttol_style_keyword_decoration" ), 'underline double',
				false ) . ' value="underline double">' . esc_html__( 'underline double', 'automatic-tooltips' ) . '</option>';
		echo '<option ' . selected( get_option( "daextauttol_style_keyword_decoration" ), 'underline solid',
				false ) . ' value="underline solid">' . esc_html__( 'underline solid', 'automatic-tooltips' ) . '</option>';
		echo '</select>';
		echo '<div class="help-icon" title="' . esc_attr__( 'The text decoration of the keyword used to generate the tooltip', 'automatic-tooltips' ) . '"></div>';

	}

	//defaults options callbacks and validations -----------------------------------------------------------------------
	public function defaults_category_id_callback() {

		echo '<select id="daextauttol-defaults-category-id" name="daextauttol_defaults_category_id" class="daext-display-none">';
		echo '<option value="0" ' . selected( intval( get_option( "daextauttol_defaults_category_id" ) ), 0,
				false ) . '>' . esc_html__( 'None', 'automatic-tooltips' ) . '</option>';

		global $wpdb;
		$table_name = $wpdb->prefix . $this->shared->get( 'slug' ) . "_category";
		$sql        = "SELECT category_id, name FROM $table_name ORDER BY category_id DESC";
		$category_a = $wpdb->get_results( $sql, ARRAY_A );

		foreach ( $category_a as $key => $category ) {
			echo '<option value="' . esc_attr($category['category_id']) . '" ' . selected( intval( get_option( "daextauttol_defaults_category_id" ) ),
					$category['category_id'], false ) . '>' . esc_html( stripslashes( $category['name'] ) ) . '</option>';
		}

		echo '</select>';
		echo '<div class="help-icon" title="' . esc_attr__( 'The category of the tooltip. This option determines the default value of the "Category" field available in the "Tooltips" menu.', 'automatic-tooltips' ) . '"></div>';

	}

	public function defaults_post_types_callback() {

		$defaults_post_types_a = get_option( "daextauttol_defaults_post_types" );

		$available_post_types_a = get_post_types( array(
			'public'  => true,
			'show_ui' => true
		) );

		//Remove the "attachment" post type
		$available_post_types_a = array_diff( $available_post_types_a, array( 'attachment' ) );

		echo '<select id="daextauttol-defaults-categories" name="daextauttol_defaults_post_types[]" class="daext-display-none" multiple>';

		foreach ( $available_post_types_a as $single_post_type ) {
			if ( is_array( $defaults_post_types_a ) and in_array( $single_post_type, $defaults_post_types_a ) ) {
				$selected = 'selected';
			} else {
				$selected = '';
			}
			$post_type_obj = get_post_type_object( $single_post_type );
			echo '<option value="' . esc_attr( $single_post_type ) . '" ' . esc_attr( $selected ) . '>' . esc_html( $post_type_obj->label ) . '</option>';
		}

		echo '</select>';
		echo '<div class="help-icon" title="' . esc_attr__( 'With this option you are able to determine in which post types the defined keyword will be used to generate the tooltips. Leave this field empty to convert the keyword in any post type. This option determines the default value of the "Post Types" field available in the "Tooltips" menu.', 'automatic-tooltips' ) . '"></div>';

	}

	public function defaults_categories_callback() {

		$defaults_categories_a = get_option( "daextauttol_defaults_categories" );

		echo '<select id="daextauttol-defaults-categories" name="daextauttol_defaults_categories[]" class="daext-display-none" multiple>';

		$categories = get_categories( array(
			'hide_empty' => 0,
			'orderby'    => 'term_id',
			'order'      => 'DESC'
		) );

		foreach ( $categories as $category ) {
			if ( is_array( $defaults_categories_a ) and in_array( $category->term_id, $defaults_categories_a ) ) {
				$selected = 'selected';
			} else {
				$selected = '';
			}
			echo '<option value="' . esc_attr( $category->term_id ) . '" ' . esc_attr( $selected ) . '>' . esc_html( $category->name ) . '</option>';
		}

		echo '</select>';
		echo '<div class="help-icon" title="' . esc_attr__( 'With this option you are able to determine in which categories the defined keyword will be used to generate the tooltips. Leave this field empty to convert the keyword in any category. This option determines the default value of the "Categories" field available in the "Tooltips" menu.', 'automatic-tooltips' ) . '"></div>';

	}

	public function defaults_tags_callback() {

		$defaults_tags_a = get_option( "daextauttol_defaults_tags" );

		echo '<select id="daextauttol-defaults-categories" name="daextauttol_defaults_tags[]" class="daext-display-none" multiple>';

		$categories = get_categories( array(
			'hide_empty' => 0,
			'orderby'    => 'term_id',
			'order'      => 'DESC',
			'taxonomy'   => 'post_tag'
		) );

		foreach ( $categories as $category ) {
			if ( is_array( $defaults_tags_a ) and in_array( $category->term_id, $defaults_tags_a ) ) {
				$selected = 'selected';
			} else {
				$selected = '';
			}
			echo '<option value="' . esc_attr( $category->term_id ) . '" ' . esc_attr( $selected ) . '>' . esc_html( $category->name ) . '</option>';
		}

		echo '</select>';
		echo '<div class="help-icon" title="' . esc_attr__( 'With this option you are able to determine in which tags the defined keyword will be used to generate the tooltips. Leave this field empty to convert the keyword in any tag. This option determines the default value of the "Tags" field available in the "Tooltips" menu.', 'automatic-tooltips' ) . '"></div>';

	}

	public function defaults_case_sensitive_search_callback() {

		echo '<select id="daextauttol-defaults-case-sensitive-search" name="daextauttol_defaults_case_sensitive_search" class="daext-display-none">';
		echo '<option ' . selected( intval( get_option( "daextauttol_defaults_case_sensitive_search" ), 10 ), 0,
				false ) . ' value="0">' . esc_html__( 'No', 'automatic-tooltips' ) . '</option>';
		echo '<option ' . selected( intval( get_option( "daextauttol_defaults_case_sensitive_search" ), 10 ), 1,
				false ) . ' value="1">' . esc_html__( 'Yes', 'automatic-tooltips' ) . '</option>';
		echo '</select>';
		echo '<div class="help-icon" title="' . esc_attr__( 'If you select "No" the defined keyword will match both lowercase and uppercase variations. This option determines the default value of the "Case Sensitive Search" field available in the "Tooltips" menu.', 'automatic-tooltips' ) . '"></div>';

	}

	public function defaults_left_boundary_callback() {

		echo '<select id="daextauttol-defaults-left-boundary" name="daextauttol_defaults_left_boundary" class="daext-display-none">';
		echo '<option ' . selected( intval( get_option( "daextauttol_defaults_left_boundary" ) ), 0,
				false ) . ' value="0">' . esc_html__( 'Generic', 'automatic-tooltips' ) . '</option>';
		echo '<option ' . selected( intval( get_option( "daextauttol_defaults_left_boundary" ) ), 1,
				false ) . ' value="1">' . esc_html__( 'White Space', 'automatic-tooltips' ) . '</option>';
		echo '<option ' . selected( intval( get_option( "daextauttol_defaults_left_boundary" ) ), 2,
				false ) . ' value="2">' . esc_html__( 'Comma', 'automatic-tooltips' ) . '</option>';
		echo '<option ' . selected( intval( get_option( "daextauttol_defaults_left_boundary" ) ), 3,
				false ) . ' value="3">' . esc_html__( 'Point', 'automatic-tooltips' ) . '</option>';
		echo '<option ' . selected( intval( get_option( "daextauttol_defaults_left_boundary" ) ), 4,
				false ) . ' value="4">' . esc_html__( 'None', 'automatic-tooltips' ) . '</option>';
		echo '</select>';
		echo '<div class="help-icon" title="' . esc_attr__( 'Use this option to match keywords preceded by a generic boundary or by a specific character. This option determines the default value of the "Left Boundary" field available in the "Tooltips" menu.', 'automatic-tooltips' ) . '"></div>';

	}

	public function defaults_right_boundary_callback() {

		echo '<select id="daextauttol-defaults-right-boundary" name="daextauttol_defaults_right_boundary" class="daext-display-none">';
		echo '<option ' . selected( intval( get_option( "daextauttol_defaults_right_boundary" ), 10 ), 0,
				false ) . ' value="0">' . esc_html__( 'Generic', 'automatic-tooltips' ) . '</option>';
		echo '<option ' . selected( intval( get_option( "daextauttol_defaults_right_boundary" ), 10 ), 1,
				false ) . ' value="1">' . esc_html__( 'White Space', 'automatic-tooltips' ) . '</option>';
		echo '<option ' . selected( intval( get_option( "daextauttol_defaults_right_boundary" ), 10 ), 2,
				false ) . ' value="2">' . esc_html__( 'Comma', 'automatic-tooltips' ) . '</option>';
		echo '<option ' . selected( intval( get_option( "daextauttol_defaults_right_boundary" ), 10 ), 3,
				false ) . ' value="3">' . esc_html__( 'Point', 'automatic-tooltips' ) . '</option>';
		echo '<option ' . selected( intval( get_option( "daextauttol_defaults_right_boundary" ), 10 ), 4,
				false ) . ' value="4">' . esc_html__( 'None', 'automatic-tooltips' ) . '</option>';
		echo '</select>';
		echo '<div class="help-icon" title="' . esc_attr__( 'Use this option to match keywords followed by a generic boundary or by a specific character. This option determines the default value of the "Right Boundary" field available in the "Tooltips" menu.', 'automatic-tooltips' ) . '"></div>';

	}

	public function defaults_limit_callback() {

		echo '<input maxlength="7" type="text" id="daextauttol_defaults_limit" name="daextauttol_defaults_limit" class="regular-text" value="' . intval( get_option( "daextauttol_defaults_limit" ),
				10 ) . '" />';
		echo '<div class="help-icon" title="' . esc_attr__( 'With this option you can determine the maximum number of matches of the defined keyword automatically converted to a link. This option determines the default value of the "Limit" field available in the "Tooltips" menu.', 'automatic-tooltips' ) . '"></div>';

	}

	public function defaults_limit_validation( $input ) {

		if ( ! preg_match( $this->shared->regex_number_ten_digits, $input ) or intval( $input, 10 ) < 1 or intval( $input,
				10 ) > 1000000 ) {
			add_settings_error( 'daextauttol_defaults_limit', 'daextauttol_defaults_limit',
				esc_html__( 'Please enter a number from 1 to 1000000 in the "Limit" option.', 'automatic-tooltips' ) );
			$output = get_option( 'daextauttol_defaults_limit' );
		} else {
			$output = $input;
		}

		return intval( $output, 10 );

	}


	public function defaults_priority_callback() {

		echo '<input maxlength="7" type="text" id="daextauttol_defaults_priority" name="daextauttol_defaults_priority" class="regular-text" value="' . intval( get_option( "daextauttol_defaults_priority" ),
				10 ) . '" />';
		echo '<div class="help-icon" title="' . esc_attr__( 'The priority value determines the order used to apply the tooltips on the post. This option determines the default value of the "Priority" field available in the "Tooltips" menu.', 'automatic-tooltips' ) . '"></div>';

	}

	public function defaults_priority_validation( $input ) {

		if ( ! preg_match( $this->shared->regex_number_ten_digits, $input ) or intval( $input, 10 ) < 0 or intval( $input,
				10 ) > 1000000 ) {
			add_settings_error( 'daextauttol_defaults_priority', 'daextauttol_defaults_priority',
				esc_html__( 'Please enter a number from 1 to 1000000 in the "Priority" option.', 'automatic-tooltips' ) );
			$output = get_option( 'daextauttol_defaults_priority' );
		} else {
			$output = $input;
		}

		return intval( $output, 10 );

	}

	//analysis options callbacks and validations -----------------------------------------------------------------------
	public function analysis_set_max_execution_time_callback() {

		echo '<select id="daextauttol-analysis-set-max-execution-time" name="daextauttol_analysis_set_max_execution_time" class="daext-display-none">';
		echo '<option ' . selected( intval( get_option( "daextauttol_analysis_set_max_execution_time" ) ), 0,
				false ) . ' value="0">' . esc_html__( 'No', 'automatic-tooltips' ) . '</option>';
		echo '<option ' . selected( intval( get_option( "daextauttol_analysis_set_max_execution_time" ) ), 1,
				false ) . ' value="1">' . esc_html__( 'Yes', 'automatic-tooltips' ) . '</option>';
		echo '</select>';
		echo '<div class="help-icon" title="' . esc_attr__( 'Select "Yes" to enable your custom "Max Execution Time Value" on long running scripts.', 'automatic-tooltips' ) . '"></div>';

	}

	public function analysis_max_execution_time_value_callback() {

		echo '<input maxlength="7" type="text" id="daextauttol_analysis_max_execution_time_value" name="daextauttol_analysis_max_execution_time_value" class="regular-text" value="' . intval( get_option( "daextauttol_analysis_max_execution_time_value" ),
				10 ) . '" />';
		echo '<div class="help-icon" title="' . esc_attr__( 'This value determines the maximum number of seconds allowed to execute long running scripts.', 'automatic-tooltips' ) . '"></div>';

	}

	public function analysis_max_execution_time_value_validation( $input ) {

		if ( ! preg_match( $this->shared->regex_number_ten_digits, $input ) or intval( $input, 10 ) > 1000000 ) {
			add_settings_error( 'daextauttol_analysis_max_execution_time_value', 'daextauttol_analysis_max_execution_time_value',
				esc_html__( 'Please enter a valid value in the "Memory Limit Value" option.', 'automatic-tooltips' ) );
			$output = get_option( 'daextauttol_analysis_max_execution_time_value' );
		} else {
			$output = $input;
		}

		return intval( $output, 10 );

	}

	public function analysis_set_memory_limit_callback() {

		echo '<select id="daextauttol-analysis-set-memory-limit" name="daextauttol_analysis_set_memory_limit" class="daext-display-none">';
		echo '<option ' . selected( intval( get_option( "daextauttol_analysis_set_memory_limit" ) ), 0,
				false ) . ' value="0">' . esc_html__( 'No', 'automatic-tooltips' ) . '</option>';
		echo '<option ' . selected( intval( get_option( "daextauttol_analysis_set_memory_limit" ) ), 1,
				false ) . ' value="1">' . esc_html__( 'Yes', 'automatic-tooltips' ) . '</option>';
		echo '</select>';
		echo '<div class="help-icon" title="' . esc_attr__( 'Select "Yes" to enable your custom "Memory Limit Value" on long running scripts.', 'automatic-tooltips' ) . '"></div>';

	}

	public function analysis_memory_limit_value_callback() {

		echo '<input maxlength="7" type="text" id="daextauttol_analysis_memory_limit_value" name="daextauttol_analysis_memory_limit_value" class="regular-text" value="' . intval( get_option( "daextauttol_analysis_memory_limit_value" ),
				10 ) . '" />';
		echo '<div class="help-icon" title="' . esc_attr__( 'This value determines the PHP memory limit in megabytes allowed to execute long running scripts.', 'automatic-tooltips' ) . '"></div>';

	}

	public function analysis_memory_limit_value_validation( $input ) {

		if ( ! preg_match( $this->shared->regex_number_ten_digits, $input ) or intval( $input, 10 ) > 1000000 ) {
			add_settings_error( 'daextauttol_analysis_memory_limit_value', 'daextauttol_analysis_memory_limit_value',
				esc_html__( 'Please enter a valid value in the "Memory Limit Value" option.', 'automatic-tooltips' ) );
			$output = get_option( 'daextauttol_analysis_memory_limit_value' );
		} else {
			$output = $input;
		}

		return intval( $output, 10 );

	}

	public function analysis_limit_posts_analysis_callback() {

		echo '<input maxlength="7" type="text" id="daextauttol_analysis_limit_posts_analysis" name="daextauttol_analysis_limit_posts_analysis" class="regular-text" value="' . intval( get_option( "daextauttol_analysis_limit_posts_analysis" ),
				10 ) . '" />';
		echo '<div class="help-icon" title="' . esc_attr__( 'With this options you can determine the maximum number of posts analyzed to get information about your tooltips. If you select for example "1000", the analysis performed by the plugin will use your latest "1000" posts.', 'automatic-tooltips' ) . '"></div>';

	}

	public function analysis_limit_posts_analysis_validation( $input ) {

		if ( ! preg_match( $this->shared->regex_number_ten_digits, $input ) or intval( $input, 10 ) > 1000000 ) {
			add_settings_error( 'daextauttol_analysis_limit_posts_analysis', 'daextauttol_analysis_limit_posts_analysis',
				esc_html__( 'Please enter a valid value in the "Limit Post Analysis" option.', 'automatic-tooltips' ) );
			$output = get_option( 'daextauttol_analysis_limit_posts_analysis' );
		} else {
			$output = $input;
		}

		return intval( $output, 10 );

	}


	public function analysis_post_types_callback() {

		$analysis_post_types_a = get_option( "daextauttol_analysis_post_types" );

		$available_post_types_a = get_post_types( array(
			'public'  => true,
			'show_ui' => true
		) );

		//Remove the "attachment" post type
		$available_post_types_a = array_diff( $available_post_types_a, array( 'attachment' ) );

		echo '<select id="daextauttol-analysis-post-types" name="daextauttol_analysis_post_types[]" class="daext-display-none" multiple>';

		foreach ( $available_post_types_a as $single_post_type ) {
			if ( is_array( $analysis_post_types_a ) and in_array( $single_post_type, $analysis_post_types_a ) ) {
				$selected = 'selected';
			} else {
				$selected = '';
			}
			$post_type_obj = get_post_type_object( $single_post_type );
			echo '<option value="' . esc_attr($single_post_type) . '" ' . esc_attr($selected) . '>' . esc_html( $post_type_obj->label ) . '</option>';
		}

		echo '</select>';
		echo '<div class="help-icon" title="' . esc_attr__( 'With this option you are able to determine in which post types the analysis should be performed. Leave this field empty to perform the analysis in any post type.', 'automatic-tooltips' ) . '"></div>';

	}

	public function analysis_post_types_validation( $input ) {

		if ( is_array( $input ) ) {
			return $input;
		} else {
			return '';
		}

	}

	//advanced options callbacks and validations ---------------------------------------------------------------------
	public function advanced_enable_tooltips_callback() {

		echo '<select id="daextauttol-advanced-enable-tooltips" name="daextauttol_advanced_enable_tooltips" class="daext-display-none">';
		echo '<option ' . selected( intval( get_option( "daextauttol_advanced_enable_tooltips" ) ), 0,
				false ) . ' value="0">' . esc_html__( 'No', 'automatic-tooltips' ) . '</option>';
		echo '<option ' . selected( intval( get_option( "daextauttol_advanced_enable_tooltips" ) ), 1,
				false ) . ' value="1">' . esc_html__( 'Yes', 'automatic-tooltips' ) . '</option>';
		echo '</select>';
		echo '<div class="help-icon" title="' . esc_attr__( 'This option determines the default status of the "Enable Tooltips" option available in the "Automatic Tooltips" meta box.', 'automatic-tooltips' ) . '"></div>';

	}

	public function advanced_filter_priority_callback() {

		echo '<input maxlength="11" type="text" id="daextauttol_advanced_filter_priority" name="daextauttol_advanced_filter_priority" class="regular-text" value="' . intval( get_option( "daextauttol_advanced_filter_priority" ),
				10 ) . '" />';
		echo '<div class="help-icon" title="' . esc_attr__( 'This option determines the priority of the filter used to apply the tooltips. A lower number corresponds with an earlier execution.', 'automatic-tooltips' ) . '"></div>';

	}

	public function advanced_filter_priority_validation( $input ) {

		if ( intval( $input, 10 ) < - 2147483648 or intval( $input, 10 ) > 2147483646 ) {
			add_settings_error( 'daextauttol_advanced_filter_priority', 'daextauttol_advanced_filter_priority',
				esc_html__( 'Please enter a number from -2147483648 to 2147483646 in the "Filter Priority" option.', 'automatic-tooltips' ) );
			$output = get_option( 'daextauttol_advanced_filter_priority' );
		} else {
			$output = $input;
		}

		return intval( $output, 10 );

	}

	public function advanced_enable_test_mode_callback() {

		echo '<select id="daextauttol-advanced-enable-test-mode" name="daextauttol_advanced_enable_test_mode" class="daext-display-none">';
		echo '<option ' . selected( intval( get_option( "daextauttol_advanced_enable_test_mode" ) ), 0,
				false ) . ' value="0">' . esc_html__( 'No', 'automatic-tooltips' ) . '</option>';
		echo '<option ' . selected( intval( get_option( "daextauttol_advanced_enable_test_mode" ) ), 1,
				false ) . ' value="1">' . esc_html__( 'Yes', 'automatic-tooltips' ) . '</option>';
		echo '</select>';
		echo '<div class="help-icon" title="' . esc_attr__( 'With the test mode enabled the tooltips will be applied to your posts, pages or custom post types only if the user that is requesting the posts, pages or custom post types is the website administrator.', 'automatic-tooltips' ) . '"></div>';

	}

	public function advanced_random_prioritization_callback() {

		echo '<select id="daextauttol-advanced-random-prioritization" name="daextauttol_advanced_random_prioritization" class="daext-display-none">';
		echo '<option ' . selected( intval( get_option( "daextauttol_advanced_random_prioritization" ) ), 0,
				false ) . ' value="0">' . esc_html__( 'No', 'automatic-tooltips' ) . '</option>';
		echo '<option ' . selected( intval( get_option( "daextauttol_advanced_random_prioritization" ) ), 1,
				false ) . ' value="1">' . esc_html__( 'Yes', 'automatic-tooltips' ) . '</option>';
		echo '</select>';
		echo '<div class="help-icon" title="' . esc_attr__( "With this option enabled the order used to apply the tooltips with the same priority is randomized on a per-post basis. With this option disabled the order used to apply the tooltips with the same priority is the order used to add them in the back-end. It's recommended to enable this option for a better distribution of the tooltips.", 'automatic-tooltips' ) . '"></div>';

	}

	public function advanced_categories_and_tags_verification_callback() {

		echo '<select id="daextauttol-advanced-categories-and-tags-verification" name="daextauttol_advanced_categories_and_tags_verification" class="daext-display-none">';
		echo '<option ' . selected( get_option( "daextauttol_advanced_categories_and_tags_verification" ), 'post',
				false ) . ' value="post">' . esc_html__( 'Post', 'automatic-tooltips' ) . '</option>';
		echo '<option ' . selected( get_option( "daextauttol_advanced_categories_and_tags_verification" ), 'any',
				false ) . ' value="any">' . esc_html__( 'Any', 'automatic-tooltips' ) . '</option>';
		echo '</select>';
		echo '<div class="help-icon" title="' . esc_attr__( 'If "Post" is selected categories and tags will be verified only in the "post" post type, if "Any" is selected categories and tags will be verified in any post type.', 'automatic-tooltips' ) . '"></div>';

	}

	public function advanced_categories_and_tags_verification_validation( $input ) {

		switch ( $input ) {
			case 'post':
				return 'post';
			default:
				return 'any';
		}

	}

	public function advanced_general_limit_mode_callback() {

		echo '<select id="daextauttol-advanced-general-limit-mode" name="daextauttol_advanced_general_limit_mode" class="daext-display-none">';
		echo '<option ' . selected( intval( get_option( "daextauttol_advanced_general_limit_mode" ) ), 0,
				false ) . ' value="0">' . esc_html__( 'Auto', 'automatic-tooltips' ) . '</option>';
		echo '<option ' . selected( intval( get_option( "daextauttol_advanced_general_limit_mode" ) ), 1,
				false ) . ' value="1">' . esc_html__( 'Manual', 'automatic-tooltips' ) . '</option>';
		echo '</select>';
		echo '<div class="help-icon" title="' . esc_attr__( 'If "Auto" is selected the maximum number of tooltips per post is automatically generated based on the length of the post, in this case the "General Limit (Characters per Tooltips)" option is used. If "Manual" is selected the maximum number of tooltips per post is equal to the value of the "General Limit (Amount)" option.', 'automatic-tooltips' ) . '"></div>';

	}

	public function advanced_general_limit_characters_per_tooltip_callback() {

		echo '<input maxlength="7" type="text" id="daextauttol_advanced_general_limit_characters_per_tooltip" name="daextauttol_advanced_general_limit_characters_per_tooltip" class="regular-text" value="' . intval( get_option( "daextauttol_advanced_general_limit_characters_per_tooltip" ),
				10 ) . '" />';
		echo '<div class="help-icon" title="' . esc_attr__( 'This value is used to automatically determine the maximum number of tooltips per post when the "General Limit Mode" option is set to "Auto".', 'automatic-tooltips' ) . '"></div>';

	}

	public function advanced_general_limit_characters_per_tooltip_validation( $input ) {

		if ( ! preg_match( $this->shared->regex_number_ten_digits, $input ) or intval( $input, 10 ) < 1 or intval( $input,
				10 ) > 1000000 ) {
			add_settings_error( 'daextauttol_advanced_general_limit_characters_per_tooltip',
				'daextauttol_advanced_general_limit_characters_per_tooltip',
				esc_html__( 'Please enter a number from 1 to 1000000 in the "General Limit (Characters per Tooltip)" option.', 'automatic-tooltips' ) );
			$output = get_option( 'daextauttol_advanced_general_limit_characters_per_tooltip' );
		} else {
			$output = $input;
		}

		return intval( $output, 10 );

	}

	public function advanced_general_limit_amount_callback() {

		echo '<input maxlength="7" type="text" id="daextauttol_advanced_general_limit_amount" name="daextauttol_advanced_general_limit_amount" class="regular-text" value="' . intval( get_option( "daextauttol_advanced_general_limit_amount" ),
				10 ) . '" />';
		echo '<div class="help-icon" title="' . esc_attr__( 'This value determines the maximum number of tooltips per post when the "General Limit Mode" option is set to "Manual".', 'automatic-tooltips' ) . '"></div>';

	}

	public function advanced_general_limit_amount_validation( $input ) {

		if ( ! preg_match( $this->shared->regex_number_ten_digits, $input ) or intval( $input, 10 ) < 1 or intval( $input,
				10 ) > 1000000 ) {
			add_settings_error( 'daextauttol_advanced_general_limit_amount', 'daextauttol_advanced_general_limit_amount',
				esc_html__( 'Please enter a number from 1 to 1000000 in the "General Limit (Amount)" option.', 'automatic-tooltips' ) );
			$output = get_option( 'daextauttol_advanced_general_limit_amount' );
		} else {
			$output = $input;
		}

		return intval( $output, 10 );

	}

	public function advanced_protected_tags_callback() {

		$advanced_protected_tags_a = get_option( "daextauttol_advanced_protected_tags" );

		echo '<select id="daextauttol-advanced-protected-tags" name="daextauttol_advanced_protected_tags[]" class="daext-display-none" multiple>';

		$list_of_html_tags = array(
			'a',
			'abbr',
			'acronym',
			'address',
			'applet',
			'area',
			'article',
			'aside',
			'audio',
			'b',
			'base',
			'basefont',
			'bdi',
			'bdo',
			'big',
			'blockquote',
			'body',
			'br',
			'button',
			'canvas',
			'caption',
			'center',
			'cite',
			'code',
			'col',
			'colgroup',
			'datalist',
			'dd',
			'del',
			'details',
			'dfn',
			'dir',
			'div',
			'dl',
			'dt',
			'em',
			'embed',
			'fieldset',
			'figcaption',
			'figure',
			'font',
			'footer',
			'form',
			'frame',
			'frameset',
			'h1',
			'h2',
			'h3',
			'h4',
			'h5',
			'h6',
			'head',
			'header',
			'hgroup',
			'hr',
			'html',
			'i',
			'iframe',
			'img',
			'input',
			'ins',
			'kbd',
			'keygen',
			'label',
			'legend',
			'li',
			'link',
			'map',
			'mark',
			'menu',
			'meta',
			'meter',
			'nav',
			'noframes',
			'noscript',
			'object',
			'ol',
			'optgroup',
			'option',
			'output',
			'p',
			'param',
			'pre',
			'progress',
			'q',
			'rp',
			'rt',
			'ruby',
			's',
			'samp',
			'script',
			'section',
			'select',
			'small',
			'source',
			'span',
			'strike',
			'strong',
			'style',
			'sub',
			'summary',
			'sup',
			'table',
			'tbody',
			'td',
			'textarea',
			'tfoot',
			'th',
			'thead',
			'time',
			'title',
			'tr',
			'tt',
			'u',
			'ul',
			'var',
			'video',
			'wbr'
		);

		foreach ( $list_of_html_tags as $tag ) {
			echo '<option value="' . esc_attr($tag) . '" ' . esc_attr($this->shared->selected_array( $advanced_protected_tags_a,
					$tag )) . '>' . esc_html($tag) . '</option>';
		}

		echo '</select>';
		echo '<div class="help-icon" title="' . esc_attr__( 'With this option you are able to determine in which HTML tags the tooltips should not be applied.', 'automatic-tooltips' ) . '"></div>';

	}

	public function advanced_protected_gutenberg_blocks_callback() {

		$advanced_protected_gutenberg_blocks_a = get_option( "daextauttol_advanced_protected_gutenberg_blocks" );

		echo '<select id="daextauttol-advanced-protected-gutenberg-embeds" name="daextauttol_advanced_protected_gutenberg_blocks[]" class="daext-display-none" multiple>';

		echo '<option value="paragraph" ' . esc_attr($this->shared->selected_array( $advanced_protected_gutenberg_blocks_a,
				'paragraph' )) . '>' . esc_html__( 'Paragraph', 'automatic-tooltips' ) . '</option>';
		echo '<option value="image" ' . esc_attr($this->shared->selected_array( $advanced_protected_gutenberg_blocks_a,
				'image' )) . '>' . esc_html__( 'Image', 'automatic-tooltips' ) . '</option>';
		echo '<option value="heading" ' . esc_attr($this->shared->selected_array( $advanced_protected_gutenberg_blocks_a,
				'heading' )) . '>' . esc_html__( 'Heading', 'automatic-tooltips' ) . '</option>';
		echo '<option value="gallery" ' . esc_attr( $this->shared->selected_array( $advanced_protected_gutenberg_blocks_a,
				'gallery' )) . '>' . esc_html__( 'Gallery', 'automatic-tooltips' ) . '</option>';
		echo '<option value="list" ' . esc_attr( $this->shared->selected_array( $advanced_protected_gutenberg_blocks_a,
				'list' )) . '>' . esc_html__( 'List', 'automatic-tooltips' ) . '</option>';
		echo '<option value="quote" ' . esc_attr( $this->shared->selected_array( $advanced_protected_gutenberg_blocks_a,
				'quote' )) . '>' . esc_html__( 'Quote', 'automatic-tooltips' ) . '</option>';
		echo '<option value="audio" ' . esc_attr( $this->shared->selected_array( $advanced_protected_gutenberg_blocks_a,
				'audio' )) . '>' . esc_html__( 'Audio', 'automatic-tooltips' ) . '</option>';
		echo '<option value="cover-image" ' . esc_attr( $this->shared->selected_array( $advanced_protected_gutenberg_blocks_a,
				'cover-image' )) . '>' . esc_html__( 'Cover Image', 'automatic-tooltips' ) . '</option>';
		echo '<option value="subhead" ' . esc_attr( $this->shared->selected_array( $advanced_protected_gutenberg_blocks_a,
				'subhead' )) . '>' . esc_html__( 'Subhead', 'automatic-tooltips' ) . '</option>';
		echo '<option value="video" ' . esc_attr( $this->shared->selected_array( $advanced_protected_gutenberg_blocks_a,
				'video' )) . '>' . esc_html__( 'Video', 'automatic-tooltips' ) . '</option>';
		echo '<option value="code" ' . esc_attr( $this->shared->selected_array( $advanced_protected_gutenberg_blocks_a,
				'code' )) . '>' . esc_html__( 'Code', 'automatic-tooltips' ) . '</option>';
		echo '<option value="html" ' . esc_attr( $this->shared->selected_array( $advanced_protected_gutenberg_blocks_a,
				'html' )) . '>' . esc_html__( 'Custom HTML', 'automatic-tooltips' ) . '</option>';
		echo '<option value="preformatted" ' . esc_attr( $this->shared->selected_array( $advanced_protected_gutenberg_blocks_a,
				'preformatted' )) . '>' . esc_html__( 'Preformatted', 'automatic-tooltips' ) . '</option>';
		echo '<option value="pullquote" ' . esc_attr( $this->shared->selected_array( $advanced_protected_gutenberg_blocks_a,
				'pullquote' )) . '>' . esc_html__( 'Pullquote', 'automatic-tooltips' ) . '</option>';
		echo '<option value="table" ' . esc_attr( $this->shared->selected_array( $advanced_protected_gutenberg_blocks_a,
				'table' )) . '>' . esc_html__( 'Table', 'automatic-tooltips' ) . '</option>';
		echo '<option value="verse" ' . esc_attr( $this->shared->selected_array( $advanced_protected_gutenberg_blocks_a,
				'verse' )) . '>' . esc_html__( 'Verse', 'automatic-tooltips' ) . '</option>';
		echo '<option value="button" ' . esc_attr( $this->shared->selected_array( $advanced_protected_gutenberg_blocks_a,
				'button' )) . '>' . esc_html__( 'Button', 'automatic-tooltips' ) . '</option>';
		echo '<option value="columns" ' . esc_attr( $this->shared->selected_array( $advanced_protected_gutenberg_blocks_a,
				'columns' )) . '>' . esc_html__( 'Columns (Experimentals)', 'automatic-tooltips' ) . '</option>';
		echo '<option value="more" ' . esc_attr( $this->shared->selected_array( $advanced_protected_gutenberg_blocks_a,
				'more' )) . '>' . esc_html__( 'More', 'automatic-tooltips' ) . '</option>';
		echo '<option value="nextpage" ' . esc_attr( $this->shared->selected_array( $advanced_protected_gutenberg_blocks_a,
				'nextpage' )) . '>' . esc_html__( 'Page Break', 'automatic-tooltips' ) . '</option>';
		echo '<option value="separator" ' . esc_attr( $this->shared->selected_array( $advanced_protected_gutenberg_blocks_a,
				'separator' )) . '>' . esc_html__( 'Separator', 'automatic-tooltips' ) . '</option>';
		echo '<option value="spacer" ' . esc_attr( $this->shared->selected_array( $advanced_protected_gutenberg_blocks_a,
				'spacer' )) . '>' . esc_html__( 'Spacer', 'automatic-tooltips' ) . '</option>';
		echo '<option value="text-columns" ' . esc_attr( $this->shared->selected_array( $advanced_protected_gutenberg_blocks_a,
				'text-columns' )) . '>' . esc_html__( 'Text Columnns', 'automatic-tooltips' ) . '</option>';
		echo '<option value="shortcode" ' . esc_attr( $this->shared->selected_array( $advanced_protected_gutenberg_blocks_a,
				'shortcode' )) . '>' . esc_html__( 'Shortcode', 'automatic-tooltips' ) . '</option>';
		echo '<option value="categories" ' . esc_attr( $this->shared->selected_array( $advanced_protected_gutenberg_blocks_a,
				'categories' )) . '>' . esc_html__( 'Categories', 'automatic-tooltips' ) . '</option>';
		echo '<option value="latest-posts" ' . esc_attr( $this->shared->selected_array( $advanced_protected_gutenberg_blocks_a,
				'latest-posts' )) . '>' . esc_html__( 'Latest Posts', 'automatic-tooltips' ) . '</option>';
		echo '<option value="embed" ' . esc_attr( $this->shared->selected_array( $advanced_protected_gutenberg_blocks_a,
				'embed' )) . '>' . esc_html__( 'Embed', 'automatic-tooltips' ) . '</option>';
		echo '<option value="core-embed/twitter" ' . esc_attr( $this->shared->selected_array( $advanced_protected_gutenberg_blocks_a,
				'core-embed/twitter' )) . '>' . esc_html__( 'Twitter', 'automatic-tooltips' ) . '</option>';
		echo '<option value="core-embed/youtube" ' . esc_attr( $this->shared->selected_array( $advanced_protected_gutenberg_blocks_a,
				'core-embed/youtube' )) . '>' . esc_html__( 'YouTube', 'automatic-tooltips' ) . '</option>';
		echo '<option value="core-embed/facebook" ' . esc_attr( $this->shared->selected_array( $advanced_protected_gutenberg_blocks_a,
				'core-embed/facebook' )) . '>' . esc_html__( 'Facebook', 'automatic-tooltips' ) . '</option>';
		echo '<option value="core-embed/instagram" ' . esc_attr( $this->shared->selected_array( $advanced_protected_gutenberg_blocks_a,
				'core-embed/instagram' )) . '>' . esc_html__( 'Instagram', 'automatic-tooltips' ) . '</option>';
		echo '<option value="core-embed/wordpress" ' . esc_attr( $this->shared->selected_array( $advanced_protected_gutenberg_blocks_a,
				'core-embed/wordpress' )) . '>' . esc_html__( 'WordPress', 'automatic-tooltips' ) . '</option>';
		echo '<option value="core-embed/soundcloud" ' . esc_attr( $this->shared->selected_array( $advanced_protected_gutenberg_blocks_a,
				'core-embed/soundcloud' )) . '>' . esc_html__( 'SoundCloud', 'automatic-tooltips' ) . '</option>';
		echo '<option value="core-embed/spotify" ' . esc_attr( $this->shared->selected_array( $advanced_protected_gutenberg_blocks_a,
				'core-embed/spotify' )) . '>' . esc_html__( 'Spotify', 'automatic-tooltips' ) . '</option>';
		echo '<option value="core-embed/flickr" ' . esc_attr( $this->shared->selected_array( $advanced_protected_gutenberg_blocks_a,
				'core-embed/flickr' )) . '>' . esc_html__( 'Flickr', 'automatic-tooltips' ) . '</option>';
		echo '<option value="core-embed/vimeo" ' . esc_attr( $this->shared->selected_array( $advanced_protected_gutenberg_blocks_a,
				'core-embed/vimeo' )) . '>' . esc_html__( 'Vimeo', 'automatic-tooltips' ) . '</option>';
		echo '<option value="core-embed/animoto" ' . esc_attr( $this->shared->selected_array( $advanced_protected_gutenberg_blocks_a,
				'core-embed/animoto' )) . '>' . esc_html__( 'Animoto', 'automatic-tooltips' ) . '</option>';
		echo '<option value="core-embed/cloudup" ' . esc_attr( $this->shared->selected_array( $advanced_protected_gutenberg_blocks_a,
				'core-embed/cloudup' )) . '>' . esc_html__( 'Cloudup', 'automatic-tooltips' ) . '</option>';
		echo '<option value="core-embed/collegehumor" ' . esc_attr( $this->shared->selected_array( $advanced_protected_gutenberg_blocks_a,
				'core-embed/collegehumor' )) . '>' . esc_html__( 'CollegeHumor', 'automatic-tooltips' ) . '</option>';
		echo '<option value="core-embed/dailymotion" ' . esc_attr( $this->shared->selected_array( $advanced_protected_gutenberg_blocks_a,
				'core-embed/dailymotion' )) . '>' . esc_html__( 'DailyMotion', 'automatic-tooltips' ) . '</option>';
		echo '<option value="core-embed/funnyordie" ' . esc_attr( $this->shared->selected_array( $advanced_protected_gutenberg_blocks_a,
				'core-embed/funnyordie' )) . '>' . esc_html__( 'Funny or Die', 'automatic-tooltips' ) . '</option>';
		echo '<option value="core-embed/hulu" ' . esc_attr( $this->shared->selected_array( $advanced_protected_gutenberg_blocks_a,
				'core-embed/hulu' )) . '>' . esc_html__( 'Hulu', 'automatic-tooltips' ) . '</option>';
		echo '<option value="core-embed/imgur" ' . esc_attr( $this->shared->selected_array( $advanced_protected_gutenberg_blocks_a,
				'core-embed/imgur' )) . '>' . esc_html__( 'Imgur', 'automatic-tooltips' ) . '</option>';
		echo '<option value="core-embed/issuu" ' . esc_attr( $this->shared->selected_array( $advanced_protected_gutenberg_blocks_a,
				'core-embed/issuu' )) . '>' . esc_html__( 'Issuu', 'automatic-tooltips' ) . '</option>';
		echo '<option value="core-embed/kickstarter" ' . esc_attr( $this->shared->selected_array( $advanced_protected_gutenberg_blocks_a,
				'core-embed/kickstarter' )) . '>' . esc_html__( 'Kickstarter', 'automatic-tooltips' ) . '</option>';
		echo '<option value="core-embed/meetup-com" ' . esc_attr( $this->shared->selected_array( $advanced_protected_gutenberg_blocks_a,
				'core-embed/meetup-com' )) . '>' . esc_html__( 'Meetup.com', 'automatic-tooltips' ) . '</option>';
		echo '<option value="core-embed/mixcloud" ' . esc_attr( $this->shared->selected_array( $advanced_protected_gutenberg_blocks_a,
				'core-embed/mixcloud' )) . '>' . esc_html__( 'Mixcloud', 'automatic-tooltips' ) . '</option>';
		echo '<option value="core-embed/photobucket" ' . esc_attr( $this->shared->selected_array( $advanced_protected_gutenberg_blocks_a,
				'core-embed/photobucket' )) . '>' . esc_html__( 'Photobucket', 'automatic-tooltips' ) . '</option>';
		echo '<option value="core-embed/polldaddy" ' . esc_attr( $this->shared->selected_array( $advanced_protected_gutenberg_blocks_a,
				'core-embed/polldaddy' )) . '>' . esc_html__( 'Polldaddy', 'automatic-tooltips' ) . '</option>';
		echo '<option value="core-embed/reddit" ' . esc_attr( $this->shared->selected_array( $advanced_protected_gutenberg_blocks_a,
				'core-embed/reddit' )) . '>' . esc_html__( 'Reddit', 'automatic-tooltips' ) . '</option>';
		echo '<option value="core-embed/reverbnation" ' . esc_attr( $this->shared->selected_array( $advanced_protected_gutenberg_blocks_a,
				'core-embed/reverbnation' )) . '>' . esc_html__( 'ReverbNation', 'automatic-tooltips' ) . '</option>';
		echo '<option value="core-embed/screencast" ' . esc_attr( $this->shared->selected_array( $advanced_protected_gutenberg_blocks_a,
				'core-embed/screencast' )) . '>' . esc_html__( 'Screencast', 'automatic-tooltips' ) . '</option>';
		echo '<option value="core-embed/scribd" ' . esc_attr( $this->shared->selected_array( $advanced_protected_gutenberg_blocks_a,
				'core-embed/scribd' )) . '>' . esc_html__( 'Scribd', 'automatic-tooltips' ) . '</option>';
		echo '<option value="core-embed/slideshare" ' . esc_attr( $this->shared->selected_array( $advanced_protected_gutenberg_blocks_a,
				'core-embed/slideshare' )) . '>' . esc_html__( 'Slideshare', 'automatic-tooltips' ) . '</option>';
		echo '<option value="core-embed/smugmug" ' . esc_attr( $this->shared->selected_array( $advanced_protected_gutenberg_blocks_a,
				'core-embed/smugmug' )) . '>' . esc_html__( 'SmugMug', 'automatic-tooltips' ) . '</option>';
		echo '<option value="core-embed/speaker" ' . esc_attr( $this->shared->selected_array( $advanced_protected_gutenberg_blocks_a,
				'core-embed/speaker' )) . '>' . esc_html__( 'Speaker', 'automatic-tooltips' ) . '</option>';
		echo '<option value="core-embed/ted" ' . esc_attr( $this->shared->selected_array( $advanced_protected_gutenberg_blocks_a,
				'core-embed/ted' )) . '>' . esc_html__( 'Ted', 'automatic-tooltips' ) . '</option>';
		echo '<option value="core-embed/tumblr" ' . esc_attr( $this->shared->selected_array( $advanced_protected_gutenberg_blocks_a,
				'core-embed/tumblr' )) . '>' . esc_html__( 'Tumblr', 'automatic-tooltips' ) . '</option>';
		echo '<option value="core-embed/videopress" ' . esc_attr( $this->shared->selected_array( $advanced_protected_gutenberg_blocks_a,
				'core-embed/videopress' )) . '>' . esc_html__( 'VideoPress', 'automatic-tooltips' ) . '</option>';
		echo '<option value="core-embed/wordpress-tv" ' . esc_attr( $this->shared->selected_array( $advanced_protected_gutenberg_blocks_a,
				'core-embed/wordpress-tv' )) . '>' . esc_html__( 'WordPress.tv', 'automatic-tooltips' ) . '</option>';

		echo '</select>';
		echo '<div class="help-icon" title="' . esc_attr__( 'With this option you are able to determine in which Gutenberg blocks the tooltips should not be applied.', 'automatic-tooltips' ) . '"></div>';

	}

	public function advanced_protected_gutenberg_custom_blocks_callback() {

		echo '<input type="text" id="daextauttol_advanced_protected_gutenberg_custom_blocks" name="daextauttol_advanced_protected_gutenberg_custom_blocks" class="regular-text" value="' . esc_attr( get_option( "daextauttol_advanced_protected_gutenberg_custom_blocks" ) ) . '" />';
		echo '<div class="help-icon" title="' . esc_attr__( 'Enter a list of Gutenberg custom blocks, separated by a comma.', 'automatic-tooltips' ) . '"></div>';

	}

	public function advanced_protected_gutenberg_custom_blocks_validation( $input ) {

		if ( strlen( trim( $input ) ) > 0 and ! preg_match( $this->shared->regex_list_of_gutenberg_blocks, $input ) ) {
			add_settings_error( 'daextauttol_advanced_protected_gutenberg_custom_blocks',
				'daextauttol_advanced_protected_gutenberg_custom_blocks',
				esc_html__( 'Please enter a valid list of Gutenberg custom blocks separated by a comma in the "Protected Gutenberg Custom Blocks" option.', 'automatic-tooltips' ) );
			$output = get_option( 'daextauttol_advanced_protected_gutenberg_custom_blocks' );
		} else {
			$output = $input;
		}

		return $output;

	}

	public function advanced_protected_gutenberg_custom_void_blocks_callback() {

		echo '<input type="text" id="daextauttol_advanced_protected_gutenberg_custom_void_blocks" name="daextauttol_advanced_protected_gutenberg_custom_void_blocks" class="regular-text" value="' . esc_attr( get_option( "daextauttol_advanced_protected_gutenberg_custom_void_blocks" ) ) . '" />';
		echo '<div class="help-icon" title="' . esc_attr__( 'Enter a list of Gutenberg custom void blocks, separated by a comma.', 'automatic-tooltips' ) . '"></div>';

	}

	public function advanced_protected_gutenberg_custom_void_blocks_validation( $input ) {

		if ( strlen( trim( $input ) ) > 0 and ! preg_match( $this->shared->regex_list_of_gutenberg_blocks, $input ) ) {
			add_settings_error( 'daextauttol_advanced_protected_gutenberg_custom_void_blocks',
				'daextauttol_advanced_protected_gutenberg_custom_void_blocks',
				esc_html__( 'Please enter a valid list of Gutenberg custom void blocks separated by a comma in the "Protected Gutenberg Custom Void Blocks" option.', 'automatic-tooltips' ) );
			$output = get_option( 'daextauttol_advanced_protected_gutenberg_custom_void_blocks' );
		} else {
			$output = $input;
		}

		return $output;

	}

}