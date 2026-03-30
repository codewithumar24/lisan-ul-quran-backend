<?php

namespace Modules\Admin\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Modules\Admin\Entities\Lesson;
use Modules\Admin\Entities\ArabicLetter;
use Modules\Admin\Entities\TajweedRule;

class LessonSeeder extends Seeder
{
    public function run(): void
    {
        $lessons = [
            // Chapter 1: Arabic Alphabet
            [
                'title_english' => 'Introduction to Arabic Letters',
                'title_urdu' => 'عربی حروف کا تعارف',
                'title_arabic' => 'مقدمة في الحروف العربية',
                'description_english' => 'Learn about the 29 Arabic letters and their basic characteristics',
                'description_urdu' => 'عربی کے 29 حروف اور ان کی بنیادی خصوصیات جانیں',
                'lesson_type' => 'alphabet',
                'chapter_number' => 1,
                'lesson_number' => 1,
                'content' => json_encode([
                    'sections' => [
                        [
                            'type' => 'text',
                            'title' => 'What are Arabic Letters?',
                            'content' => 'Arabic has 29 letters. They are written from right to left...'
                        ],
                        [
                            'type' => 'video',
                            'title' => 'Introduction Video',
                            'url' => '/videos/alphabet-intro.mp4'
                        ]
                    ]
                ]),
                'learning_objectives' => json_encode([
                    'Know the total number of Arabic letters',
                    'Understand the direction of Arabic writing',
                    'Recognize that Arabic letters have different forms'
                ]),
                'estimated_minutes' => 20,
                'difficulty_level' => 1,
                'is_published' => true,
                'arabic_letters' => [],
                'tajweed_rules' => [],
            ],
            [
                'title_english' => 'Alif - The First Letter',
                'title_urdu' => 'الف - پہلا حرف',
                'title_arabic' => 'الألف - الحرف الأول',
                'description_english' => 'Learn the letter Alif, its pronunciation, and different forms',
                'description_urdu' => 'حرف الف، اس کا تلفظ اور مختلف اشکال سیکھیں',
                'lesson_type' => 'alphabet',
                'chapter_number' => 1,
                'lesson_number' => 2,
                'content' => json_encode([
                    'sections' => [
                        [
                            'type' => 'audio',
                            'title' => 'Pronunciation of Alif',
                            'url' => '/audio/alif-pronunciation.mp3'
                        ],
                        [
                            'type' => 'image',
                            'title' => 'Forms of Alif',
                            'url' => '/images/alif-forms.png'
                        ],
                        [
                            'type' => 'text',
                            'title' => 'Makhraj of Alif',
                            'content' => 'Alif is pronounced from the empty space in the mouth and throat...'
                        ]
                    ]
                ]),
                'learning_objectives' => json_encode([
                    'Pronounce Alif correctly',
                    'Recognize Alif in different positions',
                    'Write Alif in all its forms'
                ]),
                'estimated_minutes' => 25,
                'difficulty_level' => 1,
                'is_published' => true,
                'arabic_letters' => ['ا'],
                'tajweed_rules' => ['Madd Asli'],
            ],
            [
                'title_english' => 'Ba - The Second Letter',
                'title_urdu' => 'ب - دوسرا حرف',
                'title_arabic' => 'الباء - الحرف الثاني',
                'description_english' => 'Learn the letter Ba, its pronunciation, and its Qalqalah property',
                'description_urdu' => 'حرف ب، اس کا تلفظ اور قلقلہ کی خاصیت سیکھیں',
                'lesson_type' => 'alphabet',
                'chapter_number' => 1,
                'lesson_number' => 3,
                'content' => json_encode([
                    'sections' => [
                        [
                            'type' => 'audio',
                            'title' => 'Pronunciation of Ba',
                            'url' => '/audio/ba-pronunciation.mp3'
                        ],
                        [
                            'type' => 'text',
                            'title' => 'Makhraj of Ba',
                            'content' => 'Ba is pronounced by pressing the lips together...'
                        ],
                        [
                            'type' => 'text',
                            'title' => 'Qalqalah in Ba',
                            'content' => 'Ba is one of the Qalqalah letters. When it has sukoon, it produces an echoing sound...'
                        ]
                    ]
                ]),
                'learning_objectives' => json_encode([
                    'Pronounce Ba correctly',
                    'Apply Qalqalah rule when Ba has sukoon',
                    'Recognize Ba in different positions'
                ]),
                'estimated_minutes' => 25,
                'difficulty_level' => 1,
                'is_published' => true,
                'arabic_letters' => ['ب'],
                'tajweed_rules' => ['Qalqalah'],
            ],

            // Chapter 2: Makhraj Categories
            [
                'title_english' => 'Introduction to Makharij',
                'title_urdu' => 'مخارج کا تعارف',
                'title_arabic' => 'مقدمة في المخارج',
                'description_english' => 'Learn about the articulation points of Arabic letters',
                'description_urdu' => 'عربی حروف کے مخارج کا تعارف',
                'lesson_type' => 'makhraj',
                'chapter_number' => 2,
                'lesson_number' => 1,
                'content' => json_encode([
                    'sections' => [
                        [
                            'type' => 'video',
                            'title' => 'What are Makharij?',
                            'url' => '/videos/makharij-intro.mp4'
                        ],
                        [
                            'type' => 'text',
                            'title' => 'The Five Main Categories',
                            'content' => 'Makharij are divided into five main categories: Al-Jawf, Al-Halq, Al-Lisan, Ash-Shafataan, and Al-Khayshoom...'
                        ]
                    ]
                ]),
                'learning_objectives' => json_encode([
                    'Understand what Makharij are',
                    'Identify the five main categories of Makharij',
                    'Locate the articulation points in the mouth and throat'
                ]),
                'estimated_minutes' => 30,
                'difficulty_level' => 2,
                'is_published' => true,
                'arabic_letters' => [],
                'tajweed_rules' => [],
            ],
            [
                'title_english' => 'Throat Letters - Al-Halq',
                'title_urdu' => 'حلق کے حروف',
                'title_arabic' => 'حروف الحلق',
                'description_english' => 'Learn about letters pronounced from the throat',
                'description_urdu' => 'حلق سے ادا ہونے والے حروف کے بارے میں سیکھیں',
                'lesson_type' => 'makhraj',
                'chapter_number' => 2,
                'lesson_number' => 2,
                'content' => json_encode([
                    'sections' => [
                        [
                            'type' => 'audio',
                            'title' => 'Throat Letters Audio',
                            'url' => '/audio/throat-letters.mp3'
                        ],
                        [
                            'type' => 'text',
                            'title' => 'The Six Throat Letters',
                            'content' => 'The throat letters are: ه, ء, ع, ح, غ, خ. They are divided into three levels...'
                        ]
                    ]
                ]),
                'learning_objectives' => json_encode([
                    'Identify all throat letters',
                    'Pronounce each throat letter correctly',
                    'Distinguish between different throat levels'
                ]),
                'estimated_minutes' => 35,
                'difficulty_level' => 2,
                'is_published' => true,
                'arabic_letters' => ['ح', 'خ', 'ع', 'غ', 'ه', 'ء'],
                'tajweed_rules' => [],
            ],

            // Chapter 3: Tajweed Rules
            [
                'title_english' => 'Introduction to Tajweed',
                'title_urdu' => 'تجوید کا تعارف',
                'title_arabic' => 'مقدمة في التجويد',
                'description_english' => 'Learn the importance and basic rules of Tajweed',
                'description_urdu' => 'تجوید کی اہمیت اور بنیادی قواعد',
                'lesson_type' => 'tajweed_rule',
                'chapter_number' => 3,
                'lesson_number' => 1,
                'content' => json_encode([
                    'sections' => [
                        [
                            'type' => 'video',
                            'title' => 'What is Tajweed?',
                            'url' => '/videos/tajweed-intro.mp4'
                        ],
                        [
                            'type' => 'text',
                            'title' => 'Why Tajweed Matters',
                            'content' => 'Tajweed ensures proper pronunciation of Quranic Arabic...'
                        ]
                    ]
                ]),
                'learning_objectives' => json_encode([
                    'Understand the importance of Tajweed',
                    'Learn the basic principles of Tajweed',
                    'Recognize common Tajweed terms'
                ]),
                'estimated_minutes' => 25,
                'difficulty_level' => 1,
                'is_published' => true,
                'arabic_letters' => [],
                'tajweed_rules' => [],
            ],
            [
                'title_english' => 'Noon Saakin and Tanween Rules',
                'title_urdu' => 'نون ساکن اور تنوین کے قواعد',
                'title_arabic' => 'أحكام النون الساكنة والتنوين',
                'description_english' => 'Learn the four rules for Noon Saakin and Tanween',
                'description_urdu' => 'نون ساکن اور تنوین کے چار قواعد',
                'lesson_type' => 'tajweed_rule',
                'chapter_number' => 3,
                'lesson_number' => 2,
                'content' => json_encode([
                    'sections' => [
                        [
                            'type' => 'audio',
                            'title' => 'Examples of Izhar',
                            'url' => '/audio/izhar-examples.mp3'
                        ],
                        [
                            'type' => 'audio',
                            'title' => 'Examples of Idgham',
                            'url' => '/audio/idgham-examples.mp3'
                        ],
                        [
                            'type' => 'audio',
                            'title' => 'Examples of Ikhfa',
                            'url' => '/audio/ikhfa-examples.mp3'
                        ],
                        [
                            'type' => 'audio',
                            'title' => 'Examples of Iqlab',
                            'url' => '/audio/iqlab-examples.mp3'
                        ]
                    ]
                ]),
                'learning_objectives' => json_encode([
                    'Identify when to apply Izhar',
                    'Apply Idgham correctly',
                    'Practice Ikhfa with proper nasalization',
                    'Recognize Iqlab and convert to Meem'
                ]),
                'estimated_minutes' => 45,
                'difficulty_level' => 2,
                'is_published' => true,
                'arabic_letters' => [],
                'tajweed_rules' => ['Izhar', 'Idgham', 'Ikhfa', 'Iqlab'],
            ],
            [
                'title_english' => 'Meem Saakin Rules',
                'title_urdu' => 'میم ساکن کے قواعد',
                'title_arabic' => 'أحكام الميم الساكنة',
                'description_english' => 'Learn the three rules for Meem Saakin',
                'description_urdu' => 'میم ساکن کے تین قواعد',
                'lesson_type' => 'tajweed_rule',
                'chapter_number' => 3,
                'lesson_number' => 3,
                'content' => json_encode([
                    'sections' => [
                        [
                            'type' => 'audio',
                            'title' => 'Ikhfa Shafawi Examples',
                            'url' => '/audio/ikhfa-shafawi.mp3'
                        ],
                        [
                            'type' => 'audio',
                            'title' => 'Idgham Shafawi Examples',
                            'url' => '/audio/idgham-shafawi.mp3'
                        ],
                        [
                            'type' => 'audio',
                            'title' => 'Izhar Shafawi Examples',
                            'url' => '/audio/izhar-shafawi.mp3'
                        ]
                    ]
                ]),
                'learning_objectives' => json_encode([
                    'Apply Ikhfa Shafawi correctly',
                    'Recognize Idgham Shafawi with double Meem',
                    'Practice Izhar Shafawi for all other letters'
                ]),
                'estimated_minutes' => 35,
                'difficulty_level' => 2,
                'is_published' => true,
                'arabic_letters' => ['م'],
                'tajweed_rules' => ['Ikhfa Shafawi', 'Idgham Shafawi', 'Izhar Shafawi'],
            ],
        ];

        foreach ($lessons as $lessonData) {
            $arabicLetters = $lessonData['arabic_letters'];
            $tajweedRules = $lessonData['tajweed_rules'];

            unset($lessonData['arabic_letters']);
            unset($lessonData['tajweed_rules']);

            $lesson = Lesson::firstOrCreate(
                [
                    'title_english' => $lessonData['title_english'],
                    'chapter_number' => $lessonData['chapter_number'],
                    'lesson_number' => $lessonData['lesson_number'],
                ],
                array_merge($lessonData, [
                    'uuid' => Str::uuid(), // ✅ ADD UUID HERE
                ])
            );

            // Sync Arabic letters
            if (!empty($arabicLetters)) {
                $letterIds = ArabicLetter::whereIn('letter_arabic', $arabicLetters)->pluck('id');
                $lesson->arabicLetters()->sync($letterIds);
            }

            // Sync Tajweed rules
            if (!empty($tajweedRules)) {
                $ruleIds = TajweedRule::whereIn('rule_name_english', $tajweedRules)->pluck('id');
                $lesson->tajweedRules()->sync($ruleIds);
            }
        }

        $this->command->info('Lessons seeded successfully: ' . count($lessons) . ' lessons.');
    }
}
