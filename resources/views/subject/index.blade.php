@extends('layouts.app')

@section('content')
<!-- フラッシュメッセージ -->
@if (session('flash_message'))
   <div class="alert alert-success">
      {{ session('flash_message') }}
   </div>
@endif

<div class="container">
  <h4>科目管理</h4>
  <div class="card"></div>

  <table class="table">
    <thead>
      <tr>
        <th scope="col"></th>
        <th scope="col">科目名</th>
        <th scope="col">計算方法</th>
        <th scope="col">　編集</th>
        <th scope="col">　削除</th>
      </tr>
    </thead>
    <tbody>
    @foreach ($subject as $s)
      <tr>
        <th scope="row">{{ $s->id }}</th>
        <td>{{ $s->subject_name }}</td>
        <td>本体金額 × {{ $s->calculation }}</td>
        <td>
          <!-- モーダルボタン -->
          <button type="button" class="btn btn-outline-info" data-toggle="modal" data-target="#edit{{ $s->id }}">
            科目編集
          </button>
          <!-- モーダル・伝票登録フォーム -->
          <div class="modal fade" id="edit{{ $s->id }}" tabindex="-1" role="dialog" aria-labelledby="#editModal" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModal">伝票編集</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                  <form method="post" action="{{ route('subject.update', $s->id) }}">
                  @csrf
                  @method('post')
                    <input type="hidden" name="id" value="{{ $s->id}}">
                    <div class="form-group">
                        <label for="s_name">科目名</label>
                        <input type="text" name="subject_name" class="form-control" id="s_name" value="{{ $s->subject_name }}">
                    </div>
                    <div class="form-group">
                        <label for="cal">計算方法</label>
                        <input type="number" name="calculation" class="form-control" id="cal" value="{{ $s->calculation }}">
                    </div>
                    <button type="submit" class="btn btn-primary btn-lg btn-block">更新する</button>
                  </form>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">閉じる</button>
                </div>
              </div>
            </div>
          </div>
        </td>
        <td>
          <form method="post" action="{{ route('subject.destroy', $s->id) }}">
            @csrf
            @method('delete')
            <button type="submit" class="btn btn-outline-danger" onclick='return confirm("削除しますか？");'>削除</button>
          </form>
        </td>
      </tr>
    @endforeach
    </tbody>
  </table>

</div>
@endsection
