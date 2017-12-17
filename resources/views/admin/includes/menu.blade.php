<?php use App\Http\Controllers\Admin\Includes\Includes; ?>

<?php $menu = Includes::menu();?>

<ul class="nav navbar-nav side-nav" style="margin-top:100px;">
    <li style="color:#fff;padding:6px 20px;"><i class="fa fa-user" aria-hidden="true"></i> <?=Auth::user()->name;?></li>
    <li><a href="/" target="_blank">Strona główna</a></li> 
    @foreach($menu as $href => $element)
    @if(is_array($element))
    <li class="child-li"><a href="" class="child-parent">{{$href}}</a>
        <ul class="nav navbar-nav child-menu">
            @foreach($element as $h => $e)
            <li><a href="{{$h}}">{{$e}}</a></li>
            @endforeach
        </ul>
    </li>
    @else
    <li><a href="{{$href}}">{{$element}}</a></li>
    @endif

    @endforeach

</ul>
