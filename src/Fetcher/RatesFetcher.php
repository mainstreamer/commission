<?php
declare(strict_types=1);

namespace App\Fetcher;

use App\Calculator\CommissionCalculator;
use App\DTO\RateDTO;
use App\DTO\TransactionDTO;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class RatesFetcher
{
    private HttpClientInterface $httpClient;

    private SerializerInterface $serializer;

    private string $url = 'https://api.exchangeratesapi.io/latest';

    public function __construct(HttpClientInterface $httpClient, SerializerInterface $serializer)
    {
        $this->httpClient = $httpClient;

        $this->serializer = $serializer;
    }

    public function fetch(TransactionDTO $transactionDTO): RateDTO
    {
        $rate = new RateDTO();
        if ($transactionDTO->currency !== CommissionCalculator::EUR) {
            $payload = $this->httpClient->request(FetcherInterface::GET, $this->url)->getContent();
            $rates = json_decode($payload, true, 512, JSON_THROW_ON_ERROR);
            if (array_key_exists($transactionDTO->currency, $rates['rates'])) {
                $rate->rate = $rates['rates'][$transactionDTO->currency];
            }
        } else {
            $rate->rate = 0.0;
        }

        return $rate;
    }
}
