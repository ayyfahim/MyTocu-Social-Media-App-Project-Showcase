<?php

namespace App\Http\Controllers\Admin;

use App\Liste;
use App\Journal;
use Carbon\Carbon;
use App\Charts\ChartJs;
use App\ContactUsMessage;
use App\Frontend\AboutUs;
use App\Frontend\ContactUs;
use App\Frontend\TeamMember;
use App\Frontend\TermsOfUse;
use Illuminate\Http\Request;
use App\Charts\SevenDaysPosts;
use App\Frontend\FeaturedImage;
use App\Frontend\PrivacyPolicy;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /** Todays Date */
        $today_date = Carbon::now()->format('Y-m-d');

        /** Creating from, to array Date */
        $dt = Carbon::create(1975, 12, 25, 22, 0, 0);
        $dt->toTimeString();
        for ($i = 0; $i < 12; $i++) {
            $from[] = $dt->addHours(2)->format('H:i:s');
        }

        $dt = Carbon::create(1975, 12, 25, 0, 0, 0);
        $dt->toTimeString();
        for ($i = 0; $i < 12; $i++) {
            $to[] = $dt->addHours(2)->format('H:i:s');
        }

        /** Creating Label, Lists, Journals for today */
        for ($i = 0; $i < 12; $i++) {
            $time[] = $from[$i] . " - " . $to[$i];
            $lists_today[] = Liste::whereBetween('created_at', [$today_date . ' ' . $from[$i], $today_date . ' ' . $to[$i]])->count();
            $journals_today[] = Journal::whereBetween('created_at', [$today_date . ' ' . $from[$i], $today_date . ' ' . $to[$i]])->count();
        }
        $list_today = new ChartJs;
        $list_today->labels($time);
        $list_today->dataset('Lists', 'bar', $lists_today)->options([
            'backgroundColor' => [
                '#4433FF',
                '#00D660',
                '#FF1F1F',
                '#FF8E24',
                '#060606',
                '#F5E2E3',
                '#566FA9'
            ]
        ]);
        $journal_today = new ChartJs;
        $journal_today->labels($time);
        $journal_today->dataset('Journals', 'bar', $journals_today)->options([
            'backgroundColor' => [
                '#4433FF',
                '#00D660',
                '#FF1F1F',
                '#FF8E24',
                '#060606',
                '#F5E2E3',
                '#566FA9'
            ]
        ]);


        /** Creating labels, journals and lists for past 7 days */
        for ($i = 1; $i < 7; $i++) {
            $date[] = Carbon::now()->subDays(7 - $i)->format('d-m-Y');
            $lists_7_days[] = Liste::whereDate('created_at', Carbon::now()->subDays(7 - $i)->format('Y-m-d'))->count();
            $journals_7_days[] = Journal::whereDate('created_at', Carbon::now()->subDays(7 - $i)->format('Y-m-d'))->count();
        }
        $list_7_days = new ChartJs;
        $list_7_days->labels($date);
        $list_7_days->dataset('Lists', 'bar', $lists_7_days)->options([
            'backgroundColor' => [
                '#4433FF',
                '#00D660',
                '#FF1F1F',
                '#FF8E24',
                '#060606',
                '#F5E2E3',
                '#566FA9'
            ]
        ]);
        $journal_7_days = new ChartJs;
        $journal_7_days->labels($date);
        $journal_7_days->dataset('Journals', 'bar', $journals_7_days)->options([
            'backgroundColor' => [
                '#4433FF',
                '#00D660',
                '#FF1F1F',
                '#FF8E24',
                '#060606',
                '#F5E2E3',
                '#566FA9'
            ]
        ]);

        return view('dashboard.index', ['list_7_days' => $list_7_days, 'journal_7_days' => $journal_7_days, 'list_today' => $list_today, 'journal_today' => $journal_today]);
    }
}
