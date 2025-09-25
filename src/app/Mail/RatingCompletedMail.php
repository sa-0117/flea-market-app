<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use App\Models\Listing;

class RatingCompletedMail extends Mailable
{
    public $listing;

    public function __construct(Listing $listing)
    {
        $this->listing = $listing;
    }

    public function build()
    {
        return $this->view('emails.rating-completed');
    }
}
