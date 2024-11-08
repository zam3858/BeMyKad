[![Latest Version on Packagist](https://img.shields.io/packagist/v/zam3858/bemykad.svg?style=flat-square)](https://packagist.org/packages/zam3858/bemykad) [![Fix PHP code style issues](https://github.com/zam3858/bemykad/actions/workflows/fix-php-code-style-issues.yml/badge.svg)](https://github.com/zam3858/bemykad/actions/workflows/fix-php-code-style-issues.yml) [![PHPStan](https://github.com/zam3858/bemykad/actions/workflows/phpstan.yml/badge.svg)](https://github.com/zam3858/bemykad/actions/workflows/phpstan.yml) [![Tests](https://github.com/zam3858/bemykad/actions/workflows/run-tests.yml/badge.svg)](https://github.com/zam3858/bemykad/actions/workflows/run-tests.yml) [![Total Downloads](https://img.shields.io/packagist/dt/zam3858/bemykad.svg?style=flat-square)](https://packagist.org/packages/zam3858/bemykad)

# BeMyKad

`BeMyKad` is a PHP package for extracting information from Malaysian MyKad numbers. This package helps validate MyKad numbers, retrieve the date of birth, gender, and identify the state or country of birth from the MyKad number.

## Installation

To install the package, use Composer:

```bash
composer require zam3858/bemykad
```

## Usage

Below is a simple example of how to use the `BeMyKad` class.

### Basic Example

```php
use BeMyKad\BeMyKad;

$mykadNumber = "960101-14-1234";
$mykad = new BeMyKad($mykadNumber);

// Validate the MyKad number
if ($mykad->isValid()) {
    echo "MyKad is valid\n";

    // Get date of birth
    echo "Date of Birth: " . $mykad->getDateOfBirth() . "\n";

    // Get gender
    $gender = $mykad->getGender() === BeMyKad::MALE ? 'Male' : 'Female';
    echo "Gender: " . $gender . "\n";

    // Get state or country of birth
    echo "Place of Birth: " . $mykad->getState() . "\n";
    
    /**
     * Outputs
     * {
     * "mykad": "960101141234",
     * "formatted": "960101-14-1234",
     * "isValid": true,
     * "dateOfBirth": "1996-01-01",
     * "gender": "Male",
     * "state": "Johor"
     * }
     */
    echo $mykad;
} else {
    echo "Invalid MyKad number.";
}
```

### Methods

- **`__construct(string $mykadNumber)`**: Initializes the `BeMyKad` instance with a MyKad number, automatically removing dashes for uniformity.
- **`isValid(): bool`**: Returns `true` if the MyKad number format and date of birth are valid.
- **`getDateOfBirth(): ?string`**: Returns the date of birth in `Y-m-d` format if valid, or `null` if invalid.
- **`getGender(): ?int`**: Returns `BeMyKad::MALE` or `BeMyKad::FEMALE` if valid, or `null` if invalid.
- **`getState(): ?string`**: Returns the place of birth (state or country) if valid. For codes that don't map to a specific place, returns `'Unknown'`.

### Validation Details

- **Date of Birth Validation**: Ensures the date part of the MyKad number is valid by verifying it corresponds to a real calendar date and matches the expected century.
- **Format Validation**: Ensures the MyKad number is in one of two acceptable formats: `YYMMDD-SS-SSSS` or `YYMMDDSSSSSS`.

### Handling Unmapped Codes

Certain codes, such as `'99'`, represent categories rather than specific locations and return `'Unknown'`. This ensures a consistent output for codes that indicate unspecified regions.

### Exceptions

The `BeMyKad` class does not throw exceptions by default for invalid MyKad numbers. Instead, validation methods (`isValid`, `getDateOfBirth`, `getGender`, `getState`) return `null` or `false` when the MyKad number is invalid.

## Additional Class: `BirthCountry`

The `BirthCountry` class contains the mappings for MyKad place-of-birth codes to their respective locations. You can retrieve the mapped location directly using the following method:

- **`getPlaceOfBirth(string $code): string`**: Returns the place of birth corresponding to the provided code. If the code is not recognized, it returns `'Unknown'`.

### Example Usage of `BirthCountry`

```php
use BeMyKad\BirthCountry;

echo BirthCountry::getPlaceOfBirth('10'); // Outputs: "Selangor"
echo BirthCountry::getPlaceOfBirth('99'); // Outputs: "Unknown"
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

We welcome contributions! Please see [CONTRIBUTING](CONTRIBUTING.md) for details on how to get involved.

## Security Vulnerabilities

If you discover any security issues, please review our [security policy](../../security/policy) for reporting vulnerabilities.

## Credits

- [Hizam Mohd](https://github.com/zam3858)
- [Nasrul Hazim](https://github.com/nasrulhazim)

## License

This package is open-sourced software licensed under the [MIT License](LICENSE.md).
