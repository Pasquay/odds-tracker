<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http; 
use App\Models\Price;                

#[Signature('app:fetch-prices')]
#[Description('Fetches live crypto prices and stores them in the database')]
class FetchPrices extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Fetching prices from CoinGecko...');

        $response = Http::get('https://api.coingecko.com/api/v3/simple/price?ids=bitcoin,ethereum&vs_currencies=usd');

        if ($response->successful()) {
            $data = $response->json();

            Price::create([
                'asset_name' => 'bitcoin',
                'current_price' => $data['bitcoin']['usd']
            ]);

            Price::create([
                'asset_name' => 'ethereum',
                'current_price' => $data['ethereum']['usd']
            ]);

            $this->info('Prices saved successfully!');
        } else {
            $this->error('Failed to fetch prices.');
        }
    }
}