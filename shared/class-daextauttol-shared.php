<?php

/*
 * this class should be used to stores properties and methods shared by the
 * admin and public side of wordpress
 */

class Daextauttol_Shared {

	//properties used in add_tooltips()
	private $tooltip_id = 0;
	private $tooltip_a = array();
	private $parsed_tooltip = null;
	private $parsed_post_type = null;
	private $max_number_tooltips_per_post = null;
	private $tooltips_ca = null;
	private $pb_id = null;
	private $pb_a = null;

	//regex
	public $regex_list_of_gutenberg_blocks = '/^(\s*([A-Za-z0-9-\/]+\s*,\s*)+[A-Za-z0-9-\/]+\s*|\s*[A-Za-z0-9-\/]+\s*)$/';
	public $regex_number_ten_digits = '/^\s*\d{1,10}\s*$/';
	public $number_of_replacements = 0;
	public $font_family_regex = '/^([A-Za-z0-9-\'", ]*)$/';

	private $post_id = null;

	protected static $instance = null;

	private $data = array();

	private function __construct() {

		$this->data['slug'] = 'daextauttol';
		$this->data['ver']  = '1.09';
		$this->data['dir']  = substr( plugin_dir_path( __FILE__ ), 0, - 7 );
		$this->data['url']  = substr( plugin_dir_url( __FILE__ ), 0, - 7 );

		//Here are stored the plugin option with the related default values
		$this->data['options'] = [

			//Database Version -----------------------------------------------------------------------------------------
			$this->get( 'slug' ) . "_database_version"                              => "0",

			//Style ----------------------------------------------------------------------------------------------------
			$this->get( 'slug' ) . '_style_tooltip_background_color'                => "#000000",
			$this->get( 'slug' ) . '_style_tooltip_font_color'                      => "#FFFFFF",
			$this->get( 'slug' ) . '_style_tooltip_font_family'                     => "-apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen-Sans, Ubuntu, Cantarell, 'Helvetica Neue', sans-serif",
			$this->get( 'slug' ) . '_style_tooltip_font_weight'                     => "inherit",
			$this->get( 'slug' ) . '_style_tooltip_font_size'                       => "18",
			$this->get( 'slug' ) . '_style_tooltip_font_line_height'                => "29",
			$this->get( 'slug' ) . '_style_tooltip_horizontal_padding'              => "24",
			$this->get( 'slug' ) . '_style_tooltip_vertical_padding'                => "24",
			$this->get( 'slug' ) . '_style_tooltip_border_radius'                   => "4",
			$this->get( 'slug' ) . '_style_tooltip_max_width'                       => "400",
			$this->get( 'slug' ) . '_style_tooltip_text_alignment'                  => "left",
			$this->get( 'slug' ) . '_style_tooltip_drop_shadow'                     => "0",
			$this->get( 'slug' ) . '_style_tooltip_animation'                       => "1",
			$this->get( 'slug' ) . '_style_tooltip_animation_transition_duration'   => "150",
			$this->get( 'slug' ) . '_style_tooltip_arrow_size'                      => "10",
			$this->get( 'slug' ) . '_style_keyword_background_color'                => "#CCCCCC",
			$this->get( 'slug' ) . '_style_keyword_font_color'                      => "#000000",
			$this->get( 'slug' ) . '_style_keyword_font_family'                     => "-apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen-Sans, Ubuntu, Cantarell, 'Helvetica Neue', sans-serif",
			$this->get( 'slug' ) . '_style_keyword_font_weight'                     => "inherit",
			$this->get( 'slug' ) . '_style_keyword_font_size'                       => "18",
			$this->get( 'slug' ) . '_style_keyword_decoration'                      => "underline solid",

			//Defaults -------------------------------------------------------------------------------------------------
			$this->get( 'slug' ) . '_defaults_category_id'                          => "0",
			$this->get( 'slug' ) . '_defaults_post_types'                           => "",
			$this->get( 'slug' ) . '_defaults_categories'                           => "",
			$this->get( 'slug' ) . '_defaults_tags'                                 => "",
			$this->get( 'slug' ) . '_defaults_case_sensitive_search'                => "0",
			$this->get( 'slug' ) . '_defaults_left_boundary'                        => "0",
			$this->get( 'slug' ) . '_defaults_right_boundary'                       => "0",
			$this->get( 'slug' ) . '_defaults_limit'                                => "1",
			$this->get( 'slug' ) . '_defaults_priority'                             => "0",

			//Analysis -------------------------------------------------------------------------------------------------
			$this->get( 'slug' ) . '_analysis_set_max_execution_time'               => "1",
			$this->get( 'slug' ) . '_analysis_max_execution_time_value'             => "300",
			$this->get( 'slug' ) . '_analysis_set_memory_limit'                     => "1",
			$this->get( 'slug' ) . '_analysis_memory_limit_value'                   => "512",
			$this->get( 'slug' ) . '_analysis_limit_posts_analysis'                 => "1000",
			$this->get( 'slug' ) . '_analysis_post_types'                           => "",

			//Advanced -------------------------------------------------------------------------------------------------
			$this->get( 'slug' ) . '_advanced_enable_tooltips'                      => "1",
			$this->get( 'slug' ) . '_advanced_filter_priority'                      => "2147483646",
			$this->get( 'slug' ) . '_advanced_enable_test_mode'                     => "0",
			$this->get( 'slug' ) . '_advanced_random_prioritization'                => "0",
			$this->get( 'slug' ) . '_advanced_categories_and_tags_verification'     => "post",
			$this->get( 'slug' ) . '_advanced_general_limit_mode'                   => "1",
			$this->get( 'slug' ) . '_advanced_general_limit_characters_per_tooltip' => "200",
			$this->get( 'slug' ) . '_advanced_general_limit_amount'                 => "100",

			/*
			 * By default the following HTML tags are protected:
			 *
			 * - h1
			 * - h2
			 * - h3
			 * - h4
			 * - h5
			 * - h6
			 * - a
			 * - img
			 * - pre
			 * - code
			 * - table
			 * - iframe
			 * - script
			 */
			$this->get( 'slug' ) . '_advanced_protected_tags'                       => array(
				'h1',
				'h2',
				'h3',
				'h4',
				'h5',
				'h6',
				'a',
				'img',
				'ul',
				'ol',
				'span',
				'pre',
				'code',
				'table',
				'iframe',
				'script'
			),

			/*
			 * By default all the Gutenberg Blocks except the following are protected:
			 *
			 * - Paragraph
			 * - List
			 * - Text Columns
			 */
			$this->get( 'slug' ) . '_advanced_protected_gutenberg_blocks'           => array(
				//'paragraph',
				'image',
				'heading',
				'gallery',
				//'list',
				'quote',
				'audio',
				'cover-image',
				'subhead',
				'video',
				'code',
				'html',
				'preformatted',
				'pullquote',
				'table',
				'verse',
				'button',
				'columns',
				'more',
				'nextpage',
				'separator',
				'spacer',
				//'text-columns',
				'shortcode',
				'categories',
				'latest-posts',
				'embed',
				'core-embed/twitter',
				'core-embed/youtube',
				'core-embed/facebook',
				'core-embed/instagram',
				'core-embed/wordpress',
				'core-embed/soundcloud',
				'core-embed/spotify',
				'core-embed/flickr',
				'core-embed/vimeo',
				'core-embed/animoto',
				'core-embed/cloudup',
				'core-embed/collegehumor',
				'core-embed/dailymotion',
				'core-embed/funnyordie',
				'core-embed/hulu',
				'core-embed/imgur',
				'core-embed/issuu',
				'core-embed/kickstarter',
				'core-embed/meetup-com',
				'core-embed/mixcloud',
				'core-embed/photobucket',
				'core-embed/polldaddy',
				'core-embed/reddit',
				'core-embed/reverbnation',
				'core-embed/screencast',
				'core-embed/scribd',
				'core-embed/slideshare',
				'core-embed/smugmug',
				'core-embed/speaker',
				'core-embed/ted',
				'core-embed/tumblr',
				'core-embed/videopress',
				'core-embed/wordpress-tv'
			),

			$this->get( 'slug' ) . '_advanced_protected_gutenberg_custom_blocks'      => "",
			$this->get( 'slug' ) . '_advanced_protected_gutenberg_custom_void_blocks' => "",

		];

	}

