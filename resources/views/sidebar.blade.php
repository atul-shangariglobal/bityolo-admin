<div class="sidebar display-none" data-color="orange" data-background-color="white" data-image="{{ asset('public/dist/img/sidebar-3.jpg')}}">
    <!--
      Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

      Tip 2: you can also add an image using data-image tag
  -->
    <div class="logo">
        <a href="{{ url('/dashboard') }}" class="simple-text logo-normal">
           {{-- <img src="https://arax.io/assets/images/logo.png" alt="" width="20%">--}}
            <img style="animation: fa-spin 10s infinite;" src="https://arax-image.s3.ap-south-1.amazonaws.com/email/3PZpJFqANX77ndMmWMUiyubZJv0F9UtQSXRgQkbv.png" alt="" width="35%">
            COSS ADMIN
        </a>
    </div>

    <?php
    $permIds = session('perms') ? session('perms') : [];
    $allItems = \App\SidebarItem::where('parent_id',null)->where('is_active',true)/*->whereIn('perm_id',$permIds)*/->orderBy('order','asc')->get();
    //dd($allItems);
    $url = parse_url(url()->current(), PHP_URL_PATH);
    foreach ($allItems as $sidebaritem){

        $children = \App\SidebarItem::where('parent_id',$sidebaritem->id)->get();
        if(count($children)>0){
            $sidebaritem['hasChildren'] = $children;
        }
        $children = \App\SidebarItem::where('parent_id',$sidebaritem->id)/*->whereIn('perm_id',$permIds)*/->get();
        $sidebaritem['children'] = $children;
    }
    //dd($allItems); ?>
    <div class="sidebar-wrapper">
        <ul class="nav">
            @foreach($allItems as $key=>$item)
           {{-- <li class="nav-item @if(strpos($url,$item->url) !== false) active @endif">
                <a class="nav-link" href="{{ url($item->url) }}">
                    <i class="material-icons">{{ $item->iconClass }}</i>
                    <p>{{ $item->name }}</p>
                </a>
            </li>--}}

                <li class="nav-item @if(isset($item->children) && count($item->children)>0) dropdown @endif @if(strpos($url,$item->url) !== false) active @endif">
                    <a class="nav-link @if(isset($item->children) && $item->hasChildren) dropdown-toggle @endif cursor-pointer " @if(isset($item->children) && $item->hasChildren) id="dropdownMenuButton{{$key}}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" @else href="{{ url($item->url) }}" @endif >
                        <i class="material-icons">{{ $item->iconClass }}</i>
                        {{ $item->name }}
                    </a>
                    @if(isset($item->children) && count($item->children)>0)
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton{{$key}}">
                        @foreach($item->children as $child)
                            <a class="dropdown-item m-0" style="padding: 2px !important;" href="{{ url($child->url) }}">
                                <i class="material-icons small">{{ $child->iconClass }}</i>
                                <p>{{ $child->name }}</p>
                            </a>
                        @endforeach
                    </div>
                    @endif
                </li>

            @endforeach
            <li class="nav-item dropdown">
                <a class="nav-link" href="{{ route('logout') }}"
                   onclick="event.preventDefault();
                   document.getElementById('logout-form').submit();">
                    <!-- <i class="material-icons">exit_to_app</i> -->
                    {{ __('Logout') }}
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </li>
        </ul>
    </div>
</div>
