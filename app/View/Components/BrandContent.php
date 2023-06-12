<?php

namespace App\View\Components;

use App\Models\Brand;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class BrandContent extends Component
{
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $data = [
            ['status', '=', '1'],
        ];
        $list_brand = Brand::where($data)->orderBy('created_at', 'asc')->take(4)->get();
        return view('components.brand-content', compact('list_brand'));
    }
}
