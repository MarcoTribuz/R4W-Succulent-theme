<?php

class SucculentsQodefLike {
	private static $instance;
	
	private function __construct() {
		add_action( 'wp_ajax_succulents_qodef_like', array( $this, 'ajax' ) );
		add_action( 'wp_ajax_nopriv_succulents_qodef_like', array( $this, 'ajax' ) );
	}
	
	public static function get_instance() {
		if ( null == self::$instance ) {
			self::$instance = new self;
		}
		
		return self::$instance;
	}
	
	function ajax() {
		
		$likes_id = isset( $_POST['likes_id'] ) && ! empty( $_POST['likes_id'] ) ? sanitize_text_field( $_POST['likes_id'] ) : '';
        $post_id  = ! empty( $likes_id ) ? substr( str_replace( 'qodef-like-', '', $likes_id ), 0, - 4 ) : '-1';

        check_ajax_referer( 'qodef_like_nonce_' . $post_id, 'like_nonce' );
		//update
		if ( !empty( $likes_id ) ) {
			$post_id = str_replace( 'qodef-like-', '', $likes_id );
			$post_id = substr( $post_id, 0, - 4 );
			$type    = isset( $_POST['type'] ) ? $_POST['type'] : '';
			
			echo wp_kses( $this->like_post( $post_id, 'update', $type ), array(
				'span' => array(
					'class'       => true,
					'aria-hidden' => true,
					'style'       => true,
					'id'          => true
				),
				'i'    => array(
					'class' => true,
					'style' => true,
					'id'    => true
				)
			) );
		} //get
		else {
			$post_id = str_replace( 'qodef-like-', '', $likes_id );
			$post_id = substr( $post_id, 0, - 4 );
			echo wp_kses( $this->like_post( $post_id, 'get' ), array(
				'span' => array(
					'class'       => true,
					'aria-hidden' => true,
					'style'       => true,
					'id'          => true
				),
				'i'    => array(
					'class' => true,
					'style' => true,
					'id'    => true
				)
			) );
		}
		
		exit;
	}
	
	public function like_post( $post_id, $action = 'get', $type = '' ) {
		if ( ! is_numeric( $post_id ) ) {
			return;
		}
		
		switch ( $action ) {
			
			case 'get':
				$like_count = get_post_meta( $post_id, '_qodef-like', true );
				
				if ( isset( $_COOKIE[ 'qodef-like_' . $post_id ] ) ) {
					$icon = '<i class="icon_heart" aria-hidden="true"></i>';
				} else {
					$icon = '<i class="icon_heart_alt" aria-hidden="true"></i>';
				}
				
				if ( ! $like_count ) {
					$like_count = 0;
					add_post_meta( $post_id, '_qodef-like', $like_count, true );
					$icon = '<i class="icon_heart_alt" aria-hidden="true"></i>';
				}
				
				$return_value = $icon . "<span>" . esc_attr( $like_count ) . "</span>";
				
				return $return_value;
				break;
			
			case 'update':
				$like_count = get_post_meta( $post_id, '_qodef-like', true );
				
				if ( isset( $_COOKIE[ 'qodef-like_' . $post_id ] ) ) {
					return $like_count;
				}
				
				$like_count ++;
				
				update_post_meta( $post_id, '_qodef-like', $like_count );
				setcookie( 'qodef-like_' . $post_id, $post_id, time() * 20, '/' );
				
				$return_value = "<i class='icon_heart' aria-hidden='true'></i><span>" . esc_attr( $like_count ) . "</span>";
				
				return $return_value;
				
				break;
			default:
				return '';
				break;
		}
	}
	
	public function add_like() {
		global $post;
		
		$output = $this->like_post( $post->ID );
		
		$class       = 'qodef-like';
		$rand_number = rand( 100, 999 );
		$title       = esc_html__( 'Like this', 'succulents' );
		
		if ( isset( $_COOKIE[ 'qodef-like_' . $post->ID ] ) ) {
			$class = 'qodef-like liked';
			$title = esc_html__( 'You already like this!', 'succulents' );
		}
		
		return '<a href="#" class="' . $class . '" id="qodef-like-' . $post->ID . '-' . $rand_number . '" title="' . $title . '" data-post-id="' . esc_attr( $post->ID ) . '">' . $output . wp_nonce_field( 'qodef_like_nonce_' . esc_attr( $post->ID ), 'qodef_like_nonce_' . esc_attr( $post->ID ), true, false ) . '</a>';
	}
}

if ( ! function_exists( 'succulents_qodef_create_like' ) ) {
	function succulents_qodef_create_like() {
		SucculentsQodefLike::get_instance();
	}
	
	add_action( 'after_setup_theme', 'succulents_qodef_create_like' );
}