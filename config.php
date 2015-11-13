<?php
/**
 *  Edit your configuration here 
 *  you can already use $faker
 */
$faker = Faker\Factory::create('en_GB'); // You can change that value to suit your needs

define('POST_TYPE', 'post'); // What post type would you like to seed ?
define('POST_AUTHOR', 1); // What's the author id to use ?
define('POST_TITLE', $faker->name()); // What's the post title you're gonna use ?
define('POST_CONTENT', $faker->realText()); // What's the post title you're gonna use ?

/**
 *  Acf values can be listed here.
 *  
 *  The key is the name of the field.
 *  To use flex fields, use the field_key (you know, that field_5641e6b5d1167 kind of key)
 */
/*$acf_values = array(
    'lastname' => $faker->lastname(),
    'firstname' => $faker->lastname(),
    'company' => $faker->company()
);*/