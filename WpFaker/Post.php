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
     * Save an image attachement in the database and in the filesystem.
     * 
     * @param string $filename
     * @return int
     */
    public function saveImage($filename)
    {
        $wp_filetype = wp_check_filetype(basename($filename), null);
        $attachment = array(
            'post_mime_type' => $wp_filetype['type'],
            'post_title' => $filename,
            'post_content' => '',
            'post_status' => 'inherit',
            'post_author' => $this->user_id
        );
        
        $attachement_id = wp_insert_attachment($attachment, UPLOAD_DIR.'/'.$filename);
        
        $imagenew = get_post($attachement_id);
        $fullsizepath = get_attached_file($imagenew->ID);
        $attach_data = wp_generate_attachment_metadata($attachement_id, $fullsizepath);
        wp_update_attachment_metadata($attachement_id, $attach_data);
        
        return $attachement_id;
    }
    
    /**
     * Update Acf values.
     * 
     * @param array $values
     */
    public function saveAcf($values)
    {
        foreach($values as $k => $v) {
            update_field($k, $v, $this->post_id);
        }
    }
    
    /**
     * Create the use WpFakerUser
     * 
     * This is used to assign the generated contents and let the developer 
     * delete easily all the dummy content.
     */
    public function createUser()
    {
        $password = wp_generate_password(36, true); //Generate a strong password
        $this->user_id = wp_create_user('WpFakerUser', $password, 'WpFakerUser@WpFaker.Fake');
        
        $user = get_user_by('id', $this->user_id);
        $user->remove_role('subscriber');
        $user->add_role('administrator');
    }
    
    /**
     * Create the new post according to the Config in use.
     * 
     * @param object $Config
     */
    public function createPost($Config)
    {
        $this->post_id = wp_insert_post(array(
            'comment_status' => 'closed',
            'ping_status' => 'closed',
            'post_author' => $this->user_id,
            'post_name' => sanitize_title($Config->post_title),
            'post_title' => $Config->post_title,
            'post_content' => $Config->post_content,
            'post_status' => 'publish',
            'post_type' => $Config->post_type
    	));
    }
    
    /**
     * Assign the post to one term in each existing taxonomy
     * 
     * @param object $Config
     */
    public function saveTerms($Config)
    {
        $taxonomies = get_object_taxonomies($Config->post_type);
        if ($taxonomies) {
            foreach ($taxonomies as $taxonomy) {
                $terms = get_terms($taxonomy, 'hide_empty=0');
                if ($terms) {
                    wp_set_object_terms($this->post_id, $terms[rand(0,(count($terms)-1))]->slug, $taxonomy);
                }
            }
        }
    }
}