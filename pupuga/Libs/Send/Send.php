<?php

namespace Pupuga\Libs\Send;

class Send
{
    public $parameters = array();

    public function __construct($to, $subject, $message, $from = '', $attachment = '')
    {
        $this
            ->setToMail($to)
            ->setSubjectMail($subject)
            ->setMessageMail($message)
            ->setHeadersMail($from);
    }

    public function mail()
    {
        $result = array();
        foreach ($this->parameters['to'] as $to) {
            $result[] = wp_mail($to, $this->parameters['subject'], $this->parameters['message'], $this->parameters['headers'], $this->parameters['attachments']);
        }

        return $result;
    }

    /**
     * @return $this
     */
    public function setToMail($to)
    {
        $this->parameters['to'][] = $to;

        return $this;
    }

    /**
     * @return $this
     */
    public function setSubjectMail($subject)
    {
        $this->parameters['subject'] = $subject;

        return $this;
    }

    /**
     * @return $this
     */
    public function setMessageMail($message)
    {
        $this->parameters['message'] = $message;

        return $this;
    }

    /**
     * @return $this
     */
    public function setHeadersMail($from)
    {
        remove_all_filters( 'wp_mail_from' );
        remove_all_filters( 'wp_mail_from_name' );
        $headers = array();

        if ($from == '') {
            $from = get_bloginfo('admin_email');
        }
        $headers[] = 'From: ' . get_bloginfo('name') .' <' . $from . '>';
        $headers[] = 'content-type: text/html';
        $this->parameters['headers'] = $headers;

        return $this;
    }

}