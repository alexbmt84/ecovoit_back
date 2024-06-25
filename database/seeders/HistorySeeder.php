<?php

namespace Database\Seeders;

use App\Models\History;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HistorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $actions = [
            'Checked','Edited','Deleted'
        ];

        for($i=0; $i < 200; $i++){

            $randomAction = rand(0, count($actions)-1);

            History::create(
                [
                    'action' => $actions[$randomAction],
                    'admin_id' => rand(1, 2),
                    'student_id' => rand(23, 622),

                ]
            );
                
        }   
      
    }
}