	public static function get_instance() {

		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;

	}

	//retrieve data
	public function get( $index ) {
		return $this->data[ $index ];
	}

	/*
	 * Add tooltips to the content based on the keyword created with the AIL menu:
	 *
	 * 1 - The protected blocks are applied with apply_protected_blocks()
	 * 2 - The words to be converted as a link are temporarely replaced with [ail]ID[/ail]
	 * 3 - The [al]ID[/al] identifiers are replaced with the actual links
	 * 4 - The protected block are removed with the remove_protected_blocks()
	 * 5 - The content with applied the tooltips is returned
	 *
	 * @param $content The content on which the tooltips should be applied.
	 * @param $check_query This parameter is set to True when the method is called inside the loop and is used to
	 * verify if we are in a single post.
	 * @param $post_type If the tooltips are added from the back-end this parameter is used to determine the post type
	 * of the content.
	 * $post_id This parameter is used if the method has been called outside the loop.
	 * @return string The content with applied the tooltips.
	 *
	 */
	public function add_tooltips( $content, $check_query = true, $post_type = '', $post_id = false ) {

		//Verify that we are inside a post, page or cpt
		if ( $check_query ) {
			if ( ! is_singular() or is_attachment() or is_feed() ) {
				return $content;
			}
		}

		//If the $post_id is not set means that we are in the loop and can be retrieved with get_the_ID()
		if ( $post_id === false ) {
			$this->post_id = get_the_ID();
		} else {
			$this->post_id = $post_id;
		}

		/*
		 * Verify with the "Enable tooltips" post meta data or (if the meta data is not present) verify with the
		 * "Enable tooltips" option if the tooltips should be applied to this post.
		 */
		$enable_tooltips = get_post_meta( $this->post_id, '_daextauttol_enable_tooltips', true );
		if ( strlen( trim( $enable_tooltips ) ) === 0 ) {
			$enable_tooltips = get_option( $this->get( 'slug' ) . '_advanced_enable_tooltips' );
		}
		if ( intval( $enable_tooltips, 10 ) === 0 ) {
			$this->number_of_replacements = 0;

			return $content;
		}

		//Protect the tags and the commented HTML with the protected blocks
		$content = $this->apply_protected_blocks( $content );

		//Get the maximum number of tooltips allowed per post
		$this->max_number_tooltips_per_post = $this->get_max_number_tooltips_per_post( $this->post_id );

		//Get an array with the tooltips from the db table
		global $wpdb;
		$table_name = $wpdb->prefix . $this->get( 'slug' ) . "_tooltip";
		$sql        = "SELECT * FROM $table_name ORDER BY priority DESC";
		$tooltips   = $wpdb->get_results( $sql, ARRAY_A );

		/*
		 * To avoid additional database requests for each tooltip in preg_replace_callback_2() save the data of the
		 * tooltip in an array that uses the "tooltip_id" as its index.
		 */
		$this->tooltips_ca = $this->save_tooltips_in_custom_array( $tooltips );

		//Apply the Random Prioritization if enabled
		if ( intval( get_option( $this->get( 'slug' ) . '_advanced_random_prioritization' ), 10 ) === 1 ) {
			$tooltips = $this->apply_random_prioritization( $tooltips, $this->post_id );
		}

		//Iterate through all the defined tooltips
		foreach ( $tooltips as $key => $tooltip ) {

			//Save this tooltip as a class property
			$this->parsed_tooltip = $tooltip;

			/*
			 * If $post_type is not empty means that we are adding the tooltips through the back-end, in this case set
			 * the $this->parsed_post_type property with the $post_type variable.
			 *
			 * If $post_type is empty means that we are in the loop and the post type can be retrieved with the
			 * get_post_type() function.
			 */
			if ( $post_type !== '' ) {
				$this->parsed_post_type = $post_type;
			} else {
				$this->parsed_post_type = get_post_type();
			}

			//Get the list of post types where the tooltips should be applied
			$post_types_a = maybe_unserialize( $tooltip['post_types'] );

			//if $post_types_a is not an array fill $post_types_a with the posts available in the website
			if ( ! is_array( $post_types_a ) ) {
				$post_types_a = $this->get_post_types_with_ui();
			}

			//Verify the post type
			if ( in_array( $this->parsed_post_type, $post_types_a ) === false ) {
				continue;
			}

			/*
			 * Verify categories and tags only in the "post" post type or in all the posts. This verification is based
			 * on the value of the $categories_and_tags_verification option.
			 *
			 * - If $categories_and_tags_verification is equal to "any" verify the presence of the selected categories
			 * and tags in any post type.
			 * - If $categories_and_tags_verification is equal to "post" verify the presence of the selected categories
			 * and tags only in the "post" post type.
			 */
			$categories_and_tags_verification = get_option( $this->get( 'slug' ) . "_advanced_categories_and_tags_verification" );
			if ( ( $categories_and_tags_verification === 'any' or get_post_type() === 'post' ) and
			     ( ! $this->is_compliant_with_categories( $this->post_id, $tooltip ) or
			       ! $this->is_compliant_with_tags( $this->post_id, $tooltip ) ) ) {
				continue;
			}

			//Get the max number of tooltips per keyword
			$max_number_tooltips_per_keyword = $tooltip['limit'];

			//Apply a case sensitive search if the case_sensitive_flag is set to True
			if ( $tooltip['case_sensitive_search'] ) {
				$modifier = 'u';//enable unicode modifier
			} else {
				$modifier = 'iu';//enable case insensitive and unicode modifier
			}

			//Find the left boundary
			switch ( $tooltip['left_boundary'] ) {
				case 0:
					$left_boundary = '\b';
					break;

				case 1:
					$left_boundary = ' ';
					break;

				case 2:
					$left_boundary = ',';
					break;

				case 3:
					$left_boundary = '\.';
					break;

				case 4:
					$left_boundary = '';
					break;
			}

			//Find the right boundary
			switch ( $tooltip['right_boundary'] ) {
				case 0:
					$right_boundary = '\b';
					break;

				case 1:
					$right_boundary = ' ';
					break;

				case 2:
					$right_boundary = ',';
					break;

				case 3:
					$right_boundary = '\.';
					break;

				case 4:
					$right_boundary = '';
					break;
			}

			//escape regex characters and the '/' regex delimiter
			$tooltip_keyword        = preg_quote( $tooltip['keyword'], '/' );
			$tooltip_keyword_before = preg_quote( $tooltip['keyword_before'], '/' );
			$tooltip_keyword_after  = preg_quote( $tooltip['keyword_after'], '/' );

			/*
			 * Step 1: "The creation of temporary identifiers of the substitutions"
			 *
			 * Replaces all the matches with the [al]ID[/al] string, where the ID is the identifier of the substitution.
			 * The ID is also used as the index of the $this->tooltip_a temporary array used to store information about
			 * all the substutions. This array will be later used in "Step 2" to replace the [al]ID[/al] string with the
			 * actual links.
			 */
			$content = preg_replace_callback(
				'/(' . $tooltip_keyword_before . ')(' . ( $left_boundary ) . ')(' . $tooltip_keyword . ')(' . ( $right_boundary ) . ')(' . $tooltip_keyword_after . ')/' . $modifier,
				array( $this, 'preg_replace_callback_1' ),
				$content,
				$max_number_tooltips_per_keyword );

		}

		/*
		 * Step 2: "The replacement of the temporary string [ail]ID[/ail]"
		 *
		 * Replaces the [al]ID[/al] matches found in the $content with the actual links by using the $this->tooltip_a
		 * array to find the identifier of the substitutions and by retrieving in the db table "tooltips" (with the
		 * "tooltip_id") additional information about the substitution.
		 */
		$content = preg_replace_callback(
			'/\[al\](\d+)\[\/al\]/',
			array( $this, 'preg_replace_callback_2' ),
			$content,
			- 1,
			$this->number_of_replacements );

		//Remove the protected blocks
		$content = $this->remove_protected_blocks( $content );

		//Reset the id of the tooltip
		$this->tooltip_id = 0;

		//Reset the array that includes the data of the tooltips already applied
		$this->tooltip_a = array();

		return $content;

	}

	/*
	 * Replaces the following elements with [pr]ID[/pr]:
	 *
	 * - Protected Gutenberg Blocks
	 * - Protected Gutenberg Custom Blocks
	 * - Protected Gutenberg Custom Void Blocks
	 * - The sections enclosed in HTML comments
	 * - The Protected Tags
	 *
	 * The replaced tags and URLs are saved in the property $pr_a, an array with the ID used in the block as the index.
	 *
	 * @param $content string The unprotected $content
	 * @return string The $content with applied the protected block
	 */
	private function apply_protected_blocks( $content ) {

		$this->pb_id = 0;
		$this->pb_a  = array();

		//Get the Gutenberg Protected Blocks
		$protected_gutenberg_blocks   = get_option( $this->get( 'slug' ) . '_advanced_protected_gutenberg_blocks' );
		$protected_gutenberg_blocks_a = maybe_unserialize( $protected_gutenberg_blocks );
		if ( ! is_array( $protected_gutenberg_blocks_a ) ) {
			$protected_gutenberg_blocks_a = array();
		}

		//Get the Protected Gutenberg Custom Blocks
		$protected_gutenberg_custom_blocks   = get_option( $this->get( 'slug' ) . '_advanced_protected_gutenberg_custom_blocks' );
		$protected_gutenberg_custom_blocks_a = array_filter( explode( ',',
			str_replace( ' ', '', trim( $protected_gutenberg_custom_blocks ) ) ) );

		//Get the Protected Gutenberg Custom Void Blocks
		$protected_gutenberg_custom_void_blocks   = get_option( $this->get( 'slug' ) . '_advanced_protected_gutenberg_custom_void_blocks' );
		$protected_gutenberg_custom_void_blocks_a = array_filter( explode( ',',
			str_replace( ' ', '', trim( $protected_gutenberg_custom_void_blocks ) ) ) );

		$protected_gutenberg_blocks_comprehensive_list_a = array_merge( $protected_gutenberg_blocks_a,
			$protected_gutenberg_custom_blocks_a, $protected_gutenberg_custom_void_blocks_a );

		if ( is_array( $protected_gutenberg_blocks_comprehensive_list_a ) ) {

			foreach ( $protected_gutenberg_blocks_comprehensive_list_a as $key => $block ) {

				//Non-Void Blocks
				if ( $block === 'paragraph' or
				     $block === 'image' or
				     $block === 'heading' or
				     $block === 'gallery' or
				     $block === 'list' or
				     $block === 'quote' or
				     $block === 'audio' or
				     $block === 'cover-image' or
				     $block === 'subhead' or
				     $block === 'video' or
				     $block === 'code' or
				     $block === 'preformatted' or
				     $block === 'pullquote' or
				     $block === 'table' or
				     $block === 'verse' or
				     $block === 'button' or
				     $block === 'columns' or
				     $block === 'more' or
				     $block === 'nextpage' or
				     $block === 'separator' or
				     $block === 'spacer' or
				     $block === 'text-columns' or
				     $block === 'shortcode' or
				     $block === 'embed' or
				     $block === 'core-embed/twitter' or
				     $block === 'core-embed/youtube' or
				     $block === 'core-embed/facebook' or
				     $block === 'core-embed/instagram' or
				     $block === 'core-embed/wordpress' or
				     $block === 'core-embed/soundcloud' or
				     $block === 'core-embed/spotify' or
				     $block === 'core-embed/flickr' or
				     $block === 'core-embed/vimeo' or
				     $block === 'core-embed/animoto' or
				     $block === 'core-embed/cloudup' or
				     $block === 'core-embed/collegehumor' or
				     $block === 'core-embed/dailymotion' or
				     $block === 'core-embed/funnyordie' or
				     $block === 'core-embed/hulu' or
				     $block === 'core-embed/imgur' or
				     $block === 'core-embed/issuu' or
				     $block === 'core-embed/kickstarter' or
				     $block === 'core-embed/meetup-com' or
				     $block === 'core-embed/mixcloud' or
				     $block === 'core-embed/photobucket' or
				     $block === 'core-embed/polldaddy' or
				     $block === 'core-embed/reddit' or
				     $block === 'core-embed/reverbnation' or
				     $block === 'core-embed/screencast' or
				     $block === 'core-embed/scribd' or
				     $block === 'core-embed/slideshare' or
				     $block === 'core-embed/smugmug' or
				     $block === 'core-embed/speaker' or
				     $block === 'core-embed/ted' or
				     $block === 'core-embed/tumblr' or
				     $block === 'core-embed/videopress' or
				     $block === 'core-embed/wordpress-tv' or
				     in_array( $block, $protected_gutenberg_custom_blocks_a )
				) {

					//escape regex characters and the '/' regex delimiter
					$block = preg_quote( $block, '/' );

					//Non-Void Blocks Regex
					$content = preg_replace_callback(
						'/
                    <!--\s+(wp:' . $block . ').*?-->        #1 Gutenberg Block Start
                    .*?                                     #2 Gutenberg Content
                    <!--\s+\/\1\s+-->                       #3 Gutenberg Block End
                    /ixs',
						array( $this, 'apply_single_protected_block' ),
						$content
					);

					//Void Blocks
				} elseif ( $block === 'html' or
				           $block === 'categories' or
				           $block === 'latest-posts' or
				           in_array( $block, $protected_gutenberg_custom_void_blocks_a )
				) {

					//escape regex characters and the '/' regex delimiter
					$block = preg_quote( $block, '/' );

					//Void Blocks Regex
					$content = preg_replace_callback(
						'/
                    <!--\s+wp:' . $block . '.*?\/-->        #1 Void Block
                    /ix',
						array( $this, 'apply_single_protected_block' ),
						$content
					);

				}

			}

		}

		/*
		 * Protect the commented sections, enclosed between <!-- and -->
		 */
		$content = preg_replace_callback(
			'/
            <!--                                #1 Comment Start
            .*?                                 #2 Any character zero or more time with a lazy quantifier
            -->                                 #3 Comment End
            /ix',
			array( $this, 'apply_single_protected_block' ),
			$content
		);

		/*
		 * Get the list of the protected tags from the "Protected Tags" option
		 */
		$protected_tags   = get_option( $this->get( 'slug' ) . '_advanced_protected_tags' );
		$protected_tags_a = maybe_unserialize( $protected_tags );

		if ( is_array( $protected_tags_a ) ) {

			foreach ( $protected_tags_a as $key => $single_protected_tag ) {

				/*
				 * Validate the tag. HTML elements all have names that only use
				 * characters in the range 0–9, a–z, and A–Z.
				 */
				if ( preg_match( '/^[0-9a-zA-Z]+$/', $single_protected_tag ) === 1 ) {

					//Make the tag lowercase
					$single_protected_tag = strtolower( $single_protected_tag );

					//Apply different treatment if the tag is a void tag or a non-void tag.
					if ( $single_protected_tag == 'area' or
					     $single_protected_tag == 'base' or
					     $single_protected_tag == 'br' or
					     $single_protected_tag == 'col' or
					     $single_protected_tag == 'embed' or
					     $single_protected_tag == 'hr' or
					     $single_protected_tag == 'img' or
					     $single_protected_tag == 'input' or
					     $single_protected_tag == 'keygen' or
					     $single_protected_tag == 'link' or
					     $single_protected_tag == 'meta' or
					     $single_protected_tag == 'param' or
					     $single_protected_tag == 'source' or
					     $single_protected_tag == 'track' or
					     $single_protected_tag == 'wbr'
					) {

						//Apply the protected block on void tags
						$content = preg_replace_callback(
							'/                                  
                            <                                   #1 Begin the start-tag
                            (' . $single_protected_tag . ')     #2 The tag name (captured for the backreference)
                            (\s+[^>]*)?                         #3 Match the rest of the start-tag
                            >                                   #4 End the start-tag
                            /ix',
							array( $this, 'apply_single_protected_block' ),
							$content
						);

					} else {

						//Apply the protected block on non-void tags
						$content = preg_replace_callback(
							'/
                            <                                   #1 Begin the start-tag
                            (' . $single_protected_tag . ')     #2 The tag name (captured for the backreference)
                            (\s+[^>]*)?                         #3 Match the rest of the start-tag
                            >                                   #4 End the start-tag
                            .*?                                 #5 The element content (with the "s" modifier the dot matches also the new lines)
                            <\/\1\s*>                           #6 The end-tag with a backreference to the tag name (\1) and optional white-spaces before the closing >
                            /ixs',
							array( $this, 'apply_single_protected_block' ),
							$content
						);

					}

				}

			}

		}

		return $content;

	}

