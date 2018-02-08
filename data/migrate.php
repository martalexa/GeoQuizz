<?php

require __DIR__ .'/../vendor/autoload.php';
require __DIR__ .'/../src/includes/db.php';

use Illuminate\Database\Capsule\Manager as Capsule;

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

$migrator = new Migrator();

$migrator->migrate();

header('Content-type: application/json');
echo json_encode(array('message' => 'Le schéma de la base de données a bien été créé'));