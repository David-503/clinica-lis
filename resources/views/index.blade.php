@extends('layouts.master')

@section('title')
    Las Palmeras
@endsection


@section('header')
    @parent
@endsection

@section('MainContent')
    @parent
@endsection
@section('content')
<form action="/dashboard/doctor/infoDoctor" method="POST">
    @csrf
    <input type="hidden" name="_method" value="POST">

    <input type="text" name="dui" placeholder="dui" id="dui">
    <button type="submit">Listar<button>
</form> 

{{-- <form action="/dashboard/paciente/actualizar" method="POST">
    @csrf
    {{ csrf_field() }}
    <input type="hidden" name="_method" value="PUT">

    <input type="text" name="dui" placeholder="dui" id="dui">
    <input type="text" name="name" placeholder="name" id="dui">
    <input type="text" name="lastname" placeholder="lastname" id="dui">
    <input type="mail" name="email" placeholder="email" id="dui">
    <input type="text" name="address" placeholder="address" id="dui">
    <input type="text" name="phone" placeholder="phone" id="dui">
    <button type="submit">enviar<button>
</form>  --}}
@endsection