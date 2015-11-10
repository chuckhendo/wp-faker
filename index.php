<?php
require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/config.php';
require __DIR__. '/../wp-load.php';

$faking_content_url = basename($_SERVER['PHP_SELF']);

if($_GET['proceed'] == 1) {
    /**
     *  Generating content !
     */
    $post_id = wp_insert_post(
    	array(
    		'comment_status'	=>	'closed',
    		'ping_status'		=>	'closed',
    		'post_author'		=>	POST_AUTHOR,
    		'post_name'		=>	sanitize_title(POST_TITLE),
    		'post_title'		=>	POST_TITLE,
            'post_content'		=>	POST_CONTENT,
    		'post_status'		=>	'publish',
    		'post_type'		=>	POST_TYPE
    	)
    );
    
    if(isset($values)) {
        foreach($values as $k => $v) {
            update_field($k, $v, $post_id);
        }
    }
    
    $content .= '
    <h3>Content created with success!</h3>
    <p>The content <a href="'.get_permalink($post_id).'" target="_blank">"'.POST_TITLE.'"</a> with id '.$post_id.' has been created!</p>';
    
    $button = '<a href="'.$faking_content_url.'?proceed=1" class="btn btn-sm btn-primary">Great, one more time!</a> <small>or</small> <a href="'.$faking_content_url.'?proceed=0" class="btn btn-sm btn-secondary">what\'s my config again?</a>';
    
} else {




    /**
     *  Asking to confirm config
     */    
    $content = '
    <h3>Ready to generate content with this config?</h3>
    <ul>
        <li>Post type : '.POST_TYPE.'</li>
        <li>Post author id : '.POST_AUTHOR.'</li>
        <li>Post content : '.POST_CONTENT.'</li>
        <li>Dummy Acf values example : <br/><pre>'.print_r($values,1).'</pre></li>
    </ul>';
    
    $button = '<a href="'.$faking_content_url.'?proceed=1" class="btn btn-sm btn-primary">OK, let\'s go!</a>';
    
}




/**
 *  Display it all in a nice template =)
 */
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Faking content</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha/css/bootstrap.min.css">
    </head>
    <body>
        <div class="container m-y-lg">
            <div class="col-sm-8 col-sm-offset-2">
                <div class="card">
                    <div class="card-block">
                        <?= $content ?>
                    </div>
                    <div class="card-footer">
                        <?= $button ?>
                    </div>
                </div>
                <p><small><a href="https://github.com/fzaninotto/Faker/blob/master/readme.md" target="_blank"><?= __('Faker docs','fakingContent') ?></a></small></p>
            </div>
        </div>
    </body>
</html>