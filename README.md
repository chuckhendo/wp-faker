# WP-Faker

WP-Faker is a small tool to generate WordPress content really quickly ! More than that, you can add Acf fields too !
It's based on François Zaninotto's [Faker PHP library](https://github.com/fzaninotto/Faker).

## Why?

I needed a small tool to seed my WordPress installations when developping new
themes for customers. Having to manually write into each fields of some posts
containing a lot of acf fields is such a pain...

That's why I did this tool which allows me to specify which post type I want to
populate and assign dummy values to each fields.

By the way, WP-Faker works without Acf too.

## Installation

Just clone the project at the root of your wordpress install and install Faker
with composer :
```
git clone https://github.com/alanpilloud/wp-faker.git
composer install
```
## Usage

All you have to do is editing the file config.php to suit your needs and browse
the wp-faker folder.