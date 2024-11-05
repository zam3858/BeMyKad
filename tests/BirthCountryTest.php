<?php

use BeMyKad\BirthCountry;

it('returns correct place of birth for valid codes', function () {
    expect(BirthCountry::getPlaceOfBirth('01'))->toBe('Johor');
    expect(BirthCountry::getPlaceOfBirth('10'))->toBe('Selangor');
    expect(BirthCountry::getPlaceOfBirth('14'))->toBe('Federal Territory of Kuala Lumpur');
});

it('returns unknown for invalid or unmapped codes', function () {
    expect(BirthCountry::getPlaceOfBirth('99'))->toBe('No Information / Refugee');
    expect(BirthCountry::getPlaceOfBirth('XX'))->toBe('Unknown');
});
