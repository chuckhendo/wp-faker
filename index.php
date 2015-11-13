<?php
require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/config.php';
require __DIR__. '/../wp-load.php';

Twig_Autoloader::register();
$loader = new Twig_Loader_Filesystem('templates');
$twig = new Twig_Environment($loader);

$faking_content_url = basename($_SERVER['PHP_SELF']);

if (filter_input(INPUT_GET, 'proceed') == 1) {
    /**
     *  Generating content !
     */
    $post_id = wp_insert_post(
    	array(
    		'comment_status' => 'closed',
    		'ping_status' => 'closed',
    		'post_author' => POST_AUTHOR,
    		'post_name' => sanitize_title(POST_TITLE),
    		'post_title' =>	POST_TITLE,
            'post_content' => POST_CONTENT,
    		'post_status' => 'publish',
    		'post_type' => POST_TYPE
    	)
    );
    
    if(isset($acf_values)) {
        foreach($acf_values as $k => $v) {
            update_field($k, $v, $post_id);
        }
    }
    
    $data['post'] = [
        'id' => $post_id,
        'url' => get_permalink($post_id),
        'title' => POST_TITLE,
    ];

    $data['footer'] = '<a href="'.$faking_content_url.'?proceed=1" class="btn btn-sm btn-primary">Great, one more time!</a> <small>or</small> <a href="'.$faking_content_url.'?proceed=0" class="btn btn-sm btn-secondary">what\'s my config again?</a>';
    $template = 'go.twig';
    
} else {
    /**
     *  Asking to confirm config
     */
    $data['config'] = [
        'Post type : '.POST_TYPE,
        'Post author id : '.POST_AUTHOR,
        'Post content : '.POST_CONTENT,
    ];
    
    if (isset($acf_values)) {
        $data['config'][] = 'Dummy Acf values example : <br><pre>'.print_r($acf_values,1).'</pre>';
    }
    
    $data['footer'] = '<a href="'.$faking_content_url.'?proceed=1" class="btn btn-sm btn-primary">OK, let\'s go!</a>';
    $template = 'ready.twig';
}

echo $twig->render($template,$data);
