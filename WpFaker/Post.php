<?php
//namespace \WpFaker\Post;

class Post
{
    /**
     *  Generated post id
     */
    public $post_id = null;
    
    /**
     *  WpFakerUser user id
     */
    public $user_id = null;
    
    /**
     *  save an image attachement in the database and in the filesystem
     */
    public function saveImage($filename)
    {
        $wp_filetype = wp_check_filetype(basename($filename), null);
        $attachment = array(
            'post_mime_type' => $wp_filetype['type'],
            'post_title' => $filename,
            'post_content' => '',
            'post_status' => 'inherit'
        );
        
        $attachement_id = wp_insert_attachment($attachment, UPLOAD_DIR.'/'.$filename);
        
        $imagenew = get_post($attachement_id);
        $fullsizepath = get_attached_file($imagenew->ID);
        $attach_data = wp_generate_attachment_metadata($attachement_id, $fullsizepath);
        wp_update_attachment_metadata($attachement_id, $attach_data);
        
        return $attachement_id;
    }
    
    public function saveAcf($values)
    {
        foreach($values as $k => $v) {
            update_field($k, $v, $this->post_id);
        }
    }
    
    public function createUser()
    {
        $password = wp_generate_password(36, true); //Generate a strong password
        $this->user_id = wp_create_user('WpFakerUser', $password, 'WpFakerUser@WpFaker.Fake');
        
        $user = get_user_by( 'id', $this->user_id );
        $user->remove_role( 'subscriber' );
        $user->add_role( 'administrator' );
    }
    
    public function createPost()
    {
        $this->post_id = wp_insert_post(array(
    		'comment_status' => 'closed',
    		'ping_status' => 'closed',
    		'post_author' => $this->user_id,
    		'post_name' => sanitize_title(POST_TITLE),
    		'post_title' =>	POST_TITLE,
            'post_content' => POST_CONTENT,
    		'post_status' => 'publish',
    		'post_type' => POST_TYPE
    	));
    }
}