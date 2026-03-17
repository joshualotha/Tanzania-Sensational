<?php

namespace App\Console\Commands;

use App\Models\Booking;
use App\Models\Departure;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ReleaseExpiredBookingHolds extends Command
{
    protected $signature = 'bookings:release-expired-holds';
    protected $description = 'Release expired booking seat holds';

    public function handle(): int
    {
        $expired = Booking::query()
            ->whereIn('status', ['new', 'contacted'])
            ->whereNotNull('hold_expires_at')
            ->where('hold_expires_at', '<', now())
            ->where('held_seats', '>', 0)
            ->get();

        $count = 0;

        foreach ($expired as $booking) {
            DB::transaction(function () use ($booking, &$count) {
                $booking->refresh();
                if (!$booking->departure_id || $booking->held_seats <= 0) return;

                $departure = Departure::lockForUpdate()->find($booking->departure_id);
                if (!$departure) return;

                $departure->held_seats = max(0, (int)$departure->held_seats - (int)$booking->held_seats);
                $departure->available_seats = $departure->remaining_seats;
                if ($departure->remaining_seats <= 0) {
                    $departure->status = 'Full';
                } elseif ($departure->remaining_seats <= 3) {
                    $departure->status = 'Limited';
                } else {
                    $departure->status = 'Available';
                }
                $departure->save();

                $booking->held_seats = 0;
                $booking->hold_expires_at = null;
                $booking->status = 'cancelled';
                $booking->notes = trim(($booking->notes ? $booking->notes . "\n" : '') . '[System] Hold expired and seats were released.');
                $booking->save();

                $count++;
            });
        }

        $this->info("Released holds for {$count} booking(s).");
        return Command::SUCCESS;
    }
}

