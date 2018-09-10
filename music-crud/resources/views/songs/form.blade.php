<div class="form-group {{ $errors->has('title') ? 'has-error' : ''}}">
    <label for="title" class="control-label">{{ 'Title' }}</label>
    <input class="form-control" name="title" type="text" id="title" value="{{ $song->title or ''}}" >
    {!! $errors->first('title', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('artist') ? 'has-error' : ''}}">
    <label for="artist" class="control-label">{{ 'Artist' }}</label>
    <input class="form-control" name="artist" type="text" id="artist" value="{{ $song->artist or ''}}" >
    {!! $errors->first('artist', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group">
    <label for="artist" class="control-label">{{ 'Song file (MP3)' }}</label>
    <br />
    {{ Form::file('song') }}
</div>

<div class="form-group">
    <label for="artist" class="control-label">{{ 'Image' }}</label>
    <br />
    {{ Form::file('image') }}
</div>

<div class="form-group">
    <input class="btn btn-primary float-right" type="submit" value="{{ $formMode === 'edit' ? 'Update' : 'Create' }}">
</div>
