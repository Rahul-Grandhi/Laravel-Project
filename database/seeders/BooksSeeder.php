<?php

namespace Database\Seeders;

//use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Books;

class BooksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for($i =1; $i<=10; $i++)
        {
            $existingbook = Books::find($i);

            if(!$existingbook)
            {
                Books::create(
                    [
                        'id'=> $i,
                        'name'=>'Book'. $i,
                    ]
                    );
            }
        }
    }
}