	/*
	 * This method is used inside all the preg_replace_callback located in the apply_protected_blocks() method.
	 *
	 * What it does is:
	 *
	 * 1 - Saves the match in the $pb_a array
	 * 2 - Returns the protected block with the related identifier ([pb]ID[/pb])
	 *
	 * @param $m An array with at index 0 the complete match and at index 1 the capture group.
	 * @return string
	 */
	private function apply_single_protected_block( $m ) {

		//save the match in the $pb_a array
		$this->pb_id ++;
		$this->pb_a[ $this->pb_id ] = $m[0];

		//Replaces the portion of post with the protected block and the index of the $pb_a array as the identifier.
		return '[pb]' . $this->pb_id . '[/pb]';

	}

	/*
	 * Replaces the block [pr]ID[/pr] with the related portion of post found in the $pb_a property.
	 *
	 * @param $content string The $content with applied the protected block.
	 * return string The unprotected content.
	 */
	private function remove_protected_blocks( $content ) {

		$content = preg_replace_callback(
			'/\[pb\](\d+)\[\/pb\]/',
			array( $this, 'preg_replace_callback_3' ),
			$content
		);

		return $content;

	}

	/*
	 * Callback of the preg_replace_callback() function.
	 *
	 * This callback is used to avoid an anonymous function as a parameter of the preg_replace_callback() function for
	 * PHP backward compatibility.
	 *
	 * Look for uses of preg_replace_callback_1 to find which preg_replace_callback() function is actually using this
	 * callback.
	 */
	public function preg_replace_callback_1( $m ) {

		/*
		 * Do not apply the replacement and return the matched string in the following cases:
		 *
		 * - If the max number of tooltips per post has been reached
		 */
		if ( $this->max_number_tooltips_per_post === $this->tooltip_id ) {

			return $m[1] . $m[2] . $m[3] . $m[4] . $m[5];

		} else {

			/*
			 * Increases the $tooltip_id property and stores the information related to this tooltip and match in the
			 * $tooltip_a property. These information will be later used to replace the temporary identifiers of the
			 * tooltips with the related data, and also in this method to verify the "Same URL Limit" option.
			 */
			$this->tooltip_id ++;
			$this->tooltip_a[ $this->tooltip_id ]['tooltip_id']     = $this->parsed_tooltip['tooltip_id'];
			$this->tooltip_a[ $this->tooltip_id ]['text']           = $m[3];
			$this->tooltip_a[ $this->tooltip_id ]['left_boundary']  = $m[2];
			$this->tooltip_a[ $this->tooltip_id ]['right_boundary'] = $m[4];
			$this->tooltip_a[ $this->tooltip_id ]['keyword_before'] = $m[1];
			$this->tooltip_a[ $this->tooltip_id ]['keyword_after']  = $m[5];

			//Replaces the match with the temporary identifier of the tooltip
			return '[al]' . $this->tooltip_id . '[/al]';

		}

	}

