<?php

namespace Database\Seeders;

use App\Models\Contact;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Contact::firstOrCreate(
            ['email' => 'kafleparkrit@gmail.com'],
            [
                'phone' => '+977 9869296810',
                'facebook' => 'https://www.facebook.com/',
                'twitter' => 'https://x.com/tweet?lang=en',
                'instagram' => 'https://www.instagram.com/',
                'mapSrc' => 'https://www.google.com/maps/embed?pb=!1m10!1m8!1m3!1d1178.7454298192038!2d85.3176899733825!3d27.73041743331114!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2snp!4v1692332346612!5m2!1sen!2snp',
            ]
        );
    }
}
