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

    $invalidMykad = new BeMyKad('990231-10-1234');
    expect($invalidMykad->validDOB())->toBeFalse();
});

it('validates a MyKad number correctly', function () {
    $mykad = new BeMyKad('990101-10-1234');
    expect($mykad->isValid())->toBeTrue();

    $invalidMykad = new BeMyKad('990231-10-1234');
    expect($invalidMykad->isValid())->toBeFalse();
});

it('returns correct date of birth', function () {
    $mykad = new BeMyKad('990101-10-5234');
    expect($mykad->getDateOfBirth())->toBe('1999-01-01');

    $invalidMykad = new BeMyKad('990231-10-1234');
    expect($invalidMykad->getDateOfBirth())->toBeNull();
});

it('returns gender correctly', function () {
    $maleMykad = new BeMyKad('990101-10-1235');
    expect($maleMykad->getGender())->toBe(BeMyKad::MALE);

    $femaleMykad = new BeMyKad('990101-10-1234');
    expect($femaleMykad->getGender())->toBe(BeMyKad::FEMALE);
});

it('returns correct place of birth', function () {
    $pbCode = '10';
    $mykad = new BeMyKad('990101-'.$pbCode.'-1234');

    expect($mykad->getState())->toBe(BirthCountry::getPlaceOfBirth($pbCode));

    // Adjusting to match 'No Information / Refugee' for code '99'
    $invalidMykad = new BeMyKad('990101-99-1234');
    expect($invalidMykad->getState())->toBe('No Information / Refugee');
});