	/*
	 * Callback of the preg_replace_callback() function
	 *
	 * This callback is used to avoid an anonymous function as a parameter of the preg_replace_callback() function for
	 * PHP backward compatibility.
	 *
	 * Look for uses of preg_replace_callback_2 to find which preg_replace_callback() function is actually using this
	 * callback.
	 */
	public function preg_replace_callback_2( $m ) {

		/*
		 * Find the related text of the link from the $this->tooltip_a multidimensional array by using the match as
		 * the index.
		 */
		$link_text = $this->tooltip_a[ $m[1] ]['text'];

		//Get the left and right boundaries
		$left_boundary  = $this->tooltip_a[ $m[1] ]['left_boundary'];
		$right_boundary = $this->tooltip_a[ $m[1] ]['right_boundary'];


		//Get the keyword_before and keyword_after
		$keyword_before = $this->tooltip_a[ $m[1] ]['keyword_before'];
		$keyword_after  = $this->tooltip_a[ $m[1] ]['keyword_after'];

		//Get the tooltip_id
		$tooltip_id = $this->tooltip_a[ $m[1] ]['tooltip_id'];

		//Return the actual link
		return $keyword_before . $left_boundary . '<span class="daextauttol-tooltip" data-tooltip="' . esc_attr( $this->tooltips_ca[ $tooltip_id ]['text'] ) . '">' . $link_text . '</span>' . $right_boundary . $keyword_after;

	}

