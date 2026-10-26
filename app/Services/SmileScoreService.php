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
                    'user_answer_text' => $answeredOption && isset($q['options'][$answeredOption]) ? $q['options'][$answeredOption] : 'Tidak dijawab',
                    'correct_answer' => $q['correct'],
                    'correct_answer_text' => $q['options'][$q['correct']] ?? '',
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
     * Menggunakan Gemini AI jika terkonfigurasi.
     * Jika API key tidak ada, kuota habis, timeout, atau struktur respons tidak valid,
     * sistem secara otomatis menampilkan edukasi berbasis pedoman medis (rule-based fallback).
     * Hasil selalu disimpan ke database agar refresh tidak memicu panggilan baru.
     *
     * Perbaikan keamanan dan efisiensi kuota:
     * - Semua cache (termasuk rule_based_fallback) dikembalikan langsung pada GET tanpa retry.
     * - Regenerasi hanya lewat POST /edukasi/regenerate (forceRegenerate=true).
     * - Cache::lock per submissionId mencegah dua request paralel memanggil Gemini ganda.
     *
     * @param array    $evaluationResult Hasil dari evaluateAnswers()
     * @param int|null $submissionId     ID submission untuk cache & persistensi database
     * @param bool     $forceRegenerate  Abaikan cache; hanya untuk POST regenerate (maks 3x/sesi)
     */
    public function generateEducationContent(array $evaluationResult, ?int $submissionId = null, bool $forceRegenerate = false): array
    {
        // --- Cek cache database terlebih dahulu ---
        // Semua status tersimpan (ai, rule_based, rule_based_fallback) dikembalikan langsung.
        // Hanya forceRegenerate=true (dari POST endpoint) yang melewati cache ini.
        if ($submissionId && !$forceRegenerate) {
            try {
                $saved = \App\Models\SmileScoreSubmission::find($submissionId);
                if ($saved && !empty($saved->ai_education) && is_array($saved->ai_education)) {
                    $cachedSource = $saved->ai_education['source'] ?? '';
                    Log::info("[SmileScore] Cache ditemukan untuk submission #{$submissionId}, sumber: {$cachedSource}. Dikembalikan tanpa panggilan Gemini.");
                    return $saved->ai_education;
                }
            } catch (\Throwable $e) {
                Log::warning('[SmileScore] Gagal membaca cache edukasi dari database: ' . $e->getMessage());
            }
        }

        // --- Cek API key ---
        $apiKey = function_exists('config') ? config('services.gemini.api_key') : env('GEMINI_API_KEY');
        $hasAiConfigured = !empty($apiKey);

        $education = null;
        $source    = 'rule_based';

        if ($hasAiConfigured) {
            // --- Proteksi request paralel via Cache::lock per submissionId ---
            // Mencegah dua tab/klik bersamaan menghasilkan dua panggilan Gemini sekaligus.
            $lockKey = $submissionId ? "gemini_gen_{$submissionId}" : null;
            $lock    = $lockKey ? \Illuminate\Support\Facades\Cache::lock($lockKey, 30) : null;

            if ($lock && !$lock->get()) {
                // Lock aktif: request lain sedang dalam proses. Tunggu sebentar lalu baca DB.
                Log::info("[SmileScore] Lock aktif untuk submission #{$submissionId}; membaca dari DB setelah jeda singkat.");
                sleep(2);
                try {
                    $saved = \App\Models\SmileScoreSubmission::find($submissionId);
                    if ($saved && !empty($saved->ai_education) && is_array($saved->ai_education)) {
                        return $saved->ai_education;
                    }
                } catch (\Throwable $e) {
                    Log::warning('[SmileScore] Gagal membaca DB setelah menunggu lock: ' . $e->getMessage());
                }
                // Jika tidak ada data, lanjutkan tanpa lock (graceful degradation)
                $lock = null;
            }

            try {
                [$aiResponse, $aiError] = $this->callGeminiApi($evaluationResult, $apiKey);

                if ($aiResponse !== null) {
                    // --- Gemini berhasil ---
                    $education = [
                        'source'               => 'ai',
                        'title'                => 'Edukasi Personal Bertenaga Gemini AI',
                        'introduction'         => $aiResponse['introduction'],
                        'score_interpretation' => $aiResponse['score_interpretation'],
                        'priority_topics'      => $aiResponse['priority_topics'],
                        'key_points'           => $aiResponse['key_points'],
                        'daily_habits'         => $aiResponse['daily_habits'],
                        'when_to_seek_care'    => $aiResponse['when_to_seek_care'],
                        'disclaimer'           => 'Edukasi ini disusun secara otomatis oleh Gemini AI berdasarkan pola jawaban kuesioner sebagai sarana peningkatan literasi, bukan diagnosis medis. Konsultasikan kondisi fisik gigi ke dokter gigi.',
                        'generated_at'         => now()->toISOString(),
                    ];
                    $source = 'ai';
                    Log::info('[SmileScore] Gemini AI berhasil menghasilkan edukasi personal.');
                } else {
                    // --- Gemini gagal (timeout / 429 / JSON tidak valid) ---
                    // Aktifkan fallback rule-based secara otomatis agar siswa tetap mendapat edukasi.
                    Log::warning('[SmileScore] Gemini AI gagal. Beralih ke fallback rule-based. Error: ' . ($aiError ?? 'unknown'));
                    $ruleContent = $this->getRuleBasedEducation($evaluationResult);
                    $education   = array_merge($ruleContent, [
                        'source'    => 'rule_based_fallback',
                        'ai_error'  => $aiError ?? 'Gemini API tidak mengembalikan respons yang valid.',
                        'failed_at' => now()->toISOString(),
                    ]);
                    $source = 'rule_based_fallback';
                }
            } finally {
                // Pastikan lock selalu dilepas walau terjadi exception di callGeminiApi
                if ($lock) {
                    $lock->release();
                }
            }
        } else {
            // Tidak ada API key — gunakan rule-based dan tandai dengan jelas
            $education = $this->getRuleBasedEducation($evaluationResult);
            $source    = 'rule_based';
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
                Log::error('[SmileScore] Gagal menyimpan hasil edukasi ke submission: ' . $e->getMessage());
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
        $model = $model ?: env('GEMINI_MODEL', 'gemini-1.5-flash');
        $endpoint = "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key={$apiKey}";

        $incorrectItems = $eval['incorrect_items'] ?? [];
        $correctCount   = $eval['correct_count'] ?? 0;
        $percentage     = $eval['percentage'] ?? 0;
        $category       = $eval['category'] ?? '-';
        $emoji          = $eval['emoji'] ?? '🦷';
        $incorrectCount = 20 - $correctCount;

        if (empty($incorrectItems)) {
            $contextIntro = "Siswa menjawab seluruh 20 pertanyaan dengan BENAR (100%, Kategori: Baik {$emoji}).";
            $mistakesSection = "Seluruh 20 soal dijawab benar. Fokuskan materi pada 3 topik penguatan konsep preventif utama (proses demineralisasi karies & peran fluoride, pencegahan radang gusi & benang gigi, serta urgensi kontrol berkala dokter gigi 6 bulan sekali).";
        } else {
            $contextIntro = "Siswa menjawab {$correctCount} benar dari 20 soal ({$percentage}%, Kategori: {$category} {$emoji}) dengan {$incorrectCount} soal dijawab kurang tepat.";
            // Berikan detail soal yang salah dijawab beserta opsi siswa dan kunci benar (ambil hingga 12 item representatif)
            $mistakesSection = collect($incorrectItems)->take(12)->map(function ($item) {
                $id = $item['id'] ?? '?';
                $topic = $item['topic'] ?? 'Kesehatan Gigi';
                $catGroup = $item['category_group'] ?? 'Umum';
                $qText = $item['question'] ?? ($this->questions[$id]['question'] ?? '-');
                $ansLetter = $item['user_answer'] ?? '-';
                $ansText = $item['user_answer_text'] ?? ($item['user_answer'] ?? '-');
                $corText = $item['correct_answer_text'] ?? ($this->questions[$id]['options'][$this->questions[$id]['correct'] ?? ''] ?? '-');
                $expl = $item['explanation'] ?? ($this->questions[$id]['explanation'] ?? '-');

                return "- Soal #{$id} [Topik: {$topic} | Kategori: {$catGroup}]\n" .
                       "  Pertanyaan: {$qText}\n" .
                       "  Jawaban siswa: ({$ansLetter}) {$ansText}\n" .
                       "  Kunci benar: {$corText}\n" .
                       "  Konsep kunci: {$expl}";
            })->implode("\n\n");
        }

        $prompt = <<<PROMPT
Anda adalah asisten edukasi kesehatan gigi dan mulut profesional, ramah, komunikatif, dan mendidik untuk siswa Sekolah Menengah Kejuruan (SMK) di Indonesia.

DATA EVALUASI SISWA:
{$contextIntro}

RINCIAN POLA JAWABAN SISWA:
{$mistakesSection}

TUGAS UTAMA:
Ubah evaluasi di atas menjadi pembelajaran personal berdasarkan pola jawaban siswa. Hindari membuat artikel ensiklopedia yang panjang dan membosankan, definisi kaku, atau pengulangan materi soal.

PANDUAN PEMILIHAN DAN PENYUSUNAN MATERI:
1. Analisis Berdasarkan Data Nyata:
   Gunakan data hasil evaluasi yang tersedia di atas. Jangan mengarang alasan kesalahan yang tidak berdasar atau mengklaim kondisi fisik siswa yang tidak diketahui.
2. Batasi 3 Hingga Maksimal 5 Topik Prioritas:
   Meskipun terdapat {$incorrectCount} jawaban salah, JANGAN membuat {$incorrectCount} materi terpisah! Gabungkan topik-topik yang memiliki keterkaitan konsep (misalnya beberapa soal karies digabung menjadi 1 topik konsep pembentukan lubang gigi). Pilih MAKSIMAL 3 HINGGA 5 TOPIK PRIORITAS yang paling mendasar untuk dipahami kembali.
3. Struktur Setiap Topik Prioritas (WAJIB):
   - title: Judul konsep materi yang spesifik dan jelas (contoh: "Mekanisme Asam & Kerusakan Enamel Gigi").
   - core_concept: Satu kalimat tegas yang menyatakan inti konsep yang perlu dipahami siswa.
   - explanation: Penjelasan sederhana (2-4 kalimat). Istilah medis dijelaskan menggunakan bahasa yang mudah dipahami remaja SMK.
   - daily_context: Contoh situasi nyata kehidupan sehari-hari siswa SMK (misalnya: kebiasaan jajan manis saat istirahat tanpa bilas air putih, sikat gigi terburu-buru sebelum berangkat sekolah, mengabaikan gusi berdarah).
   - remember_point: Satu kesimpulan praktis yang mudah diingat dan tidak mengulang penjelasan secara verbatim.
4. Rekomendasi Kebiasaan Sehat (daily_habits):
   Buat MAKSIMAL 3 tindakan praktis yang relevan dengan topik prioritas, dapat diterapkan langsung dalam rutinitas harian siswa SMK, tidak mengulang teks penjelasan, dan tidak memberikan diagnosis medis.
5. Poin Penting (key_points):
   Buat 3-4 fakta kunci penting yang singkat dan esensial.
6. Kapan Berkonsultasi (when_to_seek_care):
   Panduan singkat (2-3 kalimat) mengenai tanda bahaya yang memerlukan penanganan dokter gigi dan pentingnya kontrol rutin 6 bulan sekali.
7. Interpretasi Skor (score_interpretation):
   Jelaskan secara ramah bahwa skor kuesioner ini merupakan evaluasi tingkat literasi/pengetahuan kesehatan gigi dan mulut, BUKAN diagnosis klinis atas kondisi fisik gigi siswa.

LARANGAN KERAS:
- DILARANG menggunakan pembukaan klise seperti "Penting bagi siswa SMK untuk mengetahui...".
- DILARANG menulis definisi ensiklopedis yang terlalu panjang dan berbelit-belit.
- DILARANG mengulang pertanyaan kuesioner sebagai paragraf materi.
- DILARANG mengklaim siswa menderita penyakit tertentu (misal: "Gigi kamu saat ini sedang berlubang").
- DILARANG mengulang substansi atau kalimat yang sama di beberapa bagian.

FORMAT OUTPUT:
Balas HANYA berupa JSON valid (tanpa blok markdown ```json, tanpa teks pembuka/penutup):
{
  "introduction": "Kalimat pembuka personal dan suportif (2-3 kalimat) berdasarkan capaian evaluasi.",
  "score_interpretation": "Penjelasan bahwa hasil evaluasi ini mengukur pemahaman literasi kesehatan gigi (bukan diagnosis fisik) dan maknanya bagi proses belajar siswa (2-3 kalimat).",
  "priority_topics": [
    {
      "title": "Judul Konsep Topik Prioritas",
      "core_concept": "Satu kalimat inti konsep pembelajaran.",
      "explanation": "Penjelasan sederhana 2-4 kalimat dengan istilah medis ramah remaja.",
      "daily_context": "Contoh situasi nyata sehari-hari siswa SMK.",
      "remember_point": "Satu kesimpulan praktis yang mudah diingat."
    }
  ],
  "key_points": [
    "Poin kunci penting 1",
    "Poin kunci penting 2",
    "Poin kunci penting 3"
  ],
  "daily_habits": [
    "Tindakan praktis 1 (maksimal 3 kebiasaan)",
    "Tindakan praktis 2",
    "Tindakan praktis 3"
  ],
  "when_to_seek_care": "Panduan kapan siswa perlu berkonsultasi ke dokter gigi dan pentingnya kontrol 6 bulan sekali (2-3 kalimat)."
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
                        'temperature'      => 0.4,
                        'maxOutputTokens'  => 2048,
                    ]
                ]);

            if ($response->successful()) {
                $data = $response->json();
                $text = $data['candidates'][0]['content']['parts'][0]['text'] ?? null;
                if ($text) {
                    $cleanText = preg_replace('/^```(?:json)?\s*/i', '', trim($text));
                    $cleanText = preg_replace('/\s*```$/', '', $cleanText);
                    $decoded   = json_decode(trim($cleanText), true);

                    // Jika decode gagal karena karakter kontrol unescaped dari LLM, sanitasi dan coba lagi
                    if ($decoded === null) {
                        $sanitized = preg_replace('/[\x00-\x09\x0B\x0C\x0E-\x1F\x7F]/', '', $cleanText);
                        $retryDecoded = json_decode($sanitized, true);
                        if (is_array($retryDecoded)) {
                            $decoded = $retryDecoded;
                        }
                    }

                    if (
                        is_array($decoded)
                        && !empty($decoded['introduction'])
                        && !empty($decoded['score_interpretation'])
                        && !empty($decoded['priority_topics'])
                        && is_array($decoded['priority_topics'])
                        && !empty($decoded['daily_habits'])
                        && is_array($decoded['daily_habits'])
                        && !empty($decoded['when_to_seek_care'])
                    ) {
                        // Normalisasi dan validasi isi priority_topics
                        $validTopics = [];
                        foreach ($decoded['priority_topics'] as $topic) {
                            if (!is_array($topic) || empty($topic['title'])) {
                                continue;
                            }
                            $explanation   = $topic['explanation'] ?? '';
                            $coreConcept   = $topic['core_concept'] ?? $topic['relevance'] ?? '';
                            $dailyContext  = $topic['daily_context'] ?? $topic['example'] ?? '';
                            $rememberPoint = $topic['remember_point'] ?? $topic['takeaway'] ?? '';

                            if (empty($explanation) && empty($coreConcept)) {
                                continue;
                            }

                            $validTopics[] = [
                                'title'          => trim($topic['title']),
                                'core_concept'   => trim($coreConcept ?: $explanation),
                                'explanation'    => trim($explanation ?: $coreConcept),
                                'daily_context'  => trim($dailyContext),
                                'remember_point' => trim($rememberPoint),
                                'relevance'      => trim($coreConcept ?: $explanation), // Kompatibilitas mundur
                            ];
                        }

                        if (!empty($validTopics)) {
                            // Batasi maksimal 3-5 topik prioritas
                            $decoded['priority_topics'] = array_slice($validTopics, 0, 5);

                            // Batasi maksimal 3 kebiasaan sehat sehari-hari
                            $filteredHabits = array_values(array_filter($decoded['daily_habits'], fn($h) => is_string($h) && trim($h) !== ''));
                            $decoded['daily_habits'] = array_slice($filteredHabits, 0, 3);

                            // Pastikan key_points terisi dan tidak berlebihan
                            if (empty($decoded['key_points']) || !is_array($decoded['key_points'])) {
                                $decoded['key_points'] = [
                                    'Sikat gigi 2 kali sehari dengan pasta berfluoride: pagi setelah sarapan dan malam sebelum tidur.',
                                    'Bersihkan sela-sela gigi dengan dental floss untuk mencegah plak merusak tepi gusi.',
                                    'Pemeriksaan rutin ke dokter gigi setiap 6 bulan mendeteksi masalah sebelum timbul rasa sakit.',
                                ];
                            } else {
                                $filteredKeys = array_values(array_filter($decoded['key_points'], fn($k) => is_string($k) && trim($k) !== ''));
                                $decoded['key_points'] = array_slice($filteredKeys, 0, 4);
                            }

                            return [$decoded, null];
                        }
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
     * Menghasilkan struktur personal pembelajaran terstruktur (3-5 topik prioritas,
     * konsep inti, contoh situasi sehari-hari, hal yang perlu diingat, dan 3 kebiasaan sehat).
     */
    protected function getRuleBasedEducation(array $eval): array
    {
        $category   = $eval['category'] ?? 'Kurang baik';
        $percentage = $eval['percentage'] ?? 0;
        $correct    = $eval['correct_count'] ?? 0;
        $incorrectItems = $eval['incorrect_items'] ?? [];
        $incorrectIds = collect($incorrectItems)->pluck('id')->all();

        $introduction = match ($category) {
            'Baik'  => 'Luar biasa! Kamu sudah memiliki dasar pemahaman kesehatan gigi dan mulut yang sangat baik. Mari kita perdalam konsep kunci untuk mempertahankan kesehatan senyummu setiap hari.',
            'Cukup' => 'Hasil yang baik! Kamu sudah memahami banyak hal penting tentang kesehatan gigi. Ada beberapa konsep kunci yang perlu diperkuat agar pemahaman dan kebiasaanmu semakin maksimal.',
            default => 'Langkah awal yang sangat baik! Mengikuti evaluasi ini membantumu mengenali hal-hal penting seputar kesehatan gigi. Pelajari materi ringkas di bawah untuk meningkatkan kesehatan senyummu.',
        };

        $scoreInterpretation = "Kamu berhasil menjawab {$correct} dari 20 soal dengan benar ({$percentage}%), termasuk dalam kategori {$category}. Skor ini merupakan evaluasi tingkat pemahaman literasi kesehatan gigi dan mulutmu saat ini, bukan diagnosis klinis atas kondisi fisik gigimu. " . match ($category) {
            'Baik'  => 'Hasil ini menunjukkan pemahaman teoritis yang kokoh dalam menjaga kebersihan rongga mulut.',
            'Cukup' => 'Hasil ini menandakan sebagian besar konsep sudah kamu pahami, namun ada beberapa prinsip pencegahan yang perlu ditingkatkan.',
            default => 'Hasil ini menjadi panduan belajar yang tepat untuk mengenali kebiasaan dan fakta kesehatan gigi yang sering disalahpahami.',
        };

        // Master materi terstruktur berdasarkan rumpun konsep soal
        $clusterDefinitions = [
            'karies' => [
                'ids' => [1, 2, 3, 4, 7],
                'topic' => [
                    'title'          => 'Proses Terjadinya Gigi Berlubang & Peran Asam Bakteri',
                    'core_concept'   => 'Gigi berlubang terjadi karena asam hasil olahan bakteri dari sisa makanan manis melarutkan mineral pelindung gigi (enamel), bukan karena ulat.',
                    'explanation'    => 'Ketika sisa makanan berkarbohidrat menempel di gigi, bakteri rongga mulut mengubahnya menjadi asam yang melarutkan mineral enamel gigi secara bertahap. Jika dibiarkan, lubang akan menembus ke lapisan dalam hingga saraf dan menimbulkan sakit berdenyut.',
                    'daily_context'  => 'Sering ngemil makanan manis atau minum boba saat istirahat sekolah tanpa berkumur air putih membuat gigi terus terpapar asam sepanjang hari.',
                    'remember_point' => 'Sikat gigi dengan pasta berfluoride membantu mengembalikan mineral gigi yang hilang dan menghentikan pembentukan lubang sejak dini.',
                ],
            ],
            'tambal_gigi' => [
                'ids' => [5, 6],
                'topic' => [
                    'title'          => 'Perawatan Restorasi: Kapan dan Mengapa Gigi Perlu Ditambal',
                    'core_concept'   => 'Tambal gigi adalah pengisian bahan pelindung pada kavitas gigi yang harus dilakukan sedini mungkin sebelum infeksi mencapai saraf.',
                    'explanation'    => 'Menunda penambalan karena gigi belum terasa sakit adalah kekeliruan umum. Lubang gigi tidak dapat menutup sendiri. Penambalan dini oleh dokter gigi menghentikan penyebaran kuman, jauh lebih nyaman, dan menyelamatkan struktur asli gigi.',
                    'daily_context'  => 'Banyak siswa membiarkan titik hitam kecil di gigi geraham karena belum ngilu, hingga akhirnya gigi patah atau abses bengkak menjelang ujian sekolah.',
                    'remember_point' => 'Jangan menunggu gigi terasa sakit hebat; periksakan dan tambal gigi saat lubang masih kecil dan dangkal.',
                ],
            ],
            'gusi' => [
                'ids' => [8, 9, 10, 11, 12, 13, 14],
                'topic' => [
                    'title'          => 'Kesehatan Gusi: Mengenali Gejala Awal dan Mencegah Gingivitis',
                    'core_concept'   => 'Gusi berdarah saat menyikat gigi merupakan tanda utama radang gusi akibat tumpukan plak bakteri di perbatasan gigi, bukan karena sikat terlalu keras.',
                    'explanation'    => 'Plak adalah lapisan lengket tak kasat mata berisi koloni bakteri. Jika plak di garis gusi tidak dibersihkan dengan sikat gigi lembut dan dental floss, racun kuman memicu peradangan. Bila dibiarkan menahun, radang dapat merusak jaringan penyangga hingga gigi goyang.',
                    'daily_context'  => 'Saat melihat busa sikat gigi berdarah di pagi hari, sebagian siswa malah takut menyikat area tersebut, padahal area itulah yang paling membutuhkan pembersihan teliti.',
                    'remember_point' => 'Gusi sehat berwarna merah muda kencang dan tidak berdarah; bersihkan sela gigi dan garis gusi setiap hari.',
                ],
            ],
            'sikat_dan_fluoride' => [
                'ids' => [15, 16, 18, 19, 20],
                'topic' => [
                    'title'          => 'Teknik Waktu Menyikat Gigi & Perlindungan Aktif Fluoride',
                    'core_concept'   => 'Waktu paling krusial menyikat gigi adalah pagi setelah sarapan dan malam tepat sebelum tidur dengan pasta gigi berfluoride.',
                    'explanation'    => 'Menyikat gigi sebelum tidur malam sangat penting karena produksi air liur pembersih alami menurun drastis saat tidur. Fluoride berfungsi memperkuat lapisan enamel agar tahan terhadap serangan asam dan mencegah demineralisasi dini.',
                    'daily_context'  => 'Banyak remaja mengira menyikat gigi saat mandi sore sudah cukup, padahal setelah mandi masih makan malam dan ngemil hingga larut malam.',
                    'remember_point' => 'Jadikan menyikat gigi sebelum tidur malam sebagai kebiasaan wajib tanpa kompromi.',
                ],
            ],
            'kontrol_rutin' => [
                'ids' => [17],
                'topic' => [
                    'title'          => 'Pemeriksaan Berkala: Manfaat Kunjungan Rutin Setiap 6 Bulan',
                    'core_concept'   => 'Kunjungan rutin ke dokter gigi setiap 6 bulan bertujuan mencegah dan mendeteksi masalah sedini mungkin sebelum timbul keluhan sakit.',
                    'explanation'    => 'Karang gigi dan lubang awal sering kali tidak bergejala. Melalui pemeriksaan berkala, dokter gigi dapat melakukan pembersihan karang gigi profesional (scaling) dan perawatan preventif sebelum kerusakan meluas dan memerlukan biaya besar.',
                    'daily_context'  => 'Menganggap klinik gigi hanya untuk saat darurat gigi sakit adalah anggapan keliru yang sering menyebabkan kehilangan gigi di usia muda.',
                    'remember_point' => 'Periksa ke dokter gigi secara teratur setiap 6 bulan sekali, ada atau tidak ada keluhan rasa sakit.',
                ],
            ],
        ];

        // Tentukan topik prioritas berdasarkan kesalahan siswa (maksimal 3-5 topik)
        $priorityTopics = [];

        if (empty($incorrectIds)) {
            // Sempurna: Berikan 3 topik penguatan konsep utama
            $selectedKeys = ['karies', 'gusi', 'kontrol_rutin'];
        } else {
            // Pilih cluster yang memiliki jawaban salah
            $selectedKeys = [];
            foreach ($clusterDefinitions as $key => $def) {
                $hasMistake = !empty(array_intersect($def['ids'], $incorrectIds));
                if ($hasMistake) {
                    $selectedKeys[] = $key;
                }
            }

            // Jika kurang dari 3 cluster, tambahkan cluster mendasar lainnya
            $fallbackKeys = ['karies', 'gusi', 'sikat_dan_fluoride', 'kontrol_rutin', 'tambal_gigi'];
            foreach ($fallbackKeys as $fbKey) {
                if (count($selectedKeys) >= 3) {
                    break;
                }
                if (!in_array($fbKey, $selectedKeys)) {
                    $selectedKeys[] = $fbKey;
                }
            }

            // Batasi maksimal 4-5 topik
            $selectedKeys = array_slice($selectedKeys, 0, 4);
        }

        foreach ($selectedKeys as $key) {
            $t = $clusterDefinitions[$key]['topic'];
            $priorityTopics[] = [
                'title'          => $t['title'],
                'core_concept'   => $t['core_concept'],
                'explanation'    => $t['explanation'],
                'daily_context'  => $t['daily_context'],
                'remember_point' => $t['remember_point'],
                'relevance'      => $t['core_concept'], // Kompatibilitas mundur
            ];
        }

        $keyPoints = [
            'Sikat gigi 2 kali sehari secara teratur: pagi setelah sarapan dan malam sebelum tidur.',
            'Gunakan pasta gigi berfluoride untuk memperkuat lapisan enamel gigi melawan asam.',
            'Gunakan benang gigi (dental floss) untuk membersihkan sela gigi yang tidak terjangkau sikat.',
            'Lakukan pemeriksaan gigi rutin setiap 6 bulan sekali meskipun tidak ada rasa sakit.',
        ];

        // Maksimal 3 kebiasaan praktis sesuai panduan revisi
        $dailyHabits = [
            'Sikat gigi selama minimal 2 menit dengan sikat berbulu lembut dan gerakan melingkar perlahan.',
            'Bersihkan sela gigi dengan dental floss setiap malam sebelum menyikat gigi untuk membuang plak.',
            'Bilas mulut dengan air putih setelah mengonsumsi makanan manis dan jadwalkan kontrol 6 bulan sekali.',
        ];

        return [
            'source'               => 'rule_based',
            'title'                => 'Edukasi Kesehatan Gigi & Mulut',
            'introduction'         => $introduction,
            'score_interpretation' => $scoreInterpretation,
            'priority_topics'      => $priorityTopics,
            'key_points'           => $keyPoints,
            'daily_habits'         => $dailyHabits,
            'when_to_seek_care'    => 'Segera periksakan diri ke dokter gigi jika kamu mengalami gusi yang mudah berdarah, gigi berdenyut nyeri, atau tampak bercak hitam berlubang. Tetap jadwalkan kunjungan rutin setiap 6 bulan sekali meskipun tanpa keluhan untuk menjaga senyum sehat jangka panjang.',
            'disclaimer'           => 'Materi edukasi ini disusun sebagai sarana peningkatan literasi kesehatan gigi dan mulut remaja, bukan merupakan diagnosis medis atau rencana terapi klinis langsung oleh dokter gigi.',
        ];
    }

}
