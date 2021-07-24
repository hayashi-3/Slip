@extends('layouts.app')

@section('content')
<div class="container">
   <h4>月次仕訳</h4>

   <ul class="tab-menu">
      @foreach ($m_summary as $m_s)
      <li class="tab-menu__item"><span class="tab-trigger js-tab-trigger" data-id="{{ $m_s->id }}">{{ $m_s->month }}</span></li>
      @endforeach
   </ul><!-- .tab-menu -->

   <div class="tab-content">
      @foreach ($m_summary as $m_s)
      <div class="tab-content__item js-tab-target" id="{{ $m_s->id }}">
         <p>{{ $m_s->monthly_grand_total }}</p>
      </div><!-- .tab-content__item -->
      @endforeach
   </div><!-- .tab-content -->

</div>

@endsection
