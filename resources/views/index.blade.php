@extends('layouts.app')

@section('title')
    Halaman Post Page
@endsection

@section('body')
    <h1>Halaman Post</h1>
   @if (count($posts)>0)
       <ul>
           @foreach ($posts as $post)
               <a href="{{ route('post.show', $post['id']) }}"><li>{{ $post['title'] }}</li></a>
           @endforeach
       </ul>
   @else
       <p>Tidak ada</p>
   @endif
@endsection
