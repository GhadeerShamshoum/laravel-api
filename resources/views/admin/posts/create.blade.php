@extends('layouts.admin')

@section('content')
<h1 class="text-center">add Post </h1>
<form action="{{route("admin.posts.store")}}" method="POST" enctype="multipart/form-data">
  @csrf
  <div class="form-group col-md-12">
    <label for="title">title</label>
    <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" placeholder="add title" value="{{old("title")}}">
    @error('title')
      <div class="alert alert-danger">{{ $message }}</div>
    @enderror
  </div>
  <div class="form-group col-md-12">
    <label for="content">Content</label>
    <textarea rows="5" class="form-control @error('content') is-invalid @enderror" id="content" name="content" placeholder="add a content">{{old("content")}}</textarea>
    @error('content')
      <div class="alert alert-danger">{{ $message }}</div>
    @enderror
  </div>
  <!-- upload an image -->
  <div class="form-group">
    <label for="">Image</label>
    <input type="file" name="image"
    class="form-control @error('image') is-invalid @enderror">
    @error('image')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>
 
  <!-- Categories -->
  <div class="form-group">
    <label for="">Category</label>
    <select class="form-control" name="category_id">
      <option value="">Default select</option>
      @foreach($categories as $category)
        <option value="{{$category->id}}"
        {{$category->id}}>
        {{ $category->name }}
      </option>
      @endforeach
    </select>
    @error('category_id')
    <div class="invalid-feeback">{{ $message }}</div>
    @enderror
  </div>


  <!-- the post's tag -->
  <div class="form-group">
    <label>Tags</label>
    @foreach ($tags as $tag)
      <div class="form-check">
        <input class="form-check-input" type="checkbox" name="tags[]" id="{{$tag->slug}}"
        value="{{$tag->id}}">
        <label class="form-check-label" for="{{$tag->slug}}">
          {{$tag->name}}
        </label>  
      </div>
    @endforeach
  </div>

 
  
  <button type="submit" class="btn btn-primary">Add</button>
</form>

 
@endsection
