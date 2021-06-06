<?php

namespace Inc\Base;


class LikeDislike
{

    public function register(){
		add_filter( 'the_content', array( $this , 'add_likes_dislikes' ) );
    }
    
    public function add_likes_dislikes( $content ){

        if( is_user_logged_in() ){

            global $wpdb;
            global $post;
            //var_dump($post->ID);
            $post_id = $post->ID;
            $table = $wpdb->prefix.TABLE_NAME;

            $likes = $wpdb->get_row( "SELECT COUNT(*) as likes FROM `{$table}` WHERE `post_id`={$post_id} AND `likes` !=0", ARRAY_A );
            $dislikes = $wpdb->get_row( "SELECT COUNT(*) as dislikes FROM `{$table}` WHERE `post_id`={$post_id} AND `dislikes` !=0", ARRAY_A );
            //var_dump($likes , $dislikes );
            $discription = "
                <ul id='like_dislike'>
                    <li><a data-val='likes' href='javascript:;'>Like</a><span>[".$likes['likes']."]</span></li>
                    <li><a data-val='dislikes' href='javascript:;'>Dislike</a><span>[".$dislikes['dislikes']."]</span></li>
                </ul>
            ";
            return $content.$discription;
        }
        return $content;
    }
}