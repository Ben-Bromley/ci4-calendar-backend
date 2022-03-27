<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class EventsTable extends Migration
{
    public function up()
    {
        // init forge
        $forge = \Config\Database::forge();
        // creates database if it doesn't already exist
        $forge->createDatabase('ci_calendar', true);

        // create a migration for a table of events
        $forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true
            ],
            'event_name' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'event_start' => [
                'type' => 'DATETIME',
            ],
            'event_end' => [
                'type' => 'DATETIME',
            ],
            'event_description' => [
                'type' => 'TEXT',
            ],

        ]);

        //create primary key id
        $forge->addPrimaryKey('id', true);

        $forge->createTable('events', true);
    }

    public function down()
    {
        // init forge
        $forge = \Config\Database::forge();
        // drop table if exists
        $forge->dropTable('events', true);
    }
}
