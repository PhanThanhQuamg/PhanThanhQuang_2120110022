<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\Slider;

class Slideshow extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $list_slider = Slider::where('status', '=', 1)->take(3)->orderBy('sort_order', 'ASC')->get();
        return view('components.slideshow', compact('list_slider'));
    }
}
