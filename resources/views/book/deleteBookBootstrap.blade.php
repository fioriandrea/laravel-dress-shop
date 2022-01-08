@extends('layouts.delete')

@section('titolo', 'Delete book from the list')

@section('stile', 'style.css')

@section('left_navbar')
<li><a href="{{ route('home') }}">Home</a></li>
<li class="dropdown active">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">My Library<b class="caret"></b></a>
    <ul class="dropdown-menu">
        <li class='active'><a href="{{ route('book.index') }}">Books List</a></li>
        <li><a href="{{ route('author.index') }}">Authors List</a></li>
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
<li class="active"><a href="{{ route('book.index') }}">My Library</a></li>
<li class="active"><a href="{{ route('book.index') }}">Books</a></li>
<li class="active">Delete book</li>
@endsection

@section('corpo')
<div class="container text-center">
    <div class="row">
        <div class="col-md-12">
            <header>
                <h1>
                    Delete book "{{ $book->title }}" from the list
                </h1>
            </header>
            <p class='lead'>
                Deleting book. Confirm?
            </p>
        </div>
    </div>
</div>

<div class="container text-center">
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class='panel-heading'>
                    Revert
                </div>
                <div class='panel-body'>
                    <p>The book <strong>will not be removed</strong> from the data base</p>
                    <p><a class="btn btn-default" href="{{ route('book.index') }}"><span class='glyphicon glyphicon-log-out'></span> Back to books list</a></p>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="panel panel-default">
                <div class='panel-heading'>
                    Confirm
                </div>
                <div class='panel-body'>
                    <p>The book <strong>will be permanently removed</strong> from the data base</p>
                    <p><a class="btn btn-danger" href="{{ route('book.destroy', ['id' => $book->id]) }}"><span class='glyphicon glyphicon-trash'></span> Delete</a></p>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection