<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DocumentDirectoryTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datas = [
            [
                'title' => 'Other',
                'created_at' => Carbon::now()
            ]
        ];
        foreach($datas as $data){
            $type = DB::table('document_directories_type')->where('title',$data['title'])->first();
            if(empty($type)){
                DB::table('document_directories_type')->insert($data);
            }
        }
    }
}
