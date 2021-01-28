
@php
  $name = 'Dashboard';
@endphp
@extends('layouts.L1')

@section('title') {{$name}} @stop

@section('subheader-name') {{$name}} @stop

@section('subheader-link')
  <span class="kt-subheader__breadcrumbs-separator"></span>
  <a href="#" class="kt-subheader__breadcrumbs-link">
    {{$name}}
  </a>
@stop

@section('subheader-btn')
  <!-- <a href="{{route('users.create')}}" class="btn btn-label-brand btn-bold">Add User</a> -->
@stop

@section('content')
<div class="row">
  <div class="col-xl-12">
    <!--begin:: Components/Pagination/Default-->
    <div class="kt-portlet text-center">
      <div class="kt-portlet__body text-center">
        <h1>Selamat Datang Di Aplikasi Koperasi Polda @if(Sentinel::getUser()->roles()->first()->id==2)  {{Sentinel::getUser()->roles()->first()->name}} @elseif(Sentinel::getUser()->roles()->first()->id==3) {{Sentinel::getUser()->satker->name}} @endif </h1>
        <h3>Aplikasi Ini Masih Dalam <span class="kt-font-warning">Pengembangan</span> Silakan Lakukan Percobaa Pada Aplikasi Ini</h3>
        <h4>Jika Menemukan Kendala <span class="kt-font-success">Harapan Kami</span> Bisa Memberikan Kritik dan Sarannya</h4>
      </div>
    </div>
    <!--end:: Components/Pagination/Default-->
  </div>
</div>
@stop

@section('tjs')

@stop
