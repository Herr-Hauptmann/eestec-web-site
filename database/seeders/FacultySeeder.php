<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Faculty;
use DB;

class FacultySeeder extends Seeder
{
    public function run()
    {
        $fakulteti = [
            "Akademija likovnih umjetnosti",
            "Akademija scenskih umjetnosti",
            "American University in BiH",
            "Arhitektonski fakultet",
            "Ekonomski fakultet",
            "Elektrotehnički fakultet",
            "Fakultet islamskih nauka",
            "Fakultet političkih nauka",
            "Fakultet sporta i tjelesnog odgoja",
            "Fakultet za kriminalistiku, kriminologiju i sigurnosne studije",
            "Fakultet za saobraćaj i komunikacije",
            "Fakultet za upravu",
            "Fakultet zdravstvenih studija",
            "Farmaceutski fakultet",
            "Filozofski fakultet",
            "Građevinski fakultet",
            "International Burch University",
            "International University of Sarajevo",
            "Katolički bogoslovni fakultet",
            "Mašinski fakultet",
            "Medicinski fakultet",
            "Muzička akademija",
            "Pedagoški fakultet",
            "Poljoprivredno-prehrambeni fakultet",
            "Pravni fakultet",
            "Prirodno-matematički fakultet",
            "Sarajevo School of Science and Technology",
            "Stomatološki fakultet",
            "Šumarski fakultet",
            "Veterinarski fakultet"
        ];

        if(DB::table('faculties')->count() == 0){
            foreach($fakulteti as $fakultet){
                Faculty::create([
                    'name'=>$fakultet
                ]);
            }
        }
        else
        {
            echo('Tabela fakulteti je vec popunjena');
        }
    }
}
