<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SmileScoreService
{
    /**
     * Master data 20 kuesioner penelitian kesehatan gigi dan mulut.
     * Sumber: Dokumen Penelitian SMK Putra Nasional Cibodas.
     */
    protected array $questions = [
        1 => [
            'id' => 1,
            'question' => 'Gigi berlubang adalah kerusakan jaringan keras gigi yang terutama disebabkan oleh ...',
            'topic' => 'Penyebab Gigi Berlubang',
            'category_group' => 'Karies Gigi',
            'options' => [
                'a' => 'Gigi dan mulut yang jarang dibersihkan dalam kehidupan sehari-hari',
                'b' => 'Sisa makanan yang diubah bakteri menjadi asam melalui proses demineralisasi',
                'c' => 'Kebiasaan menggertakan gigi secara terus-menerus',
                'd' => 'Kebiasaan mengunyah makanan keras yang memicu keretakan struktur gigi',
            ],
            'correct' => 'b',
            'explanation' => 'Gigi berlubang (karies) terjadi ketika sisa makanan berkarbohidrat difermentasi oleh bakteri rongga mulut menjadi asam, yang melarutkan mineral enamel gigi (demineralisasi).',
        ],
        2 => [
            'id' => 2,
            'question' => 'Tanda-tanda gigi berlubang adalah ...',
            'topic' => 'Tanda Gigi Berlubang',
            'category_group' => 'Karies Gigi',
            'options' => [
                'a' => 'Gigi tertutup lapisan keras seperti kerak',
                'b' => 'Gusi menebal dan menutupi bagian gigi',
                'c' => 'Gigi berlubang dan berwarna cokelat atau hitam',
                'd' => 'Luka kecil berwarna putih kekuningan di mulut',
            ],
            'correct' => 'c',
            'explanation' => 'Tanda khas gigi berlubang adalah terlihatnya kavitas/lubang pada permukaan gigi yang berubah warna menjadi kecokelatan hingga kehitaman.',
        ],
        3 => [
            'id' => 3,
            'question' => 'Bagaimana cara mencegah terjadinya gigi berlubang?',
            'topic' => 'Pencegahan Gigi Berlubang',
            'category_group' => 'Karies Gigi',
            'options' => [
                'a' => 'Mengompres pipi dengan air hangat',
                'b' => 'Meminum obat pereda nyeri saat gigi sakit',
                'c' => 'Menyikat gigi dua kali sehari secara teratur',
                'd' => 'Beristirahat cukup agar tubuh tetap sehat',
            ],
            'correct' => 'c',
            'explanation' => 'Pencegahan paling mendasar dan terbukti efektif untuk gigi berlubang adalah menyikat gigi minimal 2 kali sehari secara teratur dengan pasta gigi berfluoride.',
        ],
        4 => [
            'id' => 4,
            'question' => 'Bagaimana cara penanganan yang tepat mengatasi gigi berlubang?',
            'topic' => 'Penanganan Gigi Berlubang',
            'category_group' => 'Karies Gigi',
            'options' => [
                'a' => 'Dibiarkan agar lubang gigi tertutup sendiri',
                'b' => 'Diperiksa dan ditambal oleh dokter gigi',
                'c' => 'Diberi pasta gigi lebih banyak saat sikat gigi',
                'd' => 'Dioleskan obat tradisional tanpa pemeriksaan',
            ],
            'correct' => 'b',
            'explanation' => 'Lubang gigi tidak dapat menutup atau sembuh dengan sendirinya; harus dibersihkan dari jaringan terinfeksi dan direstorasi (ditambal) oleh dokter gigi.',
        ],
        5 => [
            'id' => 5,
            'question' => 'Apa itu tambal gigi?',
            'topic' => 'Konsep Tambal Gigi',
            'category_group' => 'Perawatan Gigi',
            'options' => [
                'a' => 'Lapisan yang digunakan untuk mencegah gusi berdarah',
                'b' => 'Alat yang digunakan untuk mencabut gigi berlubang',
                'c' => 'Cairan yang digunakan untuk membersihkan gigi',
                'd' => 'Bahan pengisi gigi untuk melindunginya dari kerusakan',
            ],
            'correct' => 'd',
            'explanation' => 'Tambal gigi adalah prosedur penempatan bahan restorasi ke dalam kavitas gigi yang telah dibersihkan untuk mengembalikan fungsi kunyah dan menghentikan kerusakan lebih lanjut.',
        ],
        6 => [
            'id' => 6,
            'question' => 'Kapan gigi perlu ditambal akibat gigi berlubang?',
            'topic' => 'Indikasi Tambal Gigi',
            'category_group' => 'Perawatan Gigi',
            'options' => [
                'a' => 'Saat gigi terasa bersih setelah disikat',
                'b' => 'Saat gigi terlihat berlubang dan terasa nyeri',
                'c' => 'Saat gusi terlihat merah muda dan sehat',
                'd' => 'Saat gigi terasa kuat saat digunakan makan',
            ],
            'correct' => 'b',
            'explanation' => 'Tambal gigi harus dilakukan sedini mungkin ketika tampak lubang dan mulai muncul rasa linu atau nyeri sebelum mencapai pulpa/saraf gigi.',
        ],
        7 => [
            'id' => 7,
            'question' => 'Apa yang dapat terjadi jika gigi berlubang tidak segera ditangani?',
            'topic' => 'Akibat Gigi Berlubang',
            'category_group' => 'Karies Gigi',
            'options' => [
                'a' => 'Gigi menjadi rapuh dan mudah patah',
                'b' => 'Gigi terkikis lebih tipis dan menjadi sensitif',
                'c' => 'Gigi maju ke depan sehingga menjadi tonggos',
                'd' => 'Gigi menjadi sakit dan lubang semakin besar',
            ],
            'correct' => 'd',
            'explanation' => 'Jika gigi berlubang diabaikan, bakteri akan terus mengikis jaringan keras gigi hingga infeksi menyentuh saraf, menimbulkan sakit hebat, pembengkakan, bahkan abses.',
        ],
        8 => [
            'id' => 8,
            'question' => 'Radang gusi umumnya disebabkan oleh ...',
            'topic' => 'Penyebab Radang Gusi',
            'category_group' => 'Kesehatan Gusi',
            'options' => [
                'a' => 'Kebiasaan mengunyah di satu sisi rahang',
                'b' => 'Kebiasaan sering menggigit-gigit bibir',
                'c' => 'Penumpukan plak dan sisa makanan di tepi gusi',
                'd' => 'Kebiasaan mengonsumsi makanan manis dan lengket',
            ],
            'correct' => 'c',
            'explanation' => 'Gingivitis (radang gusi) utamanya dipicu oleh penumpukan plak (lapisan lengket berisi koloni bakteri) yang tertinggal di perbatasan gigi dan gusi.',
        ],
        9 => [
            'id' => 9,
            'question' => 'Ciri-ciri radang gusi adalah ...',
            'topic' => 'Tanda Radang Gusi',
            'category_group' => 'Kesehatan Gusi',
            'options' => [
                'a' => 'Gusi merah, bengkak, dan mudah berdarah',
                'b' => 'Timbul bercak putih atau luka di sudut bibir',
                'c' => 'Mulut terasa kering dan mudah sariawan',
                'd' => 'Gigi terasa ngilu saat minum dingin',
            ],
            'correct' => 'a',
            'explanation' => 'Ciri utama radang gusi adalah gusi tampak merah terang, membengkak, dan gampang mengeluarkan darah terutama saat menyikat gigi.',
        ],
        10 => [
            'id' => 10,
            'question' => 'Yang bukan penyebab terjadinya radang gusi adalah ...',
            'topic' => 'Faktor Pencegah Radang Gusi',
            'category_group' => 'Kesehatan Gusi',
            'options' => [
                'a' => 'Kebiasaan merokok secara rutin',
                'b' => 'Kekurangan vitamin C dalam tubuh',
                'c' => 'Infeksi di mulut dan tambalan gigi rusak',
                'd' => 'Menggunakan sela gigi dengan benang gigi',
            ],
            'correct' => 'd',
            'explanation' => 'Menggunakan benang gigi (dental floss) justru adalah metode yang dianjurkan untuk membersihkan sela gigi dari plak, sehingga BUKAN penyebab radang gusi.',
        ],
        11 => [
            'id' => 11,
            'question' => 'Cara mencegah terjadinya radang gusi adalah ...',
            'topic' => 'Pencegahan Radang Gusi',
            'category_group' => 'Kesehatan Gusi',
            'options' => [
                'a' => 'Perawatan behel gigi ke klinik gigi',
                'b' => 'Perawatan tambal gigi ke klinik gigi',
                'c' => 'Sikat gigi rutin dan membersihkan sela gigi',
                'd' => 'Memasang gigi palsu ke dokter gigi',
            ],
            'correct' => 'c',
            'explanation' => 'Menjaga kebersihan rongga mulut melalui menyikat gigi teratur dan membersihkan sela gigi dengan benang gigi merupakan cara paling ampuh mencegah radang gusi.',
        ],
        12 => [
            'id' => 12,
            'question' => 'Berikut ini manakah yang menjadi pemicu penyebab radang gusi?',
            'topic' => 'Pemicu Radang Gusi',
            'category_group' => 'Kesehatan Gusi',
            'options' => [
                'a' => 'Makanan pedas, rokok, dan minuman alkohol',
                'b' => 'Makanan manis, asam, dan minuman dingin',
                'c' => 'Kebiasaan menggigit bibir dan pipi bagian dalam',
                'd' => 'Kebiasaan menghisap jempol dan menggigit kuku',
            ],
            'correct' => 'a',
            'explanation' => 'Konsumsi makanan yang mengiritasi seperti makanan pedas, zat beracun rokok, dan alkohol dapat memperburuk inflamasi serta menurunkan daya tahan jaringan gusi.',
        ],
        13 => [
            'id' => 13,
            'question' => 'Darah pada sikat gigi merupakan tanda dari ...',
            'topic' => 'Gejala Penyakit Gusi',
            'category_group' => 'Kesehatan Gusi',
            'options' => [
                'a' => 'Penyakit gusi',
                'b' => 'Kerusakan gigi',
                'c' => 'Karang gigi',
                'd' => 'Sariawan',
            ],
            'correct' => 'a',
            'explanation' => 'Bercak darah pada bulu sikat gigi atau busa pasta gigi adalah tanda paling umum dari peradangan gusi (penyakit gusi).',
        ],
        14 => [
            'id' => 14,
            'question' => 'Mengapa radang gusi perlu segera dicegah dan ditangani?',
            'topic' => 'Urgensi Penanganan Gusi',
            'category_group' => 'Kesehatan Gusi',
            'options' => [
                'a' => 'Agar gusi tidak semakin meradang dan berdarah',
                'b' => 'Agar gigi menjadi lebih putih dengan cepat',
                'c' => 'Agar bentuk gigi berubah menjadi lebih rapi',
                'd' => 'Agar gigi terasa lebih keras saat digigit',
            ],
            'correct' => 'a',
            'explanation' => 'Radang gusi harus segera ditangani agar inflamasi tidak meluas ke jaringan periodontal yang lebih dalam dan menyebabkan kerusakan tulang penyangga gigi.',
        ],
        15 => [
            'id' => 15,
            'question' => 'Kapan waktu ideal menyikat gigi dalam sehari?',
            'topic' => 'Waktu Menyikat Gigi',
            'category_group' => 'Kebiasaan Sehat',
            'options' => [
                'a' => 'Setiap selesai mandi pagi dan mandi sore',
                'b' => 'Setiap selesai makan termasuk saat ngemil',
                'c' => 'Saat gigi terasa kotor pada waktu tertentu',
                'd' => 'Setelah sarapan pagi dan sebelum tidur malam',
            ],
            'correct' => 'd',
            'explanation' => 'Waktu menyikat gigi yang tepat dan direkomendasikan secara ilmiah adalah pagi setelah sarapan dan malam sebelum beristirahat tidur.',
        ],
        16 => [
            'id' => 16,
            'question' => 'Pasta gigi yang baik digunakan adalah ... agar membantu memperkuat gigi dan mencegah gigi berlubang',
            'topic' => 'Pasta Gigi Berfluoride',
            'category_group' => 'Kebiasaan Sehat',
            'options' => [
                'a' => 'Pasta gigi berbahan pemutih kuat yang abrasif',
                'b' => 'Pasta gigi yang mengandung fluoride',
                'c' => 'Pasta gigi bermerk dan berkualitas tinggi',
                'd' => 'Pasta gigi dengan rasa mint yang segar',
            ],
            'correct' => 'b',
            'explanation' => 'Kandungan fluoride pada pasta gigi berfungsi meremineralisasi enamel gigi, menjadikannya lebih tahan terhadap serangan asam penyebab gigi berlubang.',
        ],
        17 => [
            'id' => 17,
            'question' => 'Kapan Anda melakukan kunjungan ke klinik gigi untuk dilakukan pemeriksaan?',
            'topic' => 'Pemeriksaan Rutin',
            'category_group' => 'Pemeriksaan Gigi',
            'options' => [
                'a' => 'Saat gigi terasa sakit saja',
                'b' => 'Setiap 1 tahun sekali',
                'c' => 'Setiap 6 bulan sekali',
                'd' => 'Saat ada program gratis',
            ],
            'correct' => 'c',
            'explanation' => 'Pemeriksaan gigi ke dokter gigi dianjurkan dilakukan secara berkala setiap 6 bulan sekali, meskipun tidak ada keluhan rasa sakit.',
        ],
        18 => [
            'id' => 18,
            'question' => 'Bagaimana cara pemakaian sikat gigi yang benar?',
            'topic' => 'Higienitas Sikat Gigi',
            'category_group' => 'Kebiasaan Sehat',
            'options' => [
                'a' => 'Menggunakan sikat gigi sendiri dan tidak bergantian',
                'b' => 'Menggunakan satu sikat gigi bersama anggota keluarga',
                'c' => 'Menggunakan sikat gigi sampai bulunya rusak',
                'd' => 'Menggunakan sikat gigi tanpa dibilas sehabis pakai',
            ],
            'correct' => 'a',
            'explanation' => 'Sikat gigi adalah benda personal yang tidak boleh digunakan bergantian dengan orang lain untuk mencegah transmisi kuman dan bakteri patogen.',
        ],
        19 => [
            'id' => 19,
            'question' => 'Apa fungsi fluoride?',
            'topic' => 'Fungsi Fluoride',
            'category_group' => 'Kebiasaan Sehat',
            'options' => [
                'a' => 'Membuat gigi putih',
                'b' => 'Melindungi gigi dari kerusakan',
                'c' => 'Membuat gigi tumbuh',
                'd' => 'Mencegah bau mulut',
            ],
            'correct' => 'b',
            'explanation' => 'Fluoride bekerja memperkuat lapisan enamel gigi sehingga lebih tahan terhadap asam dan membantu proses remineralisasi dini untuk mencegah gigi berlubang.',
        ],
        20 => [
            'id' => 20,
            'question' => 'Jenis kepala dan bulu sikat gigi yang disarankan adalah ...',
            'topic' => 'Karakteristik Sikat Gigi',
            'category_group' => 'Kebiasaan Sehat',
            'options' => [
                'a' => 'Kepala kecil dengan bulu lembut',
                'b' => 'Kepala sedang dengan bulu kasar',
                'c' => 'Kepala besar dengan bulu kasar',
                'd' => 'Kepala besar dengan bulu sedang',
            ],
            'correct' => 'a',
            'explanation' => 'Kepala sikat gigi berukuran kecil mampu menjangkau area gigi belakang (geraham), dan bulu lembut (soft bristles) tidak melukai gusi maupun mengikis email gigi.',
        ],
    ];

    /**
     * Dapatkan daftar 20 soal untuk tampilan frontend kuesioner.
     * Kunci jawaban sengaja tidak disertakan untuk menjaga integritas tes.
     */
    public function getQuestionsForDisplay(): array
    {
        $displayQuestions = [];
        foreach ($this->questions as $id => $item) {
            $displayQuestions[] = [
                'id' => $item['id'],
                'question' => $item['question'],
                'topic' => $item['topic'],
                'options' => $item['options'],
            ];
        }
        return $displayQuestions;
    }

    /**
     * Menghitung skor jawaban di backend secara deterministik.
     *
     * @param array $userAnswers [1 => 'b', 2 => 'c', ...]
     * @return array
     */
    public function evaluateAnswers(array $userAnswers): array
    {
        $correctCount = 0;
        $incorrectItems = [];
        $detailedResults = [];

        foreach ($this->questions as $id => $q) {
            $answeredOption = isset($userAnswers[$id]) ? strtolower(trim($userAnswers[$id])) : null;
            $isCorrect = ($answeredOption === $q['correct']);

            if ($isCorrect) {
                $correctCount++;
            } else {
                $incorrectItems[] = [
                    'id' => $id,
                    'topic' => $q['topic'],
                    'category_group' => $q['category_group'],
                    'question' => $q['question'],
                    'user_answer' => $answeredOption,
                    'explanation' => $q['explanation'],
                ];
            }

            $detailedResults[$id] = [
                'is_correct' => $isCorrect,
                'user_answer' => $answeredOption,
            ];
        }

        // Rumus: (Jumlah benar / 20) * 100
        $percentage = (int) round(($correctCount / 20) * 100);

        // Kategori & Emoji Deterministik Sesuai Arahan:
        // 16-20 (80-100%): Baik (😍)
        // 12-15 (60-75%): Cukup (😉)
        // 0-11  (0-55%): Kurang baik (🤨)
        if ($correctCount >= 16) {
            $category = 'Baik';
            $emoji = '😍';
            $badgeColor = 'emerald';
            $interpretation = 'Pengetahuan kesehatan gigi dan mulutmu sudah sangat baik! Pertahankan kebiasaan merawat gigi setiap hari.';
        } elseif ($correctCount >= 12) {
            $category = 'Cukup';
            $emoji = '😉';
            $badgeColor = 'amber';
            $interpretation = 'Pengetahuan kesehatan gigi dan mulutmu sudah cukup baik, namun masih ada beberapa kebiasaan dan fakta penting yang perlu ditingkatkan.';
        } else {
            $category = 'Kurang baik';
            $emoji = '🤨';
            $badgeColor = 'rose';
            $interpretation = 'Tingkat pengetahuan kesehatan gigi dan mulutmu masih memerlukan perhatian lebih. Yuk pelajari edukasi di bawah untuk senyum yang lebih sehat!';
        }

        return [
            'total_questions' => 20,
            'correct_count' => $correctCount,
            'incorrect_count' => 20 - $correctCount,
            'percentage' => $percentage,
            'category' => $category,
            'emoji' => $emoji,
            'badge_color' => $badgeColor,
            'interpretation' => $interpretation,
            'incorrect_items' => $incorrectItems,
            'detailed_results' => $detailedResults,
        ];
    }

    /**
     * Menghasilkan konten edukasi yang relevan berdasarkan hasil evaluasi siswa.
     * Menggunakan Gemini AI jika terkonfigurasi. Jika gagal, catat status kegagalan
     * secara jujur tanpa menyajikan fallback statis sebagai hasil Gemini.
     *
     * @param array $evaluationResult Hasil evaluasi dari evaluateAnswers()
     * @param int|null $submissionId ID submission untuk menyimpan hasil ke database
     * @param bool $forceRegenerate Abaikan cache dan paksa panggil Gemini ulang
     */
    public function generateEducationContent(array $evaluationResult, ?int $submissionId = null, bool $forceRegenerate = false): array
    {
        // --- Cek cache database terlebih dahulu ---
        if ($submissionId && !$forceRegenerate) {
            try {
                $saved = \App\Models\SmileScoreSubmission::find($submissionId);
                if ($saved && !empty($saved->ai_education) && is_array($saved->ai_education)) {
                    $cached = $saved->ai_education;
                    // Pastikan ini bukan cache dari kegagalan lama yang perlu dicoba ulang
                    if (($cached['source'] ?? '') !== 'ai_failed') {
                        Log::info("[SmileScore] Menggunakan edukasi tersimpan untuk submission #{$submissionId}, sumber: " . ($cached['source'] ?? 'unknown'));
                        return $cached;
                    }
                }
            } catch (\Throwable $e) {
                Log::warning('Gagal membaca cache edukasi dari database: ' . $e->getMessage());
            }
        }

        // --- Cek API key ---
        $apiKey = null;
        try {
            $apiKey = function_exists('config') ? config('services.gemini.api_key') : null;
        } catch (\Throwable $e) {
            $apiKey = null;
        }
        $apiKey = $apiKey ?: env('GEMINI_API_KEY');
        $hasAiConfigured = !empty($apiKey);

        $education = null;
        $source = 'rule_based';
        $aiError = null;

        if ($hasAiConfigured) {
            [$aiResponse, $aiError] = $this->callGeminiApi($evaluationResult, $apiKey);
            if ($aiResponse !== null) {
                $education = [
                    'source'              => 'ai',
                    'title'               => 'Edukasi Personal Bertenaga Gemini AI',
                    'introduction'        => $aiResponse['introduction'],
                    'score_interpretation'=> $aiResponse['score_interpretation'],
                    'priority_topics'     => $aiResponse['priority_topics'],
                    'key_points'          => $aiResponse['key_points'],
                    'daily_habits'        => $aiResponse['daily_habits'],
                    'when_to_seek_care'   => $aiResponse['when_to_seek_care'],
                    'disclaimer'          => 'Edukasi ini disusun secara otomatis oleh Gemini AI berdasarkan pola jawaban kuesioner sebagai sarana peningkatan literasi, bukan diagnosis medis. Konsultasikan kondisi fisik gigi ke dokter gigi.',
                    'generated_at'        => now()->toISOString(),
                ];
                $source = 'ai';
                Log::info('[SmileScore] Gemini AI berhasil menghasilkan edukasi personal.');
            } else {
                // AI dipanggil tetapi gagal — simpan status kegagalan secara jujur
                $education = [
                    'source'      => 'ai_failed',
                    'title'       => 'Edukasi AI Belum Tersedia',
                    'error'       => $aiError ?? 'Gemini API tidak mengembalikan respons yang valid.',
                    'failed_at'   => now()->toISOString(),
                ];
                $source = 'ai_failed';
                Log::warning('[SmileScore] Gemini AI gagal menghasilkan edukasi. Error: ' . ($aiError ?? 'unknown'));
            }
        } else {
            // Tidak ada API key — gunakan rule-based dan tandai dengan jelas
            $education = $this->getRuleBasedEducation($evaluationResult);
            $source = 'rule_based';
            Log::info('[SmileScore] Gemini API key tidak dikonfigurasi, menggunakan rule-based fallback.');
        }

        // --- Simpan ke database jika submissionId tersedia ---
        if ($submissionId) {
            try {
                \App\Models\SmileScoreSubmission::where('id', $submissionId)->update([
                    'ai_education'              => $education,
                    'ai_education_generated_at' => now(),
                    'ai_education_source'       => $source,
                ]);
                Log::info("[SmileScore] Edukasi disimpan ke submission #{$submissionId}, sumber: {$source}");
            } catch (\Throwable $e) {
                Log::error('Gagal menyimpan hasil edukasi ke submission: ' . $e->getMessage());
            }
        }

        return $education;
    }

    /**
     * Panggilan ke Google Gemini API secara aman di backend.
     * API key tidak pernah dikirim ke frontend atau dicatat di log.
     *
     * @return array{0: ?array, 1: ?string} [$parsedData, $errorMessage]
     */
    public function callGeminiApi(array $eval, string $apiKey): array
    {
        $model = null;
        try {
            $model = function_exists('config') ? config('services.gemini.model') : null;
        } catch (\Throwable $e) {
            $model = null;
        }
        $model = $model ?: env('GEMINI_MODEL', 'gemini-3.5-flash-lite');
        $endpoint = "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key={$apiKey}";

        // Identifikasi topik yang salah dijawab beserta penjelasan singkatnya
        $incorrectItems = $eval['incorrect_items'] ?? [];
        $topicsSummary = collect($incorrectItems)->pluck('topic')->unique()->implode(', ');
        $allCorrect = empty($incorrectItems);
        if ($allCorrect) {
            $topicsSummary = 'Seluruh soal dijawab dengan benar.';
        }

        $correctCount  = $eval['correct_count'] ?? 0;
        $percentage    = $eval['percentage'] ?? 0;
        $category      = $eval['category'] ?? '-';
        $emoji         = $eval['emoji'] ?? '🦷';
        $incorrectCount = 20 - $correctCount;

        // Daftar soal salah beserta topik dan penjelasan (max 10 agar prompt tidak terlalu panjang)
        $incorrectDetails = collect($incorrectItems)->take(10)->map(fn($item) =>
            "- Topik: {$item['topic']} | Penjelasan kunci: {$item['explanation']}"
        )->implode("\n");

        $prompt = <<<PROMPT
Anda adalah asisten edukasi kesehatan gigi dan mulut yang ramah dan suportif untuk siswa SMK Indonesia.

Siswa baru saja menyelesaikan kuesioner literasi kesehatan gigi dan mulut Smile Score dengan hasil:
- Jumlah jawaban benar: {$correctCount} dari 20 ({$percentage}%)
- Kategori hasil: {$category} {$emoji}
- Jumlah soal yang salah dijawab: {$incorrectCount}
- Topik yang perlu ditingkatkan: {$topicsSummary}

Detail soal yang salah dijawab (gunakan sebagai dasar materi edukasi):
{$incorrectDetails}

ATURAN WAJIB:
1. Jangan mengubah skor, persentase, atau kategori hasil.
2. Jangan memberikan diagnosis medis fisik (misalnya: "gigimu berlubang saat ini").
3. Jangan mengarang informasi medis atau referensi yang tidak berdasar.
4. Gunakan bahasa Indonesia yang komunikatif, positif, mendidik, dan ramah untuk siswa SMK.
5. Personalisasikan konten berdasarkan topik yang salah dijawab — jangan buat materi generik.
6. Balas HANYA dalam format JSON valid berikut (tanpa markdown blok ```json, tanpa teks apapun di luar JSON):

{
  "introduction": "Kalimat pembuka personal yang suportif dan memotivasi siswa berdasarkan hasil mereka (2-3 kalimat).",
  "score_interpretation": "Penjelasan netral dan tidak menghakimi mengenai arti kategori hasil: {$category} dengan skor {$correctCount}/20. Fokus pada konteks belajar, bukan menilai kemampuan siswa (2-3 kalimat).",
  "priority_topics": [
    {
      "title": "Nama topik yang perlu dipelajari (dari daftar salah di atas)",
      "relevance": "Mengapa topik ini penting dan relevan untuk siswa SMK (1 kalimat singkat).",
      "explanation": "Penjelasan konsep yang benar secara ilmiah, mudah dipahami siswa SMK, dan langsung berkaitan dengan soal yang salah (2-3 kalimat)."
    }
  ],
  "key_points": [
    "Fakta/poin penting yang perlu diingat 1",
    "Fakta/poin penting yang perlu diingat 2",
    "Fakta/poin penting yang perlu diingat 3"
  ],
  "daily_habits": [
    "Kebiasaan sehari-hari yang praktis dan dapat langsung diterapkan siswa SMK 1",
    "Kebiasaan sehari-hari yang praktis dan dapat langsung diterapkan siswa SMK 2",
    "Kebiasaan sehari-hari yang praktis dan dapat langsung diterapkan siswa SMK 3",
    "Kebiasaan sehari-hari yang praktis dan dapat langsung diterapkan siswa SMK 4"
  ],
  "when_to_seek_care": "Panduan singkat kapan siswa SMK perlu mengunjungi dokter gigi, ditulis secara ramah dan tidak menakutkan (2-3 kalimat)."
}
PROMPT;

        try {
            $response = Http::timeout(25)
                ->withOptions($this->getHttpOptions())
                ->withHeaders(['Content-Type' => 'application/json'])
                ->post($endpoint, [
                    'contents' => [
                        [
                            'parts' => [
                                ['text' => $prompt]
                            ]
                        ]
                    ],
                    'generationConfig' => [
                        'responseMimeType' => 'application/json',
                        'temperature'      => 0.45,
                        'maxOutputTokens'  => 2048,
                    ]
                ]);

            if ($response->successful()) {
                $data = $response->json();
                $text = $data['candidates'][0]['content']['parts'][0]['text'] ?? null;
                if ($text) {
                    // Bersihkan jika model menyertakan code block markdown
                    $cleanText = preg_replace('/^```(?:json)?\s*/i', '', trim($text));
                    $cleanText = preg_replace('/\s*```$/', '', $cleanText);
                    $decoded   = json_decode(trim($cleanText), true);

                    if (
                        is_array($decoded)
                        && !empty($decoded['introduction'])
                        && !empty($decoded['score_interpretation'])
                        && !empty($decoded['priority_topics'])
                        && is_array($decoded['priority_topics'])
                        && !empty($decoded['key_points'])
                        && is_array($decoded['key_points'])
                        && !empty($decoded['daily_habits'])
                        && is_array($decoded['daily_habits'])
                        && !empty($decoded['when_to_seek_care'])
                    ) {
                        return [$decoded, null];
                    }

                    $jsonError = json_last_error_msg();
                    Log::warning('[SmileScore] Format JSON Gemini tidak sesuai struktur. json_last_error: ' . $jsonError . '. Preview: ' . substr($text, 0, 300));
                    return [null, 'Respons Gemini tidak memenuhi struktur JSON yang diharapkan (json error: ' . $jsonError . ')'];
                }
                return [null, 'Gemini mengembalikan respons kosong (tidak ada teks pada candidates[0])'];
            } else {
                $status  = $response->status();
                $bodySnippet = substr($response->body(), 0, 400);
                Log::warning("[SmileScore] Gemini API HTTP {$status}: {$bodySnippet}");
                return [null, "Gemini API mengembalikan HTTP {$status}"];
            }
        } catch (\Throwable $e) {
            // Hindari mencatat URL lengkap yang mengandung API key
            $msg = get_class($e) . ': ' . $e->getMessage();
            Log::error('[SmileScore] Gemini API call exception: ' . $msg);
            return [null, 'Koneksi ke Gemini API gagal: ' . get_class($e)];
        }
    }

    /**
     * Opsi HTTP client untuk keandalan koneksi HTTPS di berbagai environment.
     * Selalu mencoba menggunakan bundle CA eksplisit jika ditemukan, agar konsisten
     * di semua konteks (web server, CLI, php artisan serve, dll.) di XAMPP / Windows.
     */
    protected function getHttpOptions(): array
    {
        // Coba bundle CA yang diketahui tersedia di instalasi XAMPP umum
        $knownBundles = [
            'C:/xampp/apache/bin/curl-ca-bundle.crt',
            'C:/xampp/perl/vendor/lib/Mozilla/CA/cacert.pem',
            'C:/xampp/phpMyAdmin/vendor/composer/ca-bundle/res/cacert.pem',
        ];

        foreach ($knownBundles as $bundle) {
            if (file_exists($bundle)) {
                return ['verify' => $bundle];
            }
        }

        // Jika ada konfigurasi CA dari php.ini, biarkan cURL menggunakannya
        if (ini_get('curl.cainfo') || ini_get('openssl.cafile')) {
            return [];
        }

        // Fallback: log peringatan, jangan disable verify (keamanan)
        Log::warning('[SmileScore] Tidak ditemukan bundle CA yang valid. cURL SSL verify mungkin gagal.');
        return [];
    }

    /**
     * Konten edukasi berbasis aturan (Rule-Based Fallback) yang diverifikasi medis.
     * Digunakan hanya ketika API key Gemini tidak dikonfigurasi.
     * Sesuai struktur baru dengan field introduction, score_interpretation, priority_topics,
     * key_points, daily_habits, dan when_to_seek_care.
     */
    protected function getRuleBasedEducation(array $eval): array
    {
        $category   = $eval['category'] ?? 'Kurang baik';
        $percentage = $eval['percentage'] ?? 0;
        $correct    = $eval['correct_count'] ?? 0;

        $introduction = match ($category) {
            'Baik'  => 'Luar biasa! Kamu sudah memiliki pemahaman yang sangat baik mengenai kesehatan gigi dan mulut. Pertahankan semangat belajarmu dan terus terapkan kebiasaan sehat ini setiap hari.',
            'Cukup' => 'Kerja bagus! Kamu sudah memahami dasar-dasar kesehatan gigi dan mulut. Masih ada beberapa topik yang bisa kamu perkuat agar pemahamanmu semakin lengkap.',
            default => 'Jangan berkecil hati! Kamu sudah mengambil langkah berani dengan mengikuti kuesioner ini. Setiap informasi yang kamu pelajari hari ini adalah investasi untuk senyummu yang lebih sehat.',
        };

        $scoreInterpretation = "Kamu berhasil menjawab {$correct} dari 20 soal dengan benar ({$percentage}%), masuk dalam kategori {$category}. " . match ($category) {
            'Baik'  => 'Ini menunjukkan kamu telah memiliki fondasi pengetahuan yang kuat tentang perawatan gigi dan mulut.',
            'Cukup' => 'Ini artinya ada beberapa konsep yang sudah kamu pahami dengan baik, namun beberapa topik masih perlu penguatan.',
            default => 'Ini adalah titik awal yang baik — dengan mempelajari materi di bawah, kamu bisa meningkatkan pengetahuanmu secara signifikan.',
        };

        // Buat materi per topik yang salah, atau penguatan umum jika semua benar
        $priorityTopics = [];
        if (!empty($eval['incorrect_items'])) {
            $groupedByTopic = collect($eval['incorrect_items'])->groupBy('topic');
            foreach ($groupedByTopic as $topicName => $items) {
                $first = $items->first();
                $priorityTopics[] = [
                    'title'      => $topicName,
                    'relevance'  => 'Topik ini dijawab kurang tepat dalam kuesionermu dan merupakan bagian penting dari perawatan gigi sehari-hari.',
                    'explanation'=> $first['explanation'],
                ];
            }
        } else {
            $priorityTopics = [
                ['title' => 'Pencegahan Karies (Gigi Berlubang)', 'relevance' => 'Karies adalah masalah gigi paling umum yang dapat dicegah dengan kebiasaan sederhana.', 'explanation' => 'Gigi berlubang terjadi ketika bakteri mengubah sisa makanan berkarbohidrat menjadi asam yang melarutkan mineral enamel. Pencegahan terbaik adalah menyikat gigi 2x sehari dengan pasta berfluoride.'],
                ['title' => 'Kesehatan Gusi (Pencegahan Gingivitis)', 'relevance' => 'Radang gusi yang tidak ditangani dapat berkembang menjadi periodontitis dan kehilangan gigi.', 'explanation' => 'Plak yang menumpuk di pinggir gusi memicu peradangan. Rutinitas menyikat gigi dan menggunakan benang gigi setiap hari adalah cara paling efektif mencegahnya.'],
                ['title' => 'Pemeriksaan Rutin ke Dokter Gigi', 'relevance' => 'Pemeriksaan berkala mendeteksi masalah sebelum menjadi parah dan mahal ditangani.', 'explanation' => 'Kunjungan ke dokter gigi setiap 6 bulan memungkinkan pembersihan karang gigi profesional dan deteksi dini karies atau masalah gusi.'],
            ];
        }

        $keyPoints = [
            'Sikat gigi 2 kali sehari: pagi setelah sarapan dan malam sebelum tidur.',
            'Gunakan pasta gigi mengandung fluoride untuk memperkuat enamel.',
            'Gunakan benang gigi (dental floss) untuk membersihkan sela gigi yang tidak terjangkau sikat.',
            'Batasi makanan dan minuman manis/asam yang memicu produksi asam bakteri.',
            'Periksa ke dokter gigi setiap 6 bulan meskipun tidak ada keluhan.',
        ];

        $dailyHabits = [
            'Sikat gigi selama minimal 2 menit dengan gerakan melingkar lembut.',
            'Ganti sikat gigi setiap 3 bulan sekali atau saat bulu sikat sudah mekar.',
            'Gunakan benang gigi sebelum menyikat gigi malam untuk membersihkan sela gigi.',
            'Minum air putih yang cukup, terutama setelah mengonsumsi makanan manis.',
        ];

        return [
            'source'               => 'rule_based',
            'title'                => 'Edukasi Kesehatan Gigi & Mulut',
            'introduction'         => $introduction,
            'score_interpretation' => $scoreInterpretation,
            'priority_topics'      => $priorityTopics,
            'key_points'           => $keyPoints,
            'daily_habits'         => $dailyHabits,
            'when_to_seek_care'    => 'Segera kunjungi dokter gigi jika kamu mengalami nyeri gigi, gusi sering berdarah, atau sudah lebih dari 6 bulan tidak memeriksakan gigi. Periksa rutin setiap 6 bulan bahkan tanpa keluhan untuk menjaga kesehatan gigi jangka panjang.',
            'disclaimer'           => 'Materi edukasi ini disusun berdasarkan pedoman literasi kesehatan gigi dan mulut untuk meningkatkan pengetahuan, bukan merupakan diagnosis medis. Konsultasikan kondisi fisik gigimu ke dokter gigi terdekat.',
        ];
    }

}
