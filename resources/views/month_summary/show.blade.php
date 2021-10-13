@extends('layouts.app')
@push('js')
  <script src="{{ asset('js/changeEditForm.js') }}" defer></script>
@endpush

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

  <div class="ml-5">
    <h4>月間詳細</h4>
  </div>

  <div class="m_show_table">
    <div class="m_show_tr">
      <div class="m_show_th"></div>
      <div class="m_show_th">支払方法</div>
      <div class="m_show_th">科目名</div>
      <div class="m_show_th">発生日</div>
      <div class="m_show_th">金額</div>
      <div class="m_show_th">小計</div>
      <div class="m_show_th">消費税率</div>
      <div class="m_show_th">消費税額</div>
      <div class="m_show_th">総計</div>
      <div class="m_show_th">備考</div>
      <div class="m_show_th">編集</div>
      <div class="m_show_th">保存</div>
      <div class="m_show_th"></div>
      <div class="m_show_th">削除</div>
    </div>

    @foreach($m_summary_slip as $ms_slip)
      <div class="m_show_tr">
        <div class="data-edit">
          @include('month_summary._edit_form')
        </div>
      </div>
    @endforeach
  </div>
   
  <div>{{ $m_summary_slip->links() }}</div>
@endsection