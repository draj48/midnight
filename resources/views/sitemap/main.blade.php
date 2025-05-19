<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
        xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">
    @foreach(config('menus') as $menu)
        @if($menu->route)
        <url>
            <loc>{{ route($menu->route) }}</loc>
            <lastmod>{{ gmdate('Y-m-d\TH:i:s\Z', strtotime(date('Y-m-d H:i:s'))) }}</lastmod>
            <changefreq>daily</changefreq>
            <priority>0.9</priority>
        </url>
        @endif
    @endforeach

</urlset>
