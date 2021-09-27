@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="row justify-content-center-end">
                    {{Form::open(['url'=>route('crm.users.index'), 'method'=>'GET'])}}
                    <div class="row">
                        <div class="col-10">
                            @include('forms._input', [
    'name'=>'search',
    'placeholder'=>'Пользователь...',
])
                        </div>
                        <div class="col-2">
                            <button class="btn btn-secondary">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                        {{Form::close()}}
                    </div>
                    <div class="col-auto">
                        <a href="{{route('crm.users.create')}}" class="btn btn-success">
                            <i class="fas fa-user-plus"></i>
                            Создать нового пользователя
                        </a>
                    </div>
                </div>

                <div class="row pb-2 mt-5">
                    <div class="col-12">
                        Список пользователей
                    </div>
                </div>

                <div class="row pb-2 mp-4">
                    <div class="col-1">
                        Id
                    </div>
                    <div class="col-5">
                        ИМя пользователя
                    </div>
                    <div class="col-6">
                        Действия
                    </div>
                </div>

                @foreach($users as $user)
                    <div class="row pb-2">
                        <div class="col-1">
                            {{$user->getKey()}}
                        </div>
                        <div class="col-6">
                            {{$user->getName()}}
                        </div>
                        <div class="col-1">
                            <a href="{{route('crm.users.edit',$user)}}" class="btn btn-success">
                                <i class="fas fa-pen"></i>
                            </a>
                        </div>
                        <div class="col-1">
                            {{Form::open(['mothod'=>'DELETE', 'url'=>route('crm.users.destroy',$user)])}}

                            <button class="btn btn-danger">
                                <i class="fas fa-trash"></i>
                            </button>
                            {{Form::close()}}
                        </div>
                    </div>
                    @empty
                    @endforelse
            </div>
        </div>
    </div>
@endsection
