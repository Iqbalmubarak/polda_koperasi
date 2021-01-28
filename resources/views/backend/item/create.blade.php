
@php
  $name = __('inventoris.title');
  $status = 'available';
  if(isset($_GET['status'])){
    $status = $_GET['status'];
  }
@endphp
@extends('layouts.L1')

@section('title')@lang('global.app_create') {{$name}} @stop

@section('subheader-name')@lang('global.app_create') {{$name}} @stop

@section('subheader-link')
  <span class="kt-subheader__breadcrumbs-separator"></span>
  <a href="javascript::void(0)" class="kt-subheader__breadcrumbs-link">
    @lang('global.app_create') {{$name}}
  </a>
@stop

@section('subheader-btn')
<a href="{{route('item.index')}}?status={{$status}}" class="btn btn-default btn-bold">
  @lang('global.app_back_to_list')
</a>
<div class="btn-group">
  <button type="button" class="btn btn-brand btn-bold" onclick="$('#user_create_f').click()">
    @lang('global.app_save')
  </button>
</div>
@stop

@section('content')
<div class="kt-portlet kt-portlet--tabs">
    <div class="kt-portlet__body">
      {{ Form::open(array('url' => route('item.store'), 'files' => true)) }}
        <div class="tab-content">
          <div class="tab-pane active" id="kt_user_edit_tab_1" role="tabpanel">
            <div class="kt-form kt-form--label-right">
              <div class="kt-form__body">
                <div class="kt-section kt-section--first">
                  <div class="kt-section__body">
                    <div class="form-group row">
                      <label class="col-xl-3 col-lg-3 col-form-label">Image</label>
                      <div class="col-lg-9 col-xl-6">
                        <div class="kt-avatar kt-avatar--outline kt-avatar--circle-" id="kt_user_edit_avatar">
                          @if (Request::is('*edit'))
                          <div class="kt-avatar__holder" style="background-image: url({{$data->avatar ? url('img/profile-pict/'.$data->avatar) : asset('https://static.thenounproject.com/png/17241-200.png')}});"></div>
                          @else
                          <div class="kt-avatar__holder" style="background-image: url({{asset('https://static.thenounproject.com/png/17241-200.png')}});"></div>
                          @endif
                          <label class="kt-avatar__upload" data-toggle="kt-tooltip" title="" data-original-title="Ganti image">
                            <i class="fa fa-pen"></i>
                            <input type="file" name="avatar" accept=".png, .jpg, .jpeg">
                          </label>
                          <span class="kt-avatar__cancel" data-toggle="kt-tooltip" title="" data-original-title="@lang('user.field.avatar.cancel')">
                            <i class="fa fa-times"></i>
                          </span>
                        </div>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-xl-3 col-lg-3 col-form-label">Nama Barang</label>
                      <div class="col-lg-9 col-xl-6">
                        {!! Form::text('name',null, ['class' => 'form-control','required'=>'required']) !!}
                        @error('name')
                          <div class="form-text text-danger">{{$message}}</div>
                        @enderror
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-xl-3 col-lg-3 col-form-label">@lang('inventoris.field.satuan')</label>
                      <div class="col-lg-9 col-xl-6">
                        {!! Form::select('units', $units,null, ['class' => 'form-control kt-select2 myselect2','required'=>'required','id'=>'s_unit_create']) !!}
                        @error('units')
                          <div class="form-text text-danger">{{$message}}</div>
                        @enderror
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-xl-3 col-lg-3 col-form-label">Jenis</label>
                      <div class="col-lg-9 col-xl-6">
                        {!! Form::select('type', $type,null, ['class' => 'form-control kt-select2 myselect2','required'=>'required','id'=>'s_type_create']) !!}
                        @error('type')
                          <div class="form-text text-danger">{{$message}}</div>
                        @enderror
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-xl-3 col-lg-3 col-form-label">Merek</label>
                      <div class="col-lg-9 col-xl-6">
                        {!! Form::select('brands', $brands,null, ['class' => 'form-control kt-select2 myselect2','required'=>'required','id'=>'s_brands_create']) !!}
                        @error('brands')
                          <div class="form-text text-danger">{{$message}}</div>
                        @enderror
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-xl-3 col-lg-3 col-form-label">Profit</label>
                      <div class="col-lg-9 col-xl-6">
                        {!! Form::number('profit',null, ['class' => 'form-control','required'=>'required','min'=>1]) !!}
                        @error('profit')
                          <div class="form-text text-danger">{{$message}}</div>
                        @enderror
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-xl-3 col-lg-3 col-form-label">Note</label>
                      <div class="col-lg-9 col-xl-6">
                        {!! Form::textarea('note',null, ['class' => 'form-control','required'=>'required']) !!}
                        @error('note')
                          <div class="form-text text-danger">{{$message}}</div>
                        @enderror
                      </div>
                    </div>
                    <div class="form-group row" id="field_sumber_lainnya_create">
                      <div class="col-xl-3 col-lg-3 col-form-label"></div>
                      <div class="col-lg-9 col-xl-6">
                        <input type="text" name="sumber_lain" class="form-control" placeholder="Enter Sumber Lainnya" id="i_sumber_lainnya_create">
                        @error('sumber_lain')
                        <div class="form-text text-danger">{{$message}}</div>
                        @enderror
                      </div>
                    </div>
                  </div>
                </div>
                <div class="text-center">
                  <button class="btn btn-brand btn-md btn-tall btn-wide kt-font-bold kt-font-transform-u" type="submit" name="button" id="user_create_f">
                    @lang('global.app_save')
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

