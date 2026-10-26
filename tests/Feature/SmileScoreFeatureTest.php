<?php

namespace Tests\Feature;

use App\Models\SmileScoreSubmission;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SmileScoreFeatureTest extends TestCase
{
    use RefreshDatabase;
    /**
     * 1. Siswa membuka Smile Score dan diarahkan ke form biodata sebelum soal.
     */
    public function test_student_opens_smile_score_and_sees_biodata_form(): void
    {
        $response = $this->get('/smile-score');

        $response->assertStatus(200);
        $response->assertSee('Biodata Siswa');
        $response->assertSee('Nama Lengkap');
        $response->assertSee('Usia');
        $response->assertSee('Jenis Kelamin');
        $response->assertSee('Kelas');
        $response->assertSee('Lanjutkan ke Kuesioner');
    }

    /**
     * 2. Siswa mencoba melanjutkan tanpa mengisi biodata; sistem menolak (validasi gagal).
     */
    public function test_biodata_submission_fails_when_fields_are_missing(): void
    {
        $response = $this->from('/smile-score')->post('/smile-score/biodata', [
            'name' => '',
            'age' => '',
            'gender' => '',
            'class_name' => '',
        ]);

        $response->assertStatus(302);
        $response->assertRedirect('/smile-score');
        $response->assertSessionHasErrors(['name', 'age', 'gender', 'class_name']);
    }

    /**
     * 3. Siswa mengisi biodata dengan benar; sistem mengizinkan lanjut ke kuesioner.
     */
    public function test_student_submits_valid_biodata_and_is_redirected_to_questionnaire(): void
    {
        $payload = [
            'name' => 'Ahmad Fauzi',
            'age' => 16,
            'gender' => 'Laki-laki',
            'class_name' => 'X Teknik Komputer',
        ];

        $response = $this->post('/smile-score/biodata', $payload);

        $response->assertStatus(302);
        $response->assertRedirect('/smile-score/kuesioner');
        $this->assertEquals($payload, session('smile_score_biodata'));

        // Cek halaman kuesioner terbuka dan memuat profil siswa
        $qResponse = $this->get('/smile-score/kuesioner');
        $qResponse->assertStatus(200);
        $qResponse->assertSee('Ahmad Fauzi');
        $qResponse->assertSee('X Teknik Komputer');
        $qResponse->assertSee('Ukur <span class="text-[#168C83]">Smile Score</span> Kamu', false);
    }

    /**
     * 4. Siswa mencoba membuka halaman soal secara langsung tanpa biodata; sistem mengarahkan kembali ke biodata.
     */
    public function test_direct_access_to_questionnaire_without_biodata_is_blocked(): void
    {
        // Tanpa session biodata
        $response = $this->get('/smile-score/kuesioner');

        $response->assertStatus(302);
        $response->assertRedirect('/smile-score');
        $response->assertSessionHas('warning');
    }

    /**
     * 5. Siswa menyelesaikan 20 soal; skor dan kategori dihitung, dan biodata terhubung dengan hasil.
     */
    public function test_submission_evaluates_score_and_links_biodata(): void
    {
        // Set biodata siswa di session
        config(['services.gemini.api_key' => null]);
        $biodata = [
            'name' => 'Siti Nurhaliza',
            'age' => 17,
            'gender' => 'Perempuan',
            'class_name' => 'XI Farmasi',
        ];
        session(['smile_score_biodata' => $biodata]);

        // Isi 16 soal benar -> 80% (Baik 😍)
        $correctKeys = [
            1 => 'b', 2 => 'c', 3 => 'c', 4 => 'b', 5 => 'd',
            6 => 'b', 7 => 'd', 8 => 'c', 9 => 'a', 10 => 'd',
            11 => 'c', 12 => 'a', 13 => 'a', 14 => 'a', 15 => 'd',
            16 => 'b', 17 => 'a', 18 => 'b', 19 => 'a', 20 => 'b',
        ];

        $response = $this->post('/smile-score/submit', ['answers' => $correctKeys]);

        $response->assertStatus(302);
        $response->assertRedirect('/smile-score/hasil');

        // Verifikasi hasil di session
        $result = session('smile_score_result');
        $this->assertNotNull($result);
        $this->assertEquals(16, $result['correct_count']);
        $this->assertEquals(80, $result['percentage']);
        $this->assertEquals('Baik', $result['category']);
        $this->assertEquals('😍', $result['emoji']);
        $this->assertEquals($biodata, $result['student']); // Biodata terhubung erat!

        // Verifikasi tersimpan di database
        $this->assertDatabaseHas('smile_score_submissions', [
            'name' => 'Siti Nurhaliza',
            'age' => 17,
            'gender' => 'Perempuan',
            'class_name' => 'XI Farmasi',
            'correct_count' => 16,
            'percentage' => 80,
            'category' => 'Baik',
        ]);

        // Verifikasi halaman hasil menampilkan nama siswa
        $resultPage = $this->get('/smile-score/hasil');
        $resultPage->assertStatus(200);
        $resultPage->assertSee('Siti Nurhaliza');
        $resultPage->assertSee('XI Farmasi');
        $resultPage->assertSee('Hasil Smile Score');
        $resultPage->assertSee('Kategori: Baik');

        // Verifikasi halaman edukasi menampilkan nama siswa
        $eduPage = $this->get('/smile-score/edukasi');
        $eduPage->assertStatus(200);
        $eduPage->assertSee('Siti Nurhaliza');
    }

    /**
     * 6. Akses langsung halaman hasil tanpa session dialihkan ke awal (biodata).
     */
    public function test_direct_access_to_result_without_session_redirects_to_start(): void
    {
        $response = $this->get('/smile-score/hasil');

        $response->assertStatus(302);
        $response->assertRedirect('/smile-score');
        $response->assertSessionHas('info');
    }

    /**
     * 7. Tombol Mulai Smile Score di beranda mengarah ke route smile-score.start (biodata).
     */
    public function test_homepage_cta_buttons_point_to_smile_score_start_route(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee(route('smile-score.start'));
        $response->assertSee('Mulai Smile Score');
    }

    /**
     * 8. Artefak Vercel preview menyajikan alur biodata dan bukan lagi placeholder "Coming Soon".
     */
    /**
     * 8. Artefak Vercel preview menyajikan alur biodata dan bukan lagi placeholder "Coming Soon".
     */
    public function test_vercel_preview_artifacts_point_to_biodata_flow_and_not_coming_soon(): void
    {
        $previewIndex = base_path('vercel-preview/index.html');
        $previewSmileScore = base_path('vercel-preview/smile-score.html');

        $this->assertFileExists($previewIndex);
        $this->assertFileExists($previewSmileScore);

        $indexContent = file_get_contents($previewIndex);
        $this->assertStringContainsString('smile-score.html', $indexContent);
        $this->assertStringContainsString('Mulai Smile Score', $indexContent);

        $smileScoreContent = file_get_contents($previewSmileScore);
        $this->assertStringContainsString('Biodata Siswa', $smileScoreContent);
        $this->assertStringContainsString('Nama Lengkap', $smileScoreContent);
        $this->assertStringContainsString('Lanjutkan ke Kuesioner', $smileScoreContent);
        $this->assertStringNotContainsString('Coming Soon ✨', $smileScoreContent);

        // Verifikasi kejujuran mode preview: tidak mengklaim sebagai Gemini AI di statis
        $this->assertStringContainsString('Mode Pratinjau', $smileScoreContent);
        $this->assertStringContainsString('Materi yang Perlu Dipahami', $smileScoreContent);
        $this->assertStringContainsString('3 Kebiasaan Sehat yang Bisa Diterapkan', $smileScoreContent);
        $this->assertStringContainsString('Kapan Harus Berkonsultasi ke Dokter Gigi', $smileScoreContent);
    }

    /**
     * 9. Halaman edukasi menyajikan 5 bagian terstruktur yang berorientasi pada pemahaman konsep personal.
     */
    public function test_education_page_renders_5_structured_learning_sections(): void
    {
        config(['services.gemini.api_key' => null]);
        $originalEnv = getenv('GEMINI_API_KEY');
        putenv('GEMINI_API_KEY=');

        try {
            $biodata = [
                'name' => 'Budi Santoso',
                'age' => 16,
                'gender' => 'Laki-laki',
                'class_name' => 'X Mesin 1',
            ];

            // 14 benar -> 70% Cukup
            $answers = [
                1 => 'b', 2 => 'c', 3 => 'c', 4 => 'b', 5 => 'd',
                6 => 'b', 7 => 'd', 8 => 'c', 9 => 'a', 10 => 'd',
                11 => 'c', 12 => 'a', 13 => 'a', 14 => 'a',
                15 => 'a', 16 => 'a', 17 => 'a', 18 => 'b', 19 => 'a', 20 => 'b',
            ];

            $service = app(\App\Services\SmileScoreService::class);
            $eval = $service->evaluateAnswers($answers);
            $eval['student'] = $biodata;

            session([
                'smile_score_biodata' => $biodata,
                'smile_score_result' => $eval,
            ]);

            $response = $this->get('/smile-score/edukasi');

            $response->assertStatus(200);

            // Bagian 1: Ringkasan hasil & Konteks literasi non-diagnosis
            $response->assertSee('Ringkasan Hasil Evaluasi');
            $response->assertSee('Evaluasi Literasi Pengetahuan');
            $response->assertSee('bukan merupakan diagnosis klinis');

            // Bagian 2: Materi yang Perlu Dipahami (Kartu Prioritas)
            $response->assertSee('Materi yang Perlu Dipahami');
            $response->assertSee('Konsep yang Perlu Dipahami:');
            $response->assertSee('Penjelasan Singkat:');
            $response->assertSee('Situasi Sehari-hari Siswa:');
            $response->assertSee('Hal yang Perlu Diingat:');

            // Bagian 3: Kebiasaan Sehat yang Bisa Diterapkan (Maksimal 3)
            $response->assertSee('Kebiasaan Sehat yang Bisa Diterapkan');
            $response->assertSee('3 tindakan praktis');

            // Bagian 4: Kapan Perlu Berkonsultasi
            $response->assertSee('Kapan Perlu Berkonsultasi ke Dokter Gigi?');

            // Bagian 5: Disclaimer Medis
            $response->assertSee('Pemberitahuan Edukasi Literasi');
            $response->assertSee('bukan merupakan diagnosis medis');
        } finally {
            if ($originalEnv !== false) {
                putenv("GEMINI_API_KEY={$originalEnv}");
            }
        }
    }

    /**
     * 10. Rate limiting regenerasi edukasi AI dibatasi maksimal 3 kali per sesi.
     */
    public function test_education_regeneration_rate_limiting_enforces_max_3_attempts(): void
    {
        // Mock Http agar tidak memanggil API aktual
        \Illuminate\Support\Facades\Http::fake([
            'generativelanguage.googleapis.com/*' => \Illuminate\Support\Facades\Http::response([
                'candidates' => [
                    [
                        'content' => [
                            'parts' => [
                                ['text' => json_encode([
                                    'introduction' => 'Intro edukasi AI hasil regenerasi.',
                                    'score_interpretation' => 'Interpretasi skor AI.',
                                    'priority_topics' => [
                                        [
                                            'title' => 'Topik Regenerasi AI',
                                            'core_concept' => 'Konsep inti.',
                                            'explanation' => 'Penjelasan.',
                                            'daily_context' => 'Konteks.',
                                            'remember_point' => 'Ingat ini.'
                                        ]
                                    ],
                                    'key_points' => ['Poin 1'],
                                    'daily_habits' => ['Kebiasaan 1', 'Kebiasaan 2'],
                                    'when_to_seek_care' => 'Periksa rutin.'
                                ])]
                            ]
                        ]
                    ]
                ]
            ], 200)
        ]);

        config(['services.gemini.api_key' => 'fake-api-key']);

        $eval = [
            'correct_count' => 15,
            'percentage' => 75,
            'category' => 'Cukup',
            'emoji' => '😉',
            'incorrect_items' => []
        ];

        session(['smile_score_result' => $eval]);

        // Percobaan 1: Berhasil
        $res1 = $this->post('/smile-score/edukasi/regenerate');
        $res1->assertStatus(302);
        $res1->assertSessionHas('success');
        $this->assertEquals(1, session('ai_regen_count'));

        // Percobaan 2: Berhasil
        $res2 = $this->post('/smile-score/edukasi/regenerate');
        $res2->assertStatus(302);
        $res2->assertSessionHas('success');
        $this->assertEquals(2, session('ai_regen_count'));

        // Percobaan 3: Berhasil (Batas Maksimal)
        $res3 = $this->post('/smile-score/edukasi/regenerate');
        $res3->assertStatus(302);
        $res3->assertSessionHas('success');
        $this->assertEquals(3, session('ai_regen_count'));

        // Percobaan 4: Ditolak oleh Rate Limit!
        $res4 = $this->post('/smile-score/edukasi/regenerate');
        $res4->assertStatus(302);
        $res4->assertSessionHas('warning');
        $this->assertStringContainsString('Batas percobaan pembuatan ulang AI telah tercapai', session('warning'));
        $this->assertEquals(3, session('ai_regen_count'));
    }

    /**
     * 11. Edukasi yang sudah tersimpan di database dimuat kembali dari cache tanpa re-generate.
     */
    public function test_education_caches_in_database_and_returns_on_subsequent_visits(): void
    {
        $cachedPayload = [
            'source' => 'ai',
            'title' => 'Edukasi Tersimpan dari Database',
            'introduction' => 'Intro yang tersimpan di database.',
            'score_interpretation' => 'Interpretasi tersimpan.',
            'priority_topics' => [
                [
                    'title' => 'Topik Cache Database',
                    'core_concept' => 'Konsep dari cache DB.',
                    'explanation' => 'Penjelasan dari cache DB.',
                    'daily_context' => 'Konteks harian cache DB.',
                    'remember_point' => 'Poin ingat cache DB.',
                    'relevance' => 'Konsep dari cache DB.',
                ]
            ],
            'key_points' => ['Poin penting cache'],
            'daily_habits' => ['Kebiasaan cache 1', 'Kebiasaan cache 2'],
            'when_to_seek_care' => 'Kapan ke dokter gigi dari cache DB.',
            'disclaimer' => 'Disclaimer dari cache DB.',
        ];

        $submission = SmileScoreSubmission::create([
            'name' => 'Citra Lestari',
            'age' => 17,
            'gender' => 'Perempuan',
            'class_name' => 'XII Akuntansi',
            'answers' => [1 => 'b', 2 => 'c'],
            'correct_count' => 18,
            'percentage' => 90,
            'category' => 'Baik',
            'emoji' => '😍',
            'status' => 'completed',
            'answered_count' => 20,
            'ai_education' => $cachedPayload,
            'ai_education_source' => 'ai',
        ]);

        $eval = [
            'correct_count' => 18,
            'percentage' => 90,
            'category' => 'Baik',
            'emoji' => '😍',
            'incorrect_items' => [],
            'student' => [
                'name' => 'Citra Lestari',
                'class_name' => 'XII Akuntansi',
            ]
        ];

        session([
            'smile_score_result' => $eval,
            'smile_score_submission_id' => $submission->id,
        ]);

        $response = $this->get('/smile-score/edukasi');

        $response->assertStatus(200);
        $response->assertSee('Topik Cache Database');
        $response->assertSee('Konsep dari cache DB.');
        $response->assertSee('Intro yang tersimpan di database.');
    }

    /**
     * 12. Cache ai_failed tidak memicu panggilan Gemini ulang saat GET /edukasi di-refresh.
     *     Halaman tetap menampilkan status (bukan error 500) tanpa memanggil API.
     */
    public function test_ai_failed_cache_does_not_retry_gemini_on_get_refresh(): void
    {
        // Http::fake kosong: jika Gemini dipanggil, test akan gagal karena tidak ada respons terdaftar
        \Illuminate\Support\Facades\Http::fake([]);

        $cachedFailed = [
            'source'    => 'ai_failed',
            'title'     => 'Edukasi AI Belum Tersedia',
            'error'     => 'Gemini API mengembalikan HTTP 429',
            'failed_at' => now()->toISOString(),
        ];

        $submission = SmileScoreSubmission::create([
            'name'          => 'Uji Retry',
            'age'           => 16,
            'gender'        => 'Laki-laki',
            'class_name'    => 'X TKJ',
            'answers'       => [1 => 'a'],
            'correct_count' => 10,
            'percentage'    => 50,
            'category'      => 'Kurang baik',
            'emoji'         => '🤨',
            'status'        => 'completed',
            'answered_count'=> 20,
            'ai_education'  => $cachedFailed,
            'ai_education_source' => 'ai_failed',
        ]);

        $eval = [
            'correct_count'  => 10,
            'percentage'     => 50,
            'category'       => 'Kurang baik',
            'emoji'          => '🤨',
            'incorrect_items'=> [],
        ];

        session([
            'smile_score_result'        => $eval,
            'smile_score_submission_id' => $submission->id,
        ]);

        // Kunjungi halaman edukasi (GET) — seharusnya TIDAK memanggil Gemini
        $response = $this->get('/smile-score/edukasi');
        $response->assertStatus(200);

        // Http::fake tidak boleh menerima panggilan; jika ada panggilan maka assertSentCount gagal
        \Illuminate\Support\Facades\Http::assertNothingSent();

        // Pastikan database tidak diubah (cache ai_failed tetap)
        $this->assertDatabaseHas('smile_score_submissions', [
            'id'                  => $submission->id,
            'ai_education_source' => 'ai_failed',
        ]);
    }

    /**
     * 13. Saat Gemini gagal (HTTP 429), sistem menampilkan fallback rule-based otomatis.
     *     source disimpan sebagai 'rule_based_fallback' di database.
     */
    public function test_gemini_failure_activates_rule_based_fallback_automatically(): void
    {
        \Illuminate\Support\Facades\Http::fake([
            'generativelanguage.googleapis.com/*' => \Illuminate\Support\Facades\Http::response('Rate limit exceeded', 429),
        ]);

        config(['services.gemini.api_key' => 'fake-api-key-for-fallback-test']);

        $answers = [
            1 => 'b', 2 => 'c', 3 => 'c', 4 => 'b', 5 => 'd',
            6 => 'b', 7 => 'd', 8 => 'c', 9 => 'a', 10 => 'd',
            11 => 'a', 12 => 'b', 13 => 'b', 14 => 'b', 15 => 'a',
            16 => 'a', 17 => 'a', 18 => 'b', 19 => 'a', 20 => 'b',
        ];

        $service = app(\App\Services\SmileScoreService::class);
        $eval    = $service->evaluateAnswers($answers);

        $submission = SmileScoreSubmission::create([
            'name'          => 'Uji Fallback 429',
            'age'           => 17,
            'gender'        => 'Perempuan',
            'class_name'    => 'XI AK',
            'answers'       => $answers,
            'correct_count' => $eval['correct_count'],
            'percentage'    => $eval['percentage'],
            'category'      => $eval['category'],
            'emoji'         => $eval['emoji'],
            'status'        => 'completed',
            'answered_count'=> 20,
        ]);

        $eval['student'] = ['name' => 'Uji Fallback 429', 'class_name' => 'XI AK', 'age' => 17, 'gender' => 'Perempuan'];

        session([
            'smile_score_result'        => $eval,
            'smile_score_submission_id' => $submission->id,
        ]);

        $response = $this->get('/smile-score/edukasi');
        $response->assertStatus(200);

        // Konten edukasi rule-based HARUS tampil (bukan halaman kosong)
        $response->assertSee('Materi yang Perlu Dipahami');
        $response->assertSee('Kebiasaan Sehat yang Bisa Diterapkan');

        // Badge fallback harus tampil
        $response->assertSee('Mode Cadangan Otomatis');

        // Database harus menyimpan source 'rule_based_fallback'
        $this->assertDatabaseHas('smile_score_submissions', [
            'id'                  => $submission->id,
            'ai_education_source' => 'rule_based_fallback',
        ]);

        // Refresh kedua TIDAK boleh memanggil Gemini lagi (gunakan cache)
        \Illuminate\Support\Facades\Http::fake([]);
        $response2 = $this->get('/smile-score/edukasi');
        $response2->assertStatus(200);
        \Illuminate\Support\Facades\Http::assertNothingSent();
    }

    /**
     * 14. Halaman edukasi dengan source 'rule_based_fallback' menampilkan 5 bagian konten lengkap.
     */
    public function test_education_page_renders_full_content_for_rule_based_fallback(): void
    {
        $fallbackPayload = [
            'source'               => 'rule_based_fallback',
            'title'                => 'Edukasi Kesehatan Gigi & Mulut',
            'introduction'         => 'Intro dari fallback rule-based.',
            'score_interpretation' => 'Interpretasi dari fallback.',
            'priority_topics'      => [
                [
                    'title'          => 'Topik Fallback Rule-Based',
                    'core_concept'   => 'Konsep inti fallback.',
                    'explanation'    => 'Penjelasan fallback.',
                    'daily_context'  => 'Konteks sehari-hari fallback.',
                    'remember_point' => 'Ingat ini fallback.',
                    'relevance'      => 'Konsep inti fallback.',
                ],
            ],
            'key_points'           => ['Poin fallback 1', 'Poin fallback 2'],
            'daily_habits'         => ['Kebiasaan fallback 1', 'Kebiasaan fallback 2', 'Kebiasaan fallback 3'],
            'when_to_seek_care'    => 'Panduan konsultasi dari fallback.',
            'disclaimer'           => 'Disclaimer fallback.',
            'ai_error'             => 'Gemini API mengembalikan HTTP 429',
            'failed_at'            => now()->toISOString(),
        ];

        $submission = SmileScoreSubmission::create([
            'name'                => 'Uji Render Fallback',
            'age'                 => 16,
            'gender'              => 'Laki-laki',
            'class_name'          => 'X TKJ 2',
            'answers'             => [1 => 'b'],
            'correct_count'       => 12,
            'percentage'          => 60,
            'category'            => 'Cukup',
            'emoji'               => '😉',
            'status'              => 'completed',
            'answered_count'      => 20,
            'ai_education'        => $fallbackPayload,
            'ai_education_source' => 'rule_based_fallback',
        ]);

        $eval = [
            'correct_count'  => 12,
            'percentage'     => 60,
            'category'       => 'Cukup',
            'emoji'          => '😉',
            'incorrect_items'=> [],
            'student'        => ['name' => 'Uji Render Fallback', 'class_name' => 'X TKJ 2'],
        ];

        session([
            'smile_score_result'        => $eval,
            'smile_score_submission_id' => $submission->id,
        ]);

        $response = $this->get('/smile-score/edukasi');
        $response->assertStatus(200);

        // Badge mode cadangan harus tampil
        $response->assertSee('Mode Cadangan Otomatis');

        // Konten 5 bagian harus tampil
        $response->assertSee('Topik Fallback Rule-Based');
        $response->assertSee('Intro dari fallback rule-based.');
        $response->assertSee('Kebiasaan Sehat yang Bisa Diterapkan');
        $response->assertSee('Kapan Perlu Berkonsultasi ke Dokter Gigi?');
        $response->assertSee('Pemberitahuan Edukasi Literasi');
    }
}

