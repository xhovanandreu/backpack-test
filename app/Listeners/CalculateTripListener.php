<?php

namespace App\Listeners;


use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\CalculateTripEvent;
use App\Services\TripCalculatorService;
class CalculateTripListener implements ShouldQueue
{
    protected TripCalculatorService $tripCalculator;
    /**
     * Create the event listener.
     */
    public function __construct(TripCalculatorService $tripCalculator)
    {
        $this->tripCalculator = $tripCalculator;
    }

    /**
     * Handle the event.
     * @param CalculateTripEvent $event
     * @return void
     */
    public function handle(CalculateTripEvent $event): void
    {
        $this->tripCalculator->calculateEstimatedArrivalTime($event->trip);
    }
}
