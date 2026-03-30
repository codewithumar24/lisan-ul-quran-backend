<?php

namespace Modules\Admin\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Modules\Admin\Entities\MakhrajCategory;

class MakhrajCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name_english' => 'Al-Jawf',
                'name_arabic' => 'الجوف',
                'name_urdu' => 'حلق',
                'description_english' => 'The empty space in the mouth and throat',
                'description_urdu' => 'منہ اور حلق کی خالی جگہ',
            ],
            [
                'name_english' => 'Al-Halq',
                'name_arabic' => 'الحلق',
                'name_urdu' => 'حلق',
                'description_english' => 'The throat - divided into three parts: deepest, middle, and closest to mouth',
                'description_urdu' => 'حلق - تین حصوں میں تقسیم: گہرا، درمیانی، اور منہ کے قریب',
            ],
            [
                'name_english' => 'Al-Lisan',
                'name_arabic' => 'اللسان',
                'name_urdu' => 'زبان',
                'description_english' => 'The tongue - multiple articulation points',
                'description_urdu' => 'زبان - متعدد مخارج',
            ],
            [
                'name_english' => 'Ash-Shafataan',
                'name_arabic' => 'الشفتان',
                'name_urdu' => 'ہونٹ',
                'description_english' => 'The lips - various articulation points',
                'description_urdu' => 'ہونٹ - متعدد مخارج',
            ],
            [
                'name_english' => 'Al-Khayshoom',
                'name_arabic' => 'الخيشوم',
                'name_urdu' => 'ناک',
                'description_english' => 'The nasal cavity - for ghunnah sounds',
                'description_urdu' => 'ناک کی گہا - غنہ کے لیے',
            ],
        ];

        $order = 1;

        foreach ($categories as $category) {
            MakhrajCategory::firstOrCreate(
                ['name_english' => $category['name_english']],
                array_merge($category, [
                    'uuid' => Str::uuid(), // ✅ FIX
                    'display_order' => $order++,
                ])
            );
        }

        $this->command->info('Makhraj categories seeded successfully: ' . count($categories) . ' categories.');
    }
}
