<?php

require __DIR__ . '/vendor/autoload.php';

$httpClient = Symfony\Component\HttpClient\HttpClient::create();

$serializer = new \Symfony\Component\Serializer\Serializer([new \Symfony\Component\Serializer\Normalizer\ObjectNormalizer(null, null, null, new \Symfony\Component\PropertyInfo\Extractor\ReflectionExtractor())], [new \Symfony\Component\Serializer\Encoder\JsonEncoder()] );

$binFetcher = new \App\Fetcher\BinFetcher($httpClient, $serializer);
$ratesFetcher = new \App\Fetcher\RatesFetcher($httpClient, $serializer);
$commissionCalculator = new \App\Calculator\CommissionCalculator();
$app = new \App\Service\CommissionService($binFetcher, $ratesFetcher, $commissionCalculator);
$transactions = file($argv[1]);

foreach ($transactions as $transaction) {
     echo $app->getCommission($serializer->deserialize($transaction, \App\DTO\TransactionDTO::class, 'json')).PHP_EOL;
}
