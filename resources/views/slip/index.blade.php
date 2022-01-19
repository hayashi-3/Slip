@extends('layouts.app')

@section('content')
<!-- フラッシュメッセージ -->
@if (session('flash_message'))
<div class="alert alert-success">
   {{ session('flash_message') }}
</div>
@endif

<!-- エラーメッセージ -->
@if ($errors->any())
<div class="alert alert-danger">
   <ul>
      @foreach ($errors->all() as $error)
      <li>{{ $error }}</li>
      @endforeach
   </ul>
</div>
@endif

<div class="container">

   <div class="row">
      <!-- 新規登録フォーム -->
      @include('slip/_create_form')

      <h4 class="mt-3">今月の支出　¥{{ number_format($gtotalSl) }} (税込)</h4>

      <ul class="tab-menu">
         <li class="tab-menu__item">
            <span class="tab-trigger js-tab-trigger is-active" data-id="tab01">
               {{ \Carbon\Carbon::now()->format("Y年m月") }} 【日付順】
            </span>
         </li>
         <li class="tab-menu__item">
            <span class="tab-trigger js-tab-trigger" data-id="tab02">
               現金支払分
            </span>
         </li>
         <li class="tab-menu__item">
            <span class="tab-trigger js-tab-trigger" data-id="tab03">
               クレジット支払分
            </span>
         </li>
      </ul>

      <div class="tab-content">
         <div class="tab-content__item js-tab-target is-active" id="tab01">

            <table class="table">
               <thead>
                  <tr>
                     <th scope="col"></th>
                     <th scope="col">支払方法</th>
                     <th scope="col">科目名</th>
                     <th scope="col">発生日</th>
                     <th scope="col">金額</th>
                     <th scope="col">小計</th>
                     <th scope="col">消費税率</th>
                     <th scope="col">消費税額</th>
                     <th scope="col">総計</th>
                     <th scope="col">備考</th>
                     <th scope="col">編集</th>
                     <th scope="col">削除</th>
                  </tr>
               </thead>
               <tbody>
                  @foreach ($slip as $sl)
                  <tr>
                     <th scope="row">{{ $sl->id }}</th>
                     @if ($sl->is_cash === 0)
                     <td>現金</td>
                     @else
                     <td>クレジット</td>
                     @endif

                     @foreach ($subject as $sb)
                     @if ($sl->subject_id == $sb->id)
                     <td>{{ $sb->subject_name }}</td>
                     @endif
                     @endforeach
                     <td>{{ $sl->accrual_year }}/{{ $sl->accrual_month }}/{{ $sl->accrual_date }}</td>
                     <!-- マイナスは赤字にする -->
                     @if ($sl->price > 0)
                     <td>¥{{ number_format($sl->price) }}</td>
                     @else
                     <td class="canceled">¥{{ number_format($sl->price) }}</td>
                     @endif
                     @if ($sl->subtotal > 0)
                     <td>¥{{ number_format($sl->subtotal) }}</td>
                     @else
                     <td class="canceled">¥{{ number_format($sl->subtotal) }}</td>
                     @endif
                     <td>{{ $sl->sales_tax_rate }}%</td>
                     @if ($sl->sales_tax > 0)
                     <td>¥{{ number_format($sl->sales_tax) }}</td>
                     @else
                     <td class="canceled">¥{{ number_format($sl->sales_tax) }}</td>
                     @endif
                     @if ($sl->grand_total > 0)
                     <td>¥{{ number_format($sl->grand_total) }}</td>
                     @else
                     <td class="canceled">¥{{ number_format($sl->grand_total) }}</td>
                     @endif
                     <td>{{ $sl->remarks }}</td>
                     @if ($sl->annual_confirmation === 0)
                     <td>
                        <!-- モーダルボタン -->
                        <button type="button" class="btn btn-outline-info" data-toggle="modal" data-target=".edit{{ $sl->id }}">
                           伝票編集
                        </button>
                        <!-- 更新フォーム -->
                        @include('slip/_edit_form')
                     </td>
                     @else
                     <td>
                        年次決算確定済み
                     </td>
                     @endif
                     <td>
                        @if ($sl->annual_confirmation === 0)
                        <form method="post" action="{{ route('slip.delete', $sl->id) }}">
                           @csrf
                           <button type="submit" name="delete" class="btn btn-outline-danger" onClick="delete_alert(event);return false;">削除</button>
                        </form>
                        @endif
                     </td>
                  </tr>

                  @endforeach
               </tbody>
            </table>
         </div><!-- .tab-content__item -->

         <div class="tab-content__item js-tab-target" id="tab02">

            <table class="table">
               <thead>
                  <tr>
                     <th scope="col"></th>
                     <th scope="col">支払方法</th>
                     <th scope="col">科目名</th>
                     <th scope="col">発生日</th>
                     <th scope="col">金額</th>
                     <th scope="col">小計</th>
                     <th scope="col">消費税率</th>
                     <th scope="col">消費税額</th>
                     <th scope="col">総計</th>
                     <th scope="col">備考</th>
                  </tr>
               </thead>
               <tbody>
                  @foreach ($cashSlip as $sl)
                  <tr>
                     <th scope="row">{{ $sl->id }}</th>
                     @if ($sl->is_cash === 0)
                     <td>現金</td>
                     @else
                     <td>クレジット</td>
                     @endif

                     @foreach ($subject as $sb)
                     @if ($sl->subject_id == $sb->id)
                     <td>{{ $sb->subject_name }}</td>
                     @endif
                     @endforeach
                     <td>{{ $sl->accrual_year }}/{{ $sl->accrual_month }}/{{ $sl->accrual_date }}</td>
                     <!-- マイナスは赤字にする -->
                     @if ($sl->price > 0)
                     <td>¥{{ number_format($sl->price) }}</td>
                     @else
                     <td class="canceled">¥{{ number_format($sl->price) }}</td>
                     @endif
                     @if ($sl->subtotal > 0)
                     <td>¥{{ number_format($sl->subtotal) }}</td>
                     @else
                     <td class="canceled">¥{{ number_format($sl->subtotal) }}</td>
                     @endif
                     <td>{{ $sl->sales_tax_rate }}%</td>
                     @if ($sl->sales_tax > 0)
                     <td>¥{{ number_format($sl->sales_tax) }}</td>
                     @else
                     <td class="canceled">¥{{ number_format($sl->sales_tax) }}</td>
                     @endif
                     @if ($sl->grand_total > 0)
                     <td>¥{{ number_format($sl->grand_total) }}</td>
                     @else
                     <td class="canceled">¥{{ number_format($sl->grand_total) }}</td>
                     @endif
                     <td>{{ $sl->remarks }}</td>
                  </tr>
                  @endforeach
               </tbody>
            </table>
         </div>

         <div class="tab-content__item js-tab-target" id="tab03">

            <table class="table">
               <thead>
                  <tr>
                     <th scope="col"></th>
                     <th scope="col">支払方法</th>
                     <th scope="col">科目名</th>
                     <th scope="col">発生日</th>
                     <th scope="col">金額</th>
                     <th scope="col">小計</th>
                     <th scope="col">消費税率</th>
                     <th scope="col">消費税額</th>
                     <th scope="col">総計</th>
                     <th scope="col">備考</th>
                  </tr>
               </thead>
               <tbody>
                  @foreach ($creditSlip as $sl)
                  <tr>
                     <th scope="row">{{ $sl->id }}</th>
                     @if ($sl->is_cash === 0)
                     <td>現金</td>
                     @else
                     <td>クレジット</td>
                     @endif

                     @foreach ($subject as $sb)
                     @if ($sl->subject_id == $sb->id)
                     <td>{{ $sb->subject_name }}</td>
                     @endif
                     @endforeach
                     <td>{{ $sl->accrual_year }}/{{ $sl->accrual_month }}/{{ $sl->accrual_date }}</td>
                     <!-- マイナスは赤字にする -->
                     @if ($sl->price > 0)
                     <td>¥{{ number_format($sl->price) }}</td>
                     @else
                     <td class="canceled">¥{{ number_format($sl->price) }}</td>
                     @endif
                     @if ($sl->subtotal > 0)
                     <td>¥{{ number_format($sl->subtotal) }}</td>
                     @else
                     <td class="canceled">¥{{ number_format($sl->subtotal) }}</td>
                     @endif
                     <td>{{ $sl->sales_tax_rate }}%</td>
                     @if ($sl->sales_tax > 0)
                     <td>¥{{ number_format($sl->sales_tax) }}</td>
                     @else
                     <td class="canceled">¥{{ number_format($sl->sales_tax) }}</td>
                     @endif
                     @if ($sl->grand_total > 0)
                     <td>¥{{ number_format($sl->grand_total) }}</td>
                     @else
                     <td class="canceled">¥{{ number_format($sl->grand_total) }}</td>
                     @endif
                     <td>{{ $sl->remarks }}</td>
                  </tr>
                  @endforeach
               </tbody>
            </table>
         </div>

      </div><!-- .tab-content -->
   </div>

   <div class="mt-5">
      <canvas id="pieChart"></canvas>
      <script type="text/javascript">
         var jsonSlip = <?php
                           $jsonSlip = json_encode($groupSlip);
                           echo $jsonSlip; ?>;

         var subject_names = [];
         for (var i = 0; i < jsonSlip.length; i++) {
            subject_names.push(jsonSlip[i].subject_name);
         }

         var subtotal = [];
         for (var i = 0; i < jsonSlip.length; i++) {
            subtotal.push(jsonSlip[i].sum);
         }
      </script>
   </div>
</div>
@endsection