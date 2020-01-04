<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
  <sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <sitemap>
      <loc>{{ url('sitemap/blog') }}</loc>
      <lastmod>{{ $articles->created_at->toAtomString() }}</lastmod>
    </sitemap>
    <sitemap>
      <loc>{{ url('sitemap/dokumen') }}</loc>
      <lastmod>{{ $documents->created_at->toAtomString() }}</lastmod>
    </sitemap>
    <sitemap>
      <loc>{{ url('sitemap/kategori') }}</loc>
      <lastmod>{{ $categories->created_at->toAtomString() }}</lastmod>
    </sitemap>
    <sitemap>
      <loc>{{ url('sitemap/review') }}</loc>
      <lastmod>{{ $reviews->created_at->toAtomString() }}</lastmod>
    </sitemap>
  </sitemapindex>