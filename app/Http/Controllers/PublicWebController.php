<?php

namespace App\Http\Controllers;


use App\Models\AboutUsDynamic;
use App\Models\Category;
use App\Models\ExpertProfile;
use App\Models\Faqs;
use App\Models\FaqsHeading;
use App\Models\Home2Dynamic;
use App\Models\HomeDynamic;
use App\Models\TeacherGig;
use App\Models\TermPrivacy;
use App\Models\ServiceReviews;
use App\Models\User;
use Illuminate\Http\Request;

class PublicWebController extends Controller
{


    public function Index()
    {
        $home = HomeDynamic::first();
        $home2 = Home2Dynamic::first();
        $categories = Category::where('status', 1) // Only active categories
        ->select('category')  // Select only the category field
        ->distinct()          // Ensure unique category names
        ->get();
        for ($i = 1; $i <= 8; $i++) {
            $field = 'expert_link_' . $i;
            $ids = explode('/', $home->$field);
            if (!empty($ids[1])) {
                ${'gig_' . $i} = TeacherGig::query()
                    ->withAvg('all_reviews', 'rating')
                    ->where(['id' => $ids[1], 'status' => 1])
                    ->first();

                if (${'gig_' . $i}) {
                    ${'profile_' . $i} = ExpertProfile::where([
                        'user_id' => ${'gig_' . $i}->user_id,
                        'status' => 1
                    ])->first();
                } else {
                    ${'gig_' . $i} = null;
                    ${'profile_' . $i} = null;
                }
            } else {
                ${'gig_' . $i} = null;
                ${'profile_' . $i} = null;
            }
        }

        // Get top 10 highest rated reviews from service_reviews table
        $topReviews = ServiceReviews::with(['user', 'teacher', 'gig'])
            ->whereNull('parent_id') // Only parent reviews, not replies
            ->orderBy('rating', 'desc')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return view("Public-site.index", compact(
            'home',
            'home2',
            'categories',
            'gig_1',
            'gig_2',
            'gig_3',
            'gig_4',
            'gig_5',
            'gig_6',
            'gig_7',
            'gig_8',
            'profile_1',
            'profile_2',
            'profile_3',
            'profile_4',
            'profile_5',
            'profile_6',
            'profile_7',
            'profile_8',
            'topReviews'
        ));
    }


    public function AboutUs()
    {
        $about = AboutUsDynamic::first();
        return view("Public-site.about-us", compact('about'));
    }


    public function ContactUs()
    {
        return view("Public-site.contact-us");
    }


    public function ExpertFaqs()
    {

        $faqs_heading = FaqsHeading::where(['type' => 'seller'])->get();
        $faqs = Faqs::where(['type' => 'seller'])->get();

        return view("Public-site.expert", compact('faqs', 'faqs_heading'));
    }


    public function BuyerFaqs()
    {

        $faqs_heading = FaqsHeading::where(['type' => 'buyer'])->get();
        $faqs = Faqs::where(['type' => 'buyer'])->get();

        return view("Public-site.buyer", compact('faqs', 'faqs_heading'));
    }


    public function FaqInfo($id)
    {

        $faq = Faqs::find($id);

        return view("Public-site.faq-info", compact('faq'));
    }


    public function Privacy()
    {

        $privacy = TermPrivacy::where(['type' => 'privacy'])->get();

        return view("Public-site.privacy", compact('privacy'));
    }


    public function Services()
    {
        return view("Public-site.services");
    }


    public function TearmCondition()
    {

        $term = TermPrivacy::where(['type' => 'term'])->get();

        return view("Public-site.term-condition", compact('term'));
    }


}
