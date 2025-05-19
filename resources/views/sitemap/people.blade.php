<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
        xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">
    @foreach ($listings as $listing)
        <url>
            <loc>{{ route('people',$listing->slug) }}</loc>
            <lastmod>{{ gmdate('Y-m-d\TH:i:s\Z', strtotime($listing->updated_at)) }}</lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.50</priority>
        </url>
    @endforeach

</urlset>
