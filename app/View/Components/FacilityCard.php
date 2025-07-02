<?php

namespace App\View\Components;

use App\Models\Facility;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FacilityCard extends Component
{
    /**
     * Create a new component instance.
     */
    public Facility $facility;
    public function __construct(Facility $facility)
    {
        $this->facility = $facility;
    }
    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.facility-card');
    }
}
