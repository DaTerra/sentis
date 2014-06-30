@extends('master')
@section('header')
<h2>
    Posts with the Tag: {{$tag->name}}
</h2>
@stop

@section('content')
@if (count($tag->posts) > 0)

    <table class="table table-striped">
        <thead>
        <tr>
            <th>#</th>
            <th>Title</th>
            <th>Content</th>
            <th>Source</th>
            <th>Media Type</th>
            <th>Media URL</th>
            <th>Tags</th>
            <th>User</th>
            <th>Privacy</th>
            <th>Anonymous</th>
            <th>IP Address</th>
            <th>Status</th>
        </tr>
        </thead>
        <tbody>
        @foreach($tag->posts as $post)
        <tr>
            <td>{{ link_to_route('posts-page', $post->id, $post->id)}}</td>
            <td>{{{$post->postContent['title']}}}</td>
            <td>{{{$post->postContent['content']}}}</td>
            <td>{{{$post->postContent['source_url']}}}</td>
            <td>{{{$post->postContent['media']['type']}}}</td>
            <td>
                <img style="width:30%;" src="{{{$post->postContent['media_url']}}}"/>
            </td>
            <td>
                @foreach ($post->tags as $tag)
                    <p>{{link_to_route('tags-page', $tag->name,  $tag->id)}}</p>
                @endforeach
            </td>
            <td>
                {{link_to_route('profile-user',$post->user->username,  $post->user->username)}}
            </td>
            <td>{{{$post->privacy->name}}}</td>
            <td>{{{$post->anonymous}}}</td>
            <td>{{{$post->user_ip_address}}}</td>
            <td>{{{$post->status}}}</td>
        </tr>
        @endforeach
        </tbody>
    </table>
@else
    <p>There are no posts created to this tag.</p>
@endif

@stop