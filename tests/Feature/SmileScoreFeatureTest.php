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
    }
}
