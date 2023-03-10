<?php

namespace Database\Seeders;

use Botble\Base\Models\MetaBox as MetaBoxModel;
use Botble\Base\Supports\BaseSeeder;
use Botble\Language\Models\LanguageMeta;
use Botble\Page\Models\Page;
use Botble\Slug\Models\Slug;
use Html;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use SlugHelper;

class PageSeeder extends BaseSeeder
{
    public function run(): void
    {
        Page::truncate();
        DB::table('pages_translations')->truncate();
        Slug::where('reference_type', Page::class)->delete();
        MetaBoxModel::where('reference_type', Page::class)->delete();
        LanguageMeta::where('reference_type', Page::class)->delete();

        $pages = [
            [
                'name' => 'Homepage',
                'content' =>
                    Html::tag('div', '[featured-posts][/featured-posts]') .
                    Html::tag('div', '[recent-posts title="What\'s new?"][/recent-posts]') .
                    Html::tag('div', '[featured-categories-posts title="Best for you" category_id="2"][/featured-categories-posts]') .
                    Html::tag('div', '[all-galleries limit="8"][/all-galleries]')
                ,
                'template' => 'no-sidebar',
            ],
            [
                'name' => 'Blog',
                'content' => '---',
                'template' => 'default',
            ],
            [
                'name' => 'Contact',
                'content' => Html::tag(
                    'p',
                    'Address: North Link Building, 10 Admiralty Street, 757695 Singapore'
                ) .
                    Html::tag('p', 'Hotline: 18006268') .
                    Html::tag('p', 'Email: contact@botble.com') .
                    Html::tag(
                        'p',
                        '[google-map]North Link Building, 10 Admiralty Street, 757695 Singapore[/google-map]'
                    ) .
                    Html::tag('p', 'For the fastest reply, please use the contact form below.') .
                    Html::tag('p', '[contact-form][/contact-form]'),
                'template' => 'default',
            ],
            [
                'name' => 'Cookie Policy',
                'content' => Html::tag('h3', 'EU Cookie Consent') .
                    Html::tag(
                        'p',
                        'To use this website we are using Cookies and collecting some Data. To be compliant with the EU GDPR we give you to choose if you allow us to use certain Cookies and to collect some Data.'
                    ) .
                    Html::tag('h4', 'Essential Data') .
                    Html::tag(
                        'p',
                        'The Essential Data is needed to run the Site you are visiting technically. You can not deactivate them.'
                    ) .
                    Html::tag(
                        'p',
                        '- Session Cookie: PHP uses a Cookie to identify user sessions. Without this Cookie the Website is not working.'
                    ) .
                    Html::tag(
                        'p',
                        '- XSRF-Token Cookie: Laravel automatically generates a CSRF "token" for each active user session managed by the application. This token is used to verify that the authenticated user is the one actually making the requests to the application.'
                    ),
                'template' => 'default',
            ],
        ];

        foreach ($pages as $item) {
            $item['user_id'] = 1;
            $page = Page::create($item);

            Slug::create([
                'reference_type' => Page::class,
                'reference_id' => $page->id,
                'key' => Str::slug($page->name),
                'prefix' => SlugHelper::getPrefix(Page::class),
            ]);
        }

        $translations = [
            [
                'name' => 'Trang ch???',
                'content' =>
                    Html::tag('div', '[featured-posts][/featured-posts]') .
                    Html::tag('div', '[recent-posts title="C?? g?? m???i?"][/recent-posts]') .
                    Html::tag(
                        'div',
                        '[featured-categories-posts title="T???t nh???t cho b???n" category_id="2"][/featured-categories-posts]'
                    ) .
                    Html::tag('div', '[all-galleries limit="8"][/all-galleries]')
                ,
            ],
            [
                'name' => 'Tin t???c',
                'content' => '---',
            ],
            [
                'name' => 'Li??n h???',
                'content' => Html::tag(
                    'p',
                    '?????a ch???: North Link Building, 10 Admiralty Street, 757695 Singapore'
                ) .
                    Html::tag('p', '???????ng d??y n??ng: 18006268') .
                    Html::tag('p', 'Email: contact@botble.com') .
                    Html::tag(
                        'p',
                        '[google-map]North Link Building, 10 Admiralty Street, 757695 Singapore[/google-map]'
                    ) .
                    Html::tag('p', '????? ???????c tr??? l???i nhanh nh???t, vui l??ng s??? d???ng bi???u m???u li??n h??? b??n d?????i.') .
                    Html::tag('p', '[contact-form][/contact-form]'),
            ],
            [
                'name' => 'Cookie Policy',
                'content' => Html::tag('h3', 'EU Cookie Consent') .
                    Html::tag(
                        'p',
                        '????? s??? d???ng trang web n??y, ch??ng t??i ??ang s??? d???ng Cookie v?? thu th???p m???t s??? D??? li???u. ????? tu??n th??? GDPR c???a Li??n minh Ch??u ??u, ch??ng t??i cho b???n l???a ch???n n???u b???n cho ph??p ch??ng t??i s??? d???ng m???t s??? Cookie nh???t ?????nh v?? thu th???p m???t s??? D??? li???u.'
                    ) .
                    Html::tag('h4', 'D??? li???u c???n thi???t') .
                    Html::tag(
                        'p',
                        'D??? li???u c???n thi???t l?? c???n thi???t ????? ch???y Trang web b???n ??ang truy c???p v??? m???t k??? thu???t. B???n kh??ng th??? h???y k??ch ho???t ch??ng.'
                    ) .
                    Html::tag(
                        'p',
                        '- Session Cookie: PHP s??? d???ng Cookie ????? x??c ?????nh phi??n c???a ng?????i d??ng. N???u kh??ng c?? Cookie n??y, trang web s??? kh??ng ho???t ?????ng.'
                    ) .
                    Html::tag(
                        'p',
                        '- XSRF-Token Cookie: Laravel t??? ?????ng t???o "token" CSRF cho m???i phi??n ng?????i d??ng ??ang ho???t ?????ng do ???ng d???ng qu???n l??. Token n??y ???????c s??? d???ng ????? x??c minh r???ng ng?????i d??ng ???? x??c th???c l?? ng?????i th???c s??? ????a ra y??u c???u ?????i v???i ???ng d???ng.'
                    ),
            ],
        ];

        foreach ($translations as $index => $item) {
            $item['lang_code'] = 'vi';
            $item['pages_id'] = $index + 1;

            DB::table('pages_translations')->insert($item);
        }
    }
}
