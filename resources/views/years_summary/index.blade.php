@extends('layouts.app')

@section('content')
<div class="container">
   <h4>年次決算</h4>

   <!-- excelのエクスポート -->
   <div class="row">
      <div class="col col-7"></div>
      <div class="col col-5">
        <form>
          <div>
            <input type="number" name="year">　年度　
            <input type="submit" value="年次決算を確定する">
          </div>
        </form>
      </div>
   </div>
   <div class="row">
      <div class="col col-10"></div>
      <div class="col col-2 mt-3">
        <a href="{{ route('export') }}">
           <button class="btn btn-success mr-3" data-toggle="tooltip" title="1年分の明細を出力します" data-placement="bottom">
             Excel出力
           </button>
        </a>
      </div>
   </div>

   <ul class="tab-menu">
      @foreach ($years as $y)
      <li class="tab-menu__item"><span class="tab-trigger js-tab-trigger" data-id="{{ $y->accountin_year }}">{{ $y->accountin_year }}年</span></li>
      @endforeach
   </ul><!-- .tab-menu -->

   <div class="tab-content">
      @foreach ($years as $y)
         <div class="tab-content__item js-tab-target" id="{{ $y->accountin_year }}">
            <table class="table">
               <thead>
                  <tr>
                     <th scope="col">科目</th>
                     <th scope="col">小計</th>
                     <th scope="col">消費税</th>
                     <th scope="col">総計</th>
                  </tr>
               </thead>
               <tbody>
               @foreach ($y_summary as $ys)
                  <tr>
                  @if ($y->accountin_year === $ys->accountin_year)
                     <td>{{ $ys->subject_name }}</td>
                     <td>¥{{ number_format($ys->year_subtotal) }}</td>
                     <td>¥{{ number_format($ys->year_sales_tax) }}</td>
                     <td>¥{{ number_format($ys->year_grand_total) }}</td>
                     @endif
                  </tr>
                  @endforeach
               </tbody>
            </table>
         </div><!-- .tab-content__item -->
      @endforeach
   </div><!-- .tab-content -->
   
</div>

<script>
document.addEventListener("DOMContentLoaded", () => {
   $(function () {
      $('[data-toggle="tooltip"]').tooltip()
      })
   });
</script>
@endsection