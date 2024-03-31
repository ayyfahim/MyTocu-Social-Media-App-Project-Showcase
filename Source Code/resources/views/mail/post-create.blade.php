@component('mail::message')
# Hello {{ $friend->name }}

{{$post->user->name}} has created a post titled: <b>{{ $post->title }}</b>

<div style="margin: 30px auto; text-align: center">
    <a style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto,
    Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; -webkit-text-size-adjust: none; border-radius: 4px; color: #fff; display: inline-block;
    overflow: hidden; text-decoration: none; background-color: #2d3748; border-bottom: 8px solid
    #2d3748; border-left: 18px solid #2d3748; border-right: 18px solid #2d3748; border-top: 8px solid
    #2d3748;" target="_blank" href="{{ $url }}">Click to see the List</a>
    <a style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto,
    Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; -webkit-text-size-adjust: none; border-radius: 4px; color: #fff; display: inline-block;
    overflow: hidden; text-decoration: none; background-color: #2d3748; border-bottom: 8px solid
    #2d3748; border-left: 18px solid #2d3748; border-right: 18px solid #2d3748; border-top: 8px solid
    #2d3748;" target="_blank" href="{{ route('login') }}">Login to Mytocu</a>
</div>

Thanks,<br>
{{ config('app.name') }}
@endcomponent
