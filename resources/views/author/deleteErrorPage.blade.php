@extends('layouts.delete')

@section('titolo', 'Delete author from the list')

@section('stile', 'style.css')

@section('left_navbar')
<li><a href="{{ route('home') }}">Home</a></li>
<li class="dropdown active">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">My Library<b class="caret"></b></a>
    <ul class="dropdown-menu">
        <li><a href="{{ route('book.index') }}">Books List</a></li>
        <li class='active'><a href="{{ route('author.index') }}">Authors List</a></li>
    </ul>
</li>
@endsection

@section('right_navbar')
@if($logged)
<li><a><i>Welcome {{ $loggedName }}</i></a></li>
<li><a href="{{ route('user.logout') }}">logout <span class="glyphicon glyphicon-log-out"></span></a></li>
@endif
@endsection

@section('breadcrumb')
<li><a href="{{ route('home') }}">Home</a></li>
<li class="active"><a href="{{ route('author.index') }}">My Library</a></li>
<li class="active"><a href="{{ route('author.index') }}">Authors</a></li>
<li class="active">Delete author</li>
@endsection

@section('corpo')
<div class="container text-center">
    <div class="row">
        <div class="col-md-12">
            <header>
                <h1>
                    Delete author from the list
                </h1>
            </header>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-danger">
                <div class='panel-heading'>
                    Illegal page access
                </div>
                <div class='panel-body'>
                    <p>Something <strong>wrong</strong> happened while accessing this page</p>
                    <p><a class="btn btn-default" href="{{ route('author.index') }}"><span class='glyphicon glyphicon-log-out'></span> Back to books list</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection