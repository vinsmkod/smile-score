<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Auth;

abstract class TestCase extends BaseTestCase
{
    /**
     * Setelah setiap test, logout dari semua guard yang dikonfigurasi.
     * Ini mencegah session auth bocor antar class test saat menjalankan
     * seluruh test suite dalam satu proses (php artisan test).
     */
    protected function tearDown(): void
    {
        foreach (array_keys(config('auth.guards', [])) as $guard) {
            try {
                Auth::guard($guard)->logout();
            } catch (\Throwable) {
                // Guard tertentu (misal: token-only) tidak mendukung logout statis; abaikan.
            }
        }

        parent::tearDown();
    }
}

