<sitemapindex xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
              xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/siteindex.xsd">

    <sitemap>
        <loc>{{route('sitemap.main')}}</loc>
        <lastmod>{{date("Y-m-d")."T".date("H:i:s")}}+03:00</lastmod>
    </sitemap>
    @for ($post=1; $post <=ceil($listings['post']/config('attr.sitemap')); $post++)
        <sitemap>
            <loc>{{route('sitemap.post',$post)}}</loc>
            <lastmod>{{date("Y-m-d")."T".date("H:i:s")}}+03:00</lastmod>
        </sitemap>
    @endfor

    @for ($episode=1; $episode <=ceil($listings['episode']/config('attr.sitemap')); $episode++)
        <sitemap>
            <loc>{{route('sitemap.episode',$episode)}}</loc>
            <lastmod>{{date("Y-m-d")."T".date("H:i:s")}}+03:00</lastmod>
        </sitemap>
    @endfor

        @for ($people=1; $people <=ceil($listings['episode']/config('attr.sitemap')); $people++)
            <sitemap>
                <loc>{{route('sitemap.people',$people)}}</loc>
                <lastmod>{{date("Y-m-d")."T".date("H:i:s")}}+03:00</lastmod>
            </sitemap>
        @endfor


    @for ($genre=1; $genre <=ceil($listings['post']/config('attr.sitemap')); $genre++)
        <sitemap>
            <loc>{{route('sitemap.genre',$genre)}}</loc>
            <lastmod>{{date("Y-m-d")."T".date("H:i:s")}}+03:00</lastmod>
        </sitemap>
    @endfor
</sitemapindex>
