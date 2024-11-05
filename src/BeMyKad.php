<?php

namespace BeMyKad;

use DateTime;
use Exception;

/**
 * Class BeMyKad
 *
 * A class to handle and validate Malaysian MyKad numbers, providing utilities for gender,
 * date of birth, and state/place of birth based on the MyKad structure.
 */
class BeMyKad
{
    /** @var string The sanitized MyKad number without dashes */
    protected string $mykadNumber;

    /** @var int Gender constant for male */
    const MALE = 0;

    /** @var int Gender constant for female */
    const FEMALE = 1;

    /**
     * Constructor that initializes the MyKad number.
     * Removes any dashes for consistency.
     *
     * @param  string  $mykadNumber  The MyKad number to process.
     *
     * @throws Exception If any error occurs during initialization.
     */
    public function __construct(string $mykadNumber)
    {
        $this->mykadNumber = str_replace('-', '', $mykadNumber);
    }

    /**
     * Validates the MyKad number based on date of birth and format.
     *
     * @return bool True if the MyKad number is valid; otherwise, false.
     */
    public function isValid(): bool
    {
        return $this->validDOB() && $this->validFormat();
    }

    /**
     * Validates the date of birth part of the MyKad number.
     * Checks if the extracted date is a valid calendar date.
     *
     * @return bool True if the date of birth is valid; otherwise, false.
     */
    public function validDOB(): bool
    {
        $dobPart = substr($this->mykadNumber, 0, 6);
        $century = $this->getCentury();
        $dobString = $century.$dobPart;

        $dob = DateTime::createFromFormat('Ymd', $dobString);

        return $dob && $dob->format('Ymd') === $dobString;
    }

    /**
     * Validates the format of the MyKad number.
     * Supports both the basic 12-digit format and the dashed format (YYMMDD-SS-GGGG).
     *
     * @return bool True if the MyKad number format is valid; otherwise, false.
     */
    public function validFormat(): bool
    {
        return preg_match('/^\d{12}$/', $this->mykadNumber) || preg_match('/^\d{6}-\d{2}-\d{4}$/', $this->mykadNumber);
    }

    /**
     * Determines the century prefix based on the MyKad number's 9th digit.
     *
     * @return string "19" for the 1900s or "20" for the 2000s.
     */
    private function getCentury(): string
    {
        $ninthDigit = (int) substr($this->mykadNumber, 8, 1);

        return $ninthDigit > 4 ? '19' : '20';
    }

    /**
     * Extracts and returns the date of birth from the MyKad number in 'Y-m-d' format.
     * Returns null if the MyKad number is invalid.
     *
     * @return string|null The date of birth in 'Y-m-d' format or null if invalid.
     */
    public function getDateOfBirth(): ?string
    {
        if (! $this->isValid()) {
            return null;
        }

        $dobPart = substr($this->mykadNumber, 0, 6);
        $century = $this->getCentury();
        $dobString = $century.$dobPart;

        $dob = DateTime::createFromFormat('Ymd', $dobString);

        return $dob ? $dob->format('Y-m-d') : null;
    }

    /**
     * Determines the gender based on the last digit of the MyKad number.
     * Even number indicates female; odd number indicates male.
     *
     * @return int|null Returns self::FEMALE (0) or self::MALE (1), or null if invalid.
     */
    public function getGender(): ?int
    {
        if (! $this->isValid()) {
            return null;
        }

        return ((int) substr($this->mykadNumber, -1) % 2 === 0) ? self::FEMALE : self::MALE;
    }

    /**
     * Retrieves the state or place of birth based on the state code in the MyKad number.
     * Returns null if the MyKad number is invalid.
     *
     * @return string|null The state or place of birth associated with the MyKad number or null if invalid.
     */
    public function getState(): ?string
    {
        if (! $this->isValid()) {
            return null;
        }

        $pbCode = substr($this->mykadNumber, 6, 2);

        return BirthCountry::getPlaceOfBirth($pbCode);
    }
}
