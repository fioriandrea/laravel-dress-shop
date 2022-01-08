@extends('layouts.master')

@section('titolo', 'My Authors')

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
<li class="active">My Library</li>
<li class="active">Authors</li>
@endsection

@section('corpo')
<div class="container">
    <div class="row">
        <div class="col-md-offset-10 col-xs-6">
            <p>
                <a class="btn btn-success" href="{{ route('author.create') }}"><span class="glyphicon glyphicon-new-window"></span> Create new author</a>
            </p>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <table class="table table-striped table-hover table-responsive" style="width:100%">
                <col width='80%'>
                <col width='10%'>
                <col width='10%'>
                <thead>
                    <tr>
                        <th>Author's name</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($authorList as $author)
                    <tr>
                        <td>{{ $author->firstname }} {{ $author->lastname }}</td>
                        <td>
                            <a class="btn btn-primary" href="{{ route('author.edit', ['author' => $author->id]) }}"><span class="glyphicon glyphicon-pencil"></span> Edit</a>
                        </td>
                        @if(count($author->books)==0)
                        <td>
                            <a class="btn btn-danger" href="{{ route('author.destroy.confirm', ['id' => $author->id]) }}"><span class="glyphicon glyphicon-trash"></span> Delete</a>
                        </td>
                        @else
                        <td>
                            <a class="btn btn-default" disabled="disabled" href=""><span class="glyphicon glyphicon-ban-circle"></span> Delete</a>
                        </td>
                        @endif
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection