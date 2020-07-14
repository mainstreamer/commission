<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;

class CommissionCalculatorTest extends TestCase
{
    public function testEU(): void
    {
        $transactionDTO = new \App\DTO\TransactionDTO();
        $transactionDTO->amount = "100.00";
        $transactionDTO->bin = "1234";
        $transactionDTO->currency = 'EUR';

        $rateDTO = new \App\DTO\RateDTO();
        $rateDTO->rate = 0;

        $countryDTO = new \App\DTO\CountryDTO();
        $countryDTO->alpha2 = 'DK';

        $binDTO = new \App\DTO\BinDTO();
        $binDTO->country = $countryDTO;

        $service = new \App\Calculator\CommissionCalculator();

        self::assertEquals(1.0, $service->calculate($transactionDTO, $binDTO, $rateDTO));
    }

    public function testNonEu(): void
    {
        $transactionDTO = new \App\DTO\TransactionDTO();
        $transactionDTO->amount = "100.00";
        $transactionDTO->bin = "1234";
        $transactionDTO->currency = 'EUR';

        $rateDTO = new \App\DTO\RateDTO();
        $rateDTO->rate = 0;

        $countryDTO = new \App\DTO\CountryDTO();
        $countryDTO->alpha2 = 'TU';

        $binDTO = new \App\DTO\BinDTO();
        $binDTO->country = $countryDTO;

        $service = new \App\Calculator\CommissionCalculator();

        self::assertEquals(2.0, $service->calculate($transactionDTO, $binDTO, $rateDTO));
    }

    public function testUsdNonEu(): void
    {
        $transactionDTO = new \App\DTO\TransactionDTO();
        $transactionDTO->amount = "100.00";
        $transactionDTO->bin = "1234";
        $transactionDTO->currency = 'USD';

        $rateDTO = new \App\DTO\RateDTO();
        $rateDTO->rate = 0.9;

        $countryDTO = new \App\DTO\CountryDTO();
        $countryDTO->alpha2 = 'TU';

        $binDTO = new \App\DTO\BinDTO();
        $binDTO->country = $countryDTO;

        $service = new \App\Calculator\CommissionCalculator();

        self::assertEquals(2.22, $service->calculate($transactionDTO, $binDTO, $rateDTO));
    }
}
