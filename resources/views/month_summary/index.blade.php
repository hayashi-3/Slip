@extends('layouts.app')

@section('content')
<div class="container">
   <h4>月次仕訳</h4>
   <div class="card"></div>

   <div class="row">
      <div class="col-md-7">
         <div class="nav-tabs-custom">

            <ul class="nav nav-tabs">
               @foreach($items as $key => $item)
               <li><a href="#tab_{{ $key }}" data-toggle="tab" >{!! $item->name !!}</a></li>
               @endforeach
            </ul>

            <div class="tab-content">
            @foreach($items as $key => $item)
               <div class="tab-pane{{ $key == 1 ? " active" : "" }}" id="tab_{{ $key }}">
                  @foreach($item->stuff as $data)
                  <label class="mylabel">{{ $data->name }}</label>
                  @endforeach
               </div>
            @endforeach
            </div>
         </div>
      </div>
   </div>

</div>
@endsection
