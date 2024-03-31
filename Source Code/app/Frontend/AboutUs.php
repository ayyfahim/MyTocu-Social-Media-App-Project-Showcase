<?php

namespace App\Frontend;

use Illuminate\Database\Eloquent\Model;

use Te7aHoudini\LaravelTrix\Traits\HasTrixRichText;

class AboutUs extends Model
{
    use HasTrixRichText;

    protected $guarded = [];
}
