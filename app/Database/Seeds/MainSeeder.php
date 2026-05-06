<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MainSeeder extends Seeder
{
    public function run()
    {
        $db = \Config\Database::connect();
        $db->query('SET FOREIGN_KEY_CHECKS=0;');
        
        $db->table('reviews')->truncate();
        $db->table('favorites')->truncate();
        $db->table('culinary_photos')->truncate();
        $db->table('culinary_locations')->truncate();
        $db->table('categories')->truncate();
        $db->table('users')->truncate();
        
        // Users
        $userModel = new \App\Models\UserModel();
        $userModel->insertBatch([
            [
                'username' => 'admin',
                'password' => password_hash('admin123', PASSWORD_DEFAULT),
                'role'     => 'admin',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'username' => 'budi_santoso',
                'password' => password_hash('user123', PASSWORD_DEFAULT),
                'role'     => 'user',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'username' => 'siti_aminah',
                'password' => password_hash('user123', PASSWORD_DEFAULT),
                'role'     => 'user',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ]);

        // Categories
        $db->table('categories')->insertBatch([
            ['id' => 1, 'name' => 'Makanan Berat', 'description' => 'Menu utama yang mengenyangkan seperti nasi goreng, penyetan, dan bakso.'],
            ['id' => 2, 'name' => 'Jajanan & Snack', 'description' => 'Camilan ringan dan jajanan tradisional.'],
            ['id' => 3, 'name' => 'Minuman Segar', 'description' => 'Berbagai pilihan minuman dingin, kopi, dan jus segar.'],
        ]);

        $locData = [
            // Makanan Berat (Category 1)
            [
                'category_id' => 1, 'name' => 'Nasi Goreng Babat Pak Karmin Mberok', 
                'address' => 'Jl. Pemuda No.2, Dadapsari, Semarang Utara', 
                'latitude' => '-6.9712', 'longitude' => '110.4228',
                'photo' => 'https://images.unsplash.com/photo-1603133872878-684f208fb84b?auto=format&fit=crop&w=800&q=80', 
                'rating_avg' => 4.8, 'status' => 'approved',
                'description' => 'Legenda nasi goreng babat di Semarang. Babatnya empuk dengan bumbu rempah yang meresap sempurna, dimasak dengan cara tradisional menggunakan arang.',
                'reviews' => [
                    ['user_id' => 2, 'rating' => 5, 'comment' => 'Babatnya juara! Empuk banget dan nggak bau. Porsinya pas, suasana pinggir kali mberok yang ikonik.'],
                    ['user_id' => 3, 'rating' => 4, 'comment' => 'Rasa konsisten dari dulu. Antrinya lumayan kalau jam makan malam, tapi worth it banget!']
                ]
            ],
            [
                'category_id' => 1, 'name' => 'Bakso Doa Ibu (Sompok)', 
                'address' => 'Jl. Sompok Baru No.57, Semarang', 
                'latitude' => '-7.0012', 'longitude' => '110.4350',
                'photo' => 'https://images.unsplash.com/photo-1593560708920-61dd98c46a4e?auto=format&fit=crop&w=800&q=80', 
                'rating_avg' => 4.7, 'status' => 'approved',
                'description' => 'Bakso legendaris dengan kuah kaldu sapi yang sangat gurih. Tekstur baksonya berdaging dan kenyal, disajikan dengan jeroan sapi yang melimpah.',
                'reviews' => [
                    ['user_id' => 2, 'rating' => 5, 'comment' => 'Kuahnya kaldu banget! Baksonya kerasa dagingnya, bukan cuma tepung. Jeroannya juga bersih.'],
                    ['user_id' => 3, 'rating' => 4, 'comment' => 'Tempatnya selalu ramai. Pelayanan cepat meski padat. Salah satu bakso terbaik di Semarang.']
                ]
            ],
            // Jajanan (Category 2)
            [
                'category_id' => 2, 'name' => 'Lumpia Gang Lombok (Asli)', 
                'address' => 'Jl. Gang Lombok No.11, Purwodinatan', 
                'latitude' => '-6.9734', 'longitude' => '110.4278',
                'photo' => 'https://images.unsplash.com/photo-1541544741938-0af808871cc0?auto=format&fit=crop&w=800&q=80', 
                'rating_avg' => 4.9, 'status' => 'approved',
                'description' => 'Lumpia tertua di Semarang. Isian rebungnya tidak bau sama sekali, dipadukan dengan udang dan telur yang padat. Kulitnya renyah untuk versi goreng.',
                'reviews' => [
                    ['user_id' => 3, 'rating' => 5, 'comment' => 'Ini baru lumpia Semarang asli! Rebungnya manis gurih dan nggak ada bau pesing. Sausnya juga mantap.'],
                    ['user_id' => 2, 'rating' => 5, 'comment' => 'Meskipun mahal, tapi kualitasnya sebanding. Ukurannya besar dan isinya sangat padat.']
                ]
            ],
            [
                'category_id' => 2, 'name' => 'Tahu Gimbal Pak Edi (Taman KB)', 
                'address' => 'Jl. Menteri Supeno, Semarang', 
                'latitude' => '-6.9922', 'longitude' => '110.4208',
                'photo' => 'https://images.unsplash.com/photo-1626082927389-6cd097cdc6ec?auto=format&fit=crop&w=800&q=80', 
                'rating_avg' => 4.6, 'status' => 'approved',
                'description' => 'Tahu gimbal dengan bumbu kacang yang kental dan rasa petis yang pas. Udang gimbalnya besar-besar dan sangat renyah.',
                'reviews' => [
                    ['user_id' => 2, 'rating' => 5, 'comment' => 'Bumbu kacangnya beda sama yang lain, petisnya berasa banget tapi nggak berlebihan. Udangnya gede-gede!'],
                    ['user_id' => 3, 'rating' => 4, 'comment' => 'Porsinya banyak, bikin kenyang. Cocok dimakan sore hari sambil menikmati suasana Taman KB.']
                ]
            ],
            // Minuman (Category 3)
            [
                'category_id' => 3, 'name' => 'Es Puter Cong Lik (Ahmad Dahlan)', 
                'address' => 'Jl. KH Ahmad Dahlan, Semarang', 
                'latitude' => '-6.9885', 'longitude' => '110.4235',
                'photo' => 'https://images.unsplash.com/photo-1501443762994-82bd5dace89a?auto=format&fit=crop&w=800&q=80', 
                'rating_avg' => 4.8, 'status' => 'approved',
                'description' => 'Es puter tradisional dengan berbagai varian rasa buah asli seperti durian, kopyor, dan alpukat. Teksturnya lembut dan rasanya sangat otentik.',
                'reviews' => [
                    ['user_id' => 3, 'rating' => 5, 'comment' => 'Rasa duriannya beneran pake buah durian asli, bukan perisa. Manisnya pas dan seger banget buat malam hari.'],
                    ['user_id' => 2, 'rating' => 4, 'comment' => 'Cemilan wajib kalau lagi ke Semarang. Paling suka rasa kopyornya, klasik banget.']
                ]
            ],
            [
                'category_id' => 3, 'name' => 'Asem-Asem Koh Liem', 
                'address' => 'Jl. Karang Anyar No.28, Semarang', 
                'latitude' => '-6.9825', 'longitude' => '110.4215',
                'photo' => 'https://images.unsplash.com/photo-1547592166-23ac45744acd?auto=format&fit=crop&w=800&q=80', 
                'rating_avg' => 4.7, 'status' => 'approved',
                'description' => 'Meskipun makanan berat, kuah asem-asemnya sangat menyegarkan. Potongan daging sapinya empuk dengan kuah asam manis yang balance dari tomat hijau dan belimbing wuluh.',
                'reviews' => [
                    ['user_id' => 2, 'rating' => 5, 'comment' => 'Seger banget kuahnya! Dagingnya nggak pelit dan empuk. Makan pake nasi anget pas banget.'],
                    ['user_id' => 3, 'rating' => 4, 'comment' => 'Favorit keluarga dari dulu. Rasanya nggak pernah berubah, tetep enak dan seger.']
                ]
            ],
        ];

        foreach ($locData as $data) {
            $reviews = $data['reviews'];
            unset($data['reviews']);

            $data['created_at'] = date('Y-m-d H:i:s');
            $data['updated_at'] = date('Y-m-d H:i:s');
            $db->table('culinary_locations')->insert($data);
            
            $locId = $db->insertID();

            // Insert reviews
            foreach ($reviews as $rev) {
                $rev['location_id'] = $locId;
                $rev['created_at'] = date('Y-m-d H:i:s');
                $db->table('reviews')->insert($rev);
            }
        }

        $db->query('SET FOREIGN_KEY_CHECKS=1;');
    }
}
