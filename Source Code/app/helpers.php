<?php

use App\Message;
use App\ContactUsMessage;
use Illuminate\Support\Collection;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;

if (!function_exists('unreadMessages')) {
    function unreadMessages()
    {
        return Message::where([
            'receiver_id' => auth()->id()
        ])
            ->whereNull('seen_at')
            ->count();
    }
}

if (!function_exists('unreadContactMessages')) {
    function unreadContactMessages()
    {
        return ContactUsMessage::whereNull('seen_at');
    }
}

if (!function_exists('paginate')) {
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    function paginate($items, $perPage = 5, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }
}

if (!function_exists('linkify')) {
    /**
     * Turn all URLs in clickable links.
     *
     * @param string $value
     * @param array  $protocols  http/https, ftp, mail, twitter
     * @param array  $attributes
     * @return string
     */
    function linkify($value, $protocols = array('http', 'mail'), array $attributes = array())
    {
        // Link attributes
        $attr = '';
        foreach ($attributes as $key => $val) {
            $attr .= ' ' . $key . '="' . htmlentities($val) . '"';
        }

        $links = array();

        // Extract existing links and tags
        $value = preg_replace_callback('~(<a .*?>.*?</a>|<.*?>)~i', function ($match) use (&$links) {
            return '<' . array_push($links, $match[1]) . '>';
        }, $value);

        // Extract text links for each protocol
        foreach ((array) $protocols as $protocol) {
            switch ($protocol) {
                case 'http':
                case 'https':
                    $value = preg_replace_callback('~(?:(https?)://([^\s<]+)|(www\.[^\s<]+?\.[^\s<]+))(?<![\.,:])~i', function ($match) use ($protocol, &$links, $attr) {
                        if ($match[1]) {
                            $protocol = $match[1];
                        }
                        $link = $match[2] ?: $match[3];
                        return '<' . array_push($links, "<a $attr href=\"$protocol://$link\">$link</a>") . '>';
                    }, $value);
                    break;
                case 'mail':
                    $value = preg_replace_callback('~([^\s<]+?@[^\s<]+?\.[^\s<]+)(?<![\.,:])~', function ($match) use (&$links, $attr) {
                        return '<' . array_push($links, "<a $attr href=\"mailto:{$match[1]}\">{$match[1]}</a>") . '>';
                    }, $value);
                    break;
                case 'twitter':
                    $value = preg_replace_callback('~(?<!\w)[@#](\w++)~', function ($match) use (&$links, $attr) {
                        return '<' . array_push($links, "<a $attr href=\"https://twitter.com/" . ($match[0][0] == '@' ? '' : 'search/%23') . $match[1]  . "\">{$match[0]}</a>") . '>';
                    }, $value);
                    break;
                default:
                    $value = preg_replace_callback('~' . preg_quote($protocol, '~') . '://([^\s<]+?)(?<![\.,:])~i', function ($match) use ($protocol, &$links, $attr) {
                        return '<' . array_push($links, "<a $attr href=\"$protocol://{$match[1]}\">{$match[1]}</a>") . '>';
                    }, $value);
                    break;
            }
        }

        // Insert all link
        return preg_replace_callback('/<(\d+)>/', function ($match) use (&$links) {
            return $links[$match[1] - 1];
        }, $value);
    }
}

if (!function_exists('days')) {
    function days()
    {
        for ($i = 1; $i <= 31; $i++) {
            $days[] = $i;
        }

        return $days;
    }
}

if (!function_exists('months')) {
    function months()
    {
        $months = array(
            1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April', 5 => 'May', 6 => 'Jun',
            7 => 'July', 8 => 'August', 9 => 'September', 10 => 'October', 11 => 'November',
            12 => 'December'
        );

        return $months;
    }
}

if (!function_exists('years')) {
    function years()
    {
        for ($i = 1972; $i <= now()->year; $i++) {
            $year[] = $i;
        }

        return $year;
    }
}
