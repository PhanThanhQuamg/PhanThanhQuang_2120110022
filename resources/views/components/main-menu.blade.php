<div>
    <!--header-bottom-->
    <div class="container">
        <div class="row">
            <div class="col-sm-9">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>
                <div class="mainmenu pull-left">
                    <ul class="nav navbar-nav collapse navbar-collapse">
                        @foreach ($list_menu as $rowmenu)
                            <x-menu-item :menu="$rowmenu" />
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="col-sm-3">
                <form action="{{ route('site.search') }}" method="get">
                    <div class="search_box pull-right">
                        <input type="text" placeholder="Search" name="key" />
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
