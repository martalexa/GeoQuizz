<?php

require __DIR__ .'/../vendor/autoload.php';
require __DIR__ .'/../src/includes/db.php';

use Illuminate\Database\Capsule\Manager as Capsule;
use App\Models\City;

class Migrator {
	
    /**
     * migrate the database schema
     */
    public function migrate() {
        

        /**
         * create table for cities
         */
        if (!Capsule::schema()->hasTable('city')) {
            Capsule::schema()->create('city', function($table)
            {
                $table->integer('id', true);
                $table->string('name');
                $table->string('lat');
                $table->string('lng');
                $table->integer('zoom_level');
            });
        }

        /**
         * create table for series
         */
        if (!Capsule::schema()->hasTable('serie')) {
            Capsule::schema()->create('serie', function($table)
            {

                $table->integer('id', true);
                $table->string('distance')->default('');
                $table->string('image')->default('');
                $table->string('name')->default('');
                $table->timestamp('updated_at')->default(Capsule::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
                $table->timestamp('created_at')->default(Capsule::raw('CURRENT_TIMESTAMP'));
                //FK
                $table->integer('city_id');

                $table->engine = 'InnoDB';

                //Foreign keys declaration
                $table->foreign('city_id')->references('id')->on('city')->onDelete('cascade');
                // We'll need to ensure that MySQL uses the InnoDB engine to
                // support the indexes, other engines aren't affected.
                $table->engine = 'InnoDB';
            });
        }

        /**
         * create table photos
         */
        if (!Capsule::schema()->hasTable('photo')) {
            Capsule::schema()->create('photo', function($table)
            {
                $table->integer('id', true);
                $table->string('url');
                $table->string('description');
                $table->string('lat');
                $table->string('lng');
                //FK
                $table->integer('serie_id');

                $table->engine = 'InnoDB';

                //Foreign keys declaration
                $table->foreign('serie_id')->references('id')->on('serie')->onDelete('cascade');
            });
        }
		
		/**
         * create table partie
         */
        if (!Capsule::schema()->hasTable('partie')) {
            Capsule::schema()->create('partie', function($table)
            {
                $table->integer('id', true);
                $table->string('token');
                $table->integer('nb_photos');
                $table->integer('state');
                $table->string('player_username');
                $table->integer('score');
                $table->integer('serie_id');

                $table->engine = 'InnoDB';

                //Foreign keys declaration
                $table->foreign('serie_id')->references('id')->on('serie')->onDelete('cascade');
            });
        }

        /**
         * create table palier
         */
        if (!Capsule::schema()->hasTable('palier')) {
            Capsule::schema()->create('palier', function($table)
            {
                $table->integer('id', true);
                $table->integer('coef');
                $table->integer('points');

                //FK
                $table->integer('serie_id');

                $table->engine = 'InnoDB';

                //Foreign keys declaration
                $table->foreign('serie_id')->references('id')->on('serie')->onDelete('cascade');
            });
        }

        /**
         * create table temps
         */
        if (!Capsule::schema()->hasTable('temps')) {
            Capsule::schema()->create('temps', function($table)
            {
                $table->integer('id', true);
                $table->integer('nb_seconds');
                $table->integer('coef');

                //FK
                $table->integer('serie_id');

                $table->engine = 'InnoDB';

                //Foreign keys declaration
                $table->foreign('serie_id')->references('id')->on('serie')->onDelete('cascade');
            });
        }
        /**
         * create table temps
         */
        if (!Capsule::schema()->hasTable('user')) {
            Capsule::schema()->create('user', function($table)
            {
                $table->integer('id', true);
                $table->string('username');
                $table->string('password');

                $table->engine = 'InnoDB';

            });
        }

    }
}

$cities = array();

$city = new City();
$city->lat = '48.6843900';
$city->lng = '6.1849600';
$city->name = 'Nancy';
$city->zoom_level = 13;
array_push($cities, $city);

$city = new City();
$city->lat = '48.856406';
$city->lng = '2.3521452';
$city->name = 'Paris';
$city->zoom_level = 13;
array_push($cities, $city);

$city = new City();
$city->lat = '40.7127753';
$city->lng = '-74.0059728';
$city->name = 'New York';
$city->zoom_level = 11;
array_push($cities, $city);

$city = new City();
$city->lat = '51.5073509';
$city->lng = '-0.12775829999998223';
$city->name = 'London';
$city->zoom_level = 11;
array_push($cities, $city);

$city = new City();
$city->lat = '52.52000659999999';
$city->lng = '13.404953999999975';
$city->name = 'Berlin';
$city->zoom_level = 11;
array_push($cities, $city);

$city = new City();
$city->lat = '55.755826';
$city->lng = '37.617299900000035';
$city->name = 'Moscou';
$city->zoom_level = 11;
array_push($cities, $city);

$city = new City();
$city->lat = '41.9027835';
$city->lng = '12.496365500000024';
$city->name = 'Rome';
$city->zoom_level = 11;
array_push($cities, $city);

$city = new City();
$city->lat = '39.90419989999999';
$city->lng = '116.40739630000007';
$city->name = 'Beijing';
$city->zoom_level = 11;
array_push($cities, $city);

//
foreach ($cities as $city) {
    $city->save();
}

$migrator = new Migrator();

$migrator->migrate();

header('Content-type: application/json');
echo json_encode(array('message' => 'Le schéma de la base de données a bien été créé'));