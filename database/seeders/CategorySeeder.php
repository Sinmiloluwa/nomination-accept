<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $table = 'category';
        $file = public_path("/$table".".csv");

        function import_CSV($filename, $delimiter = ','){
            if(!file_exists($filename) || !is_readable($filename))
              return false;
            $header = null;
            $data = array();
            if (($handle = fopen($filename, 'r')) !== false){
                while (($row = fgetcsv($handle, 1000, $delimiter)) !== false){
                  if(!$header)
                    $header = $row;
                  else
                    $data[] = array_combine($header, $row);
                  }
                  fclose($handle);
                }
            return $data;
    }

    $records = import_CSV($file);

// add each record to the posts table in DB       
foreach ($records as $key => $record) {
  Category::create([
    'name' => $record['name'],
  ]);
}
    }
}
