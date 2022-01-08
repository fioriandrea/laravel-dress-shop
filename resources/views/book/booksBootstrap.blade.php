@extends('layouts.master')

@section('titolo', 'My Books')

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
<li class="active">My Library</li>
<li class="active">Books</li>
@endsection

@section('corpo')
<div class="container">
    <div class="row">
        <div class="col-md-offset-10 col-xs-6">
            <p>
                <a class="btn btn-success" href="{{ route('book.create') }}"><span class="glyphicon glyphicon-new-window"></span> Create new book</a>
            </p>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <table class="table table-striped table-hover table-responsive" style="width:100%">
                <col width='50%'>
                <col width='30%'>
                <col width='10%'>
                <col width='10%'>
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Author</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($bookList as $book)
                    <tr>
                        <td>{{ $book->title }}</td>
                        <td>{{ $book->author->lastname }}</td>
                        <td>
                            <a class="btn btn-primary" href="{{ route('book.edit', ['book' => $book->id]) }}"><span class="glyphicon glyphicon-pencil"></span> Edit</a>
                        </td>
                        <td>
                            <a class="btn btn-danger" href="{{ route('book.destroy.confirm', ['id' => $book->id]) }}"><span class="glyphicon glyphicon-trash"></span> Delete</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection