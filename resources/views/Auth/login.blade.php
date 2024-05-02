<!-- resources/views/login.blade.php -->

@extends('layouts.master')

@section('content')
    <div class="container login-container">
        <div class="login-form">
            <h2 class="text-center">Login</h2>
            <form action="{{ route('login') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="exampleInputEmail1">Email address</label>
                    <input name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
                        placeholder="Enter email">
                    @error('email')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Password</label>
                    <input type="password" class="form-control" id="exampleInputPassword1" name="password"
                        placeholder="Password">
                    @error('password')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary btn-block">Login</button>
                <div class="form-group">
                    <small class="form-text text-muted">don't have an account? register <a href="{{ '/users/create' }}">here</a></small>
                </div>
            </form>
        </div>
    </div>
@endsection
