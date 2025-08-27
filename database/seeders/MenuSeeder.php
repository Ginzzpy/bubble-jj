<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $menus = [
            [
                'title' => 'Foto',
                'slug' => 'photo',
                'price' => 'Rp 15.000',
                'description' => 'Kirim foto kamu yang ingin di buatkan video Jedag-jedug.',
                'btn_link' => 'viewer.upload.photo',
            ],
            [
                'title' => 'Video',
                'slug' => 'video',
                'price' => 'Rp 10.000',
                'description' => 'Kirim video Jedag-jedug kamu yang mau di posting, tanpa batasan durasi dan ukuran.',
                'btn_link' => 'viewer.upload.video',
            ],
            [
                'title' => 'Video bersyarat',
                'slug' => 'free',
                'price' => 'Rp 0 (Gratis)',
                'description' => 'Kirim video berdurasi 25 hingga 60 detik dan ukuran maksimal 2MB.',
                'btn_link' => 'viewer.upload.free',
            ],
        ];

        foreach ($menus as $menu) {
            Menu::create($menu);
        }
    }
}
