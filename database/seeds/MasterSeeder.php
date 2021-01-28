<?php

use Illuminate\Database\Seeder;

class MasterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('barang')->insert([
            [
                'id'=>'1',
                'nama_barang'=> 'Buku Tulis',
             ],
             [
                 'id'=>'2',
                 'nama_barang'=> 'Kertas HVS',
              ],
              [
                 'id'=>'3',
                 'nama_barang'=> 'Pena Pilot',
              ]
            
         ]);
    }
}
