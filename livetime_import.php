<?php

namespace Livetime;

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/packages/includes/includes.php';

define('DB_NAME', '215520-livetime-wp');

/** MySQL-databasens användarnamn */
define('DB_USER', '215520_xu29048');

/** MySQL-databasens lösenord */
define('DB_PASSWORD', 'Bon#4ever');

/** MySQL-server */
define('DB_HOST', 'livetime-wp-215520.mysql.binero.se');

/** Teckenkodning för tabellerna i databasen. */
define('DB_CHARSET', 'utf8mb4');

/** Kollationeringstyp för databasen. Ändra inte om du är osäker. */
define('DB_COLLATE', 'utf8mb4_unicode_ci');

Includes\Util::init_database();

$capsule = Includes\Util::get_capsule();

$customers = json_decode( file_get_contents( __DIR__ . '/exports/export_customers.txt' ) );
$contacts = json_decode( file_get_contents( __DIR__ . '/exports/export_contacts.txt' ) );
$projects = json_decode( file_get_contents( __DIR__ . '/exports/export_projects.txt' ) );
$products = json_decode( file_get_contents( __DIR__ . '/exports/export_products.txt' ) );
$quotes = json_decode( file_get_contents( __DIR__ . '/exports/export_quotes.txt' ) );
$themes = json_decode( file_get_contents( __DIR__ . '/exports/export_themes.txt' ) );

// CUSTOMERS
$customer_query = array();

foreach ( $customers as $customer ) {
    $customer_query[] = array(
        'id' => $customer->id,
        'name' => $customer->name,
        'org_nr' => $customer->org_nr,
        'county' => $customer->county,
        'town' => $customer->town,
        'address' => $customer->address,
        'postal' => $customer->postal,
        'created_at' => $customer->created_at,
        'updated_at' => $customer->updated_at
    );
}

// CONTACTS
$contact_query = array();

foreach ( $contacts as $contact ) {
    $contact_query[] = array(
        'id' => $contact->id,
        'customer_id' => $contact->customer_id,
        'name' => $contact->name,
        'surname' => $contact->surname,
        'email' => $contact->email,
        'phone' => $contact->phone,
        'created_at' => $contact->created_at,
        'updated_at' => $contact->updated_at
    );
}

// THEMES
/*$theme_query = array();

foreach ( $themes as $theme ) {
    $theme_query[] = array(
        'id' => $theme->id,
        'url' => $theme->url,
        'screenshot' => $theme->screenshot,
        'classification' => $theme->classification,
        'envato_url' => $theme->envato_url,
        'envato_image_url' => $theme->envato_image_url,
        'created_at' => $theme->created_at,
        'updated_at' => $theme->updated_at
    );
}*/

// PROJECTS
$project_query = array();

foreach ( $projects as $project ) {
    $project_query[] = array(
        'id' => $project->id,
        'customer_id' => $project->customer_id,
        'handler_id' => $project->handler_id,
        'theme_id' => $project->theme_id,
        'status_id' => 1,
        'hash' => $project->hash,
        'percentage' => $project->percentage,
        'confirmed' => $project->confirmed,
        'created_at' => $project->created_at,
        'updated_at' => $project->updated_at
    );
}

// PRODUCTS
$product_query = array();

foreach ( $products as $product ) {
    $product_query[] = array(
        'id' => $product->id,
        'project_id' => $product->project_id,
        'name' => $product->name,
        'description' => $product->description,
        'price' => $product->price,
        'qty' => $product->qty,
        'created_at' => $product->created_at,
        'updated_at' => $product->updated_at
    );
}

// QUOTES
$quote_query = array();

foreach ( $quotes as $quote ) {
    $quote_query[] = array(
        'id' => $quote->id,
        'project_id' => $quote->project_id,
        'url' => $quote->url,
        'created_at' => $quote->created_at,
        'updated_at' => $quote->updated_at
    );
}

$capsule->table('customers')->insert( $customer_query );
$capsule->table('customer_contacts')->insert( $contact_query );
//$capsule->table('themes')->insert( $theme_query );
$capsule->table('projects')->insert( $project_query );
$capsule->table('project_products')->insert( $product_query );
$capsule->table('quotes')->insert( $quote_query );