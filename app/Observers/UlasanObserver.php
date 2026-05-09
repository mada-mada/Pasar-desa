<?php

namespace App\Observers;

use App\Models\Ulasan;

class UlasanObserver
{
    /**
     * Handle the Ulasan "created" event.
     */
    public function created(Ulasan $ulasan): void
    {
        $this->updateMasterRating($ulasan);
    }

    /**
     * Handle the Ulasan "updated" event.
     */
    public function updated(Ulasan $ulasan): void
    {
        if ($ulasan->wasChanged('is_approved')) {
            $this->updateMasterRating($ulasan);
        }
    }

    /**
     * Handle the Ulasan "deleted" event.
     */
    public function deleted(Ulasan $ulasan): void
    {
        $this->updateMasterRating($ulasan);
    }

    /**
     * Update the related model's rating and total reviews.
     */
    private function updateMasterRating(Ulasan $ulasan): void
    {
        $master = $ulasan->ulasanable;
        
        if ($master) {
            $approvedUlasans = $master->ulasans()->where('is_approved', true);
            $totalUlasan = $approvedUlasans->count();
            $rataRataRating = $totalUlasan > 0 ? $approvedUlasans->avg('rating') : 0;

            $master->update([
                'total_ulasan' => $totalUlasan,
                'rata_rata_rating' => $rataRataRating
            ]);
        }
    }
}
