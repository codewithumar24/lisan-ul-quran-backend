<?php

namespace Modules\Admin\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Modules\Admin\Entities\TajweedRule;

class TajweedRuleSeeder extends Seeder
{
    public function run(): void
    {
        $rules = [
            // Noon Saakin & Tanween Rules
            [
                'rule_category' => 'Noon Saakin',
                'rule_name_english' => 'Izhar',
                'rule_name_arabic' => 'الإظهار',
                'rule_name_urdu' => 'اظہار',
                'description_english' => 'Clear pronunciation of Noon Saakin or Tanween',
                'description_urdu' => 'نون ساکن یا تنوین کا واضح تلفظ',
                'applicable_letters' => ['ء', 'ه', 'ع', 'ح', 'غ', 'خ'],
                'application_method_english' => 'Pronounce the noon clearly without ghunnah',
                'application_method_urdu' => 'نون کو بغیر غنہ کے واضح طور پر ادا کریں',
                'examples' => ['مِنْ رَبِّهِمْ', 'مِنْ هَادٍ'],
                'difficulty_level' => 1,
                'display_order' => 1,
                'is_basic' => true,
            ],
            [
                'rule_category' => 'Noon Saakin',
                'rule_name_english' => 'Idgham',
                'rule_name_arabic' => 'الإدغام',
                'rule_name_urdu' => 'ادغام',
                'description_english' => 'Merging of Noon Saakin or Tanween into the following letter',
                'description_urdu' => 'نون ساکن یا تنوین کا اگلے حرف میں مل جانا',
                'applicable_letters' => ['ي', 'ر', 'م', 'ل', 'و', 'ن'],
                'application_method_english' => 'Merge the noon into the following letter with ghunnah',
                'application_method_urdu' => 'نون کو اگلے حرف میں غنہ کے ساتھ ملا دیں',
                'examples' => ['مِنْ يَقُولُ', 'مِنْ رَبِّهِمْ'],
                'difficulty_level' => 2,
                'display_order' => 2,
                'is_basic' => true,
            ],
            [
                'rule_category' => 'Noon Saakin',
                'rule_name_english' => 'Ikhfa',
                'rule_name_arabic' => 'الإخفاء',
                'rule_name_urdu' => 'اخفاء',
                'description_english' => 'Concealment of Noon Saakin or Tanween',
                'description_urdu' => 'نون ساکن یا تنوین کا مخفی کرنا',
                'applicable_letters' => ['ت', 'ث', 'ج', 'د', 'ذ', 'ز', 'س', 'ش', 'ص', 'ض', 'ط', 'ظ', 'ف', 'ق', 'ك'],
                'application_method_english' => 'Pronounce with a nasal sound without full merging',
                'application_method_urdu' => 'نون کو بغیر مکمل ملائے ناک سے آواز نکالیں',
                'examples' => ['مِنْ قَبْلِ', 'عَلِيمًا كَانَ'],
                'difficulty_level' => 2,
                'display_order' => 3,
                'is_basic' => true,
            ],
            [
                'rule_category' => 'Noon Saakin',
                'rule_name_english' => 'Iqlab',
                'rule_name_arabic' => 'الإقلاب',
                'rule_name_urdu' => 'اقلاب',
                'description_english' => 'Changing Noon Saakin or Tanween into Meem',
                'description_urdu' => 'نون ساکن یا تنوین کا میم میں تبدیل ہونا',
                'applicable_letters' => ['ب'],
                'application_method_english' => 'Change the noon into meem with ghunnah',
                'application_method_urdu' => 'نون کو میم میں بدل کر غنہ کے ساتھ ادا کریں',
                'examples' => ['مِنْ بَعْدِ', 'عَلِيمٌ بِذَاتِ'],
                'difficulty_level' => 2,
                'display_order' => 4,
                'is_basic' => true,
            ],

            // Meem Saakin Rules
            [
                'rule_category' => 'Meem Saakin',
                'rule_name_english' => 'Ikhfa Shafawi',
                'rule_name_arabic' => 'الإخفاء الشفوي',
                'rule_name_urdu' => 'اخفاء شفوی',
                'description_english' => 'Concealment of Meem Saakin with ghunnah',
                'description_urdu' => 'میم ساکن کا غنہ کے ساتھ مخفی کرنا',
                'applicable_letters' => ['ب'],
                'application_method_english' => 'Conceal the meem with a nasal sound',
                'application_method_urdu' => 'میم کو ناک سے آواز نکالتے ہوئے مخفی کریں',
                'examples' => ['تَرْمِيهِم بِحِجَارَةٍ'],
                'difficulty_level' => 2,
                'display_order' => 5,
                'is_basic' => true,
            ],
            [
                'rule_category' => 'Meem Saakin',
                'rule_name_english' => 'Idgham Shafawi',
                'rule_name_arabic' => 'الإدغام الشفوي',
                'rule_name_urdu' => 'ادغام شفوی',
                'description_english' => 'Merging of Meem Saakin into another Meem',
                'description_urdu' => 'میم ساکن کا دوسرے میم میں مل جانا',
                'applicable_letters' => ['م'],
                'application_method_english' => 'Merge the meem into the following meem with ghunnah',
                'application_method_urdu' => 'میم کو اگلے میم میں غنہ کے ساتھ ملا دیں',
                'examples' => ['وَلَهُم مَّا', 'عَلَيْهِم مَّا'],
                'difficulty_level' => 2,
                'display_order' => 6,
                'is_basic' => true,
            ],
            [
                'rule_category' => 'Meem Saakin',
                'rule_name_english' => 'Izhar Shafawi',
                'rule_name_arabic' => 'الإظهار الشفوي',
                'rule_name_urdu' => 'اظہار شفوی',
                'description_english' => 'Clear pronunciation of Meem Saakin',
                'description_urdu' => 'میم ساکن کا واضح تلفظ',
                'applicable_letters' => ['أ', 'ب', 'ت', 'ث', 'ج', 'ح', 'خ', 'د', 'ذ', 'ر', 'ز', 'س', 'ش', 'ص', 'ض', 'ط', 'ظ', 'ع', 'غ', 'ف', 'ق', 'ك', 'ل', 'ن', 'ه', 'و', 'ي'],
                'application_method_english' => 'Pronounce the meem clearly without ghunnah',
                'application_method_urdu' => 'میم کو بغیر غنہ کے واضح طور پر ادا کریں',
                'examples' => ['أَمْ هُمْ', 'عَلَيْهِمْ غَيْرِ'],
                'difficulty_level' => 1,
                'display_order' => 7,
                'is_basic' => true,
            ],

            // Qalqalah
            [
                'rule_category' => 'Qalqalah',
                'rule_name_english' => 'Qalqalah',
                'rule_name_arabic' => 'القلقلة',
                'rule_name_urdu' => 'قلقلہ',
                'description_english' => 'Echoing sound when a letter is saakin',
                'description_urdu' => 'حرف ساکن ہونے پر گونج کی آواز',
                'applicable_letters' => ['ق', 'ط', 'ب', 'ج', 'د'],
                'application_method_english' => 'Produce an echoing sound when the letter is saakin',
                'application_method_urdu' => 'حرف ساکن ہونے پر گونج کی آواز نکالیں',
                'examples' => ['اقْرَأْ', 'فَجَعَلْنَاهُمْ', 'وَمَا أَدْرَاكَ'],
                'difficulty_level' => 2,
                'display_order' => 8,
                'is_basic' => true,
            ],

            // Madd Rules
            [
                'rule_category' => 'Madd',
                'rule_name_english' => 'Madd Asli',
                'rule_name_arabic' => 'المد الأصلي',
                'rule_name_urdu' => 'مد اصلی',
                'description_english' => 'Natural elongation of 2 counts',
                'description_urdu' => 'دو حرکت کا قدرتی مد',
                'applicable_letters' => ['ا', 'و', 'ي'],
                'application_method_english' => 'Elongate the letter for 2 counts',
                'application_method_urdu' => 'حرف کو دو حرکت تک کھینچیں',
                'examples' => ['قَالَ', 'يَقُولُ', 'قِيلَ'],
                'difficulty_level' => 1,
                'display_order' => 9,
                'is_basic' => true,
            ],
            [
                'rule_category' => 'Madd',
                'rule_name_english' => 'Madd Wajib Muttasil',
                'rule_name_arabic' => 'المد الواجب المتصل',
                'rule_name_urdu' => 'مد واجب متصل',
                'description_english' => 'Compulsory elongation of 4-5 counts when a hamza follows a madd letter in the same word',
                'description_urdu' => 'جب مد حرف کے بعد ہمزہ ہو تو 4-5 حرکت کھینچنا واجب ہے',
                'applicable_letters' => ['ا', 'و', 'ي'],
                'application_method_english' => 'Elongate for 4-5 counts when followed by hamza in same word',
                'application_method_urdu' => 'جب اگلا حرف ہمزہ ہو تو 4-5 حرکت کھینچیں',
                'examples' => ['جَاءَ', 'سُوءَ', 'الْحَيَاءَ'],
                'difficulty_level' => 3,
                'display_order' => 10,
                'is_basic' => false,
            ],
            [
                'rule_category' => 'Madd',
                'rule_name_english' => 'Madd Jaiz Munfasil',
                'rule_name_arabic' => 'المد الجائز المنفصل',
                'rule_name_urdu' => 'مد جائز منفصل',
                'description_english' => 'Permissible elongation of 2-5 counts when a hamza follows a madd letter in the next word',
                'description_urdu' => 'جب مد حرف کے بعد ہمزہ اگلے لفظ میں ہو تو 2-5 حرکت کھینچنا جائز ہے',
                'applicable_letters' => ['ا', 'و', 'ي'],
                'application_method_english' => 'Elongate for 2-5 counts when followed by hamza in next word',
                'application_method_urdu' => 'جب اگلے لفظ میں ہمزہ ہو تو 2-5 حرکت کھینچیں',
                'examples' => ['فِي أَنفُسِهِمْ', 'قُوا أَنفُسَكُمْ'],
                'difficulty_level' => 3,
                'display_order' => 11,
                'is_basic' => false,
            ],
        ];

        $order = 12;
        foreach ($rules as $rule) {
            TajweedRule::firstOrCreate(
                ['rule_name_english' => $rule['rule_name_english']],
                array_merge($rule, [
                    'uuid' => Str::uuid(), // ✅ ADD UUID HERE
                    'display_order' => $order++
                ])
            );
        }

        $this->command->info('Tajweed rules seeded successfully: ' . count($rules) . ' rules.');
    }
}
