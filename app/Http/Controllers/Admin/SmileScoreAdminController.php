<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SmileScoreSubmission;
use App\Services\SmileScoreExportService;
use App\Services\SmileScoreService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SmileScoreAdminController extends Controller
{
    protected SmileScoreService $questionnaireService;
    protected SmileScoreExportService $exportService;

    public function __construct(
        SmileScoreService $questionnaireService,
        SmileScoreExportService $exportService
    ) {
        $this->questionnaireService = $questionnaireService;
        $this->exportService = $exportService;
    }

    /**
     * Dashboard Data Responden: Ringkasan statistik, filter, pencarian, dan tabel paginasi.
     */
    public function index(Request $request)
    {
        // 1. Ringkasan Statistik Aktual dari Database
        $totalRespondents = SmileScoreSubmission::count();
        $totalCompleted = SmileScoreSubmission::where('status', 'completed')->count();
        $totalInProgress = SmileScoreSubmission::where('status', 'in_progress')->count();

        // Distribusi Kategori Smile Score (hanya dari yang telah selesai)
        $countBaik = SmileScoreSubmission::where('status', 'completed')->where('category', 'Baik')->count();
        $countCukup = SmileScoreSubmission::where('status', 'completed')->where('category', 'Cukup')->count();
        $countKurang = SmileScoreSubmission::where('status', 'completed')
            ->whereIn('category', ['Kurang baik', 'Kurang'])
            ->count();

        // Jumlah pengerjaan berdasarkan periode
        $countToday = SmileScoreSubmission::whereDate('created_at', today())->count();
        $countThisWeek = SmileScoreSubmission::where('created_at', '>=', now()->startOfWeek())->count();

        // 2. Query Data Responden dengan Filter
        $query = SmileScoreSubmission::query()->latest('id');

        $this->applyFilters($query, $request);

        $submissions = $query->paginate(15)->withQueryString();

        // Ambil daftar kelas unik untuk dropdown filter
        $availableClasses = SmileScoreSubmission::select('class_name')
            ->distinct()
            ->whereNotNull('class_name')
            ->where('class_name', '!=', '')
            ->orderBy('class_name')
            ->pluck('class_name');

        return view('admin.dashboard', compact(
            'submissions',
            'totalRespondents',
            'totalCompleted',
            'totalInProgress',
            'countBaik',
            'countCukup',
            'countKurang',
            'countToday',
            'countThisWeek',
            'availableClasses'
        ));
    }

    /**
     * Halaman Detail Responden: Biodata, Ringkasan Hasil, dan Rincian 20 Jawaban Soal.
     */
    public function detail($id)
    {
        $submission = SmileScoreSubmission::findOrFail($id);
        $masterQuestions = $this->questionnaireService->getQuestionsForDisplay();
        $userAnswers = is_array($submission->answers) ? $submission->answers : [];

        // Kunci jawaban resmi (hanya diakses di admin)
        $answerKeys = [
            1 => 'b', 2 => 'c', 3 => 'c', 4 => 'b', 5 => 'd',
            6 => 'b', 7 => 'd', 8 => 'c', 9 => 'a', 10 => 'd',
            11 => 'c', 12 => 'a', 13 => 'a', 14 => 'a', 15 => 'd',
            16 => 'b', 17 => 'c', 18 => 'a', 19 => 'b', 20 => 'a',
        ];

        // Susun rincian 20 pertanyaan
        $questionDetails = [];
        $isCompleted = ($submission->status === 'completed');

        foreach ($masterQuestions as $q) {
            $qNum = $q['id'];
            $selectedOpt = isset($userAnswers[$qNum]) ? strtolower(trim((string) $userAnswers[$qNum])) : null;
            $correctOpt = $answerKeys[$qNum] ?? null;

            $hasAnswered = ($selectedOpt !== null && $selectedOpt !== '');
            $isCorrect = ($hasAnswered && $selectedOpt === $correctOpt);

            $questionDetails[] = [
                'number' => $qNum,
                'question' => $q['question'],
                'topic' => $q['topic'],
                'options' => $q['options'],
                'selected_option' => $selectedOpt,
                'selected_text' => $selectedOpt ? ($q['options'][$selectedOpt] ?? '-') : null,
                'correct_option' => $correctOpt,
                'correct_text' => $correctOpt ? ($q['options'][$correctOpt] ?? '-') : null,
                'has_answered' => $hasAnswered,
                'is_correct' => $isCorrect,
            ];
        }

        return view('admin.detail', compact('submission', 'questionDetails', 'isCompleted'));
    }

    /**
     * Ekspor Data Responden dan Hasil Kuesioner ke Excel (.xlsx) atau CSV (.csv).
     */
    public function export(Request $request)
    {
        $format = $request->input('format', 'xlsx');
        $scope = $request->input('scope', 'filtered'); // filtered | all | completed

        $query = SmileScoreSubmission::query()->orderBy('id');

        if ($scope === 'completed') {
            $query->where('status', 'completed');
        } elseif ($scope === 'filtered') {
            $this->applyFilters($query, $request);
        }
        // jika scope === 'all', seluruh data tanpa filter

        $submissions = $query->get();

        $today = now()->format('Y-m-d');

        if ($format === 'csv') {
            $filename = "smile_score_data_responden_{$today}.csv";
            return $this->exportService->exportCsv($submissions, $filename);
        }

        // Default: Excel (.xlsx)
        $filename = "smile_score_data_responden_{$today}.xlsx";
        return $this->exportService->exportExcel($submissions, $filename);
    }

    /**
     * Terapkan filter pencarian pada query Eloquent.
     */
    protected function applyFilters($query, Request $request): void
    {
        // 1. Pencarian Nama
        if ($request->filled('search')) {
            $search = trim($request->input('search'));
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('id', 'like', "%{$search}%");
            });
        }

        // 2. Filter Kelas
        if ($request->filled('class_name')) {
            $query->where('class_name', $request->input('class_name'));
        }

        // 3. Filter Jenis Kelamin
        if ($request->filled('gender')) {
            $query->where('gender', $request->input('gender'));
        }

        // 4. Filter Kategori Skor
        if ($request->filled('category')) {
            $cat = $request->input('category');
            if ($cat === 'Kurang baik') {
                $query->whereIn('category', ['Kurang baik', 'Kurang']);
            } else {
                $query->where('category', $cat);
            }
        }

        // 5. Filter Status Pengerjaan
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        // 6. Filter Rentang Tanggal
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->input('date_from'));
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->input('date_to'));
        }
    }

    /**
     * Hapus satu data responden tertentu beserta seluruh jawabannya.
     */
    public function destroy($id)
    {
        $submission = SmileScoreSubmission::findOrFail($id);
        $name = $submission->name;
        $formattedId = $submission->formatted_id;

        try {
            DB::transaction(function () use ($submission) {
                $submission->delete();
            });

            Log::info("Admin ID " . (Auth::id() ?? '-') . " berhasil menghapus responden: {$formattedId} (ID Database: {$id}).");

            return redirect()->route('admin.responden')
                ->with('success', "Data responden {$name} ({$formattedId}) berhasil dihapus dari sistem.");
        } catch (\Throwable $e) {
            Log::error("Gagal menghapus data responden ID {$id}: " . $e->getMessage());

            return redirect()->back()
                ->with('error', 'Terjadi kesalahan sistem saat menghapus data responden. Silakan coba kembali.');
        }
    }

    /**
     * Hapus seluruh data responden untuk memulai siklus pengujian atau penelitian baru.
     * Memerlukan konfirmasi teks eksplisit 'HAPUS DATA RESPONDEN'.
     */
    public function destroyAll(Request $request)
    {
        $request->validate([
            'confirmation_text' => [
                'required',
                'string',
                function ($attribute, $value, $fail) {
                    if (trim((string) $value) !== 'HAPUS DATA RESPONDEN') {
                        $fail('Teks konfirmasi tidak sesuai. Harap ketik "HAPUS DATA RESPONDEN" dengan benar.');
                    }
                },
            ],
        ], [
            'confirmation_text.required' => 'Teks konfirmasi wajib diisi untuk melakukan pembersihan seluruh data responden.',
        ]);

        $totalCount = SmileScoreSubmission::count();

        if ($totalCount === 0) {
            return redirect()->route('admin.responden')
                ->with('info', 'Tidak ada data responden yang dapat dihapus.');
        }

        try {
            DB::transaction(function () {
                SmileScoreSubmission::query()->delete();
            });

            Log::info("Admin ID " . (Auth::id() ?? '-') . " membersihkan seluruh data responden ({$totalCount} record terhapus).");

            return redirect()->route('admin.responden')
                ->with('success', "Seluruh data responden ({$totalCount} data) berhasil dibersihkan dari sistem. Sistem siap untuk pengujian/penelitian baru.");
        } catch (\Throwable $e) {
            Log::error("Gagal membersihkan seluruh data responden: " . $e->getMessage());

            return redirect()->back()
                ->with('error', 'Terjadi kesalahan sistem saat membersihkan data responden. Silakan coba kembali.');
        }
    }
}
