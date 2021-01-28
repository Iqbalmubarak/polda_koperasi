
@php
  $name = 'Filter Laporan Mingguan';
@endphp
@extends('layouts.L1')

@section('title'){{$name}} @stop

@section('subheader-name'){{$name}} @stop

@section('subheader-link')
  <span class="kt-subheader__breadcrumbs-separator"></span>
  <a href="javascript::void(0)" class="kt-subheader__breadcrumbs-link">
    {{$name}}
  </a>
@stop

@section('content')
<div class="kt-portlet kt-portlet--tabs">
    <div class="kt-portlet__body">
      {{ Form::open(array('method' => 'GET','url' => 'laporan-mingguan','target' => '_blank')) }}
        <div class="tab-content">
          <div class="tab-pane active" id="kt_user_edit_tab_1" role="tabpanel">
            <div class="kt-form kt-form--label-right">
              <div class="kt-form__body">
                <div class="kt-section kt-section--first">
                  <div class="form-group row">
                    <label class="col-xl-3 col-lg-3 col-form-label">Tanggal Mulai</label>
                    <div class="col-lg-9 col-xl-6">
                      {!! Form::date('tanggal_mulai', null, ['class' => 'form-control', 'placeholder'=>'','required'=>'required']) !!}
                      @error('tanggal_mulai')
                        <div class="form-text text-danger">{{$message}}</div>
                      @enderror
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-xl-3 col-lg-3 col-form-label">Tanggal Akhir</label>
                    <div class="col-lg-9 col-xl-6">
                      {!! Form::date('tanggal_akhir', null, ['class' => 'form-control', 'placeholder'=>'','required'=>'required']) !!}
                      @error('tanggal_akhir')
                        <div class="form-text text-danger">{{$message}}</div>
                      @enderror
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-xl-3 col-lg-3 col-form-label">Jenis Laporan</label>
                    <div class="col-lg-9 col-xl-6">
                      {!! Form::select('jenis_laporan',[1=>"Laporan 1", 2=>"Laporan 2"], null, ['class' => 'form-control', 'placeholder'=>'--Selected--','required'=>'required']) !!}
                      @error('jenis_laporan')
                        <div class="form-text text-danger">{{$message}}</div>
                      @enderror
                    </div>
                  </div>
                </div>
                <div class="text-center">
                  <button class="btn btn-brand btn-md btn-tall btn-wide kt-font-bold kt-font-transform-u" type="submit">
                    Cetak
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      {{ Form::close() }}
    </div>
  </div>
@stop
