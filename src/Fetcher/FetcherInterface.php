<?php
declare(strict_types=1);

namespace App\Fetcher;

interface FetcherInterface
{
    const GET = 'GET';

    const POST = 'POST';

    const JSON = 'json';

    public function fetch();
}
