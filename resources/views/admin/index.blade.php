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
  <h4>管理者 ユーザー管理</h4>
  <div class="row">
    <!-- 新規登録フォーム -->
    <div class="ml-3 mb-3">
      @include('admin/_create_form')
    </div>

    <table class="table">
      <thead>
        <tr>
          <th scope="col">ユーザーID</th>
          <th scope="col">ユーザー名</th>
          <th scope="col">メール</th>
          <th scope="col">権限</th>
          <th scope="col">ステータス</th>
          <th scope="col">編集</th>
        </tr>
      </thead>
      <tbody>
        @foreach($account as $ac)
        <tr>
          <td>{{ $ac->id }}</td>
          <td>{{ $ac->name }}</td>
          <td>{{ $ac->email }}</td>
          @if($ac->role === 0)
            <td>一般</td>
          @else
            <td>管理者</td>
          @endif
          @if($ac->is_active === 0)
            <td>アカウント有効</td>
          @else
            <td>アカウント無効</td>
          @endif
          <td><!-- モーダルボタン -->
            <button type="button" class="btn btn-outline-info" data-toggle="modal" data-target=".edit{{ $ac->id }}">
              ユーザー編集
            </button>
            <!-- モーダル・伝票登録フォーム -->
            <div class="modal fade edit{{ $ac->id }}" tabindex="-1" role="dialog" aria-labelledby="#editModal" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModal">ユーザー編集</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="post" action="{{ route('account.update') }}">
                        @csrf
                          <input type="hidden" name="id" value="{{ $ac->id}}">
                          <div class="form-group">
                              <label for="name">名前</label>
                              <input type="text" name="name" class="form-control" id="name" value="{{ $ac->name }}">
                          </div>
                          <div class="form-group">
                              <label for="email">メールアドレス</label>
                              <input type="email" name="email" class="form-control" id="email" value="{{ $ac->email }}">
                          </div>
                          <div class="form-group">
                              <label for="password">パスワード</label>
                              <input type="password" name="password" class="form-control" id="password" value="{{ $ac->password }}">
                          </div>
                          <div class="form-group">
                              <label for="confirm_password">パスワード（確認）</label>
                              <input type="password" name="confirm_password" class="form-control" id="confirm_password" value="{{ $ac->password }}">
                          </div>
                          <div class="form-check">
                              <input type="hidden" name="is_active" class="form-check-input" id="is_active" value="0">
                              <input type="checkbox" name="is_active" class="form-check-input" id="is_active" value="1" @if ($ac->is_active == 1) checked @endif>
                              <label class="form-check-label" for="is_active">アカウント無効</label>
                          </div>
                          <div class="form-check">
                              <input type="hidden" name="role" class="form-check-input" id="role" value="0">
                              <input type="checkbox" name="role" class="form-check-input" id="role" value="1" @if ($ac->role == 1) checked @endif>
                              <label class="form-check-label" for="role">管理者権限</label>
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
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endsection