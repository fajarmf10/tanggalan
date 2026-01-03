# Tanggalan

[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)
[![PHP Version](https://img.shields.io/badge/PHP-8.1%2B-blue.svg)](https://php.net)

> Library PHP untuk konversi kalender Jawa dan Hijriah dengan integrasi Laravel

🇮🇩 Bahasa Indonesia | [🇬🇧 English](README.md)

## Fitur

- ✅ Konversi Gregorian ↔ Hijriah (algoritma Um Al-Qura)
- ✅ Konversi Gregorian ↔ Jawa dengan perhitungan Weton
- ✅ Perhitungan Pasaran & Neptu
- ✅ Core yang framework-agnostic (bisa dipakai di framework PHP apa saja)
- ✅ Integrasi Laravel (facades, helpers, Carbon mixins, validation rules)
- ✅ Objek tanggal yang immutable (thread-safe)
- ✅ Dukungan multibahasa (Indonesia, Inggris, Jawa, Arab)
- ✅ Mengikuti prinsip SOLID & clean architecture
- ✅ Type-safe dengan fitur PHP 8.1+

## Instalasi

### Untuk Proyek Laravel

```bash
composer require fajarmf10/tanggalan
```

Publikasikan file konfigurasi:

```bash
php artisan tanggalan:install
```

### Untuk Proyek PHP Non-Laravel

```bash
composer require fajarmf10/tanggalan
```

## Panduan Cepat

### Penggunaan Dasar (Framework-Agnostic)

```php
use Tanggalan\Tanggalan;

// Gregorian → Hijriah
$hijri = Tanggalan::toHijri('2025-01-04');
echo $hijri->format(); // "5 Rajab 1446 H"

// Gregorian → Jawa (dengan Weton)
$jawa = Tanggalan::toJavanese('2025-01-04');
echo $jawa->getWeton(); // "Sabtu Kliwon"
echo $jawa->getNeptu(); // 17

// Hijriah → Gregorian
$gregorian = Tanggalan::fromHijri(1446, 7, 5);
echo $gregorian->format('Y-m-d'); // "2025-01-04"

// Hanya ambil Weton
$weton = Tanggalan::getWeton('2025-01-04');
echo $weton; // "Sabtu Kliwon"
```

### Penggunaan di Laravel

#### Menggunakan Facade

```php
use Tanggalan\Laravel\Facades\Tanggalan;

$hijri = Tanggalan::toHijri('2025-01-04');
$weton = Tanggalan::getWeton('2025-01-04');
```

#### Menggunakan Helper Functions

```php
$hijri = to_hijri('2025-01-04');
$jawa = to_javanese('2025-01-04');
$weton = get_weton('2025-01-04');
$gregorian = from_hijri(1446, 7, 5);
```

#### Menggunakan Carbon Mixin

```php
use Carbon\Carbon;

$carbon = Carbon::now();

// Konversi ke Hijriah
$hijri = $carbon->toHijri();
echo $hijri->format('d F Y H', 'id'); // "5 Rajab 1446 H"

// Ambil Weton
$weton = $carbon->getWeton();
echo $weton->format('jv'); // "Setu Kliwon"

// Format sebagai Hijriah
echo $carbon->formatHijri('d F Y H', 'id');

// Buat dari tanggal Hijriah
$carbon = Carbon::createFromHijri(1446, 7, 5);
```

#### Validation Rules

```php
use Tanggalan\Laravel\Rules\ValidHijriDate;
use Tanggalan\Laravel\Rules\ValidJavaneseDate;

$request->validate([
    'tanggal_lahir' => ['required', 'date', new ValidHijriDate()],
    'tanggal_acara' => ['required', 'date', new ValidJavaneseDate()],
]);
```

## Penggunaan Lanjutan

### Algoritma Kalender Hijriah

**Dua algoritma tersedia:**

#### 1. Algoritma Um Al-Qura (Default - Direkomendasikan)
- Berdasarkan kalender resmi Arab Saudi
- Menggunakan pengamatan astronomi sebenarnya
- **Akurat untuk tahun 1440-1500 H (2018-2079 M)**
- Paling akurat untuk tanggal saat ini/dekat

```php
// Default - menggunakan Um Al-Qura
$hijri = Tanggalan::toHijri('2025-01-04');
```

#### 2. Algoritma Tabular Islam (Tanpa hardcode!)
- **Perhitungan matematis murni - TANPA tabel lookup!**
- Bekerja untuk **SEMUA tanggal** (rentang tak terbatas)
- Mungkin berbeda ±1 hari dari Um Al-Qura
- Dapat diprediksi dan konsisten

```php
// Gunakan algoritma Tabular
$tanggalan = Tanggalan::withTabularAlgorithm();
$hijri = $tanggalan->toHijri('1850-01-01'); // Untuk tanggal historis!
$hijri = $tanggalan->toHijri('2500-01-01'); // Untuk tanggal masa depan!
```

#### Perbandingan:
| Fitur | Um Al-Qura | Tabular Islam |
|-------|------------|---------------|
| Akurasi | ±0 hari (pengamatan aktual) | ±1 hari |
| Rentang Tanggal | 2018-2079 M | Tak terbatas |
| Tabel Lookup | Ya (61 tahun) | Tidak (matematis murni) |
| Kecepatan | Cepat | Cepat |
| Kasus Penggunaan | Tanggal saat ini | Semua tanggal (historis/masa depan) |

### Penyesuaian Tanggal Hijriah

Beberapa daerah mungkin memulai bulan Hijriah sehari lebih awal atau lambat karena perbedaan ru'yat hilal:

```php
// Sesuaikan dengan -1, 0, atau +1 hari
$tanggalan = Tanggalan::withAdjustment(-1);
$hijri = $tanggalan->toHijri('2025-01-04');

// Atau dengan algoritma Tabular + penyesuaian
$tanggalan = Tanggalan::withTabularAlgorithm(-1);
```

Di Laravel, atur ini di `config/tanggalan.php`:

```php
'hijri_adjustment' => -1, // atau set TANGGALAN_HIJRI_ADJUSTMENT di .env
```

### Opsi Formatting

```php
// Format tanggal Hijriah
$hijri = Tanggalan::toHijri('2025-01-04');

echo $hijri->format('d F Y H', 'id'); // "5 Rajab 1446 H" (Indonesia)
echo $hijri->format('d F Y H', 'en'); // "5 Rajab 1446 H" (Inggris)
echo $hijri->format('d F Y H', 'ar'); // "5 رَجَب 1446 ه" (Arab)

// Format Jawa/Weton
$weton = Tanggalan::getWeton('2025-01-04');

echo $weton->format('id'); // "Sabtu Kliwon" (Indonesia)
echo $weton->format('jv'); // "Setu Kliwon" (Jawa)
echo $weton->format('en'); // "Saturday Kliwon" (Inggris)

// Dapatkan sebagai array
print_r($hijri->toArray());
print_r($weton->toArray());
```

## Konfigurasi

### Konfigurasi Laravel

Publikasikan dan edit `config/tanggalan.php`:

```php
return [
    // Penyesuaian kalender Hijriah (-1, 0, atau +1)
    'hijri_adjustment' => 0,

    // Locale default (id, en, jv, ar)
    'locale' => 'id',

    // Aktifkan Carbon macros
    'enable_carbon_macros' => true,
];
```

### Environment Variables

```env
TANGGALAN_HIJRI_ADJUSTMENT=0
TANGGALAN_LOCALE=id
TANGGALAN_ENABLE_CARBON_MACROS=true
```

## Memahami Kalender Jawa

### Weton

Weton adalah kombinasi unik dari:
- **Dino pitu (7 hari)**: Senin, Selasa, Rabu, Kamis, Jumat, Sabtu, Minggu
- **Pasaran (5 hari)**: Legi, Pahing, Pon, Wage, Kliwon

Ini menciptakan siklus 35 hari (7 × 5 = 35), dengan setiap kombinasi memiliki makna budaya dalam tradisi Jawa.

### Neptu

Neptu adalah nilai numerologi yang digunakan dalam primbon Jawa:
- Setiap hari memiliki nilai neptu
- Setiap pasaran memiliki nilai neptu
- Total neptu = neptu hari + neptu pasaran

```php
$weton = Tanggalan::getWeton('2025-01-04'); // Sabtu Kliwon
$neptu = $weton->getNeptu(); // 17 (Sabtu=9 + Kliwon=8)
```

**Penafsiran Neptu Tradisional:**
- ≤ 9: Sri (Makmur)
- 10-12: Lungguh (Tenang)
- 13-15: Lara (Sengsara)
- 16-18: Pati (Kematian)
- \> 18: Sri (Makmur)

## Arsitektur

Library ini mengikuti **prinsip SOLID** dan **clean architecture**:

- **Single Responsibility**: Setiap class punya satu tujuan yang jelas
- **Open/Closed**: Bisa diperluas melalui interface
- **Liskov Substitution**: Semua implementasi bisa diganti
- **Interface Segregation**: Interface yang fokus dan spesifik
- **Dependency Inversion**: Bergantung pada abstraksi

### Komponen Utama

- **Value Objects**: Representasi tanggal yang immutable (HijriDate, JavaneseDate, Weton)
- **Algorithms**: Algoritma konversi yang pluggable (UmAlQuraAlgorithm)
- **Converters**: Logika konversi tanggal dengan dependency injection
- **Calculators**: Perhitungan khusus (WetonCalculator, NeptuCalculator)
- **Enums**: Enumerasi yang type-safe (PasaranDay, JavaneseDay, HijriMonth)

## Testing

```bash
composer install
vendor/bin/phpunit
```

## Kontribusi

Kontribusi sangat diterima! Silakan baca [Panduan Kontribusi](CONTRIBUTING.md) terlebih dahulu.

1. Fork repository ini
2. Buat feature branch (`git checkout -b feature/fitur-keren`)
3. Commit perubahan Anda (`git commit -m 'Tambah fitur keren'`)
4. Push ke branch (`git push origin feature/fitur-keren`)
5. Buat Pull Request

## Lisensi

Proyek ini dilisensikan di bawah MIT License - lihat file [LICENSE](LICENSE) untuk detail.

## Kredit

- **Pembuat**: [Fajar Maulana Firdaus](https://github.com/fajarmf10)
- **Algoritma Hijriah**: Berdasarkan kalender Um Al-Qura (Arab Saudi)
- **Kalender Jawa**: Sistem kalender Jawa tradisional

## Dukungan

- 📧 Email: fajarmf78@gmail.com
- 🐛 Issues: [GitHub Issues](https://github.com/fajarmf10/tanggalan/issues)
- 📖 Dokumentasi: [GitHub Wiki](https://github.com/fajarmf10/tanggalan/wiki)

---

Dibuat dengan ❤️ untuk komunitas developer Indonesia dan dunia
