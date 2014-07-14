@extends('master')

@section('content')
<div class="page-header">
    <h2>
        {{$feeling->name}}
        @if(isset($feeling->description))
            <p>{{{$feeling->description}}}</p>
        @endif
    </h2>
</div>
@if (count($feeling->posts()) > 0)

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
            <th>Public Tags</th>
            <th>User</th>
            <td>Last update</td>
            <th>Privacy</th>
            <th>Anonymous</th>
            <th>IP Address</th>
            <th>Status</th>
        </tr>
        </thead>
        <tbody>
        @foreach($feeling->posts() as $post)
        <tr>
            <td>
                {{ link_to_route('posts-page', $post->id, $post->id)}}
                <a href="{{url('sentis/'.$post->id.'/create')}}">
                    <span class="glyphicon glyphicon-heart"></span></a>
            </td>
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
                @foreach ($post->publicTags() as $tag)
                    <p>{{link_to_route('tags-page', $tag->name .' (' .$tag->qtd .') ',  $tag->id)}}</p>
                @endforeach
            </td>
            <td>
                {{link_to_route('profile-user',$post->user->username,  $post->user->username)}}
            </td>
            <td>
                {{ date('d M Y H:i a',strtotime($post->updated_at)) }}
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
    <p>There are no posts created with this feeling.</p>
@endif

@stop