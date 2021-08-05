{{-- 投稿フォームのview --}}
{!! Form::open(['route' => 'photos.store']) !!}
    <div class="form-group">
        {!! Form::textarea('image_file_name', null, ['class' => 'form-control', 'rows' => '2']) !!}
        {!! Form::submit('Post', ['class' => 'btn btn-primary btn-block']) !!}
    </div>
{!! Form::close() !!}