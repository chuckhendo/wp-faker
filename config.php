<?php
/**
 *  Edit your configuration here 
 *  you can already use $faker
 */
$faker = Faker\Factory::create('fr_CH'); // You can change that value to suit your needs

define('POST_TYPE','post'); // What post type would you like to seed ?
define('POST_AUTHOR',1); // What's the author id to use ?
define('POST_TITLE',$faker->name()); // What's the post title you're gonna use ?
define('POST_CONTENT',$faker->realText()); // What's the post title you're gonna use ?

/**
 *  Acf values can be listed here.
 *  
 *  The key is the name of the field.
 *  For the moment, repeaters and flex contents are not supported
 */
/*$values = array(
    'lastname' => $faker->lastname(),
    'firstname' => $faker->lastname(),
    'company' => $faker->company()
);*/