<?php

namespace App\Services;

use App\User;
use Illuminate\Contracts\Mail\Mailer;

class AppMailer
{

    protected $appName;

    protected $subject;
    /**
     * The Laravel Mailer instance.
     *
     * @var Mailer
     */
    protected $mailer;
    /**
     * The sender of the email.
     *
     * @var string
     */
    protected $from = 'vahid@timenix.com';
    /**
     * The recipient of the email.
     *
     * @var string
     */
    protected $to;
    /**
     * The view for the email.
     *
     * @var string
     */
    protected $view;
    /**
     * The data associated with the view for the email.
     *
     * @var array
     */
    protected $data = [];

    /**
     * Create a new app mailer instance.
     *
     * @param Mailer $mailer
     */
    public function __construct(Mailer $mailer)
    {
        $this->appName = config('app.name', 'Timenix');
        $this->mailer = $mailer;
    }

    public function sendContactUsFrom(array $user)
    {
        $this->from = $user['email'];
        $this->to = 'timenixhq@gmail.com';
        $this->subject = 'Contact Us - ' . $user['email'];
        $this->view = 'emails.contactUs';
        $this->data = $user;
        $this->send();
    }

    public function sendWelcomeTo(User $user)
    {
        $this->to = $user->email;
        $this->view = 'emails.welcome';
        $this->subject = $this->appName . ' - Welcome! ';
        $this->data = $user->toArray();
        $this->send();
    }

    public function sendConfirmMailTo(User $user)
    {
        $this->to = $user->email;
        $this->view = 'emails.confirm';
        $this->subject = $this->appName . ' - Contact Us';
        $this->data = $user->toArray();
        $this->send();
    }

    /**
     * Deliver the email.
     *
     * @return void
     */
    public function send()
    {
        $to = $this->to;
        $from = $this->from;
        $name = $this->appName;
        $subject = $this->subject;
        $user = $this->data;
        $this->data = compact('user');
        return $this->mailer->send($this->view, $this->data, function ($message) use ($to, $from, $subject, $name) {
            $message->replyTo($from, $name);
            $message->to($to)->from($from, $name)->subject($subject);
        });
    }
}