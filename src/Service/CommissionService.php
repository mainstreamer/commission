<?php
declare(strict_types=1);

namespace App\Service;

use App\Calculator\CommissionCalculator;
use App\DTO\TransactionDTO;
use App\Fetcher\BinFetcher;
use App\Fetcher\RatesFetcher;

class CommissionService
{
    private BinFetcher $binFetcher;

    private RatesFetcher $ratesFetcher;

    private CommissionCalculator $calculator;

    public function __construct(BinFetcher $binFetcher, RatesFetcher $ratesFetcher, CommissionCalculator $calculator)
    {
        $this->binFetcher = $binFetcher;
        $this->ratesFetcher = $ratesFetcher;
        $this->calculator = $calculator;
    }

    public function getCommission(TransactionDTO $transactionDTO): float
    {
        $binDTO = $this->binFetcher->fetch($transactionDTO);
        $rateDTO = $this->ratesFetcher->fetch($transactionDTO);

        return $this->calculator->calculate($transactionDTO, $binDTO, $rateDTO);
    }
}
