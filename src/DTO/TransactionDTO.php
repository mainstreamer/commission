<?php
declare(strict_types=1);

namespace App\DTO;

class TransactionDTO
{
    public string $bin;
    public string $amount;
    public string $currency;
}
