# BeMyKad

`BeMyKad` is a PHP package for managing and extracting information from Malaysian MyKad numbers. This package helps validate MyKad numbers, retrieve the date of birth, determine the gender, and identify the state or country of birth based on the MyKad number.

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
} else {
    echo "Invalid MyKad number.";
}
```

### Methods

- **`__construct(string $mykadNumber)`**: Initializes the `BeMyKad` instance with a MyKad number.
- **`isValid(): bool`**: Returns `true` if the MyKad number format and date of birth are valid.
- **`getDateOfBirth(): ?string`**: Returns the date of birth in `Y-m-d` format if valid, or `null` if invalid.
- **`getGender(): ?int`**: Returns `BeMyKad::MALE` or `BeMyKad::FEMALE` if valid, or `null` if invalid.
- **`getState(): ?string`**: Returns the place of birth (state or country) if valid, or `null` if invalid.

### Validation Details

- **Date of Birth Validation**: Checks that the date part of the MyKad number is valid and accurately formatted.
- **Format Validation**: Ensures the MyKad number is in the correct format (`YYMMDD-SS-SSSS` or `YYMMDDSSSSSS`).

### Exceptions

The `BeMyKad` class does not throw exceptions by default for invalid MyKad numbers. Instead, validation methods (`isValid`, `getDateOfBirth`, `getGender`, `getState`) return `null` or `false` when the MyKad number is invalid.

---

## License

This package is open-source and available under the [MIT license](LICENSE).

---

