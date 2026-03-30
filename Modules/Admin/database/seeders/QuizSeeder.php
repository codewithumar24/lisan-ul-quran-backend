<?php

namespace Modules\Admin\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Modules\Admin\Entities\Quiz;
use Modules\Admin\Entities\Lesson;
use Modules\Admin\Entities\QuizQuestion;

class QuizSeeder extends Seeder
{
    public function run(): void
    {
        $alifLesson = Lesson::where('title_english', 'Alif - The First Letter')->first();
        $baLesson = Lesson::where('title_english', 'Ba - The Second Letter')->first();

        // Alif Lesson Quiz
        $alifQuiz = Quiz::firstOrCreate(
            [
                'title_english' => 'Alif Lesson Quiz',
                'lesson_id' => $alifLesson?->id,
            ],
            [
                'uuid' => Str::uuid(), // ✅ ADD UUID FOR QUIZ
                'title_urdu' => 'الف سبق کوئز',
                'description_english' => 'Test your knowledge of the letter Alif',
                'description_urdu' => 'حرف الف کے بارے میں اپنے علم کا امتحان لیں',
                'quiz_type' => 'lesson_quiz',
                'time_limit_minutes' => 10,
                'passing_score_percentage' => 70,
                'max_attempts' => 3,
                'show_answers_after' => true,
                'is_published' => true,
                'display_order' => 1,
            ]
        );

        // Alif Quiz Questions
        $alifQuestions = [
            [
                'question_english' => 'What is the first letter of the Arabic alphabet?',
                'question_urdu' => 'عربی حروف تہجی کا پہلا حرف کیا ہے؟',
                'question_type' => 'multiple_choice',
                'options' => json_encode(['Alif (ا)', 'Ba (ب)', 'Ta (ت)', 'Jeem (ج)']),
                'correct_answers' => json_encode(['Alif (ا)']),
                'explanation_english' => 'Alif is the first letter of the Arabic alphabet.',
                'explanation_urdu' => 'الف عربی حروف تہجی کا پہلا حرف ہے۔',
                'points' => 1,
                'difficulty_level' => 1,
                'display_order' => 1,
            ],
            [
                'question_english' => 'What is the makhraj (articulation point) of Alif?',
                'question_urdu' => 'الف کا مخرج کیا ہے؟',
                'question_type' => 'multiple_choice',
                'options' => json_encode([
                    'From the throat',
                    'From the empty space in the mouth and throat',
                    'From the lips',
                    'From the tip of the tongue'
                ]),
                'correct_answers' => json_encode(['From the empty space in the mouth and throat']),
                'explanation_english' => 'Alif is pronounced from Al-Jawf (the empty space in the mouth and throat).',
                'explanation_urdu' => 'الف کا مخرج الجوف ہے (منہ اور حلق کی خالی جگہ)۔',
                'points' => 1,
                'difficulty_level' => 1,
                'display_order' => 2,
            ],
            [
                'question_english' => 'Which of the following is TRUE about Alif?',
                'question_urdu' => 'الف کے بارے میں مندرجہ ذیل میں سے کون سا صحیح ہے؟',
                'question_type' => 'multiple_choice',
                'options' => json_encode([
                    'It is a Qalqalah letter',
                    'It has Ghunnah',
                    'It is a Madd letter',
                    'It is pronounced from the throat'
                ]),
                'correct_answers' => json_encode(['It is a Madd letter']),
                'explanation_english' => 'Alif is one of the Madd letters used for elongation.',
                'explanation_urdu' => 'الف مد کے حروف میں سے ہے جو کھنچاؤ کے لیے استعمال ہوتا ہے۔',
                'points' => 1,
                'difficulty_level' => 2,
                'display_order' => 3,
            ],
            [
                'question_english' => 'Does Alif have different forms based on its position in a word?',
                'question_urdu' => 'کیا الف کے لفظ میں مقام کے لحاظ سے مختلف اشکال ہوتے ہیں؟',
                'question_type' => 'true_false',
                'options' => json_encode(['True', 'False']),
                'correct_answers' => json_encode(['True']),
                'explanation_english' => 'Yes, Alif has isolated, initial, middle, and final forms.',
                'explanation_urdu' => 'جی ہاں، الف کے الگ، شروع، درمیان، اور آخر کی اشکال ہوتے ہیں۔',
                'points' => 1,
                'difficulty_level' => 1,
                'display_order' => 4,
            ],
            [
                'question_english' => 'Listen to the audio and identify the letter being pronounced.',
                'question_urdu' => 'آڈیو سنیں اور پہچانیں کہ کون سا حرف ادا کیا جا رہا ہے۔',
                'question_type' => 'audio_identification',
                'options' => json_encode(['Alif', 'Ba', 'Ta', 'Tha']),
                'correct_answers' => json_encode(['Alif']),
                'audio_file' => '/audio/alif-quiz.mp3',
                'points' => 2,
                'difficulty_level' => 2,
                'display_order' => 5,
            ],
        ];

        foreach ($alifQuestions as $question) {
            QuizQuestion::firstOrCreate(
                [
                    'quiz_id' => $alifQuiz->id,
                    'question_english' => $question['question_english'],
                ],
                array_merge($question, [
                    'uuid' => Str::uuid(), // ✅ ADD UUID FOR QUESTIONS
                ])
            );
        }

        // Ba Lesson Quiz
        $baQuiz = Quiz::firstOrCreate(
            [
                'title_english' => 'Ba Lesson Quiz',
                'lesson_id' => $baLesson?->id,
            ],
            [
                'uuid' => Str::uuid(), // ✅ ADD UUID FOR QUIZ
                'title_urdu' => 'ب سبق کوئز',
                'description_english' => 'Test your knowledge of the letter Ba',
                'description_urdu' => 'حرف ب کے بارے میں اپنے علم کا امتحان لیں',
                'quiz_type' => 'lesson_quiz',
                'time_limit_minutes' => 10,
                'passing_score_percentage' => 70,
                'max_attempts' => 3,
                'show_answers_after' => true,
                'is_published' => true,
                'display_order' => 2,
            ]
        );

        $baQuestions = [
            [
                'question_english' => 'What is the makhraj (articulation point) of Ba?',
                'question_urdu' => 'ب کا مخرج کیا ہے؟',
                'question_type' => 'multiple_choice',
                'options' => json_encode([
                    'From the throat',
                    'From the empty space in the mouth',
                    'From the lips',
                    'From the tip of the tongue'
                ]),
                'correct_answers' => json_encode(['From the lips']),
                'explanation_english' => 'Ba is a labial letter pronounced by pressing the lips together.',
                'explanation_urdu' => 'ب شفوی حرف ہے جو ہونٹوں کو ملا کر ادا کیا جاتا ہے۔',
                'points' => 1,
                'difficulty_level' => 1,
                'display_order' => 1,
            ],
            [
                'question_english' => 'Which of the following is TRUE about Ba?',
                'question_urdu' => 'ب کے بارے میں مندرجہ ذیل میں سے کون سا صحیح ہے؟',
                'question_type' => 'multiple_choice',
                'options' => json_encode([
                    'It is a Qalqalah letter',
                    'It has Ghunnah',
                    'It is a Madd letter',
                    'It is pronounced from the throat'
                ]),
                'correct_answers' => json_encode(['It is a Qalqalah letter']),
                'explanation_english' => 'Ba is one of the Qalqalah letters that produces an echoing sound when saakin.',
                'explanation_urdu' => 'ب قلقلہ کے حروف میں سے ہے جو ساکن ہونے پر گونج کی آواز پیدا کرتا ہے۔',
                'points' => 1,
                'difficulty_level' => 2,
                'display_order' => 2,
            ],
            [
                'question_english' => 'What happens when Ba has sukoon?',
                'question_urdu' => 'جب ب ساکن ہو تو کیا ہوتا ہے؟',
                'question_type' => 'multiple_choice',
                'options' => json_encode([
                    'It becomes silent',
                    'It produces an echoing sound (Qalqalah)',
                    'It merges with the next letter',
                    'It becomes a nasal sound'
                ]),
                'correct_answers' => json_encode(['It produces an echoing sound (Qalqalah)']),
                'explanation_english' => 'When Ba has sukoon, it produces an echoing sound known as Qalqalah.',
                'explanation_urdu' => 'جب ب ساکن ہو تو یہ قلقلہ کی گونج پیدا کرتا ہے۔',
                'points' => 1,
                'difficulty_level' => 1,
                'display_order' => 3,
            ],
        ];

        foreach ($baQuestions as $question) {
            QuizQuestion::firstOrCreate(
                [
                    'quiz_id' => $baQuiz->id,
                    'question_english' => $question['question_english'],
                ],
                array_merge($question, [
                    'uuid' => Str::uuid(), // ✅ ADD UUID FOR QUESTIONS
                ])
            );
        }

        // Update total questions count
        $alifQuiz->updateTotalQuestions();
        $baQuiz->updateTotalQuestions();

        $this->command->info('Quizzes seeded successfully.');
    }
}
