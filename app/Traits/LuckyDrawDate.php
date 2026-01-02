<?php

namespace App\Traits;

use Carbon\Carbon;

trait LuckyDrawDate
{
    public function getLuckyDrawDate()
    {
        return Carbon::now()->subMonth();
    }
}
