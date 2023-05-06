<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\Menu;

class FooterItem extends Component
{
    public $row_menu = null;
    /**
     * Create a new component instance.
     */
    public function __construct($menuitem)
    {
        $this->row_menu = $menuitem;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $menuitem = $this->row_menu;
        $list_menu_sub = Menu::where([
            ['status', '=', '1'],
            ['parent_id', '=', $menuitem->id],
            ['position', '=', 'footermenu']
        ])->orderBy('sort_order', 'asc')->get();
        $sub = false;
        if (count($list_menu_sub) > 0) {
            $sub = true;
        }
        return view('components.footer-item',compact('menuitem','list_menu_sub','sub'));
    }
}
