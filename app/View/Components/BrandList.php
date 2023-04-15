<?php

namespace App\View\Components;

use App\Models\Brand;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class BrandList extends Component
{
    public function __construct()
    {
        //
    }

    public function render(): View|Closure|string
    {
        $list_brand = Brand::where('status', 1)->get();
        return view('components.brand-list', compact('list_brand'));
    }
}
