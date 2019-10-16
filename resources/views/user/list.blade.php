@extends('layouts.master')
@section('title','User Management')
@section('page_name','User Management')
@section('css')
    @parent
<style>
    .pagination {
        border: 0.5px solid #d4d4d4;text-align: right;
    }
</style>
@endsection
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card mt-2">

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                        <div class="p-4">
                            <table class="border table table-bordered table-striped table-condesed">
                                <thead>
                                <tr>
                                    <td>S. No.</td>
                                    <td>Name</td>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($users as $key => $user)
                                    <tr>
                                        <td class="p-2">
                                            {{ (($users->currentpage() - 1)*$users->perpage()) + $key +1 }}
                                        </td>
                                        <td>{{ $user->name }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                        </div>

                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
