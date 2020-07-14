<?php

namespace App\Fetcher;


class BinFetcherException extends \Exception
{
    protected $message = 'Error getting BIN';
}