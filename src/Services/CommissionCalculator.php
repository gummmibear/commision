<?php

namespace App\Services;

use App\Services\Importer\Query\GetBinQuery;
use App\Services\Importer\ValueObjects\ExchangeRates;
use App\Services\Importer\ValueObjects\TransactionCollection;

class CommissionCalculator
{
    public function __construct(private GetBinQuery $getBinQuery, private EuCuntry $euCuntry)
    {
    }

    public function calculate(TransactionCollection $transactions, ExchangeRates $exchangeRates)
    {
        $commission = [];

        foreach ($transactions->list() as $transaction) {
            $bin = ($this->getBinQuery)($transaction->bin);
            $isEu = $this->euCuntry->isEU($bin->country());
            $rate = $exchangeRates->getFor($transaction->currency);

            if ($transaction->isEuro() || $rate === 0.0) {
                $amountFixed = $transaction->amount;
            }

            if (!$transaction->isEuro() || $rate > 0) {
                $amountFixed = $transaction->amount / $rate;
            }


            $commission[$transaction->bin] = round($amountFixed * ($isEu ? 0.01 : 0.02), 2);
        }

        return $commission;
    }
}