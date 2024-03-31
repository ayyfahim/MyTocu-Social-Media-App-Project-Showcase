<?php

namespace App\Http\Controllers;

use App\Liste;
use App\Journal;
use App\ContactUsMessage;
use App\Frontend\AboutUs;
use App\Frontend\ContactUs;
use App\Frontend\TeamMember;
use App\Frontend\TermsOfUse;
use Illuminate\Http\Request;
use App\Frontend\FeaturedImage;
use App\Frontend\PrivacyPolicy;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\OpenGraph;
use Illuminate\Database\Eloquent\Builder;

class FrontendController extends Controller
{
    public function baseURL()
    {
        if (!Auth::check()) {
            return redirect()->route('register');
        } else {
            return redirect()->route('user.show', auth()->user()->slug);
        }
    }

    public function termsOfUse()
    {
        SEOMeta::setTitle('Terms of Use');
        $terms = TermsOfUse::all();
        return view('footer.terms-of-use', compact('terms'));
    }

    public function aboutUs()
    {
        SEOMeta::setTitle('About Us');
        SEOMeta::setDescription('Satisfying, simple, clean and fun social network experience without the unnecessary bits. You’ll have a place you can come back to and view all your best experiences.');
        OpenGraph::setTitle('About Us')
            ->setDescription('Satisfying, simple, clean and fun social network experience without the unnecessary bits. You’ll have a place you can come back to and view all your best experiences.');
        $about_us = AboutUs::where('status', '1')->first();
        return view('footer.about-us', compact('about_us'));
    }

    public function privacyPolicy()
    {
        SEOMeta::setTitle('Privacy Policy');
        $policies = PrivacyPolicy::all();
        return view('footer.privacy', compact('policies'));
    }

    public function explore()
    {
        SEOMeta::setTitle('Explore');
        $lists = Liste::whereHas('user', function (Builder $query) {
            $query->where('status', 0);
        })->latest()->with(['likes', 'comments', 'posts', 'comments_limit', 'user'])->paginate(18);
        $lists->withPath(url('render-all-lists'));

        $journals = Journal::whereHas('user', function (Builder $query) {
            $query->where('status', 0);
        })->latest()->with(['likes', 'comments', 'comments_limit', 'user'])->paginate(18);
        $journals->withPath(url('render-all-journals'));

        return view('explore', compact('lists', 'journals'));
    }
}
