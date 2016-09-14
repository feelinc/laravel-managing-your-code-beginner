@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-6">Users</div>
                        <div class="col-xs-6 text-right">
                            <a href="{{ url('/users/export/xls') }}" class="btn btn-default" data-toggle="tooltip" data-placement="left" title="Download to Excel">
                                <span class="glyphicon glyphicon glyphicon-floppy-save" aria-hidden="true"></span>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="panel-body">
                    @if ( ! $list->isEmpty())
                    <ul class="list-group">
                        @foreach ($list as $item)
                        <li class="list-group-item">
                            <span class="badge">{{ $item->id }}</span>{{ $item->name }}
                        </li>
                        @endforeach
                    </ul>
                    @endif
                </div>

                <div class="panel-footer">{{ $list->links() }}</div>
            </div>
        </div>
    </div>
</div>
@endsection
