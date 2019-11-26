<meta http-equiv="content-language" content="{{ $settings['language'] }}">
<meta name="robots" content="@if($seo && $seo->noindex == 1){{'noindex, nofollow'}}@else{{'index, follow'}}@endif">
<meta NAME="geo.position" CONTENT="21.003233; 105.867443">
<meta NAME="geo.placename" CONTENT="{{ $settings['address'] }}">
<meta NAME="geo.region" CONTENT="VN">
<title>@if($seo){{$seo->title}}@endif</title>
<meta name="description" content="@if($seo){{$seo->description}}@endif">

<!-- Schema.org markup for Google+ -->
<meta itemprop="name" content="@if($seo){{$seo->title}}@endif">
<meta itemprop="description" content="@if($seo){{$seo->description}}@endif">
<meta itemprop="image" content="@if($seo){{url($seo->avatar)}}@endif">

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

<!-- Twitter Card data -->
<meta name="twitter:card" content="@if($seo){{url($seo->avatar)}}@endif">
<meta name="twitter:site" content="@nencer">
<meta name="twitter:title" content="@if($seo){{$seo->title}}@endif">
<meta name="twitter:description" content="@if($seo){{$seo->description}}@endif">
<meta name="twitter:creator" content="@tygiavn">
<!-- Twitter summary card with large image must be at least 280x150px -->
<meta name="twitter:image:src" content="@if($seo){{url($seo->avatar)}}@endif">

@if($seo)
    <link rel="alternate" hreflang="vi-vn" href="@if($seo){{url($seo->link)}}@endif">
    <link rel="canonical" href="@if($seo){{url($seo->link)}}@endif">
@endif

<script type='application/ld+json'>
    {
    "@context":"http://schema.org",
    "@type":"WebSite",
    "url":"@if($seo){{url($seo->link)}}@endif",
    "name":"@if($seo){{$seo->title}}@endif"
    }
</script>
<script type="application/ld+json">
    {
    "@context": "http://schema.org",
    "@type": "organization",
    "name": "@if($seo){{$seo->title}}@endif",
    "url": "@if($seo){{url($seo->link)}}@endif",
    "logo": "@if($seo){{url($seo->avatar)}}@endif",
    "contactPoint": {
    "@type": "ContactPoint",
    "telephone": "{{ $settings['phone'] }}",
    "contactType": "customer service",
    "contactOption": "TollFree",
    "areaServed": "VN",
    "availableLanguage": "Vietnamese"
    },
    "sameAs": [
    "{{ $settings['facebook'] }}",
    "{{ $settings['twitter'] }}",
    "{{ $settings['googleplus'] }}"
    ]
    }

</script>
<script type="application/ld+json">
    {
    "@context": "http://schema.org",
    "@type": "Person",
    "name": "Neo Nguyen",
    "jobTitle": "CEO",
    "image":"{{env('APP_URL')}}",
    "url": "{{env('APP_URL')}}",
    "sameAs":[
    "https://www.facebook.com/neonguyen84"
    ],
    "AlumniOf":[ "Hà Nội" ],
    "address": {
    "@type": "PostalAddress",
    "addressLocality": "Ha Noi",
    "addressRegion": "vietnam"
    }}
</script>

