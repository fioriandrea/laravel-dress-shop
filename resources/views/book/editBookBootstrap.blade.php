@extends('layouts.master')

@section('titolo')
@if(isset($book->id))
    Edit book
@else
    Add book
@endif
@endsection

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
@if(isset($book->id))
    <li class = "active">Edit book</li>
@else
    <li class = "active">Add book</li>
@endif
@endsection

@section('corpo')
<div class="container">
    <div class="row">
        <div class='col-md-12'>
            @if(isset($book->id))
                <form class="form-horizontal" name="book" method="get" action="{{ route('book.update', ['id' => $book->id]) }}">
            @else
                <form class="form-horizontal" name="book" method="post" action="{{ route('book.store') }}">
            @endif
                @csrf
                <div class="form-group">
                    <label for="title" class="col-md-2">Title</label>
                    <div class="col-sm-10">
                        @if(isset($book->id))
                        <input class="form-control" type="text" id="title" name="title" placeholder="Book title" value="{{ $book->title }}">
                        @else
                        <input class="form-control" type="text" id="title" name="title" placeholder="Book title">
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <label for="author_id" class="col-md-2">Author</label>
                    <div class="col-sm-10">
                        <select class="form-control" name="author_id">
                            @foreach($authorList as $author)
                                @if((isset($book->id))&&($author->id == $book->author_id))
                                    <option value="{{ $author->id }}" selected="selected">{{ $author->lastname }}</option>
                                @else
                                    <option value="{{ $author->id }}">{{ $author->lastname }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-10 col-sm-offset-2">
                        @if(isset($book->id))
                        <input type="hidden" name="id" value="{{ $book->id }}"/>
                        <label for="mySubmit" class="btn btn-primary btn-large btn-block"><span class="glyphicon glyphicon-floppy-save"></span> Save</label>
                        <input id="mySubmit" type="submit" value="Save" class="hidden"/>
                        @else
                        <label for="mySubmit" class="btn btn-primary btn-large btn-block"><span class="glyphicon glyphicon-floppy-save"></span> Create</label>
                        <input id="mySubmit" type="submit" value="Create" class="hidden"/>
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-10 col-sm-offset-2">
                        <a href="{{ route('book.index') }}" class="btn btn-danger btn-large btn-block"><span class="glyphicon glyphicon-log-out"></span> Cancel</a>                         
                    </div>
                </div>                       
            </form>
        </div>
    </div>
</div>
@endsection