<?php

namespace Botble\Gallery\Listeners;

use SiteMapManager;
use Botble\Gallery\Repositories\Interfaces\GalleryInterface;

class RenderingSiteMapListener
{
    protected GalleryInterface $galleryRepository;

    public function __construct(GalleryInterface $galleryRepository)
    {
        $this->galleryRepository = $galleryRepository;
    }

    public function handle(): void
    {
        SiteMapManager::add(route('public.galleries'), '2020-11-15 00:00', '0.8', 'weekly');

        $galleries = $this->galleryRepository->getDataSiteMap();

        foreach ($galleries as $gallery) {
            SiteMapManager::add($gallery->url, $gallery->updated_at, '0.8');
        }
    }
}
