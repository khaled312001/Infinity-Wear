@php
$xmlDeclaration = '<' . '?xml version="1.0" encoding="UTF-8"?' . '>';
echo $xmlDeclaration . PHP_EOL;
@endphp
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
@foreach($urls as $url)
    <url>
        <loc>{{ $url['url'] }}</loc>
        <lastmod>{{ date('Y-m-d') }}</lastmod>
        <changefreq>weekly</changefreq>
        <priority>{{ $url['priority'] }}</priority>
    </url>
@endforeach
</urlset>