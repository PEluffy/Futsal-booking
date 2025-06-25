<?php

namespace App\View\Components;

use App\Models\Court;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CourtCard extends Component
{
    public Court $court;
    public function __construct(Court $court)
    {
        $this->court = $court;
    }
    public function render(): View|Closure|string
    {
        return view('components.court-card');
    }
}
