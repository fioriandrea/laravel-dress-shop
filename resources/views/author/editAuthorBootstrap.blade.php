@extends('layouts.master')

@section('titolo')
@if(isset($author->id))
Edit author
@else
Add author
@endif
@endsection

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
@if(isset($author->id))
<li class = "active">Edit author</li>
@else
<li class = "active">Add author</li>
@endif
@endsection

@section('corpo')
<div class="container">
    <div class="row">
        <div class='col-md-12'>
            @if(isset($author->id))
                <form class="form-horizontal" name="author" method="get" action="{{ route('author.update', ['id' => $author->id]) }}">
            @else
                <form class="form-horizontal" name="author" method="post" action="{{ route('author.store') }}">
            @endif
                @csrf
                <div class="form-group">
                    <label for="firstName" class="col-md-2">First Name</label>
                    <div class="col-sm-10">
                        @if(isset($author->id))
                            <input class="form-control" type="text" id="firstName" name="firstName" placeholder="First Author's Name" value="{{ $author->firstname }}">
                        @else
                            <input class="form-control" type="text" id="firstName" name="firstName" placeholder="First Author's Name">
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <label for="lastName" class="col-md-2">Last Name</label>
                    <div class="col-sm-10">
                        @if(isset($author->id))
                            <input class="form-control" type="text" id="lastName" name="lastName" placeholder="Last Author's Name" value="{{ $author->lastname }}">
                        @else
                            <input class="form-control" type="text" id="lastName" name="lastName" placeholder="Last Author's Name">
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-10 col-sm-offset-2">
                        @if(isset($author->id))
                            <input type="hidden" name="id" value="{{ $author->id }}"/>
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
                        <a href="{{ route('author.index') }}" class="btn btn-danger btn-large btn-block"><span class="glyphicon glyphicon-log-out"></span> Cancel</a>                         
                    </div>
                </div>                       
            </form>
        </div>
    </div>
</div>
@endsection