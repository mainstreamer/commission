<?php

namespace App\Fetcher;


class RatesFetcherException extends \Exception
{
    protected $message = 'Error getting rates';
}