<?php

namespace App\Services\Importer\Query;

use App\Services\Importer\ValueObjects\Bin;

class GetBinQuery
{
    public function __invoke(string $binNumber)
    {
        $bin = json_decode(file_get_contents(sprintf('https://lookup.binlist.net/%s', $binNumber)), true);
        var_dump($bin);
        return new Bin($bin);
    }
}