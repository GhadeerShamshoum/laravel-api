@extends('layouts.admin')

@section('content')
<h1 class="text-center">title:{{$post->title}}</h1>
<h5 class="mt-3 mb-3">content:{{$post->content}}</h5>
<h5 class="mt-3 mb-3">Slug:{{$post->slug}}</h5>
@if($post->image)
    <img style="width:400px" src="{{ asset("storage/{$post->image}")}}" alt="{{$post->title}}">
@endif
<br>

@foreach ($post->tags as $tag)
    {{$tag->name}}
@endforeach
<br>


<a href="{{route("admin.posts.index")}}"><button type="button" class="btn btn-primary my-5">back</button></a>
    

 
@endsection