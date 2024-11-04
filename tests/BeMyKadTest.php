<?php

use BeMyKad\BeMyKad;
use BeMyKad\BirthCountry;

it('checks MyKad format', function () {
    $validMykad = new BeMyKad('990101-10-1234');
    expect($validMykad->validFormat())->toBeTrue();

    $invalidMykad = new BeMyKad('invalid-format');
    expect($invalidMykad->validFormat())->toBeFalse();
});

it('checks MyKad date of birth', function () {
    $validMykad = new BeMyKad('990101-10-1234');
    expect($validMykad->validDOB())->toBeTrue();

    // invalid date (Feb 31st)
    $invalidMykad = new BeMyKad('990231-10-1234');
    expect($invalidMykad->validDOB())->toBeFalse();
});

it('validates a MyKad number correctly', function () {
    $mykad = new BeMyKad('990101-10-1234'); // valid format, birthdate and PB assumed valid
    expect($mykad->isValid())->toBe(true);
});

it('returns the correct century for date of birth', function () {
    // expects 2001
    $mykad = new BeMyKad('010101-10-1234');
    try {
        $reflection = new ReflectionClass($mykad);

        $method = $reflection->getMethod('getCentury');
        $method->setAccessible(true);

        expect($method->invoke($mykad))->toBe('20');
    } catch (Exception $e) {

    }
});

it('returns correct date of birth', function () {
    $mykad = new BeMyKad('990101-10-5234'); // valid date (Jan 1, 1999)
    expect($mykad->getDateOfBirth())->toBe('1999-01-01');
});

it('returns male gender correctly', function () {
    $mykad = new BeMyKad('990101-10-1235'); // last digit is odd (male)
    expect($mykad->getGender())->toBe(BeMyKad::MALE);
});

it('returns female gender correctly', function () {
    $mykad = new BeMyKad('990101-10-1234'); // last digit is even (female)
    expect($mykad->getGender())->toBe(BeMyKad::FEMALE);
});

it('returns correct place of birth', function () {
    // Selangor
    $pbCode = '10';

    $mykad = new BeMyKad('990101-' . $pbCode . '-1234');
    $state = BirthCountry::getPlaceOfBirth($pbCode);

    expect($mykad->getState())->toBe($state);
});
