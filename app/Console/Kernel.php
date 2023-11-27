<?php

namespace App\Console;

use App\Models\Card;
use App\Models\HistoryPrice;
use App\Models\Product;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();

        $schedule->command('backup:run --only-db')->dailyAt('08:00');
        $schedule->command('backup:run --only-db')->dailyAt('20:00');
        $schedule->command('backup:clean')->dailyAt('20:00');


        $schedule->call(function () {
            $cards = Card::all();
            foreach ($cards as $card){
                $price = $card->default_price;
                $productPrices = Product::where('card_id',$card->id)->pluck('price')->toArray();
                if(!empty($productPrices)){
                    $SortProductPrices = sort($productPrices);
                    $count = sizeof($SortProductPrices);
                    $getNum = ceil($count/10)-$count;
                    $price = array_slice($SortProductPrices,$getNum,1);
                }

                $data = [
                    'card_id'=>$card->id,
                    'price'=>$price,
                    'dateTime'=>date('Y-m-d'),
                ];
                $historyPrice = HistoryPrice::create($data);
            }
        })->dailyAt('08:00');

    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