@section('tjs')
  <script src="{{asset('theme/js/pages/custom/user/edit-user.js')}}" type="text/javascript"></script>
  <script src="{{asset('theme/js/pages/crud/forms/widgets/select2.js')}}" type="text/javascript"></script>
  <script type="text/javascript">
    $('#field_sumber_lainnya_create').hide();
    $('#s_sumber_create').prop("disabled", true);
    $(".myselect2").select2({
        placeholder: "Select a state",
        allowClear: true
    });
    $('.myselect2').val(0).change();

    $('#s_sumber_create').on('select2:select', function (e) {
        var id = e.params.data.id;
        if(id=="xxx"){
          $('#field_sumber_lainnya_create').show();
        }else{
          $('#field_sumber_lainnya_create').hide();
        }
    });

    $('#s_sumber_create').on('select2:opening', function (e) {
        let barang = $('#s_barang_create').val();
        let satuan = $('#s_satuan_create').val();
        let satker = $('#s_satker_create').val();
        if (typeof(satker) == "undefined") satker = 1;
        if(satuan && barang && satker){
          setTimeout(function(){
            $('#s_sumber_create').prop("disabled", false);
          }, 1000);
          // fethData(satker, barang, satuan);
        }else{
          $('#s_sumber_create').prop("disabled", true);
        }
    });

    $('#s_barang_create').on('select2:select', function (e) {
        isSumberAvailable()
    });

    $('#s_satuan_create').on('select2:select', function (e) {
        isSumberAvailable()
    });

    $('#s_satker_create').on('select2:select', function (e) {
        isSumberAvailable()
    });

    function isSumberAvailable() {
      let barang = $('#s_barang_create').val();
      let satuan = $('#s_satuan_create').val();
      let satker = $('#s_satker_create').val();
      if (typeof(satker) == "undefined") satker = 1;
      if(satuan && barang && satker){
        fethData(satker, barang, satuan);
        setTimeout(function(){
          $('#s_sumber_create').prop("disabled", false);
        }, 1000);
      }else{
        $('#s_sumber_create').prop("disabled", true);
      }
    }

    function fethData(satker, barang, satuan) {
      let base_url = "{{url('/')}}";
      $("#s_sumber_create").select2("destroy");

      //perulangan data
      $('#s_sumber_create').empty();
      $.ajax({
        url: base_url+"/api/select/sumber/"+satker+"/"+barang+"/"+satuan,
        type: "GET",
        success: function(datas){
          $('#s_sumber_create').append('<option value="">Select a state</option>');
          for (var i = 0; i < datas.length; i++) {
            $('#s_sumber_create').append('<option value="' + datas[i].id + '">' + datas[i].name+ '</option>');
          }
        }
      });

      $("#s_sumber_create").select2({
          placeholder: "Select a state",
          allowClear: true,
          language: {
            noResults: function (params) {
              return "Sumber Di Satker Anda Tidak Ada yang Mencukupi";
            }
          }
      });
    }
  </script>
@endsection

@section('tcss')
  <link href="{{asset('theme/css/pages/wizard/wizard-4.css')}}" rel="stylesheet" type="text/css" />
@endsection
