<?php

namespace Tests\Unit;

use App\Services\SmileScoreService;
use Tests\TestCase;

class SmileScoreServiceTest extends TestCase
{
    protected SmileScoreService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new SmileScoreService();
    }

    /**
     * 1. Pengguna menjawab seluruh soal dengan benar: skor 20, nilai 100%, kategori 😍 Baik.
     */
    public function test_perfect_score_all_20_correct(): void
    {
        // Kunci jawaban: 1:b, 2:c, 3:c, 4:b, 5:d, 6:b, 7:d, 8:c, 9:a, 10:d, 11:c, 12:a, 13:a, 14:a, 15:d, 16:b, 17:c, 18:a, 19:b, 20:a
        $answers = [
            1 => 'b', 2 => 'c', 3 => 'c', 4 => 'b', 5 => 'd',
            6 => 'b', 7 => 'd', 8 => 'c', 9 => 'a', 10 => 'd',
            11 => 'c', 12 => 'a', 13 => 'a', 14 => 'a', 15 => 'd',
            16 => 'b', 17 => 'c', 18 => 'a', 19 => 'b', 20 => 'a',
        ];

        $res = $this->service->evaluateAnswers($answers);

        $this->assertEquals(20, $res['correct_count']);
        $this->assertEquals(100, $res['percentage']);
        $this->assertEquals('Baik', $res['category']);
        $this->assertEquals('😍', $res['emoji']);
        $this->assertEmpty($res['incorrect_items']);
    }

    /**
     * 2. Pengguna menjawab 16 soal dengan benar: nilai 80%, kategori 😍 Baik. (Batas Bawah Baik)
     */
    public function test_score_boundary_16_correct_is_baik(): void
    {
        $answers = [
            1 => 'b', 2 => 'c', 3 => 'c', 4 => 'b', 5 => 'd',
            6 => 'b', 7 => 'd', 8 => 'c', 9 => 'a', 10 => 'd',
            11 => 'c', 12 => 'a', 13 => 'a', 14 => 'a', 15 => 'd',
            16 => 'b', // 16 benar
            17 => 'a', 18 => 'b', 19 => 'a', 20 => 'b', // 4 salah
        ];

        $res = $this->service->evaluateAnswers($answers);

        $this->assertEquals(16, $res['correct_count']);
        $this->assertEquals(80, $res['percentage']);
        $this->assertEquals('Baik', $res['category']);
        $this->assertEquals('😍', $res['emoji']);
        $this->assertCount(4, $res['incorrect_items']);
    }

    /**
     * 3. Pengguna menjawab 15 soal dengan benar: nilai 75%, kategori 😉 Cukup. (Batas Atas Cukup)
     */
    public function test_score_boundary_15_correct_is_cukup(): void
    {
        $answers = [
            1 => 'b', 2 => 'c', 3 => 'c', 4 => 'b', 5 => 'd',
            6 => 'b', 7 => 'd', 8 => 'c', 9 => 'a', 10 => 'd',
            11 => 'c', 12 => 'a', 13 => 'a', 14 => 'a', 15 => 'd', // 15 benar
            16 => 'a', 17 => 'a', 18 => 'b', 19 => 'a', 20 => 'b', // 5 salah
        ];

        $res = $this->service->evaluateAnswers($answers);

        $this->assertEquals(15, $res['correct_count']);
        $this->assertEquals(75, $res['percentage']);
        $this->assertEquals('Cukup', $res['category']);
        $this->assertEquals('😉', $res['emoji']);
        $this->assertCount(5, $res['incorrect_items']);
    }

    /**
     * 4. Pengguna menjawab 12 soal dengan benar: nilai 60%, kategori 😉 Cukup. (Batas Bawah Cukup)
     */
    public function test_score_boundary_12_correct_is_cukup(): void
    {
        $answers = [
            1 => 'b', 2 => 'c', 3 => 'c', 4 => 'b', 5 => 'd',
            6 => 'b', 7 => 'd', 8 => 'c', 9 => 'a', 10 => 'd',
            11 => 'c', 12 => 'a', // 12 benar
            13 => 'b', 14 => 'b', 15 => 'a', 16 => 'a', 17 => 'a',
            18 => 'b', 19 => 'a', 20 => 'b', // 8 salah
        ];

        $res = $this->service->evaluateAnswers($answers);

        $this->assertEquals(12, $res['correct_count']);
        $this->assertEquals(60, $res['percentage']);
        $this->assertEquals('Cukup', $res['category']);
        $this->assertEquals('😉', $res['emoji']);
        $this->assertCount(8, $res['incorrect_items']);
    }

    /**
     * 5. Pengguna menjawab 11 soal dengan benar: nilai 55%, kategori 🤨 Kurang baik. (Batas Atas Kurang baik)
     */
    public function test_score_boundary_11_correct_is_kurang_baik(): void
    {
        $answers = [
            1 => 'b', 2 => 'c', 3 => 'c', 4 => 'b', 5 => 'd',
            6 => 'b', 7 => 'd', 8 => 'c', 9 => 'a', 10 => 'd',
            11 => 'c', // 11 benar
            12 => 'b', 13 => 'b', 14 => 'b', 15 => 'a', 16 => 'a',
            17 => 'a', 18 => 'b', 19 => 'a', 20 => 'b', // 9 salah
        ];

        $res = $this->service->evaluateAnswers($answers);

        $this->assertEquals(11, $res['correct_count']);
        $this->assertEquals(55, $res['percentage']);
        $this->assertEquals('Kurang baik', $res['category']);
        $this->assertEquals('🤨', $res['emoji']);
        $this->assertCount(9, $res['incorrect_items']);
    }

    /**
     * 6. Pengguna menjawab seluruh soal dengan salah: skor 0, nilai 0%, kategori 🤨 Kurang baik.
     */
    public function test_score_all_0_correct_is_kurang_baik(): void
    {
        // Semua opsi dibuat sengaja salah
        $answers = [
            1 => 'a', 2 => 'a', 3 => 'a', 4 => 'a', 5 => 'a',
            6 => 'a', 7 => 'a', 8 => 'a', 9 => 'b', 10 => 'a',
            11 => 'a', 12 => 'b', 13 => 'b', 14 => 'b', 15 => 'a',
            16 => 'a', 17 => 'a', 18 => 'b', 19 => 'a', 20 => 'b',
        ];

        $res = $this->service->evaluateAnswers($answers);

        $this->assertEquals(0, $res['correct_count']);
        $this->assertEquals(0, $res['percentage']);
        $this->assertEquals('Kurang baik', $res['category']);
        $this->assertEquals('🤨', $res['emoji']);
        $this->assertCount(20, $res['incorrect_items']);
    }

    /**
     * 7. Verifikasi ketat: Seluruh rentang skor 0-20 memiliki kategori pasti dan tidak tumpang tindih.
     */
    public function test_all_possible_scores_from_0_to_20_have_valid_categories(): void
    {
        for ($correct = 0; $correct <= 20; $correct++) {
            $answers = [];
            $correctKeys = [
                1 => 'b', 2 => 'c', 3 => 'c', 4 => 'b', 5 => 'd',
                6 => 'b', 7 => 'd', 8 => 'c', 9 => 'a', 10 => 'd',
                11 => 'c', 12 => 'a', 13 => 'a', 14 => 'a', 15 => 'd',
                16 => 'b', 17 => 'c', 18 => 'a', 19 => 'b', 20 => 'a',
            ];

            for ($i = 1; $i <= 20; $i++) {
                if ($i <= $correct) {
                    $answers[$i] = $correctKeys[$i];
                } else {
                    $answers[$i] = ($correctKeys[$i] === 'a') ? 'b' : 'a';
                }
            }

            $res = $this->service->evaluateAnswers($answers);
            $this->assertEquals($correct, $res['correct_count']);

            if ($correct >= 16) {
                $this->assertEquals('Baik', $res['category']);
                $this->assertEquals('😍', $res['emoji']);
            } elseif ($correct >= 12) {
                $this->assertEquals('Cukup', $res['category']);
                $this->assertEquals('😉', $res['emoji']);
            } else {
                $this->assertEquals('Kurang baik', $res['category']);
                $this->assertEquals('🤨', $res['emoji']);
            }
        }
    }

    /**
     * 8. Fallback edukasi statis saat AI tidak aktif/gagal.
     */
    public function test_education_rule_based_fallback(): void
    {
        $eval = [
            'correct_count' => 10,
            'percentage' => 50,
            'category' => 'Kurang baik',
            'emoji' => '🤨',
            'incorrect_items' => [
                ['topic' => 'Penyebab Gigi Berlubang', 'explanation' => 'Asam bakteri melarutkan mineral.'],
                ['topic' => 'Penyebab Radang Gusi', 'explanation' => 'Plak menumpuk di gusi.'],
            ]
        ];

        $originalEnv = getenv('GEMINI_API_KEY');
        putenv('GEMINI_API_KEY=');
        unset($_ENV['GEMINI_API_KEY'], $_SERVER['GEMINI_API_KEY']);
        config(['services.gemini.api_key' => null]);

        try {
            $education = $this->service->generateEducationContent($eval);

            $this->assertEquals('rule_based', $education['source']);
            $this->assertNotEmpty($education['introduction']);
            $this->assertNotEmpty($education['score_interpretation']);
            $this->assertNotEmpty($education['priority_topics']);
            $this->assertNotEmpty($education['key_points']);
            $this->assertNotEmpty($education['daily_habits']);
            $this->assertNotEmpty($education['when_to_seek_care']);
            $this->assertStringContainsString('diagnosis medis', $education['disclaimer']);
        } finally {
            if ($originalEnv !== false) {
                putenv("GEMINI_API_KEY={$originalEnv}");
                $_ENV['GEMINI_API_KEY'] = $originalEnv;
                $_SERVER['GEMINI_API_KEY'] = $originalEnv;
                config(['services.gemini.api_key' => $originalEnv]);
            }
        }
    }
}
