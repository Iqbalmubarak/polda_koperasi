<?php

use Illuminate\Database\Seeder;

class BaseSeeder extends Seeder
{

public function run()
{
    $admins = [
        ['Muhammad Iqbal', 'Mubarak', 'admin01@gmail.com','admin','root'],
        ['Velia Andrini', 'Fahira', 'user01@gmail.com','user','root'],
        ['Difah Alferina', 'Puput', 'user02@gmail.com','user2','root'],
        ['Ines', 'Aja', 'user03@gmail.com','user3','root'],
        ['Luzya', 'Gitu lhoo', 'user04@gmail.com','user4','root'],
    ];

    DB::table('roles')->insert([
        [
            'id'=>'1',
            'slug' 		    => 'S-Admins',
            'name' 			  => 'Super Admin',
            'permissions' => '{"log-viewer::logs.dashboard":true,"log-viewer::logs.list":true,"log-viewer::logs.delete":true,"log-viewer::logs.show":true,"log-viewer::logs.download":true,"log-viewer::logs.filter":true,"log-viewer::logs.search":true,"password.request":true,"password.email":true,"password.reset":true,"home.dashboard":true,"home.all-data":true,"users.index":true,"users.create":true,"users.store":true,"users.show":true,"users.edit":true,"users.update":true,"users.destroy":true,"users.activate":true,"users.deactivate":true,"users.permissions":true,"users.simpan":true,"users.all-data":true,"roles.index":true,"roles.add":true,"roles.updt":true,"roles.destroy":true,"roles.permissions":true,"roles.simpan":true,"roles.all-data":true,"type.index":true,"type.add":true,"type.updt":true,"type.destroy":true,"type.all-data":true,"supplier.index":true,"supplier.add":true,"supplier.updt":true,"supplier.destroy":true,"supplier.all-data":true,"unit.index":true,"unit.add":true,"unit.updt":true,"unit.destroy":true,"unit.all-data":true,"brand.index":true,"brand.add":true,"brand.updt":true,"brand.destroy":true,"brand.all-data":true,"inreq.index":true,"inreq.create":true,"inreq.store":true,"inreq.show":true,"inreq.destroy":true,"inreq.acc":true,"inreq.acc_one":true,"inreq.reject_one":true,"inreq.reject":true,"inreq.all-data":true,"inreqde.add":true,"inreqde.updt":true,"inreqde.destroy":true,"item.index":true,"item.create":true,"item.store":true,"item.show":true,"item.updt":true,"item.destroy":true,"item.all-data":true,"inventorisDetail.add":true,"inventorisDetail.updt":true,"inventorisDetail.destroy":true,"inventorisKeluar.add":true,"inventorisKeluar.updt":true,"inventorisKeluar.destroy":true,"laporan.mingguan-filter":true,"laporan.mingguan":true,"laporan.keluar-filter":true,"laporan.keluar":true}',
        ],
        [
            'id'=>'2',
            'slug' 		    => 'Admin',
            'name' 			  => 'Admin',
            'permissions'  => '{"password.request":true,"password.email":true,"password.reset":true,"home.dashboard":true,"home.part-data":true,"users.index":true,"users.create":true,"users.store":true,"users.show":true,"users.edit":true,"users.update":true,"users.destroy":true,"users.activate":true,"users.deactivate":true,"users.part-data":true,"satker.index":true,"satker.add":true,"satker.updt":true,"satker.destroy":true,"satker.all-data":true,"barang.index":true,"barang.add":true,"barang.updt":true,"barang.destroy":true,"barang.all-data":true,"satbar.index":true,"satbar.add":true,"satbar.updt":true,"satbar.destroy":true,"satbar.all-data":true,"sumber.index":true,"sumber.add":true,"sumber.updt":true,"sumber.destroy":true,"sumber.all-data":true,"inreq.index":true,"inreq.show":true,"inreq.acc_one":true,"inreq.reject_one":true,"inreq.all-data":true,"inreqde.updt":true,"inventoris.index":true,"inventoris.create":true,"inventoris.store":true,"inventoris.show":true,"inventoris.updt":true,"inventoris.destroy":true,"inventoris.all-data":true,"inventorisDetail.add":true,"inventorisDetail.updt":true,"inventorisDetail.destroy":true,"laporan.mingguan-filter":true,"laporan.mingguan":true,"laporan.keluar-filter":true,"laporan.keluar":true}'
        ],
        [
            'id'=>'3',
            'slug' 		    => 'User',
            'name' 			  => 'User',
            'permissions' => '{"password.request":true,"password.email":true,"password.reset":true,"home.dashboard":true,"home.self-data":true,"orders.confirm":true,"orders.index":true,"satker.all-data":true,}',
        ],
    ]);

    DB::table('units')->insert([
        [
            'id'=>'1',
            'name' 			  => 'Sachet',
        ],
        [
            'id'=>'2',
            'name' 			  => 'Box',
        ],
        [
            'id'=>'3',
            'name' 			  => 'Pcs',
        ],
        [
            'id'=>'4',
            'name' 			  => 'Pak',
        ],
        [
            'id'=>'5',
            'name' 			  => 'Lusin',
        ],
        [
            'id'=>'6',
            'name' 			  => 'Bal',
        ],
        [
            'id'=>'7',
            'name' 			  => 'rim',
        ],
        [
            'id'=>'8',
            'name' 			  => 'Kodi',
        ],
        [
            'id'=>'9',
            'name' 			  => 'meter',
        ],
        [
            'id'=>'10',
            'name' 			  => 'kg',
        ],

    ]);


    DB::table('brands')->insert([
        [
            'id'=>'1',
            'name' 			  => 'GIV',
        ],
        [
            'id'=>'2',
            'name' 			  => 'Pentene',
        ],
        [
            'id'=>'3',
            'name' 			  => 'Citra',
        ],
        [
            'id'=>'4',
            'name' 			  => 'Pilot',
        ],
        [
            'id'=>'5',
            'name' 			  => 'Bintang Obor',
        ],
        [
            'id'=>'6',
            'name' 			  => 'Kiss',
        ],
        [
            'id'=>'7',
            'name' 			  => 'Pepsodent',
        ],
        [
            'id'=>'8',
            'name' 			  => 'Sari Roti',
        ],
        [
            'id'=>'9',
            'name' 			  => 'Sajuak',
        ],
        [
            'id'=>'10',
            'name' 			  => 'Aqua',
        ],
        [
            'id'=>'11',
            'name' 			  => 'Sunsilk',
        ],
        [
            'id'=>'12',
            'name' 			  => 'Bimoli',
        ],
        [
            'id'=>'13',
            'name' 			  => 'Segitiga Biru',
        ],
        [
            'id'=>'14',
            'name' 			  => 'Paper One',
        ],
        [
            'id'=>'15',
            'name' 			  => 'Sari Wangi',
        ],
        [
            'id'=>'16',
            'name' 			  => 'Blue Band',
        ],
        [
            'id'=>'17',
            'name' 			  => 'Prochiz',
        ],
        [
            'id'=>'18',
            'name' 			  => 'Swallow',
        ],
        [
            'id'=>'19',
            'name' 			  => 'Indomie',
        ],
        [
            'id'=>'20',
            'name' 			  => 'Rose Brand',
        ],
        [
            'id'=>'21',
            'name' 			  => 'Royco',
        ],
        [
            'id'=>'22',
            'name' 			  => 'Bango',
        ],
        [
            'id'=>'23',
            'name' 			  => 'Sunlight',
        ],
        [
            'id'=>'24',
            'name' 			  => 'Daia',
        ],

    ]);



    DB::table('type')->insert([
        [
            'id'=>'1',
            'name' 			  => 'Makanan',
        ],
        [
            'id'=>'2',
            'name' 			  => 'Minuman',
        ],
        [
            'id'=>'3',
            'name' 			  => 'ATK',
        ],
        [
            'id'=>'4',
            'name' 			  => 'kebutuhan sehari-hari',
        ],
        [
            'id'=>'5',
            'name' 			  => 'Bahan Pakaian Kantor',
        ],
        
    ]);



    DB::table('suppliers')->insert([
        [
            'id'=>'1',
            'name' 			  => 'PT. Tanamo',
            'address'         => 'Jl. Moh.Hatta',
        ],
        [
            'id'=>'2',
            'name' 			  => 'PT. XYZ',
            'address'         => 'Jl. Perintis Kemerdekaan',      
        ],
        [
            'id'=>'3',
            'name' 			  => 'CV. Percetakan',
            'address'         => 'Jl. Ahmad Yani',
        ],
        
    ]);




    DB::table('items')->insert([
        [
            'id'=>'1',
            'name' 			  => 'Sunsilk Hijab',
            'note'            => 'Conditioner',
            'price'           => '500',
            'type_id'         => '4',
            'brand_id'        => '11',
            'unit_id'         => '1',
        ],
        [
            'id'=>'2',
            'name' 			  => 'Giv white',
            'note'            => 'Sabun kecantikan',
            'price'           => '1000',  
            'type_id'         => '4',
            'brand_id'        => '1',
            'unit_id'         => '3',   
        ],
        [
            'id'=>'3',
            'name' 			  => 'Citra Body Wash',
            'note'            => 'Sabun cair',
            'price'           => '800',
            'type_id'         => '4',
            'brand_id'        => '3',
            'unit_id'         => '3', 
        ],
        [
            'id'=>'4',
            'name' 			  => 'Pantene Shampoo Anti Ketombe',
            'note'            => 'Shampoo',
            'price'           => '500',
            'type_id'         => '4',
            'brand_id'        => '2',
            'unit_id'         => '3', 
        ],
        [
            'id'=>'5',
            'name' 			  => 'Bimoli',
            'note'            => 'Minyak goreng',
            'price'           => '1500',
            'type_id'         => '4',
            'brand_id'        => '12',
            'unit_id'         => '10', 
        ],
        [
            'id'=>'6',
            'name' 			  => 'Segitiga Biru',
            'note'            => 'Tepung terigu',
            'price'           => '1000',
            'type_id'         => '4',
            'brand_id'        => '13',
            'unit_id'         => '10',
        ],
        [
            'id'=>'7',
            'name' 			  => 'Paper One',
            'note'            => 'Kertas HVS A4',
            'price'           => '700',
            'type_id'         => '3',
            'brand_id'        => '14',
            'unit_id'         => '7',
        ],
        [
            'id'=>'8',
            'name' 			  => 'Sari Wangi',
            'note'            => 'Teh',
            'price'           => '750',
            'type_id'         => '4',
            'brand_id'        => '15',
            'unit_id'         => '3',
        ],
        [
            'id'=>'9',
            'name' 			  => 'BlueBand',
            'note'            => 'Margarin',
            'price'           => '1500',
            'type_id'         => '4',
            'brand_id'        => '16',
            'unit_id'         => '3',
        ],
        [
            'id'=>'10',
            'name' 			  => 'Prochiz',
            'note'            => 'Keju',
            'price'           => '1000',
            'type_id'         => '4',
            'brand_id'        => '17',
            'unit_id'         => '3',
        ],
        [
            'id'=>'11',
            'name' 			  => 'Pilot Ballpoint Hitam',
            'note'            => 'Pena',
            'price'           => '500',
            'type_id'         => '3',
            'brand_id'        => '4',
            'unit_id'         => '2',
        ],
        [
            'id'=>'12',
            'name' 			  => 'Bintang Obor',
            'note'            => 'Buku',
            'price'           => '1000', 
            'type_id'         => '3',
            'brand_id'        => '5',
            'unit_id'         => '8',    
        ],
        [
            'id'=>'13',
            'name' 			  => 'Swallow Globe Agar-agar Putih',
            'note'            => 'Agar-agar',
            'price'           => '1000',
            'type_id'         => '4',
            'brand_id'        => '18',
            'unit_id'         => '2',
        ],
        [
            'id'=>'14',
            'name' 			  => 'Indomie goreng rasa rendang',
            'note'            => 'Mie instan',
            'price'           => '700',
            'type_id'         => '4',
            'brand_id'        => '19',
            'unit_id'         => '3',
        ],
        [
            'id'=>'15',
            'name' 			  => 'Indomie kuah rasa kari ayam',
            'note'            => 'Mie instan',
            'price'           => '1000',
            'type_id'         => '4',
            'brand_id'        => '19',
            'unit_id'         => '3',
        ],
        [
            'id'=>'16',
            'name' 			  => 'Rose Brand bihun instan soto ayam',
            'note'            => 'Bihun instan',
            'price'           => '1500',
            'type_id'         => '4',
            'brand_id'        => '20',
            'unit_id'         => '3',
        ],
        [
            'id'=>'17',
            'name' 			  => 'Royco rasa ayam',
            'note'            => 'Bumbu kaldu',
            'price'           => '500',
            'type_id'         => '4',
            'brand_id'        => '21',
            'unit_id'         => '1',
        ],
        [
            'id'=>'18',
            'name' 			  => 'Bango botol 133 ml',
            'note'            => 'Kecap manis',
            'price'           => '1000',
            'type_id'         => '4',
            'brand_id'        => '22',
            'unit_id'         => '3',
        ],
        [
            'id'=>'19',
            'name' 			  => 'Sunlight Sabun Cuci Piring Jeruk Nipis',
            'note'            => 'Sabun cuci piring',
            'price'           => '700',
            'type_id'         => '4',
            'brand_id'        => '23',
            'unit_id'         => '3',
        ],
        [
            'id'=>'20',
            'name' 			  => 'Daia Detergen Bubuk Biru',
            'note'            => 'Sabun cuci kain',
            'price'           => '1000',
            'type_id'         => '4',
            'brand_id'        => '24',
            'unit_id'         => '3',
        ],
    ]);



    foreach ($admins as $admin) {
        DB::table('users')->insert([
            [
                'first_name'		 => $admin[0],
                'last_name'     => $admin[1],
                'email' 		     => $admin[2],
                'username'      => $admin[3],
                'password' 		 => bcrypt($admin[4]),
                'permissions'   => '{"password.request":true,"password.email":true,"password.reset":true,"home.dashboard":true,"users.index":true,"users.create":true,"users.store":true,"users.show":true,"users.edit":true,"users.update":true,"users.destroy":true,"users.activate":true,"users.deactivate":true,"users.permissions":true,"users.simpan":true,"roles.index":true,"roles.create":true,"roles.store":true,"roles.show":true,"roles.edit":true,"roles.update":true,"roles.destroy":true,"roles.permissions":true,"roles.simpan":true,"roles.all-data":true}',
            ]
        ]);

        $id = DB::getPdo()->lastInsertId();

        DB::table('activations')->insert([
            [
                'user_id' 		=> $id,
                'code' 			  => str_random(40),
                'completed' 	=> '1',
            ]
        ]);

        DB::table('role_users')->insert([
            [
                'user_id' 		=> $id,
                'role_id' 			  => '1'
            ]
        ]);
    }

}
}
