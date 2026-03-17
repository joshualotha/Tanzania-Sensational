<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TrekkingRoute;
use App\Models\SafariPackage;
use App\Models\Destination;
use App\Models\BlogPost;
use App\Models\Booking;
use Illuminate\Http\Request;

class StatsController extends Controller
{
    public function index()
    {
        return response()->json([
            'trekking_routes_count' => TrekkingRoute::count(),
            'safari_packages_count' => SafariPackage::count(),
            'destinations_count' => Destination::count(),
            'blog_posts_count' => BlogPost::count(),
            'total_bookings' => Booking::count(),
            'contact_submissions' => \App\Models\ContactSubmission::count(),
            'recent_bookings' => Booking::with(['departure.trekkingRoute', 'safariPackage'])->latest()->take(5)->get()
        ]);
    }
}