	/*
	 * Callback of the preg_replace_callback() function.
	 *
	 * This callback is used to avoid an anonymous function as a parameter of the preg_replace_callback() function for
	 * PHP backward compatibility.
	 *
	 * Look for uses of preg_replace_callback_3 to find which preg_replace_callback() function is actually using this
	 * callback.
	 */
	public function preg_replace_callback_3( $m ) {

		/*
		 * The presence of nested protected blocks is verified. If a protected block is inside the content of a
		 * protected block the remove_protected_block() method is applied recursively until there are no protected
		 * blocks.
		 */
		$html           = $this->pb_a[ $m[1] ];
		$recursion_ends = false;

		do {

			/*
			 * If there are no protected blocks in content of the protected block end the recursion, otherwise apply
			 * remove_protected_block() again.
			 */
			if ( preg_match( '/\[pb\](\d+)\[\/pb\]/', $html ) == 0 ) {
				$recursion_ends = true;
			} else {
				$html = $this->remove_protected_blocks( $html );
			}

		} while ( $recursion_ends === false );

		return $html;

	}

	/*
	 * Returns true if there are exportable data or false if here are no exportable data.
	 */
	public function exportable_data_exists() {

		$exportable_data = false;
		global $wpdb;

		$table_name  = $wpdb->prefix . $this->get( 'slug' ) . "_tooltip";
		$total_items = $wpdb->get_var( "SELECT COUNT(*) FROM $table_name" );
		if ( $total_items > 0 ) {
			$exportable_data = true;
		}

		return $exportable_data;

	}

	/*
	 * Objects as a value are set to empty strings. This prevent to generate notices with the methods of the wpdb class.
	 *
	 * @param $data An array which includes objects that should be converted to a empty strings.
	 * @return string An array where the objects have been replaced with empty strings.
	 */
	public function replace_objects_with_empty_strings( $data ) {

		foreach ( $data as $key => $value ) {
			if ( gettype( $value ) === 'object' ) {
				$data[ $key ] = '';
			}
		}

		return $data;

	}

	/*
	 * Returns the maximum number of tooltips allowed per post by using the method explained below.
	 *
	 * If the "General Limit Mode" option is set to "Auto":
	 *
	 * The maximum number of tooltips per post is calculated based on the content length of this post divided for the
	 * value of the "General Limit (Characters per tooltip)" option.
	 *
	 * If the "General Limit Mode" option is set to "Manual":
	 *
	 * The maximum number of tooltips per post is equal to the value of "General Limit (Amount)".
	 *
	 * @param $post_id int The post ID for which the maximum number tooltips per post should be calculated.
	 * @return int The maximum number of tooltips allowed per post.
	 */
	private function get_max_number_tooltips_per_post( $post_id ) {

		if ( intval( get_option( $this->get( 'slug' ) . '_advanced_general_limit_mode' ), 10 ) === 0 ) {

			//Auto -----------------------------------------------------------------------------------------------------
			$post_obj               = get_post( $post_id );
			$post_length            = mb_strlen( $post_obj->post_content );
			$characters_per_tooltip = intval( get_option( $this->get( 'slug' ) . '_advanced_general_limit_characters_per_tooltip' ),
				10 );

			return intval( $post_length / $characters_per_tooltip );

		} else {

			//Manual ---------------------------------------------------------------------------------------------------
			return intval( get_option( $this->get( 'slug' ) . '_advanced_general_limit_amount' ), 10 );

		}

	}

