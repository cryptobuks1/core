@extends('master')

@section('css')
<style>
  .comments {
    margin: 2.5rem auto 0;
    max-width: 60.75rem;
    padding: 0 1.25rem;
  }
  .comment-wrap {
    margin-bottom: 1.25rem;
    display: table;
    width: 100%;
    min-height: 5.3125rem;
  }

  .photo {
    padding-top: 0.625rem;
    display: table-cell;
    width: 3.5rem;
  }
  .photo .avatar {
    height: 2.25rem;
    width: 2.25rem;
    border-radius: 50%;
    background-size: contain;
  }

  .comment-block {
    padding: 1rem;
    background-color: #fff;
    display: table-cell;
    vertical-align: top;
    border-radius: 0.1875rem;
    box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.08);
  }
  .comment-block textarea {
    width: 100%;
    resize: none;
  }

  .comment-text {
    margin-bottom: 1.25rem;
  }

  .bottom-comment {
    color: #acb4c2;
    font-size: 0.875rem;
  }

  .comment-date {
    float: left;
  }

  .comment-actions {
    float: right;
  }
  .comment-actions li {
    display: inline;
    margin: -2px;
    cursor: pointer;
  }
  .comment-actions li.complain {
    padding-right: 0.75rem;
    border-right: 1px solid #e1e5eb;
  }
  .comment-actions li.reply {
    padding-left: 0.75rem;
    padding-right: 0.125rem;
  }
  .comment-actions li:hover {
    color: #0095ff;
  }
</style>
@endsection
@section('js')
  @include('ckfinder::setup')
@endsection

@section('content')
<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-12">
      <div class="col-md-12">
            <!-- general form elements -->

           @include('layouts.errors')

            <div class="card card-light">
              <div class="card-header">
                <h3 class="card-title">Tiêu đề: <strong>{{ $ticket->title }}</strong>
                  @if($ticket->status == 'closed')
                    <label class="badge badge-danger">Đã đóng</label>
                  @elseif($ticket->status == 'pending')
                    <label class="badge badge-success">Đang mở</label>
                  @elseif($ticket->status == 'verify')
                    <label class="badge badge-dark">Đợi xác minh</label>
                  @elseif($ticket->status == 'canceled')
                    <label class="badge badge-warning">Đã hủy</label>
                  @else
                    <label class="badge badge-dark">Không rõ</label>
                  @endif
                </h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
                <div class="card-body table-responsive">

                  <div class="row"><div class="col-sm-12">
                      <table id="example1" class="table table-bordered table-striped dataTable">
                        <thead>
                        <tr>
                          <th>STT</th>
                          <th>Người gửi</th>
                          <th>Nội dung</th>
                          <th>Ngày tháng</th>
                          <th>Tệp tin</th>
                          <th>UserID</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                          <td>#1</td>
                          <td><strong>{{ $ticket->name }}</strong> <br>{{ $ticket->phone }}<br>{{ $ticket->email }}</td>
                          <td><span style="font-size: 14px">
                              {!! $ticket->message !!}
                            </span>

                          </td>
                          <td>{{ $ticket->created_at}}</td>
                          <td>{{ $ticket->file}}</td>
                          <td>{{ $ticket->user}}</td>
                        </tr>
                        @if(count($replies) > 0)
                        @foreach( $replies as $key => $reply )
                          <tr>
                            <td>#{{$key+2}}</td>
                            <td><strong>{{ $reply->user_name }}</strong> <br>{{ $reply->user_phone }}<br>{{ $reply->user_email }}</td>
                            <td>{{ $reply->reply }}</td>
                            <td>{{ $reply->created_at}}</td>
                            <td>{{ $reply->file}}</td>
                            <td>{{ $reply->user}}</td>
                            </tr>
                        @endforeach
                        @endif
                        </tbody>


                      </table>
                      {!! Form::open(array('route' => 'backend.post.ticket.reply','method'=>'POST','enctype'=>'multipart/form-data')) !!}
                      <div class="row">

                        <div class="col-md-10">
                          <textarea name="reply" size="4" class="form-control" placeholder="Câu trả lời"></textarea>
                          <input name="ticket" value="{{$ticket->id}}" type="hidden">
                        </div>
                        <div class="col-md-2">
                          <button class="btn btn-success" style="padding: 18px">Trả lời</button>
                        </div>

                      </div>
                      {!! Form::close() !!}

                    </div></div>

                </div>
                <!-- /.card-body -->

            </div>
            <!-- /.card -->
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

          </div>
    <!-- /.card -->
    </div>
  <!-- /.col -->
  </div>
<!-- /.row -->
</section>
<!-- /.content -->
@endsection