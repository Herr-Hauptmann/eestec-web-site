<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Reference;
use DB;

class ReferenceSeeder extends Seeder
{
    public function run()
    {
        $references = [
            "Promocija na fakultetu",
            "Društvene mreže",
            "Mediji",
            "Web stranica",
            "Preporuka prijatelja",
            "Promotivni leci i plakati",
            "Ništa od navedenog"
        ];

        if(DB::table('references')->count() == 0){
            foreach($references as $reference){
                Reference::create([
                    'type'=>$reference
                ]);
            }
        }
        else
        {
            echo('Tabela reference je vec popunjena');
        }
    }
}
