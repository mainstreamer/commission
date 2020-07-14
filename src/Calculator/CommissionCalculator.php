<?php
declare(strict_types=1);

namespace App\Calculator;

use App\DTO\BinDTO;
use App\DTO\RateDTO;
use App\DTO\TransactionDTO;

class CommissionCalculator
{
    const EUR = 'EUR';

    public function calculate(TransactionDTO $transactionDTO, BinDTO $binDTO, RateDTO $rateDTO): float
    {
        return round($this->getFixedAmount($transactionDTO, $rateDTO) * $this->getCoefficient($binDTO), 2);
    }

    private function isEU(string $countryCode): bool
    {
        return (bool) preg_match('/AT|B[EG]|C[YZ]|D[EK]|E[ES]|F[IR]|G[R]|H[RU]|I[ET]|L[TUV]|MT|NL|P[OT]|RO|S[EIK]/', $countryCode);
    }

    private function getCoefficient(BinDTO $binDTO): float
    {
        return $this->isEU($binDTO->country->alpha2) ? 0.01 : 0.02;
    }

    private function getFixedAmount(TransactionDTO $transactionDTO, RateDTO $rateDTO): float
    {
        if ($rateDTO->rate != 0) {

            return (float) $transactionDTO->amount / (float) $rateDTO->rate;
        }

        return (float) $transactionDTO->amount;
    }
}
