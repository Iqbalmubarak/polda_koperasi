<!--begin::Modal-->
<div class="modal fade" id="f_modal_edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title" id="exampleModalLabel">Edit</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      </button>
    </div>
    {{ Form::open(array('method'=>'PATCH', 'url' => '#', 'files' => true, 'id'=>'form_edit')) }}
      <div class="modal-body">
        <div class="col-md-12">
          <div class="kt-form__group--inline">
            <div class="kt-form__label">
              <label class="kt-label m-label--single">Rp. {{$data->modal + $data->price}},00</label>
            </div>
          </div>
          <div class="d-md-none kt-margin-b-10"></div>
        </div>
        <div class="col-md-12">
          <div class="kt-form__group--inline">
            <div class="kt-form__label">
              <label class="kt-label m-label--single">Qty:</label>
            </div>
            <div class="kt-form__control">
              {!! Form::number('profit',null, ['class' => 'form-control','required'=>'required','min'=>1]) !!}
              @error('profit')
                <div class="form-text text-danger">{{$message}}</div>
              @enderror
            </div>
          </div>
          <div class="d-md-none kt-margin-b-10"></div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button id="btn_form" type="submit" class="btn btn-primary">Save changes</button>
      </div>
    {{ Form::close() }}
  </div>
</div>
</div>
<!--end::Modal-->

<div class="col-md-3 col-xl-3">
  <div class="kt-portlet kt-portlet--height-fluid">
    <div class="kt-portlet__head kt-portlet__head--noborder">
      <div class="kt-portlet__head-label">
        <h3 class="kt-portlet__head-title">

        </h3>
      </div>
      <div class="kt-portlet__head-toolbar">

      </div>
    </div>
    <div class="kt-portlet__body">
      <!--begin::Widget -->
      <div class="kt-widget kt-widget--user-profile-2">

          <div class="kt-widget__head">
            <div class="kt-widget__media">
              @if($data->picture)
                <img class="kt-widget__img kt-hidden-" src="{{url('img/profile-pict/'.$data->picture)}}" alt="image" height="90px" width="90px">
              @else
                <div class="kt-widget__pic kt-widget__pic--success kt-font-success kt-font-boldest kt-hidden-">
                  {{Helper::awalan($data->name)}}
                </div>
              @endif
            </div>
            <div class="kt-widget__info">
              <a href="{{route('users.show',$data->id)}}" class="kt-widget__username">
                {{$data->name}}
              </a>
            </div>
          </div>
  
        <div class="kt-widget__body">
          <div class="kt-widget__section">
          </div>

          <div class="kt-widget__item">
            <div class="kt-widget__contact">
              <span class="kt-widget__label">Satuan:</span>
              <span class="kt-widget__label">{{$data->units->name}}</span>
            </div>
            <div class="kt-widget__contact">
              <span class="kt-widget__label">Merek:</span>
              <span class="kt-widget__label">{{$data->brands->name}}</span>
            </div>
            <div class="kt-widget__contact">
              <span class="kt-widget__label">Harga:</span>
              <span class="kt-widget__label">Rp. {{$data->modal + $data->price}},00</span>
            </div>
          </div>
        </div>
        <br>
        <div class="text-center">
            <div class="kt-widget__action">
              <!-- <button type="button" class="btn btn-outline-brand btn-elevate btn-circle btn-icon"><i class="flaticon-bell"></i></button> -->
              @if (Sentinel::getUser()->hasAccess(['users.show']))
              <a href="{{route('users.show',$data->id)}}" class="btn btn-icon btn-circle btn-label-twitter">
                <i class="fa fa-info"></i>
              </a>
              @endif
              @if (Sentinel::getUser()->hasAccess(['users.show']))
              <a href="{{route('markets.create',$data->id)}}" class="btn btn-icon btn-circle btn-label-twitter">
                <i class="fa fa-shopping-cart"></i>
              </a>
              @endif
              <!-- <a href="#" class="btn btn-icon btn-circle btn-label-linkedin">
              <i class="fa fa-edit"></i>
            </a> -->


          </div>
        </div>
      </div>
      <!--end::Widget -->
    </div>
  </div>
</div>

<script type="text/javascript">
  function edit_inventoris(id) {
  $('#f_modal_edit').modal('show');
  var base = "{{url('/')}}";
  $('#form_edit').attr('action', base+'/item/');
  }
</script>
