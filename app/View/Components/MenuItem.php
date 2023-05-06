<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\Menu;

class MenuItem extends Component
{
    public $row_menu = null;
    /**
     * Create a new component instance.
     */
    public function __construct($menu)
    {
        $this->row_menu = $menu;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $menu = $this->row_menu;
        $list_menu_sub = Menu::where([['status', '=', '1'], ['parent_id', '=', $menu->id], ['position', '=', 'mainmenu']])->get();
        $sub_menu = false;
        if (count($list_menu_sub) > 0) {
            $sub_menu = true;
        }
        return view('components.menu-item', compact('menu', 'list_menu_sub', 'sub_menu'));
    }
}
