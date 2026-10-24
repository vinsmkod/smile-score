<?php

namespace Tests\Feature;

use App\Models\SmileScoreSubmission;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SmileScoreAdminTest extends TestCase
{
    use RefreshDatabase;

    protected User $adminUser;

    protected function setUp(): void
    {
        parent::setUp();

        $this->adminUser = User::factory()->create([
            'email' => 'admin@smilescore.id',
            'name' => 'Admin Penguji',
        ]);
    }

    /**
     * 1. Pengguna tanpa hak admin (tamu) diblokir dari dashboard, detail, dan ekspor (harus dialihkan ke login).
     */
    public function test_unauthenticated_user_cannot_access_admin_routes(): void
    {
        $this->get('/admin')->assertRedirect('/login');
        $this->get('/admin/responden/1')->assertRedirect('/login');
        $this->get('/admin/export?format=xlsx')->assertRedirect('/login');
        $this->get('/admin/export?format=csv')->assertRedirect('/login');
    }

    /**
     * 2. Admin dapat login dengan kredensial yang benar dan masuk ke dashboard.
     */
    public function test_admin_can_login_and_access_dashboard(): void
    {
        $response = $this->post('/admin/login', [
            'email' => 'admin@smilescore.id',
            'password' => 'password', // default factory password
        ]);

        $response->assertStatus(302);
        $response->assertRedirect('/admin');
        $this->assertAuthenticatedAs($this->adminUser);

        $dashResponse = $this->get('/admin');
        $dashResponse->assertStatus(200);
        $dashResponse->assertSee('Data Responden Penelitian');
        $dashResponse->assertSee('Total Responden');
    }

    /**
     * 3. Admin dapat melihat data responden aktual yang tersimpan di database.
     */
    public function test_admin_can_view_actual_respondent_records(): void
    {
        $sub = SmileScoreSubmission::create([
            'name' => 'Budi Santoso',
            'age' => 16,
            'gender' => 'Laki-laki',
            'class_name' => 'X Mesin 1',
            'answers' => [1 => 'b', 2 => 'c', 3 => 'c', 4 => 'b', 5 => 'd'],
            'correct_count' => 18,
            'percentage' => 90,
            'category' => 'Baik',
            'emoji' => '😍',
            'status' => 'completed',
            'answered_count' => 20,
            'started_at' => now()->subMinutes(10),
            'completed_at' => now(),
        ]);

        $response = $this->actingAs($this->adminUser)->get('/admin');

        $response->assertStatus(200);
        $response->assertSee('Budi Santoso');
        $response->assertSee('X Mesin 1');
        $response->assertSee('18');
        $response->assertSee('90%');
        $response->assertSee('Baik');
        $response->assertSee('Selesai');
    }

    /**
     * 4. Halaman detail responden menampilkan biodata lengkap, rekap skor, dan rincian 20 butir soal beserta kunci jawaban.
     */
    public function test_admin_can_view_respondent_detail_and_20_questions(): void
    {
        // Jawaban 1 benar ('b'), soal 2 salah ('a', kunci 'c')
        $sub = SmileScoreSubmission::create([
            'name' => 'Dewi Lestari',
            'age' => 17,
            'gender' => 'Perempuan',
            'class_name' => 'XI Akuntansi',
            'answers' => [1 => 'b', 2 => 'a'],
            'correct_count' => 14,
            'percentage' => 70,
            'category' => 'Cukup',
            'emoji' => '😉',
            'status' => 'completed',
            'answered_count' => 20,
            'started_at' => now()->subMinutes(5),
            'completed_at' => now(),
        ]);

        $response = $this->actingAs($this->adminUser)->get("/admin/responden/{$sub->id}");

        $response->assertStatus(200);
        $response->assertSee('Dewi Lestari');
        $response->assertSee('XI Akuntansi');
        $response->assertSee('70%');
        $response->assertSee('Cukup');
        $response->assertSee('Rincian Jawaban 20 Soal Kuesioner');
        $response->assertSee('Kunci Jawaban Resmi');
        // Pastikan nomor soal 1 dan 20 ada
        $response->assertSee('Gigi berlubang adalah kerusakan jaringan keras gigi yang terutama disebabkan oleh');
        $response->assertSee('Jenis kepala dan bulu sikat gigi yang disarankan adalah');
    }

    /**
     * 5. Jawaban kosong (in_progress) dibedakan dari jawaban salah dan tidak dianggap sebagai hasil final.
     */
    public function test_in_progress_submission_is_not_treated_as_completed(): void
    {
        $inProgress = SmileScoreSubmission::create([
            'name' => 'Reza Rahardian',
            'age' => 16,
            'gender' => 'Laki-laki',
            'class_name' => 'X Otomotif',
            'answers' => [], // Belum jawab
            'correct_count' => 0,
            'percentage' => 0,
            'category' => 'Belum Selesai',
            'emoji' => '⏳',
            'status' => 'in_progress',
            'answered_count' => 0,
            'started_at' => now(),
            'completed_at' => null,
        ]);

        // Verifikasi pada dashboard
        $dash = $this->actingAs($this->adminUser)->get('/admin');
        $dash->assertStatus(200);
        $dash->assertSee('Reza Rahardian');
        $dash->assertSee('Belum Selesai');

        // Verifikasi pada detail
        $detail = $this->actingAs($this->adminUser)->get("/admin/responden/{$inProgress->id}");
        $detail->assertStatus(200);
        $detail->assertSee('Belum Selesai (Draft)');
        $detail->assertSee('Belum Dijawab');
    }

    /**
     * 6. Filter pencarian dan kategori pada admin berfungsi akurat.
     */
    public function test_admin_filtering_by_name_class_and_category(): void
    {
        SmileScoreSubmission::create([
            'name' => 'Rina Nose',
            'age' => 16,
            'gender' => 'Perempuan',
            'class_name' => 'X Tata Boga',
            'answers' => [],
            'correct_count' => 19,
            'percentage' => 95,
            'category' => 'Baik',
            'emoji' => '😍',
            'status' => 'completed',
            'answered_count' => 20,
        ]);

        SmileScoreSubmission::create([
            'name' => 'Sule Prikitiew',
            'age' => 17,
            'gender' => 'Laki-laki',
            'class_name' => 'XI Listrik',
            'answers' => [],
            'correct_count' => 8,
            'percentage' => 40,
            'category' => 'Kurang baik',
            'emoji' => '🤨',
            'status' => 'completed',
            'answered_count' => 20,
        ]);

        // Filter nama "Rina"
        $filter1 = $this->actingAs($this->adminUser)->get('/admin?search=Rina');
        $filter1->assertSee('Rina Nose');
        $filter1->assertDontSee('Sule Prikitiew');

        // Filter kategori "Kurang baik"
        $filter2 = $this->actingAs($this->adminUser)->get('/admin?category=Kurang+baik');
        $filter2->assertSee('Sule Prikitiew');
        $filter2->assertDontSee('Rina Nose');
    }

    /**
     * 7. Ekspor CSV menghasilkan response 200, UTF-8 BOM, header kolom lengkap, dan data tersanitasi.
     */
    public function test_admin_can_export_csv(): void
    {
        SmileScoreSubmission::create([
            'name' => '=Sum(1,2)', // uji formula injection
            'age' => 16,
            'gender' => 'Laki-laki',
            'class_name' => 'X RPL',
            'answers' => [1 => 'b', 2 => 'c'],
            'correct_count' => 16,
            'percentage' => 80,
            'category' => 'Baik',
            'emoji' => '😍',
            'status' => 'completed',
            'answered_count' => 20,
        ]);

        $response = $this->actingAs($this->adminUser)->get('/admin/export?format=csv&scope=all');

        $response->assertStatus(200);
        $this->assertEquals('text/csv; charset=UTF-8', $response->headers->get('Content-Type'));
        $this->assertStringContainsString('smile_score_data_responden_', $response->headers->get('Content-Disposition'));

        // Ambil stream output CSV
        ob_start();
        $response->sendContent();
        $csvContent = ob_get_clean();

        // Pastikan ada UTF-8 BOM
        $this->assertStringStartsWith("\xEF\xBB\xBF", $csvContent);
        // Header kolom CSV
        $this->assertStringContainsString('respondent_id,nama_lengkap,usia,jenis_kelamin,kelas', $csvContent);
        $this->assertStringContainsString('Q01,Q02', $csvContent);
        $this->assertStringContainsString('Q01_correct,Q02_correct', $csvContent);
        $this->assertStringContainsString('kode_kategori_spss', $csvContent);

        // Pastikan formula injection disanitasi dengan tanda petik '
        $this->assertStringContainsString("\"'=Sum(1,2)\"", $csvContent);
    }

    /**
     * 8. Ekspor Excel (.xlsx) menghasilkan response 200 dengan Content-Type XLSX dan valid ZIP structure.
     */
    public function test_admin_can_export_excel_xlsx(): void
    {
        SmileScoreSubmission::create([
            'name' => 'Siswa Penguji Excel',
            'age' => 16,
            'gender' => 'Perempuan',
            'class_name' => 'X Kimia',
            'answers' => [1 => 'b', 2 => 'c', 3 => 'c'],
            'correct_count' => 17,
            'percentage' => 85,
            'category' => 'Baik',
            'emoji' => '😍',
            'status' => 'completed',
            'answered_count' => 20,
        ]);

        $response = $this->actingAs($this->adminUser)->get('/admin/export?format=xlsx&scope=all');

        $response->assertStatus(200);
        $this->assertEquals(
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            $response->headers->get('Content-Type')
        );
        $this->assertStringContainsString('.xlsx', $response->headers->get('Content-Disposition'));

        // Cek struktur ZIP OpenXML
        ob_start();
        $response->sendContent();
        $xlsxContent = ob_get_clean();

        // PK\x03\x04 adalah signature magic bytes file ZIP/XLSX
        $this->assertStringStartsWith("PK\x03\x04", $xlsxContent);
    }

    /**
     * 9. Ekspor tidak mengubah atau menghapus data asli dalam database.
     */
    public function test_export_does_not_mutate_or_delete_database(): void
    {
        $initialCount = SmileScoreSubmission::count();

        $this->actingAs($this->adminUser)->get('/admin/export?format=csv');
        $this->actingAs($this->adminUser)->get('/admin/export?format=xlsx');

        $this->assertEquals($initialCount, SmileScoreSubmission::count());
    }
}
