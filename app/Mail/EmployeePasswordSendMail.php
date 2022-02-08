<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmployeePasswordSendMail extends Mailable
{
    use Queueable, SerializesModels;

    public $employee;
    public $password;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($employee, $password)
    {
        $this->employee = $employee; 
        $this->password = $password;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(env('FROM_EMAIL'))->subject('Your account has been created | '.env('APP_NAME','Test'))->markdown('email.employee_password');
    }
}
