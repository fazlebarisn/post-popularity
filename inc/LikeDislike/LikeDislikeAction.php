<?php

namespace Inc\LikeDislike;


class LikeDislikeAction
{

	public function register(){
         add_action( 'wp_ajax_likes_dislikes_action', array( $this , 'likes_dislikes_action') );
         add_action( 'wp_ajax_nopriv_likes_dislikes_action',  array( $this , 'likes_dislikes_action') );
    }

    public function likes_dislikes_action(){

        if( isset( $_POST['action'] ) ): 

            global $wpdb;
            $state = $_POST['state'];
            $post_id = $_POST['post'];
            $table = $wpdb->prefix.TABLE_NAME;
            $user_id = get_current_user_id();

            $row = $wpdb->get_row( "SELECT * FROM `{$table}` WHERE `post_id`={$post_id} AND `user_id`={$user_id}", ARRAY_A );


            if( $row == null ){
                $wpdb->insert( $table, [
                    'user_id' => $user_id,
                    'post_id' => $post_id,
                    $state => 1,
                ]);
            }elseif( $row['user_id'] == $user_id && $row['state'] == 0 ){
                $wpdb->delete( $table, [
                    'user_id' => $user_id,
                    'post_id' => $post_id,
                ]);
                $wpdb->insert( $table, [
                    'user_id' => $user_id,
                    'post_id' => $post_id,
                    $state => 1,
                ]);
            }else{
                $wpdb->delete( $table, [
                    'user_id' => $user_id,
                    'post_id' => $post_id,
                ]);
            }

        endif;

        $likes = $wpdb->get_row( "SELECT COUNT(*) as likes FROM `{$table}` WHERE `post_id`={$post_id} AND `likes` !=0", ARRAY_A );
        $dislikes = $wpdb->get_row( "SELECT COUNT(*) as dislikes FROM `{$table}` WHERE `post_id`={$post_id} AND `dislikes` !=0", ARRAY_A );

        echo json_encode( array(
            'likes' => $likes['likes'],
            'dislikes' => $dislikes['dislikes']
        ));

        wp_die();
    }
    
}