<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\Post;

class PostHome extends Component
{
    public $topic = null;
    /**
     * Create a new component instance.
     */
    public function __construct($rowpost)
    {
        $this->topic = $rowpost;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $row_top = $this->topic;
        $top_id = $row_top->id;
        $arrtopid  = array();
        array_push($arrtopid, $top_id);
        $list_post = Post::join('ptq_topic', 'ptq_topic.id', '=', 'ptq_post.topic_id')
            ->whereIn('topic_id', $arrtopid)
            ->where('ptq_post.status', '=', '1')
            ->select('ptq_post.*', 'ptq_topic.name as chude')
            ->orderBy('ptq_post.created_at', 'asc')
            ->take(3)
            ->get();
        return view('components.post-home', compact('list_post'));
    }
}
