<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Team;
use DB;

class TeamSeeder extends Seeder
{
    public function run()
    {
        $teams = [
            "Tim za informacione tehnologije",
            "Tim za ljudske resurse i logistiku",
            "Tim za odnose s javnošću",
            "Dizajn tim",
            "Tim za odnose s kompanijama",
            "Grant tim"
        ];

        if(DB::table('teams')->count() == 0){
            foreach($teams as $team){
                Team::create([
                    'name'=>$team
                ]);
            }
        }
        
        else
        {
            echo('Tabela "team" je vec popunjena');
        }
    }
}