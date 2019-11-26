<meta http-equiv="Content-Type" content="text/html" charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
<meta http-equiv="content-language" content="{{ $settings['language'] }}">
<meta name="robots" content="noindex, nofollow">
<title>@if($seo){{$seo->title}}@endif</title>
<meta name="description" content="@if($seo){{$seo->description}}@endif">
<!-- Open Graph data -->
<meta property="og:title" content="@if($seo){{$seo->description}}@endif">
<meta property="og:type" content="article">
<meta property="og:url" content="@if($seo){{url($seo->link)}}@endif"/>
<meta property="og:image" content="@if($seo){{url($seo->avatar)}}@endif">
<meta property="og:description" content="@if($seo){{$seo->description}}@endif">
<meta property="og:site_name" content="@if($seo){{$seo->title}}@endif">
<meta property="article:published_time" content="{{date('d-m-Y')}}T18:05:18+05:00">
<meta property="article:modified_time" content="{{date('d-m-Y')}}T18:30:19+01:00">
<meta property="article:section" content="@if($seo){{$seo->description}}@endif">
<meta property="article:tag" content="@if($seo){{$seo->title}}@endif">
<meta property="fb:admins" content="788105437921828">
@if($seo)
    <link rel="canonical" href="@if($seo){{url($seo->link)}}@endif">
@endif

