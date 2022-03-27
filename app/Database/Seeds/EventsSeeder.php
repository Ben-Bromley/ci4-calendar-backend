<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class EventsSeeder extends Seeder
{
    public function run()
    {
        // create events
        $data = [
            'event_name' => 'Amber\'s Birthday',
            'event_start' => '2020-03-27 14:27:00',
            'event_end' => '2020-03-27 14:27:00',
            'event_description' => 'This is the first event',
        ];
        // save event
        $this->db->table('events')->insert($data);
    }
}