	/*
	 * Returns True if the post has the categories required by the tooltip or if the tooltip doesn't require any
	 * specific category.
	 *
	 * @return Bool
	 */
	private function is_compliant_with_categories( $post_id, $tooltip ) {

		$tooltip_categories_a = maybe_unserialize( $tooltip['categories'] );
		$post_categories      = get_the_terms( $post_id, 'category' );
		$category_found       = false;

		//If no categories are specified return true
		if ( ! is_array( $tooltip_categories_a ) ) {
			return true;
		}

		/*
		 * Do not proceed with the application of the tooltip if in this post no categories included in
		 * $tooltip_categories_a are available.
		 */
		foreach ( $post_categories as $key => $post_single_category ) {
			if ( in_array( $post_single_category->term_id, $tooltip_categories_a ) ) {
				$category_found = true;
			}
		}

		if ( $category_found ) {
			return true;
		} else {
			return false;
		}

	}

	/*
	 * Returns True if the post has the tags required by the tooltip or if the tooltip doesn't require any specific
	 * tag.
	 *
	 * @return Bool
	 */
	private function is_compliant_with_tags( $post_id, $tooltip ) {

		$tooltip_tags_a = maybe_unserialize( $tooltip['tags'] );
		$post_tags      = get_the_terms( $post_id, 'post_tag' );
		$tag_found      = false;

		//If no tags are specified return true
		if ( ! is_array( $tooltip_tags_a ) ) {
			return true;
		}

		if ( $post_tags !== false ) {

			/*
			 * Do not proceed with the application of the tooltip if this post has at least one tag but no tags
			 * included in $tooltip_tags_a are available.
			 */
			foreach ( $post_tags as $key => $post_single_tag ) {
				if ( in_array( $post_single_tag->term_id, $tooltip_tags_a ) ) {
					$tag_found = true;
				}
			}
			if ( ! $tag_found ) {
				return false;
			}

		} else {

			//Do not proceed with the application of the tooltip if this post has no tags associated
			return false;

		}

		return true;

	}

	/*
	 * Remove the HTML comment ( comment enclosed between <!-- and --> )
	 *
	 * @param $content The HTML with the comments
	 * @return string The HTML without the comments
	 */
	public function remove_html_comments( $content ) {

		$content = preg_replace(
			'/
            <!--                                #1 Comment Start
            .*?                                 #2 Any character zero or more time with a lazy quantifier
            -->                                 #3 Comment End
            /ix',
			'',
			$content
		);

		return $content;

	}

	/*
	 * Remove the script tags
	 *
	 * @param $content The HTML with the script tags
	 * @return string The HTML without the script tags
	 */
	public function remove_script_tags( $content ) {

		$content = preg_replace(
			'/
            <                                   #1 Begin the start-tag
            script                              #2 The script tag name
            (\s+[^>]*)?                         #3 Match the rest of the start-tag
            >                                   #4 End the start-tag
            .*?                                 #5 The element content ( with the "s" modifier the dot matches also the new lines )
            <\/script\s*>                       #6 The script end-tag with optional white-spaces before the closing >
            /ixs',
			'',
			$content
		);

		return $content;

	}

	/*
	 * Get the number of records available in the "statistic" db table
	 *
	 * @return int The number of records in the "statistic" db table
	 */
	public function number_of_records_in_statistic() {

		global $wpdb;
		$table_name  = $wpdb->prefix . $this->get( 'slug' ) . "_statistic";
		$total_items = $wpdb->get_var( "SELECT COUNT(*) FROM $table_name" );

		return $total_items;

	}

	/*
	 * Applies a random order (based on the hash of the post_id and tooltip_id) to the tooltips that have the same
	 * priority. This ensures a better distribution of the tooltips.
	 *
	 * @param $tooltip Array
	 * @param $post_id Int
	 * @return Array
	 */
	public function apply_random_prioritization( $tooltips, $post_id ) {

		//Initialize variables
		$tooltips_rp1 = array();
		$tooltips_rp2 = array();

		//Move the tooltips array in the new $tooltips_rp1 array, which uses the priority value as its index
		foreach ( $tooltips as $key => $tooltip ) {

			$tooltips_rp1[ $tooltip['priority'] ][] = $tooltip;

		}

		/*
		 * Apply a random order (based on the hash of the post_id and tooltip_id) to the tooltips that have the same
		 * priority.
		 */
		foreach ( $tooltips_rp1 as $key => $tooltips_a ) {

			/*
			 * In each tooltip create the new "hash" field which include an hash value based on the post_id and on the
			 * tooltip_id.
			 */
			foreach ( $tooltips_a as $key2 => $tooltip ) {

				/*
				 * Create the hased value. Note that the "-" character is used to avoid situations where the same input
				 * is provided to the md5() function.
				 *
				 * Without the "-" character for example with:
				 *
				 * $post_id = 12 and $tooltip['tooltip_id'] = 34
				 *
				 * We provide the same input of:
				 *
				 * $post_id = 123 and $tooltip['tooltip_id'] = 4
				 *
				 * etc.
				 */
				$hash = hexdec( md5( $post_id . '-' . $tooltip['tooltip_id'] ) );

				/*
				 * Convert all the non-digits to the character "1", this makes the comparison performed in the usort
				 * callback possible.
				 */
				$tooltip['hash']     = preg_replace( '/\D/', '1', $hash, - 1, $replacement_done );
				$tooltips_a[ $key2 ] = $tooltip;

			}

			//Sort $tooltips_a based on the new value of the "hash" field
			usort( $tooltips_a, function ( $a, $b ) {

				return $b['hash'] - $a['hash'];

			} );

			$tooltips_rp1[ $key ] = $tooltips_a;

		}

		/*
		 * Move the tooltips in the new $tooltips_rp2 array, which is structured like the original array, where the
		 * value of the priority field is stored in the tooltip and it's not used as the index of the array that
		 * includes all the tooltips with the same priority.
		 */
		foreach ( $tooltips_rp1 as $key => $tooltips_a ) {

			for ( $t = 0; $t < ( count( $tooltips_a ) ); $t ++ ) {

				$tooltip        = $tooltips_a[ $t ];
				$tooltips_rp2[] = $tooltip;

			}

		}

		return $tooltips_rp2;

	}

