# Tanggalan

[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)
[![PHP Version](https://img.shields.io/badge/PHP-8.1%2B-blue.svg)](https://php.net)

> PHP library for Javanese and Hijri calendar conversions with Laravel integration

[🇮🇩 Bahasa Indonesia](README.id.md) | 🇬🇧 English

## Features

- ✅ Gregorian ↔ Hijri conversion (Um Al-Qura algorithm)
- ✅ Gregorian ↔ Javanese conversion with Weton calculation
- ✅ Pasaran & Neptu calculation
- ✅ Framework-agnostic core (works with any PHP framework)
- ✅ Laravel integration (facades, helpers, Carbon mixins, validation rules)
- ✅ Immutable date objects (thread-safe)
- ✅ Multilingual support (Indonesian, English, Javanese, Arabic)
- ✅ SOLID principles & clean architecture
- ✅ Type-safe with PHP 8.1+ features

## Installation

### For Laravel Projects

```bash
composer require fajarmf10/tanggalan
```

Publish the configuration file:

```bash
php artisan tanggalan:install
```

### For Non-Laravel PHP Projects

```bash
composer require fajarmf10/tanggalan
```

## Quick Start

### Basic Usage (Framework-Agnostic)

```php
use Tanggalan\Tanggalan;

// Gregorian → Hijri
$hijri = Tanggalan::toHijri('2025-01-04');
echo $hijri->format(); // "5 Rajab 1446 H"

// Gregorian → Javanese (with Weton)
$javanese = Tanggalan::toJavanese('2025-01-04');
echo $javanese->getWeton(); // "Sabtu Kliwon"
echo $javanese->getNeptu(); // 17

// Hijri → Gregorian
$gregorian = Tanggalan::fromHijri(1446, 7, 5);
echo $gregorian->format('Y-m-d'); // "2025-01-04"

// Get Weton only
$weton = Tanggalan::getWeton('2025-01-04');
echo $weton; // "Sabtu Kliwon"
```

### Laravel Usage

#### Using Facade

```php
use Tanggalan\Laravel\Facades\Tanggalan;

$hijri = Tanggalan::toHijri('2025-01-04');
$weton = Tanggalan::getWeton('2025-01-04');
```

#### Using Helper Functions

```php
$hijri = to_hijri('2025-01-04');
$javanese = to_javanese('2025-01-04');
$weton = get_weton('2025-01-04');
$gregorian = from_hijri(1446, 7, 5);
```

#### Using Carbon Mixin

```php
use Carbon\Carbon;

$carbon = Carbon::now();

// Convert to Hijri
$hijri = $carbon->toHijri();
echo $hijri->format('d F Y H', 'id'); // "5 Rajab 1446 H"

// Get Weton
$weton = $carbon->getWeton();
echo $weton->format('jv'); // "Setu Kliwon"

// Format as Hijri
echo $carbon->formatHijri('d F Y H', 'ar'); // Arabic format

// Create from Hijri
$carbon = Carbon::createFromHijri(1446, 7, 5);
```

#### Validation Rules

```php
use Tanggalan\Laravel\Rules\ValidHijriDate;
use Tanggalan\Laravel\Rules\ValidJavaneseDate;

$request->validate([
    'birth_date' => ['required', 'date', new ValidHijriDate()],
    'event_date' => ['required', 'date', new ValidJavaneseDate()],
]);
```

## Advanced Usage

### Hijri Calendar Algorithms

**Two algorithms available:**

#### 1. Um Al-Qura Algorithm (Default - Recommended)
- Based on official Saudi Arabian calendar
- Uses actual astronomical observations
- **Accurate for years 1440-1500 AH (2018-2079 CE)**
- Most accurate for current/near dates

```php
// Default - uses Um Al-Qura
$hijri = Tanggalan::toHijri('2025-01-04');
```

#### 2. Tabular Islamic Algorithm (No hardcoding!)
- **Pure mathematical calculation - NO lookup tables!**
- Works for **ANY date** (unlimited range)
- May differ by ±1 day from Um Al-Qura
- Predictable and consistent

```php
// Use Tabular algorithm
$tanggalan = Tanggalan::withTabularAlgorithm();
$hijri = $tanggalan->toHijri('1850-01-01'); // Works for historical dates!
$hijri = $tanggalan->toHijri('2500-01-01'); // Works for future dates!
```

#### Comparison:
| Feature | Um Al-Qura | Tabular Islamic |
|---------|------------|-----------------|
| Accuracy | ±0 days (actual observations) | ±1 day |
| Date Range | 2018-2079 CE | Unlimited |
| Lookup Table | Yes (61 years) | No (pure math) |
| Speed | Fast | Fast |
| Use Case | Current dates | Any date (historical/future) |

### Hijri Date Adjustment

Some regions may observe Hijri months starting a day earlier or later due to moon sighting differences:

```php
// Adjust by -1, 0, or +1 day
$tanggalan = Tanggalan::withAdjustment(-1);
$hijri = $tanggalan->toHijri('2025-01-04');

// Or with Tabular algorithm + adjustment
$tanggalan = Tanggalan::withTabularAlgorithm(-1);
```

In Laravel, configure this in `config/tanggalan.php`:

```php
'hijri_adjustment' => -1, // or set TANGGALAN_HIJRI_ADJUSTMENT in .env
```

### Formatting Options

```php
// Hijri date formatting
$hijri = Tanggalan::toHijri('2025-01-04');

echo $hijri->format('d F Y H', 'id'); // "5 Rajab 1446 H" (Indonesian)
echo $hijri->format('d F Y H', 'en'); // "5 Rajab 1446 H" (English)
echo $hijri->format('d F Y H', 'ar'); // "5 رَجَب 1446 ه" (Arabic)

// Javanese/Weton formatting
$weton = Tanggalan::getWeton('2025-01-04');

echo $weton->format('id'); // "Sabtu Kliwon" (Indonesian)
echo $weton->format('jv'); // "Setu Kliwon" (Javanese)
echo $weton->format('en'); // "Saturday Kliwon" (English)

// Get as array
print_r($hijri->toArray());
print_r($weton->toArray());
```

## Configuration

### Laravel Configuration

Publish and edit `config/tanggalan.php`:

```php
return [
    // Hijri calendar adjustment (-1, 0, or +1)
    'hijri_adjustment' => 0,

    // Default locale (id, en, jv, ar)
    'locale' => 'id',

    // Enable Carbon macros
    'enable_carbon_macros' => true,
];
```

### Environment Variables

```env
TANGGALAN_HIJRI_ADJUSTMENT=0
TANGGALAN_LOCALE=id
TANGGALAN_ENABLE_CARBON_MACROS=true
```

## Understanding Javanese Calendar

### Weton

Weton is a unique combination of:
- **7-day week**: Senin, Selasa, Rabu, Kamis, Jumat, Sabtu, Minggu
- **5-day Pasaran**: Legi, Pahing, Pon, Wage, Kliwon

This creates a 35-day cycle (7 × 5 = 35), with each combination having cultural significance in Javanese tradition.

### Neptu

Neptu is a numerological value used in Javanese divination:
- Each day has a neptu value
- Each pasaran has a neptu value
- Total neptu = day neptu + pasaran neptu

```php
$weton = Tanggalan::getWeton('2025-01-04'); // Sabtu Kliwon
$neptu = $weton->getNeptu(); // 17 (Sabtu=9 + Kliwon=8)
```

## Architecture

This library follows **SOLID principles** and **clean architecture**:

- **Single Responsibility**: Each class has one clear purpose
- **Open/Closed**: Extensible through interfaces
- **Liskov Substitution**: All implementations are substitutable
- **Interface Segregation**: Focused, specific interfaces
- **Dependency Inversion**: Depends on abstractions

### Key Components

- **Value Objects**: Immutable date representations (HijriDate, JavaneseDate, Weton)
- **Algorithms**: Pluggable conversion algorithms (UmAlQuraAlgorithm)
- **Converters**: Date conversion logic with dependency injection
- **Calculators**: Specialized calculations (WetonCalculator, NeptuCalculator)
- **Enums**: Type-safe enumerations (PasaranDay, JavaneseDay, HijriMonth)

## Testing

```bash
composer install
vendor/bin/phpunit
```

## Contributing

Contributions are welcome! Please read our [Contributing Guide](CONTRIBUTING.md) first.

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add some amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## Credits

- **Author**: [Fajar Maulana Firdaus](https://github.com/fajarmf10)
- **Hijri Algorithm**: Based on Um Al-Qura calendar (Saudi Arabia)
- **Javanese Calendar**: Traditional Javanese calendar system

## Support

- 📧 Email: fajarmf78@gmail.com
- 🐛 Issues: [GitHub Issues](https://github.com/fajarmf10/tanggalan/issues)
- 📖 Documentation: [GitHub Wiki](https://github.com/fajarmf10/tanggalan/wiki)

---

Made with ❤️ for the Indonesian developer community and the world
