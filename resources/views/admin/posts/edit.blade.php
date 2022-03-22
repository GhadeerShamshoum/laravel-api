
@extends('layouts.admin')
@section('content')
<h1 class="text-center">update:{{$post->name}}</h1>
<form action="{{route("admin.posts.update", $post->id)}}" method="POST">
  @csrf
  @method('PUT')
  <div class="form-group col-md-12">
    <label for="title">title</label>
    <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" placeholder="add title" value="{{old("title")??$post->title}}">
    @error('title')
      <div class="alert alert-danger">{{ $message }}</div>
    @enderror
  </div>
  <div class="form-group col-md-12">
    <label for="content">Content</label>
    <textarea rows="5" class="form-control @error('description') is-invalid @enderror" id="content" name="content" placeholder="add a content" >{{$post->content}}</textarea>
    @error('content')
      <div class="alert alert-danger">{{ $message }}</div>
    @enderror
  </div>

  <!-- Category -->
  <div class="form-group">
    <label>Category</label>
    <select class="form-control" name="category_id" id="category_id">
      <option value="">Default select</option>
      @foreach($categories as $category)
      <option value="{{$category->id}}">
        {{ $category->name }}
      </option>
      @endforeach
    </select>
    @error('category_id')
    <div class="invalid-feeback">{{ $message }}</div>
    @enderror
  </div>

  <!-- tags -->
  <div class="from-group">
    <label for="">Tags</label>
    @foreach ($tags as $tag)
    <div class="form-check">
      <input type="checkbox" class="form-check-input" id="{{$tag->slug}}"
      name="tags[]" value="{{$tag->id}}"
      {{ $post->tags->contains($tag) ? "checked" : ""}}>
      <label class="form-check-label" for="{{$tag->slug}}">
        {{$tag->name}}
      </label>  

    </div>
    @endforeach

  </div>

  
  <button type="submit" class="btn btn-primary">
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-save" viewBox="0 0 16 16">
      <path d="M2 1a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H9.5a1 1 0 0 0-1 1v7.293l2.646-2.647a.5.5 0 0 1 .708.708l-3.5 3.5a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L7.5 9.293V2a2 2 0 0 1 2-2H14a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h2.5a.5.5 0 0 1 0 1H2z"/>
    </svg>
    Save</button>
  </form>
@endsection
