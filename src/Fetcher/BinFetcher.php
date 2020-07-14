<?php
declare(strict_types=1);

namespace App\Fetcher;

use App\DTO\BinDTO;
use App\DTO\TransactionDTO;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class BinFetcher
{
    private HttpClientInterface $httpClient;

    private SerializerInterface $serializer;

    private string $url = 'https://lookup.binlist.net/';

    public function __construct(HttpClientInterface $httpClient, SerializerInterface $serializer)
    {
        $this->httpClient = $httpClient;
        $this->serializer = $serializer;
    }

    public function fetch(TransactionDTO $transactionDTO): BinDTO
    {
        try {
            $payload = $this->httpClient->request(FetcherInterface::GET, $this->url.$transactionDTO->bin)->getContent();
        } catch (\Throwable $e) {
            throw new BinFetcherException('Failed to fetch Bin');
        }

        return $this->deserialize($payload);
    }

    private function deserialize(string $payload): BinDTO
    {
        try {
            $bin = $this->serializer->deserialize($payload, BinDTO::class, FetcherInterface::JSON);
            if (!$bin instanceof BinDTO) {throw new \Exception();}
        } catch (\Throwable $e) {
            throw new BinFetcherException();
        }

        return $bin;
    }
}