	/*
	 * To avoid additional database requests for each tooltip in preg_replace_callback_2() save the data of the
	 * tooltip in an array that uses the "tooltip_id" as its index.
	 *
	 * @param $tooltips Array
	 * @return Array
	 */
	public function save_tooltips_in_custom_array( $tooltips ) {

		$tooltips_ca = array();

		foreach ( $tooltips as $key => $tooltip ) {

			$tooltips_ca[ $tooltip['tooltip_id'] ] = $tooltip;

		}

		return $tooltips_ca;

	}

	/*
	 * Given the tooltip ID the tooltip Object is returned.
	 *
	 * @param $tooltip_id Int
	 * @return Object
	 */
	public function get_tooltip_object( $tooltip_id ) {

		global $wpdb;
		$table_name  = $wpdb->prefix . $this->get( 'slug' ) . "_tooltip";
		$safe_sql    = $wpdb->prepare( "SELECT * FROM $table_name WHERE tooltip_id = %d ", $tooltip_id );
		$tooltip_obj = $wpdb->get_row( $safe_sql );

		return $tooltip_obj;

	}

	/*
	 * Get an array with the post types with UI except the attachment post type.
	 *
	 * @return Array
	 */
	public function get_post_types_with_ui() {

		//Get all the post types with UI
		$args               = array(
			'public'  => true,
			'show_ui' => true
		);
		$post_types_with_ui = get_post_types( $args );

		//Remove the attachment post type
		unset( $post_types_with_ui['attachment'] );

		//Replace the associative index with a numeric index
		$temp_array = array();
		foreach ( $post_types_with_ui as $key => $value ) {
			$temp_array[] = $value;
		}
		$post_types_with_ui = $temp_array;

		return $post_types_with_ui;

	}

	/*
	 * Returns true if the category with the specified $category_id exists.
	 *
	 * @param $category_id Int
	 * @return bool
	 */
	public function category_exists( $category_id ) {

		global $wpdb;

		$table_name  = $wpdb->prefix . $this->get( 'slug' ) . "_category";
		$safe_sql    = $wpdb->prepare( "SELECT COUNT(*) FROM $table_name WHERE category_id = %d", $category_id );
		$total_items = $wpdb->get_var( $safe_sql );

		if ( $total_items > 0 ) {
			return true;
		} else {
			return false;
		}

	}

	/*
	 * Returns true if one or more tooltips are using the specified category.
	 *
	 * @param $category_id Int
	 * @return bool
	 */
	public function category_is_used( $category_id ) {

		global $wpdb;

		$table_name  = $wpdb->prefix . $this->get( 'slug' ) . "_tooltip";
		$safe_sql    = $wpdb->prepare( "SELECT COUNT(*) FROM $table_name WHERE category_id = %d", $category_id );
		$total_items = $wpdb->get_var( $safe_sql );

		if ( $total_items > 0 ) {
			return true;
		} else {
			return false;
		}

	}

	/*
	 * Given the category ID the category name is returned.
	 *
	 * @param $category_id Int
	 * @return String
	 */
	public function get_category_name( $category_id ) {

		if ( intval( $category_id, 10 ) === 0 ) {
			return esc_html__( 'None', 'automatic-tooltips' );
		}

		global $wpdb;
		$table_name   = $wpdb->prefix . $this->get( 'slug' ) . "_category";
		$safe_sql     = $wpdb->prepare( "SELECT * FROM $table_name WHERE category_id = %d ", $category_id );
		$category_obj = $wpdb->get_row( $safe_sql );

		return $category_obj->name;

	}

	/*
	 * If $needle is present in the $haystack array echos 'selected="selected"'.
	 *
	 * @param $haystack Array
	 * @param $needle String
	 */
	public function selected_array( $array, $needle ) {

		if ( is_array( $array ) and in_array( $needle, $array ) ) {
			return 'selected';
		}

	}

	/*
	 * Set the PHP "Max Execution Time" and "Memory Limit" based on the values defined in the options.
	 */
	public function set_met_and_ml() {

		/*
		 * Set the custom "Max Execution Time Value" defined in the options if the 'Set Max Execution Time' option is
		 * set to "Yes".
		 */
		if ( intval( get_option( $this->get( 'slug' ) . '_analysis_set_max_execution_time' ), 10 ) === 1 ) {
			ini_set( 'max_execution_time',
				intval( get_option( $this->get( 'slug' ) . '_analysis_max_execution_time_value' ), 10 ) );
		}

		/*
		 * Set the custom "Memory Limit Value" (in megabytes) defined in the options if the 'Set Memory Limit' option is
		 * set to "Yes".
		 */
		if ( intval( get_option( $this->get( 'slug' ) . '_analysis_set_memory_limit' ), 10 ) === 1 ) {
			ini_set( 'memory_limit', intval( get_option( $this->get( 'slug' ) . "_analysis_memory_limit_value" ), 10 ) . 'M' );
		}

	}

}