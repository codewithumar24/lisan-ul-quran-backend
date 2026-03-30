<?php

namespace Modules\Admin\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Modules\Admin\Entities\PracticeExercise;
use Modules\Admin\Entities\Lesson;

class PracticeExerciseSeeder extends Seeder
{
    public function run(): void
    {
        $alifLesson = Lesson::where('title_english', 'Alif - The First Letter')->first();
        $baLesson = Lesson::where('title_english', 'Ba - The Second Letter')->first();
        $noonSaakinLesson = Lesson::where('title_english', 'Noon Saakin and Tanween Rules')->first();

        $exercises = [
            [
                'lesson_id' => $alifLesson?->id,
                'title_english' => 'Alif Pronunciation Practice',
                'title_urdu' => 'الف تلفظ کی مشق',
                'exercise_type' => 'pronunciation',
                'instructions_english' => 'Listen to the audio and repeat after it. Record your pronunciation and compare.',
                'instructions_urdu' => 'آڈیو سنیں اور دہرائیں۔ اپنا تلفظ ریکارڈ کریں اور موازنہ کریں۔',
                'content' => json_encode([
                    'text' => 'ا - اَ - اِ - اُ',
                    'words' => ['اَب', 'اُم', 'اِبن'],
                    'examples' => [
                        ['word' => 'اَب', 'meaning' => 'father'],
                        ['word' => 'اُم', 'meaning' => 'mother'],
                        ['word' => 'اِبن', 'meaning' => 'son']
                    ]
                ]),
                'correct_response' => json_encode([
                    'expected' => 'Alif with proper makhraj from empty space in mouth',
                    'common_mistakes' => [
                        'Pronouncing from the throat',
                        'Adding nasal sound',
                        'Too short or too long'
                    ]
                ]),
                'points' => 10,
                'difficulty_level' => 1,
                'display_order' => 1,
            ],
            [
                'lesson_id' => $alifLesson?->id,
                'title_english' => 'Alif Writing Practice',
                'title_urdu' => 'الف لکھنے کی مشق',
                'exercise_type' => 'repetition',
                'instructions_english' => 'Practice writing Alif in all its forms: isolated, initial, middle, and final',
                'instructions_urdu' => 'الف کو اس کی تمام صورتوں میں لکھنے کی مشق کریں: الگ، شروع، درمیان، آخر',
                'content' => json_encode([
                    'isolated' => 'ا',
                    'initial' => 'ا',
                    'middle' => 'ـا',
                    'final' => 'ـا',
                    'examples' => ['اَب', 'اُم', 'باَب', 'با'],
                    'traceable' => true
                ]),
                'points' => 15,
                'difficulty_level' => 1,
                'display_order' => 2,
            ],
            [
                'lesson_id' => $baLesson?->id,
                'title_english' => 'Ba Pronunciation with Qalqalah',
                'title_urdu' => 'قلقلہ کے ساتھ ب کا تلفظ',
                'exercise_type' => 'pronunciation',
                'instructions_english' => 'Practice Ba with Qalqalah. Notice the echoing sound when Ba has sukoon.',
                'instructions_urdu' => 'قلقلہ کے ساتھ ب کا تلفظ کریں۔ جب ب ساکن ہو تو گونج کی آواز نوٹ کریں۔',
                'content' => json_encode([
                    'text' => 'ب - بْ - بَب - بَاب',
                    'words' => ['بَاب', 'بُوب', 'بِيب'],
                    'examples' => [
                        ['word' => 'بَاب', 'meaning' => 'door'],
                        ['word' => 'بُوب', 'meaning' => 'pipe'],
                        ['word' => 'بِيب', 'meaning' => 'pop']
                    ]
                ]),
                'correct_response' => json_encode([
                    'expected' => 'Ba with strong lip pressure and echoing when saakin',
                    'common_mistakes' => [
                        'Weak lip pressure',
                        'No echoing sound',
                        'Missing Qalqalah'
                    ]
                ]),
                'points' => 15,
                'difficulty_level' => 2,
                'display_order' => 1,
            ],
            [
                'lesson_id' => $noonSaakinLesson?->id,
                'title_english' => 'Izhar Identification Exercise',
                'title_urdu' => 'اظہار کی شناخت کی مشق',
                'exercise_type' => 'identification',
                'instructions_english' => 'Identify which words contain Izhar (clear pronunciation of Noon Saakin)',
                'instructions_urdu' => 'پہچانیں کہ کن الفاظ میں اظہار ہے (نون ساکن کا واضح تلفظ)',
                'content' => json_encode([
                    'words' => [
                        ['word' => 'مِنْ رَبِّهِمْ', 'has_izhar' => false],
                        ['word' => 'مِنْ هَادٍ', 'has_izhar' => true],
                        ['word' => 'مِنْ قَبْلِ', 'has_izhar' => false],
                        ['word' => 'مِنْ عِلْمٍ', 'has_izhar' => true],
                    ]
                ]),
                'correct_response' => json_encode([
                    'expected' => 'Izhar occurs with throat letters: ء, ه, ع, ح, غ, خ'
                ]),
                'options' => json_encode(['Yes, Izhar', 'No, Not Izhar']),
                'points' => 20,
                'difficulty_level' => 2,
                'display_order' => 1,
            ],
        ];

        foreach ($exercises as $exercise) {
            if ($exercise['lesson_id']) {
                PracticeExercise::firstOrCreate(
                    [
                        'lesson_id' => $exercise['lesson_id'],
                        'title_english' => $exercise['title_english'],
                    ],
                    array_merge($exercise, [
                        'uuid' => Str::uuid(), // ✅ ADD UUID HERE
                    ])
                );
            }
        }

        $this->command->info('Practice exercises seeded successfully.');
    }
}
