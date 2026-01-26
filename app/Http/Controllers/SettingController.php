<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    /**
     * Menampilkan halaman form pengaturan.
     */
    public function index()
    {
        // Ambil semua setting dari database menjadi array [key => value]
        $settings = Setting::pluck('value', 'key')->toArray();

        return view('admin.settings.index', compact('settings'));
    }

    /**
     * Memproses update pengaturan (Gambar & Teks).
     */
    public function update(Request $request)
    {
        // 1. VALIDASI INPUT
        $request->validate([
            // Validasi Gambar
            'site_logo'   => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048', // Logo Atas
            'footer_logo' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048', // Logo Bawah (Baru)
            'hero_bg'     => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120', // Background

            // Validasi Teks Footer & Kontak
            'footer_address'       => 'nullable|string',
            'footer_email'         => 'nullable|email',
            'footer_phone'         => 'nullable|string',
            'footer_hours_weekday' => 'nullable|string',
            'footer_hours_friday'  => 'nullable|string',
            'contact_google_maps_link' => 'nullable|string',

            // Validasi Laporan PDF
            'report_header_address'  => 'nullable|string',
            'report_signer_name'     => 'nullable|string',
            'report_signer_nip'      => 'nullable|string',
            'report_signer_rank'     => 'nullable|string',
            'report_signer_position' => 'nullable|string',

            // Validasi Sosial Media
            'social_facebook'  => 'nullable|url',
            'social_instagram' => 'nullable|url',
            'social_twitter'   => 'nullable|url',
            'social_youtube'   => 'nullable|url',
        ]);

        // 2. PROSES UPDATE LOGO NAVBAR (site_logo)
        if ($request->hasFile('site_logo')) {
            // Hapus file lama jika ada
            $oldLogo = Setting::where('key', 'site_logo')->value('value');
            if ($oldLogo && Storage::disk('public')->exists($oldLogo)) {
                Storage::disk('public')->delete($oldLogo);
            }

            // Upload baru
            $path = $request->file('site_logo')->store('settings', 'public');

            // Simpan ke DB
            Setting::updateOrCreate(['key' => 'site_logo'], ['value' => $path]);
        }

        // 3. PROSES UPDATE LOGO FOOTER (footer_logo) - BARU
        if ($request->hasFile('footer_logo')) {
            // Hapus file lama jika ada
            $oldFooterLogo = Setting::where('key', 'footer_logo')->value('value');
            if ($oldFooterLogo && Storage::disk('public')->exists($oldFooterLogo)) {
                Storage::disk('public')->delete($oldFooterLogo);
            }

            // Upload baru
            $path = $request->file('footer_logo')->store('settings', 'public');

            // Simpan ke DB
            Setting::updateOrCreate(['key' => 'footer_logo'], ['value' => $path]);
        }

        // 4. PROSES UPDATE HERO BACKGROUND (hero_bg)
        if ($request->hasFile('hero_bg')) {
            // Hapus file lama jika ada
            $oldBg = Setting::where('key', 'hero_bg')->value('value');
            if ($oldBg && Storage::disk('public')->exists($oldBg)) {
                Storage::disk('public')->delete($oldBg);
            }

            // Upload baru
            $path = $request->file('hero_bg')->store('settings', 'public');

            // Simpan ke DB
            Setting::updateOrCreate(['key' => 'hero_bg'], ['value' => $path]);
        }

        // 5. PROSES UPDATE TEKS FOOTER & SOSMED (Looping)
        $textSettings = [
            'footer_address',
            'footer_email',
            'footer_phone',
            'footer_hours_weekday',
            'footer_hours_friday',
            'social_facebook',
            'social_instagram',
            'social_twitter',
            'social_twitter',
            'social_youtube',
            'social_twitter',
            'social_youtube',
            'contact_google_maps_link',
            
            // Setting Laporan
            'report_header_address',
            'report_signer_name',
            'report_signer_nip',
            'report_signer_rank',
            'report_signer_position'
        ];

        // LOGIKA KHUSUS: Jika user paste <iframe> map, ambil src-nya saja
        if ($request->filled('contact_google_maps_link')) {
            $mapInput = $request->input('contact_google_maps_link');
            if (str_contains($mapInput, '<iframe') && str_contains($mapInput, 'src="')) {
                // Ambil URL di dalam src="..."
                preg_match('/src="([^"]+)"/', $mapInput, $match);
                if (isset($match[1])) {
                    $request->merge(['contact_google_maps_link' => $match[1]]);
                }
            }
        }

        foreach ($textSettings as $key) {
            // Update atau Create jika belum ada
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $request->input($key)]
            );
        }

        return redirect()->back()->with('success', 'Pengaturan tampilan berhasil diperbarui!');
    }
}
