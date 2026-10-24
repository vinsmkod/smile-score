<?php

namespace App\Http\Controllers;

use App\Models\SmileScoreSubmission;
use App\Services\SmileScoreService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SmileScoreController extends Controller
{
    protected SmileScoreService $service;

    public function __construct(SmileScoreService $service)
    {
        $this->service = $service;
    }

    /**
     * Tahap 01: Tampilkan form biodata siswa sebelum masuk ke kuesioner.
     */
    public function biodataForm(Request $request)
    {
        $savedBiodata = $request->session()->get('smile_score_biodata', []);
        return view('smile-score.biodata', compact('savedBiodata'));
    }

    /**
     * Proses dan validasi pengisian biodata siswa.
     */
    public function saveBiodata(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'min:2', 'max:100', 'regex:/[a-zA-Z]/'],
            'age' => ['required', 'integer', 'between:12,25'],
            'gender' => ['required', 'in:Laki-laki,Perempuan'],
            'class_name' => ['required', 'string', 'min:1', 'max:50'],
        ], [
            'name.required' => 'Nama Lengkap wajib diisi.',
            'name.min' => 'Nama Lengkap minimal terdiri dari 2 karakter.',
            'name.max' => 'Nama Lengkap maksimal 100 karakter.',
            'name.regex' => 'Nama Lengkap tidak boleh hanya berisi spasi atau karakter tidak valid.',
            'age.required' => 'Usia wajib diisi.',
            'age.integer' => 'Usia harus berupa bilangan bulat positif.',
            'age.between' => 'Usia harus dalam rentang usia wajar siswa SMK (12-25 tahun).',
            'gender.required' => 'Jenis Kelamin wajib dipilih.',
            'gender.in' => 'Pilihan jenis kelamin harus Laki-laki atau Perempuan.',
            'class_name.required' => 'Kelas wajib diisi.',
            'class_name.max' => 'Kelas maksimal 50 karakter.',
        ]);

        $biodata = [
            'name' => trim($validated['name']),
            'age' => (int) $validated['age'],
            'gender' => $validated['gender'],
            'class_name' => trim($validated['class_name']),
        ];

        // Simpan biodata di session
        $request->session()->put('smile_score_biodata', $biodata);

        // Catat pengerjaan in_progress ke database untuk pelacakan responden
        try {
            $existingId = $request->session()->get('smile_score_submission_id');
            $existing = $existingId ? SmileScoreSubmission::find($existingId) : null;

            if ($existing && $existing->status === 'in_progress') {
                $existing->update([
                    'name' => $biodata['name'],
                    'age' => $biodata['age'],
                    'gender' => $biodata['gender'],
                    'class_name' => $biodata['class_name'],
                ]);
            } else {
                $submission = SmileScoreSubmission::create([
                    'name' => $biodata['name'],
                    'age' => $biodata['age'],
                    'gender' => $biodata['gender'],
                    'class_name' => $biodata['class_name'],
                    'answers' => [],
                    'correct_count' => 0,
                    'percentage' => 0,
                    'category' => 'Belum Selesai',
                    'emoji' => '⏳',
                    'status' => 'in_progress',
                    'answered_count' => 0,
                    'test_type' => 'pre_test',
                    'session_id' => $request->session()->getId(),
                    'started_at' => now(),
                    'completed_at' => null,
                ]);
                $request->session()->put('smile_score_submission_id', $submission->id);
            }
        } catch (\Throwable $e) {
            Log::error('Gagal mencatat in_progress submission: ' . $e->getMessage());
        }

        return redirect()->route('smile-score.kuesioner');
    }

    /**
     * Tahap 02: Tampilkan halaman kuesioner 20 soal.
     * Route ini dilindungi: Siswa wajib memiliki biodata yang valid di session.
     */
    public function kuesioner(Request $request)
    {
        $biodata = $request->session()->get('smile_score_biodata');

        if (!$biodata) {
            return redirect()->route('smile-score.start')
                ->with('warning', 'Silakan lengkapi biodata siswa terlebih dahulu sebelum mengerjakan kuesioner.');
        }

        $questions = $this->service->getQuestionsForDisplay();
        return view('smile-score.index', compact('questions', 'biodata'));
    }

    /**
     * Proses jawaban 20 soal kuesioner dari siswa di backend.
     */
    public function submit(Request $request)
    {
        $biodata = $request->session()->get('smile_score_biodata');

        if (!$biodata) {
            return redirect()->route('smile-score.start')
                ->with('warning', 'Sesi biodata tidak ditemukan. Silakan isi kembali biodata siswa.');
        }

        // Validasi backend: Seluruh 20 soal harus dijawab
        $rules = [];
        $messages = [];
        for ($i = 1; $i <= 20; $i++) {
            $rules["answers.{$i}"] = ['required', 'string', 'in:a,b,c,d'];
            $messages["answers.{$i}.required"] = "Soal nomor {$i} belum dijawab. Mohon jawab semua soal.";
        }

        $validated = $request->validate($rules, $messages);

        // Hitung skor deterministik di backend
        $userAnswers = $validated['answers'] ?? [];
        $evaluation = $this->service->evaluateAnswers($userAnswers);

        // Hubungkan data biodata siswa dengan hasil evaluasi
        $evaluation['student'] = $biodata;

        // Simpan rekam data penelitian ke database
        try {
            $submissionId = $request->session()->get('smile_score_submission_id');
            $submission = $submissionId ? SmileScoreSubmission::find($submissionId) : null;

            if ($submission) {
                $submission->update([
                    'name' => $biodata['name'],
                    'age' => $biodata['age'],
                    'gender' => $biodata['gender'],
                    'class_name' => $biodata['class_name'],
                    'answers' => $userAnswers,
                    'correct_count' => $evaluation['correct_count'],
                    'percentage' => $evaluation['percentage'],
                    'category' => $evaluation['category'],
                    'emoji' => $evaluation['emoji'],
                    'status' => 'completed',
                    'answered_count' => 20,
                    'completed_at' => now(),
                ]);
            } else {
                $submission = SmileScoreSubmission::create([
                    'name' => $biodata['name'],
                    'age' => $biodata['age'],
                    'gender' => $biodata['gender'],
                    'class_name' => $biodata['class_name'],
                    'answers' => $userAnswers,
                    'correct_count' => $evaluation['correct_count'],
                    'percentage' => $evaluation['percentage'],
                    'category' => $evaluation['category'],
                    'emoji' => $evaluation['emoji'],
                    'status' => 'completed',
                    'answered_count' => 20,
                    'test_type' => 'pre_test',
                    'session_id' => $request->session()->getId(),
                    'started_at' => now(),
                    'completed_at' => now(),
                ]);
                $request->session()->put('smile_score_submission_id', $submission->id);
            }

            $evaluation['submission_id'] = $submission->id;
            $evaluation['formatted_id'] = $submission->formatted_id;
        } catch (\Throwable $e) {
            Log::error('Gagal menyimpan submission ke database: ' . $e->getMessage());
        }

        // Simpan hasil di session pengguna
        $request->session()->put('smile_score_result', $evaluation);

        return redirect()->route('smile-score.result');
    }

    /**
     * Tahap 03: Tampilkan halaman hasil Smile Score.
     */
    public function result(Request $request)
    {
        $result = $request->session()->get('smile_score_result');

        if (!$result) {
            return redirect()->route('smile-score.start')
                ->with('info', 'Silakan lengkapi biodata dan selesaikan kuesioner terlebih dahulu untuk melihat hasil Smile Score.');
        }

        return view('smile-score.result', compact('result'));
    }

    /**
     * Tampilkan detail hasil dan materi edukasi bertenaga AI / rule-based.
     * Menggunakan edukasi tersimpan di database jika sudah ada.
     */
    public function education(Request $request)
    {
        $result = $request->session()->get('smile_score_result');

        if (!$result) {
            return redirect()->route('smile-score.start')
                ->with('info', 'Silakan lengkapi biodata dan selesaikan kuesioner terlebih dahulu untuk melihat materi edukasi.');
        }

        // Ambil submissionId dari session untuk cache & penyimpanan
        $submissionId = $request->session()->get('smile_score_submission_id');

        // Hasilkan edukasi (akan menggunakan cache DB jika sudah ada)
        $education = $this->service->generateEducationContent($result, $submissionId);

        return view('smile-score.education', compact('result', 'education'));
    }

    /**
     * Coba buat ulang materi edukasi dari Gemini AI.
     * Hanya bisa dipanggil oleh siswa yang punya session result aktif.
     * Dibatasi 3 kali percobaan per session untuk mencegah pemborosan kuota.
     */
    public function regenerateEducation(Request $request)
    {
        $result = $request->session()->get('smile_score_result');

        if (!$result) {
            return redirect()->route('smile-score.start')
                ->with('info', 'Sesi tidak ditemukan. Silakan selesaikan kuesioner terlebih dahulu.');
        }

        // Rate limiting: max 3 regenerasi per session
        $regenCount = $request->session()->get('ai_regen_count', 0);
        if ($regenCount >= 3) {
            return redirect()->route('smile-score.education')
                ->with('warning', 'Batas percobaan pembuatan ulang AI telah tercapai (maks 3x per sesi). Silakan mulai kuesioner baru jika diperlukan.');
        }

        $submissionId = $request->session()->get('smile_score_submission_id');

        // Paksa regenerasi ke Gemini (abaikan cache)
        $education = $this->service->generateEducationContent($result, $submissionId, forceRegenerate: true);

        // Catat jumlah regenerasi
        $request->session()->put('ai_regen_count', $regenCount + 1);

        if (($education['source'] ?? '') === 'ai') {
            return redirect()->route('smile-score.education')
                ->with('success', 'Edukasi AI berhasil dibuat ulang!');
        }

        return redirect()->route('smile-score.education')
            ->with('warning', 'Pembuatan edukasi AI belum berhasil. ' . ($education['error'] ?? 'Silakan coba lagi beberapa saat.'));
    }
}
